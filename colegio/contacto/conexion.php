<?php

// Conexion por procedimientos orientado a objetos (mysqli)

// Con PHP 8.1+ mysqli lanza excepciones: se fuerza este modo para que un fallo se capture aqui y no se muestre al visitante
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $mysqli = new mysqli("localhost", "root", "", "eugenio_pagina_web");
    $mysqli->set_charset("utf8mb4");
} catch (mysqli_sql_exception $error) {
    // El detalle va al registro del servidor, no a la pantalla del visitante
    error_log("Conexión fallida: " . $error->getMessage());
    http_response_code(500);
    die("No se pudo conectar con la base de datos.");
}
