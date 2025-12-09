<?php
session_start();

// 2. INCLUIR CONEXIÓN A LA BASE DE DATOS
// Asegúrate de que la ruta 'conexion.php' sea correcta
include_once '../Conexion/Conexion.php'; 

// 3. VALIDACIÓN BÁSICA DEL MÉTODO
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../Html/Error/405.html"); 
    exit("Método de solicitud no válido.");
}

// 4. VERIFICAR AUTENTICACIÓN DEL APRENDIZ
// Se usa $_SESSION['us_id'] que es la variable correcta según tu login
if (!isset($_SESSION['Us_id'])) {
    $_SESSION['notificacion_error'] = "❌ No se puede agendar la cita: no has iniciado sesión.";
    header("Location: ../Html/Login/Login.php"); 
    exit("Acceso no autorizado.");
}

// Obtener el ID del aprendiz logueado desde la sesión (us_id)
$aprendiz_id = $_SESSION['Us_id'];

// 5. RECOGER Y SANEAR DATOS DEL FORMULARIO
$fecha = $_POST['fecha'] ?? null;
$motivo = $_POST['Motivo'] ?? null;
$psicologo_id = $_POST['Psicologo'] ?? null;

// 6. VALIDACIÓN DE DATOS REQUERIDOS
if (empty($fecha) || empty($psicologo_id)) {
    $_SESSION['notificacion_error'] = "⚠️ Error: Debes seleccionar una fecha y un psicólogo para continuar.";
    header("Location: ../Html/Aprendiz/solicitarcitaApren.php");
    exit();
}

// 7. PREPARAR VALORES PARA LA INSERCIÓN
$motivo_completo = "Motivo: " . $motivo;
$estado_inicial = "Pendiente";

// 8. INSERCIÓN EN LA BASE DE DATOS
try {
    $db = new Conexion();
    $conexion = $db->getConnect();
    
    // Consulta INSERT segura con marcadores de posición (?)
    // Asegúrate que los nombres de las columnas ('Fecha', 'Hora', 'Estado', 'Motivo', 'Id_Usuario', 'Id_Psicologo') coincidan con tu tabla 'cita'.
    $sql = "INSERT INTO cita (Fecha, Hora, Estado, Motivo, Id_Usuario, Id_Psicologo) 
            VALUES (?, CURTIME(), ?, ?, ?, ?)";
            
    $stmt = $conexion->prepare($sql);
    
    $stmt->execute([
        $fecha,
        $estado_inicial,
        $motivo_completo,
        $aprendiz_id, 
        $psicologo_id
    ]);
    
    // 9. REDIRECCIÓN TRAS ÉXITO
    $_SESSION['notificacion_exito'] = "✅ Cita solicitada exitosamente. Espera la confirmación del psicólogo.";
    header("Location: ../../Html/Aprendiz/Descarga.php"); 
    exit();

} catch (PDOException $e) {
    // 10. MANEJO DE ERRORES DE BASE DE DATOS
    error_log("Error al agendar cita: " . $e->getMessage());
    $_SESSION['notificacion_error'] = "❌ Hubo un error inesperado al guardar la cita. Inténtalo de nuevo. [Detalle: " . $e->getMessage() . "]";
    header("Location: ../Html/Aprendiz/solicitarcitaApren.php");
    exit();
}

?>