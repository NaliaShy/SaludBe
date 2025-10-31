<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $motivo = $_POST['motivo'];

    $sql = "INSERT INTO citas (IdCita, fecha, hora, estado, motivo) VALUES ('$nombre', '$fecha', '$hora', '$motivo')";

    if ($conn->query($sql) === TRUE) {
        echo "Cita guardada exitosamente";
        header("Location: ../Html/Aprendiz/PaginaPrincipal.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>