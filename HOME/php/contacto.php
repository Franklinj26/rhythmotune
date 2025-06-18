
<?php
session_start();
// Incluir la clase PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';

// Creamos una instancia PHPMailer por cada correo a enviar.
$mail1 = new PHPMailer(true);

try {
    // CORREO PARA EL USUARIO
    // Configuración del servidor SMTP
    $mail1->isSMTP();                                      // Usar SMTP
    $mail1->CharSet    = 'UTF-8';                          // Cambiamos el formato a UTF-8
    $mail1->Host       = 'smtp.gmail.com';                 // Servidor SMTP de Gmail
    $mail1->SMTPAuth   = true;                             // Habilitamos autenticación SMTP
    $mail1->Username   = 'tucorreo@gmail.com';             // Dirección de correo de Gmail para enviar los correos
    $mail1->Password   = 'contraseña de app con espacios'; // Token generado para ese correo
    $mail1->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Habilitamos encriptación TLS
    $mail1->Port       = 587;                              // Puerto SMTP de Gmail

    // Información del remitente y destinatario
    $mail1->setFrom('tucorreo@tudominio.com', 'NombreApp');  // Remitente
    $mail1->addAddress("dirección_a_la_que_enviar@gmail.com");     // Destinatario

    // Contenido del correo
    $mail1->isHTML(true);                                  // Configuramos el formato del correo en HTML
    $mail1->Subject = "Asunto de ejemplo";                         // Asunto
    $mail1->Body    = "Cuerpo del correo de ejemplo";              // Cuerpo del correo en HTML
    $mail1->AltBody = $mensajeResumen;                             // Cuerpo del correo en texto plano (sin HTML)

    // Enviamos el correo.
    $mail1->send();

    // Si todo ha salido bien, le mostramos al usuario que se han enviado.
    header('Location: ../respuestas/CorreoEnviado.php');
} catch (Exception $e) {
    // Si todo ha salido mal, le mostramos al usuario que algo ha salido mal.
    header('Location: ../respuestas/CorreoFallido.php');
}
?>