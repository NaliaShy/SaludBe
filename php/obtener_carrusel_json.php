<?php
header("Content-Type: application/json");
include "conexion.php";

$sql = "SELECT * FROM carrusel ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$imagenes = [];

while ($row = mysqli_fetch_assoc($result)) {
    $imagenes[] = "../../Uploads/carrusel/" . $row["imagen_nombre"];
}

echo json_encode($imagenes);
