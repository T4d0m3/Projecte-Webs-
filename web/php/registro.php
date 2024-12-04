<?php
session_start();
require_once 'cone.php';

// Manejar el registro de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $nombre = $_POST['user'];
    $email = $_POST['email'];
    $contraseña = $_POST['password'];
    $departamento = $_POST['departamento'];

    // Proteger contra inyecciones SQL
    $nombre = pg_escape_string($conn, $nombre);
    $email = pg_escape_string($conn, $email);
    $departamento = pg_escape_string($conn, $departamento);

    // Generar un hash de la contraseña
    $contraseña_hashed = password_hash($contraseña, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, contraseña, email, departamento) VALUES ('$nombre', '$contraseña_hashed', '$email', '$departamento')";

    if (pg_query($conn, $sql)) {
        // Redirigir a formulario.php
        header("Location: formulario.php");
        exit();
    } else {
        // Error al registrar
        echo "Error al registrar: " . pg_last_error($conn);
    }
}

pg_close($conn);
?>
