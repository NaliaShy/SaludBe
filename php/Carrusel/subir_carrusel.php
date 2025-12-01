<?php
header("Content-Type: application/json");
require_once "../Conexion/Conexion.php";

// Crear conexión con PDO
$conexion = new Conexion();
$conn = $conexion->getConnect();

// Validar archivo
if (!isset($_FILES["imagen"])) {
    echo json_encode(["error" => "No se recibió imagen"]);
    exit;
}

$archivo = $_FILES["imagen"];
$dir = "../../Uploads/carrusel/";

// Crear carpeta si no existe
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// Crear nombre único
$nombre_archivo = uniqid() . "_" . basename($archivo["name"]);
$ruta_final = $dir . $nombre_archivo;

// Mover al servidor
if (move_uploaded_file($archivo["tmp_name"], $ruta_final)) {

    // Insertar en la BD
    $sql = "INSERT INTO carrusel (imagen_nombre, estado) VALUES (?, 'activo')";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$nombre_archivo])) {

        echo json_encode([
            "success" => true,
            "nombre" => $nombre_archivo,
            "url" => "../../Uploads/carrusel/" . $nombre_archivo
        ]);

    } else {
        echo json_encode(["error" => "Error insertando en BD"]);
    }

} else {
    echo json_encode(["error" => "Error moviendo archivo"]);
}
?>
