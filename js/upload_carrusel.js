console.log("✔ JS CARGADO CORRECTAMENTE");

// ELEMENTOS
const uploadBox = document.getElementById("uploadBox");
const fileInput = document.getElementById("fileInput");
const previewContainer = document.getElementById("previewContainer");
const imagePreview = document.getElementById("imagePreview");
const popup = document.getElementById("popupNotification");
const historial = document.getElementById("historial");

// ABRIR SELECTOR AL CLIC
uploadBox.addEventListener("click", () => fileInput.click());

// CAMBIO DE ARCHIVO MANUAL
fileInput.addEventListener("change", () => {
    const file = fileInput.files[0];
    showPreview(file);
    uploadImage(file);
});

// DRAGOVER
uploadBox.addEventListener("dragover", (e) => {
    e.preventDefault();
    uploadBox.classList.add("dragover");
});

// DRAG LEAVE
uploadBox.addEventListener("dragleave", () => {
    uploadBox.classList.remove("dragover");
});

// DROP
uploadBox.addEventListener("drop", (e) => {
    e.preventDefault();
    uploadBox.classList.remove("dragover");

    const file = e.dataTransfer.files[0];
    showPreview(file);
    uploadImage(file);
});

// MOSTRAR PREVIEW
function showPreview(file) {
    if (!file) return;

    const reader = new FileReader();

    reader.onload = () => {
        imagePreview.src = reader.result;
        previewContainer.style.display = "block";
    };

    reader.readAsDataURL(file);
}

// SUBIR IMAGEN
function uploadImage(file) {
    if (!file) return;

    console.log("📤 Enviando fetch con archivo:", file.name);

    let formData = new FormData();
    formData.append("imagen", file);
    formData.append("titulo", "Imagen automática");
    formData.append("descripcion", "Subida por el psicólogo");

    fetch("../../Php/subir_carrusel.php", {
        method: "POST",
        body: formData
    })
        .then((resp) => {
            console.log("📥 Respuesta RAW del servidor:", resp);
            return resp.text();
        })
        .then((texto) => {
            console.log("📄 TEXTO DEVUELTO POR PHP:", texto);

            let res;
            try {
                res = JSON.parse(texto);
            } catch (e) {
                showPopup("❌ Error: respuesta inválida del servidor");
                console.error("❌ NO SE PUDO PARSEAR JSON:", e);
                return;
            }

            if (res.status === "ok") {
                showPopup("✔ Imagen subida correctamente");
                addToHistorial(res.file);
            } else {
                showPopup("❌ Error: " + res.msg);
            }
        })
        .catch((err) => {
            console.error("❌ ERROR EN FETCH:", err);
            showPopup("❌ Error al subir la imagen");
        });
}

// POPUP
function showPopup(msg) {
    popup.innerHTML = msg;
    popup.classList.add("show");

    setTimeout(() => {
        popup.classList.remove("show");
    }, 3000);
}

// AGREGAR AL HISTORIAL
function addToHistorial(nombre) {
    const img = document.createElement("img");
    img.src = "../../Uploads/carrusel/" + nombre;
    img.classList.add("thumb");

    historial.prepend(img); // Lo más nuevo primero
}
