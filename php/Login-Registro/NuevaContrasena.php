<?php
session_start();
require_once "../conexion.php";

// Verificar que existe el correo en sesión
if (!isset($_SESSION['reset_email'])) {
    echo "sin_correo";
    exit;
}

$email = $_SESSION['reset_email'];

// Leer nueva contraseña
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

// Actualizar en BD con la columna correcta (Us_contraseña)
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
