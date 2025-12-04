<?php
session_start();
require_once "../Conexion/Conexion.php";  // ← RUTA CORREGIDA

if (!isset($_SESSION['reset_email'])) {
    echo "sin_correo";
    exit;
}

$email = $_SESSION['reset_email'];

$conexion = new Conexion();
$db = $conexion->getConnect();

// Leer código enviado desde AJAX
$codigo = $_POST['codigo'] ?? '';

if (strlen($codigo) !== 6) {
    echo "codigo_invalido";
    exit;
}

// Buscar token en BD
$query = $db->prepare("
    SELECT Us_reset_token, Us_reset_expira 
    FROM usuarios 
    WHERE Us_correo = ?
");
$query->execute([$email]);
$data = $query->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "no_user";
    exit;
}

// Verificar expiración
if (strtotime($data['Us_reset_expira']) < time()) {
    echo "expirado";
    exit;
}

// Verificar código
if ($codigo != $data['Us_reset_token']) {
    echo "codigo_incorrecto";
    exit;
}

// Código correcto
echo "ok";
