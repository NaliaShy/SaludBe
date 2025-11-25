<?php
include 'Conexion.php';

// Crear conexión
$db = new Conexion();
// La variable de conexión es $conn, ya que así la definiste
$conn = $db->getConnect(); 

// 1. Obtener el término de búsqueda de manera segura
$searchTerm = $_GET['search_term'] ?? '';
$searchParam = '%' . $searchTerm . '%'; 

// 2. Definir el ID del Rol para Aprendiz
$rol_aprendiz = 1;

// 3. Consulta SQL con el filtro de rol y búsqueda agrupada
// Utilizamos WHERE (condición1 OR condición2) AND condición_rol
$sql = "SELECT Us_id, Us_nombre, Us_apellios 
        FROM usuarios 
        WHERE (Us_nombre LIKE :search OR Us_apellios LIKE :search)
        AND Rol_id = :rol_id"; 

// 4. Preparación y ejecución de la consulta PDO
// CORRECCIÓN: Usamos $conn en lugar de $conexion
$stmt = $conn->prepare($sql);
$stmt->bindParam(':search', $searchParam);
$stmt->bindParam(':rol_id', $rol_aprendiz, PDO::PARAM_INT); // Usamos el ID del rol
$stmt->execute(); 
$aprendices = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ... el resto de tu lógica para mostrar $aprendices
?>