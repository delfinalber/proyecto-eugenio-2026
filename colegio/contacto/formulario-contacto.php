<?php

// Recibe el formulario de contacto de contacto.php: valida los datos, los guarda en la tabla
// formulario_contacto y avisa por correo. Siempre responde con una redireccion a contacto.php.

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . "/conexion.php";

const LONGITUD_MAXIMA_CORREO = 200;
const LONGITUD_MAXIMA_NOMBRE = 200;
const LONGITUD_MAXIMA_MENSAJE = 500;

// Falta la configuracion necesaria para enviar el correo (por ejemplo la clave en el archivo .env)
class ConfiguracionCorreoException extends RuntimeException
{
}

// $estado: ok | invalido | error (contacto.php lo muestra en un modal)
function volverAContacto(string $estado): void
{
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Location: contacto.php" . ($estado !== "" ? "?contacto=" . $estado : ""), true, 303);
}

// Responde al visitante de inmediato y deja que el script siga trabajando: el envio SMTP puede tardar
// varios segundos y el visitante no tiene por que esperarlo.
function responderYContinuar(string $estado): void
{
    ignore_user_abort(true);
    set_time_limit(60);

    volverAContacto($estado);
    header("Content-Length: 0");
    header("Connection: close");

    while (ob_get_level() > 0) {
        ob_end_flush();
    }
    flush();
    if (function_exists("fastcgi_finish_request")) {
        fastcgi_finish_request();
    }
}

// Devuelve el texto limpio, o null si no es texto UTF-8 valido (evita guardar caracteres corruptos)
function limpiarTexto(mixed $valor, bool $variasLineas = false): ?string
{
    if (!is_string($valor) || !mb_check_encoding($valor, "UTF-8")) {
        return null;
    }

    $valor = str_replace(["\r\n", "\r"], "\n", $valor);

    if ($variasLineas) {
        // Conserva saltos de linea y tabulaciones, quita el resto de caracteres de control
        return trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', "", $valor));
    }

    // Campos de una sola linea: los saltos de linea (tambien usados para inyectar cabeceras de correo) pasan a espacio
    return trim(preg_replace('/\s+/u', " ", preg_replace('/[\x00-\x1F\x7F]/u', " ", $valor)));
}

function enviarCorreoContacto(string $correo, string $nombre, string $telefono, string $mensaje): void
{
    $destinatario = "delfin.alber@gmail.com";
    $archivoEntorno = __DIR__ . "/.env";
    $configuracionCorreo = is_file($archivoEntorno)
        ? parse_ini_file($archivoEntorno, false, INI_SCANNER_RAW)
        : [];
    $claveAplicacion = $configuracionCorreo["GMAIL_APP_PASSWORD"] ?? "";

    try {
        if ($claveAplicacion === "") {
            throw new ConfiguracionCorreoException("Falta GMAIL_APP_PASSWORD en el archivo .env.");
        }

        require_once __DIR__ . "/vendor/autoload.php";

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = $destinatario;
        $mail->Password = $claveAplicacion;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        // Por defecto PHPMailer espera hasta 300 s si el servidor SMTP no responde
        $mail->Timeout = 15;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->Encoding = PHPMailer::ENCODING_BASE64;

        $mail->setFrom($destinatario, "Formulario de contacto");
        $mail->addAddress($destinatario);
        $mail->addReplyTo($correo, $nombre);

        $mail->isHTML(false);
        $mail->Subject = "Nuevo mensaje desde el formulario de contacto";
        $mail->Body = "Nombre: $nombre\n"
            . "Correo: $correo\n"
            . "Telefono: " . ($telefono !== "" ? $telefono : "(no indicado)") . "\n\n"
            . "Mensaje:\n$mensaje";
        $mail->send();
    } catch (Throwable $error) {
        error_log("No se pudo enviar el correo del formulario de contacto: " . $error->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    volverAContacto("");
    exit();
}

$correo = limpiarTexto($_POST["email"] ?? "");
$nombre = limpiarTexto($_POST["nombre"] ?? "");
$telefono = limpiarTexto($_POST["telefono"] ?? "");
$mensaje = limpiarTexto($_POST["texto_area"] ?? "", true);

// El telefono se guarda solo con digitos (y un + inicial opcional), sin espacios, guiones ni parentesis
$telefono = $telefono === null ? null : preg_replace('/[\s().-]/', "", $telefono);

$datosValidos = $correo !== null && $nombre !== null && $telefono !== null && $mensaje !== null
    && $correo !== "" && mb_strlen($correo) <= LONGITUD_MAXIMA_CORREO && filter_var($correo, FILTER_VALIDATE_EMAIL) !== false
    && $nombre !== "" && mb_strlen($nombre) <= LONGITUD_MAXIMA_NOMBRE
    && ($telefono === "" || preg_match('/^\+?\d{7,15}$/', $telefono) === 1)
    && $mensaje !== "" && mb_strlen($mensaje) <= LONGITUD_MAXIMA_MENSAJE;

if (!$datosValidos) {
    volverAContacto("invalido");
    exit();
}

try {
    // Consulta preparada: los datos del visitante nunca se concatenan en el SQL
    $stmt = $mysqli->prepare("INSERT INTO formulario_contacto (correo_formulario, nombre_formulario, telefono_formulario, mensaje_formulario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $correo, $nombre, $telefono, $mensaje);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
} catch (mysqli_sql_exception $error) {
    error_log("No se pudo guardar el formulario de contacto: " . $error->getMessage());
    volverAContacto("error");
    exit();
}

// El mensaje ya esta guardado: se responde al visitante y despues se envia el correo
responderYContinuar("ok");
enviarCorreoContacto($correo, $nombre, $telefono, $mensaje);
