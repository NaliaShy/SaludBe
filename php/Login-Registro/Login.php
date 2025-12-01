<?php
require "../Conexion/Conexion.php";

// Iniciar sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ... (código de validación de formulario) ...
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

                // ✅ Sesión correcta: guardar variables...
                $_SESSION['us_id'] = $usuario['Us_id'];
                $_SESSION['documento'] = $usuario['Us_documento'];
                $_SESSION['rol_id'] = $usuario['Rol_id'];

                // ===========================================
                // ✅ IMPRIMIR EL ID DE USUARIO (SOLO PRUEBA)

                
                // ===========================================
                echo "<script>console.log('Usuario ID: " . $usuario['Us_id'] . "');</script>";
                // ===========================================

                $rutas_roles = [
                    1 => "../../Html/Aprendiz/Descarga.php", 
                    2 => "../../Html/psicologo/descarga.php" 
                ];

                $rol_actual = $usuario['Rol_id'];

                if (isset($rutas_roles[$rol_actual])) {
                    header("Location: " . $rutas_roles[$rol_actual]);
                    exit();
                } else {
                    echo "❌ Rol de usuario no reconocido ($rol_actual).";
                    header("Location: ../../Html/Login/Loginaprendiz.html");
                    exit();
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