<?php
require "../Conexion/Conexion.php";
$URL_BASE = "http:///localhost/SaludBE/"; 
// Iniciar sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ... (código de validación de formulario) ...
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // 🛑 CORRECCIÓN: Manejar datos faltantes con sesión y redirección
    if (empty($correo) || empty($contrasena)) {
        $_SESSION['Mensaje'] = "⚠️ Por favor, ingresa tu correo y contraseña.";
        $_SESSION['Estilo'] = "datos_faltantes"; 
        header("Location: " . $URL_BASE . "Html/Login/Login.php"); 
        exit();
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

                // ✅ Sesión correcta: guardar variables
                $_SESSION['Us_id'] = $usuario['Us_id'];
                $_SESSION['documento'] = $usuario['Us_documento'];
                $_SESSION['Rol_id'] = $usuario['Rol_id'];


                $rutas_roles = [
                    // Usar la URL absoluta completa
                    1 => $URL_BASE . "Html/Aprendiz/Descarga.php",
                    2 => $URL_BASE . "Html/psicologo/descarga.php"
                ];

                $rol_actual = $usuario['Rol_id'];

                if (isset($rutas_roles[$rol_actual])) {
                    // La redirección ahora es infalible porque usa la ruta completa
                    header("Location: " . $rutas_roles[$rol_actual]);
                    exit();
                } else {
                    // Si el rol no está mapeado, redirige al login
                    $_SESSION['Mensaje'] = "❌ Error: Tu rol de usuario (ID: " . $rol_actual . ") no tiene una ruta de destino configurada.";
                    $_SESSION['Estilo'] = "error_rol";
                    header("Location: " . $URL_BASE . "Html/Login/Login.php"); // USAR $URL_BASE
                    exit();
                }
            } else {

                $_SESSION['Mensaje'] = "Contraseña incorrecta.";
                $_SESSION['Estilo'] = "Cont_incorecta";
                header("Location: " . $URL_BASE . "Html/Login/Login.php"); // 🛑 CORRECCIÓN
                exit();
            }
        } else {
            $_SESSION['Mensaje'] = "Correo incorrecto.";
            $_SESSION['Estilo'] = "Corre_incorecto";
            header("Location: " . $URL_BASE . "Html/Login/Login.php"); // 🛑 CORRECCIÓN
            exit();
        }
    } catch (PDOException $e) {
        echo "❌ Error en la consulta: " . $e->getMessage();
    }
}
?>