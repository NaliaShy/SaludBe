<?php
include "conexion.php";

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$existentes = $_POST['pregunta_existente'];
$nuevas = $_POST['preguntas_nuevas'];

$conexion->query("UPDATE tests SET titulo='$titulo' WHERE id=$id");

foreach ($existentes as $pid => $texto) {
    $conexion->query("UPDATE preguntas SET texto_pregunta='$texto' WHERE id=$pid");
}

if (!empty($nuevas)) {
    foreach ($nuevas as $p) {
        $conexion->query("INSERT INTO preguntas (test_id, texto_pregunta) VALUES ($id, '$p')");
    }
}

header("Location: listar_tests.php");
?>
