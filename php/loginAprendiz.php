<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "natalia123", "saludBE");

// Verificar conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if (empty($correo) || empty($contrasena)) {
        die("⚠️ Faltan datos del formulario (correo o contraseña vacíos).");
    }

    // Preparar la consulta
    $sql = "SELECT Us_documento, Us_contraseña FROM usuarios WHERE Us_correo = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("❌ Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si el usuario existe
    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($contrasena, $usuario['Us_contraseña'])) {
            session_start();
            $_SESSION['documento'] = $usuario['Us_documento'];
            header("Location: ../Html/Aprendiz/descarga.html");
            exit();
        } else {
            // Mostrar mensaje de depuración
            echo "❌ Contraseña incorrecta.<br>";
            echo "Contraseña ingresada: $contrasena<br>";
            echo "Hash en BD: " . $usuario['Us_contraseña'] . "<br>";
            exit();
        }
    } else {
        echo "❌ Usuario no encontrado con el correo: $correo";
        exit();
    }

    $stmt->close();
}

$conexion->close();
?>
