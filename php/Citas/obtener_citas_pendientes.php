<?php
// archivo: ../../php/Citas/obtener_citas_pendientes.php

include_once '../Conexion/Conexion.php'; 
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['Us_id'])) {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado.']);
    exit();
}

$idPsicologo = $_SESSION['Us_id'];
$idAprendiz = isset($_GET['id_aprendiz']) ? $_GET['id_aprendiz'] : null;

if (!$idAprendiz) {
    echo json_encode(['success' => false, 'message' => 'ID de aprendiz requerido.']);
    exit();
}

try {
    $db = new Conexion();
    $conexion = $db->getConnect();
    
    // Busca citas Aceptadas y Pendientes entre este Psicólogo y este Aprendiz
    $sql = "SELECT IdCita, Fecha, Hora, Estado ,Motivo, Id_Usuario as id_aprendiz, Id_Psicologo
            FROM cita 
            WHERE Id_Usuario = ? 
              AND Id_psicologo = ? 
              AND Estado IN ('Aceptada', 'Pendiente')
            ORDER BY Fecha DESC, Hora DESC";
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$idAprendiz, $idPsicologo]);
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true, 
        'citas' => $citas
    ]);

} catch (PDOException $e) {
    error_log("Error al obtener citas: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error de base de datos.']);
}

$conexion = null;
?>