<?php
    include '../../php/conexion.php';

    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        die("⚠️ No has iniciado sesión.");
    }

    $idUsuario = $_SESSION['id_usuario'];


    $eventos = [];

    if (isset($_GET['fecha'])) {
        $fecha = $_GET['fecha'];

        try {
            $db = new Conexion();
            $conexion = $db->getConnect();
            $sql = "SELECT motivo, fecha, hora, estado 
        FROM cita 
        WHERE Fecha = ? AND Id_Usuario = ?";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([$fecha, $idUsuario]); // ✅ AHORA SÍ la variable correcta
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
        <title>SaludBE</title>
        <link rel="stylesheet" href="../../Css/Repetivos/root.css">
        <link rel="stylesheet" href="../../Css/Aprendiz/Calendario.css">
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
                <h2>Eventos del Día</h2>
                <ul id="event-list">
                    <?php
                    if (isset($_GET['fecha'])) {
                        echo "<h3>Fecha seleccionada: " . htmlspecialchars($_GET['fecha']) . "</h3>";

                        if (isset($eventos['error'])) {
                            echo "<li>Error: " . $eventos['error'] . "</li>";
                        } elseif (empty($eventos)) {
                            echo "<li>No hay eventos para esta fecha 😊</li>";
                        } else {
                            foreach ($eventos as $ev) {
                                echo "<li>
                            <strong>" . htmlspecialchars($ev['motivo']) . "</strong><br>
                            " . htmlspecialchars($ev['fecha']) . "<br>
                            <small>" . htmlspecialchars($ev['hora']) . "</small>
                            <strong>" . htmlspecialchars($ev['estado']) . "</strong>
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

        <script src="../../js/Calendario.js"></script>
    </body>

    </html>