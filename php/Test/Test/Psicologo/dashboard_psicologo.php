<?php
session_start();
include "conexion.php";

// Verificar si el usuario es psicólogo
// Suponiendo que role = "psicologo" en la tabla usuarios
if ($_SESSION['role'] != 'psicologo') {
    header("Location: login.php");
    exit();
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <h2>Panel del Psicólogo</h2>
    <hr>

    <a href="crear_test.php" class="btn btn-primary">➕ Crear nuevo Test</a>
    <a href="listar_tests.php" class="btn btn-success">📋 Ver Tests</a>
</div>
