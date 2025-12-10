// chat.js — Orquestador mejorado del chatbot
import { makeResponse, applyCostenoMode } from "./ai-engine.js";
import {
  addBotMessage,
  addUserMessage,
  toggleDrawer,
  openChat,
  showTyping,
  hideTyping,
  addSuggestionButtons,
  clearSuggestions
} from "./ui.js";

let costenoMode = false;
let sending = false;
const STORAGE_KEY = "saludbe_chat_history_v1";
let history = []; // {from: 'user'|'bot', text, ts}

document.addEventListener("DOMContentLoaded", () => {
  // botones principales
  const menuBtn = document.getElementById("menuBtnTop");
  if (menuBtn) menuBtn.onclick = toggleDrawer;

  const fab = document.getElementById("openFab");
  if (fab) fab.onclick = () => {
    openChat();
    focusInput();
  };

  // enviar mensaje
  const sendBtn = document.getElementById("sendBtn");
  const input = document.getElementById("input");
  if (sendBtn) sendBtn.onclick = sendMessage;
  if (input) {
    input.addEventListener("keydown", e => {
      if (e.key === "Enter") sendMessage();
    });
  }

  // toggle costeño
  const costenoToggle = document.getElementById("costenoToggle");
  if (costenoToggle) costenoToggle.onchange = (e) => {
    costenoMode = e.target.checked;
    const badge = document.getElementById("costeñoBadge");
    if (badge) badge.style.display = costenoMode ? "inline-block" : "none";
  };

  // ejercicios y contacto (botones "rápidos")
  const exerciseBtn = document.getElementById("exerciseBtn");
  if (exerciseBtn) exerciseBtn.onclick = () => handleQuickAction("exercise");

  const contactBtn = document.getElementById("contactBtn");
  if (contactBtn) contactBtn.onclick = () => handleQuickAction("contact");

  // Cargar historia desde storage
  loadHistory();
  replayHistoryToUI();
});

function focusInput() {
  const input = document.getElementById("input");
  if (input) input.focus();
}

// Evita spam pulsando muy seguido
function disableInputTemp(ms = 800) {
  const input = document.getElementById("input");
  const btn = document.getElementById("sendBtn");
  if (input) input.disabled = true;
  if (btn) btn.disabled = true;
  setTimeout(() => {
    if (input) input.disabled = false;
    if (btn) btn.disabled = false;
    focusInput();
  }, ms);
}

// Maneja botones rápidos
function handleQuickAction(action) {
  if (action === "exercise") {
    // mandar mensaje del usuario implícito para mantener contexto
    processUserMessage("Ejercicio de respiración");
  } else if (action === "contact") {
    processUserMessage("Quiero contacto de ayuda");
  }
}

// Enviar mensaje from UI
export function sendMessage() {
  if (sending) return;
  const input = document.getElementById("input");
  if (!input) return;
  const text = input.value.trim();
  if (!text) return;

  input.value = "";
  processUserMessage(text);
}

// Core: procesa el texto del usuario y genera respuesta
async function processUserMessage(text) {
  // Guardar mensaje del usuario en UI e historial
  addUserMessage(text);
  pushHistory({ from: "user", text, ts: Date.now() });

  // Clear suggestions (si las hay)
  clearSuggestions();

  // Bloqueo temporal de input
  disableInputTemp(700);

  // Obtener respuesta del motor (puede usar memoria interna)
  let reply = makeResponse(text);

  // aplicar costeño si está activo
  if (costenoMode) reply = applyCostenoMode(reply);

  // Si el motor no devuelve nada, fallback
  if (!reply || typeof reply !== "string") {
    reply = "Lo siento, no entendí bien. ¿Puedes decirlo de otra forma?";
  }

  // Si el motor sugiere ejercicios o recursos, mostramos botones
  // (usamos heurística simple — el motor puede devolver texto con palabras clave)
  const willShowQuickButtons = /(respir|ejercicio|llamar|contacto|ayuda)/i.test(reply);

  // Simular typing con delay variable (más natural)
  await simulateTypingAndReply(reply, willShowQuickButtons);
}

