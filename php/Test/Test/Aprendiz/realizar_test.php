<?php
session_start();
include "conexion.php";

$id = $_GET['id'];

$test = $conexion->query("SELECT * FROM tests WHERE id=$id")->fetch_assoc();
$pregs = $conexion->query("SELECT * FROM preguntas WHERE test_id=$id");
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <h3>Realizar Test: <?= $test['titulo'] ?></h3>
    <hr>

    <form action="guardar_respuestas.php" method="POST">
        <input type="hidden" name="test_id" value="<?= $id ?>">

        <?php while($p = $pregs->fetch_assoc()){ ?>
            <div class="mb-4">
                <label><strong><?= $p['texto_pregunta'] ?></strong></label>

                <select name="respuesta[<?= $p['id'] ?>]" class="form-select" required>
                    <option value="1">Nunca</option>
                    <option value="2">Probablemente</option>
                    <option value="3">Más o menos</option>
                    <option value="4">Siempre</option>
                </select>
            </div>
        <?php } ?>

        <button type="submit" class="btn btn-primary">Enviar respuestas</button>
    </form>
</div>
