<?php
include "../../php\Conexion\Conexion.php";

$conexion = new Conexion();
$conn = $conexion->getConnect();

$query = $conn->prepare("SELECT imagen_nombre FROM carrusel WHERE estado = 'activo' ORDER BY id DESC");
$query->execute();
$imagenes = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="../../Css/Aprendiz/carrusel.css">
<div class="carousel-wrapper">
  <div class="carousel-container">

    <div class="carousel" id="slides-container">
      </div>

    <button class="carousel-button prev">&#8249;</button>
    <button class="carousel-button next">&#8250;</button>
    <div class="dots-container"></div>

  </div>
</div>
<script src="../../js/carrusel.js"></script>