<?php
// archivo: ../../php/aprendiz/descargar_mi_seguimiento.php

// 🚨 Iniciar Output Buffering para evitar errores de cabecera/descarga
ob_start();

include_once '../Conexion/Conexion.php'; 
session_start();

// 1. Verificación de sesión (Solo permite la descarga si hay una sesión activa)
if (!isset($_SESSION['Us_id'])) {
    // Limpiamos el buffer si hubiera algo antes
    ob_end_clean();
    die("Error: Debes iniciar sesión para acceder a esta información.");
}

$idAprendiz = $_SESSION['Us_id'];

try {
    $db = new Conexion();
    $conexion = $db->getConnect();
    
    // 2. Consulta PRINCIPAL: Obtener datos del Aprendiz y su historial de Seguimientos
    // La consulta se centra en el Aprendiz (U) y solo busca sus citas y seguimientos.
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
                -- 🚨 NOTA: Estado_Seguimiento es un tinyint (0/1), se muestra como número
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
            
            -- Unimos citas donde el aprendiz es el usuario (C.Id_Usuario)
            LEFT JOIN cita C ON U.Us_id = C.Id_Usuario 
            
            -- Unimos el seguimiento a esa cita
            LEFT JOIN seguimiento S ON C.IdCita = S.id_cita 
            
            -- Unimos los datos del Psicólogo (P)
            LEFT JOIN usuarios P ON C.Id_psicologo = P.Us_id
            
            WHERE U.Us_id = ? 
            ORDER BY S.fecha_creacion DESC, C.Fecha DESC";
            
    $stmt = $conexion->prepare($sql);
    // 🚨 Usamos el ID de la sesión para la consulta
    $stmt->execute([$idAprendiz]); 
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si no hay resultados de seguimientos/citas, aún podemos devolver los datos del aprendiz
    if (empty($resultado)) {
        // ... (Consulta simplificada para obtener solo datos del aprendiz)
        $sqlAprendiz = "SELECT U.Us_nombre, U.Us_apellios FROM usuarios U WHERE U.Us_id = ?";
        $stmtAprendiz = $conexion->prepare($sqlAprendiz);
        $stmtAprendiz->execute([$idAprendiz]);
        $datosAprendiz = $stmtAprendiz->fetch(PDO::FETCH_ASSOC);
        
        if (!$datosAprendiz) {
             ob_end_clean();
             die("Error: Datos de Aprendiz no encontrados.");
        }
        
        // Creamos un resultado base para el CSV con los datos del aprendiz y N/A para seguimientos
        $primerRegistro = [
            'ID_Aprendiz' => $idAprendiz,
            'Nombre_Aprendiz' => $datosAprendiz['Us_nombre'],
            'Apellido_Aprendiz' => $datosAprendiz['Us_apellios'],
            'Documento_Aprendiz' => 'N/A', // Se requeriría otra consulta si quieres llenar esto
            'Email_Aprendiz' => 'N/A',
            'Tipo_Documento' => 'N/A',
            'ID_Seguimiento' => 'N/A',
            'Detalle_Seguimiento' => 'No hay historial de seguimientos o citas registradas.',
            'Fecha_Registro_Seguimiento' => 'N/A',
            'Estado_Seguimiento' => 'N/A',
            'ID_Cita_Asociada' => 'N/A',
            'Fecha_Cita' => 'N/A',
            'Hora_Cita' => 'N/A',
            'Motivo_Cita' => 'N/A',
            'Estado_Cita' => 'N/A',
            'Nombre_Psicologo' => 'N/A',
            'Apellido_Psicologo' => 'N/A'
        ];
        $resultado[] = $primerRegistro;
    }
    
    // 3. Preparar el CSV y cabeceras de descarga
    $primerRegistro = $resultado[0]; // Usamos el primer registro para los encabezados
    
    // Generar nombre de archivo
    $nombreAprendiz = str_replace(' ', '_', $primerRegistro['Nombre_Aprendiz'] . '_' . $primerRegistro['Apellido_Aprendiz']);
    $fechaActual = date('Ymd_His');
    $nombreArchivo = "Mi_Seguimiento_{$nombreAprendiz}_{$fechaActual}.csv";

    // Establecer cabeceras para forzar la descarga
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
    
    // Abre salida estándar
    $output = fopen("php://output", "w");
    
    // Agregar BOM para compatibilidad UTF-8 en Excel
    fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

    // Escribir encabezados del CSV (usamos las claves del primer registro)
    fputcsv($output, array_keys($primerRegistro));

    // Escribir cada fila de datos
    foreach ($resultado as $fila) {
        fputcsv($output, $fila);
    }

    fclose($output);
    
    // 🚨 Limpiamos el buffer y salimos para asegurar que solo se envía el CSV
    ob_end_clean();
    exit;

} catch (PDOException $e) {
    ob_end_clean();
    error_log("Error de descarga de mi seguimiento: " . $e->getMessage());
    die("Error en la base de datos durante la descarga.");
}

$conexion = null;
?>