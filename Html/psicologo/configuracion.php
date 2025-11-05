<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Centro de Configuraciones</title>
    <link rel="stylesheet" href="../../Css/Psicologo/configuaracion.css">
    <link rel="stylesheet" href="../../Css/Repetivos/sidebar.css">
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
</head>

<body>
    <?php include '../../php/Components/Sidebar_p.php'; ?>
    <div class="config-container">
        <div class="tabs">
            <div class="tab active" onclick="showSection('general')">General</div>
            <div class="tab" onclick="showSection('actualizar')">Actualizar Datos</div>
        </div>
        <div id="general" class="section active">
            <button class="config-btn secondary">Cambiar Cuenta</button>
            <button class="config-btn" onclick="window.location.href='../Login/Loginpsicologo.html'">Cerrar
                Sesión</button>
            <button class="config-btn danger">Eliminar Cuenta</button>
            <button class="config-btn" style="margin-top: 20px;"
                onclick="window.location.href='paginaprincipal.html'">Volver</button>
        </div>

        <div id="actualizar" class="section">
            <form>
                <label for="tipo_doc">Tipo y número de documento:</label>
                <div style="display: flex; gap: 10px;">
                    <select id="tipo_doc" name="tipo_doc" style="flex: 1;">
                        <option value="CC">CC</option>
                        <option value="TI">TI</option>
                        <option value="CE">CE</option>
                    </select>
                    <input type="text" id="num_doc" name="num_doc" placeholder="123456789" style="flex: 2;">
                </div>
                <label for="nombre_completo">Nombre completo:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" placeholder="Ingresa tu nombre completo">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" placeholder="Example@soy.sena.edu.co">
                <label for="password">Contraseña:</label>
                <div style="display: flex; align-items: center;">
                    <input type="password" id="password" name="password" placeholder="Contraseña" style="flex: 1;">
                    <button type="button" onclick="togglePassword()"
                        style="margin-left: -35px; background: none; border: none; cursor: pointer;">
                        <span id="eye">&#128065;</span>
                    </button>
                </div>
                <button class="config-btn" type="submit" style="margin-top: 20px;">Actualizar</button>
            </form>
        </div>
        <script>
            function togglePassword() {
                const pwd = document.getElementById('password');
                const eye = document.getElementById('eye');
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    eye.textContent = '🙈';
                } else {
                    pwd.type = 'password';
                    eye.textContent = '👁️';
                }
            }
        </script>


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
        function showSection(section) {
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
            if (section === 'general') {
                document.querySelector('.tab:nth-child(1)').classList.add('active');
                document.getElementById('general').classList.add('active');
            } else {
                document.querySelector('.tab:nth-child(2)').classList.add('active');
                document.getElementById('actualizar').classList.add('active');
            }
        }
    </script>

</body>

</html>