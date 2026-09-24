<?php

// Endpoint AJAX: busca un estudiante en la tabla `asistencia` por documento
// para precargar el modal de "Registrar inasistencia".

require_once __DIR__ . "/../auth/sesion.php";
require_once __DIR__ . "/conexion.php";

header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

if (empty($_SESSION["usuario_id"])) {
    http_response_code(401);
    echo json_encode(["encontrado" => false, "error" => "Debes iniciar sesión."]);
    exit();
}

$documento = preg_replace('/\D+/', '', trim($_GET["documento"] ?? ""));

if ($documento === "") {
    echo json_encode(["encontrado" => false, "error" => "Escribe un número de documento."]);
    exit();
}

$documentoInt = (int) $documento;
$stmt = $mysqli->prepare(
    "SELECT nombre_asistencia, grado_asistencia, jornada_asistencia FROM asistencia WHERE documento_asistencia = ?"
);
$stmt->bind_param("i", $documentoInt);
$stmt->execute();
$estudiante = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$estudiante) {
    echo json_encode(["encontrado" => false, "error" => "No se encontró ningún estudiante con ese documento en la tabla de asistencia."]);
    exit();
}

echo json_encode([
    "encontrado" => true,
    "nombre"     => $estudiante["nombre_asistencia"],
    "grado"      => $estudiante["grado_asistencia"],
    "jornada"    => $estudiante["jornada_asistencia"],
]);
