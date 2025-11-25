<?php
require_once 'Conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido.";
    exit;
}

$tipo = isset($_POST['tipo_test']) ? $_POST['tipo_test'] : null;
$titulo = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
$questions = isset($_POST['questions']) ? $_POST['questions'] : [];

if (empty($titulo) || empty($descripcion)) {
    echo "Faltan datos requeridos.";
    exit;
}

try {
    $db = new Conexion();
    $conn = $db->getConnect();

    // Insertar en la tabla `test`
    $sql = "INSERT INTO test (tes_titulo, tes_descripcion, tes_fecha_creacion) VALUES (:titulo, :descripcion, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':titulo' => $titulo,
        ':descripcion' => $descripcion
    ]);

    $testId = $conn->lastInsertId();

    // Crear tabla pregunta si no existe
    $crearTabla = "CREATE TABLE IF NOT EXISTS pregunta (
        pgr_id INT AUTO_INCREMENT PRIMARY KEY,
        pgr_test_id INT NOT NULL,
        pgr_texto TEXT NOT NULL,
        pgr_opciones TEXT,
        pgr_orden INT DEFAULT 0,
        FOREIGN KEY (pgr_test_id) REFERENCES test(tes_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $conn->exec($crearTabla);

    // Insertar preguntas
    if (!empty($questions) && is_array($questions)) {
        $insertPregunta = $conn->prepare("INSERT INTO pregunta (pgr_test_id, pgr_texto, pgr_opciones, pgr_orden) VALUES (:test_id, :texto, :opciones, :orden)");
        $orden = 1;
        foreach ($questions as $q) {
            $texto = isset($q['texto']) ? trim($q['texto']) : '';
            $opciones = isset($q['opciones']) && is_array($q['opciones']) ? json_encode(array_values($q['opciones']), JSON_UNESCAPED_UNICODE) : null;

            if ($texto === '') continue;

            $insertPregunta->execute([
                ':test_id' => $testId,
                ':texto' => $texto,
                ':opciones' => $opciones,
                ':orden' => $orden
            ]);

            $orden++;
        }
    }

    // Redirigir a la lista de tests o mostrar mensaje de éxito
    header('Location: ../Html/Aprendiz/test.php');
    exit;

} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
    exit;
}

?>
