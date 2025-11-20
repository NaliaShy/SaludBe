<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página Principal</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/psicologo/Lista.css" />
    <!-- Se incluye jQuery para facilitar las llamadas AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        <?php 
        // Nota: Asumo que este archivo obtiene la lista de aprendices en la variable $aprendices
        include '../../php/mostrarusuarios.php'; 
        ?>

        <div class="aprendiz-container">

            <?php if (!empty($aprendices)): ?>
                <div class="juegos-grid">
                    <?php foreach ($aprendices as $aprendiz): ?>
                        <!-- MODIFICACIÓN CLAVE: Añadir el evento onclick y pasar el ID -->
                        <div class="juego-card" onclick="openModal('<?= htmlspecialchars($aprendiz['Us_id']) ?>')">
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

    <!-- ------------------------------------------------------------------ -->
    <!-- ESTRUCTURA DEL MODAL -->
    <!-- ------------------------------------------------------------------ -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">×</span>
            <div id="modal-body-content">
                <!-- Aquí se cargará la información del aprendiz vía AJAX -->
                <center>
                    <div class="loading-spinner"></div>
                    <p>Cargando información del aprendiz...</p>
                </center>
            </div>
        </div>
    </div>

    <!-- ------------------------------------------------------------------ -->
    <!-- LÓGICA JAVASCRIPT/AJAX -->
    <!-- ------------------------------------------------------------------ -->
    <script src="../../js//Lista.js">
        // Función para mostrar el modal y cargar los datos
        
    </script>
</body>

</html>