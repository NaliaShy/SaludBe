let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

const monthYearElement = document.getElementById("month-year");
const calendarGrid = document.getElementById("calendar");

// Obtenemos la fecha de hoy para poder marcarla
const today = new Date();
const todayDate = today.getDate();
const todayMonth = today.getMonth();
const todayYear = today.getFullYear();


function renderCalendar() {
    const firstDay = new Date(currentYear, currentMonth, 1).getDay();
    const lastDay = new Date(currentYear, currentMonth + 1, 0).getDate();

    calendarGrid.innerHTML = "";

    // PHP usa 1 (Lun) a 7 (Dom) / JS usa 0 (Dom) a 6 (Sáb). Ajuste:
    let startDayIndex = (firstDay + 6) % 7;

    // Rellena espacios antes del día 1
    for (let i = 0; i < startDayIndex; i++) {
        calendarGrid.innerHTML += `<div class="empty"></div>`;
    }

    // Días del mes
    for (let day = 1; day <= lastDay; day++) {
        const div = document.createElement("div");
        div.classList.add("day");
        div.innerText = day;

        // --------------------------------------------------------
        // Formato de Fecha (YYYY-MM-DD) y Objeto Date
        // --------------------------------------------------------
        const monthStr = String(currentMonth + 1).padStart(2, "0");
        const dayStr = String(day).padStart(2, "0");
        const dateString = `${currentYear}-${monthStr}-${dayStr}`;

        // Crear un objeto Date para el día actual en el bucle
        // Usamos el 12:00:00 para evitar problemas con la zona horaria
        const currentDay = new Date(currentYear, currentMonth, day, 12, 0, 0);

        // Comparación con la fecha de hoy (Date de hoy)
        const isPastDay = currentDay.getTime() < today.getTime() &&
            (currentYear !== todayYear || currentMonth !== todayMonth || day !== todayDate);


        // LÓGICA 1: Resaltar el día de hoy
        if (currentYear === todayYear && currentMonth === todayMonth && day === todayDate) {
            div.classList.add("today");
        }

        // LÓGICA 2: Marcar como DÍA PASADO (solo si no es "today")
        else if (isPastDay) {
            div.classList.add("past-day");
        }


        // --------------------------------------------------------
        // LÓGICA 3: INDICADOR DE CITA (PUNTICO / COLOR)
        // --------------------------------------------------------
        if (typeof fechasConCitas !== 'undefined' && fechasConCitas.includes(dateString)) {
            // [DEBUG Citas] Si ves este log, el día tiene una cita.
            console.log(`[DEBUG Citas] Día con cita: ${dateString}`);

            // 1. Añade una clase al contenedor del día
            div.classList.add('has-event');

            // 2. Crea y añade el "puntico"
            const dot = document.createElement('div');
            dot.classList.add('event-dot');

            // Si es un día pasado y tiene cita, añade una clase para cambiar el color del punto
            if (isPastDay) {
                dot.classList.add('past-event-dot');
            }

            div.appendChild(dot);
        }
        // --------------------------------------------------------

        div.addEventListener("click", () => {
            // La redirección usa la misma cadena de fecha
            window.location.href = `calendario.php?fecha=${dateString}`;
        });

        calendarGrid.appendChild(div);
    }

    // Texto de mes y año
    monthYearElement.innerText =
        new Date(currentYear, currentMonth).toLocaleString("es-ES", {
            month: "long",
            year: "numeric",
        });

    // [DEBUG Citas] Muestra todas las citas cargadas desde PHP
    console.log("[DEBUG Citas] Fechas encontradas:", fechasConCitas);
}

// ✅ Asegura que el calendario se dibuje al cargar la página
renderCalendar();

document.getElementById("next-month").addEventListener("click", () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar();
});

document.getElementById("prev-month").addEventListener("click", () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    renderCalendar();
});