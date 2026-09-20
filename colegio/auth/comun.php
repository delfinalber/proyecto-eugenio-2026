<?php

require_once __DIR__ . "/sesion.php";

// Segundos que dura la ventana de inicio de sesion (el mismo valor lo muestra el contador de login.js)
const TIEMPO_LOGIN_SEGUNDOS = 30;

// Paginas desde las que se puede iniciar sesion: a donde se vuelve y a donde se entra si el login es correcto
const PAGINAS_LOGIN = [
    "inicio"   => ["publica" => "../inicio/index.php",      "panel" => "../inicio/index-formulario.php"],
    "eventos"  => ["publica" => "../eventos/eventos.php",   "panel" => "../eventos/eventos-formulario.php"],
    "contacto" => ["publica" => "../contacto/contacto.php", "panel" => "../contacto/contacto-formulario.php"],
];

// Solo se aceptan destinos de la lista anterior: el valor recibido nunca se usa directamente en un Location
function paginaLogin($origen): array
{
    return PAGINAS_LOGIN[is_string($origen) ? $origen : ""] ?? PAGINAS_LOGIN["inicio"];
}

function cabecerasSinCache(): void
{
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
}

// Destruye la sesion y pide al navegador que borre cookies, cache y almacenamiento de este sitio
function cerrarSesionYLimpiar(): void
{
    $_SESSION = [];
    $parametrosCookie = session_get_cookie_params();

    // Expira todas las cookies que llegaron en la peticion (y la de sesion, aunque la peticion no la traiga)
    foreach (array_unique(array_merge(array_keys($_COOKIE), [session_name()])) as $nombreCookie) {
        setcookie($nombreCookie, "", [
            "expires"  => time() - 42000,
            "path"     => $parametrosCookie["path"],
            "domain"   => $parametrosCookie["domain"],
            "secure"   => $parametrosCookie["secure"],
            "httponly" => $parametrosCookie["httponly"],
            "samesite" => "Lax",
        ]);
    }

    session_destroy();
    header('Clear-Site-Data: "cache", "cookies", "storage"');
}

// Cierra la sesion, limpia el navegador y vuelve a $destino (una ruta ya validada por paginaLogin).
// Se responde con una pagina intermedia en vez de un redirect para poder limpiar tambien desde JavaScript
// (almacenamiento, cache y service workers) aunque el navegador ignore Clear-Site-Data, y para volver con
// location.replace, que no deja esta pagina en el historial.
function cerrarSesionYVolver(string $destino): void
{
    cerrarSesionYLimpiar();

    $banderas = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
    $destinoJs = json_encode($destino, $banderas);
    $destinoHtml = htmlspecialchars($destino, ENT_QUOTES, "UTF-8");

    header("Content-Type: text/html; charset=UTF-8");
    echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Cerrando sesión...</title>
    <noscript><meta http-equiv="refresh" content="1;url={$destinoHtml}"></noscript>
    <style>
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #0b4f43; color: #f5f9fb; font-family: "Segoe UI", sans-serif; }
    </style>
</head>
<body>
    <p>Cerrando sesión...</p>
    <script>
    (function () {
      var destino = {$destinoJs};
      var yaSalio = false;

      function salir() {
        if (yaSalio) { return; }
        yaSalio = true;
        window.location.replace(destino);
      }

      function silenciar(promesa) {
        return Promise.resolve(promesa).catch(function () {});
      }

      try { window.localStorage.clear(); } catch (e) {}
      try { window.sessionStorage.clear(); } catch (e) {}

      var tareas = [];

      if (window.caches && caches.keys) {
        tareas.push(silenciar(caches.keys().then(function (nombres) {
          return Promise.all(nombres.map(function (nombre) { return caches.delete(nombre); }));
        })));
      }

      if (window.indexedDB && indexedDB.databases) {
        tareas.push(silenciar(indexedDB.databases().then(function (bases) {
          bases.forEach(function (base) { indexedDB.deleteDatabase(base.name); });
        })));
      }

      if (navigator.serviceWorker && navigator.serviceWorker.getRegistrations) {
        tareas.push(silenciar(navigator.serviceWorker.getRegistrations().then(function (registros) {
          return Promise.all(registros.map(function (registro) { return registro.unregister(); }));
        })));
      }

      Promise.all(tareas).then(salir);
      // Si alguna limpieza se cuelga, igual se sale de la pagina
      setTimeout(salir, 1500);
    })();
    </script>
</body>
</html>
HTML;
}
