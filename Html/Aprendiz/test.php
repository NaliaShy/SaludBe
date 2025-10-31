<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaludBE - Test Psicológicos</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Aprendiz/test.css">
</head>

<body>
    <?php include '../../php/Components/Sidebar_a.php'; ?>

    <div class="container">

        <main class="main-content">


            <p class="subtitle">Test Psicológicos Disponibles</p>

            <section class="test-grid">

                <div class="test-card">
                    <img src="/Img/ansiedad.webp" alt="Test de ansiedad social">
                    <div class="test-label">Test de ansiedad social</div>
                </div>

                <div class="test-card">
                    <img src="/Img/celular.webp" alt="Test de adicción al internet">
                    <div class="test-label">Test de adicción al internet</div>
                </div>

                <div class="test-card">
                    <img src="/Img/depre.jpg" alt="Test de depresion">
                    <div class="test-label">Test de depresion</div>
                </div>

                <div class="test-card">
                    <img src="/Img/estre.jpg" alt="Test de burnout">
                    <div class="test-label">Test de burnout</div>
                </div>

            </section>

        </main>
    </div>
    <?php include '../../php/Components/notificaciones_a.php'; ?>
</body>

</html>