/**
 * Carga el formulario para añadir un nuevo seguimiento al aprendiz.
 * @param {string|number} aprendizId - El ID del aprendiz.
 * @param {string} nombreCompleto - Nombre y apellido del aprendiz.
 */
function addSeguimientoForm(aprendizId, nombreCompleto) {
    const content = document.getElementById('modal-body-content');
    if (!content) return;

    // Generar el formulario
    content.innerHTML = `
        <div class="user-detail-header">
            <h3>✍️ Nuevo Seguimiento para ${nombreCompleto}</h3>
            <p><a href="#" onclick="openModal(${aprendizId}); return false;">← Volver a Detalles</a></p>
            <hr>
        </div>
        <form id="form-nuevo-seguimiento" onsubmit="guardarNuevoSeguimiento(event, this)">
            <input type="hidden" name="id_aprendiz" value="${aprendizId}">
            
            <label for="detalle_seguimiento">Observación / Detalle del Seguimiento:</label>
            <textarea id="detalle_seguimiento" name="detalle_seguimiento" rows="6" required 
                placeholder="Describe el avance, notas de la sesión, o plan de acción."></textarea>
            
            <label for="fecha_cita_asociada">Asociar a Cita:</label>
            <select id="fecha_cita_asociada" name="id_cita">
                <option value="">-- No asociar a ninguna cita --</option>
            </select>
            
            <div class="user-detail-actions" style="margin-top: 20px;">
                <button type="submit" class="btn-primary" id="btn-guardar-seguimiento">Guardar Seguimiento</button>
            </div>
        </form>
        <p id="seguimiento-message" style="text-align: center; margin-top: 10px;"></p>
    `;
    
    // ⭐ OPCIONAL: Llenar el select de citas pendientes
    cargarCitasPendientes(aprendizId);
}

/**
 * Función AJAX para cargar y popular el select de citas pendientes del aprendiz.
 * NOTA: Necesitas un script PHP en 'obtener_citas_pendientes.php'
 */
function cargarCitasPendientes(aprendizId) {
    const selectCitas = document.getElementById('fecha_cita_asociada');
    
    // Si el elemento existe, cargamos las citas
    if (selectCitas) {
        // Mostrar un mensaje de carga temporal
        selectCitas.innerHTML = '<option value="">Cargando citas...</option>';

        $.ajax({
            url: '../../php/Citas/obtener_citas_pendientes.php', 
            type: 'GET',
            data: { id_aprendiz: aprendizId },
            dataType: 'json',
            success: function (response) {
                // Limpiar el select
                selectCitas.innerHTML = '<option value="">-- No asociar a ninguna cita --</option>';
                
                if (response && response.success && response.citas.length > 0) {
                    response.citas.forEach(cita => {
                        const option = document.createElement('option');
                        // El valor debe ser el ID de la cita (IdCita)
                        option.value = cita.IdCita; 
                        // El texto visible debe ser la fecha, hora y motivo
                        option.textContent = `[${cita.Fecha} ${cita.Hora}] - ${cita.Motivo}`;
                        selectCitas.appendChild(option);
                    });
                } else {
                    selectCitas.innerHTML = '<option value="">-- No hay citas pendientes/aceptadas --</option>';
                }
            },
            error: function () {
                selectCitas.innerHTML = '<option value="">Error al cargar citas</option>';
            }
        });
    }
}

/**
 * Función AJAX para guardar el nuevo seguimiento.
 * NOTA: Necesitas crear el script PHP en 'guardar_seguimiento.php'
 */
function guardarNuevoSeguimiento(event, form) {
    event.preventDefault(); // Prevenir el envío estándar
    
    const btn = document.getElementById('btn-guardar-seguimiento');
    const message = document.getElementById('seguimiento-message');
    
    btn.disabled = true;
    btn.textContent = 'Guardando...';
    message.style.color = 'blue';
    message.textContent = 'Enviando datos al servidor...';

    // 1. Serializar los datos del formulario
    const formData = $(form).serialize();
    
    // 2. Llamada AJAX para guardar
    $.ajax({
        url: '../../php/SeguimientoAprendiz/guardar_seguimiento.php', // ¡DEBES CREAR ESTE ARCHIVO!
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            btn.disabled = false;
            btn.textContent = 'Guardar Seguimiento';
            
            if (response && response.success) {
                message.style.color = 'green';
                message.textContent = '✅ Seguimiento guardado exitosamente.';
                // Opcional: Recargar la vista de detalles para confirmar el cambio
                // openModal(response.id_aprendiz); 
                
            } else {
                message.style.color = 'red';
                message.textContent = `❌ Error al guardar: ${response.message || 'Error desconocido del servidor.'}`;
            }
        },
        error: function (xhr, status, error) {
            btn.disabled = false;
            btn.textContent = 'Guardar Seguimiento';
            message.style.color = 'red';
            message.textContent = `❌ Error de conexión al servidor: ${status} - ${error}`;
            console.error("AJAX Guardar Seguimiento Error:", status, error);
        }
    });
}