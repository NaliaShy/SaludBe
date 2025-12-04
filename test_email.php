<?php
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;

    // TU GMAIL
    $mail->Username = "Edgarcastellanoniebles@gmail.com";
    $mail->Password = "mvfercxlfgfsehqo"; // contraseña de app

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // REMITENTE (DEBE SER EXACTAMENTE TU GMAIL)
    $mail->setFrom("Edgarcastellanoniebles@gmail.com", "Prueba SaludBe");

    // A DONDE LO VAS A RECIBIR (PUEDE SER EL MISMO GMAIL)
    $mail->addAddress("lizarazosilvanatalia@gmail.com");

    $mail->isHTML(true);
    $mail->Subject = "PRUEBA DIRECTA PHPMailer";
    $mail->Body = "<h1>Funciona!</h1>";

    $mail->send();
    echo "Correo enviado correctamente";
    
} catch (Exception $e) {
    echo "ERROR EN SMTP: " . $mail->ErrorInfo;
}
