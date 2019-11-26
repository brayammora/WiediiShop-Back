<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class mail
{

  public function __CONSTRUCT()
  { }

  public function SendMail($receiver, $data)
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
        $mail->Password   = 'secret';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; 
        $mail->Port       = 587;                                    // TCP port to connect to
        //Recipients
        $mail->setFrom('bryanmora22@gmail.com', 'Wiedii Shop');
        $mail->addAddress($receiver);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Reporte de compras';
        $mail->Body    = '<b>Reporte de compras</b>';

        $mail->send();
        return 'Message has been sent';
      } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }

    
  }
}
