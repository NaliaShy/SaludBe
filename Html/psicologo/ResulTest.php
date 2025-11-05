<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Centro de Configuraciones</title>
    <link rel="stylesheet" href="../../Css/Psicologo/ResulTest.css">
    <link rel="stylesheet" href="../../Css/Repetivos/sidebar.css">
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
</head>

<body>
   <?php include '../../php/Components/Sidebar_p.php'; ?>

        <h2 class="titulo">Ver Resutado </h2>

        <section class="tabla-result">
            <div class="fila">
                <div class="info">
                    <span class="nombre">Moises Saavedra</span>
                </div>
                <div class="acciones">
                    <button class="btn resultado">Resultado</button>

                </div>
            </div>

            <div class="fila">
                <div class="info">
                    <span class="nombre">Natalia Lizarazo</span>
                </div>
                <div class="acciones">
                    <button class="btn resultado">Resultado</button>


                </div>
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