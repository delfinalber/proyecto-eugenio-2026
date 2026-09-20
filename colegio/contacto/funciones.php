<?php

// Valores por defecto de respaldo cuando la tabla `contacto` aun no tiene contenido
const BANNER_CONTACTO_POR_DEFECTO = "./img-contacto/banner.png";
const TITULO_CONTACTO_POR_DEFECTO = "Ubicación I.E. Eugenio Ferro Falla";
const URL_MAPA_POR_DEFECTO = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3985.422565702828!2d-75.32341682690004!3d2.6897856558085493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b6aa0fff33cb7%3A0x6578b61850261c46!2sI.E.%20Eugenio%20Ferro%20Falla!5e0!3m2!1ses-419!2sco!4v1785241533403!5m2!1ses-419!2sco";

// Devuelve la URL lista para usar en el iframe del mapa, o "" si no es un mapa embebido de Google Maps.
// Acepta la URL sola o el codigo <iframe ...> completo tal como lo entrega Google Maps.
function urlMapaValida(string $entrada): string
{
    $entrada = trim($entrada);

    if (preg_match('/<iframe[^>]*\ssrc\s*=\s*["\']([^"\']+)["\']/i', $entrada, $coincidencia)) {
        $entrada = html_entity_decode($coincidencia[1], ENT_QUOTES, "UTF-8");
    }

    $partes = parse_url($entrada);
    if (
        $partes === false
        || ($partes["scheme"] ?? "") !== "https"
        || ($partes["host"] ?? "") !== "www.google.com"
        || strpos($partes["path"] ?? "", "/maps/embed") !== 0
    ) {
        return "";
    }

    return $entrada;
}
