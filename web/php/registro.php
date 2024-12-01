<?php
session_start();
// Incluye la conexión a la base de datos
require_once 'cone.php';

// Manejar el registro de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $nombre = $_POST['user'];
    $email = $_POST['email'];
    $contraseña = $_POST['password'];
    $departamento = $_POST['departamento']; // Capturamos el departamento

    // Proteger contra inyecciones SQL
    $nombre = pg_escape_string($conn, $nombre);
    $email = pg_escape_string($conn, $email);
    $contraseña = pg_escape_string($conn, $contraseña);
    $departamento = pg_escape_string($conn, $departamento); 

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, contraseña, email, departamento) VALUES ('$nombre', '$contraseña', '$email', '$departamento')";

    if (pg_query($conn, $sql)) {
        //redirigir a formulario.php
        header("Location: formulario.php");
        exit();
    } else {
        // Error al registrar
        echo "Error al registrar: " . pg_last_error($conn);
    }
}

pg_close($conn);
?>
