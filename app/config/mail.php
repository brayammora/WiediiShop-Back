<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class mail
{

  public function __CONSTRUCT()
  { }

  public function SendMail($receiver, $nombre, $data)
  {
      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);

      try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'bryanmora22@gmail.com';                     // SMTP username
        $mail->Password   = 'probm1234';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; 
        $mail->Port       = 587;                                    // TCP port to connect to
        //Recipients
        $mail->setFrom('bryanmora22@gmail.com', 'Wiedii Shop');
        $mail->addAddress($receiver);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail ->CharSet = " ISO-8859-1"; 
        $mail->AddEmbeddedImage(__DIR__ . '/../../src/images/logo.svg', "image1", "logo.svg");
        $mail->Subject = 'Reporte de compras';
        $cuerpo = file_get_contents(__DIR__ . '/../../src/mail.html');
        $cuerpo = str_replace("{{body}}", $data, $cuerpo);
        $cuerpo = str_replace("{{name}}", $nombre, $cuerpo);
        $mail->Body    = utf8_decode($cuerpo);
        

        $mail->send();
        return 'Message has been sent';
      } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }

    
  }
}
