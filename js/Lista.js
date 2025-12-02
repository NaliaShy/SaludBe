// =======================================================================
// 1. DEFINICIONES GLOBALES (Aseguramos que el elemento exista)
// =======================================================================

// Obtenemos la referencia al modal principal UNA VEZ al cargar el script.
const userModal = document.getElementById('userModal');


/**
 * Función para cerrar y ocultar el modal de detalles del aprendiz.
 */
function closeModal() {
    if (userModal) {
        // Oculta el modal
        userModal.style.display = 'none'; 
        
        // Limpiar el contenido interno y restaurar el spinner de carga
        const modalBody = document.getElementById('modal-body-content');
        if (modalBody) {
            modalBody.innerHTML = `
                <center>
                    <div class="loading-spinner"></div>
                    <p>Cargando información del aprendiz...</p>
                </center>`;
        }
    }
}


/**
 * Función para abrir el modal y cargar los detalles del usuario vía AJAX.
 * @param {string|number} userId - El ID del usuario seleccionado.
 */
function openModal(userId) {
    const content = document.getElementById('modal-body-content');

    if (!userModal || !content) {
        console.error("Error: Elementos del modal no encontrados (userModal o modal-body-content).");
        return;
    }

    // 1. Mostrar spinner de carga y el modal
    content.innerHTML = '<center><div class="loading-spinner"></div><p>Cargando información del aprendiz...</p></center>';
    userModal.style.display = "flex"; // Mostrar modal

    // 2. Llamada AJAX para obtener los detalles del usuario
    $.ajax({
        url: '../../php/obtener_detalle_usuario.php', 
        type: 'GET',
        data: { Us_id: userId },
        dataType: 'json',
        success: function(data) {
            if (data && data.success) {
                const user = data.user;

                // 3. Renderizar el contenido de detalles
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
                        <button 
                            class="btn-secondary" 
                            onclick="window.open('../../php/psicologo/imprimir_seguimientos.php?id_aprendiz=${user.Us_id}', '_blank')"
                        >
                            🖨️ Imprimir Historial
                        </button>

                        <button 
                            class="btn-info" 
                            onclick="loadSeguimientos(${user.Us_id}, '${user.Us_nombre} ${user.Us_apellios}')"
                        >
                            📋 Ver Seguimientos (Modal)
                        </button>
                        
                        <button 
                            class="btn-primary" 
                            onclick="window.location.href='/SaludBe/Html/psicologo/calendario.php'"
                        >
                            📅 Citas
                        </button>
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


/**
 * Carga el historial de seguimientos de un aprendiz en el mismo modal.
 * @param {string|number} aprendizId - El ID del aprendiz.
 * @param {string} nombreCompleto - Nombre y apellido del aprendiz.
 */
function loadSeguimientos(aprendizId, nombreCompleto) {
    const content = document.getElementById('modal-body-content');
    
    if (!content) return; // Si no hay content, salimos

    // Mostrar spinner de carga en el modal
    content.innerHTML = `
        <div class="user-detail-header">
            <h3>Historial de Seguimientos de ${nombreCompleto}</h3>
            <p><a href="#" onclick="openModal(${aprendizId}); return false;">← Volver a Detalles</a></p>
            <hr>
        </div>
        <center><div class="loading-spinner"></div><p>Cargando historial de seguimientos...</p></center>
    `;

    // Llamada AJAX para obtener los seguimientos
    $.ajax({
        url: '../../php/SeguimientoAprendiz/seguimiento.php',
        type: 'GET',
        data: { id_aprendiz: aprendizId },
        dataType: 'json',
        success: function(response) {
            if (response && response.success) {
                const seguimientos = response.data;
                let htmlContent = `
                    <div class="user-detail-header">
                        <h3>Historial de Seguimientos de ${nombreCompleto} (${response.count} registros)</h3>
                        <p><a href="#" onclick="openModal(${aprendizId}); return false;">← Volver a Detalles</a></p>
                        <hr>
                    </div>
                `;

                if (seguimientos.length === 0) {
                    htmlContent += '<p style="text-align: center; color: #888;">No se encontraron seguimientos registrados.</p>';
                } else {
                    htmlContent += '<div class="seguimientos-list">';
                    
                    seguimientos.forEach(s => {
                        const fechaCreacion = new Date(s.fecha_creacion).toLocaleString('es-ES');
                        const fechaCita = s.fecha_cita ? `${s.fecha_cita} (${s.hora_cita})` : 'No asociada';

                        htmlContent += `
                            <div class="seguimiento-card">
                                <h4>Reg. #${s.id_seguimiento} - Fecha: ${fechaCreacion}</h4>
                                <p><strong>Psicólogo:</strong> ${s.nombre_psicologo || 'N/A'} ${s.apellido_psicologo || ''}</p>
                                <p><strong>Cita:</strong> ${fechaCita}</p>
                                <p><strong>Motivo Cita:</strong> ${s.motivo_cita || 'N/A'}</p>
                                <p><strong>Descripción:</strong></p>
                                <p class="description-text">${s.detalle_seguimiento.replace(/\n/g, '<br>')}</p>
                            </div>
                        `;
                    });
                    
                    htmlContent += '</div>';
                }
                
                content.innerHTML = htmlContent;

            } else {
                content.innerHTML = `<p class="error-message">❌ Error al cargar seguimientos: ${response.error || 'Respuesta inválida del servidor.'}</p>`;
            }
        },
        error: function(xhr, status, error) {
            content.innerHTML = `<p class="error-message">❌ Error de conexión al servidor al cargar seguimientos: ${status} - ${error}</p>`;
            console.error("AJAX Seguimiento Error:", status, error);
        }
    });
}


// =======================================================================
// 2. EVENTOS DE CIERRE ADICIONALES
// =======================================================================

// Cierre al presionar la tecla ESC
document.addEventListener('keydown', (event) => {
    // Verificamos que el modal exista, esté visible y la tecla sea 'Escape'
    if (event.key === 'Escape' && userModal && userModal.style.display === 'flex') {
        closeModal();
    }
});

// Cierre al hacer clic fuera del contenido (en el overlay)
document.addEventListener('click', (event) => {
    // Verificamos si el clic fue en el overlay y no en el contenido del modal
    if (userModal && event.target === userModal) {
        closeModal();
    }
});