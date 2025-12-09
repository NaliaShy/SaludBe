<?php
require_once __DIR__ . "/../../php/Conexion/Conexion.php";

// Crear conexión
session_start();
$db = new Conexion();
// La variable de conexión es $conn, ya que así la definiste
$conn = $db->getConnect();


$idUsuario = $_SESSION['Us_id']; // ✅ AQUÍ SÍ


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Página Principal — Psicologo</title>

  <!-- TUS CSS -->

  <link rel="stylesheet" href="../../Css/Index.css">

</head>

<body>
  <div class="sidebarUsuario">
    <?php include '../../php/Components/sidebar.php'; ?>
  </div>
  <div class="main">
    <?php include '../../php/Components/añadirImagenes.php'; ?>
    <?php include 'seccions/Lista.php' ?>

    <?php include 'seccions/test.php' ?>
    <?php include 'seccions/calendario.php' ?>

    <?php include 'seccions/configuracion.php' ?>
    <?php include '../../php/chat/chat.php'; ?>
    <?php include '../../php/chat-bot/Chat.php' ?>
  </div>



  <script src="../../js/upload_carrusel.js"></script>
  <script src="../../js/Seccions/seccions.js"></script>
  <script src="../../js/test.js"></script>
  <script src="../../js/Calendario.js"></script>
  <script src="../../js/chat.js"></script>
  <script src="../../js/Guardar_seguimiento.js"></script>


</body>

</html>