// Simula typing humano y luego agrega la respuesta
async function simulateTypingAndReply(replyText, showQuickButtons = false) {
  sending = true;

  // Random delay: base + por longitud (entre 600ms y 2000ms)
  const base = 500;
  const perChar = 25;
  const delay = Math.min(2500, base + (replyText.length * perChar));
  showTyping(); // muestra indicador de typing

  // Espera
  await new Promise(r => setTimeout(r, Math.max(400, delay)));

  hideTyping();
  // Evitamos respuestas duplicadas consecutivas
  const lastBot = history.slice().reverse().find(h => h.from === "bot");
  if (lastBot && lastBot.text === replyText) {
    // Si el bot iba a repetir exactamente, suavizamos la respuesta
    replyText = replyText + " (y sigo aquí)"; 
  }

  addBotMessage(replyText);
  pushHistory({ from: "bot", text: replyText, ts: Date.now() });

  // Si el bot pidió una acción / recomendación, mostrar botones
  if (showQuickButtons) {
    const suggestions = buildSuggestionsFromReply(replyText);
    if (suggestions.length) addSuggestionButtons(suggestions, handleSuggestionClick);
  }

  sending = false;
}

// Construye botones rápidos a partir del texto de la respuesta (heurística)
function buildSuggestionsFromReply(reply) {
  const s = [];
  const t = reply.toLowerCase();
  if (t.includes("respir") || t.includes("ejercicio")) {
    s.push({ id: "do_breath", label: "Hacer respiración guiada" });
    s.push({ id: "video_relax", label: "Ver técnica breve" });
  }
  if (t.includes("llam") || t.includes("contacto") || t.includes("106") || t.includes("123")) {
    s.push({ id: "call_106", label: "Mostrar número de ayuda" });
    s.push({ id: "contact_support", label: "Contactar soporte" });
  }
  return s;
}

function handleSuggestionClick(sugg) {
  // acciones mapeadas
  if (sugg.id === "do_breath") {
    addBotMessage("Ok, vamos: Inhala 4s — sostén 4s — exhala 6s. Repite 4 veces.");
    pushHistory({ from: "bot", text: "Ok, vamos: Inhala 4s — sostén 4s — exhala 6s. Repite 4 veces.", ts: Date.now() });
  } else if (sugg.id === "video_relax") {
    addBotMessage("Te dejo un ejercicio corto: mira este video cuando puedas (abre en otra pestaña).");
    pushHistory({ from: "bot", text: "Te dejo un ejercicio corto: mira este video cuando puedas (abre en otra pestaña).", ts: Date.now() });
  } else if (sugg.id === "call_106") {
    addBotMessage("En Colombia, la Línea 106 está disponible. Si necesitas, llama ahora.");
    pushHistory({ from: "bot", text: "En Colombia, la Línea 106 está disponible. Si necesitas, llama ahora.", ts: Date.now() });
  } else if (sugg.id === "contact_support") {
    addBotMessage("Puedo tomar tu correo y avisar a soporte, o puedes escribir a soporte@saludbe.com");
    pushHistory({ from: "bot", text: "Puedo tomar tu correo y avisar a soporte, o puedes escribir a soporte@saludbe.com", ts: Date.now() });
  } else {
    // fallback: tratar como mensaje del usuario
    processUserMessage(sugg.label);
  }
  // quitar sugerencias
  clearSuggestions();
}

// ------- Historial en localStorage -------
function pushHistory(item) {
  history.push(item);
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(history.slice(-200))); // guardamos últimos 200
  } catch (e) {
    console.warn("No se pudo guardar historia:", e);
  }
}

function loadHistory() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    if (!raw) { history = []; return; }
    history = JSON.parse(raw) || [];
  } catch (e) {
    console.warn("Error cargando historia:", e);
    history = [];
  }
}

function replayHistoryToUI() {
  const box = document.getElementById("messages");
  if (!box) return;
  // Si hay historial, reproducirlo
  history.forEach(item => {
    if (item.from === "user") addUserMessage(item.text);
    else addBotMessage(item.text);
  });
  // Si no hubo interacción, saluda
  if (history.length === 0) {
    const welcome = "Hola, soy SaludBe. Si necesitas algo, escríbeme.";
    addBotMessage(welcome);
    pushHistory({ from: "bot", text: welcome, ts: Date.now() });
  }
}
