<?php
session_start();
require_once('../../php/Conexion/Conexion.php');
$conexionObj = new Conexion();
$conexion = $conexionObj->getConnect(); // Esto es un objeto PDO

// 1. Verificar si el ID está en la sesión
if (!isset($_SESSION['Us_id'])) {
    die("No hay usuario en sesión.");
}
$usuario_id = $_SESSION['Us_id'];

// 2. Consulta con marcador de posición posicional (?)
$sql = "SELECT Us_nombre, Us_apellios
        FROM usuarios 
        WHERE Us_id = ?";

// PDO utiliza prepare()
$stmt = $conexion->prepare($sql);

if ($stmt) {

    if ($stmt->execute([$usuario_id])) {

        // 4. Obtener el resultado
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $nombre = $data['Us_nombre'];
            $apellido = $data['Us_apellios']; // Asegúrate de la ortografía: 'Us_apellidos'
        } else {
            $nombre = "Aprendiz";
            $apellido = "";
        }
    } else {
        // Error de ejecución
        $errorInfo = $stmt->errorInfo();
        die("Error al ejecutar la consulta: " . $errorInfo[2]);
    }
} else {
    // Error de preparación
    $errorInfo = $conexion->errorInfo();
    die("Error al preparar la consulta: " . $errorInfo[2]);
}

// 5. Cerrar la conexión (PDO la cierra automáticamente cuando el script termina)
// Ya no necesitas $stmt->close() ni $conexion->close()
?>

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


        if (!isset($_SESSION['Us_id'])) {
            header("Location: login.php");
            exit();
        }

        $idUsuario = $_SESSION['Us_id'];

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