<?php
include "conexion.php";

$id = $_GET['id'];
$test = $conexion->query("SELECT * FROM tests WHERE id=$id")->fetch_assoc();
$pregs = $conexion->query("SELECT * FROM preguntas WHERE test_id=$id");
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container mt-5 col-md-8">
    <h3>Editar Test</h3>
    <hr>

    <form action="guardar_edicion.php" method="POST">
        <input type="hidden" name="id" value="<?= $id ?>">

        <label class="form-label">Título del test:</label>
        <input type="text" name="titulo" class="form-control" value="<?= $test['titulo'] ?>" required>

        <hr>
        <h5>Preguntas</h5>

        <?php while($p = $pregs->fetch_assoc()){ ?>
            <div class="mb-2">
                <input type="text" name="pregunta_existente[<?= $p['id'] ?>]" class="form-control" value="<?= $p['texto_pregunta'] ?>" required>
            </div>
        <?php } ?>

        <div id="nuevas_preguntas"></div>

        <button type="button" class="btn btn-warning" onclick="agregarNueva()">➕ Agregar nueva pregunta</button>
        <br><br>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>

<script>
function agregarNueva() {
    const div = document.createElement('div');
    div.innerHTML = `<input type="text" name="preguntas_nuevas[]" class="form-control mb-2" placeholder="Nueva pregunta...">`;
    document.getElementById('nuevas_preguntas').appendChild(div);
}
</script>
