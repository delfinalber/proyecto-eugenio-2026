<?php

require_once __DIR__ . "/sesion.php";
require_once __DIR__ . "/conexion.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$mostrarErrorLogin = !empty($_SESSION["login_error"]);
unset($_SESSION["login_error"]);

// Convierte cualquier URL de YouTube (watch, youtu.be, shorts, embed) a formato embed reproducible en iframe
function urlYoutubeEmbed(string $url): string
{
    $url = trim($url);
    if ($url === "") {
        return $url;
    }

    $idVideo = null;
    if (preg_match('/youtu\.be\/([A-Za-z0-9_-]+)/', $url, $coincidencia)) {
        $idVideo = $coincidencia[1];
    } elseif (preg_match('/[?&]v=([A-Za-z0-9_-]+)/', $url, $coincidencia)) {
        $idVideo = $coincidencia[1];
    } elseif (preg_match('/youtube\.com\/(?:embed|shorts)\/([A-Za-z0-9_-]+)/', $url, $coincidencia)) {
        $idVideo = $coincidencia[1];
    }

    return $idVideo ? "https://www.youtube.com/embed/{$idVideo}" : $url;
}

$resultado = $mysqli->query("SELECT * FROM inicio ORDER BY id_inicio DESC LIMIT 1");
$inicio = $resultado ? $resultado->fetch_assoc() : null;

