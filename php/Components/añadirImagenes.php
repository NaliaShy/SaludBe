<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$conexionObj = new Conexion();
$conexion = $conexionObj->getConnect(); // Esto es un objeto PDO

// 1. Verificar si el ID está en la sesión
if (!isset($_SESSION['us_id'])) {
    die("No hay usuario en sesión.");
}
$usuario_id = $_SESSION['us_id'];

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

<!-- CONTENIDO PRINCIPAL -->
<div id="Psicologo-PaginaPrincipal" style="display: block;">

    <div class="Bienvenida-Perfil">
        <span>
            <img
                src="https://www.sena.edu.co/Style%20Library/alayout/images/logoSena.png?rev=40"
                alt="Saludbe Logo"
                id="LogoSaludBe" />
        </span>

        <h1>
            Bienvenid@, <?php echo htmlspecialchars($nombre); ?> <?php echo htmlspecialchars($apellido); ?>
        </h1>
    </div>

    <div class="acciones-psicologo">

        <div class="imagenes-carrusel">
            <!-- ⭐ Cuadro de arrastrar imagen ⭐ -->
            <div class="upload-box" id="uploadBox">
                <p>Arrastra aquí una imagen<br>o haz clic para seleccionar</p>

                <!-- 🔥 INPUT CORREGIDO 🔥 -->
                <input type="file" id="fileInput" name="imagen" accept="image/*" hidden>
            </div>

            <!-- ⭐ Preview ⭐ -->
            <div id="previewContainer" class="preview-container" style="display:none;">
                <h3>Vista previa:</h3>
                <img id="imagePreview" class="preview-img">
            </div>

            <!-- ⭐ Popup ⭐ -->
            <div id="popupNotification" class="popup-notification"></div>

            <!-- ⭐ Historial ⭐ -->
            <h3 style="margin-top:20px;">Imágenes subidas:</h3>
            <div id="historial" class="historial-container"></div>
        </div>
        <div class="notificaciones"></div>
    </div>

</div>