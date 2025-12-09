<?php
// archivo: ../../php/psicologo/descargar_seguimiento.php

include_once '../php/Conexion/Conexion.php'; // Asegúrate de que esta ruta sea correcta

// 1. Obtener el ID del aprendiz
// Se asume que este script es llamado desde un enlace o botón que pasa el ID.
if (!isset($_GET['id_aprendiz']) || !is_numeric($_GET['id_aprendiz'])) {
    die("Error: ID de Aprendiz no proporcionado o inválido.");
}

$idAprendiz = $_GET['id_aprendiz'];

try {
    $db = new Conexion();
    $conexion = $db->getConnect();
    
    // 2. Consulta PRINCIPAL: Obtener datos del Aprendiz y su historial de Seguimientos
    // Usamos JOINs para enlazar Usuarios (Aprendiz) -> Cita -> Seguimiento.
    $sql = "SELECT 
                U.Us_id AS ID_Aprendiz,
                U.Us_nombre AS Nombre_Aprendiz,
                U.Us_apellios AS Apellido_Aprendiz,
                U.Us_documento AS Documento_Aprendiz,
                U.Us_correo AS Email_Aprendiz,
                T.Ti_rol AS Tipo_Documento,

                S.id_seguimiento AS ID_Seguimiento,
                S.descripcion AS Detalle_Seguimiento,
                S.fecha_creacion AS Fecha_Registro_Seguimiento,
                S.estado_seg AS Estado_Seguimiento,

                C.IdCita AS ID_Cita_Asociada,
                C.Fecha AS Fecha_Cita,
                C.Hora AS Hora_Cita,
                C.Motivo AS Motivo_Cita,
                C.Estado AS Estado_Cita,
                
                P.Us_nombre AS Nombre_Psicologo,
                P.Us_apellios AS Apellido_Psicologo
            FROM usuarios U
            LEFT JOIN tipo_usuarios T ON U.Ti_id = T.Ti_id
            
            -- Unimos citas donde el aprendiz es el usuario
            LEFT JOIN cita C ON U.Us_id = C.Id_Usuario 
            
            -- Unimos el seguimiento a esa cita
            LEFT JOIN seguimiento S ON C.IdCita = S.id_cita 
            
            -- Unimos los datos del Psicólogo (P)
            LEFT JOIN usuarios P ON C.Id_psicologo = P.Us_id
            
            WHERE U.Us_id = ? 
            ORDER BY S.fecha_creacion DESC, C.Fecha DESC";
            
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$idAprendiz]);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si no hay datos, al menos cargamos los datos del aprendiz si existen.
    if (empty($resultado)) {
        // Ejecutar una consulta solo para obtener los datos del aprendiz si no tiene seguimientos
        $sqlAprendiz = "SELECT U.Us_id AS ID_Aprendiz, U.Us_nombre, U.Us_apellios, U.Us_documento, U.Us_correo, T.Ti_rol AS Tipo_Documento
                         FROM usuarios U
                         LEFT JOIN tipo_usuarios T ON U.Ti_id = T.Ti_id
                         WHERE U.Us_id = ?";
        $stmtAprendiz = $conexion->prepare($sqlAprendiz);
        $stmtAprendiz->execute([$idAprendiz]);
        $datosAprendiz = $stmtAprendiz->fetch(PDO::FETCH_ASSOC);
        
        if ($datosAprendiz) {
             // Creamos un resultado con datos del aprendiz pero campos de seguimiento vacíos
             $resultado[] = array_merge($datosAprendiz, [
                'ID_Seguimiento' => 'N/A',
                'Detalle_Seguimiento' => 'No hay seguimientos registrados',
                'Fecha_Registro_Seguimiento' => 'N/A',
                'Estado_Seguimiento' => 'N/A',
                'ID_Cita_Asociada' => 'N/A',
                'Fecha_Cita' => 'N/A',
                'Hora_Cita' => 'N/A',
                'Motivo_Cita' => 'N/A',
                'Estado_Cita' => 'N/A',
                'Nombre_Psicologo' => 'N/A',
                'Apellido_Psicologo' => 'N/A'
            ]);
        } else {
            die("Error: Aprendiz no encontrado.");
        }
    }
    
    // 3. Preparar el CSV y cabeceras de descarga
    $primerRegistro = $resultado[0];
    
    // Reemplazamos espacios en el nombre del archivo
    $nombreAprendiz = str_replace(' ', '_', $primerRegistro['Nombre_Aprendiz'] . '_' . $primerRegistro['Apellido_Aprendiz']);
    $fechaActual = date('Ymd_His');
    $nombreArchivo = "Seguimiento_{$nombreAprendiz}_{$fechaActual}.csv";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
    
    // Abre salida estándar
    $output = fopen("php://output", "w");
    
    // Convertir a UTF-8 (opcional, pero útil para caracteres especiales)
    fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

    // Escribir encabezados del CSV (usamos las claves del primer registro)
    fputcsv($output, array_keys($primerRegistro));

    // Escribir cada fila de datos
    foreach ($resultado as $fila) {
        fputcsv($output, $fila);
    }

    fclose($output);
    exit;

} catch (PDOException $e) {
    error_log("Error de descarga de seguimiento: " . $e->getMessage());
    die("Error en la base de datos durante la descarga.");
}

$conexion = null;
?>