<?php
require_once 'C:\laragon\www\SaludBe\php\Conexion\Conexion.php';
// Crear conexión
session_start();
$db = new Conexion();
// La variable de conexión es $conn, ya que así la definiste
$conn = $db->getConnect();



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página Principal</title>

    <link rel="stylesheet" href="../../Css/Index.css">


</head>

<body>
    <div class="sidebarUsuario">
        <?php include '../../php/Components/sidebar.php'; ?>
    </div>

    <div class="main">
        <?php include '../../php/Components/carrusel.php'; ?>
        <?php include 'seccions/solicitarCitaApr.php'; ?>
        <?php include 'seccions/Historial.php'; ?>
        <?php include 'seccions/test.php'; ?>
        <?php include 'seccions/calendario.php'; ?>
        <?php include 'seccions/configuracion.php' ?>
        <?php include '../../php/chat-bot/Chat.php' ?>
        <?php include '../../php/chat/chat.php'; ?>
    </div>

    <script src="../../js/Seccions/seccions.js"></script>
</body>
<script>
    window.onload = function() {
        const bienvenida = document.getElementById('bienvenida');
        bienvenida.classList.add("show");

        setTimeout(() => {
            bienvenida.classList.remove("show");
        }, 4000);
    }
</script>

</html>