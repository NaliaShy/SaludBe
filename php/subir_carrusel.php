<?php
session_start();
include "Conexion.php";

// Crear instancia de la conexión
$db = new Conexion();
$conn = $db->getConnect();  

// Verificar usuario logueado
$usuario = $_SESSION['Us_id'] ?? null;

if (!$usuario) {
    echo json_encode([
        "status" => "error",
        "msg" => "El usuario no está logueado (Us_id vacío)"
    ]);
    exit;
}

// Verificar archivo
if (!isset($_FILES['imagen'])) {
    echo json_encode([
        "status" => "error",
        "msg" => "No se recibió archivo"
    ]);
    exit;
}

// Directorio
$directorio = "../Uploads/carrusel/";

if (!file_exists($directorio)) {
    mkdir($directorio, 0777, true);
}

// Crear nombre de imagen
$nombreImagen = time() . "_" . basename($_FILES["imagen"]["name"]);
$rutaDestino = $directorio . $nombreImagen;

// Mover archivo a servidor
if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
    echo json_encode([
        "status" => "error",
        "msg" => "No se pudo mover la imagen al servidor"
    ]);
    exit;
}

$titulo = $_POST["titulo"] ?? "";
$descripcion = $_POST["descripcion"] ?? "";

// INSERT SEGÚN TU TABLA carrusel
try {
    $sql = "INSERT INTO carrusel (titulo, descripcion, imagen_url, estado, Us_id)
            VALUES (?, ?, ?, 'activo', ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$titulo, $descripcion, $nombreImagen, $usuario]);

    echo json_encode([
        "status" => "ok",
        "msg" => "Imagen subida correctamente",
        "file" => $nombreImagen
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "msg" => "Error SQL: " . $e->getMessage()
    ]);
}
