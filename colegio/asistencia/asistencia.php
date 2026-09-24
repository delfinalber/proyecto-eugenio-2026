<?php

require_once __DIR__ . "/../auth/sesion.php";
require_once __DIR__ . "/conexion.php";

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

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST["accion"] ?? "";

    if ($accion === "guardar" || $accion === "editar") {
        try {
            $documento = trim($_POST["documento_asistencia"] ?? "");
            $nombre = trim($_POST["nombre_asistencia"] ?? "");
            $grado = trim($_POST["grado_asistencia"] ?? "");
            $jornada = trim($_POST["jornada_asistencia"] ?? "");
            $telefono = trim($_POST["telefino_asistencia"] ?? "");

            if ($documento === "" || !ctype_digit($documento) || (int) $documento <= 0) {
                throw new RuntimeException("El documento debe ser un número válido.");
            }
            if ($nombre === "" || mb_strlen($nombre) > 100) {
                throw new RuntimeException("El nombre es obligatorio (máximo 100 caracteres).");
            }
            if (!in_array($grado, $gradosValidos, true)) {
                throw new RuntimeException("Selecciona un grado válido.");
            }
            if (!in_array($jornada, $jornadasValidas, true)) {
                throw new RuntimeException("Selecciona una jornada válida.");
            }
            if ($telefono === "" || !ctype_digit($telefono) || strlen($telefono) < 7 || strlen($telefono) > 14) {
                throw new RuntimeException("El teléfono debe tener entre 7 y 14 dígitos.");
            }

            $documento = (int) $documento;
            $telefono = (int) $telefono;

            if ($accion === "guardar") {
                $stmt = $mysqli->prepare(
                    "INSERT INTO asistencia (documento_asistencia, nombre_asistencia, grado_asistencia, jornada_asistencia, telefino_asistencia)
                     VALUES (?, ?, ?, ?, ?)"
                );
                $stmt->bind_param("isssi", $documento, $nombre, $grado, $jornada, $telefono);
                $stmt->execute();
                $stmt->close();
                $mensaje = "El registro de asistencia se creó correctamente.";
            } else {
                $id_asistencia = (int) ($_POST["id_asistencia"] ?? 0);
                $stmt = $mysqli->prepare(
                    "UPDATE asistencia SET documento_asistencia = ?, nombre_asistencia = ?, grado_asistencia = ?, jornada_asistencia = ?, telefino_asistencia = ?
                     WHERE id_asistencia = ?"
                );
                $stmt->bind_param("isssii", $documento, $nombre, $grado, $jornada, $telefono, $id_asistencia);
                $stmt->execute();
                $stmt->close();
                $mensaje = "El registro de asistencia se actualizó correctamente.";
            }
        } catch (mysqli_sql_exception $error) {
            $mensaje = $error->getCode() === 1062
                ? "Ya existe un registro de asistencia con ese número de documento."
                : "No se pudo guardar el registro de asistencia.";
        } catch (RuntimeException $error) {
            $mensaje = $error->getMessage();
        }
    } elseif ($accion === "eliminar") {
        $id_asistencia = (int) ($_POST["id_asistencia"] ?? 0);
        $stmt = $mysqli->prepare("DELETE FROM asistencia WHERE id_asistencia = ?");
        $stmt->bind_param("i", $id_asistencia);
        $stmt->execute();
        $stmt->close();
        $mensaje = "El registro de asistencia se eliminó correctamente.";
    } elseif ($accion === "registrar_inasistencia") {
        try {
            $documentoInasistencia = preg_replace('/\D+/', '', trim($_POST["documento_inasistencia"] ?? ""));

            if ($documentoInasistencia === "") {
                throw new RuntimeException("Escribe y busca el documento del estudiante antes de registrar la inasistencia.");
            }

            // Los datos del estudiante se toman siempre de la tabla `asistencia` (nunca de lo
            // que llegue por POST) para que la inasistencia quede con su informacion real y actual.
            $documentoInt = (int) $documentoInasistencia;
            $stmtBuscar = $mysqli->prepare(
                "SELECT nombre_asistencia, grado_asistencia, jornada_asistencia, telefino_asistencia
                 FROM asistencia WHERE documento_asistencia = ?"
            );
            $stmtBuscar->bind_param("i", $documentoInt);
            $stmtBuscar->execute();
            $estudiante = $stmtBuscar->get_result()->fetch_assoc();
            $stmtBuscar->close();

            if (!$estudiante) {
                throw new RuntimeException("No se encontró ningún estudiante con ese documento en la tabla de asistencia.");
            }

            $stmtInsertar = $mysqli->prepare(
                "INSERT INTO inasistencia (documento_inasistencia, nombre_inasistencia, telefono_inasistencia, grado_inasistencia, jornada_inasistencia)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmtInsertar->bind_param(
                "isiss",
                $documentoInt,
                $estudiante["nombre_asistencia"],
                $estudiante["telefino_asistencia"],
                $estudiante["grado_asistencia"],
                $estudiante["jornada_asistencia"]
            );
            $stmtInsertar->execute();
            $stmtInsertar->close();
            $mensaje = "Se registró la inasistencia de " . $estudiante["nombre_asistencia"] . ".";
        } catch (mysqli_sql_exception $error) {
            $mensaje = $error->getCode() === 1062
                ? "Ese estudiante ya tiene una inasistencia registrada."
                : "No se pudo registrar la inasistencia.";
        } catch (RuntimeException $error) {
            $mensaje = $error->getMessage();
        }
    }
}

