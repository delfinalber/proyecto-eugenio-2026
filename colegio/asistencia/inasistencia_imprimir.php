<?php

// Reporte imprimible (PDF via "Imprimir" del navegador) de la tabla `inasistencia`,
// respetando los mismos filtros de grado/jornada/busqueda que inasistencia.php.

require_once __DIR__ . "/../auth/sesion.php";
require_once __DIR__ . "/conexion.php";
require_once __DIR__ . "/inasistencia_datos.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (empty($_SESSION["usuario_id"])) {
    header("Location: ../inicio/index.php");
    exit();
}

$filtro = filtrarInasistencia($mysqli, $_GET);
$registros = $filtro["registros"];
$filtroGrado = $filtro["grado"];
$filtroJornada = $filtro["jornada"];
$filtroTexto = $filtro["buscar"];

$fechaImpresion = date("d/m/Y H:i");

function texto(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, "UTF-8");
}

$descripcionFiltro = [];
if ($filtroGrado !== "") {
    $descripcionFiltro[] = "Grado: " . $filtroGrado;
}
if ($filtroJornada !== "") {
    $descripcionFiltro[] = "Jornada: " . $filtroJornada;
}
if ($filtroTexto !== "") {
    $descripcionFiltro[] = "Búsqueda: \"" . $filtroTexto . "\"";
}
$descripcionFiltroTexto = $descripcionFiltro !== [] ? implode("  ·  ", $descripcionFiltro) : "Todos los registros";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de inasistencias | Eugenio Ferro Falla</title>
    <link rel="stylesheet" href="./inasistencia_imprimir.css">
    <link rel="icon" href="./img_asistencia/logo.jpeg" type="image/x-icon">
</head>
<body>

  <div class="barra-acciones">
    <button type="button" class="boton-imprimir" onclick="window.print()">
      Imprimir / Guardar como PDF
    </button>
  </div>

  <div class="hoja">
    <header class="encabezado">
      <img src="./img_asistencia/logo.jpeg" alt="Logo institucional" class="logo">
      <div class="datos-institucion">
        <h1>Institución Educativa Eugenio Ferro Falla</h1>
        <p class="subtitulo">Campoalegre, Huila, Colombia</p>
        <p>Reporte de inasistencias</p>
      </div>
    </header>

    <hr class="linea-separadora">

    <div class="meta-reporte">
      <p><strong>Filtros aplicados:</strong> <?= texto($descripcionFiltroTexto) ?></p>
      <p><strong>Fecha de impresión:</strong> <?= texto($fechaImpresion) ?></p>
      <p><strong>Total de registros:</strong> <?= count($registros) ?></p>
    </div>

    <table class="tabla-reporte">
      <thead>
        <tr>
          <th>#</th>
          <th>Documento</th>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Grado</th>
          <th>Jornada</th>
          <th>Fecha registrada</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($registros === []): ?>
          <tr>
            <td colspan="7" class="sin-datos">No hay registros de inasistencia con los filtros seleccionados.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($registros as $indice => $registro): ?>
            <tr>
              <td><?= $indice + 1 ?></td>
              <td><?= texto((string) $registro["documento_inasistencia"]) ?></td>
              <td><?= texto($registro["nombre_inasistencia"]) ?></td>
              <td><?= texto((string) $registro["telefono_inasistencia"]) ?></td>
              <td><?= texto($registro["grado_inasistencia"]) ?></td>
              <td><?= texto($registro["jornada_inasistencia"]) ?></td>
              <td><?= texto(date("d/m/Y H:i", strtotime($registro["fecha_inasistencia"]))) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <p class="pie-reporte">Documento generado automáticamente el <?= texto($fechaImpresion) ?> desde el panel de asistencia de la Institución Educativa Eugenio Ferro Falla.</p>
  </div>

  <script>
    window.addEventListener("load", function () {
      window.print();
    });
  </script>
</body>
</html>
