<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';
require 'Correo.php';

// -----------------------------
//        Contacto
// -----------------------------
if (isset($_POST['envio'])) {
    if (!isset($_POST["nombre"], $_POST["email"], $_POST["asunto"], $_POST["mensaje"])) {
        die("<p style='color:#FFF'>❌ Datos incompletos. <a href='../html/contacto.html'>Volver</a></p>");
    }

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    $GestorCorreo = new Correo();
    $GestorCorreo->EnviarCorreo($email, 'Contacto recibido.',
        '<h1>Datos recibidos: </h1>'
        . '<br>Tu nombre: ' . $nombre
        . '<br>Tu correo: ' . $email
        . '<br>Tu asunto: ' . $asunto
        . '<br>Tu mensaje:<br><br> ' . $mensaje
        . '<br><br>¡Gracias por contactar con nosotros! 🤓👆'
    );

    $GestorCorreo->EnviarCorreo('rhythmotune@gmail.com', $asunto, 
        $mensaje
        . '<br><br>Nombre del remitente: ' . $nombre
        . '<br>Correo del remitente: ' . $email
    );

    header("Location: ../html/contacto.html");
}
?>