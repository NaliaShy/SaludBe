<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaludBE</title>

    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Aprendiz/frase_dia.css">
</head>

<body>
    <div class="header">
        <h1 class="logo">SaludBE</h1>
        <a href="../Aprendiz/PaginaPrincipal.php" class="skip">SALTAR</a>
    </div>

    <div class="phrase-box">
        <?php
        session_start();
        include '../../php/conexion.php';

        // ✅ Usar el MISMO nombre que viene del login
        if (!isset($_SESSION['us_id'])) {
            header("Location: login.php");
            exit();
        }

        $idUsuario = $_SESSION['us_id'];

        $db = new Conexion();
        $conexion = $db->getConnect();

        try {
            $sql = "SELECT Fs_contenido, Fs_fecha_creacion 
                    FROM frase_motivacional 
                    ORDER BY RAND() 
                    LIMIT 1";

            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $frase = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "❌ Error en la consulta: " . $e->getMessage();
        }
        ?>

        <?php if ($frase): ?>
            <div class="phrase-content">
                <p class="phrase-text">"<?php echo htmlspecialchars($frase['Fs_contenido']); ?>"</p>
                <p class="phrase-author">- <?php echo htmlspecialchars($frase['Fs_fecha_creacion']); ?></p>
            </div>
        <?php else: ?>
            <p class="no-phrase">No se encontró ninguna frase.</p>
        <?php endif; ?>

    </div>

    <script>
        // Espera 3 segundos y redirige a la página principal
        setTimeout(() => {
            window.location.href = "PaginaPrincipal.php";
        }, 3000);
    </script>

</body>

</html>