<?php
// ¡MANTENER ESTA LÍNEA! Es necesaria para acceder a $_SESSION['us_id'] y a los includes.
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> SaludBE - Agendar Cita</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Aprendiz/solicitarcitaApren.css">
</head>

<body>

    <?php include '../../php/Components/Sidebar_a.php'; ?>

    <!-- Contenedor principal -->
    <main>
        <section class="formulario">
            <div class="titulo">
                <center>
                    <h1>Agende su citas</h1>
                </center>
                <br>
            </div>
            <!-- El formulario envía los datos al script de procesamiento agendarcitas.php -->
            <form action="../../php/Citas/agendarcitas.php" method="post">
                <div class="form">
                    <div class="fila">
                        <div class="campo">
                            <label for="fecha">Selecciona la fecha</label>
                            <!-- Se añade 'min' para evitar seleccionar fechas pasadas -->
                            <input type="date" id="fecha" name="fecha" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="campo">
                        <label for="Motivo">Motivo</label>
                        <textarea id="Motivo" name="Motivo" rows="4" placeholder="Describe brevemente el motivo de tu consulta..." required></textarea>
                    </div>

                    <div class="campo">
                        <label for="Psicologo">Psicólogo</label>
                        <select name="Psicologo" id="Psicologo" required>
                            <option value="">Seleccione un psicólogo</option>
                            <?php
                            // Incluye tu archivo de conexión a la base de datos.
                            // Nota: la ruta debe ser correcta desde este archivo.
                            include_once '../../php/Conexion/conexion.php';

                            try {
                                // 1. Instancia la clase de conexión (PDO)
                                $db = new Conexion();
                                $conexion = $db->getConnect(); 

                                // 2. Define el ID del rol de psicólogo
                                $rol_psicologo = 2;

                                // 3. Consulta SQL para obtener los usuarios con Rol_id = 2 (Psicólogos)
                                $sql = "SELECT Us_id, Us_nombre, Us_apellios FROM usuarios WHERE Rol_id = ? ORDER BY Us_nombre";
                                $stmt = $conexion->prepare($sql);
                                $stmt->execute([$rol_psicologo]); 
                                $psicologos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // 4. Itera sobre el array de resultados de PDO
                                if (!empty($psicologos)) {
                                    foreach ($psicologos as $psicologo) {
                                        // Us_id se usa como el valor que se enviará al backend
                                        $id = htmlspecialchars($psicologo['Us_id']); 
                                        $nombre_completo = htmlspecialchars($psicologo['Us_nombre'] . ' ' . $psicologo['Us_apellido']);

                                        echo "<option value='{$id}'>{$nombre_completo}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No hay psicólogos disponibles</option>";
                                }
                            } catch (PDOException $e) {
                                // Muestra el error de conexión o consulta para DEPURACIÓN
                                error_log("Error DB al cargar psicólogos: " . $e->getMessage());
                                echo "<option value='' disabled>ERROR: " . htmlspecialchars($e->getMessage()) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="campo-check">
                        <input type="checkbox" id="confirmar" required>
                        <label for="confirmar">Confirmo que los datos ingresados en este formulario son verdaderos</label>
                    </div>

                    <div class="acciones">
                        <button type="submit" class="btn-enviar">Solicitar cita</button>
                    </div>
            </form>
            </div>
        </section>
    </main>
    <?php include '../../php/Components/notificaciones_a.php'; ?>
</body>

</html>