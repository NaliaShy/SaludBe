<?php
include 'conexion.php';

// Iniciar sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if (empty($correo) || empty($contrasena)) {
        die("⚠️ Faltan datos del formulario (correo o contraseña vacíos).");
    }

    $db = new Conexion();
    $conexion = $db->getConnect();

    try {
        $sql = "SELECT Us_id, Us_documento, Us_contraseña FROM usuarios WHERE Us_correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            if (password_verify($contrasena, $usuario['Us_contraseña'])) {

                // ✅ Aquí corregimos los nombres de sesión
                $_SESSION['us_id'] = $usuario['Us_id'];
                $_SESSION['documento'] = $usuario['Us_documento'];

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

    } catch (PDOException $e) {
        echo "❌ Error en la consulta: " . $e->getMessage();
    }
}
?>
