<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';


function enviarCorreoRecuperacion($correo, $nombre, $token) {

    $mail = new PHPMailer(true);

    try {

        // Configuración SMTP de Gmail
        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = 'uruguayahk@gmail.com';

        $mail->Password = 'naot asfi mujo anea';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = 587;


        // Remitente
        $mail->setFrom(
            'uruguayahk@gmail.com',
            'AHK-Uruguay'
        );


        // Destinatario
        $mail->addAddress($correo, $nombre);


        // Asunto
        $mail->Subject = 'Recuperación de contraseña - AHK-Uruguay';


        // Crear enlace
        $enlace = 'http://localhost/gestion_ahk/restablecer_contrasena.html?token='
                  . urlencode($token);


        // Contenido HTML
        $mail->isHTML(true);

        $mail->Body = '

            <h2>AHK-Uruguay</h2>

            <p>Hola <strong>' . htmlspecialchars($nombre) . '</strong>.</p>

            <p>
                Recibimos una solicitud para restablecer
                la contraseña de tu cuenta.
            </p>

            <p>
                Hacé clic en el siguiente botón:
            </p>

            <p>
                <a href="' . $enlace . '"
                   style="
                   display:inline-block;
                   padding:12px 20px;
                   background:#c62828;
                   color:white;
                   text-decoration:none;
                   border-radius:5px;">
                   
                    Restablecer contraseña

                </a>
            </p>

            <p>
                Este enlace será válido durante
                <strong>30 minutos</strong>.
            </p>

            <p>
                Si vos no solicitaste este cambio,
                podés ignorar este correo.
            </p>

            <hr>

            <p>
                AHK-Uruguay
            </p>
        ';


        // Versión de texto plano
        $mail->AltBody =
            "Hola $nombre.\n\n" .
            "Recibimos una solicitud para restablecer " .
            "tu contraseña.\n\n" .
            "Enlace:\n$enlace\n\n" .
            "Este enlace será válido durante 30 minutos.";


        // Enviar
        $mail->send();

        return true;

    } catch (Exception $e) {

        error_log("Error enviando correo: " . $mail->ErrorInfo);

        return false;
    }
}