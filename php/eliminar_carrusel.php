<?php
include "conexion.php";

$url = $_POST['url']; 
$nombre = basename($url);

$sql = "DELETE FROM carrusel WHERE imagen_nombre = '$nombre'";
mysqli_query($conn, $sql);

$ruta = "../Uploads/carrusel/" . $nombre;

if (file_exists($ruta)) {
    unlink($ruta);
    echo "eliminado";
} else {
    echo "no existe";
}
?>
