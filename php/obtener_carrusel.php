<?php
header("Content-Type: application/json");
require "Conexion.php";

// 1. Crea una instancia de la clase Conexion
$db = new Conexion();

// 2. Obtiene el objeto de conexión PDO
$conn = $db->getConnect();

// 3. Define y prepara la consulta
$sql = "SELECT id, imagen_url FROM carrusel_imagenes WHERE estado='activo' ORDER BY id DESC";

try {
    // 4. Ejecuta la consulta (método PDO: query())
    $stmt = $conn->query($sql);
    
    // 5. Obtiene todos los resultados como un array asociativo (método PDO: fetchAll())
    $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 6. Imprime el JSON
    echo json_encode($imagenes);

} catch (PDOException $e) {
    // Manejo de errores de la consulta
    http_response_code(500); // Establece el código de respuesta HTTP a 500 (Error Interno del Servidor)
    echo json_encode(["error" => "Error al ejecutar la consulta: " . $e->getMessage()]);
}

?>