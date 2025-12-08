// =====================================================
// AI ENGINE – VERSIÓN INTELIGENTE (CON CONTEXTO Y VARIEDAD)
// =====================================================

// Normalización de texto
export const normalize = (t) =>
  t.toLowerCase()
   .normalize("NFD")
   .replace(/[\u0300-\u036f]/g, "")
   .trim();

// -------------------------------
// MEMORIA DE CONTEXTO
// -------------------------------
let memory = {
  lastUserMessage: "",
  mood: "neutral",   // triste, ansioso, molesto, feliz, neutral
  crisisActive: false,
  crisisStep: 0,
};

// -------------------------------
// DETECTOR DE CRISIS
// -------------------------------
const CRISIS_REGEX = [
  /suicid/, /matarme/, /me quiero matar/, /acabar conmigo/,
  /quitarme la vida/, /ya no quiero vivir/, /morirme/,
  /desaparecer/, /no doy mas/, /me rindo/, /terminar todo/
];

export function isCrisis(text) {
  const t = normalize(text);
  return CRISIS_REGEX.some((re) => re.test(t));
}

// -------------------------------
// DETECTOR DE ESTADO EMOCIONAL
// -------------------------------
const MOOD_MAP = {
  triste: ["triste", "mal", "llor", "bajoneado", "sin ganas"],
  ansioso: ["ansioso", "ansiedad", "estres", "nervioso"],
  molesto: ["molesto", "rabia", "ira", "furioso", "estresado"],
  feliz: ["feliz", "contento", "bien"],
};

function detectMood(text) {
  const t = normalize(text);
  for (const mood in MOOD_MAP) {
    if (MOOD_MAP[mood].some(w => t.includes(w))) return mood;
  }
  return "neutral";
}

// -------------------------------
// RESPUESTAS VARIADAS
// -------------------------------
const RESPUESTAS = {
  saludo: [
    "Hola, ¿cómo te encuentras hoy?",
    "Hola llave, ¿cómo vas?",
    "¡Ey! Qué bueno verte por aquí.",
    "Hola, cuéntame cómo te sientes."
  ],
  general: [
    "Te escucho con atención. Puedes desahogarte conmigo.",
    "Entiendo... ¿quieres que hablemos más a fondo sobre eso?",
    "Estoy aquí para ti. Cuéntame un poco más.",
    "Gracias por confiar en mí. ¿Qué más pasó?"
  ],
  recomendacion_triste: [
    "Sé que no es fácil... ¿quieres intentar una respiración guiada?",
    "A veces ayuda escribir lo que sientes. ¿Quieres que te enseñe un ejercicio?",
    "Si te sientes muy triste, hablar con alguien cercano puede ayudar mucho."
  ],
  recomendacion_ansioso: [
    "Podemos hacer una respiración de 4-4-6 para calmar un poco el cuerpo.",
    "Cuando uno está ansioso, cerrar los ojos 10 segundos ayuda. ¿Quieres probar?",
    "¿Quieres que te recomiende un ejercicio de relajación?"
  ],
  recomendacion_molesto: [
    "Es válido sentir rabia. ¿Quieres que exploremos qué la está causando?",
    "Una técnica útil es tomar distancia 30 segundos y respirar profundo.",
    "Estoy contigo. ¿Qué fue lo que más te molestó?"
  ],
  recomendacion_neutral: [
    "Cuéntame más, estoy contigo.",
    "Interesante... ¿qué más pasó?",
    "Estoy prestando atención. ¿Qué más quisieras expresar?"
  ]
};

// -------------------------------
// FLUJO DE CRISIS MEJORADO
// -------------------------------
const CRISIS_FLOW = [
  "Lo que dices es muy serio. Estoy contigo. ¿Estás físicamente seguro ahora mismo?",
  "Gracias por responder. ¿Hay alguien cerca que pueda acompañarte?",
  "Entiendo... ¿puedes llamar o escribir a alguien de confianza?",
  "En Colombia puedes comunicarte a la Línea 106 o al 123. ¿Puedes intentarlo ahora mismo?",
  "Estoy contigo. ¿Puedes decirme cómo te sientes en este momento?"
];

// -------------------------------
// GENERADOR DE RESPUESTA
// -------------------------------
export function makeResponse(text) {
  const t = normalize(text);
  memory.lastUserMessage = text;

  // 1. Detección de crisis
  if (isCrisis(t)) {
    memory.crisisActive = true;
    memory.crisisStep = 1;
    return CRISIS_FLOW[0];
  }

  // 2. Respuesta dentro del flujo de crisis
  if (memory.crisisActive) {
    memory.crisisStep++;
    if (memory.crisisStep >= CRISIS_FLOW.length) memory.crisisStep = CRISIS_FLOW.length - 1;
    return CRISIS_FLOW[memory.crisisStep];
  }

  // 3. Detección emocional
  memory.mood = detectMood(t);

  // 4. Saludo
  if (/hola|buenas|hey/.test(t)) {
    return RESPUESTAS.saludo[Math.floor(Math.random() * RESPUESTAS.saludo.length)];
  }

  // 5. Recomendaciones según estado
  let moodList = RESPUESTAS[`recomendacion_${memory.mood}`];
  if (moodList) {
    return moodList[Math.floor(Math.random() * moodList.length)];
  }

  // 6. Respuesta general por defecto
  return RESPUESTAS.general[Math.floor(Math.random() * RESPUESTAS.general.length)];
}

// -------------------------------
// MODO COSTEÑO
// -------------------------------
export function applyCostenoMode(text) {
  if (!text) return text;

  return text
    .replace(/\bestoy\b/gi, "toy")
    .replace(/\bcontigo\b/gi, "contigo mi llave")
    .replace(/\bpara\b/gi, "pa'")
    .replace(/\bhola\b/gi, "oe llave");
}
