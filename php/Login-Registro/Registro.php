<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $apellios = $_POST['apellios'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $tipo_doc = isset($_POST['tipo-doc']) ? (int)$_POST['tipo-doc'] : null; // ID del tipo de documento
    $num_document = $_POST['num_document'] ?? '';
    $estado = "activo";

    if (!$nombre || !$correo || !$contrasena) {
        die("Faltan datos obligatorios.");
    }

    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    require "../Conexion/Conexion.php";

    try {
        $db = new Conexion();
        $pdo = $db->getConnect();

        // 1) Verificar si el correo ya existe
        $check = $pdo->prepare("SELECT Us_id FROM usuarios WHERE Us_correo = ?");
        $check->execute([$correo]);
        if ($check->fetch()) {
            echo "<script>alert('El correo ya está registrado.'); window.location.href='../../Html/Login/Login.html';</script>";
            exit;
        }

        // 2) Insertar nuevo usuario (usando parámetros posicionados)
        $sql = "INSERT INTO usuarios 
            (Us_nombre, Us_apellios, Us_telefono, Us_correo, Us_contraseña, Us_estado, Ti_id, Us_documento, Rol_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $stmt = $pdo->prepare($sql);
        // Si num_document es numérico, podes castear a int. Aquí lo dejamos como string.
        $stmt->execute([$nombre, $apellios, $telefono, $correo, $contrasena_hash, $estado, $tipo_doc, $num_document]);

        echo "<script>alert('Registro exitoso'); window.location.href='../../Html/Login/Login.php';</script>";
        exit;
    } catch (PDOException $e) {
        // En producción no muestres $e->getMessage() directamente
        error_log("Registro error: " . $e->getMessage());
        echo "Ocurrió un error al registrar. Intentá nuevamente.";
        exit;
    }
}
