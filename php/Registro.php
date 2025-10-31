<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellios = $_POST['apellios'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $tipo_doc = $_POST['tipo-doc']; // ID del tipo de documento
    $num_document = $_POST['num_document'];
    $estado = "activo"; // por defecto

    // Cifrar la contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "natalia123", "saludBE");

     // Verificar la conexión

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar si el correo ya existe
    $check = $conn->prepare("SELECT Us_id FROM usuarios WHERE Us_correo = ?");
    $check->bind_param("s", $correo);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('El correo ya está registrado.'); window.location.href='/Html/Login/Registrate.html';</script>";
        $check->close();
        $conn->close();
        exit;
    }
    $check->close();

    // Insertar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (Us_nombre, Us_apellios, Us_telefono, Us_correo, Us_contraseña, Us_estado, Ti_id, Us_documento) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssssii", $nombre, $apellios, $telefono, $correo, $contrasena_hash, $estado, $tipo_doc, $num_document);

    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso'); window.location.href='../Html/Login/Loginaprendiz.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
