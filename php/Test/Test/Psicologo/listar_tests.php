<?php
session_start();
include "conexion.php";

$psicologo = $_SESSION['id'];
$tests = $conexion->query("SELECT * FROM tests WHERE creado_por=$psicologo");
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <h3>Mis Tests</h3>
    <hr>

    <a href="crear_test.php" class="btn btn-primary mb-3">➕ Crear Test</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Fecha</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while($t = $tests->fetch_assoc()){ ?>
            <tr>
                <td><?= $t['titulo'] ?></td>
                <td><?= $t['fecha'] ?></td>
                <td>
                    <a href="ver_test.php?id=<?= $t['id'] ?>" class="btn btn-info btn-sm">🔍 Ver</a>
                    <a href="editar_test.php?id=<?= $t['id'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                    <a href="eliminar_test.php?id=<?= $t['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar test?')">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
