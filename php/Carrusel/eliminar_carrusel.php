<?php
require_once "../Conexion/Conexion.php";


// Validar
if (!isset($_POST["id"])) {
    echo "no id";
    exit;
}

$id = intval($_POST["id"]);

// Crear conexión
$conexion = new Conexion();
$conn = $conexion->getConnect();

// 1️⃣ Obtener nombre del archivo
$stmt = $conn->prepare("SELECT imagen_nombre FROM carrusel WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "no existe";
    exit;
}

$imagen = $row["imagen_nombre"];
$path = "../../Uploads/carrusel/" . $imagen;

// 2️⃣ Borrar archivo físico
if (file_exists($path)) {
    unlink($path);
}

// 3️⃣ Eliminar registro en BD
$delete = $conn->prepare("DELETE FROM carrusel WHERE id = ?");
$delete->execute([$id]);

echo "ok";
?>
