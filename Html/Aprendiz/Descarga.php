<?php
session_start();

// ✅ Validación correcta usando los nombres de sesión del login
if (!isset($_SESSION['us_id'])) {
    header("Location: ../../Html/Login/Loginaprendiz.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SaludBE</title>

    <link rel="stylesheet" href="../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../Css/Aprendiz/descarga.css" />
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
        setTimeout(() => {
            window.location.href = "frase_dia.php";
        }, 3000);
    </script>

</body>

</html>
