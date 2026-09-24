// Modal para eliminar todas las inasistencias: mismo mecanismo de seguridad
// que el modal de inicio de sesion (auth/login.js) — temporizador de 30s
// avisado tambien al servidor, para que el limite no dependa solo del navegador.
(function () {
  "use strict";

  var DURACION_MS = 30000;

  var modal = document.getElementById("modalEliminarInasistencia");
  var formulario = document.getElementById("formularioEliminarInasistencia");
  var etiquetaTiempo = document.getElementById("tiempoRestanteEliminar");
  var botonConfirmar = document.getElementById("botonConfirmarEliminar");
  var intervalo = null;

  if (!modal || !formulario) {
    return;
  }

  function tiempoAgotado() {
    botonConfirmar.disabled = true;
    formulario.reset();
    var instancia = bootstrap.Modal.getInstance(modal);
    if (instancia) {
      instancia.hide();
    }
  }

  function iniciarTemporizador() {
    var limite = Date.now() + DURACION_MS;
    etiquetaTiempo.textContent = Math.round(DURACION_MS / 1000);
    botonConfirmar.disabled = false;

    // Le avisa al servidor que el modal se abrió, para que también valide los 30 segundos
    fetch("./eliminar_inasistencia.php", {
      method: "POST",
      body: new URLSearchParams({ accion: "abrir" }),
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

  modal.addEventListener("shown.bs.modal", iniciarTemporizador);
  modal.addEventListener("hidden.bs.modal", function () {
    clearInterval(intervalo);
    formulario.reset();
  });

  var modalError = document.getElementById("modalEliminarError");
  if (modalError && new URLSearchParams(window.location.search).get("eliminar_error") === "1") {
    new bootstrap.Modal(modalError).show();
  }

  // Quita ?eliminado=1 / ?eliminar_error=1 de la URL para que no queden en el historial
  if (window.history && window.history.replaceState) {
    window.history.replaceState(null, "", window.location.pathname);
  }
})();
