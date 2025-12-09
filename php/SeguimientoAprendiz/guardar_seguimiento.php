<?php
// archivo: ../../php/SeguimientoAprendiz/guardar_seguimiento.php

include_once '../Conexion/Conexion.php';
session_start();

header('Content-Type: application/json');

// 1. Verificación de sesión (Psicólogo)
if (!isset($_SESSION['Us_id'])) {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado: Sesión no iniciada.']);
    exit();
}

// Variables que vienen del formulario (POST)
$idAprendiz = isset($_POST['id_aprendiz']) ? $_POST['id_aprendiz'] : null; // Se usa para verificación y respuesta
$detalleSeguimiento = isset($_POST['detalle_seguimiento']) ? trim($_POST['detalle_seguimiento']) : null;
$idCita = (isset($_POST['id_cita']) && !empty($_POST['id_cita'])) ? $_POST['id_cita'] : null;

// 2. Validación de datos obligatorios
// Ya que la tabla 'seguimiento' en la DB requiere id_cita, lo hacemos obligatorio aquí.
// El id_aprendiz lo necesitamos para la respuesta al JS, pero no en el INSERT.
if (!$idAprendiz || empty($detalleSeguimiento) || empty($idCita)) {
    echo json_encode(['success' => false, 'message' => '❌ Faltan datos obligatorios (Aprendiz, Detalle, o ID de Cita).']);
    exit();
}

try {
    $db = new Conexion();
    $conexion = $db->getConnect();

    // ⭐ CORRECCIÓN SQL: Solo usamos columnas que existen en tu tabla 'seguimiento'
    // Mapeamos 'detalle_seguimiento' (del formulario) a 'descripcion' (de la DB)
    // y omitimos 'id_aprendiz' e 'id_psicologo' que NO están en tu tabla.
    $sql = "INSERT INTO seguimiento (id_cita, descripcion, fecha_creacion, estado_seg)
      VALUES (?, ?, NOW(), 1)"; // Asumimos estado_seg = 1 (Activo/Completado)

    $stmt = $conexion->prepare($sql);

    // Solo se necesitan 2 parámetros del formulario (id_cita y descripcion)
    $parametros = [$idCita, $detalleSeguimiento];

    $stmt->execute($parametros);

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => '✅ Seguimiento registrado con éxito.',
            'id_aprendiz' => $idAprendiz // Para que el JS pueda recargar la vista
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo insertar el seguimiento (0 filas afectadas).']);
    }
} catch (PDOException $e) {
    error_log("Error al guardar seguimiento: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => '❌ Error de base de datos: ' . $e->getMessage()]);
}

$conexion = null;
