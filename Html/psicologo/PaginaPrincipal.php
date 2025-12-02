<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Página Principal</title>

  <!-- TUS CSS -->
  <link rel="stylesheet" href="../../Css/Repetivos/root.css">
  <link rel="stylesheet" href="../../Css/psicologo/PaginaPrincipal.css" />

  <!-- CSS del upload -->
  <link rel="stylesheet" href="../../Css/psicologo/carrusel-upload.css">
</head>

<body>
  <?php include '../../php/Components/sidebar.php'; ?>

  <!-- CONTENIDO PRINCIPAL -->
  <div class="main-content">

    <h1>SaludBE</h1>

    <img
      src="https://www.sena.edu.co/Style%20Library/alayout/images/logoSena.png?rev=40"
      alt="Saludbe Logo"
      style="width: 200px; margin-bottom: 20px;" />

    <div id="Psicologo-PaginaPrincipal">
      <div class="upload-box" id="uploadBox">
        <p>Arrastra aquí una imagen<br>o haz clic para seleccionar</p>

        <!-- 🔥 INPUT CORREGIDO 🔥 -->
        <input type="file" id="fileInput" name="imagen" accept="image/*" hidden>
      </div>

      <!-- ⭐ Preview ⭐ -->
      <div id="previewContainer" class="preview-container" style="display:none;">
        <h3>Vista previa:</h3>
        <img id="imagePreview" class="preview-img">
      </div>

      <!-- ⭐ Popup ⭐ -->
      <div id="popupNotification" class="popup-notification"></div>

      <!-- ⭐ Historial ⭐ -->
      <h3 style="margin-top:20px;">Imágenes subidas:</h3>
      <div id="historial" class="historial-container"></div>

    </div>
  </div>
  <!-- Script menú -->
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
  </script>

  <!-- Script de cargar/subir imágenes -->
  <script src="../../js/upload_carrusel.js"></script>

</body>

</html>