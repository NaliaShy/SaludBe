<?php
require "../Conexion/Conexion.php";

$URL_BASE = "http://localhost/SaludBE/";

// Iniciar sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

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

                $_SESSION['Us_id'] = $usuario['Us_id'];
                $_SESSION['documento'] = $usuario['Us_documento'];
                $_SESSION['Rol_id'] = $usuario['Rol_id'];

                $rutas_roles = [
                    1 => $URL_BASE . "Html/Aprendiz/Descarga.php",
                    2 => $URL_BASE . "Html/psicologo/descarga.php"
                ];

                $rol_actual = $usuario['Rol_id'];

                if (isset($rutas_roles[$rol_actual])) {
                    header("Location: " . $rutas_roles[$rol_actual]);
                    exit();
                } else {
                    $_SESSION['Mensaje'] = "❌ Rol sin ruta asignada.";
                    $_SESSION['Estilo'] = "error_rol";
                    header("Location: " . $URL_BASE . "Html/Login/Login.php");
                    exit();
                }

            } else {

                $_SESSION['Mensaje'] = "Contraseña incorrecta.";
                $_SESSION['Estilo'] = "Cont_incorecta";
                header("Location: " . $URL_BASE . "Html/Login/Login.php");
                exit();
            }

        } else {
            $_SESSION['Mensaje'] = "Correo incorrecto.";
            $_SESSION['Estilo'] = "Corre_incorecto";
            header("Location: " . $URL_BASE . "Html/Login/Login.php");
            exit();
        }

    } catch (PDOException $e) {
        echo "❌ Error en la consulta: " . $e->getMessage();
    }
}
?>
