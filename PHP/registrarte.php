<?php
/*$conn=new mysqli("localhost","root","","");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}*/
include 'Conexion.php';

if (isset($_POST['registrarte'])) {
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre completo'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $tipo = $_POST['tipo de docuemento'];
    $ficha = $_POST['numero de ficha'];
    $password = $_POST['password'];

    $verificar = $conn->query("SELECT documento FROM usuarios WHERE documento='$documento'");


    if ($verificar->num_rows > 0) {
        echo "<script>alert('Este docuemnto ya esta en uso');</script>";
    } else {

        $sql = "INSERT INTO usuarios (documento,nombre,apellidos,email,edad,sexo,password) VALUES('$documento','$nombre','$apellido','$email','$edad','$tipo','$ficha','$password')";


        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Guardado exitosamente');
          window.location.href = '/Html/Registrate.html';</script>";
        } else {
            echo "Error al guardar: " . $conn->error;
        }
    }
}

?>