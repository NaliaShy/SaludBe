<?php
require_once "../conexion.php";
require "../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido";
    exit;
}

$conexion = new Conexion();
$db = $conexion->getConnect();

$email = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);

if (!$email) {
    echo "Correo inválido";
    exit;
}

// Buscar usuario
$query = $db->prepare("SELECT Us_id FROM usuarios WHERE Us_correo = ?");
$query->execute([$email]);

if ($query->rowCount() === 0) {
    // Por seguridad devolvemos OK aunque no exista
    echo "ok";
    exit;
}

$user = $query->fetch(PDO::FETCH_ASSOC);
$user_id = $user['Us_id'];

// Generar código
$code = random_int(100000, 999999);
$expira = date("Y-m-d H:i:s", time() + 600);

// Guardar token
$update = $db->prepare("UPDATE usuarios SET Us_reset_token = ?, Us_reset_expira = ? WHERE Us_id = ?");
$update->execute([$code, $expira, $user_id]);

// Enviar correo
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;

    // CONFIGURA ESTO:
    $mail->Username = "Edgarcastellanoniebles@gmail.com";         // <-- tu correo
    $mail->Password = "mvfercxlfgfsehqo";           // <-- tu contraseña de aplicación

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("no-reply@saludbe.com", "SaludBe");
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Código de recuperación - SaludBe";
    $mail->Body = "
        <h2>Tu código de recuperación es:</h2>
        <h1 style='font-size: 40px'>$code</h1>
        <p>Este código vence en 10 minutos.</p>
    ";

    $mail->send();

    // Guardar correo en sesión
    session_start();
    $_SESSION['reset_email'] = $email;

    echo "ok"; // Esto lo captura el JS
} 
catch (Exception $e) {
    echo "error_mail: " . $mail->ErrorInfo;
}
