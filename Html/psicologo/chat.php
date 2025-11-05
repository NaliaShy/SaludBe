<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Psicólogo</title>
  <link rel="stylesheet" href="../../Css/Psicologo/chats.css">
  <link rel="stylesheet" href="../../Css/Repetivos/sidebar.css">
  <link rel="stylesheet" href="../../Css/Repetivos/root.css">
</head>
<body>

  <!-- Barra superior -->
 <?php include '../../php/Components/Sidebar_p.php'; ?>

  <!-- Contenedor del chat -->
  <div class="chat-container">
    <!-- Sidebar de mensajes -->
    <div class="chat-sidebar">
      <h2>Messages</h2>
      <ul>
        <li class="active" data-user="Aprendis-1">Aprendis-1 <span class="time">24m</span></li>
        <li data-user="Psicologo-2">Psicologo-2 <span class="time">5h</span></li>
        <li data-user="Chatbot">Chatbot <span class="time">15m</span></li>
      </ul>
    </div>

    <!-- Chat principal -->
    <div class="chat-box">
      <div class="chat-header">
        <h3 id="chatUser">Aprendis-1</h3>
        <span class="status">● Online</span>
      </div>

      <div class="chat-messages" id="chat-messages">
        <!-- Aquí se cargan los mensajes dinámicamente con chat.js -->
      </div>

      <div class="chat-input">
        <input type="text" id="messageInput" placeholder="Escribe un mensaje...">
        <button onclick="sendMessage()">➤</button>
      </div>
    </div>
  </div>

  <script>
    function toggleMenu() {
      const sidebar = document.getElementById("sidebar");
      const overlay = document.getElementById("overlay");
      sidebar.classList.toggle("active");
      overlay.classList.toggle("show");
    }
  </script>

  <script src="../../js/chat.js"></script>
</body>
</html>
