function openModal(userId) {
    const modal = document.getElementById('userModal');
    const content = document.getElementById('modal-body-content');

    // 1. Mostrar spinner de carga
    content.innerHTML = '<center><div class="loading-spinner"></div><p>Cargando información del aprendiz...</p></center>';
    modal.style.display = "flex"; // Mostrar modal

    // 2. Llamada AJAX para obtener los detalles del usuario
    $.ajax({
        url: '../../php/obtener_detalle_usuario.php', // NUEVO SCRIPT NECESARIO
        type: 'GET',
        data: { Us_id: userId }, // Enviamos el ID del usuario
        dataType: 'json',
        success: function(data) {
            if (data && data.success) {
                const user = data.user;

                // 3. Renderizar el contenido
                content.innerHTML = `
                            <div class="user-detail-header">
                                <h3>Detalles del Aprendiz</h3>
                                <p>ID: <span>${user.Us_id}</span></p>
                            </div>
                            <div class="user-detail-body">
                                <p><strong>Nombre:</strong> ${user.Us_nombre} ${user.Us_apellios}</p>
                                <p><strong>Email:</strong> ${user.Us_email}</p>
                                <p><strong>Documento:</strong> ${user.Us_documento}</p>
                                <p><strong>Tipo de Documento:</strong> ${user.Tipo_documento}</p>
                                <p><strong>Rol:</strong> ${user.Rol_nombre}</p>
                                <p><strong>Teléfono:</strong> ${user.Us_telefono || 'N/A'}</p>
                                <p><strong>Seguimiento:</strong> ${user.descripcion || 'N/A'}</p>
                            </div>
                            <div class="user-detail-actions">
                                <!-- Botones de acción, por ejemplo, agendar cita o ver historial -->
                                <button class="btn-primary" onclick="window.location.href='agendar_cita.php?user_id=${user.Us_id}'">Agendar Cita</button>
                              
                            </div>
                        `;
            } else {
                content.innerHTML = `<p class="error-message">❌ Error al cargar los datos: ${data.message || 'ID de usuario no encontrado.'}</p>`;
            }
        },
        error: function(xhr, status, error) {
            content.innerHTML = `<p class="error-message">❌ Error de conexión al servidor: ${status} - ${error}</p>`;
            console.error("AJAX Error:", status, error);
        }
    });
}

// Función para ocultar el modal
function closeModal() {
    document.getElementById('userModal').style.display = "none";
}

// Cerrar el modal haciendo clic fuera de él
window.onclick = function(event) {
    const modal = document.getElementById('userModal');
    if (event.target == modal) {
        closeModal();
    }
}