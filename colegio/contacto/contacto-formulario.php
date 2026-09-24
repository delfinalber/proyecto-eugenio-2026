<?php

require_once __DIR__ . "/../auth/sesion.php";
require_once __DIR__ . "/conexion.php";
require_once __DIR__ . "/funciones.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (empty($_SESSION["usuario_id"])) {
    header("Location: ./contacto.php");
    exit();
}

// Campos de la tabla `contacto` que se pueden editar desde este panel
$campos = [
    "banner_contacto"   => "Imagen del banner",
    "titulo-1-contacto" => "Mapa - título",
    "map-url-contacto"  => "Mapa - URL de Google Maps (enlace embed o el código iframe completo)",
];

$textareas = ["map-url-contacto"];

// Campos que se guardan como archivos de imagen dentro de img-contacto
$camposImagen = ["banner_contacto"];

// Longitud maxima de cada columna varchar de la tabla
$longitudMaxima = ["banner_contacto" => 150, "titulo-1-contacto" => 100];

define("CARPETA_IMAGENES_CONTACTO", __DIR__ . "/img-contacto/");

function guardarImagenContacto(array $archivo): string
{
    $extensionesPermitidas = ["jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png", "webp" => "image/webp", "gif" => "image/gif"];
    $extension = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));

    if (!array_key_exists($extension, $extensionesPermitidas)) {
        throw new RuntimeException("Formato de imagen no permitido (usa jpg, png, webp o gif).");
    }

    if ($archivo["size"] > 5 * 1024 * 1024) {
        throw new RuntimeException("La imagen supera el tamaño máximo permitido de 5 MB.");
    }

    $tipoMime = mime_content_type($archivo["tmp_name"]);
    if ($tipoMime !== $extensionesPermitidas[$extension]) {
        throw new RuntimeException("El archivo subido no es una imagen válida.");
    }

    $nombreArchivo = "contacto-" . uniqid() . "." . $extension;

    if (!move_uploaded_file($archivo["tmp_name"], CARPETA_IMAGENES_CONTACTO . $nombreArchivo)) {
        throw new RuntimeException("No se pudo guardar la imagen en la carpeta img-contacto.");
    }

    return "./img-contacto/" . $nombreArchivo;
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST["accion"] ?? "";

    if ($accion === "guardar" || $accion === "editar") {
        try {
            $valores = [];
            foreach (array_keys($campos) as $campo) {
                $recibido = $_POST[$campo] ?? "";
                $actual = $_POST["actual_$campo"] ?? "";
                if (!is_string($recibido) || !is_string($actual)) {
                    throw new RuntimeException("Los datos enviados no son válidos.");
                }

                if (in_array($campo, $camposImagen, true)) {
                    $rutaImagen = trim($actual);
                    // Solo se acepta una ruta que ya este dentro de img-contacto
                    if ($rutaImagen !== "" && !preg_match('#^\./img-contacto/[A-Za-z0-9._-]+$#', $rutaImagen)) {
                        $rutaImagen = "";
                    }
                    if (isset($_FILES[$campo]) && $_FILES[$campo]["error"] === UPLOAD_ERR_OK) {
                        $rutaImagen = guardarImagenContacto($_FILES[$campo]);
                    }
                    if ($rutaImagen === "") {
                        throw new RuntimeException("Debes seleccionar una imagen para el banner.");
                    }
                    $valores[$campo] = $rutaImagen;
                } elseif ($campo === "map-url-contacto") {
                    $urlMapa = urlMapaValida($recibido);
                    if ($urlMapa === "") {
                        throw new RuntimeException("La URL del mapa debe ser un mapa embebido de Google Maps (https://www.google.com/maps/embed?...).");
                    }
                    $valores[$campo] = $urlMapa;
                } else {
                    $texto = trim($recibido);
                    if ($texto === "") {
                        throw new RuntimeException("Completa todos los campos.");
                    }
                    if (mb_strlen($texto) > ($longitudMaxima[$campo] ?? PHP_INT_MAX)) {
                        throw new RuntimeException("El campo \"{$campos[$campo]}\" admite máximo {$longitudMaxima[$campo]} caracteres.");
                    }
                    $valores[$campo] = $texto;
                }
            }
        } catch (RuntimeException $error) {
            $mensaje = $error->getMessage();
            $valores = null;
        }

        if ($valores !== null) {
            if ($accion === "guardar") {
                $columnas = implode(", ", array_map(fn($c) => "`$c`", array_keys($campos)));
                $marcadores = implode(", ", array_fill(0, count($campos), "?"));
                $tipos = str_repeat("s", count($campos));

                $stmt = $mysqli->prepare("INSERT INTO contacto ($columnas) VALUES ($marcadores)");
                $stmt->bind_param($tipos, ...array_values($valores));
                $stmt->execute();
                $stmt->close();
                $mensaje = "El contenido de contacto se creó correctamente.";
            } else {
                $id_contacto = (int) ($_POST["id_contacto"] ?? 0);
                $asignaciones = implode(", ", array_map(fn($c) => "`$c` = ?", array_keys($campos)));
                $tipos = str_repeat("s", count($campos)) . "i";
                $parametros = array_values($valores);
                $parametros[] = $id_contacto;

                $stmt = $mysqli->prepare("UPDATE contacto SET $asignaciones WHERE id_contacto = ?");
                $stmt->bind_param($tipos, ...$parametros);
                $stmt->execute();
                $stmt->close();
                $mensaje = "El contenido de contacto se actualizó correctamente.";
            }
        }
    } elseif ($accion === "eliminar") {
        $id_contacto = (int) ($_POST["id_contacto"] ?? 0);
        $stmt = $mysqli->prepare("DELETE FROM contacto WHERE id_contacto = ?");
        $stmt->bind_param("i", $id_contacto);
        $stmt->execute();
        $stmt->close();
        $mensaje = "El contenido de contacto se eliminó correctamente.";
    }
}

