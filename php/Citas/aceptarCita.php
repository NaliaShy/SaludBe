<?php
// Script para actualizar el estado de una cita de 'Pendiente' a 'Aceptada'
// ¡IMPORTANTE! Este script ahora devuelve una respuesta JSON.

include '../Conexion.php'; // Ajusta la ruta a tu archivo de conexión
session_start();

// 1. Establecer el encabezado de respuesta a JSON
header('Content-Type: application/json');

// 2. Verificar sesión del psicólogo
if (!isset($_SESSION['us_id'])) {
    echo json_encode(['status' => 'error', 'message' => '⚠️ Sesión no iniciada.']);
    exit();
}

// 3. Verificar que se haya enviado el ID de la cita
if (!isset($_POST['idCita'])) {
    echo json_encode(['status' => 'error', 'message' => '❌ ID de Cita no proporcionado.']);
    exit();
}

$idPsicologo = $_SESSION['us_id'];
$idCita = $_POST['idCita'];

try {
    $db = new Conexion();
    $conexion = $db->getConnect();
    
    // Preparar la consulta para actualizar el estado de la cita
    $sql = "UPDATE cita 
            SET estado = 'Aceptada' 
            WHERE Id_Cita = ? AND Id_Psicologo = ? AND estado = 'Pendiente'"; 
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$idCita, $idPsicologo]);
    
    // Verificar si se actualizó alguna fila
    if ($stmt->rowCount() > 0) {
        // Respuesta de éxito
        echo json_encode(['status' => 'success', 'message' => '✅ Cita aceptada correctamente.']);
    } else {
        // Respuesta de advertencia (si la cita no existe o ya estaba aceptada)
        echo json_encode(['status' => 'warning', 'message' => 'ℹ️ La cita no fue modificada. Puede que ya estuviera aceptada.']);
    }
    
} catch (PDOException $e) {
    // Manejo de errores de base de datos
    error_log("Error al aceptar cita: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => '❌ Error de base de datos: ' . $e->getMessage()]);
}

$conexion = null; // Cierra la conexión
?>