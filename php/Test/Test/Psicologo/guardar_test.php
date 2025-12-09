<?php
session_start();
include "conexion.php";

$titulo = $_POST['titulo'];
$preguntas = $_POST['preguntas'];
$psicologo = $_SESSION['id'];

$conexion->query("INSERT INTO tests (titulo, creado_por) VALUES ('$titulo', '$psicologo')");
$test_id = $conexion->insert_id;

foreach ($preguntas as $p) {
    $conexion->query("INSERT INTO preguntas (test_id, texto_pregunta) VALUES ($test_id, '$p')");
}

header("Location: listar_tests.php");
?>
