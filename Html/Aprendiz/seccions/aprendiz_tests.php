<?php
include "../../Conexion/Conexion.php";

$tests = $conexion->query("SELECT * FROM tests ORDER BY fecha_creacion DESC");
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <h2 class="text-center mb-4">Tests Disponibles</h2>

    <div class="row">
        <?php while($t = $tests->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card shadow rounded-4 p-3 mb-4">
                    <h5><?= $t['titulo'] ?></h5>
                    <p class="text-muted">Creado el: <?= $t['fecha_creacion'] ?></p>

                    <button class="btn btn-primary w-100 mt-2"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTest<?= $t['id'] ?>">
                        Resolver Test
                    </button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php
$tests->data_seek(0);
while($t = $tests->fetch_assoc()):
    $test_id = $t['id'];
    $preguntas = $conexion->query("SELECT * FROM preguntas WHERE test_id = $test_id");
?>
<!-- ================= MODAL DEL TEST ================= -->
<div class="modal fade" id="modalTest<?= $t['id'] ?>" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow">

      <div class="modal-header">
        <h5 class="modal-title">Test: <?= $t['titulo'] ?></h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="aprendiz_guardar_respuestas.php" method="POST">
        <input type="hidden" name="test_id" value="<?= $t['id'] ?>">

        <div class="modal-body">

            <?php while($p = $preguntas->fetch_assoc()): ?>
                <div class="mb-4 p-3 border rounded-3 shadow-sm">
                    <label class="form-label fw-bold"><?= $p['pregunta'] ?></label>

                    <select name="respuesta_<?= $p['id'] ?>" class="form-control mt-2" required>
                        <option value="">Seleccione una opción</option>
                        <option>Nunca</option>
                        <option>Probablemente</option>
                        <option>Más o menos</option>
                        <option>Siempre</option>
                    </select>
                </div>
            <?php endwhile; ?>

        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Enviar Respuestas</button>
        </div>

      </form>
    </div>
  </div>
</div>

<?php endwhile; ?>
