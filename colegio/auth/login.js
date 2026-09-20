// Modal de inicio de sesión compartido por index.php, eventos.php y contacto.php
(function () {
  "use strict";

  var DURACION_MS = 30000;
  var RUTA_AUTH = "../auth/";

  var modalLogin = document.getElementById("loginModal");
  var formulario = document.getElementById("formularioLogin");
  var etiquetaTiempo = document.getElementById("tiempoRestanteLogin");
  var botonEntrar = document.getElementById("botonEntrarLogin");
  var intervalo = null;

  if (!modalLogin || !formulario) {
    return;
  }

  var origen = formulario.elements.origen.value;

  function tiempoAgotado() {
    botonEntrar.disabled = true;
    formulario.reset();
    // replace() no agrega una entrada nueva al historial; logout.php borra la sesión y las cookies y vuelve a esta página
    window.location.replace(RUTA_AUTH + "logout.php?origen=" + encodeURIComponent(origen));
  }

  function iniciarTemporizador() {
    var limite = Date.now() + DURACION_MS;
    etiquetaTiempo.textContent = Math.round(DURACION_MS / 1000);
    botonEntrar.disabled = false;

    // Le avisa al servidor que el modal se abrió, para que también valide los 30 segundos
    fetch(RUTA_AUTH + "login.php", {
      method: "POST",
      body: new URLSearchParams({ accion: "abrir", origen: origen }),
      credentials: "same-origin",
      cache: "no-store"
    }).catch(function () {});

    clearInterval(intervalo);
    intervalo = setInterval(function () {
      var restante = Math.max(0, Math.ceil((limite - Date.now()) / 1000));
      etiquetaTiempo.textContent = restante;
      if (restante === 0) {
        clearInterval(intervalo);
        tiempoAgotado();
      }
    }, 250);
  }

  modalLogin.addEventListener("shown.bs.modal", iniciarTemporizador);
  modalLogin.addEventListener("hidden.bs.modal", function () {
    clearInterval(intervalo);
    formulario.reset();
  });

  var modalError = document.getElementById("loginErrorModal");
  if (modalError && new URLSearchParams(window.location.search).get("login") === "error") {
    new bootstrap.Modal(modalError).show();
  }

  // Quita ?login=error de la URL para que no quede en el historial
  if (window.history && window.history.replaceState) {
    window.history.replaceState(null, "", window.location.pathname);
  }

  // Si el navegador restaura la página desde su caché al volver atrás, se recarga para no mostrar datos viejos
  window.addEventListener("pageshow", function (evento) {
    if (evento.persisted) {
      window.location.reload();
    }
  });
})();
