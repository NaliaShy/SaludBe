import { classifyIntent, makeResponse, crisisKeywords } from "./ai-engine.js";
import { addBotMessage, addUserMessage, toggleDrawer, openChat } from "./ui.js";

document.getElementById("menuBtnTop").onclick = toggleDrawer;
document.getElementById("openFab").onclick = openChat;

document.getElementById("sendBtn").onclick = sendMessage;
document.getElementById("input").addEventListener("keydown", e=>{
  if(e.key==="Enter") sendMessage();
});

let costenoMode = false;

document.getElementById("costenoToggle").onchange = (e)=>{
  costenoMode = e.target.checked;
  document.getElementById("costeñoBadge").style.display = costenoMode ? "inline-block" : "none";
};

function sendMessage(){
  const input = document.getElementById("input");
  const text = input.value.trim();
  if(!text) return;

  addUserMessage(text);
  input.value = "";

  const intent = classifyIntent(text);
  let reply = makeResponse(intent);

  if(costenoMode){
    reply = applyCostenoMode(reply);
  }

  addBotMessage(reply);
}
