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
        $sql = "SELECT Us_id, Us_documento, Us_contraseña, Rol_id FROM usuarios WHERE Us_correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {

            if (password_verify($contrasena, $usuario['Us_contraseña'])) {

                // ✅ Sesión correcta: usar los mismos nombres SIEMPRE
                $_SESSION['us_id'] = $usuario['Us_id'];
                $_SESSION['documento'] = $usuario['Us_documento'];
                $_SESSION['rol_id'] = $usuario['Rol_id'];

                if ($usuario['Rol_id'] == 1) {
                    header("Location: ../Html/Aprendiz/Descarga.php");
                    exit();
                } elseif ($usuario['Rol_id'] == 2) {
                    header("Location: ../Html/psicologo/descarga.php");
                    exit();
                } else {
                    echo "❌ Rol de usuario no reconocido.";
                    header("Location: ../Html/Login/Loginaprendiz.html");
                }

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
