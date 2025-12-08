
<?php
require_once 'C:\laragon\www\SaludBe\php\Conexion\Conexion.php';

$db = new Conexion();
$conn = $db->getConnect(); // <--- Creación de la conexión

// 🚨 CÓDIGO DE DEPURACIÓN CRÍTICO 🚨
if ($conn instanceof PDO) {
    echo "<script>console.log('CONEXIÓN ÉXITO: \$conn es un objeto PDO válido.');</script>";
} else {
    // Si ves este mensaje, el fallo está DENTRO de la clase Conexion.php
    die("FATAL: El método getConnect() no devolvió un objeto PDO. Revisar Conexion.php.");
}
// 3. Verificación de Sesión
if (!isset($_SESSION['Us_id'])) {
    echo "No hay sesión activa.";
    exit();
}

// Guardamos el ID del usuario logueado
$idUsuario = $_SESSION['us_id'];

// 4. Ahora $conn debería ser reconocido
$stmt = $conn->prepare("SELECT Us_id, Us_nombre, Rol_id FROM usuarios WHERE Us_id = :id");
$stmt->bindParam(':id', $idUsuario);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit();
}
?>
<div class="chat-big-container" id="Chat" style="display: none;">
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
    <script>
        var usuarioLogueado = <?php echo $idUsuario; ?>;
    </script>

    <script src="../../js/Chat.js"></script>
</div>