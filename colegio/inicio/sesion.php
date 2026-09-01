<?php

// Arranque de sesion seguro compartido por index.php, login.php, logout.php e index-formulario.php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        "lifetime" => 0,
        "path"     => "/",
        "secure"   => !empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off",
        "httponly" => true,
        "samesite" => "Lax",
    ]);
    ini_set("session.use_strict_mode", "1");
    session_start();
}
