<?php
session_start(); // Iniciar la sesión

require_once 'cone.php'; // Conexión a la base de datos

if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        header("Location: ../index.html?error=Por favor, complete todos los campos");
        exit();
    }

    // Validar formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.html?error=Correo electrónico no válido");
        exit();
    }

    // Consultar la base de datos por el usuario
    $query = "SELECT id, nombre, email, contraseña, departamento FROM usuarios WHERE email = $1";
    $result = pg_query_params($conn, $query, array($email));

    if (!$result) {
        die("Error en la consulta: " . pg_last_error($conn));
    }

    $user_data = pg_fetch_assoc($result);

    // Verificar las credenciales
    if ($user_data && $password === $user_data['contraseña']) { // Compara directamente, pero usa hashing en producción
        // Configurar las variables de sesión
        $_SESSION['usuario'] = $user_data['nombre']; // Nombre del usuario
        $_SESSION['user_id'] = $user_data['id']; // ID del usuario
        $_SESSION['email'] = $user_data['email']; // Correo del usuario
        $_SESSION['departamento'] = $user_data['departamento']; // Departamento del usuario

        // Opcional: regenerar ID de sesión
        session_regenerate_id(true);

        // Establecer cookies para recordar sesión si se selecciona "Recordarme"
        if (isset($_POST['remember_me'])) {
            setcookie('remember_me', $user_data['id'], time() + (30 * 24 * 60 * 60), "/", "", true, true); // Cookie segura
            setcookie('usuario', $user_data['nombre'], time() + (30 * 24 * 60 * 60), "/");
        }

        // Guardar preferencias del usuario en cookies
        setcookie('ultima_pagina', $_SERVER['REQUEST_URI'], time() + (30 * 60), "/"); // Última página visitada
        setcookie('tema', 'oscuro', time() + (365 * 24 * 60 * 60), "/"); // Ejemplo de tema

        // Redirección basada en el departamento
        if ($user_data['departamento'] === 'soporte') {
            header("Location: control.php"); // Redirigir al panel de control
        } else {
            header("Location: formulario.php"); // Redirigir al formulario general
        }
        exit();
    } else {
        // Credenciales incorrectas
        header("Location: ../index.html?error=Credenciales incorrectas");
        exit();
    }
} else {
    header("Location: ../index.html?error=Acceso no autorizado");
    exit();
}
?>
