<?php
require_once "../Conexion/Conexion.php";
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
    // Por seguridad hacemos como si sí existiera
    echo "ok";
    exit;
}

$user = $query->fetch(PDO::FETCH_ASSOC);
$user_id = $user['Us_id'];

// Generar token
$code = random_int(100000, 999999);
$expira = date("Y-m-d H:i:s", time() + 600);

// Guardar token en BD
$update = $db->prepare("
    UPDATE usuarios 
    SET Us_reset_token = ?, Us_reset_expira = ?
    WHERE Us_id = ?
");
$update->execute([$code, $expira, $user_id]);

// --- CONFIGURAR PHPMailer ---
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;

    // TU CORREO Y CONTRASEÑA DE APP
    $mail->Username = "Edgarcastellanoniebles@gmail.com";
    $mail->Password = "mvfercxlfgfsehqo";

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // QUIÉN ENVÍA EL CORREO
    $mail->setFrom("Edgarcastellanoniebles@gmail.com", "SaludBe");

    // A QUIÉN SE LE ENVÍA (USUARIO)
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Código de recuperación - SaludBe";
    $mail->Body = "
        <h2>Tu código de recuperación es:</h2>
        <h1 style='font-size: 40px;'>$code</h1>
        <p>Tu código expira en 10 minutos.</p>
    ";

    $mail->send();

    session_start();
    $_SESSION['reset_email'] = $email;

    echo "ok";

} catch (Exception $e) {
    echo "error_mail: " . $mail->ErrorInfo;
}
