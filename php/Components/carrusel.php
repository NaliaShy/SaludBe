<link rel="stylesheet" href="../../Css/Aprendiz/carrusel.css">

<?php
// Cargar imágenes del carrusel
include "../../Php/conexion.php";

$query = "SELECT * FROM carrusel ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="carousel-wrapper">
  <div class="carousel-container">

    <div class="carousel" id="slides-container">
      <?php  
      if (mysqli_num_rows($result) > 0) {
          $first = true;

          while ($row = mysqli_fetch_assoc($result)) {
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
                // Limpiar carrusel
                slidesContainer.innerHTML = "";

                // Insertar imágenes
                imagenes.forEach((img, index) => {
                    slidesContainer.innerHTML += `
                        <div class="slide ${index === 0 ? 'active' : ''}" style="background-image: url('${img}')"></div>
                    `;
                });
            });
    }

    // Ejecutar cada 5 segundos (5000ms)
    setInterval(actualizarCarrusel, 5000);

    // Ejecutar apenas cargue la página
    actualizarCarrusel();
});
</script>
