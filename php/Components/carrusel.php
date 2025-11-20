<link rel="stylesheet" href="../../Css/Aprendiz/carrusel.css">

<?php
// Cargar imágenes del carrusel
require "../../Php/Conexion.php";

$conexion = new Conexion();
$conn = $conexion->getConnect();

$query = $conn->prepare("SELECT imagen_nombre FROM carrusel WHERE estado = 'activo' ORDER BY id DESC");
$query->execute();
$imagenes = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="carousel-wrapper">
  <div class="carousel-container">

    <div class="carousel" id="slides-container">
      <?php  
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
          // Si no hay imágenes en BD
          echo "
          <div class='slide active' style='background-image:url(\"https://i.pinimg.com/564x/20/a8/36/20a836b28a731563e14cc260471eceeb.jpg\")'></div>
          ";
      }
      ?>
    </div>

    <button class="carousel-button prev">&#8249;</button>
    <button class="carousel-button next">&#8250;</button>
    <div class="dots-container"></div>

  </div>
</div>

<script src="../../js/carrusel.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const slidesContainer = document.getElementById("slides-container");

    function actualizarCarrusel() {
        fetch("../../Php/obtener_carrusel_json.php")
            .then(res => res.json())
            .then(imagenes => {

                slidesContainer.innerHTML = "";

                imagenes.forEach((img, index) => {
                    slidesContainer.innerHTML += `
                        <div class="slide ${index === 0 ? 'active' : ''}" 
                             style="background-image: url('${img}')"></div>
                    `;
                });
            });
    }

    setInterval(actualizarCarrusel, 5000);
    actualizarCarrusel();
});
</script>
