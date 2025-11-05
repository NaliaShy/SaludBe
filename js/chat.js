const form = document.getElementById('chat-form');
const input = document.getElementById('mensaje-input');
const chatMessages = document.getElementById('chat-messages');

form.addEventListener('submit', async function (e) {
    e.preventDefault();
    const mensaje = input.value.trim();
    if (!mensaje) return;

    try {
        console.log('Enviando mensaje:', mensaje);

        const res = await fetch('/SaludBe/Html/Aprendiz/Guardar_chat_A.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `mensaje=${encodeURIComponent(mensaje)}&us_id=${usuarioLogueado}`

        });

        console.log('HTTP status:', res.status, 'ok?', res.ok, 'content-type:', res.headers.get('content-type'));

        const text = await res.text();
        console.log('Respuesta cruda del servidor:', text);

        let data;
        try {
            data = JSON.parse(text);
        } catch (err) {
            console.error('No es JSON válido:', err);
            alert('Respuesta del servidor no es JSON — mira la consola para más detalles');
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
        alert('Error de red — revisa la consola y la pestaña Network');
    }
});

function cargarMensajes() {
    fetch('/SaludBe/Html/Aprendiz/cargarmensajes_A.php')
        .then(res => res.json())
        .then(mensajes => {
            chatMessages.innerHTML = '';
            mensajes.forEach(m => {
                const div = document.createElement('div');
                div.textContent = `Usuario ${m.Us_id}: ${m.Men_contenido}`;
                chatMessages.appendChild(div);
            });
            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(err => console.error("Error cargando mensajes:", err));
}

setInterval(cargarMensajes, 2000);
cargarMensajes();
