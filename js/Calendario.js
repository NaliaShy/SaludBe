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


// Variable global para almacenar la fecha seleccionada si el usuario ha hecho clic en un día.
// Opcionalmente, puedes calcularla de la URL al inicio de la página.
let fechaActualSeleccionada = new URLSearchParams(window.location.search).get('fecha') || null;

/**
 * Función que maneja el envío del formulario de aceptar cita usando AJAX.
 * @param {Event} event - El evento de envío del formulario.
 * @param {HTMLFormElement} form - El formulario que se está enviando.
 */
function aceptarCitaAjax(event, form) {
    // 1. Prevenir el envío normal del formulario (para evitar la redirección)
    event.preventDefault(); 
    
    // Obtener los datos del formulario
    const idCita = form.querySelector('input[name="idCita"]').value;
    
    // 🔥 CAMBIO CRUCIAL: USAR EL NOMBRE CORRECTO DEL INPUT OCULTO DEL FORMULARIO
    const fechaCita = form.querySelector('input[name="fecha_cita"]').value; // ¡Corregido!

    // Deshabilitar el botón y mostrar un mensaje temporal
    const boton = form.querySelector('.btn-aceptar');


    // 2. Llamada AJAX al script PHP
    $.ajax({
        url: '../../php/Psicologo/Citas/aceptarCita.php', // El script que devuelve JSON
        type: 'POST',
        data: { idCita: idCita },
        dataType: 'json',
        success: function(response) {
            // 3. Manejar la respuesta
            let mensaje = response.message;
            if (response.status === 'success') {
                mostrarNotificacion(mensaje, 'success'); // Asumiendo que tienes una función de notificación
                // Actualizar la lista de citas para reflejar el cambio
                refrescarListaCitas(fechaCita);
            } else if (response.status === 'warning') {
                mostrarNotificacion(mensaje, 'warning');
                // Re-habilitar botón si es solo una advertencia (p.ej., ya aceptada)
                boton.textContent = textoOriginal;
                boton.disabled = false; 
            } else {
                mostrarNotificacion(mensaje, 'error');
                // Re-habilitar botón en caso de error
                boton.textContent = textoOriginal;
                boton.disabled = false;
            }
        },
        error: function(xhr, status, error) {
            mostrarNotificacion('❌ Error de conexión al servidor.', 'error');
            console.error("AJAX Error:", status, error);
            // Re-habilitar botón en caso de error
            boton.textContent = textoOriginal;
            boton.disabled = false;
        }
    });
}


/**
 * Función para recargar la lista de citas del día actual/seleccionado.
 * Esto es lo que reemplaza la redirección de PHP.
 * @param {string} fecha - La fecha de la cita para recargar la vista.
 */
function refrescarListaCitas(fecha) {
    // Simplemente recargamos la página con el parámetro 'fecha'
    // Esto fuerza a PHP a regenerar solo la lista de citas para esa fecha, 
    // manteniendo la vista actual.
    
    // Si la página se carga sin parámetro 'fecha' (mostrando citas futuras), 
    // recargamos sin parámetro 'fecha' para mantener esa vista.
    const url = fecha ? `calendarioPsicologo.php?fecha=${fecha}` : 'calendarioPsicologo.php';
    
    // Usamos window.location.replace() para evitar que el usuario vuelva atrás al POST.
    window.location.replace(url); 
}


// --- Función de Notificación (Ejemplo Básico) ---
// Puedes reemplazar esto con tu sistema de notificaciones.
function mostrarNotificacion(mensaje, tipo) {
    alert(`[${tipo.toUpperCase()}] ${mensaje}`);
}