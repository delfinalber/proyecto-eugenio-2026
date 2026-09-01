<?php

require_once __DIR__ . "/sesion.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $parametrosCookie = session_get_cookie_params();
    setcookie(
        session_name(),
        "",
        time() - 42000,
        $parametrosCookie["path"],
        $parametrosCookie["domain"],
        $parametrosCookie["secure"],
        $parametrosCookie["httponly"]
    );
}

session_destroy();

// Indica al navegador que borre cache y cookies de este origen al cerrar sesión
header('Clear-Site-Data: "cache", "cookies", "storage"');
header("Location: ./index.php");
exit();
