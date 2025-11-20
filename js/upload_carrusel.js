// ELEMENTOS
const uploadBox = document.getElementById("uploadBox");
const fileInput = document.getElementById("fileInput");
const historial = document.getElementById("historial");
const previewContainer = document.getElementById("previewContainer");
const imagePreview = document.getElementById("imagePreview");
const popup = document.getElementById("popupNotification");

// EVITAR COMPORTAMIENTO POR DEFECTO
["dragenter", "dragover", "dragleave", "drop"].forEach(e => {
    uploadBox.addEventListener(e, ev => ev.preventDefault());
});

// ESTILOS AL ARRASTRAR
["dragenter", "dragover"].forEach(e => {
    uploadBox.addEventListener(e, () => uploadBox.classList.add("hover"));
});

["dragleave", "drop"].forEach(e => {
    uploadBox.addEventListener(e, () => uploadBox.classList.remove("hover"));
});

// CLICK PARA ABRIR SELECTOR
uploadBox.addEventListener("click", () => fileInput.click());

// DROP
uploadBox.addEventListener("drop", e => {
    fileInput.files = e.dataTransfer.files;
    mostrarPreview(fileInput.files[0]);
    subirImagen(fileInput.files[0]);
});

// CHANGE
fileInput.addEventListener("change", () => {
    mostrarPreview(fileInput.files[0]);
    subirImagen(fileInput.files[0]);
});

// PREVIEW
function mostrarPreview(archivo) {
    if (!archivo) return;

    const reader = new FileReader();
    reader.onload = e => {
        previewContainer.style.display = "block";
        imagePreview.src = e.target.result;
    };
    reader.readAsDataURL(archivo);
}

// POPUP
function showPopup(msg, error = false) {
    popup.innerText = msg;
    popup.classList.toggle("error", error);
    popup.style.display = "block";

    setTimeout(() => {
        popup.style.display = "none";
    }, 2500);
}

// SUBIR IMAGEN
function subirImagen(archivo) {

    if (!archivo) {
        showPopup("No seleccionaste ninguna imagen", true);
        return;
    }

    let formData = new FormData();
    formData.append("imagen", archivo);

    fetch("../../php/subir_carrusel.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showPopup("Imagen subida correctamente");
            cargarHistorial();
        } else {
            showPopup("Error al subir imagen", true);
        }
    })
    .catch(() => showPopup("Error de conexión", true));
}

// CARGAR HISTORIAL
function cargarHistorial() {

    fetch("../../php/historial_carrusel.php")
    .then(r => r.json())
    .then(items => {
        historial.innerHTML = "";

        items.forEach(img => {

            historial.innerHTML += `
                <div class="historial-item">
                    <img src="${img.url}">

                    <button class="delete-btn" onclick="eliminarImagen(${img.id})">✖</button>

                    <button class="estado-btn" onclick="cambiarEstado(${img.id}, '${img.estado}')">
                        ${img.estado === "activo" ? "Desactivar" : "Activar"}
                    </button>
                </div>
            `;
        });
    });
}

// ELIMINAR IMAGEN
function eliminarImagen(id) {

    if (!confirm("¿Eliminar esta imagen del carrusel?")) return;

    let formData = new FormData();
    formData.append("id", id);

    fetch("../../php/eliminar_carrusel.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.text())
    .then(res => {
        if (res.trim() === "ok") {
            showPopup("Imagen eliminada");
            cargarHistorial();
        } else {
            showPopup("Error eliminando imagen", true);
        }
    });
}

// CAMBIAR ESTADO
function cambiarEstado(id, estadoActual) {

    const nuevoEstado = estadoActual === "activo" ? "inactivo" : "activo";

    let formData = new FormData();
    formData.append("id", id);
    formData.append("estado", nuevoEstado);

    fetch("../../php/cambiar_estado.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.text())
    .then(res => {
        if (res.trim() === "ok") {
            showPopup("Estado actualizado");
            cargarHistorial();
        } else {
            showPopup("Error cambiando estado", true);
        }
    });
}

// INICIAR
cargarHistorial();
