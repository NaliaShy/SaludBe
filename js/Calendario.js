const calendar = document.getElementById("calendar");
const monthYear = document.getElementById("month-year");
const prev = document.getElementById("prev-month");
const next = document.getElementById("next-month");

let date = new Date();

function renderCalendar() {
  const year = date.getFullYear();
  const month = date.getMonth();

  // Título
  monthYear.textContent = date.toLocaleDateString("es-ES", {
    month: "long",
    year: "numeric"
  }).toUpperCase();

  // Primer y último día del mes
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);

  // Limpiar grilla
  calendar.innerHTML = "";

  // Calcular desplazamiento (de Lunes a Domingo)
  let startDay = firstDay.getDay(); // 0 = Domingo
  if (startDay === 0) startDay = 7; // mover domingo al final

  // Rellenar días vacíos antes del 1
  for (let i = 1; i < startDay; i++) {
    const empty = document.createElement("div");
    calendar.appendChild(empty);
  }

  // Generar días del mes
  for (let day = 1; day <= lastDay.getDate(); day++) {
    const d = document.createElement("div");
    d.textContent = day;
    d.classList.add("day");

    const today = new Date();
    if (
      day === today.getDate() &&
      month === today.getMonth() &&
      year === today.getFullYear()
    ) {
      d.classList.add("today");
    }

    calendar.appendChild(d);
  }
}

// Botones de navegación
prev.onclick = () => {
  date.setMonth(date.getMonth() - 1);
  renderCalendar();
};

next.onclick = () => {
  date.setMonth(date.getMonth() + 1);
  renderCalendar();
};

// Render inicial
renderCalendar();
