let usuarioSeleccionado = null;

const form = document.getElementById('chat-form');
const input = document.getElementById('mensaje-input');
const chatMessages = document.getElementById('chat-messages');

// ✅ Cargar lista de usuarios
function cargarUsuarios() {
    fetch('/SaludBe/php/chat/obtenerusuarios.php')
        .then(res => res.json())
        .then(usuarios => {
            const lista = document.getElementById('lista-usuarios');
            lista.innerHTML = '';

            usuarios.forEach(u => {
                const li = document.createElement('li');
                li.textContent = u.Us_nombre;
                li.dataset.id = u.Us_id;

                li.addEventListener('click', () => {
                    usuarioSeleccionado = u.Us_id;

                    document
                        .querySelectorAll('#lista-usuarios li')
                        .forEach(x => x.classList.remove('activo'));

                    li.classList.add('activo');
                    cargarMensajes();
                });

                lista.appendChild(li);
            });
        })
        .catch(err => console.error("Error cargando usuarios:", err));
}

cargarUsuarios();

// ✅ Enviar mensaje
form.addEventListener('submit', async function (e) {
    e.preventDefault();

    if (!usuarioSeleccionado) {
        alert("Selecciona un usuario para chatear.");
        return;
    }

    const mensaje = input.value.trim();
    if (!mensaje) return;

    try {
        const res = await fetch('/SaludBe/php/chat/guardar_chat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `mensaje=${encodeURIComponent(mensaje)}&us_id=${usuarioLogueado}&destinatario_id=${usuarioSeleccionado}`
        });
        const data = await res.json();

        if (data.success) {
            input.value = '';
            cargarMensajes();
        } else {
            alert("Error: " + data.error);
        }
    } catch (err) {
        console.error('Fetch error:', err);
    }
});

// ✅ Cargar mensajes entre tú y el usuario seleccionado
function cargarMensajes() {
    if (!usuarioSeleccionado) return;

    fetch(`/SaludBe/php/chat/cargarConversaciones.php?us2=${usuarioSeleccionado}`)
        .then(res => res.json())
        .then(mensajes => {
            chatMessages.innerHTML = '';

            mensajes.forEach(m => {
                const div = document.createElement('div');

                const esMio = m.Us_id == usuarioLogueado;
                div.classList.add('mensaje', esMio ? 'mio' : 'otro');

                div.innerHTML = `
                    <strong id="name-user">${m.usuario}</strong> <strong>
                    ${m.Men_contenido}</strong>
                    <small>${m.Men_fecha_envio}</small>
                `;

                chatMessages.appendChild(div);
            });

            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(err => console.error("Error cargando mensajes:", err));
}

// ✅ Auto-refresh
setInterval(cargarMensajes, 2000);
