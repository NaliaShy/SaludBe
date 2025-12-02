<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Historial Clínico - SaludBE</title>
  <link rel="stylesheet" href="../../Css/Psicologo/Historial.css" />
  <link rel="stylesheet" href="../../Css/Repetivos/sidebar.css">
  <link rel="stylesheet" href="../../Css/Repetivos/root.css">

</head>

<body>
  <?php include '../../php/Components/sidebar.php'; ?>

  <!-- Contenido principal -->
  <div class="container">
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
    function toggleMenu() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      if (sidebar.style.left === '0px') {
        sidebar.style.left = '-250px';
        overlay.style.display = 'none';
      } else {
        sidebar.style.left = '0px';
        overlay.style.display = 'block';
      }
    }

    // Botón Descargar
    document.getElementById('btn-descargar').addEventListener('click', function () {
      alert('El historial clínico ha sido descargado.');
    });

    // Botón Editar
    document.getElementById('btn-editar').addEventListener('click', function () {
      alert('El historial clínico ha sido editado.');
    });
  </script>

</body>

</html>