<?php
include 'conexion.php';
session_start();



// ✅ Verificar sesión
if (!isset($_SESSION['id_usuario'])) {
    die("❌ No se puede agendar la cita: no has iniciado sesión.");
}

$idUsuario = $_SESSION['id_usuario'];

// ✅ Verificar método
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("❌ Error: método no permitido.");
}

// ✅ Capturar datos del formulario
$fecha = $_POST['fecha'] ?? '';
$motivo = $_POST['Motivo'] ?? ''; // <-- coincide con tu formulario
$idPsicologo = $_POST['Psicologo'] ?? '';

// ✅ Validación simple
if (empty($fecha) || empty($motivo) || empty($idPsicologo)) {
    die("❌ Faltan datos obligatorios.");
}

// ✅ Preparar valores para la tabla `cita`
$motivo = "Motivo: " . $motivo;
$estado = "Pendiente";

try {
    $db = new Conexion();
    $conexion = $db->getConnect();

    // ✅ Ahora incluye Id_Psicologo
    $sql = "INSERT INTO cita (Fecha, Hora, Estado, Motivo, Id_Usuario, Id_Psicologo)
            VALUES (?, CURTIME(), ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([$fecha, $estado, $motivo, $idUsuario, $idPsicologo]);

    // ✅ Redirigir con éxito
    header("Location: ../Html/Aprendiz/Calendario.php?msg=cita_creada");
    exit();
} catch (PDOException $e) {
    die("❌ Error al guardar la cita: " . $e->getMessage());
}