// Filtros de la lista (por GET, para poder compartir/recargar la URL con el mismo filtro)
$filtroGrado = trim($_GET["grado"] ?? "");
$filtroJornada = trim($_GET["jornada"] ?? "");
$filtroTexto = trim($_GET["buscar"] ?? "");

if (!in_array($filtroGrado, $gradosValidos, true)) {
    $filtroGrado = "";
}
if (!in_array($filtroJornada, $jornadasValidas, true)) {
    $filtroJornada = "";
}

$condiciones = [];
$parametros = [];
$tipos = "";

if ($filtroGrado !== "") {
    $condiciones[] = "grado_asistencia = ?";
    $parametros[] = $filtroGrado;
    $tipos .= "s";
}
if ($filtroJornada !== "") {
    $condiciones[] = "jornada_asistencia = ?";
    $parametros[] = $filtroJornada;
    $tipos .= "s";
}
if ($filtroTexto !== "") {
    // El documento se compara solo por digitos: si se pega con puntos, espacios o
    // guiones (p. ej. "1.000.000.008"), igual debe encontrar el registro guardado.
    $documentoBuscado = preg_replace('/\D+/', '', $filtroTexto);
    $comodinNombre = "%$filtroTexto%";

    if ($documentoBuscado !== "") {
        $condiciones[] = "(nombre_asistencia LIKE ? OR documento_asistencia LIKE ?)";
        $parametros[] = $comodinNombre;
        $parametros[] = "%$documentoBuscado%";
        $tipos .= "ss";
    } else {
        $condiciones[] = "nombre_asistencia LIKE ?";
        $parametros[] = $comodinNombre;
        $tipos .= "s";
    }
}

$sql = "SELECT * FROM asistencia";
if ($condiciones !== []) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY grado_asistencia ASC, nombre_asistencia ASC LIMIT 500";

$stmt = $mysqli->prepare($sql);
if ($parametros !== []) {
    $stmt->bind_param($tipos, ...$parametros);
}
$stmt->execute();
$registros = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Si la busqueda no encontro nada pero hay un filtro de grado/jornada activo, se avisa
// que el estudiante podria existir en otro grado u otra jornada (los filtros se combinan).
$avisoOtroFiltro = "";
if ($registros === [] && $filtroTexto !== "" && ($filtroGrado !== "" || $filtroJornada !== "")) {
    $stmtSinFiltros = $mysqli->prepare(
        "SELECT COUNT(*) AS total FROM asistencia WHERE nombre_asistencia LIKE ? OR documento_asistencia LIKE ?"
    );
    $comodinSinFiltros = "%$filtroTexto%";
    $stmtSinFiltros->bind_param("ss", $comodinSinFiltros, $comodinSinFiltros);
    $stmtSinFiltros->execute();
    $totalSinFiltros = (int) $stmtSinFiltros->get_result()->fetch_assoc()["total"];
    $stmtSinFiltros->close();

    if ($totalSinFiltros > 0) {
        $avisoOtroFiltro = "Ese documento o nombre existe, pero en otro grado o jornada. Quita esos filtros para verlo.";
    }
}

