<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaludBE</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Aprendiz/Calendario.css">
</head>

<body>
    <?php include '../../php/Components/Sidebar_a.php'; ?>

    <div class="calendar-container">
        <div class="calendar-header">
            <button id="prev-month">◀</button>
            <h2 id="month-year"></h2>
            <button id="next-month">▶</button>
        </div>
        <div class="calendar-weekdays">
            <div>Lun</div>
            <div>Mar</div>
            <div>Mié</div>
            <div>Jue</div>
            <div>Vie</div>
            <div>Sáb</div>
            <div>Dom</div>
        </div>
        <div class="calendar-grid" id="calendar"></div>
    </div>

    <?php include '../../php/Components/notificaciones_a.php'; ?>
    <script src="../../js/Calendario.js"></script>
</body>

</html>