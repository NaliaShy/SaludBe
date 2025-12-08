<?php
include_once "../../php/Conexion/Conexion.php";

$conexion = new Conexion();
$conn = $conexion->getConnect();

$query = $conn->prepare("SELECT imagen_nombre FROM carrusel WHERE estado = 'activo' ORDER BY id DESC");
$query->execute();
$imagenes = $query->fetchAll(PDO::FETCH_ASSOC);


$idUsuario = $_SESSION['Us_id']; // ✅ AQUÍ SÍ
$sql = "SELECT Us_nombre, Us_apellios
        FROM usuarios 
        WHERE Us_id = ?";

// PDO utiliza prepare()
$stmt = $conn->prepare($sql);

if ($stmt) {

    if ($stmt->execute([$idUsuario])) {

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
    $errorInfo = $conn->errorInfo();
    die("Error al preparar la consulta: " . $errorInfo[2]);
}
?>
<div id="Aprendiz-PaginaPrincipal" style="display: block;">

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
  <div class="carousel-wrapper">
    <div class="carousel-container">

      <div class="carousel" id="slides-container">
      </div>

      <button class="carousel-button prev">&#8249;</button>
      <button class="carousel-button next">&#8250;</button>
      <div class="dots-container"></div>

    </div>
  </div>
</div>
  <script src="../../js/carrusel.js"></script>