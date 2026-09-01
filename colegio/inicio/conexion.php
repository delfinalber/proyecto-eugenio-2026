<?php

// Conexion por procedimientos orientado a objetos (mysqli)

$mysqli = new mysqli("localhost", "root", "", "eugenio_pagina_web");

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8");
