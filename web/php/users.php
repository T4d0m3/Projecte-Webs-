<?php
// Incluye la conexión a la base de datos
require_once 'cone.php';

// Consulta para obtener usuarios y departamentos
$sql = "SELECT nombre, email, departamento FROM usuarios";
$result = pg_query($conn, $sql);

// Almacenamos los resultados
$users = [];
if (pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        $users[] = $row;
    }
}

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styleuser.css">
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

    <div class="content">
        <div class="background-image"></div>
        <div class="container glass-container">
            <h1 class="text-center mb-4">Gestión de Usuarios</h1>
            <div class="row" id="userList">
                <!-- Los usuarios se insertarán aquí dinámicamente -->
                <?php foreach ($users as $user): ?>
                    <div class="col-md-4 mb-4">
                        <div class="user-card">
                            <div class="user-name"><?php echo htmlspecialchars($user['nombre']); ?></div>
                            <div class="user-email"><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></div>
                            <div class="user-department"><i class="bi bi-building"></i> <?php echo htmlspecialchars($user['departamento']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
