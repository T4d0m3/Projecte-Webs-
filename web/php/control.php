<?php
require_once 'cone.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

// Procesar el formulario "Marcar como Resuelto"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $incidentId = intval($_POST['delete_id']);

    // Actualiza el estado del incidente en la base de datos
    $query = "UPDATE incidencias SET estado = 'resuelto' WHERE id = $1";
    $result = pg_query_params($conn, $query, array($incidentId));

    if ($result) {
        $message = "El incidente ha sido marcado como resuelto.";
        error_log("Incidente $incidentId marcado como resuelto.");
    } else {
        $error = "Error al marcar el incidente como resuelto: " . pg_last_error($conn);
        error_log($error);
    }
}

// Obtener el estado de los incidentes
$estado = isset($_GET['estado']) ? $_GET['estado'] : 'pendiente';

// Consulta para obtener los incidentes según el estado
$query = "SELECT id, usuario_id, tipo_problema, descripcion, urgencia, estado FROM incidencias WHERE estado = $1";
$result = pg_query_params($conn, $query, array($estado));

if (!$result) {
    error_log("Error en la consulta: " . pg_last_error($conn));
    die("Error en la consulta: " . pg_last_error($conn));
}

$incidents = [];
while ($row = pg_fetch_assoc($result)) {
    $incidents[] = [
        'id' => $row['id'],
        'title' => $row['tipo_problema'],
        'description' => $row['descripcion'],
        'status' => ($row['estado'] === 'resuelto') ? 'Resuelto' : 'Pendiente',
        'urgency' => ($row['urgencia'] >= 50) ? 'Urgente' : 'Normal',
        'dateReported' => '00:00' // Cambia esto si tienes un timestamp real
    ];
}

pg_close($conn);

// Función para obtener el color del badge según el estado
function getBadgeColor($status) {
    return ($status === 'Urgente') ? 'danger' : 'secondary';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Incidentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/stylecontrol.css">
</head>
<body>
    <!-- Fondo de la página con imagen y desenfoque -->
    <div class="background-image"></div>
    <div class="overlay"></div>
    <!-- Sidebar -->
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

    <!-- Contenido principal -->
    <div class="content" id="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 text-white">Lista de Incidentes - <?= ucfirst($estado) ?></span>
            </div>
        </nav>

        <div class="container mt-4">
            <!-- Mensajes de éxito o error -->
            <?php if (isset($message)) : ?>
                <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
            <?php elseif (isset($error)) : ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Contenedor de tarjetas de incidentes con columnas -->
            <div id="incidentList" class="row g-4">
                <?php foreach ($incidents as $incident): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title text-white"><?= htmlspecialchars($incident['title']) ?></h5>
                                    <span class="badge bg-<?= getBadgeColor($incident['urgency']) ?>">
                                        <?= htmlspecialchars($incident['urgency']) ?>
                                    </span>
                                </div>
                                <p class="card-text">
                                    <small class="text-white">Hora Reporte: <?= htmlspecialchars($incident['dateReported']) ?></small>
                                </p>
                                <p class="card-text text-white-50"><?= htmlspecialchars($incident['description']) ?></p>
                            </div>
                            <div class="card-footer bg-transparent border-top border-light">
                                <?php if ($estado === 'pendiente'): ?>
                                    <form method="post" action="control.php">
                                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($incident['id']) ?>">
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-check-lg me-1"></i> Marcar como Resuelto
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-success"><i class="bi bi-check-circle me-1"></i> Resuelto</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
