// Seleccionar todos los botones
const botones = document.querySelectorAll(".test-btn");

// Modal
const modal = document.getElementById("testModal");
const closeModal = document.querySelector(".close-modal");

const modalTitle = document.getElementById("modal-title");
const modalDesc = document.getElementById("modal-description");
const crearTestBtn = document.getElementById("crearTestBtn");

// Información de cada test
const testInfo = {
    "Test de ansiedad social": {
        descripcion: "Evalúa síntomas relacionados con ansiedad social e interacción con otros.",
        ruta: "../../php/crear_test.php?tipo=ansiedad"
    },
    "Test de adicción al internet": {
        descripcion: "Mide el nivel de uso problemático del internet.",
        ruta: "../../php/crear_test.php?tipo=adiccion"
    },
    "Test de depresión": {
        descripcion: "Evalúa síntomas depresivos según criterios psicológicos.",
        ruta: "../../php/crear_test.php?tipo=depresion"
    },
    "Test de burnout": {
        descripcion: "Evalúa agotamiento físico y emocional relacionado al trabajo.",
        ruta: "../../php/crear_test.php?tipo=burnout"
    }
};

// Abrir modal al hacer clic
botones.forEach(btn => {
    btn.addEventListener("click", () => {

        const titulo = btn.getAttribute("data-test");
        modalTitle.textContent = titulo;
        modalDesc.textContent = testInfo[titulo].descripcion;

        crearTestBtn.onclick = () => {
            window.location.href = testInfo[titulo].ruta;
        };

        modal.style.display = "block";
    });
});

// Cerrar modal
closeModal.onclick = () => modal.style.display = "none";

window.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
};