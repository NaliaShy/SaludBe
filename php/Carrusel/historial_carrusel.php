<?php
require_once "../Conexion/Conexion.php";

// Crear conexión
$con = new Conexion();
$conn = $con->getConnect();

// Consulta
$sql = $conn->prepare("SELECT id, imagen_nombre, fecha_subida, estado FROM carrusel ORDER BY id DESC");
$sql->execute();

$imagenes = [];

while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $imagenes[] = [
        "id" => $row["id"],
        "url" => "../../Uploads/carrusel/" . $row["imagen_nombre"],
        "fecha" => $row["fecha_subida"],
        "estado" => $row["estado"]
    ];
}

// Devolver en JSON
echo json_encode($imagenes, JSON_UNESCAPED_UNICODE);
?>
