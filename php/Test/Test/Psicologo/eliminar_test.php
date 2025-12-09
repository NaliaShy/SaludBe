<?php
include "conexion.php";

$id = $_GET['id'];
$conexion->query("DELETE FROM tests WHERE id=$id");

header("Location: listar_tests.php");
?>
