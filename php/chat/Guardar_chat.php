<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$mensaje = $_POST['mensaje'] ?? null;
$us_id = $_POST['us_id'] ?? null;
$destinatario_id = $_POST['destinatario_id'] ?? null;

if (!$mensaje || !$us_id || !$destinatario_id) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos', 'debug' => $_POST]);
    exit;
}

try {
    include '../Conexion/Conexion.php';
    $db = new Conexion();
    $conn = $db->getConnect();

    $stmt = $conn->prepare("
    INSERT INTO mensaje (Men_contenido, Men_fecha_envio, Us_id, destinatario_id)
    VALUES (:mensaje, NOW(), :us_id, :destinatario_id)
");

    $stmt->bindParam(':mensaje', $mensaje);
    $stmt->bindParam(':us_id', $us_id);
    $stmt->bindParam(':destinatario_id', $_POST['destinatario_id']);
    $stmt->execute();;

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
