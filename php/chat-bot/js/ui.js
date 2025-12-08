// ui.js — funciones DOM para el chat (mejoradas)
// Exportadas para que chat.js las use

export function toggleDrawer() {
  const el = document.getElementById("drawer");
  if (el) el.classList.toggle("open");
}

export function openChat() {
  const app = document.querySelector(".app");
  if (app) app.classList.add("show");
  const input = document.getElementById("input");
  if (input) input.focus();
}

// Agrega mensaje del usuario con burbuja y timestamp
export function addUserMessage(text) {
  const box = document.getElementById("messages");
  if (!box) return;
  const div = document.createElement("div");
  div.className = "bubble user";
  div.innerHTML = `<div class="msg-content">${escapeHtml(text)}</div>
                   <div class="msg-meta">${timeNow()}</div>`;
  box.appendChild(div);
  box.scrollTop = box.scrollHeight;
}

// Agrega mensaje del bot con avatar, timestamp
export function addBotMessage(text) {
  const box = document.getElementById("messages");
  if (!box) return;
  const div = document.createElement("div");
  div.className = "bubble bot";
  div.innerHTML = `<div class="avatar-bot">SB</div>
                   <div class="msg-wrapper">
                     <div class="msg-content">${escapeHtml(text)}</div>
                     <div class="msg-meta">${timeNow()}</div>
                   </div>`;
  box.appendChild(div);
  box.scrollTop = box.scrollHeight;
}

// Mostrar indicador de typing (bot)
let typingEl = null;
export function showTyping() {
  const box = document.getElementById("messages");
  if (!box) return;
  if (typingEl) return; // ya existe
  typingEl = document.createElement("div");
  typingEl.className = "bubble bot typing";
  typingEl.innerHTML = `<div class="avatar-bot">SB</div>
                        <div class="msg-wrapper"><div class="dots"><span></span><span></span><span></span></div></div>`;
  box.appendChild(typingEl);
  box.scrollTop = box.scrollHeight;
}

export function hideTyping() {
  if (!typingEl) return;
  typingEl.remove();
  typingEl = null;
}

// Sugerencias (botones rápidos) bajo el chat
let suggestionContainer = null;
export function addSuggestionButtons(list, onClick) {
  clearSuggestions();
  const box = document.getElementById("messages");
  if (!box) return;
  suggestionContainer = document.createElement("div");
  suggestionContainer.className = "suggestions";
  list.forEach(item => {
    const btn = document.createElement("button");
    btn.className = "suggestion-btn";
    btn.textContent = item.label;
    btn.onclick = () => onClick(item);
    suggestionContainer.appendChild(btn);
  });
  box.appendChild(suggestionContainer);
  box.scrollTop = box.scrollHeight;
}

export function clearSuggestions() {
  if (suggestionContainer) {
    suggestionContainer.remove();
    suggestionContainer = null;
  }
}

// Helper: hora formateada
function timeNow() {
  const d = new Date();
  const h = String(d.getHours()).padStart(2, "0");
  const m = String(d.getMinutes()).padStart(2, "0");
  return `${h}:${m}`;
}

// Escape sencillo para texto en HTML
function escapeHtml(s) {
  if (!s) return "";
  return s.replace(/[&<>"'`=]/g, function (c) {
    return {
      '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;', '`':'&#96;', '=':'&#61;'
    }[c];
  });
}
