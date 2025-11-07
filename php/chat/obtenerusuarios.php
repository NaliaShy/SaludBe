<?php
session_start();
header('Content-Type: application/json');

include '../Conexion.php';

try {
    $db = new Conexion();
    $conn = $db->getConnect();

    $idUsuario = $_SESSION['us_id'];

    // Tomamos todos menos el usuario logueado
    $stmt = $conn->prepare("
        SELECT Us_id, Us_nombre 
        FROM usuarios 
        WHERE Us_id != :id
        ORDER BY Us_nombre ASC
    ");
    $stmt->bindParam(':id', $idUsuario);
    $stmt->execute();

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
