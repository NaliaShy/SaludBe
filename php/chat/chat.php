<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['us_id'])) {
    echo "No hay sesión activa.";
    exit();
}

// Guardamos el ID del usuario logueado
$idUsuario = $_SESSION['us_id'];
include '../Conexion.php';
$db = new Conexion();
$conn = $db->getConnect();

// Consultar datos del usuario logueado
$stmt = $conn->prepare("SELECT Us_id, Us_nombre, Rol_id FROM usuarios WHERE Us_id = :id");
$stmt->bindParam(':id', $idUsuario);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat SaludBE</title>
    <link rel="stylesheet" href="/saludbe/css/repetivos/root.css">
    <link rel="stylesheet" href="/SaludBe/Css/Repetivos/chat.css">

</head>

<body>
    <?php
    if ($usuario['Rol_id'] == 1) {
        include '../../php/Components/Sidebar_a.php';
    } elseif ($usuario['Rol_id'] == 2) {
        include '../../php/Components/Sidebar_p.php';
    } else {
        echo "❌ Rol de usuario no reconocido.";
        header("Location: ../Html/Login/Loginaprendiz.html");
    }

    ?>
    <div class="chat-big-container">
        <div class="selector-chats">
            <h3>Usuarios</h3>
            <ul id="lista-usuarios"></ul>
        </div>
        <div class="chat-container">
            <div id="chat-messages"></div>
            <form id="chat-form">
                <input type="text" id="mensaje-input" placeholder="Escribe un mensaje..." autocomplete="off">
                <button type="submit" id="enviar-btn">Enviar</button>
            </form>
        </div>
    </div>

    <script>
        var usuarioLogueado = <?php echo $idUsuario; ?>;
    </script>

    <script src="../../js/Chat.js"></script>

</body>

</html>