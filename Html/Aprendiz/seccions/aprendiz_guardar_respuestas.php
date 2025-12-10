<?php
include "db.php";

$test_id = $_POST['test_id'];
$aprendiz_id = 1; // tu login irá aquí

$preguntas = $conexion->query("SELECT id FROM preguntas WHERE test_id = $test_id");

while ($p = $preguntas->fetch_assoc()) {
    $pid = $p['id'];
    $resp = $_POST["respuesta_$pid"];

    $conexion->query("INSERT INTO respuestas (test_id, pregunta_id, respuesta, aprendiz_id)
                      VALUES ($test_id, $pid, '$resp', $aprendiz_id)");
}

header("Location: aprendiz_tests.php");
exit;
?>
