router.php?test=ansiedad
router.php?test=adiccion
router.php?test=depresion
router.php?test=burnout

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SaludBE - Test Psicológicos</title>
  <link rel="stylesheet" href="../../Css/psicologo/test.css">
  <link rel="stylesheet" href="../../Css/Repetivos/sidebar.css">
  <link rel="stylesheet" href="../../Css/Repetivos/root.css">
</head>

<body>

  <?php include '../../php/Components/Sidebar_p.php'; ?>

  <div class="container">

    <main class="main-content">

      <p class="subtitle">Test Psicológicos Disponibles</p>

      <section class="test-grid">

        <div class="test-card">
          <img src="" alt="Test de ansiedad social">
          <div class="test-label">Test de ansiedad social</div>
          <button class="test-btn" data-test="Test de ansiedad social">Crear test</button>
        </div>

        <div class="test-card">
          <img src="" alt="Test de adicción al internet">
          <div class="test-label">Test de adicción al internet</div>
          <button class="test-btn" data-test="Test de adicción al internet">Crear test</button>
        </div>

        <div class="test-card">
          <img src="" alt="Test de depresión">
          <div class="test-label">Test de depresión</div>
          <button class="test-btn" data-test="Test de depresión">Crear test</button>
        </div>

        <div class="test-card">
          <img src="" alt="Test de burnout">
          <div class="test-label">Test de burnout</div>
          <button class="test-btn" data-test="Test de burnout">Crear test</button>
        </div>

      </section>

    </main>
  </div>

  <!-- MODAL PARA CREAR O INICIAR TEST -->
  <div id="testModal" class="modal">
    <div class="modal-content">
      <span class="close-modal">&times;</span>

      <h2 id="modal-title">Crear test</h2>

      <p id="modal-description"></p>

      <button id="crearTestBtn" class="btn-modal-action">Crear este test</button>
    </div>
  </div>

<script src="../../Js/test.js"></script>

</body>

</html>
