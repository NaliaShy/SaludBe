<?php
session_start();

// Verificar si hay sesión activa
if(!isset($_SESSION['us_id'])){
    echo "No hay sesión activa.";
    exit();
}

// Guardamos el ID del usuario logueado
$idUsuario = $_SESSION['us_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat SaludBE</title>

<style>
body { font-family: Arial; display:flex; justify-content:center; padding-top:50px; }
.chat-container { width: 100%; max-width:500px; background:#fff; border-radius:10px; border:1px solid #ccc; display:flex; flex-direction:column; height:400px; }
#chat-messages { flex:1; overflow-y:auto; padding:10px; }
#chat-form { display:flex; border-top:1px solid #ccc; }
#mensaje-input { flex:1; padding:10px; border:none; outline:none; }
#enviar-btn { width:80px; border:none; background:#007bff; color:#fff; cursor:pointer; }
#enviar-btn:hover { background:#0056b3; }
</style>

</head>
<body>

<div class="chat-container">
    <div id="chat-messages"></div>
    <form id="chat-form">
        <input type="text" id="mensaje-input" placeholder="Escribe un mensaje..." autocomplete="off">
        <button type="submit" id="enviar-btn">Enviar</button>
    </form>
</div>

<script>
    var usuarioLogueado = <?php echo $idUsuario; ?>;
</script>

<script src="/SaludBe/js/chat.js"></script>

</body>
</html>
