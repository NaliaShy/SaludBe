<?php
header('Content-Type: application/json');
include '../../php/Conexion.php';

try {
    $db = new Conexion();
    $conn = $db->getConnect();

    // Consulta con JOIN para traer el nombre del usuario
    $stmt = $conn->query("
        SELECT 
            m.Men_id,
            m.Men_contenido,
            m.Men_fecha_envio,
            u.Us_nombre AS usuario
        FROM mensaje m
        INNER JOIN usuarios u ON m.Us_id = u.Us_id
        ORDER BY m.Men_id ASC
    ");

    $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($mensajes);

} catch (PDOException $e) {
    echo json_encode(['success'=>false, 'error'=>$e->getMessage()]);
}
?>
