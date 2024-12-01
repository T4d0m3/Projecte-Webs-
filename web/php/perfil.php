<?php
require_once 'cone.php';

session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html?error=Por favor, inicie sesión.");
    exit();
}

// Nombre de usuario almacenado en la sesión
$logged_user = $_SESSION['usuario'];

// Consultar la información del usuario
$sql = "SELECT nombre, email, departamento FROM usuarios WHERE nombre = $1";
$result = pg_query_params($conn, $sql, array($logged_user));

// Verificar el resultado de la consulta
if (!$result) {
    die("Error en la consulta: " . pg_last_error($conn));
}

$user_data = pg_fetch_assoc($result);
if (!$user_data) {
    die("Usuario no encontrado.");
}

// Cerrar la conexión
pg_close($conn);

// Variables para el perfil
$nombre = htmlspecialchars($user_data['nombre'] ?? 'No disponible');
$email = htmlspecialchars($user_data['email'] ?? 'No disponible');
$departamento = htmlspecialchars($user_data['departamento'] ?? 'No disponible');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styleperfil.css">
</head>
<body>
<div class="overlay"></div>
<div class="sidebar" id="sidebar">
    <div class="d-flex flex-column flex-shrink-0 p-3">
        <a href="../index.html" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
            <span class="fs-4 text-white">Gestión de Incidentes</span>
        </a>
        <hr class="bg-light">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="control.php?estado=pendiente" class="nav-link <?= ($estado === 'pendiente') ? 'active' : '' ?>" aria-current="page">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Incidentes Pendientes
                </a>
            </li>
            <li>
                <a href="control.php?estado=resuelto" class="nav-link <?= ($estado === 'resuelto') ? 'active' : '' ?>">
                    <i class="bi bi-check-circle"></i>
                    Incidentes Resueltos
                </a>
            </li>
            <li>
                <a href="perfil.php" class="nav-link">
                    <i class="bi bi-person me-2"></i>
                    Perfil
                </a>
            </li>
            <li>
                <a href="users.php" class="nav-link">
                    <i class="bi bi-people me-2"></i>
                    Gestión de Usuarios
                </a>
            </li>
        </ul>
    </div>
</div>
    <div class="container02 content02">
        <div class="card02 p-4">
            <div class="row align-items-center mb-4">
                <div class="col text-center text-md-start">
                    <h2 class="text-white mb-0"><?php echo $nombre; ?></h2>
                    <p class="text-light-blue mb-0"><?php echo $departamento; ?></p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="info-card02 p-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope text-light-blue me-3"></i>
                            <div>
                                <p class="text-light-blue mb-0">Email</p>
                                <p class="text-white mb-0"><?php echo $email; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card02 p-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-building text-light-blue me-3"></i>
                            <div>
                                <p class="text-light-blue mb-0">Departamento</p>
                                <p class="text-white mb-0"><?php echo $departamento; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card02 p-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-geo-alt text-light-blue me-3"></i>
                            <div>
                                <p class="text-light-blue mb-0">Ubicación</p>
                                <p class="text-white mb-0">New York, NY</p> <!-- Estática -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
