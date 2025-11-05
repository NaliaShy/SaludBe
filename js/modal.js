const modal = document.getElementById('modalAyuda');
const abrirBtn = document.getElementById('abrirModalBtn');
const cerrarBtn = document.getElementById('cerrarModalBtn');

abrirBtn.addEventListener('click', () => {
    modal.style.display = 'flex';
});

cerrarBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Cierra al hacer clic fuera del modal
window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});