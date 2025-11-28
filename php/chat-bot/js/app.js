import { makeResponse, applyCostenoMode } from "./ai-engine.js";
import { addBotMessage, addUserMessage, toggleDrawer, openChat } from "./ui.js";

let costenoMode = false;

document.addEventListener("DOMContentLoaded", () => {

  // botones principales
  document.getElementById("menuBtnTop").onclick = toggleDrawer;
  document.getElementById("openFab").onclick = openChat;

  // enviar mensaje
  document.getElementById("sendBtn").onclick = sendMessage;
  document.getElementById("input").addEventListener("keydown", e => {
    if (e.key === "Enter") sendMessage();
  });

  // toggle costeño
  document.getElementById("costenoToggle").onchange = (e) => {
    costenoMode = e.target.checked;
    document.getElementById("costeñoBadge").style.display = costenoMode ? "inline-block" : "none";
  };

  // ejercicios
  document.getElementById("exerciseBtn").onclick = () => {
    addBotMessage("Vamos a respirar: Inhala 4s, sostén 2s, exhala 6s...");
  };

  // contacto
  document.getElementById("contactBtn").onclick = () => {
    addBotMessage("¿Quieres que te deje el número de ayuda?");
  };

});
  

function sendMessage() {
  const input = document.getElementById("input");
  const text = input.value.trim();
  if (!text) return;

  addUserMessage(text);
  input.value = "";

  let reply = makeResponse(text);

  if (costenoMode) {
    reply = applyCostenoMode(reply);
  }

  addBotMessage(reply);
}
