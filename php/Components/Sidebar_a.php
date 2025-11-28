<link rel="stylesheet" href="../../Css/Repetivos/sidebar_A.css">  

<!-- NAV superior -->
<nav>
  <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
  <div class="logo">SaludBE</div>
</nav>

<!-- Menú lateral -->
<div class="sidebar" id="sidebar">
  <ul>
    <li><a href="../../Html/Aprendiz/PaginaPrincipal.php">Inicio</a></li>
    <li><a href="../../Html/Aprendiz/solicitarCitaApr.php">Agendar citas</a></li>
    <li><a href="../../Html/Aprendiz/Historial.php">Seguimiento</a></li>
    <li><a href="../../Html/Aprendiz/calendario.php">Calendario</a></li>
    <li><a href="../../php/chat/chat.php">Chat</a></li>
    <li><a href="../../Html/Aprendiz/test.php">Test</a></li>  
    <li><a href="../../php/chat-bot/Chat.php">Chat Bot</a></li>  
    <li><a href="../../Html/Aprendiz/configuracion.php">Configuraciones</a></li>
    <li><a href="../../Html/Index.html">Cerrar Sesión</a></li>
  </ul>
</div>

<!-- Fondo oscuro -->
<div class="overlay" id="overlay"></div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    function toggleMenu() {
      sidebar.classList.toggle("active");
      overlay.classList.toggle("show");
    }

    // Permitir cerrar el menú al hacer clic fuera
    overlay.addEventListener("click", toggleMenu);

    // Hacer que toggleMenu sea accesible globalmente
    window.toggleMenu = toggleMenu;
  });
</script>

<?php echo "<!-- Sidebar cargada correctamente -->"; ?>
