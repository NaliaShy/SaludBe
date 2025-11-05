<?php
header('Content-Type: application/json');
include '../../php/Conexion.php';

try {
    $db = new Conexion();
    $conn = $db->getConnect();

    $stmt = $conn->query("SELECT Men_id, Men_contenido, Men_fecha_envio, Us_id FROM mensaje ORDER BY Men_id ASC");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($rows);
} catch (PDOException $e) {
    echo json_encode(['success'=>false, 'error'=>$e->getMessage()]);
}
?>