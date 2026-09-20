<?php

// Conexion por procedimientos orientado a objetos (mysqli)

$mysqli = new mysqli("localhost", "root", "", "eugenio_pagina_web");

if ($mysqli->connect_error) {
    // El detalle va al registro del servidor, no a la pantalla del visitante
    error_log("Conexión fallida: " . $mysqli->connect_error);
    http_response_code(500);
    die("No se pudo conectar con la base de datos.");
}

$mysqli->set_charset("utf8");
