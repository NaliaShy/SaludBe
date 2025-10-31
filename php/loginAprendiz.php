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

    // Instanciamos la conexión con PDO
    $db = new Conexion();
    $conexion = $db->getConnect();

    try {
        // 1️⃣ Buscamos el usuario por correo
        $sql = "SELECT Us_id, Us_documento, Us_contraseña FROM usuarios WHERE Us_correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // 2️⃣ Verificamos la contraseña
            if (password_verify($contrasena, $usuario['Us_contraseña'])) {

                // 3️⃣ Guardamos los datos en sesión
                $_SESSION['id_usuario'] = $usuario['Us_id'];        // 🔥 ID del usuario
                $_SESSION['documento'] = $usuario['Us_documento'];  // Documento

                // 4️⃣ También lo guardamos en una variable (por si querés usarla enseguida)
                $idUsuario = $usuario['Us_id'];

                // Redirigir al panel o siguiente página
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
