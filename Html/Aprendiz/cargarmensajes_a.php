<?php
header('Content-Type: application/json');
include 'conexion.php';

try {
    $db = new Conexion();
    $conn = $db->getConnect();

    $stmt = $conn->prepare("SELECT * FROM mensaje ORDER BY Men_fecha_envio ASC");
    $stmt->execute();
    $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($mensajes);
} catch(PDOException $e){
    echo json_encode(['error'=>$e->getMessage()]);
}
?>
