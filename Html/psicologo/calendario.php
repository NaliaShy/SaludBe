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

    if (isset($_GET['fecha'])) {
        $fecha = $_GET['fecha'];

        try {
            $db = new Conexion();
            $conexion = $db->getConnect();
            
            // **ACTUALIZACIÓN CRUCIAL DEL SQL:**
            // 1. Se une con la tabla 'usuario' (as u) para obtener el nombre del cliente.
            // 2. Se filtra por c.Id_Psicologo = ? (tu ID de sesión).
            // 3. Se selecciona el Id_Cita para poder aceptar el turno.
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
            ORDER BY c.hora ASC"; 

            $stmt = $conexion->prepare($sql);
            $stmt->execute([$fecha, $idPsicologo]); // Se usa la fecha seleccionada y el ID del psicólogo
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
    <title>SaludBE - Calendario de Citas</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Aprendiz/Calendario.css">
    <style>
        /* Estilos añadidos temporalmente para la lista de citas y el botón */
        .list {
            padding: 20px;
            background-color: var(--color-background-secondary);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        #event-list {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        .cita-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            background-color: #fff;
            border-left: 5px solid var(--color-primary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .cita-info {
            flex-grow: 1;
        }
        .cita-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }
        .cliente-nombre {
            font-weight: 600;
            color: var(--color-primary);
            font-size: 1.1em;
        }
        .motivo-cita {
            color: var(--color-text-secondary);
        }
        .horario-cita {
            font-size: 0.9em;
            color: #555;
        }
        .estado-cita {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: 500;
        }
        .estado-pendiente {
            background-color: #ffe0b2; /* Amarillo claro */
            color: #e65100; /* Naranja oscuro */
        }
        .estado-aceptada {
            background-color: #c8e6c9; /* Verde claro */
            color: #2e7d32; /* Verde oscuro */
        }
        .btn-aceptar {
            background-color: var(--color-primary);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .btn-aceptar:hover {
            background-color: var(--color-primary-dark);
        }
    </style>
</head>

<body>
    <?php include '../../php/Components/Sidebar_p.php'; ?>

    <div class="calendario-list">
        <!-- Contenedor del Calendario (se mantiene el código HTML y JS referenciado) -->
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
        
        <!-- Lista de Eventos Actualizada -->
        <div class="list">
            <h2>Citas Solicitadas</h2>
            <ul id="event-list">
                <?php
                if (isset($_GET['fecha'])) {
                    echo "<h3>Fecha seleccionada: " . htmlspecialchars($_GET['fecha']) . "</h3>";

                    if (isset($eventos['error'])) {
                        echo "<li style='color: red;'>Error en la Base de Datos: " . $eventos['error'] . "</li>";
                    } elseif (empty($eventos)) {
                        echo "<li>No hay citas de clientes programadas para esta fecha 😊</li>";
                    } else {
                        // Iterar sobre las citas encontradas
                        foreach ($eventos as $ev) {
                            // Determinar el estilo del estado
                            $estadoClase = strtolower(str_replace(' ', '-', $ev['estado']));
                            
                            echo "<li class='cita-item $estadoClase'>";
                            echo "    <div class='cita-info'>";
                            echo "        <span class='cliente-nombre'>Cliente: " . htmlspecialchars($ev['NombreCliente'] . " " . $ev['ApellidoCliente']) . "</span><br>";
                            echo "        <span class='motivo-cita'>Motivo: " . htmlspecialchars($ev['motivo']) . "</span><br>";
                            echo "        <span class='horario-cita'>Hora: " . htmlspecialchars($ev['hora']) . "</span>";
                            echo "    </div>";
                            
                            echo "    <div class='cita-actions'>";
                            echo "        <span class='estado-cita estado-" . $estadoClase . "'>Estado: " . htmlspecialchars($ev['estado']) . "</span>";
                            
                            // Botón Aceptar solo si el estado es 'Pendiente'
                            if ($ev['estado'] === 'Pendiente') {
                                // El formulario apunta al nuevo script de backend
                                echo "    <form action='../../php/Psicologo/aceptarCita.php' method='POST' style='display:inline;'>";
                                echo "        <input type='hidden' name='idCita' value='" . htmlspecialchars($ev['IdCita']) . "'>";
                                echo "        <button type='submit' class='btn-aceptar'>Aceptar Cita</button>";
                                echo "    </form>";
                            }
                            
                            echo "    </div>";
                            echo "</li>";
                        }
                    }
                } else {
                    echo "<li>Selecciona un día del calendario para ver las citas.</li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <script src="../../js/Calendario.js"></script>
</body>

</html>