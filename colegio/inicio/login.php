<?php

require_once __DIR__ . "/sesion.php";
require_once __DIR__ . "/conexion.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ./index.php");
    exit();
}

$usuario = trim($_POST["usuario"] ?? "");
$contrasena = (string) ($_POST["contrasena"] ?? "");
$autenticado = false;

if ($usuario !== "" && $contrasena !== "") {
    // Consulta preparada: el usuario nunca se concatena directamente en el SQL
    $stmt = $mysqli->prepare("SELECT id_users, contrasena_users FROM usuarios WHERE usuario_users = ? LIMIT 1");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $fila = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($fila) {
        $hashGuardado = $fila["contrasena_users"];
        $esHashSeguro = password_get_info($hashGuardado)["algo"] !== null;

        if ($esHashSeguro && password_verify($contrasena, $hashGuardado)) {
            $autenticado = true;
        } elseif (!$esHashSeguro && hash_equals($hashGuardado, $contrasena)) {
            // Migra automáticamente contraseñas heredadas en texto plano a un hash bcrypt
            $nuevoHash = password_hash($contrasena, PASSWORD_DEFAULT);
            $actualizar = $mysqli->prepare("UPDATE usuarios SET contrasena_users = ? WHERE id_users = ?");
            $actualizar->bind_param("si", $nuevoHash, $fila["id_users"]);
            $actualizar->execute();
            $actualizar->close();
            $autenticado = true;
        }

        if ($autenticado) {
            session_regenerate_id(true);
            $_SESSION["usuario_id"] = (int) $fila["id_users"];
            $_SESSION["usuario_nombre"] = $usuario;
            $_SESSION["usuario_login_time"] = time();
        }
    }
}

if ($autenticado) {
    header("Location: ./index-formulario.php");
    exit();
}

$_SESSION["login_error"] = true;
header("Location: ./index.php");
exit();
