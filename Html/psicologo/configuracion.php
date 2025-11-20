<?php
session_start();
// NOTA: Revisar si la ruta '../../php/conexion.php' es correcta para el entorno real.
include_once '../../php/conexion.php'; 

// 1. Verificar sesión y obtener ID de usuario
if (!isset($_SESSION['us_id'])) {
    header("Location: ../Html/Login/Loginpsicologo.html"); 
    exit();
}

$userId = $_SESSION['us_id'];
$userData = [
    'nombre_completo' => '',
    'email' => '',
    'documento' => '',
    'tipo_documento' => '',
];

// **********************************************
// NUEVA LÓGICA: Forzar siempre la pestaña 'General' como activa
// **********************************************
$isGeneralActive = 'active';
$isActualizarActive = '';


// 2. Obtener datos actuales del usuario para pre-llenar el formulario
try {
    $db = new Conexion();
    $conexion = $db->getConnect();
    
    // Consulta actualizada: Incluye JOIN a tipo_usuarios para obtener el nombre del tipo de documento
    $sql = "SELECT 
                u.Us_nombre, 
                u.Us_apellios, 
                u.Us_correo,
                u.Us_documento,
                t.Ti_rol AS Tipo_documento
            FROM usuarios u
            JOIN tipo_usuarios t ON u.Ti_id = t.Ti_id
            WHERE u.Us_id = ?";
            
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$userId]); 
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $userData['nombre_completo'] = htmlspecialchars($user['Us_nombre'] . ' ' . $user['Us_apellios']);
        $userData['email'] = htmlspecialchars($user['Us_correo']);
        // Datos de documento añadidos
        $userData['documento'] = htmlspecialchars($user['Us_documento']);
        $userData['tipo_documento'] = htmlspecialchars($user['Tipo_documento']);
    }

} catch (PDOException $e) {
    // Manejo de errores de base de datos
    error_log("Error al cargar datos del usuario para configuración: " . $e->getMessage());
    $_SESSION['notificacion_error'] = "Error al cargar datos: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Configuraciones</title>
    <link rel="stylesheet" href="../../Css/Psicologo/configuaracion.css">
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
</head>

<body>
    <?php 
    include '../../php/Components/Sidebar_p.php'; 
    ?>
    <?php 
    // NOTA: Corregí el include a notificaciones_p.php (asumiendo que 'p' es de psicólogo)
    include '../../php/Components/notificaciones_a.php'; 
    ?>

    <div class="config-container">
        <div class="tabs">
            <!-- Pestaña General siempre 'active' por defecto al cargar -->
            <div class="tab <?= $isGeneralActive ?>" onclick="showSection('general', this)">General</div>
            <div class="tab <?= $isActualizarActive ?>" onclick="showSection('actualizar', this)">Actualizar Datos</div>
        </div>
        
        <!-- Sección General siempre 'active' por defecto al cargar -->
        <div id="general" class="section <?= $isGeneralActive ?>">
            <h2 class="section-title">Ajustes Generales de la Cuenta</h2>
            <p>Desde aquí puedes gestionar el estado de tu cuenta de psicólogo.</p>
            <button class="config-btn danger">Eliminar Cuenta</button>
            <button class="config-btn" style="margin-top: 20px;"
                onclick="window.location.href='PaginaPrincipal.php'">Volver</button>
        </div>

        <!-- Sección Actualizar Datos sin clase 'active' por defecto -->
        <div id="actualizar" class="section <?= $isActualizarActive ?>">
            <h2 class="section-title">Actualizar Información Personal</h2>
            <!-- Formulario con ACTION a la ruta correcta -->
            <form method="POST">
                
                <!-- Campos de Documento (Solo Lectura) -->
                <label for="tipo_documento">Tipo de Documento:</label>
                <input type="text" id="tipo_documento" name="tipo_documento" 
                       value="<?= $userData['tipo_documento'] ?? '' ?>" 
                       readonly 
                       style="background-color: #f0f0f0; cursor: not-allowed;">
                
                <label for="numero_documento">Número de Documento:</label>
                <input type="text" id="numero_documento" name="numero_documento" 
                       value="<?= $userData['documento'] ?? '' ?>" 
                       readonly 
                       style="background-color: #f0f0f0; cursor: not-allowed;">
                
                <!-- Campos Actualizables -->
                <label for="nombre_completo">Nombre completo (Nombre y Apellido):</label>
                <input type="text" id="nombre_completo" name="nombre_completo" 
                       value="<?= $userData['nombre_completo'] ?>" required>
                
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" 
                       value="<?= $userData['email'] ?>" required>
                
                <label for="password">Nueva Contraseña (Dejar vacío para no cambiar):</label>
                <div style="display: flex; align-items: center;">
                    <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" style="flex: 1;">
                    <button type="button" onclick="togglePassword()"
                        style="margin-left: -35px; background: none; border: none; cursor: pointer; color: #666;">
                        <span id="eye">👁️</span>
                    </button>
                </div>

                <p class="nota">Si solo quieres actualizar tu nombre o correo, deja el campo de contraseña vacío.</p>
                
                <button class="config-btn primary" type="submit" style="margin-top: 20px;">Guardar Cambios</button>
            </form>
        </div>
    </div>
    
    <!-- LÓGICA DE JS -->
    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eye');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.innerHTML = '&#128065;'; // Ojo abierto
            } else {
                pwd.type = 'password';
                eye.innerHTML = '&#128064;'; // Ojo cerrado
            }
        }

        // Función para cambiar de sección y manejar la clase 'active' en las pestañas
        function showSection(sectionId, clickedTab) {
            // Remover 'active' de todas las secciones
            document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
            // Remover 'active' de todas las pestañas
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            
            // Añadir 'active' a la sección y pestaña correspondiente
            document.getElementById(sectionId).classList.add('active');
            if (clickedTab) {
                clickedTab.classList.add('active');
            } else {
                 // Esto solo se ejecuta si se llama sin clickear, lo cual es redundante ahora, pero mantiene el código limpio.
                document.querySelector(`.tabs [onclick*="${sectionId}"]`).classList.add('active');
            }
        }
    </script>
</body>

</html>