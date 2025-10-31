<?php
include 'conexion.php';

try {
    // Creamos la conexión usando la clase PDO
    $db = new Conexion();
    $conexion = $db->getConnect(); // 🔥 Obtenemos el objeto PDO

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $correo = trim($_POST['correo'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';

        if (empty($correo) || empty($contrasena)) {
            die("⚠️ Faltan datos del formulario (correo o contraseña vacíos).");
        }

        // 1️⃣ Buscamos al usuario por correo
        $sql = "SELECT Us_id, Us_documento, Us_contraseña FROM usuarios WHERE Us_correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2️⃣ Verificamos si existe el usuario
        if ($usuario) {
            // 3️⃣ Verificamos contraseña
            if (password_verify($contrasena, $usuario['Us_contraseña'])) {
                session_start();

                // Guardamos los datos en sesión
                $_SESSION['documento'] = $usuario['Us_documento'];
                $_SESSION['id_usuario'] = $usuario['Us_id']; // ✅ Este es el campo correcto

                // 4️⃣ Redirigimos al panel o página posterior
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
    }

} catch (PDOException $e) {
    // Error de base de datos
    error_log("PDO Exception en login: " . $e->getMessage());
    die("❌ Error de base de datos. Revisá los logs.");
} catch (Exception $e) {
    error_log("Exception en login: " . $e->getMessage());
    die("❌ Error interno: " . $e->getMessage());
}
?>
