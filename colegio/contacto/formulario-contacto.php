<?php

require __DIR__ . "/vendor/autoload.php";

$mysqli = new mysqli("localhost", "root", "", "eugenio_pagina_web");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? "";
    $nombre = $_POST["nombre"] ?? "";
    $telefono = $_POST["telefono"] ?? "";
    $texto_area = $_POST["texto_area"] ?? "";

    $stmt = $mysqli->prepare("INSERT INTO formulario_contacto (correo_formulario, nombre_formulario, telefono_formulario, mensaje_formulario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $email, $nombre, $telefono, $texto_area);
    $registroGuardado = $stmt->execute();

    if ($registroGuardado) {
        $destinatario = "delfin.alber@gmail.com";
        $asunto = "Nuevo mensaje desde el formulario de contacto";
        $archivoEntorno = __DIR__ . "/.env";
        $configuracionCorreo = is_file($archivoEntorno)
            ? parse_ini_file($archivoEntorno, false, INI_SCANNER_RAW)
            : [];
        $claveAplicacion = $configuracionCorreo["GMAIL_APP_PASSWORD"] ?? "";

        try {
            if ($claveAplicacion === "") {
                throw new RuntimeException("Falta GMAIL_APP_PASSWORD en el archivo .env.");
            }

            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = $destinatario;
            $mail->Password = $claveAplicacion;
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = "UTF-8";

            $mail->setFrom($destinatario, "Formulario de contacto");
            $mail->addAddress($destinatario);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mail->addReplyTo($email, $nombre);
            }

            $mail->isHTML(false);
            $mail->Subject = $asunto;
            $mail->Body = "Nombre: $nombre\n"
                . "Correo: $email\n"
                . "Telefono: $telefono\n\n"
                . "Mensaje:\n$texto_area";
            $mail->send();
        } catch (Throwable $error) {
            error_log("No se pudo enviar el correo del formulario de contacto: " . $error->getMessage());
        }
    }

    $stmt->close();
    $mysqli->close();
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Location: contacto.html", true, 303);
    exit;
}

?>