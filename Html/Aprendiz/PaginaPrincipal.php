

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página Principal</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Aprendiz/PaginaPrincipal.css">


</head>

<body>
    <?php include '../../php/Components/Sidebar_a.php'; ?>

    <div class="main-content">
        
        <img src="https://www.sena.edu.co/Style%20Library/alayout/images/logoSena.png?rev=40" alt="Saludbe Logo" width="200">
        <?php include '../../php/Components/carrusel.php'; ?>
    </div>

    <?php include '../../php/Components/notificaciones_a.php'; ?>
</body>
<script>
    window.onload = function() {
        const bienvenida = document.getElementById('bienvenida');
        bienvenida.classList.add("show");

        setTimeout(() => {
            bienvenida.classList.remove("show");
        }, 4000);
    }
</script>

</html>