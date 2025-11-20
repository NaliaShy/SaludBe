<?php
session_start();
header('Content-Type: application/json');

include '../Conexion.php';

try {
    $db = new Conexion();
    $conn = $db->getConnect();

    $idUsuario = $_SESSION['us_id'];
    $rol_id = $_SESSION['rol_id'];

    if ($rol_id == 1) {
        // Tomamos todos menos el usuario logueado
        $stmt = $conn->prepare("
        SELECT * FROM usuarios WHERE Rol_id = 2 AND Us_id != :id ORDER BY Us_nombre ASC");
        $stmt->bindParam(':id', $idUsuario);
        $stmt->execute();

    } elseif ($rol_id == 2) {

        $stmt = $conn->prepare("
        SELECT * FROM usuarios WHERE Rol_id = 1 AND Us_id != :id ORDER BY Us_nombre ASC");
        $stmt->bindParam(':id', $idUsuario);
        $stmt->execute();
    }else{ 
        echo json_encode(['error' => 'Rol no válido']);
        exit;
    }
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
