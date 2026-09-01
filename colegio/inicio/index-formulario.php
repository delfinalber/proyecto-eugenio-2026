<?php

require_once __DIR__ . "/sesion.php";
require_once __DIR__ . "/conexion.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (empty($_SESSION["usuario_id"])) {
    header("Location: ./index.php");
    exit();
}

// Campos de la tabla `inicio` que se pueden editar desde este panel
$campos = [
    "banner_inicio"            => "Imagen del banner",
    "carru_img_1_inicio"       => "Carrusel - imagen 1",
    "carru_img_2_inicio"       => "Carrusel - imagen 2",
    "carru_img_3_inicio"       => "Carrusel - imagen 3",
    "url_video_inicio"         => "URL del video (enlace de YouTube: watch, youtu.be o embed)",
    "titulo-acordeon-1"        => "Acordeón 1 - título",
    "texto-acordeon-1"         => "Acordeón 1 - texto",
    "titulo-acordeon-2"        => "Acordeón 2 - título",
    "texto-acordeon-2"         => "Acordeón 2 - texto",
    "titulo-acordeon-3"        => "Acordeón 3 - título",
    "texto-acordeon-3"         => "Acordeón 3 - texto",
    "button-colarsar-titulo-1" => "Colapsable 1 - título",
    "button-colarsar-texto-1"  => "Colapsable 1 - texto",
    "button-colarsar-titulo-2" => "Colapsable 2 - título",
    "button-colarsar-texto-2"  => "Colapsable 2 - texto",
    "button-colarsar-titulo-3" => "Colapsable 3 - título",
    "button-colarsar-texto-3"  => "Colapsable 3 - texto",
    "numero_whatsapp"          => "Número de WhatsApp",
];

$textareas = [
    "texto-acordeon-1", "texto-acordeon-2", "texto-acordeon-3",
    "button-colarsar-texto-1", "button-colarsar-texto-2", "button-colarsar-texto-3",
];

// Campos que se guardan como archivos de imagen dentro de img-ini
$camposImagen = ["banner_inicio", "carru_img_1_inicio", "carru_img_2_inicio", "carru_img_3_inicio"];

define("CARPETA_IMAGENES_INICIO", __DIR__ . "/img-ini/");

function guardarImagenInicio(array $archivo): string
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

    $nombreArchivo = "inicio-" . uniqid() . "." . $extension;

    if (!move_uploaded_file($archivo["tmp_name"], CARPETA_IMAGENES_INICIO . $nombreArchivo)) {
        throw new RuntimeException("No se pudo guardar la imagen en la carpeta img-ini.");
    }

    return "./img-ini/" . $nombreArchivo;
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
                        $rutaImagen = guardarImagenInicio($_FILES[$campo]);
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

                $stmt = $mysqli->prepare("INSERT INTO inicio ($columnas) VALUES ($marcadores)");
                $stmt->bind_param($tipos, ...array_values($valores));
                $stmt->execute();
                $stmt->close();
                $mensaje = "El contenido de inicio se creó correctamente.";
            } else {
                $id_inicio = (int) ($_POST["id_inicio"] ?? 0);
                $asignaciones = implode(", ", array_map(fn($c) => "`$c` = ?", array_keys($campos)));
                $tipos = str_repeat("s", count($campos)) . "i";
                $parametros = array_values($valores);
                $parametros[] = $id_inicio;

                $stmt = $mysqli->prepare("UPDATE inicio SET $asignaciones WHERE id_inicio = ?");
                $stmt->bind_param($tipos, ...$parametros);
                $stmt->execute();
                $stmt->close();
                $mensaje = "El contenido de inicio se actualizó correctamente.";
            }
        }
    } elseif ($accion === "eliminar") {
        $id_inicio = (int) ($_POST["id_inicio"] ?? 0);
        $stmt = $mysqli->prepare("DELETE FROM inicio WHERE id_inicio = ?");
        $stmt->bind_param("i", $id_inicio);
        $stmt->execute();
        $stmt->close();
        $mensaje = "El contenido de inicio se eliminó correctamente.";
    }
}

$resultado = $mysqli->query("SELECT * FROM inicio ORDER BY id_inicio DESC LIMIT 1");
$inicio = $resultado ? $resultado->fetch_assoc() : null;

