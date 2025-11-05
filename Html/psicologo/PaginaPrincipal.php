<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página Principal</title>
        <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/psicologo/PaginaPrincipal.css" />

  </head>
  <body>
    <?php include '../../php/Components/Sidebar_p.php'; ?>

    <!-- Contenido principal -->
    <div class="main-content">
      
      <h1>SaludBE</h1>
      <img
        src="https://www.sena.edu.co/Style%20Library/alayout/images/logoSena.png?rev=40"
        alt="Saludbe Logo" />
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
  </script>
  </body>
</html>
