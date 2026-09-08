<?php

require_once __DIR__ . "/sesion.php";
require_once __DIR__ . "/conexion.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (empty($_SESSION["usuario_id"])) {
    header("Location: ./eventos.php");
    exit();
}

// Campos de la tabla `eventos` que se pueden editar desde este panel
$campos = [
    "banner_eventos"   => "Imagen del banner",
    "titulo-1"         => "Perfil - título principal",
    "titulo-2"         => "Perfil - subtítulo",
    "texto-1"          => "Perfil - texto",
    "img-url-1"        => "Perfil - imagen",
    "modal-1-titulo-1" => "Modal 1 - texto del botón",
    "modal-1-titulo-2" => "Modal 1 - título del modal",
    "modal-1-text-1"   => "Modal 1 - texto",
    "modal-2-titulo-1" => "Modal 2 - texto del botón",
    "modal-2-titulo-2" => "Modal 2 - título del modal",
    "modal-2-text-2"   => "Modal 2 - texto",
    "modal-3-titulo-1" => "Modal 3 - texto del botón",
    "modal-3-titulo-2" => "Modal 3 - título del modal",
    "modal-3-text-3"   => "Modal 3 - texto",
];

$textareas = ["texto-1", "modal-1-text-1", "modal-2-text-2", "modal-3-text-3"];

// Campos que se guardan como archivos de imagen dentro de img-eventos
$camposImagen = ["banner_eventos", "img-url-1"];

define("CARPETA_IMAGENES_EVENTOS", __DIR__ . "/img-eventos/");

function guardarImagenEventos(array $archivo): string
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

    $nombreArchivo = "eventos-" . uniqid() . "." . $extension;

    if (!move_uploaded_file($archivo["tmp_name"], CARPETA_IMAGENES_EVENTOS . $nombreArchivo)) {
        throw new RuntimeException("No se pudo guardar la imagen en la carpeta img-eventos.");
    }

    return "./img-eventos/" . $nombreArchivo;
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST["accion"] ?? "";

    if ($accion === "guardar" || $accion === "editar") {
        try {
            $valores = [];
            foreach (array_keys($campos) as $campo) {
                if (in_array($campo, $camposImagen, true)) {
                    $rutaImagen = trim($_POST["actual_$campo"] ?? "");
                    if (isset($_FILES[$campo]) && $_FILES[$campo]["error"] === UPLOAD_ERR_OK) {
                        $rutaImagen = guardarImagenEventos($_FILES[$campo]);
                    }
                    $valores[$campo] = $rutaImagen;
                } else {
                    $valores[$campo] = trim($_POST[$campo] ?? "");
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

                $stmt = $mysqli->prepare("INSERT INTO eventos ($columnas) VALUES ($marcadores)");
                $stmt->bind_param($tipos, ...array_values($valores));
                $stmt->execute();
                $stmt->close();
                $mensaje = "El contenido de eventos se creó correctamente.";
            } else {
                $id_eventos = (int) ($_POST["id_eventos"] ?? 0);
                $asignaciones = implode(", ", array_map(fn($c) => "`$c` = ?", array_keys($campos)));
                $tipos = str_repeat("s", count($campos)) . "i";
                $parametros = array_values($valores);
                $parametros[] = $id_eventos;

                $stmt = $mysqli->prepare("UPDATE eventos SET $asignaciones WHERE id_eventos = ?");
                $stmt->bind_param($tipos, ...$parametros);
                $stmt->execute();
                $stmt->close();
                $mensaje = "El contenido de eventos se actualizó correctamente.";
            }
        }
    } elseif ($accion === "eliminar") {
        $id_eventos = (int) ($_POST["id_eventos"] ?? 0);
        $stmt = $mysqli->prepare("DELETE FROM eventos WHERE id_eventos = ?");
        $stmt->bind_param("i", $id_eventos);
        $stmt->execute();
        $stmt->close();
        $mensaje = "El contenido de eventos se eliminó correctamente.";
    }
}

$resultado = $mysqli->query("SELECT * FROM eventos ORDER BY id_eventos DESC LIMIT 1");
$eventos = $resultado ? $resultado->fetch_assoc() : null;

