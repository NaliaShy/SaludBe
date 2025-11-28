// =====================================================
// AI ENGINE – CRISIS DETECTOR ULTRA + FLOW CORREGIDO
// =====================================================

export const normalize = (t) =>
  t.toLowerCase()
   .normalize("NFD")
   .replace(/[\u0300-\u036f]/g, "")
   .trim();

// --------------------------
// Detección de CRISIS
// --------------------------
const CRISIS_REGEX = [
  /suicid/,
  /matarme/,
  /matarme/,
  /me quiero matar/,
  /me quiero matas/,
  /me voy a matar/,
  /acabar conmigo/,
  /acabar todo/,
  /acabar esto/,
  /quitarme la vida/,
  /ya no quiero vivir/,
  /no vale la pena vivir/,
  /morirme/,
  /desaparecer/,
  /ya no doy mas/,
  /no doy mas/,
  /me rindo/,
  /terminar todo/,
];

export function isCrisis(text) {
  const t = normalize(text);
  return CRISIS_REGEX.some((re) => re.test(t));
}

// --------------------------
// MODO CRISIS (flujo)
// --------------------------
let crisisStep = 0;

const CRISIS_FLOW = [
  "Lo que dices es muy serio. ¿Hay alguien contigo ahora mismo?",
  "Gracias por responder. ¿Hay alguien a quien puedas llamar o escribir ahora mismo?",
  "Entiendo. ¿Algún familiar, amigo o vecino disponible cerca?",
  "Quiero que estés seguro. En Colombia puedes llamar a la Línea 106 o al 123. ¿Puedes intentarlo ahora?",
  "Estoy contigo. ¿Cómo te sientes en este momento?",
];

// --------------------------
// Respuestas normales
// --------------------------
const RESP = {
  saludo: [
    "Hola, ¿cómo te sientes hoy?",
    "Hola, aquí estoy contigo.",
  ],
  general: [
    "Te escucho con atención. Cuéntame más.",
    "Estoy aquí para ti. ¿Qué pasó?",
  ],
};

export function classifyIntent(text) {
  const t = normalize(text);

  if (isCrisis(t)) return "crisis";
  if (/hola|buenas|hey/.test(t)) return "saludo";

  return "general";
}

// --------------------------
// GENERADOR DE RESPUESTAS
// --------------------------
export function makeResponse(text) {
  const intent = classifyIntent(text);

  // --------------------------
  // Crisis detectada
  // --------------------------
  if (intent === "crisis") {
    crisisStep = 1;
    return CRISIS_FLOW[0];
  }

  // --------------------------
  // Continuación del flujo
  // --------------------------
  if (crisisStep > 0) {
    crisisStep++;

    // Máximo paso 5
    if (crisisStep > 5) crisisStep = 5;

    return CRISIS_FLOW[crisisStep - 1];
  }

  // --------------------------
  // Respuestas normales
  // --------------------------
  if (intent === "saludo") {
    return RESP.saludo[Math.floor(Math.random() * RESP.saludo.length)];
  }

  return RESP.general[Math.floor(Math.random() * RESP.general.length)];
}

// --------------------------
// MODO COSTEÑO
// --------------------------
export function applyCostenoMode(text) {
  if (!text) return text;
  return text
    .replace(/\bestoy\b/gi, "toy")
    .replace(/\bcontigo\b/gi, "contigo mi llave")
    .replace(/\bpara\b/gi, "pa'")
    .replace(/\bhola\b/gi, "oe llave");
}
