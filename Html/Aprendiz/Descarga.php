<?php
session_start();

// Validar sesión: debe existir us_id
if (!isset($_SESSION['Us_id'])) {
    header("Location: ../../Html/Login/Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SaludBE</title>

    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/psicologo/carga.css">
</head>

<body>

    <img src="https://www.sena.edu.co/Style%20Library/alayout/images/logoSena.png?rev=40" alt="Logo SaludBE" />
    <h1>SaludBE</h1>

    <div class="loading-dots">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <script>
        // Espera 3 segundos y redirige
        setTimeout(() => {
            window.location.href = "../../Html/Aprendiz/frase_dia.php";
        }, 3000);
    </script>

</body>

</html>