$resultado = $mysqli->query("SELECT * FROM contacto ORDER BY id_contacto DESC LIMIT 1");
$contacto = $resultado ? $resultado->fetch_assoc() : null;

function valor_campo(?array $contacto, string $campo): string
{
    return htmlspecialchars($contacto[$campo] ?? "", ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de contenido - Contacto | Eugenio Ferro Falla</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Nunito+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./contacto.css">
    <link rel="stylesheet" href="./cuadricula.css">
    <link rel="icon" href="./img-contacto/logo.jpeg" type="image/x-icon">
</head>
<body>

<!--Inicio Banner-->
  <div class="container-fluid text-center px-0">
    <div class="row g-0 align-items-stretch hero-row">
      <div class="col-12">
        <div class="hero-banner-card">
          <img src="<?= valor_campo($contacto, "banner_contacto") ?: BANNER_CONTACTO_POR_DEFECTO ?>" class="banner" alt="Banner principal">
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
            <a class="nav-link active" aria-current="page" href="../contacto/contacto-formulario.php">Contacto</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Asistencia</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../asistencia/asistencia.php">Asistencia</a></li>
              <li><a class="dropdown-item" href="../asistencia/inasistencia.php">Inasistencia</a></li>
              <li><a class="dropdown-item" href="../asistencia/dashboard.php">Dashboard</a></li>
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
      <h1>Editor de contenido - Página de contacto</h1>
      <p>Administra la información almacenada en la tabla <strong>contacto</strong> de la base de datos <strong>eugenio_pagina_web</strong>. Estos datos alimentan las variables PHP que muestra <code>contacto.php</code>.</p>
    </div>
<!--Fin encabezado del editor-->

    <?php if ($mensaje !== ""): ?>
      <div class="alert editor-alert mb-4" role="alert"><?= htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8") ?></div>
    <?php endif; ?>

    <?php if (!$contacto): ?>
      <!--Inicio estado vacio-->
      <div class="editor-empty-card">
        <p class="mb-3">Todavía no hay contenido registrado para la página de contacto.</p>
        <button class="btn btn-crear" type="button" data-bs-toggle="modal" data-bs-target="#modalContenido">Crear contenido</button>
      </div>
      <!--Fin estado vacio-->
    <?php else: ?>
      <!--Inicio tarjeta de contenido-->
      <div class="editor-content-card p-4 mb-4">
        <div class="row gy-4">
          <div class="col-12 col-md-6">
            <div class="editor-section-title">Banner</div>
            <div class="editor-field-label">Imagen del banner</div>
            <div class="editor-field-value mb-2"><?= valor_campo($contacto, "banner_contacto") ?></div>
            <?php if (valor_campo($contacto, "banner_contacto") !== ""): ?>
              <img src="<?= valor_campo($contacto, "banner_contacto") ?>" class="editor-thumb" alt="Vista previa del banner">
            <?php endif; ?>
          </div>
          <div class="col-12 col-md-6">
            <div class="editor-section-title">Mapa</div>
            <div class="editor-field-label">Título</div>
            <div class="editor-field-value mb-2"><?= valor_campo($contacto, "titulo-1-contacto") ?></div>
            <div class="editor-field-label">URL del mapa</div>
            <div class="editor-field-value mb-2"><?= valor_campo($contacto, "map-url-contacto") ?></div>
          </div>
        </div>

        <div class="editor-actions d-flex gap-2 justify-content-end mt-4">
          <button class="btn btn-editar" type="button" data-bs-toggle="modal" data-bs-target="#modalContenido">
            <i class="fa-solid fa-pen-to-square"></i> Editar
          </button>
          <form method="post" onsubmit="return confirm('¿Seguro que deseas eliminar el contenido de contacto?');">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id_contacto" value="<?= (int) $contacto["id_contacto"] ?>">
            <button class="btn btn-eliminar" type="submit">
              <i class="fa-solid fa-trash"></i> Eliminar
            </button>
          </form>
        </div>
      </div>
      <!--Fin tarjeta de contenido-->
    <?php endif; ?>
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
            <input type="hidden" name="origen" value="contacto">
            <button type="submit" class="btn login-submit-btn">Cerrar sesión</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<!--Fin modal cerrar sesion-->

<!--Inicio modal editar/crear contenido-->
  <div class="modal fade" id="modalContenido" tabindex="-1" aria-labelledby="modalContenidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
      <div class="modal-content login-modal">
        <div class="modal-header login-modal-header">
          <h5 class="modal-title" id="modalContenidoLabel"><?= $contacto ? "Editar contenido de contacto" : "Crear contenido de contacto" ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="accion" value="<?= $contacto ? "editar" : "guardar" ?>">
            <?php if ($contacto): ?>
              <input type="hidden" name="id_contacto" value="<?= (int) $contacto["id_contacto"] ?>">
            <?php endif; ?>

            <div class="row g-3">
              <?php foreach ($campos as $campo => $etiqueta): ?>
                <div class="col-12 <?= in_array($campo, $textareas, true) ? "" : "col-md-6" ?>">
                  <label for="campo-<?= htmlspecialchars($campo) ?>" class="form-label login-label"><?= htmlspecialchars($etiqueta, ENT_QUOTES, "UTF-8") ?></label>
                  <?php if (in_array($campo, $camposImagen, true)): ?>
                    <input type="file" class="form-control login-input" id="campo-<?= htmlspecialchars($campo) ?>" name="<?= htmlspecialchars($campo) ?>" accept="image/png, image/jpeg, image/webp, image/gif" <?= valor_campo($contacto, $campo) === "" ? "required" : "" ?>>
                    <input type="hidden" name="actual_<?= htmlspecialchars($campo) ?>" value="<?= valor_campo($contacto, $campo) ?>">
                    <div class="form-text">Se guarda en la carpeta img-contacto. Actual: <?= valor_campo($contacto, $campo) ?: "sin imagen" ?></div>
                  <?php elseif (in_array($campo, $textareas, true)): ?>
                    <textarea class="form-control login-input" id="campo-<?= htmlspecialchars($campo) ?>" name="<?= htmlspecialchars($campo) ?>" rows="4" required><?= valor_campo($contacto, $campo) ?></textarea>
                    <div class="form-text">En Google Maps: Compartir → Insertar un mapa → copia el código y pégalo aquí.</div>
                  <?php else: ?>
                    <input type="text" class="form-control login-input" id="campo-<?= htmlspecialchars($campo) ?>" name="<?= htmlspecialchars($campo) ?>" value="<?= valor_campo($contacto, $campo) ?>" maxlength="<?= (int) ($longitudMaxima[$campo] ?? 255) ?>" required>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="modal-footer" style="border-top: 1px solid rgba(185, 227, 240, 0.6);">
            <button type="button" class="btn" data-bs-dismiss="modal" style="color: #f5f9fb;">Cancelar</button>
            <button type="submit" class="btn login-submit-btn"><?= $contacto ? "Guardar cambios" : "Crear contenido" ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!--Fin modal editar/crear contenido-->

  <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
  <script src="../auth/panel.js"></script>
</body>
</html>
