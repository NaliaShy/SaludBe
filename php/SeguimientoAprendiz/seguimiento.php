<?php

include_once '../Conexion/Conexion.php';

session_start();
$db = new Conexion();
// La variable de conexión es $conn, ya que así la definiste
$conn = $db->getConnect();

// ID del Aprendiz consultado (Viene del JavaScript como 'id_aprendiz')
$idAprendiz = $_GET['id_aprendiz'] ?? null; 

// Opcional: ID del Psicólogo que tiene la sesión iniciada
$idPsicologoSesion = $_SESSION['Us_id'] ?? null; // Intentando usar: 'Us_id'

// Verificar que se haya proporcionado el ID del Aprendiz (evita el 400 Bad Request)
if (!$idAprendiz) {
    http_response_code(400); 
    echo json_encode(['success' => false, 'error' => 'ID de aprendiz no proporcionado.']);
    exit;
}

try {
   

    // 3. Consulta SQL (la versión que proporcionaste)
    $sql = "
        select s.id_seguimiento,
            s.descripcion AS detalle_seguimiento,
            s.fecha_creacion,
            s.fecha_actualizacion,
            s.estado_seg,
            c.Fecha AS fecha_cita,
            c.Hora AS hora_cita,
            c.Motivo AS motivo_cita,
            (select u.Us_nombre from usuarios u where u.Us_id = ?) as nombre_psicologo,
            (select u.Us_apellios from usuarios u where u.Us_id = ?) as apellido_psicologo
            from cita c
        join seguimiento s on c.IdCita = s.id_cita
        join usuarios u on c.Id_Usuario = u.Us_id
        where u.Us_id = ? and c.Id_psicologo = ?
    "; 
    
    // 4. CREAR EL ARRAY DE PARÁMETROS EN EL ORDEN CORRECTO
    $params = [
        $idPsicologoSesion, // 1º ? -> Nombre del psicólogo (subconsulta)
        $idPsicologoSesion, // 2º ? -> Apellido del psicólogo (subconsulta)
        $idAprendiz,        // 3º ? -> Filtro del Aprendiz (where u.Us_id = ?)
        $idPsicologoSesion  // 4º ? -> Filtro del Psicólogo (where c.Id_psicologo = ?)
    ];
    
    // Ejecutar con el array de parámetros completo
    $stmt = $conn->prepare($sql);
    $stmt->execute($params); 
    
    $seguimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 5. Devolver los resultados en formato JSON
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $seguimientos,
        'count' => count($seguimientos),
        'id_psicologo_sesion' => $idPsicologoSesion,
        'message' => 'Seguimientos obtenidos correctamente para el Aprendiz ID: ' . $idAprendiz
    ]);

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false,
        'error' => 'Error de la base de datos (PDO): ' . $e->getMessage() . 
                 ' | Verifique que los 4 parámetros de execute() coincidan con los 4 marcadores.'
    ]);
}
?>