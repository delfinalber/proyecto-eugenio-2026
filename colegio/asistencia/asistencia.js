// Comportamiento del panel de asistencia: reutiliza un unico modal para crear y editar registros
(function () {
  "use strict";

  var modal = document.getElementById("modalRegistro");
  if (!modal) {
    return;
  }

  var titulo = document.getElementById("modalRegistroLabel");
  var botonGuardar = document.getElementById("botonGuardarRegistro");
  var campoAccion = modal.querySelector('[name="accion"]');
  var campoId = modal.querySelector('[name="id_asistencia"]');
  var campoDocumento = modal.querySelector('[name="documento_asistencia"]');
  var campoNombre = modal.querySelector('[name="nombre_asistencia"]');
  var campoGrado = modal.querySelector('[name="grado_asistencia"]');
  var campoJornada = modal.querySelector('[name="jornada_asistencia"]');
  var campoTelefono = modal.querySelector('[name="telefino_asistencia"]');

  function abrirCrear() {
    titulo.textContent = "Crear registro de asistencia";
    campoAccion.value = "guardar";
    campoId.value = "";
    campoDocumento.value = "";
    campoNombre.value = "";
    campoGrado.value = "";
    campoJornada.value = "";
    campoTelefono.value = "";
    botonGuardar.textContent = "Crear registro";
  }

  function abrirEditar(boton) {
    titulo.textContent = "Editar registro de asistencia";
    campoAccion.value = "editar";
    campoId.value = boton.dataset.id || "";
    campoDocumento.value = boton.dataset.documento || "";
    campoNombre.value = boton.dataset.nombre || "";
    campoGrado.value = boton.dataset.grado || "";
    campoJornada.value = boton.dataset.jornada || "";
    campoTelefono.value = boton.dataset.telefono || "";
    botonGuardar.textContent = "Guardar cambios";
  }

  document.querySelectorAll(".btn-nuevo-registro").forEach(function (boton) {
    boton.addEventListener("click", abrirCrear);
  });

  document.querySelectorAll(".btn-editar-registro").forEach(function (boton) {
    boton.addEventListener("click", function () {
      abrirEditar(boton);
    });
  });

  // Modal "Registrar inasistencia": busca al estudiante por documento en la tabla
  // `asistencia` y, si existe, habilita el boton para registrar la inasistencia.
  var modalInasistencia = document.getElementById("modalInasistencia");
  if (modalInasistencia) {
    var campoDocumentoBusqueda = document.getElementById("inasistencia-documento");
    var campoDocumentoOculto = document.getElementById("inasistencia-documento-oculto");
    var bloqueResultado = document.getElementById("inasistenciaResultado");
    var campoNombreResultado = document.getElementById("inasistencia-nombre");
    var campoGradoResultado = document.getElementById("inasistencia-grado");
    var campoJornadaResultado = document.getElementById("inasistencia-jornada");
    var mensajeInasistencia = document.getElementById("inasistenciaMensaje");
    var botonBuscarEstudiante = document.getElementById("botonBuscarEstudiante");
    var botonRegistrarInasistencia = document.getElementById("botonRegistrarInasistencia");

    function resetearBusquedaInasistencia() {
      bloqueResultado.classList.add("d-none");
      mensajeInasistencia.textContent = "";
      botonRegistrarInasistencia.disabled = true;
      campoDocumentoOculto.value = "";
    }

    modalInasistencia.addEventListener("show.bs.modal", function () {
      campoDocumentoBusqueda.value = "";
      resetearBusquedaInasistencia();
    });

    function buscarEstudiante() {
      var documento = campoDocumentoBusqueda.value.trim();
      resetearBusquedaInasistencia();

      if (documento === "") {
        mensajeInasistencia.textContent = "Escribe un número de documento.";
        return;
      }

      fetch("./buscar_estudiante.php?documento=" + encodeURIComponent(documento))
        .then(function (respuesta) {
          return respuesta.json();
        })
        .then(function (datos) {
          if (!datos.encontrado) {
            mensajeInasistencia.textContent = datos.error || "No se encontró ningún estudiante con ese documento.";
            return;
          }
          campoNombreResultado.textContent = datos.nombre;
          campoGradoResultado.textContent = datos.grado;
          campoJornadaResultado.textContent = datos.jornada;
          bloqueResultado.classList.remove("d-none");
          campoDocumentoOculto.value = documento;
          botonRegistrarInasistencia.disabled = false;
        })
        .catch(function () {
          mensajeInasistencia.textContent = "No se pudo consultar el estudiante. Intenta de nuevo.";
        });
    }

    botonBuscarEstudiante.addEventListener("click", buscarEstudiante);
    campoDocumentoBusqueda.addEventListener("keydown", function (evento) {
      if (evento.key === "Enter") {
        evento.preventDefault();
        buscarEstudiante();
      }
    });
  }
})();
