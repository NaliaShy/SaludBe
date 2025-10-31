<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> SaludBE</title>
    <link rel="stylesheet" href="../../Css/Repetivos/root.css">
    <link rel="stylesheet" href="../../Css/Repetivos/sidebar_A.css">
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
            <form action="../../php/Guardar-cita.php" method="post">
                <div class="form">
                    <div class="fila">
                        <div class="campo">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>
                        <div class="campo">
                            <label for="fecha">Selecciona la fecha</label>
                            <input type="date" id="fecha" name="fecha" required>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="campo">
                            <label for="apellido">Apellido</label>
                            <input type="text" id="apellido" name="apellido" required>
                        </div>
                        <div class="campo">
                            <label for="celular">Celular</label>
                            <input type="tel" id="celular" name="celular" required>
                        </div>
                    </div>

                    <div class="campo">
                        <label for="correo">Correo electrónico</label>
                        <input type="email" id="correo" name="correo" required>
                    </div>

                    <div class="campo">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="4"></textarea>
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