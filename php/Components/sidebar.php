<?php

// Verifica que la variable de rol exista antes de usarla
$rol_id_actual = $_SESSION['rol_id'] ?? null;

$clase_tema = '';
if ($rol_id_actual == 1) {
    // Si Rol_id es 1 (Aprendiz)
    $clase_tema = 'aprendiz-tema';
} elseif ($rol_id_actual == 2) {
    // Si Rol_id es 2 (Psicólogo)
    $clase_tema = 'psicologo-tema';
}
?>

<link rel="stylesheet" href="../../Css/Repetivos/sidebar.css">


<nav id="nav-saludbe" class="<?php echo $clase_tema; ?>">
    <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
    <div class="logo">SaludBE</div>
</nav>

<!-- Menú lateral -->
<div class="sidebar <?php echo $clase_tema; ?>" id="sidebar">
    <ul>
        <?php
        // -----------------------------------------------------------------
        // CONTROL DE VISIBILIDAD BASADO EN ROL_ID
        // -----------------------------------------------------------------

        if ($rol_id_actual == 1): // Rol 1: Aprendiz 
        ?>
            <li><a href="../../Html/Aprendiz/PaginaPrincipal.php">Inicio</a></li>
            <li><a href="../../Html/Aprendiz/solicitarCitaApr.php">Agendar citas</a></li>
            <li><a href="../../Html/Aprendiz/Historial.php">Seguimiento</a></li>
            <li><a href="../../Html/Aprendiz/calendario.php">Calendario</a></li>
            <li><a href="../../php/chat/chat.php">Chat</a></li>
            <li><a href="../../Html/Aprendiz/test.php">Test</a></li>
            <li><a href="../../php/chat-bot/Chat.php">Chat Bot</a></li>
            <li><a href="../../Html/Aprendiz/configuracion.php">Configuraciones</a></li>


        <?php elseif ($rol_id_actual == 2): // Rol 2: Psicólogo 
        ?>
            <li><a onclick="mostrarSeccion('Psicologo-PaginaPrincipal')">
                    Inicio</a></li>
            <li><a onclick="mostrarSeccion('Psicologo-ListadoUsuarios')"> Lista De
                    Pacientes</a></li>
            <li><a onclick="mostrarSeccion('Psicologo-Historial')">
                    Historial Clinico</a></li>
            <li><a onclick="mostrarSeccion('Psicologo-Calendario')">
                    Calendario</a></li>
            <li><a onclick="mostrarSeccion('Chat')">Chat</a></li>
            <li><a onclick="mostrarSeccion('Psicologo-CrearTest')">Crear test</a></li>
            <li><a onclick="mostrarSeccion('Psicologo-ResultTest')">Resultado Test</a></li>
            <li><a onclick="mostrarSeccion('Psicologo-Configuracion')"> Configuración</a></li>
        <?php endif; ?>

        <?php if ($rol_id_actual): ?>
            <li><a onclick="mostrarSeccion('chat-bot')">ChatBot</a></li>
            <li><a href="../../Html/Index.html">Cerrar Sesión</a></li>
        <?php endif; ?>
    </ul>
</div>

<!-- Fondo oscuro -->
<div class="overlay" id="overlay"></div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const nav = document.getElementById("nav-saludbe");



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