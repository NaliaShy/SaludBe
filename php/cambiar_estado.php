<?php
require "Conexion.php";

// Validar ID y estado
if (!isset($_POST["id"]) || !isset($_POST["estado"])) {
    echo "faltan_datos";
    exit;
}

$id = intval($_POST["id"]);
$estado = $_POST["estado"]; // activo / inactivo

if ($estado !== "activo" && $estado !== "inactivo") {
    echo "estado_invalido";
    exit;
}

// Crear conexión PDO
$conexion = new Conexion();
$conn = $conexion->getConnect();

// Actualizar estado
$sql = $conn->prepare("UPDATE carrusel SET estado = ? WHERE id = ?");
$ok = $sql->execute([$estado, $id]);

echo $ok ? "ok" : "error";
?>
