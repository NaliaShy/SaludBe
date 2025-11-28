export function toggleDrawer() {
  document.getElementById("drawer").classList.toggle("open");
}

export function openChat() {
  document.querySelector(".app").classList.add("show");
}

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
