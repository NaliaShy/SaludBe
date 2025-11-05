<?php
// Debug fuerte para ver todo
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

// Registro de entrada completa para debug
file_put_contents(__DIR__ . "/debug_POST_raw.txt", file_get_contents('php://input'));
file_put_contents(__DIR__ . "/debug_POST_array.txt", print_r($_POST, true), FILE_APPEND);
file_put_contents(__DIR__ . "/debug_server_headers.txt", print_r(getallheaders(), true));

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false, 'error'=>'Método no permitido: ' . $_SERVER['REQUEST_METHOD']]);
    exit;
}

// Leer variables
$mensaje = $_POST['mensaje'] ?? null;
$us_id = $_POST['us_id'] ?? null;

// Si vienen vacíos, devolvemos info de debug
if ($mensaje === null || trim($mensaje) === '') {
    echo json_encode(['success'=>false, 'error'=>'Mensaje vacío', 'debug'=>[
        'mensaje'=> $mensaje,
        'us_id'=>$us_id,
        'php_input'=>file_get_contents('php://input'),
        '_POST'=>$_POST
    ]]);
    exit;
}

try {
    include '../../php/Conexion.php';
    $db = new Conexion();
    $conn = $db->getConnect();

    $stmt = $conn->prepare("INSERT INTO mensaje (Men_contenido, Men_fecha_envio, Us_id) VALUES (:mensaje, NOW(), :us_id)");
    $stmt->bindParam(':mensaje', $mensaje);
    $stmt->bindParam(':us_id', $us_id);
    $stmt->execute();

    echo json_encode(['success'=>true]);
} catch (PDOException $e) {
    // Guardar error para revisión
    file_put_contents(__DIR__ . "/debug_sql_error.txt", $e->getMessage());
    echo json_encode(['success'=>false,'error'=>'Error BD: '.$e->getMessage()]);
}
