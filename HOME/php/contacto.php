
<?php
session_start();
// Incluir la clase PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


final class Contacto {
    public function EnviarCorreo($correo_destinatario, $asunto_correo, $cuerpo_correo){
        // Creamos una instancia PHPMailer por cada correo a enviar.
        $mail1 = new PHPMailer(true);
        
        try {
            // CORREO PARA EL USUARIO
            // Configuración del servidor SMTP
            $mail1->isSMTP();                                      // Usar SMTP
            $mail1->CharSet    = 'UTF-8';                          // Cambiamos el formato a UTF-8
            $mail1->Host       = 'smtp.gmail.com';                 // Servidor SMTP de Gmail
            $mail1->SMTPAuth   = true;                             // Habilitamos autenticación SMTP
            $mail1->Username   = 'rhythmotune@gmail.com';             // Dirección de correo de Gmail para enviar los correos
            $mail1->Password   = 'oaom mlyi krok aiqi'; // Token generado para ese correo
            $mail1->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Habilitamos encriptación TLS
            $mail1->Port       = 587;                              // Puerto SMTP de Gmail
        
            // Información del remitente y destinatario
            $mail1->setFrom('rhythmotune@rhythmotune.com', 'Rhythmotune');  // Remitente
            $mail1->addAddress($correo_destinatario);     // Destinatario
        
            // Contenido del correo
            $mail1->isHTML(true);                                  // Configuramos el formato del correo en HTML
            $mail1->Subject = $asunto_correo;                         // Asunto
            $mail1->Body    = $cuerpo_correo;              // Cuerpo del correo en HTML
            $mail1->AltBody = $mensajeResumen;                             // Cuerpo del correo en texto plano (sin HTML)
        
            // Enviamos el correo.
            $mail1->send();
        
            // Si todo ha salido bien, le mostramos al usuario que se han enviado.
            header('Location: altausuario.html');
        } catch (Exception $e) {
            // Si todo ha salido mal, le mostramos al usuario que algo ha salido mal.
            header('Location: altausuario.html');
        }
    }
}
?>