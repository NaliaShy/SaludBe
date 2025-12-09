<?php
session_start();
include "conexion.php";

$aprendiz = $_SESSION['id'];
$test_id = $_POST['test_id'];
$respuestas = $_POST['respuesta'];

foreach ($respuestas as $pregunta_id => $valor) {
    $conexion->query("
        INSERT INTO respuestas_aprendiz (aprendiz_id, test_id, pregunta_id, respuesta_valor)
        VALUES ($aprendiz, $test_id, $pregunta_id, $valor)
    ");
}

header("Location: resultado_test.php?test=$test_id");
?>
