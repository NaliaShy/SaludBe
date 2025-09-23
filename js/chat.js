function sendMessage() {
  const input = document.getElementById("messageInput");
  const chat = document.getElementById("chat-messages");

  if (input.value.trim() !== "") {
    const newMsg = document.createElement("div");
    newMsg.classList.add("msg", "sent");
    newMsg.textContent = input.value;

    chat.appendChild(newMsg);
    chat.scrollTop = chat.scrollHeight;

    input.value = "";
  }
}
// Historial de chats
let chats = {
  "Aprendis-1": [
    { type: "received", text: "Hola, ¿cómo estás?" },
    { type: "sent", text: "Todo bien, gracias. ¿Y tú?" },
    { type: "received", text: "Perfecto 😎" }
  ],
  "Psicologo-2": [
    { type: "received", text: "Buenos días, ¿cómo te sientes hoy?" }
  ],
  "Chatbot": [
    { type: "received", text: "¡Hola! Soy tu asistente virtual 🤖" }
  ]
};

let currentUser = "Aprendis-1";

// Renderizar mensajes
function renderMessages(user) {
  const chatBox = document.getElementById("chat-messages");
  chatBox.innerHTML = "";

  chats[user].forEach(msg => {
    const div = document.createElement("div");
    div.classList.add("msg", msg.type);
    div.textContent = msg.text;
    chatBox.appendChild(div);
  });
}

// Cambiar de chat al hacer clic
document.querySelectorAll(".chat-sidebar li").forEach(li => {
  li.addEventListener("click", () => {
    document.querySelector(".chat-sidebar li.active")?.classList.remove("active");
    li.classList.add("active");

    currentUser = li.getAttribute("data-user");
    document.getElementById("chatUser").textContent = currentUser;
    renderMessages(currentUser);
  });
});

// Enviar mensaje
function sendMessage() {
  const input = document.getElementById("messageInput");
  const text = input.value.trim();
  if (text === "") return;

  chats[currentUser].push({ type: "sent", text });
  renderMessages(currentUser);
  input.value = "";
}

// Render inicial
renderMessages(currentUser);
