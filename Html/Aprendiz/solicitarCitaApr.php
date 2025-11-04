<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> SaludBE</title>
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
            <form action="../../php/agendarcitas.php" method="post">
                <div class="form">
                    <div class="fila">
                        <div class="campo">
                            <label for="fecha">Selecciona la fecha</label>
                            <input type="date" id="fecha" name="fecha" required>
                        </div>
                    </div>

                    <div class="campo">
                        <label for="Motivo">Motivo</label>
                        <textarea id="Motivo" name="Motivo" rows="4"></textarea>
                    </div>

                    <div class="campo">
                        <select name="Psicologo" required>
                            <option value="">Seleccione un psicólogo</option>
                            <option value="1">Psicólogo 1</option>
                            <option value="2">Psicólogo 2</option>
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