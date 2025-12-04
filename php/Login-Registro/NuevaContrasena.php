<?php
session_start();
require_once "../Conexion/Conexion.php";

// Asegurarse que existe un correo en sesión
if (!isset($_SESSION['reset_email'])) {
    echo "sin_correo";
    exit;
}

$email = $_SESSION['reset_email'];

// Recibir nueva contraseña
$pass = $_POST['pass'] ?? '';

if (empty($pass)) {
    echo "vacio";
    exit;
}

if (strlen($pass) < 6) {
    echo "muy_corta";
    exit;
}

// Conectar BD
$conexion = new Conexion();
$db = $conexion->getConnect();

// Encriptar contraseña
$hash = password_hash($pass, PASSWORD_DEFAULT);

// Actualizar en BD
$stmt = $db->prepare("
    UPDATE usuarios
    SET 
        Us_contraseña = ?, 
        Us_reset_token = NULL, 
        Us_reset_expira = NULL
    WHERE Us_correo = ?
");

if ($stmt->execute([$hash, $email])) {
    echo "ok";
} else {
    echo "error_bd";
}