// Variables PHP con la informacion de la tabla `inicio` (con valores por defecto de respaldo)
$banner_inicio = $inicio["banner_inicio"] ?? "./img-ini/banner.png";
$carru_img_1_inicio = $inicio["carru_img_1_inicio"] ?? "./img-ini/carru1.jpeg";
$carru_img_2_inicio = $inicio["carru_img_2_inicio"] ?? "./img-ini/carru2.jpeg";
$carru_img_3_inicio = $inicio["carru_img_3_inicio"] ?? "./img-ini/carru3.jpeg";
$url_video_inicio = urlYoutubeEmbed($inicio["url_video_inicio"] ?? "https://youtu.be/G4B3WRvLX30?si=GV8IbIxST6wNcI6C");
$titulo_acordeon_1 = $inicio["titulo-acordeon-1"] ?? "Técnica en Programación de Software";
$texto_acordeon_1 = $inicio["texto-acordeon-1"] ?? "Programación de Software. El desarrollo de software hace referencia a un conjunto de actividades informáticas dedicadas al proceso de creación, diseño, implementación y soporte de software. El software propiamente dicho es el conjunto de instrucciones o programas que indican a un ordenador lo que debe hacer. Es independiente del hardware y hace que los ordenadores sean programables. El objetivo del desarrollo de software es crear un producto que satisfaga las necesidades de los usuarios y los objetivos empresariales de forma eficaz, repetible y segura. Los desarrolladores de software, programadores e ingenieros de software desarrollan software a través de una serie de pasos denominados ciclo de vida de desarrollo de software (SDLC). Las herramientas con inteligencia artificial e IA generativa se utilizan cada vez más para ayudar a los equipos de desarrollo de software a producir y probar el código.";
$titulo_acordeon_2 = $inicio["titulo-acordeon-2"] ?? "Técnica en Mantenimiento de Automatismos Industriales";
$texto_acordeon_2 = $inicio["texto-acordeon-2"] ?? "La automatización industrial. Cuando hablamos de automatización industrial, nos referimos a sistemas que usan ordenadores, autómatas programables, robots y tecnologías digitales para controlar máquinas y procesos en las fábricas. Su objetivo es reducir al máximo el trabajo manual y evitar tareas peligrosas al reemplazarlas por acciones automáticas y seguras. La automatización industrial es la evolución natural de la mecanización. Mientras la mecanización usa máquinas básicas para ayudar al trabajador, la automatización emplea equipos inteligentes y programados para controlar los procesos de manera más precisa, rápida y eficiente. Actualmente, los rápidos avances tecnológicos han dado lugar a la llamada Industria 4.0 o cuarta revolución industrial. En esta nueva etapa, las empresas usan sistemas inteligentes que permiten controlar y optimizar tola la producción con mayor precisión, calidad y rendimiento. Esto convierte a la automatización industrial en una pieza clave para compañías fabricantes y prestadoras de servicios industriales. En este artículo, vamos a explicar claramente los componentes principales que forman parte de los sistemas de automatización. También veremos cuáles son los tipos más usados en la industria y analizaremos su importancia para técnicos y empresas de servicios o manufactura.";
$titulo_acordeon_3 = $inicio["titulo-acordeon-3"] ?? "Técnico en integración de contenidos digitales";
$texto_acordeon_3 = $inicio["texto-acordeon-3"] ?? "El programa de Multimedia del SENA (formalmente conocido como Tecnología en Desarrollo Multimedia y Web o Técnico en Producción de Contenidos Digitales) Producir materiales audiovisuales para web, con finalidad comunicativa, aplicando técnicas de guionización, grabación, edición y optimización digital, para lograr contenidos adecuados en formato, narrativa y calidad técnica, según estándares de publicación en plataformas digitales.";
$colapsable_titulo_1 = $inicio["button-colarsar-titulo-1"] ?? "Tecnología";
$colapsable_texto_1 = $inicio["button-colarsar-texto-1"] ?? "La tecnología llegó para revolucionar nuestra vida a través de múltiples herramientas, dispositivos, software y plataformas, que nos permiten ser más eficientes, productivos y tener una mejor calidad de vida. Nos ha cambiado la forma en la que hacemos las actividades cotidianas, la manera en que nos comunicamos, el cómo trabajamos y hasta la forma de enseñar y aprender.";
$colapsable_titulo_2 = $inicio["button-colarsar-titulo-2"] ?? "Pedagogía";
$colapsable_texto_2 = $inicio["button-colarsar-texto-2"] ?? "La tecnología llegó para revolucionar nuestra vida a través de múltiples herramientas, dispositivos, software y plataformas, que nos permiten ser más eficientes, productivos y tener una mejor calidad de vida. Nos ha cambiado la forma en la que hacemos las actividades cotidianas, la manera en que nos comunicamos, el cómo trabajamos y hasta la forma de enseñar y aprender.";
$colapsable_titulo_3 = $inicio["button-colarsar-titulo-3"] ?? "Convivencia Escolar";
$colapsable_texto_3 = $inicio["button-colarsar-texto-3"] ?? "La convivencia escolar es un espacio en el cual se promueve acciones y acuerdos diarios que garantizan un ambiente de respeto, empatía y resolución pacífica de conflictos dentro de la comunidad educativa. Fomentan una cultura de buen trato que impacta positivamente el aprendizaje.";
$numero_whatsapp_inicio = $inicio["numero_whatsapp"] ?? "573132345685";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eugenio Ferro Falla</title>
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
  <!--inicio banner-->
  <div class="container-fluid text-center px-0">
    <div class="row g-0 align-items-stretch hero-row">
      <div class="col-12">
        <div class="hero-banner-card">
          <img src="<?= htmlspecialchars($banner_inicio, ENT_QUOTES, "UTF-8") ?>" class="banner" alt="Banner principal">
        </div>
      </div>
    </div>
  </div>
<!--fin banner-->
  <br>
<!--inicio navbar-->
  <nav class="navbar navbar-expand-lg nav-banner w-100">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">I.E. Eugenio Ferro Falla</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./index.html">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../eventos/eventos.html">Eventos</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" aria-disabled="true" href="../contacto/contacto.html">Contacto</a>
          </li>
        </ul>
        
        <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</button>
      </div>
    </div>
  </nav>
<!--fin navbar-->

  <br>
