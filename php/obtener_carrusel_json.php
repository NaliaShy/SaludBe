<?php
header("Content-Type: application/json");
require "Conexion.php";

$conexion = new Conexion();
$conn = $conexion->getConnect();

$sql = "SELECT imagen_nombre FROM carrusel WHERE estado = 'activo' ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();

$imagenes = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $imagenes[] = "../../Uploads/carrusel/" . $row["imagen_nombre"];
}

echo json_encode($imagenes);
?>
