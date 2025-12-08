<?php
// CARGA LA CONEXIÓN SIN IMPORTAR SI ES XAMPP O LARAGON
require_once __DIR__ . "/../../../php/Conexion/Conexion.php";

session_start();

// Crear conexión
$conexion = new Conexion();
$conn = $conexion->getConnect();

// OBTENER IMÁGENES DEL CARRUSEL
$query = $conn->prepare("SELECT imagen_nombre FROM carrusel WHERE estado = 'activo' ORDER BY id DESC");
$query->execute();
$imagenes = $query->fetchAll(PDO::FETCH_ASSOC);

// OBTENER NOMBRE DEL USUARIO LOGUEADO
$idUsuario = $_SESSION['Us_id'] ?? null;

if ($idUsuario) {
    $sql = "SELECT Us_nombre, Us_apellios FROM usuarios WHERE Us_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$idUsuario]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $nombre = $data['Us_nombre'];
        $apellido = $data['Us_apellios'];
    } else {
        $nombre = "Aprendiz";
        $apellido = "";
    }
} else {
    $nombre = "Aprendiz";
    $apellido = "";
}
?>

<!-- CONTENIDO HTML -->
<div id="Aprendiz-PaginaPrincipal" style="display: block;">

    <div class="Bienvenida-Perfil">
        <span>
            <img src="https://www.sena.edu.co/Style%20Library/alayout/images/logoSena.png?rev=40"
                alt="Saludbe Logo" id="LogoSaludBe" />
        </span>

        <h1>
            Bienvenid@, <?php echo htmlspecialchars($nombre); ?> <?php echo htmlspecialchars($apellido); ?>
        </h1>
    </div>

    <div class="carousel-wrapper">
        <div class="carousel-container">

            <div class="carousel" id="slides-container">
                <?php foreach ($imagenes as $img): ?>
                    <div class="slide">
                        <img src="../../../Uploads/carrusel/<?php echo $img['imagen_nombre']; ?>" alt="Imagen Carrusel">
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-button prev">&#8249;</button>
            <button class="carousel-button next">&#8250;</button>
            <div class="dots-container"></div>

        </div>
    </div>
</div>

<script src="../../js/carrusel.js"></script>
