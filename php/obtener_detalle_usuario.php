<?php
// CRUCIAL: Asegurarse de que 'conexion.php' no imprima nada (ni siquiera espacios) antes de este punto.
include 'Conexion.php'; 

// CRUCIAL: Esta línea debe ser la primera cosa que se envía al navegador (sin espacios ni warnings antes).
header('Content-Type: application/json'); 

// 1. Validar que se recibió el ID del usuario
if (!isset($_GET['Us_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de usuario no proporcionado.']);
    exit();
}

$userId = $_GET['Us_id'];

try {
    $db = new Conexion();
    $conexion = $db->getConnect();
    
    // 2. Consulta con LEFT JOIN para obtener detalles del usuario
    // Se usa LEFT JOIN para asegurar que el usuario se cargue aunque no tenga registros en 'cita' o 'seguimiento'.
    // Nota: Para simplificar la salida a una sola fila, se usa MAX(s.descripcion)
    $sql = "SELECT 
                u.Us_id, 
                u.Us_nombre, 
                u.Us_apellios, 
                u.Us_correo AS Us_email, 
                u.Us_documento, 
                u.Us_telefono,
                t.Ti_rol AS Tipo_documento, 
                r.Rol_nombre,
                MAX(s.descripcion) AS Ultimo_seguimiento -- Solo devuelve la descripción más 'grande' o la última si no hay ORDER BY
            FROM usuarios u
            JOIN rol_usuario r ON u.Rol_id = r.Rol_id
            JOIN tipo_usuarios t ON u.Ti_id = t.Ti_id
            
            -- LEFT JOINs para evitar que la consulta falle si el usuario no tiene citas o seguimientos.
            LEFT JOIN cita c ON u.Us_id = c.Id_Usuario
            
            -- Asumo que seguimiento se relaciona con cita por el ID de la cita.
            LEFT JOIN seguimiento s ON c.IdCita = s.id_cita 
            
            WHERE u.Us_id = ? AND u.Rol_id = 1
            GROUP BY u.Us_id"; // Agrupamos por usuario para usar MAX() y asegurar una fila única.
            
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$userId]); 
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // 3. Devolver la respuesta
    if ($user) {
        // Si el seguimiento es NULL, lo convertimos a un mensaje legible
        if ($user['Ultimo_seguimiento'] === null) {
            $user['Ultimo_seguimiento'] = 'Sin seguimientos registrados.';
        }
        echo json_encode(['success' => true, 'user' => $user]);
    } else {
        // El único caso en que esto falla es si el ID no existe o no es un aprendiz.
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado o no es un aprendiz.']);
    }

} catch (PDOException $e) {
    // Manejo de errores de base de datos
    error_log("Error al obtener detalles del usuario: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
}

// CRUCIAL: Si no devuelves nada después del último 'exit()', el script termina aquí.
?>