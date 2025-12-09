<?php session_start(); include "conexion.php"; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container mt-5 col-md-8">
    <h3>Crear nuevo Test</h3>
    <hr>

    <form action="guardar_test.php" method="POST">
        <label class="form-label">Título del test:</label>
        <input type="text" name="titulo" class="form-control" required>

        <hr>
        <h5>Preguntas</h5>

        <div id="preguntas">
            <div class="mb-3">
                <input type="text" name="preguntas[]" class="form-control" placeholder="Escribe una pregunta..." required>
            </div>
        </div>

        <button type="button" class="btn btn-warning" onclick="agregarPregunta()">➕ Agregar pregunta</button>
        <br><br>

        <button type="submit" class="btn btn-primary">Guardar Test</button>
    </form>
</div>

<script>
function agregarPregunta() {
    const div = document.createElement('div');
    div.classList.add("mb-3");
    div.innerHTML = `<input type="text" name="preguntas[]" class="form-control" placeholder="Escribe una pregunta..." required>`;
    document.getElementById('preguntas').appendChild(div);
}
</script>
