<?php
header("Content-Type: application/json");
include "conexion.php";

$sql = "SELECT * FROM carrusel WHERE estado='activo' ORDER BY id_carrusel DESC";
$result = mysqli_query($conn, $sql);

$imagenes = [];

while ($row = mysqli_fetch_assoc($result)) {
    $imagenes[] = "../../Uploads/carrusel/" . $row["imagen_url"];
}

echo json_encode($imagenes);
?>
