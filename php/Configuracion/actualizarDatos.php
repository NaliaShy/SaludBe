<?php
// 1. INICIAR SESIÓN y CONFIGURACIÓN
session_start();
include_once '../Conexion.php'; 

// 2. VERIFICAR AUTENTICACIÓN
if (!isset($_SESSION['us_id'])) {
    $_SESSION['notificacion_error'] = "❌ Error: No has iniciado sesión.";
    header("Location: ../Html/Login/Loginpsicologo.html"); // Redirigir al login si no está autenticado
    exit();
}

$userId = $_SESSION['us_id'];

// 3. VALIDACIÓN DEL MÉTODO
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['notificacion_error'] = "⚠️ Método de solicitud no válido.";
    header("Location: ../Html/Psicologo/configuracion.php"); 
    exit();
}

// 4. RECOGER Y SANEAR DATOS DEL FORMULARIO
$nombre_completo = trim($_POST['nombre_completo'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// 5. SEPARAR NOMBRE Y APELLIDO
$partes_nombre = explode(' ', $nombre_completo, 2);
$nombre = $partes_nombre[0] ?? '';
$apellido = $partes_nombre[1] ?? '';

// 6. VALIDACIÓN DE DATOS REQUERIDOS
if (empty($nombre) || empty($apellido) || empty($email)) {
    $_SESSION['notificacion_error'] = "⚠️ Error: El nombre completo y el correo electrónico son obligatorios.";
    echo "<script>window.location.href = 'C:\laragon\www\SaludBe\Html\psicologo\configuracion.php';</script>";
    exit();
}

// 7. PREPARAR LA CONSULTA BASE Y LOS PARÁMETROS
$setClauses = [];
$params = [];

// Campos que SIEMPRE se actualizan
$setClauses[] = "Us_nombre = ?";
$params[] = $nombre;

$setClauses[] = "Us_apellios = ?";
$params[] = $apellido;

$setClauses[] = "Us_correo = ?";
$params[] = $email;

// Manejo de la contraseña (solo si se proporciona)
if (!empty($password)) {
    // Es crucial usar PASSWORD_DEFAULT (bcrypt o más seguro) para almacenar la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $setClauses[] = "Us_contraseña = ?";
    $params[] = $hashedPassword;
}

// 8. CONSTRUIR Y EJECUTAR LA CONSULTA UPDATE
try {
    $db = new Conexion();
    $conexion = $db->getConnect();
    
    $sql = "UPDATE usuarios SET " . implode(', ', $setClauses) . " WHERE Us_id = ?";
    $params[] = $userId; // Añadir el ID del usuario al final de los parámetros
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute($params);
    
    // 9. REDIRECCIÓN TRAS ÉXITO
    $_SESSION['notificacion_exito'] = "✅ Tus datos han sido actualizados exitosamente.";
    echo "<script>window.location.href = 'C:\laragon\www\SaludBe\Html\psicologo\configuracion.php';</script>";
    exit();

} catch (PDOException $e) {
    // 10. MANEJO DE ERRORES DE BASE DE DATOS
    error_log("Error al actualizar datos del psicólogo ID {$userId}: " . $e->getMessage());
    $_SESSION['notificacion_error'] = "❌ Hubo un error inesperado al actualizar. Inténtalo de nuevo. [Detalle: " . $e->getMessage() . "]";
    echo "<script>window.location.href = 'C:\laragon\www\SaludBe\Html\psicologo\configuracion.php';</script>";
    exit();
}
?>