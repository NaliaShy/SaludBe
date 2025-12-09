<?php

if (!isset($_SESSION['Us_id'])) { 
    die("⚠️ No has iniciado sesión.");
}
$idPsicologo = $_SESSION['Us_id']; 
$eventos = [];

// =======================================================================
// ⭐ NUEVA LÍNEA: CAPTURAR EL ID DEL APRENDIZ DE LA URL
// =======================================================================
$idAprendizFiltro = isset($_GET['id_aprendiz']) ? $_GET['id_aprendiz'] : null;


$mensaje_lista = "Selecciona un día del calendario para ver las citas de esa fecha.";

// Array inicial de parámetros (siempre incluye el ID del psicólogo al final)
$parametros = [];
$clausula_filtro_aprendiz = "";

// =======================================================================
// ⭐ NUEVA LÓGICA: FILTRAR POR APRENDIZ SI EL ID ESTÁ PRESENTE
// =======================================================================
if ($idAprendizFiltro) {
    // Si se pasa un ID de aprendiz, agregamos una cláusula para filtrar por él.
    $clausula_filtro_aprendiz = "AND c.Id_Usuario = ?";
    // El ID del aprendiz se añade a los parámetros, pero el orden es importante para el SQL.
    $mensaje_lista = "Mostrando citas para el Aprendiz ID: " . htmlspecialchars($idAprendizFiltro);
}


// **MODIFICACIÓN CLAVE DE LÓGICA:**
// Si se proporciona una fecha, se filtra solo por esa fecha.
if (isset($_GET['fecha'])) {
    $fecha = $_GET['fecha'];

    // SQL para una FECHA ESPECÍFICA + FILTRO OPCIONAL DE APRENDIZ
    $sql = "SELECT 
            c.IdCita, 
            c.motivo, 
            c.fecha, 
            c.hora, 
            c.estado, 
            u.Us_nombre AS NombreCliente, 
            u.Us_apellios AS ApellidoCliente 
        FROM cita c
        JOIN usuarios u ON c.Id_Usuario = u.Us_id 
        WHERE c.Fecha = ? AND c.Id_Psicologo = ? " . $clausula_filtro_aprendiz . " 
        ORDER BY c.fecha ASC, c.hora ASC";

    $parametros = [$fecha, $idPsicologo];
    if ($idAprendizFiltro) {
        $parametros[] = $idAprendizFiltro; // Añadir el ID del aprendiz al final
    }
    
    $mensaje_lista = $mensaje_lista . " - Fecha seleccionada: " . htmlspecialchars($fecha);
} else {
    // **NUEVA LÓGICA: Mostrar todas las citas desde HOY**
    $fecha_hoy = date('Y-m-d'); // Obtener la fecha actual en formato YYYY-MM-DD

    // **NUEVO SQL:** Filtra por fechas mayores o iguales a la de hoy + FILTRO OPCIONAL DE APRENDIZ
    $sql = "SELECT 
            c.IdCita, 
            c.motivo, 
            c.fecha, 
            c.hora, 
            c.estado, 
            u.Us_nombre AS NombreCliente, 
            u.Us_apellios AS ApellidoCliente 
        FROM cita c
        JOIN usuarios u ON c.Id_Usuario = u.Us_id 
        WHERE c.Fecha >= ? AND c.Id_Psicologo = ? " . $clausula_filtro_aprendiz . "
        ORDER BY c.fecha ASC, c.hora ASC";

    $parametros = [$fecha_hoy, $idPsicologo];
    if ($idAprendizFiltro) {
        $parametros[] = $idAprendizFiltro; // Añadir el ID del aprendiz al final
    }
    
    // Si no había filtro de aprendiz, el mensaje inicial es más general
    if (!$idAprendizFiltro) {
        $mensaje_lista = "Mostrando todas las citas pendientes desde HOY (" . $fecha_hoy . ")";
    }
}

