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

$filtro = filtrarInasistencia($mysqli, $_GET);
$registros = $filtro["registros"];
$filtroGrado = $filtro["grado"];
$filtroJornada = $filtro["jornada"];
$filtroTexto = $filtro["buscar"];
$gradosValidos = $filtro["gradosValidos"];
$jornadasValidas = $filtro["jornadasValidas"];

$totalGeneral = (int) $mysqli->query("SELECT COUNT(*) AS total FROM inasistencia")->fetch_assoc()["total"];

// Los mismos filtros activos se reenvian al reporte de impresion
$queryImprimir = http_build_query(array_filter(
    ["grado" => $filtroGrado, "jornada" => $filtroJornada, "buscar" => $filtroTexto],
    fn($valor) => $valor !== ""
));

function texto(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inasistencias | Eugenio Ferro Falla</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Nunito+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./asistencia.css">
    <link rel="stylesheet" href="./cuadricula.css">
    <link rel="icon" href="./img_asistencia/logo.jpeg" type="image/x-icon">
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
              <li><a class="dropdown-item active" aria-current="page" href="./inasistencia.php">Inasistencia</a></li>
              <li><a class="dropdown-item" href="./dashboard.php">Dashboard</a></li>
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
      <h1>Inasistencias</h1>
      <p>Consulta los registros almacenados en la tabla <strong>inasistencia</strong> de la base de datos <strong>eugenio_pagina_web</strong>. Puedes buscar por documento o nombre, filtrar por grado y jornada, e imprimir el resultado en PDF.</p>
    </div>
<!--Fin encabezado del editor-->

    <!--Inicio tarjeta de contenido-->
    <div class="editor-content-card p-4 mb-4">
      <div class="editor-section-title mb-3">Registros de inasistencia</div>

      <!--Inicio filtros-->
      <form method="get" class="row g-2 align-items-end mb-3">
        <div class="col-6 col-md-3">
          <label class="form-label login-label" for="filtro-grado">Grado</label>
          <select class="form-select login-input" id="filtro-grado" name="grado">
            <option value="">Todos</option>
            <?php foreach ($gradosValidos as $codigo): ?>
              <option value="<?= $codigo ?>" <?= $filtroGrado === $codigo ? "selected" : "" ?>><?= $codigo ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-6 col-md-3">
          <label class="form-label login-label" for="filtro-jornada">Jornada</label>
          <select class="form-select login-input" id="filtro-jornada" name="jornada">
            <option value="">Todas</option>
            <?php foreach ($jornadasValidas as $jornadaOpcion): ?>
              <option value="<?= $jornadaOpcion ?>" <?= $filtroJornada === $jornadaOpcion ? "selected" : "" ?>><?= $jornadaOpcion ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-12 col-md-3">
          <label class="form-label login-label" for="filtro-buscar">Buscar (nombre o documento)</label>
          <input type="text" class="form-control login-input" id="filtro-buscar" name="buscar" value="<?= texto($filtroTexto) ?>">
        </div>
        <div class="col-12 col-md-3 d-flex flex-wrap gap-2">
          <button type="submit" class="btn login-submit-btn flex-fill">Filtrar</button>
          <a href="./inasistencia.php" class="btn btn-outline-light flex-fill">Limpiar</a>
          <a href="./inasistencia_imprimir.php<?= $queryImprimir !== "" ? "?$queryImprimir" : "" ?>" target="_blank" class="btn login-submit-btn flex-fill">
            <i class="fa-solid fa-print"></i> Imprimir
          </a>
        </div>
      </form>
      <!--Fin filtros-->

      <p class="resumen-asistencia">Mostrando <?= count($registros) ?> de <?= $totalGeneral ?> registros.</p>

      <?php if ($registros === []): ?>
        <!--Inicio estado vacio-->
        <div class="editor-empty-card">
          <p class="mb-0">No se encontraron registros con los filtros seleccionados.</p>
        </div>
        <!--Fin estado vacio-->
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-borderless tabla-asistencia align-middle mb-0">
            <thead>
              <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Grado</th>
                <th>Jornada</th>
                <th>Fecha registrada</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($registros as $registro): ?>
                <tr>
                  <td><?= texto((string) $registro["documento_inasistencia"]) ?></td>
                  <td><?= texto($registro["nombre_inasistencia"]) ?></td>
                  <td><?= texto((string) $registro["telefono_inasistencia"]) ?></td>
                  <td><?= texto($registro["grado_inasistencia"]) ?></td>
                  <td><?= texto($registro["jornada_inasistencia"]) ?></td>
                  <td><?= texto(date("d/m/Y H:i", strtotime($registro["fecha_inasistencia"]))) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
    <!--Fin tarjeta de contenido-->
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
</body>
</html>
