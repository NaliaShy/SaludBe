<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "TU_CORREO@gmail.com";
    $mail->Password = "TU_CONTRASEÑA_APP";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("no-reply@saludbe.com", "Prueba");
    $mail->addAddress("TU_CORREO@gmail.com");

    $mail->isHTML(true);
    $mail->Subject = "Correo de prueba";
    $mail->Body = "<h1>PHPMailer funciona!</h1>";

    $mail->send();
    echo "Correo enviado correctamente";
} catch (Exception $e) {
    echo "ERROR: " . $mail->ErrorInfo;
}
