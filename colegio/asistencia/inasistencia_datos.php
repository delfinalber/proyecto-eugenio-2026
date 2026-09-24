<?php

// Funciones compartidas para consultar y filtrar la tabla `inasistencia`.
// Las usan tanto inasistencia.php (listado en pantalla) como
// inasistencia_imprimir.php (reporte para imprimir/PDF), asi ambas paginas
// filtran siempre exactamente igual.

function gradosValidosAsistencia(): array
{
    $grados = [];
    for ($g = 6; $g <= 11; $g++) {
        for ($s = 1; $s <= 3; $s++) {
            $grados[] = $g . "0" . $s;
        }
    }
    return $grados;
}

function jornadasValidasAsistencia(): array
{
    return ["Mañana", "Tarde"];
}

/**
 * true si $fecha viene en formato YYYY-MM-DD y es una fecha real.
 */
function esFechaValida(string $fecha): bool
{
    if ($fecha === "") {
        return false;
    }
    $d = DateTime::createFromFormat("Y-m-d", $fecha);
    return $d !== false && $d->format("Y-m-d") === $fecha;
}

/**
 * Lee los filtros de grado, jornada, busqueda (documento o nombre) y rango de
 * fechas, los valida y devuelve tanto los valores normalizados como los
 * registros de `inasistencia` que cumplen esos filtros.
 */
function filtrarInasistencia(mysqli $mysqli, array $parametrosGet): array
{
    $gradosValidos = gradosValidosAsistencia();
    $jornadasValidas = jornadasValidasAsistencia();

    $filtroGrado = trim($parametrosGet["grado"] ?? "");
    $filtroJornada = trim($parametrosGet["jornada"] ?? "");
    $filtroTexto = trim($parametrosGet["buscar"] ?? "");
    $filtroFechaDesde = trim($parametrosGet["fecha_desde"] ?? "");
    $filtroFechaHasta = trim($parametrosGet["fecha_hasta"] ?? "");

    if (!in_array($filtroGrado, $gradosValidos, true)) {
        $filtroGrado = "";
    }
    if (!in_array($filtroJornada, $jornadasValidas, true)) {
        $filtroJornada = "";
    }
    if (!esFechaValida($filtroFechaDesde)) {
        $filtroFechaDesde = "";
    }
    if (!esFechaValida($filtroFechaHasta)) {
        $filtroFechaHasta = "";
    }
    // Si el rango viene invertido, se intercambian para que la consulta tenga sentido
    if ($filtroFechaDesde !== "" && $filtroFechaHasta !== "" && $filtroFechaDesde > $filtroFechaHasta) {
        [$filtroFechaDesde, $filtroFechaHasta] = [$filtroFechaHasta, $filtroFechaDesde];
    }

    $condiciones = [];
    $parametros = [];
    $tipos = "";

    if ($filtroGrado !== "") {
        $condiciones[] = "grado_inasistencia = ?";
        $parametros[] = $filtroGrado;
        $tipos .= "s";
    }
    if ($filtroJornada !== "") {
        $condiciones[] = "jornada_inasistencia = ?";
        $parametros[] = $filtroJornada;
        $tipos .= "s";
    }
    if ($filtroTexto !== "") {
        // El documento se compara solo por digitos: si se pega con puntos, espacios o
        // guiones, igual debe encontrar el registro guardado (mismo criterio que asistencia.php).
        $documentoBuscado = preg_replace('/\D+/', '', $filtroTexto);
        $comodinNombre = "%$filtroTexto%";

        if ($documentoBuscado !== "") {
            $condiciones[] = "(nombre_inasistencia LIKE ? OR documento_inasistencia LIKE ?)";
            $parametros[] = $comodinNombre;
            $parametros[] = "%$documentoBuscado%";
            $tipos .= "ss";
        } else {
            $condiciones[] = "nombre_inasistencia LIKE ?";
            $parametros[] = $comodinNombre;
            $tipos .= "s";
        }
    }
    if ($filtroFechaDesde !== "") {
        $condiciones[] = "fecha_inasistencia >= ?";
        $parametros[] = $filtroFechaDesde . " 00:00:00";
        $tipos .= "s";
    }
    if ($filtroFechaHasta !== "") {
        $condiciones[] = "fecha_inasistencia <= ?";
        $parametros[] = $filtroFechaHasta . " 23:59:59";
        $tipos .= "s";
    }

    $sql = "SELECT * FROM inasistencia";
    if ($condiciones !== []) {
        $sql .= " WHERE " . implode(" AND ", $condiciones);
    }
    $sql .= " ORDER BY grado_inasistencia ASC, nombre_inasistencia ASC LIMIT 2000";

    $stmt = $mysqli->prepare($sql);
    if ($parametros !== []) {
        $stmt->bind_param($tipos, ...$parametros);
    }
    $stmt->execute();
    $registros = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return [
        "registros"       => $registros,
        "grado"           => $filtroGrado,
        "jornada"         => $filtroJornada,
        "buscar"          => $filtroTexto,
        "fechaDesde"      => $filtroFechaDesde,
        "fechaHasta"      => $filtroFechaHasta,
        "gradosValidos"   => $gradosValidos,
        "jornadasValidas" => $jornadasValidas,
    ];
}