// Ejecución de la consulta (unificada)
try {
    $db = new Conexion();
    $conexion = $db->getConnect();

    // 💡 NOTA IMPORTANTE: Asegúrate de que tu clase 'Conexion' y la conexión PDO estén disponibles aquí.

    $stmt = $conexion->prepare($sql);
    $stmt->execute($parametros); // Ejecuta con los parámetros ya ordenados
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $eventos = ["error" => $e->getMessage()];
    $mensaje_lista = "Error de Base de Datos"; // Sobrescribir el mensaje si hay error
}
?>
<div class="calendario-list" id="Psicologo-Calendario" style="display: none;">
    <div class="calendar-container">
        <div class="calendar-header">
            <button id="prev-month">◀</button>
            <h2 id="month-year"></h2>
            <button id="next-month">▶</button>  
        </div>
        <div class="calendar-weekdays">
            <div>Lun</div>
            <div>Mar</div>
            <div>Mié</div>
            <div>Jue</div>
            <div>Vie</div>
            <div>Sáb</div>
            <div>Dom</div>
        </div>
        <div class="calendar-grid" id="calendar"></div>
    </div>

    <div class="list">
        <h2>Citas Solicitadas</h2>
        <h3><?php echo $mensaje_lista; ?></h3>
        <ul id="event-list">
            <?php
            if (isset($eventos['error'])) {
                echo "<li style='color: red;'>Error en la Base de Datos: " . $eventos['error'] . "</li>";
            } elseif (empty($eventos)) {
                // Mensaje genérico para no-citas, ya que el mensaje principal cubre el contexto
                echo "<li>No hay citas de clientes programadas 😊</li>";
            } else {
                // Iterar sobre las citas encontradas
                foreach ($eventos as $ev) {
                    // Determinar el estilo del estado
                    $estadoClase = strtolower(str_replace(' ', '-', $ev['estado']));

                    echo "<li class='cita-item $estadoClase'>";
                    echo "      <div class='cita-info'>";
                    echo "          <span class='cliente-nombre'>Aprendiz: " . htmlspecialchars($ev['NombreCliente'] . " " . $ev['ApellidoCliente']) . "</span><br>";
                    // **Añadir la fecha al elemento de la lista si se muestran múltiples fechas**
                    if (!isset($_GET['fecha'])) {
                        echo "          <span class='horario-cita'>Fecha: " . htmlspecialchars($ev['fecha']) . "</span><br>";
                    }
                    echo "          <span class='motivo-cita'>Motivo: " . htmlspecialchars($ev['motivo']) . "</span><br>";
                    echo "          <span class='horario-cita'>Hora: " . htmlspecialchars($ev['hora']) . "</span>";
                    echo "      </div>";

                    echo "      <div class='cita-actions'>";
                    echo "          <span class='estado-cita estado-" . $estadoClase . "'>Estado: " . htmlspecialchars($ev['estado']) . "</span>";

                    // Botón Aceptar solo si el estado es 'Pendiente'

                    if ($ev['estado'] === 'Pendiente') {
                        // El formulario AHORA llama a una función JS para manejarlo con AJAX
                        // En tu archivo PHP (calendarioPsicologo.php)

    
                        echo "      <form class='aceptar-cita-form' onsubmit='aceptarCitaAjax(event, this)'>";
                        echo "          <input type='hidden' name='idCita' value='" . htmlspecialchars($ev['IdCita']) . "'>";

                        // ESTE NOMBRE DEBE COINCIDIR CON EL JS (fecha_cita)
                        echo "          <input type='hidden' name='fecha_cita' value='" . htmlspecialchars($ev['fecha']) . "'>";

                        echo "          <button type='submit' class='btn-aceptar'>Aceptar Cita</button>";
    
                    }


                    echo "      </div>";
                    echo "</li>";
                }
            }
            ?>
        </ul>
    </div>
</div>

<?php 
// 1. Prepara el array de fechas únicas para JavaScript
$fechasConCitas = [];
// Asegúrate de que $eventos no sea un error antes de iterar
if (!isset($eventos['error'])) {
    foreach ($eventos as $ev) {
        // Asegúrate de solo añadir la fecha una vez
        if (!in_array($ev['fecha'], $fechasConCitas)) {
            $fechasConCitas[] = $ev['fecha'];
        }
    }
}
// 2. Convierte el array PHP a una cadena JSON
$jsonFechas = json_encode($fechasConCitas);
?>

<script>
    // Inyectamos la lista de fechas con citas que Calendario.js necesita
    const fechasConCitas = <?php echo $jsonFechas; ?>; 
    console.log("[PHP DEBUG] Fechas inyectadas:", fechasConCitas); // Para verificar en la consola
</script>

