<?php
include 'Conexion.php';

// Crear conexión
$db = new Conexion();
$conn = $db->getConnect();

// Si existe búsqueda, la recibimos
$search = isset($_GET['search_term']) ? trim($_GET['search_term']) : '';

if ($search !== '') {
    $sql = "SELECT Us_id, Us_nombre, Us_apellios 
            FROM usuarios 
            WHERE Us_nombre LIKE :search
               OR Us_apellios LIKE :search";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
} else {
    $sql = "SELECT Us_id, Us_nombre, Us_apellios FROM usuarios";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

$aprendices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
