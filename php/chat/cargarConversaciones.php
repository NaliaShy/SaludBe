<?php
session_start();
header('Content-Type: application/json');

include '../Conexion/Conexion.php';

if (!isset($_SESSION['Us_id'])) {
    echo json_encode([]);
    exit();
}

$yo = $_SESSION['Us_id'];
$otro = $_GET['us2'] ?? null;

if (!$otro) {
    echo json_encode([]);
    exit();
}

try {
    $db = new Conexion();
    $conn = $db->getConnect();

    $stmt = $conn->prepare("
        SELECT 
            m.Men_id,
            m.Men_contenido,
            m.Men_fecha_envio,
            u.Us_nombre AS usuario,
            m.Us_id
        FROM mensaje m
        JOIN usuarios u ON m.Us_id = u.Us_id
        WHERE (m.Us_id = :yo AND m.destinatario_id = :otro)
           OR (m.Us_id = :otro AND m.destinatario_id = :yo)
        ORDER BY m.Men_id ASC
    ");

    $stmt->execute(['yo' => $yo, 'otro' => $otro]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
