<link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Repetivos/sidebar_A.css">
    <link rel="stylesheet" href="../../php/chat-bot/css/style.css">
<div class="chat-bot" id="chat-bot" style="display: none;">
<div class="topbar">
  <div class="brand">
    <img src="assers/avatar.png" alt="avatar">
    <div>
      <div class="title">SaludMental — Asistente</div>
      <div class="sub">Apoyo emocional • Respuestas seguras</div>
    </div>
  </div>

  <div>
    <button id="menuBtnTop" class="small">☰ Ajustes</button>
  </div>
</div>

<!-- FAB -->
<div class="fab-oval" id="openFab">
  <img src="assers/avatar.png" alt="avatar">
  <div>Hablar</div>
</div>

<!-- APP -->
<div class="app">
  <div class="chat-card">
    <div class="header">
      <div class="title-wrap">
        <img src="assers/avatar.png" class="small-avatar">
        <div>
          <div class="title">SaludMental — Asistente <span id="costeñoBadge" class="costeno-badge" style="display:none">COSTEÑO</span></div>
          <div class="sub">Apoyo emocional</div>
        </div>
      </div>
    </div>

    <div class="main-body">
      <div class="messages-wrap">
        <div id="messages" class="messages"></div>
        <div id="typingArea"></div>

        <div class="controls">
          <input id="input" placeholder="Escribe aquí..." autocomplete="off"/>
          <button id="sendBtn" class="btn">Enviar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- DRAWER -->
<div id="drawer" class="drawer-overlay">
  <div class="drawer-center">
    <img src="assers/avatar.png" class="drawer-avatar">

    <h3>Asistente Salud</h3>
    <p class="drawer-sub"> • Memoria local</p>
  </div>

  <div class="drawer-options">
    <button id="exerciseBtn" class="small">Ejercicio de respiración</button>
    <button id="contactBtn" class="small">Solicitar contacto</button>

    <label><input type="checkbox" id="costenoToggle"> Activar modo costeño</label>
    <label><input type="checkbox" id="showAvatarToggle" checked> Mostrar avatar al abrir</label>
    <label><input type="checkbox" id="autoOpenOnCrisis" checked> Abrir en crisis</label>
  </div>

  <div class="resource-box" id="resourceBox"></div>

</div>
</div>
<script type="module" src="js/ai-engine.js"></script>
<script type="module" src="js/ui.js"></script>
<script type="module" src="js/chat.js"></script>

