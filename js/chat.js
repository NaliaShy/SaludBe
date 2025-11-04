const form = document.getElementById('chat-form');
const input = document.getElementById('mensaje-input');
const chatMessages = document.getElementById('chat-messages');

form.addEventListener('submit', function(e){
    e.preventDefault();
    const mensaje = input.value.trim();
    if(!mensaje) return;

    fetch('Guardar_chat.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: `mensaje=${encodeURIComponent(mensaje)}&us_id=1`
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            input.value = '';
            cargarMensajes();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(err => console.error(err));
});

function cargarMensajes(){
    fetch('cargarmensajes.php')
    .then(res => res.json())
    .then(mensajes => {
        chatMessages.innerHTML = '';
        mensajes.forEach(m => {
            const div = document.createElement('div');
            div.textContent = `Usuario ${m.Us_id}: ${m.Men_contenido}`;
            chatMessages.appendChild(div);
        });
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });
}

setInterval(cargarMensajes, 2000);
cargarMensajes();
