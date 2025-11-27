// Utilidades básicas
export const sleep = ms => new Promise(r=>setTimeout(r,ms));
export const randomChoice = arr => arr[Math.floor(Math.random()*arr.length)];


// ───────────────────────────────────────────────
// PALABRAS DE CRISIS (COMPLETAS Y SIN TILDES)
// ───────────────────────────────────────────────
export const crisisKeywords = [
  "suicid", "suicida", "suicidarme", "suicidarme", "me voy a suicidar",
  "matarme", "me quiero matar", "me quiero matas", "me quiero mata",
  "me voy a matar", "me voy a matas", "matar", "me mato",
  "quitarme la vida", "quitarme mi vida",
  "no quiero vivir", "ya no quiero vivir",
  "no puedo mas", "ya no puedo mas",
  "me rindo", "me rendi",
  "desaparecer", "quiero desaparecer",
  "cortarme", "cortar", "hacerme daño", "hacerme dano",
  "lastimarme",
  "acabar con todo",
  "terminar con todo",
  "irme pa siempre", "irme para siempre"
];


// ───────────────────────────────────────────────
// RESPUESTAS SEGURAS
// ───────────────────────────────────────────────
const variationPool = [
  "¿Querés que lo hablemos más despacio?",
  "Puedo acompañarte mientras lo contás.",
  "Estoy aquí contigo, ¿sí?"
];

const safeResponses = {
  normal: [
    "Gracias por confiar en mí.",
    "Te escucho con atención.",
    "Cuéntame un poquito más."
  ],
  depresion: [
    "Siento lo que estás viviendo, ¿qué fue lo más duro hoy?",
    "Estoy contigo en esto. No estás solo."
  ],
  ansiedad: [
    "Respira conmigo: inhala 4s... exhala 6s.",
    "Probemos grounding: dime 3 cosas que ves ahora mismo."
  ]
};


// ───────────────────────────────────────────────
// LIMPIAR TEXTO (sin tildes ni mayúsculas)
// ───────────────────────────────────────────────
function normalize(t){
  return t
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "");
}


// ───────────────────────────────────────────────
// CLASIFICADOR DE INTENTOS
// ───────────────────────────────────────────────
export function classifyIntent(text) {
  const t = normalize(text);

  if (crisisKeywords.some(k => t.includes(normalize(k)))) return "crisis";
  if (t.includes("hola")) return "saludo";
  if (t.includes("ansied")) return "ansiedad";
  if (t.includes("depres")) return "depresion";

  return "normal";
}


// ───────────────────────────────────────────────
// GENERADOR DE RESPUESTAS
// ───────────────────────────────────────────────
export function makeResponse(intent) {
  switch(intent){
    case "crisis":
      return "Me preocupa mucho lo que dices. Si estás en peligro, por favor contacta ayuda inmediata. ¿Estás acompañado ahora?";

    case "saludo":
      return "Hola, ¿cómo te sientes hoy?";

    case "ansiedad":
      return randomChoice(safeResponses.ansiedad);

    case "depresion":
      return randomChoice(safeResponses.depresion);

    default:
      return randomChoice([...safeResponses.normal, ...variationPool]);
  }
}
export function applyCostenoMode(text) {
  // Reemplazos costeños suaves
  return text
    .replace(/tú/g, "tu llave")
    .replace(/estoy/g, "toy")
    .replace(/amigo/g, "panita")
    .replace(/tranquilo/g, "relax bro")
    .replace(/hola/g, "oe llave")
    .replace(/¿/g, "¿")
}