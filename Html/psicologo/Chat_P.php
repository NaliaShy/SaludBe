<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['us_id'])) {
    echo "<p>No hay sesión activa. Inicia sesión primero.</p>";
    exit();
}

// Guardar el ID del usuario logueado
$usuarioLogueado = $_SESSION['us_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Psicólogo 🧠</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Psicologo/Chats_P.css">
</head>

<body>
<?php include '../../php/Components/Sidebar_p.php'; ?>
<div class="chat-container">
    <div id="chat-messages"></div>

    <form id="chat-form">
        <input type="text" id="mensaje-input" placeholder="Escribe un mensaje..." autocomplete="off">
        <button type="submit" id="enviar-btn">Enviar</button>
    </form>
</div>

<script>
    // Pasamos el ID del usuario de PHP a JavaScript
    const usuarioLogueado = <?php echo json_encode($usuarioLogueado); ?>;
</script>

<script src="../../Js/Chat_P.js"></script>

</body>
</html>