<!--Incio carrusel-->
  <div class="container text-center media-section">
    <div class="row align-items-stretch g-3">
      <div class="col-12 col-lg-8">
        <div id="carouselExampleAutoplaying" class="carousel slide media-card media-carousel" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="<?= htmlspecialchars($carru_img_1_inicio, ENT_QUOTES, "UTF-8") ?>" class="d-block w-100" alt="Imagen del carrusel 1">
            </div>
            <div class="carousel-item">
              <img src="<?= htmlspecialchars($carru_img_2_inicio, ENT_QUOTES, "UTF-8") ?>" class="d-block w-100" alt="Imagen del carrusel 2">
            </div>
            <div class="carousel-item">
              <img src="<?= htmlspecialchars($carru_img_3_inicio, ENT_QUOTES, "UTF-8") ?>" class="d-block w-100" alt="Imagen del carrusel 3">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="media-card media-video">
          <iframe src="<?= htmlspecialchars($url_video_inicio, ENT_QUOTES, "UTF-8") ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
<!--fin carrusel-->
  <br>
<!--inicio acordeon-->
  <div class="container text-center">
    <div class="row">
      <div class="col-lg-12 p-0">
        <div class="accordion accordion-banner p-3" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <b><?= htmlspecialchars($titulo_acordeon_1, ENT_QUOTES, "UTF-8") ?></b>
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
              <div class="accordion-body accordion-justify">
                <?= nl2br(htmlspecialchars($texto_acordeon_1, ENT_QUOTES, "UTF-8")) ?>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <b><?= htmlspecialchars($titulo_acordeon_2, ENT_QUOTES, "UTF-8") ?></b>
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body accordion-justify">
                <?= nl2br(htmlspecialchars($texto_acordeon_2, ENT_QUOTES, "UTF-8")) ?>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <b><?= htmlspecialchars($titulo_acordeon_3, ENT_QUOTES, "UTF-8") ?></b>
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body accordion-justify">
                <?= nl2br(htmlspecialchars($texto_acordeon_3, ENT_QUOTES, "UTF-8")) ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!--Fin acordeon-->
  <br>
<!--inicio collapse-horizontal-->
  <div class="container text-center">
    <div class="row align-items-center">
      <div class="col">
        <p>
          <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample-1" aria-expanded="false" aria-controls="collapseWidthExample-1">
            <?= htmlspecialchars($colapsable_titulo_1, ENT_QUOTES, "UTF-8") ?>
          </button>
        </p>
        <div class="collapse-container">
          <div class="collapse collapse-horizontal" id="collapseWidthExample-1">
            <div class="card card-body collapse-card">
              <?= nl2br(htmlspecialchars($colapsable_texto_1, ENT_QUOTES, "UTF-8")) ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <p>
          <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample-2" aria-expanded="false" aria-controls="collapseWidthExample-2">
            <?= htmlspecialchars($colapsable_titulo_2, ENT_QUOTES, "UTF-8") ?>
          </button>
        </p>
        <div class="collapse-height">
          <div class="collapse collapse-horizontal" id="collapseWidthExample-2">
            <div class="card card-body collapse-card-width">
              <?= nl2br(htmlspecialchars($colapsable_texto_2, ENT_QUOTES, "UTF-8")) ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <p>
          <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample-3" aria-expanded="false" aria-controls="collapseWidthExample-3">
            <?= htmlspecialchars($colapsable_titulo_3, ENT_QUOTES, "UTF-8") ?>
          </button>
        </p>
        <div class="collapse-container-3">
          <div class="collapse collapse-horizontal" id="collapseWidthExample-3">
            <div class="card card-body collapse-card-justify">
              <?= nl2br(htmlspecialchars($colapsable_texto_3, ENT_QUOTES, "UTF-8")) ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!--fin collapse-horizontal-->
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

