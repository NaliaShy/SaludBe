<?php
include "conexion.php";

$id = $_GET['id'];
$test = $conexion->query("SELECT * FROM tests WHERE id=$id")->fetch_assoc();
$pregs = $conexion->query("SELECT * FROM preguntas WHERE test_id=$id");
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <h3><?= $test['titulo'] ?></h3>
    <hr>

    <h5>Preguntas:</h5>
    <ul>
        <?php while($p = $pregs->fetch_assoc()){ ?>
            <li><?= $p['texto_pregunta'] ?></li>
        <?php } ?>
    </ul>

    <a href="listar_tests.php" class="btn btn-secondary">⬅ Volver</a>
</div>
