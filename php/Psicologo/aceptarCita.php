<?php
// Script para actualizar el estado de una cita de 'Pendiente' a 'Aceptada'
include '../Conexion.php'; // Ajusta la ruta a tu archivo de conexión
session_start();

// 1. Verificar sesión del psicólogo
if (!isset($_SESSION['us_id'])) {
    // Redirige o muestra un error si no hay sesión
    header("Location: ../../Html/Login/login.html");
    exit();
}

// 2. Verificar que se haya enviado el ID de la cita
if (!isset($_POST['idCita'])) {
    // Si no viene el ID de la cita, redirige con un mensaje de error
    header("Location: ../../Html/Psicologo/calendarioPsicologo.php?error=no_cita_id");
    exit();
}

$idPsicologo = $_SESSION['us_id'];
$idCita = $_POST['idCita'];

try {
    $db = new Conexion();
    $conexion = $db->getConnect();
    
    // Preparar la consulta para actualizar el estado de la cita
    // Se incluye Id_Psicologo para asegurar que solo el psicólogo dueño de la cita pueda aceptarla
    $sql = "UPDATE cita 
            SET estado = 'Aceptada' 
            WHERE Id_Cita = ? AND Id_Psicologo = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$idCita, $idPsicologo]);
    
    // Verificar si se actualizó alguna fila
    if ($stmt->rowCount() > 0) {
        // Redirigir al calendario con mensaje de éxito
        header("Location: ../../Html/Psicologo/calendarioPsicologo.php?success=cita_aceptada");
    } else {
        // Puede que la cita ya estuviera aceptada o el ID de la cita/psicólogo no coincida
        header("Location: ../../Html/Psicologo/calendarioPsicologo.php?warning=cita_no_actualizada");
    }
    
} catch (PDOException $e) {
    // Manejo de errores de base de datos
    error_log("Error al aceptar cita: " . $e->getMessage());
    header("Location: ../../Html/Psicologo/calendarioPsicologo.php?error=db_error");
}

$conexion = null; // Cierra la conexión
?>