// Comportamiento común de los paneles de edición (index-formulario, eventos-formulario y contacto-formulario)
(function () {
  "use strict";

  // Sustituye la entrada actual del historial por la URL limpia: no se agrega ninguna entrada nueva
  if (window.history && window.history.replaceState) {
    window.history.replaceState(null, "", window.location.pathname);
  }

  // Si el navegador restaura el panel desde su caché al volver atrás (por ejemplo tras cerrar sesión),
  // se recarga para que el servidor vuelva a comprobar la sesión
  window.addEventListener("pageshow", function (evento) {
    if (evento.persisted) {
      window.location.reload();
    }
  });
})();
