
<?php
// Cargar imágenes del carrusel
require "../../Php/Conexion.php";

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
      <?php  
      // ELIMINAR O COMENTAR TODA ESTA LÓGICA DE GENERACIÓN DE DIVS CON PHP
      /*
      if (count($imagenes) > 0) {
          $first = true;
          foreach ($imagenes as $row) {
              $img = "../../Uploads/carrusel/" . $row['imagen_nombre'];
              $active = $first ? "active" : "";
              $first = false;
              echo "
                <div class='slide $active' style='background-image: url(\"$img\");'></div>
              ";
          }
      } else {
          echo "
          <div class='slide active' style='background-image:url(\"...\")'></div>
          ";
      }
      */
      ?>
      </div>

    <button class="carousel-button prev">&#8249;</button>
    <button class="carousel-button next">&#8250;</button>
    <div class="dots-container"></div>

  </div>
</div>
<script src="../../js/carrusel.js"></script>