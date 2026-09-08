<?php

require_once __DIR__ . "/sesion.php";
require_once __DIR__ . "/conexion.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$mostrarErrorLogin = !empty($_SESSION["login_error"]);
unset($_SESSION["login_error"]);

$resultado = $mysqli->query("SELECT * FROM eventos ORDER BY id_eventos DESC LIMIT 1");
$eventos = $resultado ? $resultado->fetch_assoc() : null;

// Variables PHP con la informacion de la tabla `eventos` (con valores por defecto de respaldo)
$banner_eventos = $eventos["banner_eventos"] ?? "./img-eventos/banner.png";
$titulo_1_eventos = $eventos["titulo-1"] ?? "El perfil de nuestros estudiantes";
$titulo_2_eventos = $eventos["titulo-2"] ?? "El estudiante del Colegio Eugenio Ferro Falla de Campoalegre Huila deberá:";
$texto_1_eventos = $eventos["texto-1"] ?? "Ser partícipe de su quehacer educativo para construir su propio proyecto de vida con éxito.
Ser activamente creador, responsable, comprometido para liderar y producir cambios de excelencia en su vida familiar y comunitaria.
Ser una persona con capacidad crítica, reflexiva, analítica.
Ser consciente de su individualidad, su identidad y su libertad con responsabilidad.
Ser una persona que aprecie, promueva y viva en los valores familiares, sociales, culturales, cívicos, éticos, estéticos y ecológicos.
Formarse en el respeto por los derechos humanos, la paz, los principios democráticos, los acuerdos de convivencia, el pluralismo, la justicia y la tolerancia.
Ser un futuro ciudadano que puedan participar en el funcionamiento y desarrollo de las estructuras sociales económicas y políticas de Colombia con honestidad y compromiso.
Ser una persona dispuesta a propender por una formación integral.";
$img_url_1_eventos = $eventos["img-url-1"] ?? "./img-eventos/perfil.jpeg";

$modal_1_titulo_1_eventos = $eventos["modal-1-titulo-1"] ?? "Voleibol";
$modal_1_titulo_2_eventos = $eventos["modal-1-titulo-2"] ?? "Voleibol";
$modal_1_texto_eventos = $eventos["modal-1-text-1"] ?? "Edad de 7 a 11 años Martes y jueves: 4:30 p.m. a 5:30 p. m";

$modal_2_titulo_1_eventos = $eventos["modal-2-titulo-1"] ?? "Música";
$modal_2_titulo_2_eventos = $eventos["modal-2-titulo-2"] ?? "Música";
$modal_2_texto_eventos = $eventos["modal-2-text-2"] ?? "Técnica Vocal de 8 años en adelante Lunes y miércoles: 4:30 p.m. a 5:30 p. m.
Instrumentos musicales de 6 años en adelante Martes y jueves: 4:30 p.m. a 5:30 p. m.";

$modal_3_titulo_1_eventos = $eventos["modal-3-titulo-1"] ?? "Fútbol";
$modal_3_titulo_2_eventos = $eventos["modal-3-titulo-2"] ?? "Fútbol";
$modal_3_texto_eventos = $eventos["modal-3-text-3"] ?? "Categoría Babies (masculino) de 4 a 6 años Lunes y miércoles: 4:30 p.m. a 5:30 p. m.
Categoría Infantil (masculino) de 7 años en adelante Martes y jueves: 4:30 p.m. a 5:30 p. m.
Categoría Femenino de 9 años en adelante Martes y jueves: 4:30 p.m. a 5:30 p. m.";

$numero_whatsapp_eventos = "573132345685";

// Escapa un valor de la tabla para imprimirlo como texto plano
function texto_eventos(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, "UTF-8");
}

// Escapa un valor de la tabla conservando los saltos de linea guardados desde el editor
function parrafo_eventos(string $valor): string
{
    return nl2br(htmlspecialchars($valor, ENT_QUOTES, "UTF-8"));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
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
          <img src="<?= texto_eventos($banner_eventos) ?>" class="banner" alt="Banner principal">
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

        <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</button>
      </div>
    </div>
  </nav>
<!--Fin nav-->
  <br>
<!--Inicio Perfil estudiante-->
  <div class="container perfil-banner-section">
    <div class="row g-0 align-items-stretch perfil-row">
      <div class="col-12 col-lg-6 perfil-copy">
        <div class="perfil-panel h-100">
          <h3><?= texto_eventos($titulo_1_eventos) ?></h3><br>
          <h4><?= texto_eventos($titulo_2_eventos) ?></h4><br>
          <p style="text-align: justify;">
              <?= parrafo_eventos($texto_1_eventos) ?>
          </p>
        </div>
      </div>
      <div class="col-12 col-lg-6 perfil-image-col p-3 p-lg-3">
        <div class="perfil-panel perfil-image-panel h-100">
          <img src="<?= texto_eventos($img_url_1_eventos) ?>" class="img-fluid perfil-image" alt="Perfil de estudiante">
        </div>
      </div>
    </div>
  </div>
<!--Fin Perfil-->
<br>
<!--Inicio Modales -->
  <div class="container text-center">
  <div class="row">
    <div class="col">
      <!--Inicio Modal 1-->
      <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
          <?= texto_eventos($modal_1_titulo_1_eventos) ?>
        </button>

<!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= texto_eventos($modal_1_titulo_2_eventos) ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <?= parrafo_eventos($modal_1_texto_eventos) ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

              </div>
            </div>
          </div>
        </div>
      <!--Fin Modal 1-->
    </div>
    <div class="col order-5">
      <!--Inicio Modal 2  -->
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop-2">
          <?= texto_eventos($modal_2_titulo_1_eventos) ?>
        </button>

<!-- Modal -->
        <div class="modal fade" id="staticBackdrop-2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel-2" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel-2"><?= texto_eventos($modal_2_titulo_2_eventos) ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <?= parrafo_eventos($modal_2_texto_eventos) ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

              </div>
            </div>
          </div>
        </div>
      <!--Fin Modal 2-->
    </div>
    <div class="col order-1">
      <!--Inicio Modal 3 -->
      <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop-3">
          <?= texto_eventos($modal_3_titulo_1_eventos) ?>
        </button>

<!-- Modal -->
        <div class="modal fade" id="staticBackdrop-3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel-3" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel-3"><?= texto_eventos($modal_3_titulo_2_eventos) ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body " >
                <?= parrafo_eventos($modal_3_texto_eventos) ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

              </div>
            </div>
          </div>
        </div>
      <!--Fin Modal 3-->
    </div>
  </div>
</div>
<!--Fin Modales -->
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
<!--Inicio Login Modal-->
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
<!--Fin Login Modal-->

<!--Inicio modal error de login-->
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
<!--Fin modal error de login-->

  <!-- Inicio boton flotante de whatsapp-->
    <a href="https://wa.me/<?= texto_eventos($numero_whatsapp_eventos) ?>?text=Hola%2C+quiero+m%C3%A1s+informaci%C3%B3n+acerca+de+las+fecha+de+matricula+del+Eugenio+Ferro+Falla" class="whatsapp-float" target="_blank" rel="noopener" title="Enviar mensaje por WhatsApp" aria-label="Enviar mensaje por WhatsApp">
        <i class="fab fa-whatsapp" aria-hidden="true"></i>
        <span class="visually-hidden">Enviar mensaje por WhatsApp</span>
    </a>
    <!-- Fin boton flotante de whatsapp-->

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
