<?php

require_once __DIR__ . "/../auth/sesion.php";
require_once __DIR__ . "/conexion.php";
require_once __DIR__ . "/inasistencia_datos.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (empty($_SESSION["usuario_id"])) {
    header("Location: ../inicio/index.php");
    exit();
}

// Codigos de grado admitidos: 601-603, 701-703, ..., 1101-1103
$gradosValidos = [];
for ($g = 6; $g <= 11; $g++) {
    for ($s = 1; $s <= 3; $s++) {
        $gradosValidos[] = $g . "0" . $s;
    }
}

$jornadasValidas = ["Mañana", "Tarde"];

// Conteo por grado y jornada (se inicializa en 0 para mostrar siempre los 18 grados)
$conteoPorGrado = array_fill_keys($gradosValidos, ["Mañana" => 0, "Tarde" => 0]);

$resultado = $mysqli->query(
    "SELECT grado_asistencia, jornada_asistencia, COUNT(*) AS total
     FROM asistencia
     GROUP BY grado_asistencia, jornada_asistencia"
);
while ($fila = $resultado->fetch_assoc()) {
    $grado = $fila["grado_asistencia"];
    $jornada = $fila["jornada_asistencia"];
    if (isset($conteoPorGrado[$grado]) && in_array($jornada, $jornadasValidas, true)) {
        $conteoPorGrado[$grado][$jornada] += (int) $fila["total"];
    }
}

// Totales por grado general (6 a 11), sumando sus tres secciones
$totalesPorGradoBase = array_fill_keys(range(6, 11), 0);
foreach ($conteoPorGrado as $grado => $jornadas) {
    $base = intdiv((int) $grado, 100);
    if (isset($totalesPorGradoBase[$base])) {
        $totalesPorGradoBase[$base] += array_sum($jornadas);
    }
}

$totalGeneral = array_sum(array_map("array_sum", $conteoPorGrado));
$totalManana = array_sum(array_column($conteoPorGrado, "Mañana"));
$totalTarde = array_sum(array_column($conteoPorGrado, "Tarde"));
$maximoPorGradoBase = max(1, max($totalesPorGradoBase));

// Filtros de la seccion de inasistencias (grado, jornada y rango de fechas).
// Estos filtros son independientes de los de arriba (asistencia) y controlan
// las tarjetas, la tabla y los tres graficos de esta seccion.
$filtroInasistencia = filtrarInasistencia($mysqli, $_GET);
$registrosInasistencia = $filtroInasistencia["registros"];
$filtroGradoInasistencia = $filtroInasistencia["grado"];
$filtroJornadaInasistencia = $filtroInasistencia["jornada"];
$filtroFechaDesde = $filtroInasistencia["fechaDesde"];
$filtroFechaHasta = $filtroInasistencia["fechaHasta"];

// Conteo de inasistencias por grado y jornada, y por estudiante, a partir de
// los registros ya filtrados (asi las tarjetas, la tabla y los graficos
// siempre coinciden con el mismo filtro).
$conteoInasistenciaPorGrado = array_fill_keys($gradosValidos, ["Mañana" => 0, "Tarde" => 0]);
$conteoPorEstudiante = [];

foreach ($registrosInasistencia as $registro) {
    $grado = $registro["grado_inasistencia"];
    $jornada = $registro["jornada_inasistencia"];
    if (isset($conteoInasistenciaPorGrado[$grado]) && in_array($jornada, $jornadasValidas, true)) {
        $conteoInasistenciaPorGrado[$grado][$jornada]++;
    }

    $documento = (string) $registro["documento_inasistencia"];
    if (!isset($conteoPorEstudiante[$documento])) {
        $conteoPorEstudiante[$documento] = [
            "nombre"  => $registro["nombre_inasistencia"],
            "grado"   => $grado,
            "jornada" => $jornada,
            "total"   => 0,
        ];
    }
    $conteoPorEstudiante[$documento]["total"]++;
}

// Grados ordenados de mayor a menor numero de inasistencias (para el grafico de ranking)
$conteoInasistenciaOrdenado = $conteoInasistenciaPorGrado;
uasort($conteoInasistenciaOrdenado, fn($a, $b) => array_sum($b) <=> array_sum($a));

// Top 10 estudiantes con mas inasistencias, segun los filtros activos
$rankingEstudiantes = array_values($conteoPorEstudiante);
usort($rankingEstudiantes, fn($a, $b) => $b["total"] <=> $a["total"]);
$topEstudiantes = array_slice($rankingEstudiantes, 0, 10);

