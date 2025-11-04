<?php
header('Content-Type: application/json');
include 'conexion.php';

$mensaje = $_POST['mensaje'] ?? '';
$us_id = $_POST['us_id'] ?? 1; // Usuario por defecto

if(empty($mensaje)){
    echo json_encode(['success'=>false,'error'=>'Mensaje vacío']);
    exit;
}

try {
    $db = new Conexion();
    $conn = $db->getConnect();

    $stmt = $conn->prepare("INSERT INTO mensaje (Men_contenido, Men_fecha_envio, Us_id) VALUES (:mensaje, NOW(), :us_id)");
    $stmt->bindParam(':mensaje', $mensaje);
    $stmt->bindParam(':us_id', $us_id);
    $stmt->execute();

    echo json_encode(['success'=>true]);
} catch(PDOException $e){
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
?>
