<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if (empty($correo) || empty($contrasena)) {
        die("⚠️ Faltan datos del formulario (correo o contraseña vacíos).");
    }

    $sql = "SELECT Us_documento, Us_contraseña FROM usuarios WHERE Us_correo = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("❌ Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($contrasena, $usuario['Us_contraseña'])) {
            session_start();
            $_SESSION['documento'] = $usuario['Us_documento'];
            $_SESSION['id_usuario'] = $usuario['Id_Usuario']; // 🔥 Guardamos el ID numérico

            header("Location: ../Php/Descarga.php");
            exit();
        } else {
            echo "❌ Contraseña incorrecta.";
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