$totalInasistencias = array_sum(array_map("array_sum", $conteoInasistenciaPorGrado));
$totalInasistenciaManana = array_sum(array_column($conteoInasistenciaPorGrado, "Mañana"));
$totalInasistenciaTarde = array_sum(array_column($conteoInasistenciaPorGrado, "Tarde"));
$porcentajeInasistencia = $totalGeneral > 0 ? round($totalInasistencias / $totalGeneral * 100, 1) : 0;

if ($totalInasistencias === 0) {
    $jornadaConMasInasistencias = "";
} elseif ($totalInasistenciaManana === $totalInasistenciaTarde) {
    $jornadaConMasInasistencias = "Mañana y Tarde (empatadas)";
} else {
    $jornadaConMasInasistencias = $totalInasistenciaManana > $totalInasistenciaTarde ? "Mañana" : "Tarde";
}

// Datos para los graficos (Chart.js), ya listos como arreglos simples
$datosChartJornada = [
    "labels"  => ["Mañana", "Tarde"],
    "valores" => [$totalInasistenciaManana, $totalInasistenciaTarde],
];

$datosChartGrado = [
    "labels" => array_keys($conteoInasistenciaOrdenado),
    "manana" => array_column($conteoInasistenciaOrdenado, "Mañana"),
    "tarde"  => array_column($conteoInasistenciaOrdenado, "Tarde"),
];

$datosChartEstudiantes = [
    "labels"  => array_map(
        fn($estudiante) => $estudiante["nombre"] . " (" . $estudiante["grado"] . " · " . $estudiante["jornada"] . ")",
        $topEstudiantes
    ),
    "valores" => array_map(fn($estudiante) => $estudiante["total"], $topEstudiantes),
];

function texto(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, "UTF-8");
}

