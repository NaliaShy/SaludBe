<?php
// Incluir la conexión a la base de datos y manejar la sesión
include '../../php/Conexion.php';
session_start();

// 1. Verificación de sesión
if (!isset($_SESSION['us_id'])) {
    die("⚠️ No has iniciado sesión.");
}

// Usamos 'idPsicologo' para mayor claridad ya que este es el perfil del psicólogo
$idPsicologo = $_SESSION['us_id'];
$eventos = [];
$mensaje_lista = "Selecciona un día del calendario para ver las citas de esa fecha.";

// **MODIFICACIÓN CLAVE DE LÓGICA:**
// Si se proporciona una fecha, se filtra solo por esa fecha.
if (isset($_GET['fecha'])) {
    $fecha = $_GET['fecha'];

    // SQL para una FECHA ESPECÍFICA
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
        WHERE c.Fecha = ? AND c.Id_Psicologo = ?
        ORDER BY c.fecha ASC, c.hora ASC";

    $parametros = [$fecha, $idPsicologo];
    $mensaje_lista = "Fecha seleccionada: " . htmlspecialchars($fecha);
} else {
    // **NUEVA LÓGICA: Mostrar todas las citas desde HOY**
    $fecha_hoy = date('Y-m-d'); // Obtener la fecha actual en formato YYYY-MM-DD

    // **NUEVO SQL:** Filtra por fechas mayores o iguales a la de hoy
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
        WHERE c.Fecha >= ? AND c.Id_Psicologo = ?
        ORDER BY c.fecha ASC, c.hora ASC";

    $parametros = [$fecha_hoy, $idPsicologo];
    $mensaje_lista = "Mostrando todas las citas pendientes desde HOY (" . $fecha_hoy . ")";
}

// Ejecución de la consulta (unificada)
try {
    $db = new Conexion();
    $conexion = $db->getConnect();

    $stmt = $conexion->prepare($sql);
    $stmt->execute($parametros);
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $eventos = ["error" => $e->getMessage()];
    $mensaje_lista = "Error de Base de Datos"; // Sobrescribir el mensaje si hay error
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaludBE - Calendario de Citas</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Aprendiz/Calendario.css">
    <style>
        /* Estilos añadidos temporalmente para la lista de citas y el botón */
    </style>
</head>

<body>
    <?php include '../../php/Components/Sidebar_p.php'; ?>

    <div class="calendario-list">
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
                        // ...
                        if ($ev['estado'] === 'Pendiente') {
                            // El formulario AHORA llama a una función JS para manejarlo con AJAX
                            // En tu archivo PHP (calendarioPsicologo.php)

                            // ...
                            echo "      <form class='aceptar-cita-form' onsubmit='aceptarCitaAjax(event, this)'>";
                            echo "          <input type='hidden' name='idCita' value='" . htmlspecialchars($ev['IdCita']) . "'>";

                            // ESTE NOMBRE DEBE COINCIDIR CON EL JS (fecha_cita)
                            echo "          <input type='hidden' name='fecha_cita' value='" . htmlspecialchars($ev['fecha']) . "'>";

                            echo "          <button type='submit' class='btn-aceptar'>Aceptar Cita</button>";
                            // ...
                        }
                        // ...

                        echo "      </div>";
                        echo "</li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <script src="../../js/Calendario.js"></script>
</body>

</html>