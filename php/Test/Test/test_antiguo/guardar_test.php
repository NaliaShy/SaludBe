<?php
include "../../Conexion/Conexion.php";

$idUsuario = $_SESSION['Us_id'];

$titulo = $_POST['titulo'];
$preguntas = $_POST['preguntas'];

$conexion->getConnect ("INSERT INTO tests (titulo) VALUES ('$titulo')");
$test_id = $conexion-> $idUsuario;

foreach($preguntas as $p){
    if(trim($p) != ""){
        $conexion->getConnect("INSERT INTO preguntas (test_id, pregunta) VALUES ($test_id, '$p')");
    }
}

echo "Test creado correctamente";
?>