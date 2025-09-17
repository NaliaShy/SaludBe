<?php
/*$conn=new mysqli("localhost","root","","");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
} */
include 'Conexion.php';

if (isset($_POST['login'])) {
    $documento = $_POST['documento'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE documento='$documento' AND password='$password'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        echo "<script>alert('Bienvenido, Inicio de sesion exitoso');
      window.location.href = '/HTML/Pagina Principal';</script>";
    } else {
        echo "<script>alert('Documento o contraseña incorrecta');
      window.location.href = '/Html/login.html';</script>";
    }
}
?>