$totalGeneral = (int) $mysqli->query("SELECT COUNT(*) AS total FROM asistencia")->fetch_assoc()["total"];

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
    <title>Editor de contenido - Asistencia | Eugenio Ferro Falla</title>
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
              <li><a class="dropdown-item active" aria-current="page" href="./asistencia.php">Asistencia</a></li>
              <li><a class="dropdown-item" href="./inasistencia.php">Inasistencia</a></li>
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
      <h1>Editor de contenido - Asistencia</h1>
      <p>Administra los registros almacenados en la tabla <strong>asistencia</strong> de la base de datos <strong>eugenio_pagina_web</strong> (documento, nombre, grado, jornada y teléfono de cada estudiante).</p>
    </div>
<!--Fin encabezado del editor-->

    <?php if ($mensaje !== ""): ?>
      <div class="alert editor-alert mb-4" role="alert"><?= texto($mensaje) ?></div>
    <?php endif; ?>

    <!--Inicio tarjeta de contenido-->
    <div class="editor-content-card p-4 mb-4">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div class="editor-section-title mb-0">Registros de asistencia</div>
        <button class="btn btn-crear btn-nuevo-registro" type="button" data-bs-toggle="modal" data-bs-target="#modalRegistro">
          <i class="fa-solid fa-plus"></i> Nuevo registro
        </button>
      </div>

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
          <a href="./asistencia.php" class="btn btn-outline-light flex-fill">Limpiar</a>
          <button type="button" class="btn login-submit-btn flex-fill" data-bs-toggle="modal" data-bs-target="#modalInasistencia">
            <i class="fa-solid fa-user-xmark"></i> Inasistencia
          </button>
        </div>
      </form>
      <!--Fin filtros-->

      <p class="resumen-asistencia">Mostrando <?= count($registros) ?> de <?= $totalGeneral ?> registros.</p>

      <?php if ($registros === []): ?>
        <!--Inicio estado vacio-->
        <div class="editor-empty-card">
          <p class="mb-0">No se encontraron registros con los filtros seleccionados.</p>
          <?php if ($avisoOtroFiltro !== ""): ?>
            <p class="mb-0 mt-2"><strong><?= texto($avisoOtroFiltro) ?></strong></p>
          <?php endif; ?>
        </div>
        <!--Fin estado vacio-->
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-borderless tabla-asistencia align-middle mb-0">
            <thead>
              <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Grado</th>
                <th>Jornada</th>
                <th>Teléfono</th>
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($registros as $registro): ?>
                <tr>
                  <td><?= texto((string) $registro["documento_asistencia"]) ?></td>
                  <td><?= texto($registro["nombre_asistencia"]) ?></td>
                  <td><?= texto($registro["grado_asistencia"]) ?></td>
                  <td><?= texto($registro["jornada_asistencia"]) ?></td>
                  <td><?= texto((string) $registro["telefino_asistencia"]) ?></td>
                  <td><?= texto(date("d/m/Y H:i", strtotime($registro["fecha_asistencia"]))) ?></td>
                  <td class="text-nowrap">
                    <button type="button" class="btn btn-sm btn-editar btn-editar-registro" data-bs-toggle="modal" data-bs-target="#modalRegistro"
                      data-id="<?= (int) $registro["id_asistencia"] ?>"
                      data-documento="<?= texto((string) $registro["documento_asistencia"]) ?>"
                      data-nombre="<?= texto($registro["nombre_asistencia"]) ?>"
                      data-grado="<?= texto($registro["grado_asistencia"]) ?>"
                      data-jornada="<?= texto($registro["jornada_asistencia"]) ?>"
                      data-telefono="<?= texto((string) $registro["telefino_asistencia"]) ?>"
                      title="Editar registro">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <form method="post" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este registro de asistencia?');">
                      <input type="hidden" name="accion" value="eliminar">
                      <input type="hidden" name="id_asistencia" value="<?= (int) $registro["id_asistencia"] ?>">
                      <button type="submit" class="btn btn-sm btn-eliminar" title="Eliminar registro"><i class="fa-solid fa-trash"></i></button>
                    </form>
                  </td>
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

