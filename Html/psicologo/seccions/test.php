
router.php?test=ansiedad
router.php?test=adiccion
router.php?test=depresion
router.php?test=burnout


<div class="container" id="Psicologo-CrearTest" style="display: none;">

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