<!--inicio modal login-->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content login-modal">
        <div class="modal-header login-modal-header">
          <h5 class="modal-title" id="loginModalLabel">Inicio de sesión</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="./login.php" id="formularioLogin">
            <div class="d-flex justify-content-end mb-2">
              <span class="login-label" style="font-size: 0.85rem;">Tiempo restante: <strong id="tiempoRestanteLogin">30</strong>s</span>
            </div>
            <div class="mb-3">
              <label for="usuarioLogin" class="form-label login-label">Usuario</label>
              <input type="text" class="form-control login-input" id="usuarioLogin" name="usuario" placeholder="Ingresa tu usuario" autocomplete="username" required>
            </div>
            <div class="mb-3">
              <label for="contrasenaLogin" class="form-label login-label">Contrasena</label>
              <input type="password" class="form-control login-input" id="contrasenaLogin" name="contrasena" placeholder="Ingresa tu contrasena" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn login-submit-btn w-100" id="botonEntrarLogin">Entrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<!--fin modal login-->

<!--inicio modal error de login-->
  <div class="modal fade" id="loginErrorModal" tabindex="-1" aria-labelledby="loginErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content login-modal">
        <div class="modal-header login-modal-header">
          <h5 class="modal-title" id="loginErrorModalLabel">Error de acceso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body text-center">
          <p class="mb-0">Usuario o contraseña incorrecta.</p>
        </div>
        <div class="modal-footer" style="border-top: 1px solid rgba(185, 227, 240, 0.6); justify-content: center;">
          <button type="button" class="btn login-submit-btn" data-bs-dismiss="modal">Entendido</button>
        </div>
      </div>
    </div>
  </div>
<!--fin modal error de login-->

    <!--inicio boton flotante de whatsapp-->
    <!-- Enlace del Botón de WhatsApp (URL estática: este archivo es .html y no procesa PHP) -->
    <a href="https://wa.me/<?= htmlspecialchars($numero_whatsapp_inicio, ENT_QUOTES, "UTF-8") ?>?text=Hola%2C+quiero+m%C3%A1s+informaci%C3%B3n+acerca+de+las+fecha+de+matricula+del+Eugenio+Ferro+Falla" class="whatsapp-float" target="_blank" rel="noopener" title="Enviar mensaje por WhatsApp" aria-label="Enviar mensaje por WhatsApp">
        <i class="fab fa-whatsapp" aria-hidden="true"></i>
        <span class="visually-hidden">Enviar mensaje por WhatsApp</span>
    </a>
    <!--fin boton flotante de whatsapp-->


  <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function () {
      var modalLogin = document.getElementById("loginModal");
      var etiquetaTiempo = document.getElementById("tiempoRestanteLogin");
      var botonEntrar = document.getElementById("botonEntrarLogin");
      var formularioLogin = document.getElementById("formularioLogin");
      var intervalo = null;

      function iniciarTemporizadorLogin() {
        var segundos = 30;
        etiquetaTiempo.textContent = segundos;
        botonEntrar.disabled = false;

        clearInterval(intervalo);
        intervalo = setInterval(function () {
          segundos -= 1;
          etiquetaTiempo.textContent = segundos > 0 ? segundos : 0;
          if (segundos <= 0) {
            clearInterval(intervalo);
            botonEntrar.disabled = true;
          }
        }, 1000);
      }

      if (modalLogin) {
        modalLogin.addEventListener("shown.bs.modal", iniciarTemporizadorLogin);
        modalLogin.addEventListener("hidden.bs.modal", function () {
          clearInterval(intervalo);
          formularioLogin.reset();
        });
      }

      <?php if ($mostrarErrorLogin): ?>
      var modalError = new bootstrap.Modal(document.getElementById("loginErrorModal"));
      modalError.show();
      <?php endif; ?>

      // Limpia el historial de navegación (evita que quede el estado de error/login)
      if (window.history && window.history.replaceState) {
        window.history.replaceState(null, "", window.location.pathname);
      }
    })();
  </script>
</body>
</html>