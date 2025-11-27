export function addUserMessage(text) {
  const box = document.getElementById("messages");
  const div = document.createElement("div");
  div.className = "bubble user";
  div.textContent = text;
  box.appendChild(div);
  box.scrollTop = box.scrollHeight;
}

export function addBotMessage(text) {
  const box = document.getElementById("messages");
  const div = document.createElement("div");
  div.className = "bubble bot";
  div.textContent = text;
  box.appendChild(div);
  box.scrollTop = box.scrollHeight;
}

export function toggleDrawer() {
  document.getElementById("drawer").classList.toggle("open");
}

export function openChat() {
  window.scrollTo({ top: 0, behavior: "smooth" });
}
document.getElementById("exerciseBtn").onclick = ()=>{
  addBotMessage(
    "Vamos a respirar juntos:\n\n" +
    "⭐ Inhala 4 segundos...\n" +
    "⭐ Mantén 2 segundos...\n" +
    "⭐ Exhala 6 segundos...\n\n" +
    "Repite esto 5 veces conmigo."
  );
};
document.getElementById("contactBtn").onclick = ()=>{
  addBotMessage(
    "Claro, llave. Aquí tienes contacto directo:\n\n" +
    "📞 Línea 106 — Atención psicológica 24/7\n" +
    "📞 Línea 123 — Emergencias\n" +
    "🌐 Línea internacional (OMS): https://www.who.int\n\n" +
    "¿Quieres que te acompañe mientras llamas?"
  );
};