function valor_campo(?array $eventos, string $campo): string
{
    return htmlspecialchars($eventos[$campo] ?? "", ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de contenido - Eventos | Eugenio Ferro Falla</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Nunito+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./eventos.css">
    <link rel="stylesheet" href="./cuadricula.css">
    <link rel="icon" href="./img-eventos/logo.jpeg" type="image/x-icon">
</head>
<body>

<!--Inicio Banner-->
  <div class="container-fluid text-center px-0">
    <div class="row g-0 align-items-stretch hero-row">
      <div class="col-12">
        <div class="hero-banner-card">
          <img src="<?= valor_campo($eventos, "banner_eventos") ?: "./img-eventos/banner.png" ?>" class="banner" alt="Banner principal">
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
            <a class="nav-link" href="../inicio/index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./eventos.php">Eventos</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" aria-disabled="true" href="../contacto/contacto.html">Contacto</a>
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
      <h1>Editor de contenido - Página de eventos</h1>
      <p>Administra la información almacenada en la tabla <strong>eventos</strong> de la base de datos <strong>eugenio_pagina_web</strong>. Estos datos alimentan las variables PHP que muestra <code>eventos.php</code>.</p>
    </div>
<!--Fin encabezado del editor-->

    <?php if ($mensaje !== ""): ?>
      <div class="alert editor-alert mb-4" role="alert"><?= htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8") ?></div>
    <?php endif; ?>

    <?php if (!$eventos): ?>
      <!--Inicio estado vacio-->
      <div class="editor-empty-card">
        <p class="mb-3">Todavía no hay contenido registrado para la página de eventos.</p>
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
            <div class="editor-field-value mb-2"><?= valor_campo($eventos, "banner_eventos") ?></div>
            <?php if (valor_campo($eventos, "banner_eventos") !== ""): ?>
              <img src="<?= valor_campo($eventos, "banner_eventos") ?>" class="editor-thumb" alt="Vista previa del banner">
            <?php endif; ?>
          </div>
          <div class="col-12 col-md-6">
            <div class="editor-section-title">Perfil - imagen</div>
            <div class="editor-field-label">Imagen del perfil</div>
            <div class="editor-field-value mb-2"><?= valor_campo($eventos, "img-url-1") ?></div>
            <?php if (valor_campo($eventos, "img-url-1") !== ""): ?>
              <img src="<?= valor_campo($eventos, "img-url-1") ?>" class="editor-thumb" alt="Vista previa del perfil">
            <?php endif; ?>
          </div>
        </div>

        <hr class="my-4" style="border-color: rgba(185, 227, 240, 0.35);">

        <div class="row gy-4">
          <div class="col-12">
            <div class="editor-section-title">Perfil de nuestros estudiantes</div>
            <div class="editor-field-label">Título principal</div>
            <div class="editor-field-value mb-2"><?= valor_campo($eventos, "titulo-1") ?></div>
            <div class="editor-field-label">Subtítulo</div>
            <div class="editor-field-value mb-2"><?= valor_campo($eventos, "titulo-2") ?></div>
            <div class="editor-field-label">Texto</div>
            <div class="editor-field-value mb-2"><?= nl2br(valor_campo($eventos, "texto-1")) ?></div>
          </div>
        </div>

        <hr class="my-4" style="border-color: rgba(185, 227, 240, 0.35);">

        <div class="row gy-4">
          <?php
          // Cada modal usa un nombre distinto para su columna de texto
          $columnasTextoModal = [1 => "modal-1-text-1", 2 => "modal-2-text-2", 3 => "modal-3-text-3"];
          foreach ($columnasTextoModal as $n => $columnaTexto):
          ?>
            <div class="col-12 col-lg-4">
              <div class="editor-section-title">Modal <?= $n ?></div>
              <div class="editor-field-label">Texto del botón</div>
              <div class="editor-field-value mb-2"><?= valor_campo($eventos, "modal-$n-titulo-1") ?></div>
              <div class="editor-field-label">Título del modal</div>
              <div class="editor-field-value mb-2"><?= valor_campo($eventos, "modal-$n-titulo-2") ?></div>
              <div class="editor-field-label">Texto</div>
              <div class="editor-field-value mb-2"><?= nl2br(valor_campo($eventos, $columnaTexto)) ?></div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="editor-actions d-flex gap-2 justify-content-end mt-4">
          <button class="btn btn-editar" type="button" data-bs-toggle="modal" data-bs-target="#modalContenido">
            <i class="fa-solid fa-pen-to-square"></i> Editar
          </button>
          <form method="post" onsubmit="return confirm('¿Seguro que deseas eliminar el contenido de eventos?');">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id_eventos" value="<?= (int) $eventos["id_eventos"] ?>">
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
          <form method="post" action="./logout.php">
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
          <h5 class="modal-title" id="modalContenidoLabel"><?= $eventos ? "Editar contenido de eventos" : "Crear contenido de eventos" ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="accion" value="<?= $eventos ? "editar" : "guardar" ?>">
            <?php if ($eventos): ?>
              <input type="hidden" name="id_eventos" value="<?= (int) $eventos["id_eventos"] ?>">
            <?php endif; ?>

            <div class="row g-3">
              <?php foreach ($campos as $campo => $etiqueta): ?>
                <div class="col-12 <?= in_array($campo, $textareas, true) ? "" : "col-md-6" ?>">
                  <label for="campo-<?= htmlspecialchars($campo) ?>" class="form-label login-label"><?= htmlspecialchars($etiqueta, ENT_QUOTES, "UTF-8") ?></label>
                  <?php if (in_array($campo, $camposImagen, true)): ?>
                    <input type="file" class="form-control login-input" id="campo-<?= htmlspecialchars($campo) ?>" name="<?= htmlspecialchars($campo) ?>" accept="image/png, image/jpeg, image/webp, image/gif" <?= valor_campo($eventos, $campo) === "" ? "required" : "" ?>>
                    <input type="hidden" name="actual_<?= htmlspecialchars($campo) ?>" value="<?= valor_campo($eventos, $campo) ?>">
                    <div class="form-text">Se guarda en la carpeta img-eventos. Actual: <?= valor_campo($eventos, $campo) ?: "sin imagen" ?></div>
                  <?php elseif (in_array($campo, $textareas, true)): ?>
                    <textarea class="form-control login-input" id="campo-<?= htmlspecialchars($campo) ?>" name="<?= htmlspecialchars($campo) ?>" rows="4" required><?= valor_campo($eventos, $campo) ?></textarea>
                  <?php else: ?>
                    <input type="text" class="form-control login-input" id="campo-<?= htmlspecialchars($campo) ?>" name="<?= htmlspecialchars($campo) ?>" value="<?= valor_campo($eventos, $campo) ?>" required>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="modal-footer" style="border-top: 1px solid rgba(185, 227, 240, 0.6);">
            <button type="button" class="btn" data-bs-dismiss="modal" style="color: #f5f9fb;">Cancelar</button>
            <button type="submit" class="btn login-submit-btn"><?= $eventos ? "Guardar cambios" : "Crear contenido" ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!--Fin modal editar/crear contenido-->

  <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Limpia el historial de navegación al entrar tras iniciar sesión (evita reabrir con "atrás")
    if (window.history && window.history.replaceState) {
      window.history.replaceState(null, "", window.location.pathname);
    }
  </script>
</body>
</html>
