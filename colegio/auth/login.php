<?php

require_once __DIR__ . "/comun.php";
require_once __DIR__ . "/conexion.php";

cabecerasSinCache();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . paginaLogin(null)["publica"]);
    exit();
}

$pagina = paginaLogin($_POST["origen"] ?? null);

// Paso 1: el modal se acaba de abrir. El servidor anota la hora para que el limite de 30 segundos
// no dependa solo del contador del navegador.
if (($_POST["accion"] ?? "") === "abrir") {
    $_SESSION["login_abierto_en"] = time();
    http_response_code(204);
    exit();
}

// Cada apertura del modal permite un unico intento
$abiertoEn = (int) ($_SESSION["login_abierto_en"] ?? 0);
unset($_SESSION["login_abierto_en"]);
$enTiempo = $abiertoEn > 0 && (time() - $abiertoEn) <= TIEMPO_LOGIN_SEGUNDOS + 3;

$usuario = $_POST["usuario"] ?? "";
$contrasena = $_POST["contrasena"] ?? "";
$autenticado = false;

if ($enTiempo && is_string($usuario) && is_string($contrasena)) {
    $usuario = trim($usuario);

    if ($usuario !== "" && $contrasena !== "" && mb_strlen($usuario) <= 150) {
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
}

if ($autenticado) {
    header("Location: " . $pagina["panel"]);
    exit();
}

// Login fallido o fuera de tiempo: se borra la sesión, las cookies y la cache, y se vuelve a la página de origen
usleep(400000);
cerrarSesionYVolver($pagina["publica"] . ($enTiempo ? "?login=error" : ""));
exit();
