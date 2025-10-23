<?php
// Establecer conexión con la base de datos
$conexion = mysqli_connect("localhost", "root", "", "saludBE");

// Verificar la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener datos del formulario
$documento = $_POST['documento'];
$contrasena = $_POST['contrasena'];

// Verificar si el aprendiz existe en la base de datos
$consulta = "SELECT * FROM aprendiz WHERE documento = '$documento' AND contrasena = '$contrasena'";
$resultado = mysqli_query($conexion, $consulta);

if (mysqli_num_rows($resultado) == 1) {
    // Iniciar sesión y redirigir al usuario
    session_start();
    $_SESSION['documento'] = $documento;
    header("Location: ../html/homeAprendiz.html");
    exit();
} else {
    // Si las credenciales son incorrectas, redirigir al login
    header("Location: ../html/loginAprendiz.html?error=1");
    exit();
}

// Cerrar la conexión
mysqli_close($conexion);
?>