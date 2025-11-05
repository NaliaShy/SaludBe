<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seguimiento al Aprendiz - SaludBE</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Aprendiz/Historial.css" />

</head>

<body>
    <?php include '../../php/Components/Sidebar_a.php'; ?>

    <!-- Contenido principal -->
    <div class="container">
        <center>
            <h2>Seguimiento al Aprendiz</h2>
        </center>

        <div class="card">
            <div class="patient-info">
                <div class="profile-icon">👤</div>
                <div class="info-text">
                    <strong>Paciente</strong>
                    <span>Natalia Perez</span>
                    <span>Fecha<br>27/06/2025</span>
                </div>
            </div>
            <div>
                <button id="btn-descargar" class="btn">Descargar</button>
                <button id="btn-Ver" class="btn">Ver</button>
            </div>
        </div>

        <?php include '../../php/Components/notificaciones_a.php'; ?>

        <script>
            // Botón Descargar
            document.getElementById('btn-descargar').addEventListener('click', function() {
                alert('El Seguimiento al Aprendiz ha sido descargado.');
            });
        </script>

</body>

</html>