<?php

require_once __DIR__ . "/comun.php";

cabecerasSinCache();

// Se usa desde el boton "Cerrar sesión" de los paneles (POST) y al agotarse el contador de login (GET)
$pagina = paginaLogin($_REQUEST["origen"] ?? null);

cerrarSesionYVolver($pagina["publica"]);
exit();
