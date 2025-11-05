<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Página Principal</title>
  <link rel="stylesheet" href="../../Css/Repetivos/root.css">
  <link rel="stylesheet" href="../../Css/psicologo/Lista.css" />

</head>

<body>

    <?php include '../../php/Components/Sidebar_p.php'; ?>

    <div class="container">
        <h2>Lista de Aprendiz</h2>

        <form method="GET" action=""> 
            <div class="search-bar">
                <span class="icon">🔍</span>
                <input type="text" placeholder="Buscar aprendiz..." name="search_term"
                    value="<?php echo htmlspecialchars($_GET['search_term'] ?? ''); ?>">

                <button type="submit">Buscar</button>

                <button type="button">Filtro</button>
                <button type="button">Fecha</button>
            </div>
        </form>

        <?php include '../../php/mostrarusuarios.php'; ?>

        <div class="aprendiz-container">

            <?php if (!empty($aprendices)): ?>
                <div class="juegos-grid">
                    <?php foreach ($aprendices as $aprendiz): ?>
                        <div class="juego-card">
                            <h3><?= htmlspecialchars($aprendiz['Us_nombre']) ?></h3>
                            <p><?= htmlspecialchars($aprendiz['Us_apellios']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No hay aprendices registrados que coincidan con la búsqueda 😢</p>
            <?php endif; ?>
        </div>

        <?php
        if (isset($conn)) {
            $conn = null;
        }
        ?>

    </div>

</body>

</html>