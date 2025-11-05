<?php
// Incluye la clase de conexión y la instancia (asumiendo que está en el mismo nivel o que la ruta es correcta)
include '../Conexion.php'; // Asegúrate de que esta ruta sea correcta

$db = new Conexion();
$conn = $db->getConnect(); // Obtenemos el objeto PDO

$aprendices = [];
$searchTerm = $_GET['search_term'] ?? ''; // Obtener el término de búsqueda o cadena vacía

// 1. Definición de la Consulta SQL (con PLACEHOLDERS '?' y la cláusula LIKE)
// Buscamos coincidencias en el nombre O en el apellido.
$sql = "SELECT Us_nombre, Us_apellios 
        FROM usuarios
        WHERE Rol_id = 1"; // Filtro base: solo aprendices (Rol_id = 1)

if (!empty($searchTerm)) {
    // Si hay un término de búsqueda, agregamos la cláusula WHERE/AND para buscar en nombre o apellido
    $sql .= " AND (Us_nombre LIKE ? OR Us_apellios LIKE ?)";
}

try {
    // 2. Preparar la Sentencia
    $stmt = $conn->prepare($sql);
    
    // 3. Vincular Parámetros (Binding) si hay término de búsqueda
    if (!empty($searchTerm)) {
        // En PDO, la búsqueda LIKE necesita los comodines (%) pegados al valor
        $param = "%$searchTerm%";
        
        // El primer '?' corresponde al Us_nombre
        $stmt->bindParam(1, $param, PDO::PARAM_STR); 
        
        // El segundo '?' corresponde al Us_apellios
        $stmt->bindParam(2, $param, PDO::PARAM_STR);
    }
    
    // 4. Ejecutar la Sentencia
    $stmt->execute();
    
    // 5. Obtener todos los resultados
    $aprendices = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // En un entorno de producción, esto debería ir a un log, no mostrarse al usuario.
    echo "Error al ejecutar la consulta: " . $e->getMessage();
}

// Opcional: Cerrar la conexión (no es estrictamente necesario, pero es buena práctica)
$conn = null;
?>