<?php
include '../../php/Conexion/Conexion.php';

session_start();

// ERROR CORREGIDO: Usar 'us_id' en lugar de 'id_usuario'
if (!isset($_SESSION['us_id'])) {
    die("⚠️ No has iniciado sesión.");
}

// CORREGIDO: Usar 'us_id' para obtener el ID del usuario
$idUsuario = $_SESSION['us_id'];


$eventos = [];
$fechas_con_citas = []; // Variable para almacenar todas las fechas con citas (para los puntos)

try {
    $db = new Conexion();
    $conexion = $db->getConnect();
    
    // ----------------------------------------------------
    // LÓGICA 1: OBTENER TODAS LAS FECHAS CON CITA (para los puntos)
    // ----------------------------------------------------
    $sql_fechas = "SELECT DISTINCT Fecha FROM cita WHERE Id_Usuario = ?";
    $stmt_fechas = $conexion->prepare($sql_fechas);
    $stmt_fechas->execute([$idUsuario]); 
    // Almacena las fechas como un array simple de strings (ej: ['2025-11-20', '2025-11-25'])
    $fechas_con_citas = $stmt_fechas->fetchAll(PDO::FETCH_COLUMN, 0); 
    
} catch (PDOException $e) {
    error_log("Error al cargar fechas con citas: " . $e->getMessage());
    // Si hay error, la lista queda vacía para evitar fallos.
}

// ----------------------------------------------------
// LÓGICA 2: OBTENER EVENTOS PARA LA FECHA SELECCIONADA (CON DATOS DEL PSICÓLOGO)
// ----------------------------------------------------
if (isset($_GET['fecha'])) {
    $fecha = $_GET['fecha'];

    try {
        // Consulta SQL con JOIN:
        // 1. Selecciona los campos de la tabla `cita`.
        // 2. Hace un JOIN con la tabla `usuarios` (aliased como u) usando `Id_Psicologo` = `u.Us_id`.
        // 3. Selecciona el nombre y apellido del psicólogo (u.Us_nombre, u.Us_apellido).
        $sql = "SELECT 
                    c.motivo, 
                    c.fecha, 
                    c.hora, 
                    c.estado, 
                    u.Us_nombre AS nombre_psicologo, 
                    u.Us_apellios AS apellido_psicologo
                FROM cita c
                JOIN usuarios u ON c.Id_Psicologo = u.Us_id
                WHERE c.Fecha = ? AND c.Id_Usuario = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->execute([$fecha, $idUsuario]); 
        $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $eventos = ["error" => $e->getMessage()];
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaludBE - Calendario</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Aprendiz/Calendario.css">
</head>

<body>
    <?php include '../../php/Components/Sidebar_a.php'; ?>

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
            <h2>Eventos del Día</h2>
            <ul id="event-list">
                <?php
                if (isset($_GET['fecha'])) {
                    echo "<h3>Fecha seleccionada: " . htmlspecialchars($_GET['fecha']) . "</h3>";

                    if (isset($eventos['error'])) {
                        echo "<li>Error: " . htmlspecialchars($eventos['error']) . "</li>";
                    } elseif (empty($eventos)) {
                        echo "<li>No hay eventos para esta fecha 😊</li>";
                    } else {
                        foreach ($eventos as $ev) {
                            $nombre_completo_psicologo = htmlspecialchars($ev['nombre_psicologo'] . ' ' . $ev['apellido_psicologo']);
                            
                            echo "<li>
                                <strong>" . htmlspecialchars($ev['motivo']) . "</strong><br>
                                Psicólogo: <span>" . $nombre_completo_psicologo . "</span><br>
                                Fecha: " . htmlspecialchars($ev['fecha']) . "<br>
                                <small>Hora: " . htmlspecialchars($ev['hora']) . "</small> <br>
                                Estado: <p>" . htmlspecialchars($ev['estado']) . "</p>
                            </li>";
                        }
                    }
                } else {
                    echo "<li>Selecciona un día del calendario</li>";
                }
                ?>
            </ul>

        </div>
    </div>

    <?php include '../../php/Components/notificaciones_a.php'; ?>
    
    <!-- PASO FALTANTE: 
        Inyectar la lista de fechas desde PHP a JavaScript. 
        Ahora el JS tiene la variable 'fechasConCitas' disponible.
    -->
    <script>
        // Esta variable global ahora contiene todas las fechas con citas en formato ['YYYY-MM-DD']
        const fechasConCitas = <?php echo json_encode($fechas_con_citas); ?>;
    </script>

    <script src="../../js/Calendario.js"></script>
</body>

</html>