// Serializa a JSON de forma segura para incrustar dentro de un <script>
function jsonSeguro($valor): string
{
    return json_encode($valor, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Asistencia | Eugenio Ferro Falla</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Nunito+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./asistencia.css">
    <link rel="stylesheet" href="./cuadricula.css">
    <link rel="icon" href="../inicio/img-ini/logo.jpeg" type="image/x-icon">
</head>
<body>

<!--Inicio Banner-->
  <div class="container-fluid text-center px-0">
    <div class="row g-0 align-items-stretch hero-row">
      <div class="col-12">
        <div class="hero-banner-card">
          <img src="../inicio/img-ini/banner.png" class="banner" alt="Banner principal">
        </div>
      </div>
    </div>
  </div>
<!--Fin Banner-->

  <br>

<!--Inicio Nav-->
  <nav class="navbar navbar-expand-lg nav-banner w-100">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">I.E. Eugenio Ferro Falla</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="../inicio/index-formulario.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../eventos/eventos-formulario.php">Eventos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../contacto/contacto-formulario.php">Contacto</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-current="page">Asistencia</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="./asistencia.php">Asistencia</a></li>
              <li><a class="dropdown-item" href="./inasistencia.php">Inasistencia</a></li>
              <li><a class="dropdown-item active" aria-current="page" href="./dashboard.php">Dashboard</a></li>
            </ul>
          </li>
        </ul>

        <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">Cerrar Sesión</button>
      </div>
    </div>
  </nav>
<!--Fin Nav-->

  <br>

  <div class="container">
<!--Inicio encabezado del editor-->
    <div class="editor-header-card mb-4">
      <h1>Dashboard - Asistencia</h1>
      <p>Resumen de los registros almacenados en la tabla <strong>asistencia</strong> de la base de datos <strong>eugenio_pagina_web</strong>, por grado y por jornada.</p>
    </div>
<!--Fin encabezado del editor-->

    <!--Inicio tarjetas de estadisticas-->
    <div class="row gy-4 mb-4">
      <div class="col-12 col-md-4">
        <div class="stat-card">
          <div class="stat-valor"><?= $totalGeneral ?></div>
          <div class="stat-etiqueta">Total de registros</div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="stat-card">
          <div class="stat-valor"><?= $totalManana ?></div>
          <div class="stat-etiqueta">Jornada mañana</div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="stat-card">
          <div class="stat-valor"><?= $totalTarde ?></div>
          <div class="stat-etiqueta">Jornada tarde</div>
        </div>
      </div>
    </div>
    <!--Fin tarjetas de estadisticas-->

    <!--Inicio filtros de inasistencia-->
    <div class="editor-content-card p-4 mb-4">
      <div class="editor-section-title mb-3">Inasistencias — filtros</div>
      <form method="get" class="row g-2 align-items-end">
        <div class="col-6 col-md-2">
          <label class="form-label login-label" for="dash-grado">Grado</label>
          <select class="form-select login-input" id="dash-grado" name="grado">
            <option value="">Todos</option>
            <?php foreach ($gradosValidos as $codigo): ?>
              <option value="<?= $codigo ?>" <?= $filtroGradoInasistencia === $codigo ? "selected" : "" ?>><?= $codigo ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-6 col-md-2">
          <label class="form-label login-label" for="dash-jornada">Jornada</label>
          <select class="form-select login-input" id="dash-jornada" name="jornada">
            <option value="">Todas</option>
            <?php foreach ($jornadasValidas as $jornadaOpcion): ?>
              <option value="<?= $jornadaOpcion ?>" <?= $filtroJornadaInasistencia === $jornadaOpcion ? "selected" : "" ?>><?= $jornadaOpcion ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-6 col-md-3">
          <label class="form-label login-label" for="dash-fecha-desde">Desde</label>
          <input type="date" class="form-control login-input" id="dash-fecha-desde" name="fecha_desde" value="<?= texto($filtroFechaDesde) ?>">
        </div>
        <div class="col-6 col-md-3">
          <label class="form-label login-label" for="dash-fecha-hasta">Hasta</label>
          <input type="date" class="form-control login-input" id="dash-fecha-hasta" name="fecha_hasta" value="<?= texto($filtroFechaHasta) ?>">
        </div>
        <div class="col-12 col-md-2 d-flex gap-2">
          <button type="submit" class="btn login-submit-btn flex-fill">Filtrar</button>
          <a href="./dashboard.php" class="btn btn-outline-light flex-fill">Limpiar</a>
        </div>
      </form>
      <p class="resumen-asistencia mt-3 mb-0">Estos filtros controlan las tarjetas, los gráficos y la tabla de inasistencias de aquí abajo.</p>
    </div>
    <!--Fin filtros de inasistencia-->

    <!--Inicio tarjetas de inasistencia-->
    <div class="row gy-4 mb-4">
      <div class="col-12 col-md-4">
        <div class="stat-card stat-card--alerta">
          <div class="stat-valor"><?= $totalInasistencias ?></div>
          <div class="stat-etiqueta">Total inasistencias</div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="stat-card stat-card--alerta">
          <div class="stat-valor"><?= $totalInasistenciaManana ?></div>
          <div class="stat-etiqueta">Inasistencia mañana</div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="stat-card stat-card--alerta">
          <div class="stat-valor"><?= $totalInasistenciaTarde ?></div>
          <div class="stat-etiqueta">Inasistencia tarde</div>
        </div>
      </div>
    </div>
    <!--Fin tarjetas de inasistencia-->

    <!--Inicio grafico por grado-->
    <div class="editor-content-card p-4 mb-4">
      <div class="editor-section-title">Estudiantes por grado</div>
      <?php foreach ($totalesPorGradoBase as $gradoBase => $total): ?>
        <div class="barra-grado">
          <div class="barra-etiqueta">Grado <?= $gradoBase ?>°</div>
          <div class="barra-pista">
            <div class="barra-relleno" style="width: <?= (int) round($total / $maximoPorGradoBase * 100) ?>%;"></div>
          </div>
          <div class="barra-valor"><?= $total ?></div>
        </div>
      <?php endforeach; ?>
    </div>
    <!--Fin grafico por grado-->

    <!--Inicio tabla detallada-->
    <div class="editor-content-card p-4 mb-4">
      <div class="editor-section-title">Detalle por grado y jornada</div>
      <div class="table-responsive">
        <table class="table table-borderless tabla-asistencia align-middle mb-0">
          <thead>
            <tr>
              <th>Grado</th>
              <th>Mañana</th>
              <th>Tarde</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($conteoPorGrado as $grado => $jornadas): ?>
              <tr>
                <td><?= texto($grado) ?></td>
                <td><?= $jornadas["Mañana"] ?></td>
                <td><?= $jornadas["Tarde"] ?></td>
                <td><strong><?= array_sum($jornadas) ?></strong></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td><strong>Total</strong></td>
              <td><strong><?= $totalManana ?></strong></td>
              <td><strong><?= $totalTarde ?></strong></td>
              <td><strong><?= $totalGeneral ?></strong></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <!--Fin tabla detallada-->

    <!--Inicio tabla de inasistencias-->
    <div class="editor-content-card p-4 mb-4">
      <div class="editor-section-title">Detalle de inasistencias por grado y jornada</div>
      <div class="table-responsive">
        <table class="table table-borderless tabla-asistencia align-middle mb-0">
          <thead>
            <tr>
              <th>Grado</th>
              <th>Mañana</th>
              <th>Tarde</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($conteoInasistenciaPorGrado as $grado => $jornadas): ?>
              <tr>
                <td><?= texto($grado) ?></td>
                <td><?= $jornadas["Mañana"] ?></td>
                <td><?= $jornadas["Tarde"] ?></td>
                <td><strong><?= array_sum($jornadas) ?></strong></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td><strong>Total</strong></td>
              <td><strong><?= $totalInasistenciaManana ?></strong></td>
              <td><strong><?= $totalInasistenciaTarde ?></strong></td>
              <td><strong><?= $totalInasistencias ?></strong></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <p class="resumen-asistencia mt-3 mb-0">Tasa de inasistencia: <?= $porcentajeInasistencia ?>% del total de estudiantes registrados.</p>
    </div>
    <!--Fin tabla de inasistencias-->

    <!--Inicio grafico jornada con mas inasistencias-->
    <div class="editor-content-card p-4 mb-4">
      <div class="editor-section-title">¿Qué jornada tiene más inasistencias?</div>
      <?php if ($totalInasistencias > 0): ?>
        <p class="resumen-asistencia">La jornada con más inasistencias es <strong><?= texto($jornadaConMasInasistencias) ?></strong> (<?= $totalInasistenciaManana ?> en la mañana frente a <?= $totalInasistenciaTarde ?> en la tarde).</p>
      <?php else: ?>
        <p class="resumen-asistencia">No hay inasistencias registradas con los filtros seleccionados.</p>
      <?php endif; ?>
      <div class="grafico-envoltorio">
        <canvas id="graficoJornada" aria-label="Comparación de inasistencias entre la jornada mañana y la jornada tarde"></canvas>
      </div>
    </div>
    <!--Fin grafico jornada con mas inasistencias-->

    <!--Inicio grafico grado con mas inasistencias-->
    <div class="editor-content-card p-4 mb-4">
      <div class="editor-section-title">¿Qué grado tiene más inasistencias?</div>
      <p class="resumen-asistencia">Grados ordenados de mayor a menor número de inasistencias; el color de cada barra indica la jornada (dorado = mañana, azul = tarde).</p>
      <div class="grafico-envoltorio grafico-envoltorio--alto">
        <canvas id="graficoGrado" aria-label="Inasistencias por grado, separadas por jornada mañana y tarde"></canvas>
      </div>
    </div>
    <!--Fin grafico grado con mas inasistencias-->

    <!--Inicio grafico estudiantes con mas inasistencias-->
    <div class="editor-content-card p-4 mb-4">
      <div class="editor-section-title">Estudiantes con más inasistencias</div>
      <p class="resumen-asistencia">Los estudiantes con más inasistencias según los filtros activos; entre paréntesis se indica su grado y su jornada.</p>
      <?php if ($topEstudiantes === []): ?>
        <div class="editor-empty-card">
          <p class="mb-0">No hay estudiantes para mostrar con los filtros seleccionados.</p>
        </div>
      <?php else: ?>
        <div class="grafico-envoltorio grafico-envoltorio--alto">
          <canvas id="graficoEstudiantes" aria-label="Estudiantes con más inasistencias, con su grado y jornada"></canvas>
        </div>
      <?php endif; ?>
    </div>
    <!--Fin grafico estudiantes con mas inasistencias-->
  </div>

  <br>

<!--Inicio Footer-->
  <footer class="site-footer">
    <div class="container footer-main">
      <div class="row gy-4">
        <div class="col-12 col-md-6 col-lg-3">
          <h5 class="footer-title">Blog de Jose Facchin</h5>
          <ul class="footer-list">
            <li><a href="#">Blog</a></li>
            <li><a href="#">Autores invitados</a></li>
          </ul>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <h5 class="footer-title">JF Digital</h5>
          <ul class="footer-list">
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Contacto</a></li>
          </ul>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <h5 class="footer-title">Informacion</h5>
          <ul class="footer-list">
            <li><a href="#">Plan de Social Media</a></li>
            <li><a href="#">Plan de Marketing Digital</a></li>
            <li><a href="#">Marketing de Contenidos</a></li>
          </ul>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <h5 class="footer-title">Mi comunidad</h5>
          <div class="social-links">
            <a href="#" aria-label="Facebook">f</a>
            <a href="#" aria-label="Twitter">t</a>
            <a href="#" aria-label="Instagram">ig</a>
            <a href="#" aria-label="LinkedIn">in</a>
            <a href="#" aria-label="YouTube">yt</a>
            <a href="#" aria-label="Pinterest">p</a>
            <a href="#" aria-label="RSS">rss</a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>Copyright 2026 - I.E. Eugenio Ferro Falla | Politica de Privacidad</p>
      </div>
    </div>
  </footer>
<!--Fin Footer-->

<!--Inicio modal cerrar sesion-->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content login-modal">
        <div class="modal-header login-modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Cerrar sesión</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body text-center">
          <p class="mb-0">¿Seguro que deseas cerrar la sesión?</p>
        </div>
        <div class="modal-footer" style="border-top: 1px solid rgba(185, 227, 240, 0.6); justify-content: center;">
          <button type="button" class="btn" data-bs-dismiss="modal" style="color: #f5f9fb;">Cancelar</button>
          <form method="post" action="../auth/logout.php">
            <input type="hidden" name="origen" value="inicio">
            <button type="submit" class="btn login-submit-btn">Cerrar sesión</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<!--Fin modal cerrar sesion-->

  <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
  <script src="../auth/panel.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.1/chart.umd.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    (function () {
      "use strict";

      if (typeof Chart === "undefined") {
        return;
      }

      // Misma paleta del sitio (dorado = mañana, azul = tarde), pensada para
      // leerse bien sobre el fondo verde oscuro de las tarjetas del dashboard.
      var colorManana = "#b28818";
      var colorTarde = "#2f9bc7";
      var colorTexto = "#f5f9fb";
      var colorTextoSecundario = "#b9e3f0";
      var colorGrilla = "rgba(185, 227, 240, 0.18)";

      Chart.defaults.color = colorTextoSecundario;
      Chart.defaults.font.family = "'Nunito Sans', 'Segoe UI', sans-serif";

      var datosJornada = <?= jsonSeguro($datosChartJornada) ?>;
      var datosGrado = <?= jsonSeguro($datosChartGrado) ?>;
      var datosEstudiantes = <?= jsonSeguro($datosChartEstudiantes) ?>;

      var canvasJornada = document.getElementById("graficoJornada");
      if (canvasJornada) {
        new Chart(canvasJornada, {
          type: "bar",
          data: {
            labels: datosJornada.labels,
            datasets: [{
              label: "Inasistencias",
              data: datosJornada.valores,
              backgroundColor: [colorManana, colorTarde],
              borderRadius: 6,
              maxBarThickness: 70
            }]
          },
          options: {
            indexAxis: "y",
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: { callbacks: { label: function (contexto) { return " " + contexto.parsed.x + " inasistencias"; } } }
            },
            scales: {
              x: { beginAtZero: true, ticks: { precision: 0, color: colorTextoSecundario }, grid: { color: colorGrilla } },
              y: { ticks: { color: colorTexto, font: { weight: "700" } }, grid: { display: false } }
            }
          }
        });
      }

      var canvasGrado = document.getElementById("graficoGrado");
      if (canvasGrado) {
        new Chart(canvasGrado, {
          type: "bar",
          data: {
            labels: datosGrado.labels,
            datasets: [
              { label: "Mañana", data: datosGrado.manana, backgroundColor: colorManana, borderRadius: 4, maxBarThickness: 22 },
              { label: "Tarde", data: datosGrado.tarde, backgroundColor: colorTarde, borderRadius: 4, maxBarThickness: 22 }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { labels: { color: colorTexto } }
            },
            scales: {
              x: { ticks: { color: colorTextoSecundario }, grid: { display: false } },
              y: { beginAtZero: true, ticks: { precision: 0, color: colorTextoSecundario }, grid: { color: colorGrilla } }
            }
          }
        });
      }

      var canvasEstudiantes = document.getElementById("graficoEstudiantes");
      if (canvasEstudiantes) {
        new Chart(canvasEstudiantes, {
          type: "bar",
          data: {
            labels: datosEstudiantes.labels,
            datasets: [{
              label: "Inasistencias",
              data: datosEstudiantes.valores,
              backgroundColor: colorManana,
              borderRadius: 4,
              maxBarThickness: 22
            }]
          },
          options: {
            indexAxis: "y",
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false }
            },
            scales: {
              x: { beginAtZero: true, ticks: { precision: 0, color: colorTextoSecundario }, grid: { color: colorGrilla } },
              y: { ticks: { color: colorTexto }, grid: { display: false } }
            }
          }
        });
      }
    })();
  </script>
</body>
</html>
