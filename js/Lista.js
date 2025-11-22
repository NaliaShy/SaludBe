function openModal(userId) {
    const modal = document.getElementById('userModal');
    const content = document.getElementById('modal-body-content');

    // 1. Mostrar spinner de carga
    content.innerHTML = '<center><div class="loading-spinner"></div><p>Cargando información del aprendiz...</p></center>';
    modal.style.display = "flex"; // Mostrar modal

    // 2. Llamada AJAX para obtener los detalles del usuario
    $.ajax({
        url: '../../php/obtener_detalle_usuario.php', // (Asumo que este script ya funciona)
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
                            onclick="window.location.href='../../php/Psicologo/aceptarCita.php?user_id=${user.Us_id}'"
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
// Las funciones closeModal y window.onclick se mantienen sin cambios

// ***************************************************************
// NUEVA FUNCIÓN: CARGAR SEGUIMIENTOS CON AJAX Y RENDERIZAR EN MODAL
// ***************************************************************

function loadSeguimientos(aprendizId, nombreCompleto) {
    const content = document.getElementById('modal-body-content');
    
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
        url: '../../php/Psicologo/Seguimientoaprendiz/seguimiento.php', // Script que devuelve JSON
        type: 'GET',
        data: { id_aprendiz: aprendizId }, // Pasamos el ID del Aprendiz
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
                        // Formateo de fechas para mejor lectura
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