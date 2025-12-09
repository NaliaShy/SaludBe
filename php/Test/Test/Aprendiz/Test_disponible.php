<?php
session_start();
include "conexion.php";

// Verificar que sea aprendiz
if ($_SESSION['role'] != 'aprendiz') {
    header("Location: login.php");
    exit();
}

$tests = $conexion->query("SELECT * FROM tests ORDER BY fecha DESC");
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <h3>Tests Disponibles</h3>
    <hr>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php while($t = $tests->fetch_assoc()){ ?>
            <tr>
                <td><?= $t['titulo'] ?></td>
                <td><?= $t['fecha'] ?></td>
                <td>
                    <a href="realizar_test.php?id=<?= $t['id'] ?>" class="btn btn-success btn-sm">
                        Realizar Test
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
