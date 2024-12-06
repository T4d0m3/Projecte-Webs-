<?php
// conexion.php
$host = '127.0.0.1';
$dbname = 'web';
$user = 'postgres';
$password = '123';

// Establecer conexión con la base de datos
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}
?>
