<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

require_once 'cone.php';

// Verificar la conexión a la base de datos
if (!$conn) {
    die("Error en la conexión a la base de datos: " . pg_last_error());
}

// Manejar el formulario para registrar incidencias
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_incidente'])) {
    $userId = $_SESSION['user_id'];  // Obtener el ID del usuario desde la sesión
    $problemType = htmlspecialchars($_POST['problemType']);
    $description = htmlspecialchars($_POST['description']);
    $urgency = intval($_POST['urgency']);
    $estado = 'pendiente';  // Valor predeterminado de estado para la incidencia

    // Validar que los datos no estén vacíos y que la urgencia esté en el rango correcto
    if (empty($problemType) || empty($description) || $urgency < 0 || $urgency > 100) {
        header("Location: formulario.php?error=" . urlencode("Por favor complete todos los campos correctamente."));
        exit();
    }

    // Realizar la inserción de la incidencia en la base de datos
    $query = "INSERT INTO incidencias (usuario_id, tipo_problema, descripcion, urgencia, estado) 
              VALUES ($1, $2, $3, $4, $5)";
    $result = pg_query_params($conn, $query, array($userId, $problemType, $description, $urgency, $estado));

    if ($result) {
        // Redirigir con mensaje de éxito
        header("Location: formulario.php?success=" . urlencode("Incidencia registrada exitosamente."));
        exit();
    } else {
        // Manejar errores de la consulta SQL
        $error = pg_last_error($conn);
        error_log("Error al registrar incidencia: " . $error);
        header("Location: formulario.php?error=" . urlencode("Error al registrar la incidencia."));
        exit();
    }
}

// Cerrar la conexión a la base de datos
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/styleform.css">
    <script src="../assets/mainform.js" defer></script>
</head>
<body>
    <div class="cyberpunk-bg">
        <div class="container min-vh-100 d-flex align-items-center justify-content-center">
            <div class="glass-panel p-4 p-md-5 rounded-4 position-relative">
                <div class="glow-effect"></div>
                <h1 class="text-center mb-4">Formulario</h1>

                <!-- Mostrar mensajes de éxito o error -->
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
                <?php elseif (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                <?php endif; ?>

                <form id="supportForm" method="POST" action="">
                    <div class="mb-3">
                        <label for="problemType" class="form-label">Tipo de Problema</label>
                        <select class="form-select glass-input" id="problemType" name="problemType" required>
                            <option selected disabled>Selecciona el tipo de problema</option>
                            <option value="hardware">Hardware</option>
                            <option value="software">Software</option>
                            <option value="network">Red</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción del Problema</label>
                        <textarea class="form-control glass-input" id="description" name="description" rows="3" placeholder="Describe el problema..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="urgency" class="form-label">Nivel de Urgencia</label>
                        <input type="range" class="form-range" id="urgency" name="urgency" min="0" max="100" step="1" required>
                        <div id="urgencyValue" class="text-center">50</div>
                    </div>
                    <button type="submit" name="submit_incidente" class="btn btn-cyber w-100">Enviar</button>
                    <br><br>
                    <button onclick="window.location.href='logout.php';" type="button" class="btn btn-cyber w-100">Salir</button>
                </form>

                <!-- Mostrar cookies configuradas -->
                <h2 class="mt-4">Cookies Configuradas</h2>
                <ul class="list-group">
                    <?php if (count($_COOKIE) > 0): ?>
                        <?php foreach ($_COOKIE as $name => $value): ?>
                            <li class="list-group-item">
                                <strong><?= htmlspecialchars($name) ?>:</strong> <?= htmlspecialchars($value) ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item">No hay cookies configuradas.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Actualizar el valor del rango de urgencia
        const urgencySlider = document.getElementById('urgency');
        const urgencyValue = document.getElementById('urgencyValue');

        urgencySlider.addEventListener('input', () => {
            urgencyValue.textContent = urgencySlider.value + '%';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