function valor_campo(?array $inicio, string $campo): string
{
    return htmlspecialchars($inicio[$campo] ?? "", ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de contenido - Inicio | Eugenio Ferro Falla</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Nunito+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./inicio.css">
    <link rel="stylesheet" href="./cuadricula.css">
    <link rel="icon" href="./img-ini/logo.jpeg" type="image/x-icon">
</head>
<body>
  <div class="container-fluid text-center px-0">
    <div class="row g-0 align-items-stretch hero-row">
      <div class="col-12">
        <div class="hero-banner-card">
          <img src="./img-ini/banner.png" class="banner" alt="Banner principal">
        </div>
      </div>
    </div>
  </div>

  <br>

  <nav class="navbar navbar-expand-lg nav-banner w-100">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">I.E. Eugenio Ferro Falla</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../eventos/eventos.html">Eventos</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" aria-disabled="true" href="../contacto/contacto.html">Contacto</a>
          </li>
        </ul>
        
        <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">Cerrar Sesión</button>
      </div>
    </div>
  </nav>

  <br>

  <div class="container">
    <div class="editor-header-card mb-4">
      <h1>Editor de contenido - Página de inicio</h1>
      <p>Administra la información almacenada en la tabla <strong>inicio</strong> de la base de datos <strong>eugenio_pagina_web</strong>. Estos datos alimentan las variables PHP que muestra <code>index.php</code>.</p>
    </div>

    <?php if ($mensaje !== ""): ?>
      <div class="alert editor-alert mb-4" role="alert"><?= htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8") ?></div>
    <?php endif; ?>

    <?php if (!$inicio): ?>
      <!--inicio estado vacio-->
      <div class="editor-empty-card">
        <p class="mb-3">Todavía no hay contenido registrado para la página de inicio.</p>
        <button class="btn btn-crear" type="button" data-bs-toggle="modal" data-bs-target="#modalContenido">Crear contenido</button>
      </div>
      <!--fin estado vacio-->
    <?php else: ?>
      <!--inicio tarjeta de contenido-->
      <div class="editor-content-card p-4 mb-4">
        <div class="row gy-4">
          <div class="col-12 col-md-6 col-lg-3">
            <div class="editor-section-title">Banner</div>
            <div class="editor-field-label">Imagen del banner</div>
            <div class="editor-field-value mb-2"><?= valor_campo($inicio, "banner_inicio") ?></div>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="editor-section-title">Carrusel</div>
            <div class="editor-field-label">Imagen 1</div>
            <div class="editor-field-value mb-2"><?= valor_campo($inicio, "carru_img_1_inicio") ?></div>
            <div class="editor-field-label">Imagen 2</div>
            <div class="editor-field-value mb-2"><?= valor_campo($inicio, "carru_img_2_inicio") ?></div>
            <div class="editor-field-label">Imagen 3</div>
            <div class="editor-field-value mb-2"><?= valor_campo($inicio, "carru_img_3_inicio") ?></div>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="editor-section-title">Video</div>
            <div class="editor-field-label">URL del video</div>
            <div class="editor-field-value mb-2"><?= valor_campo($inicio, "url_video_inicio") ?></div>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="editor-section-title">WhatsApp</div>
            <div class="editor-field-label">Número</div>
            <div class="editor-field-value mb-2"><?= valor_campo($inicio, "numero_whatsapp") ?></div>
          </div>
        </div>

        <hr class="my-4" style="border-color: rgba(185, 227, 240, 0.35);">

        <div class="row gy-4">
          <?php foreach ([1, 2, 3] as $n): ?>
            <div class="col-12 col-lg-4">
              <div class="editor-section-title">Acordeón <?= $n ?></div>
              <div class="editor-field-label">Título</div>
              <div class="editor-field-value mb-2"><?= valor_campo($inicio, "titulo-acordeon-$n") ?></div>
              <div class="editor-field-label">Texto</div>
              <div class="editor-field-value mb-2"><?= nl2br(valor_campo($inicio, "texto-acordeon-$n")) ?></div>
            </div>
          <?php endforeach; ?>
        </div>

        <hr class="my-4" style="border-color: rgba(185, 227, 240, 0.35);">

        <div class="row gy-4">
          <?php foreach ([1, 2, 3] as $n): ?>
            <div class="col-12 col-lg-4">
              <div class="editor-section-title">Colapsable <?= $n ?></div>
              <div class="editor-field-label">Título</div>
              <div class="editor-field-value mb-2"><?= valor_campo($inicio, "button-colarsar-titulo-$n") ?></div>
              <div class="editor-field-label">Texto</div>
              <div class="editor-field-value mb-2"><?= nl2br(valor_campo($inicio, "button-colarsar-texto-$n")) ?></div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="editor-actions d-flex gap-2 justify-content-end mt-4">
          <button class="btn btn-editar" type="button" data-bs-toggle="modal" data-bs-target="#modalContenido">
            <i class="fa-solid fa-pen-to-square"></i> Editar
          </button>
          <form method="post" onsubmit="return confirm('¿Seguro que deseas eliminar el contenido de inicio?');">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id_inicio" value="<?= (int) $inicio["id_inicio"] ?>">
            <button class="btn btn-eliminar" type="submit">
              <i class="fa-solid fa-trash"></i> Eliminar
            </button>
          </form>
        </div>
      </div>
      <!--fin tarjeta de contenido-->
    <?php endif; ?>
  </div>

  <br>

<!--inicio Footer-->
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
<!--fin Footer-->
<!--inicio modal cerrar sesion-->
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
<!--fin modal cerrar sesion-->

<!--inicio modal editar/crear contenido-->
  <div class="modal fade" id="modalContenido" tabindex="-1" aria-labelledby="modalContenidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
      <div class="modal-content login-modal">
        <div class="modal-header login-modal-header">
          <h5 class="modal-title" id="modalContenidoLabel"><?= $inicio ? "Editar contenido de inicio" : "Crear contenido de inicio" ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="accion" value="<?= $inicio ? "editar" : "guardar" ?>">
            <?php if ($inicio): ?>
              <input type="hidden" name="id_inicio" value="<?= (int) $inicio["id_inicio"] ?>">
            <?php endif; ?>

            <div class="row g-3">
              <?php foreach ($campos as $campo => $etiqueta): ?>
                <div class="col-12 <?= in_array($campo, $textareas, true) ? "" : "col-md-6" ?>">
                  <label for="campo-<?= htmlspecialchars($campo) ?>" class="form-label login-label"><?= htmlspecialchars($etiqueta, ENT_QUOTES, "UTF-8") ?></label>
                  <?php if (in_array($campo, $camposImagen, true)): ?>
                    <input type="file" class="form-control login-input" id="campo-<?= htmlspecialchars($campo) ?>" name="<?= htmlspecialchars($campo) ?>" accept="image/png, image/jpeg, image/webp, image/gif" <?= valor_campo($inicio, $campo) === "" ? "required" : "" ?>>
                    <input type="hidden" name="actual_<?= htmlspecialchars($campo) ?>" value="<?= valor_campo($inicio, $campo) ?>">
                    <div class="form-text">Se guarda en la carpeta img-ini. Actual: <?= valor_campo($inicio, $campo) ?: "sin imagen" ?></div>
                  <?php elseif (in_array($campo, $textareas, true)): ?>
                    <textarea class="form-control login-input" id="campo-<?= htmlspecialchars($campo) ?>" name="<?= htmlspecialchars($campo) ?>" rows="3" required><?= valor_campo($inicio, $campo) ?></textarea>
                  <?php else: ?>
                    <input type="text" class="form-control login-input" id="campo-<?= htmlspecialchars($campo) ?>" name="<?= htmlspecialchars($campo) ?>" value="<?= valor_campo($inicio, $campo) ?>" required>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="modal-footer" style="border-top: 1px solid rgba(185, 227, 240, 0.6);">
            <button type="button" class="btn" data-bs-dismiss="modal" style="color: #f5f9fb;">Cancelar</button>
            <button type="submit" class="btn login-submit-btn"><?= $inicio ? "Guardar cambios" : "Crear contenido" ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!--fin modal editar/crear contenido-->


  <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Limpia el historial de navegación al entrar tras iniciar sesión (evita reabrir con "atrás")
    if (window.history && window.history.replaceState) {
      window.history.replaceState(null, "", window.location.pathname);
    }
  </script>
</body>
</html>