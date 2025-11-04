let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

const monthYearElement = document.getElementById("month-year");
const calendarGrid = document.getElementById("calendar");

function renderCalendar() {
    const firstDay = new Date(currentYear, currentMonth, 1).getDay();
    const lastDay = new Date(currentYear, currentMonth + 1, 0).getDate();

    calendarGrid.innerHTML = "";

    // rellena espacios antes del día 1
    for (let i = 0; i < (firstDay + 6) % 7; i++) {
        calendarGrid.innerHTML += `<div class="empty"></div>`;
    }

    // días del mes
    for (let day = 1; day <= lastDay; day++) {
        const div = document.createElement("div");
        div.classList.add("day");
        div.innerText = day;

        div.addEventListener("click", () => {
            const monthStr = String(currentMonth + 1).padStart(2, "0");
            const dayStr = String(day).padStart(2, "0");
            window.location.href = `calendario.php?fecha=${currentYear}-${monthStr}-${dayStr}`;
        });

        calendarGrid.appendChild(div);
    }

    // texto de mes y año
    monthYearElement.innerText =
        new Date(currentYear, currentMonth).toLocaleString("es-ES", {
            month: "long",
            year: "numeric",
        });
}

// ✅ LLAMADA QUE TE FALTABA
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
