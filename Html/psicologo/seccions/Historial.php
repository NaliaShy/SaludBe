<div id="Psicologo-Historial" style="display: none;">
  <h2>Historial Clínico</h2>

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
      <button id="btn-editar" class="btn">Editar</button>
      <button id="btn-Ver" class="btn">Ver</button>
    </div>
  </div>

  <div class="observacion-title">Observación</div>
  <textarea class="observacion-input" placeholder="Escribe aquí las observaciones del paciente..."></textarea>
</div>

<script>

  // Botón Descargar
  document.getElementById('btn-descargar').addEventListener('click', function() {
    alert('El historial clínico ha sido descargado.');
  });

  // Botón Editar
  document.getElementById('btn-editar').addEventListener('click', function() {
    alert('El historial clínico ha sido editado.');
  });
</script>

