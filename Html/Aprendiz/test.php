<?php
include '../../php/conexion.php';

try {
    $db = new Conexion();
    $conn = $db->getConnect();

    // Obtener todos los tests existentes
    $sql = "SELECT tes_id, tes_titulo, tes_descripcion, tes_fecha_creacion 
            FROM test 
            ORDER BY tes_id ASC";
    $stmt = $conn->query($sql);
    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tests</title>

    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/psicologo/lista_tests.css">
    <link rel="stylesheet" href="../../Css/Repetivos/sidebar.css">
</head>

<body>

    <?php include '../../php/Components/Sidebar_p.php'; ?>

    <div class="container">
        <h2>Lista de Tests Disponibles</h2>

        <table class="tabla-tests">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha de creación</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($tests)): ?>
                    <?php foreach ($tests as $test): ?>
                        <tr>
                            <td><?= $test['tes_id'] ?></td>
                            <td><?= htmlspecialchars($test['tes_titulo']) ?></td>
                            <td><?= htmlspecialchars($test['tes_descripcion']) ?></td>
                            <td><?= $test['tes_fecha_creacion'] ?></td>

                            <td>
                                <a class="btn-ir" href="realizar_test.php?id=<?= $test['tes_id'] ?>">
                                    Realizar test
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No hay tests registrados 😢</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
