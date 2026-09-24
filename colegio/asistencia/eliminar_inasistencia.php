<?php

// Borra TODOS los registros de la tabla `inasistencia`, confirmando la accion
// con un usuario de la tabla `super_usuario` (no la tabla `usuarios` normal).
// Usa el mismo mecanismo de seguridad que auth/login.php: el modal avisa al
// servidor cuando se abre y el envio solo se acepta dentro de esa ventana de
// tiempo, ademas de la verificacion de contraseña con password_verify().

require_once __DIR__ . "/../auth/sesion.php";
require_once __DIR__ . "/conexion.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Ya se debe estar dentro del panel de asistencia; el super_usuario es una
// segunda confirmacion, no un reemplazo de esta sesion.
if (empty($_SESSION["usuario_id"])) {
    header("Location: ../inicio/index.php");
    exit();
}

const TIEMPO_ELIMINAR_SEGUNDOS = 30;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ./inasistencia.php");
    exit();
}

$accion = $_POST["accion"] ?? "";

// Paso 1: el modal se acaba de abrir. Se anota la hora para que el limite de
// 30 segundos no dependa solo del contador del navegador.
if ($accion === "abrir") {
    $_SESSION["eliminar_inasistencia_abierto_en"] = time();
    http_response_code(204);
    exit();
}

// Cada apertura del modal permite un unico intento
$abiertoEn = (int) ($_SESSION["eliminar_inasistencia_abierto_en"] ?? 0);
unset($_SESSION["eliminar_inasistencia_abierto_en"]);
$enTiempo = $abiertoEn > 0 && (time() - $abiertoEn) <= TIEMPO_ELIMINAR_SEGUNDOS + 3;

$usuario = $_POST["usuario"] ?? "";
$contrasena = $_POST["contrasena"] ?? "";
$autenticado = false;

if ($enTiempo && is_string($usuario) && is_string($contrasena)) {
    $usuario = trim($usuario);

    if ($usuario !== "" && $contrasena !== "" && mb_strlen($usuario) <= 150) {
        // Consulta preparada contra `super_usuario` (no `usuarios`)
        $stmt = $mysqli->prepare("SELECT id_super_usuario, password FROM super_usuario WHERE usuario = ? LIMIT 1");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $fila = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($fila) {
            $hashGuardado = $fila["password"];
            $esHashSeguro = password_get_info($hashGuardado)["algo"] !== null;

            if ($esHashSeguro && password_verify($contrasena, $hashGuardado)) {
                $autenticado = true;
            } elseif (!$esHashSeguro && hash_equals($hashGuardado, $contrasena)) {
                // Migra automáticamente contraseñas heredadas en texto plano a un hash bcrypt
                $nuevoHash = password_hash($contrasena, PASSWORD_DEFAULT);
                $actualizar = $mysqli->prepare("UPDATE super_usuario SET password = ? WHERE id_super_usuario = ?");
                $actualizar->bind_param("si", $nuevoHash, $fila["id_super_usuario"]);
                $actualizar->execute();
                $actualizar->close();
                $autenticado = true;
            }
        }
    }
}

if ($autenticado) {
    try {
        $mysqli->query("DELETE FROM inasistencia");
        header("Location: ./inasistencia.php?eliminado=1");
    } catch (mysqli_sql_exception $error) {
        error_log("Error al eliminar inasistencia: " . $error->getMessage());
        header("Location: ./inasistencia.php?eliminar_error=1");
    }
    exit();
}

// Credenciales invalidas o tiempo agotado: mismo retraso deliberado que el login principal
usleep(400000);
header("Location: ./inasistencia.php?eliminar_error=1");
exit();
