<link rel="stylesheet" href="../../Css/Repetivos/sidebar.css">

<nav>
  <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
  <div class="logo">SaludBE</div>
</nav>

<div class="sidebar" id="sidebar">
    <ul>
        <li><a href="../../Html/psicologo/PaginaPrincipal.php">
                Inicio</a></li>
        <li><a href="../../Html/psicologo/Lista.php"> Lista De
                Pacientes</a></li>
        <li><a href="../../Html/psicologo/Historial.php">
                Historial Clinico</a></li>
        <li><a href="../../Html/psicologo/calendario.php">
                Calendario</a></li>
        <li><a href="../../Html/psicologo/chat.php">Chat</a></li>
        <li><a href="../../Html/psicologo/ResulTest.php">Resultado Test</a></li>
        <li><a href="../../Html/psicologo/configuracion.php"> Configuración</a></li>
        <li><a href="../../Html/Login/Loginpsicologo.html "> Cerrar Sesión</a></li>
    </ul>
</div>
<!-- Fondo oscuro -->
<div class="overlay" id="overlay" onclick="toggleMenu()"></div>

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