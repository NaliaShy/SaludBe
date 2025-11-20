<?php
header("Content-Type: application/json");
require "Conexion.php";

$sql = "SELECT id, imagen_url FROM carrusel_imagenes WHERE estado='activo' ORDER BY id DESC";
$result = $conn->query($sql);

$imagenes = [];

while ($row = $result->fetch_assoc()) {
    $imagenes[] = $row;
}

echo json_encode($imagenes);
?>
