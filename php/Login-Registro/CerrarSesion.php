<?php
// 1. Siempre iniciar la sesión
session_start();

// Definir la URL base de tu aplicación para la redirección
// Asegúrate de que esta ruta sea la correcta, como hiciste en Login.php
$URL_BASE = "http://localhost/SaludBE/"; 

// 2. Limpiar todas las variables de sesión
$_SESSION = array();

// 3. Si se desea destruir la cookie de sesión, se debe hacer manualmente.
// Esto destruirá la cookie de sesión de PHP:
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Destruir la sesión por completo en el servidor
session_destroy();

// 5. Redirigir al usuario a la página de inicio de sesión
// Usamos la URL absoluta para asegurar que la redirección funcione
header("Location: " . $URL_BASE . "Html/Index.php");
exit(); 
?>