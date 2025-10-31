const calendar = document.getElementById('calendar');
const monthYear = document.getElementById('month-year');
const prev = document.getElementById('prev-month');
const next = document.getElementById('next-month');

let date = new Date();

function renderCalendar() {
  const year = date.getFullYear();
  const month = date.getMonth();

  monthYear.textContent = date.toLocaleDateString('es-ES', {
    month: 'long',
    year: 'numeric'
  }).toUpperCase();

  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const startDay = firstDay.getDay(); // 0 = domingo

  calendar.innerHTML = '';

  // Rellenar días vacíos al inicio
  for (let i = 0; i < (startDay === 0 ? 6 : startDay - 1); i++) {
    calendar.innerHTML += `<div></div>`;
  }

  // Días del mes
  for (let day = 1; day <= lastDay.getDate(); day++) {
    const d = new Date(year, month, day);
    const isToday = d.toDateString() === new Date().toDateString();
    calendar.innerHTML += `<div class="day ${isToday ? 'today' : ''}">${day}</div>`;
  }
}

prev.onclick = () => {
  date.setMonth(date.getMonth() - 1);
  renderCalendar();
};
next.onclick = () => {
  date.setMonth(date.getMonth() + 1);
  renderCalendar();
};

renderCalendar();
