const form = document.getElementById('chat-form');
const input = document.getElementById('mensaje-input');
const chatMessages = document.getElementById('chat-messages');

form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const mensaje = input.value.trim();
    if (!mensaje) return;

    try {
        const res = await fetch('/SaludBe/Html/psicologo/Guardar_chat_P.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `mensaje=${encodeURIComponent(mensaje)}&us_id=${usuarioLogueado}`
        });

        const text = await res.text();
        let data;

        try {
            data = JSON.parse(text);
        } catch (err) {
            console.error('Respuesta no es JSON:', text);
            return;
        }

        if (data.success) {
            input.value = '';
            cargarMensajes();
        } else {
            alert('Error: ' + data.error);
        }

    } catch (err) {
        console.error('Fetch error:', err);
    }
});

function cargarMensajes() {
    fetch('/SaludBe/Html/psicologo/Cargarmensajes_P.php')
        .then(res => res.json())
        .then(mensajes => {
            chatMessages.innerHTML = '';

            mensajes.forEach(m => {
                const div = document.createElement('div');

                div.innerHTML = `
                    <strong>${m.usuario}:</strong> ${m.Men_contenido}<br>
                    <small>${m.Men_fecha_envio}</small>
                `;

                chatMessages.appendChild(div);
            });

            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(err => console.error("Error cargando mensajes:", err));
}

// Auto-refresh
setInterval(cargarMensajes, 2000);
cargarMensajes();
