<?php
session_start();
// Para prueba directa:
$usuarioId = $_SESSION['Us_id']; // Cambia a $_SESSION['id_usuario'] cuando tengas sesión

include 'conexion.php';
$db = new Conexion();
$conexion = $db->getConnect();

try {
    $stmt = $conexion->prepare("SELECT * FROM cita WHERE Id_Usuario = ?");
    $stmt->execute([$usuarioId]);
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Extraer solo YYYY-MM-DD si es DATETIME
    foreach($citas as &$cita){
        $cita['Fecha'] = substr($cita['Fecha'], 0, 10);
    }

    // Pasar a JS
    echo "<script>const citas = " . json_encode($citas) . ";</script>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