<!--Inicio modal crear/editar registro-->
  <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content login-modal">
        <div class="modal-header login-modal-header">
          <h5 class="modal-title" id="modalRegistroLabel">Crear registro de asistencia</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form method="post">
          <div class="modal-body">
            <input type="hidden" name="accion" value="guardar">
            <input type="hidden" name="id_asistencia" value="">
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label for="campo-documento" class="form-label login-label">Documento</label>
                <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control login-input" id="campo-documento" name="documento_asistencia" maxlength="11" required>
              </div>
              <div class="col-12 col-md-6">
                <label for="campo-telefono" class="form-label login-label">Teléfono</label>
                <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control login-input" id="campo-telefono" name="telefino_asistencia" maxlength="14" required>
              </div>
              <div class="col-12">
                <label for="campo-nombre" class="form-label login-label">Nombre completo</label>
                <input type="text" class="form-control login-input" id="campo-nombre" name="nombre_asistencia" maxlength="100" required>
              </div>
              <div class="col-12 col-md-6">
                <label for="campo-grado" class="form-label login-label">Grado</label>
                <select class="form-select login-input" id="campo-grado" name="grado_asistencia" required>
                  <option value="" disabled selected>Selecciona un grado</option>
                  <?php foreach ($gradosValidos as $codigo): ?>
                    <option value="<?= $codigo ?>"><?= $codigo ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label for="campo-jornada" class="form-label login-label">Jornada</label>
                <select class="form-select login-input" id="campo-jornada" name="jornada_asistencia" required>
                  <option value="" disabled selected>Selecciona una jornada</option>
                  <?php foreach ($jornadasValidas as $jornadaOpcion): ?>
                    <option value="<?= $jornadaOpcion ?>"><?= $jornadaOpcion ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="border-top: 1px solid rgba(185, 227, 240, 0.6);">
            <button type="button" class="btn" data-bs-dismiss="modal" style="color: #f5f9fb;">Cancelar</button>
            <button type="submit" class="btn login-submit-btn" id="botonGuardarRegistro">Crear registro</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!--Fin modal crear/editar registro-->

<!--Inicio modal registrar inasistencia-->
  <div class="modal fade" id="modalInasistencia" tabindex="-1" aria-labelledby="modalInasistenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content login-modal">
        <div class="modal-header login-modal-header">
          <h5 class="modal-title" id="modalInasistenciaLabel">Registrar inasistencia</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="row g-2 align-items-end mb-3">
            <div class="col-8">
              <label for="inasistencia-documento" class="form-label login-label">Documento del estudiante</label>
              <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control login-input" id="inasistencia-documento" maxlength="11">
            </div>
            <div class="col-4">
              <button type="button" class="btn login-submit-btn w-100" id="botonBuscarEstudiante">Buscar</button>
            </div>
          </div>

          <div id="inasistenciaResultado" class="d-none">
            <p class="mb-1"><span class="login-label">Nombre:</span> <span id="inasistencia-nombre" class="editor-field-value"></span></p>
            <p class="mb-1"><span class="login-label">Grado:</span> <span id="inasistencia-grado" class="editor-field-value"></span></p>
            <p class="mb-0"><span class="login-label">Jornada:</span> <span id="inasistencia-jornada" class="editor-field-value"></span></p>
          </div>
          <p id="inasistenciaMensaje" class="mensaje-inasistencia mb-0"></p>
        </div>
        <div class="modal-footer" style="border-top: 1px solid rgba(185, 227, 240, 0.6);">
          <button type="button" class="btn" data-bs-dismiss="modal" style="color: #f5f9fb;">Cancelar</button>
          <form method="post" id="formRegistrarInasistencia">
            <input type="hidden" name="accion" value="registrar_inasistencia">
            <input type="hidden" name="documento_inasistencia" id="inasistencia-documento-oculto" value="">
            <button type="submit" class="btn login-submit-btn" id="botonRegistrarInasistencia" disabled>Registrar inasistencia</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<!--Fin modal registrar inasistencia-->

  <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
  <script src="../auth/panel.js"></script>
  <script src="./asistencia.js"></script>
</body>
</html>
