DROP TABLE IF EXISTS incidencias;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    departamento VARCHAR(50) NOT NULL
);

CREATE TABLE incidencias (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo_problema VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    urgencia INT NOT NULL,
    estado VARCHAR(50) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)

);


INSERT INTO usuarios (nombre, contraseña, email, departamento) VALUES
('TecnicoDios', '1234', 'tecnico@gmail.com', 'soporte'),
('Carlos Perez', 'contraseña123', 'carlos.perez@empresa.com', 'ventas'),
('Maria Lopez', 'contraseña456', 'maria.lopez@empresa.com', 'soporte'),
('Juan Garcia', 'contraseña789', 'juan.garcia@empresa.com', 'desarrollo'),
('Ana Torres', 'contraseña101', 'ana.torres@empresa.com', 'marketing'),
('Luis Ramirez', 'contraseña112', 'luis.ramirez@empresa.com', 'ventas'),
('Pedro Martinez', 'contraseña113', 'pedro.martinez@empresa.com', 'soporte'),
('Laura Gomez', 'contraseña114', 'laura.gomez@empresa.com', 'desarrollo'),
('David Ruiz', 'contraseña115', 'david.ruiz@empresa.com', 'marketing'),
('Isabel Sanchez', 'contraseña116', 'isabel.sanchez@empresa.com', 'ventas'),
('Jorge Alvarez', 'contraseña117', 'jorge.alvarez@empresa.com', 'soporte'),
('Carlos Diaz', 'contraseña119', 'carlos.diaz@empresa.com', 'desarrollo'),
('Raquel Fernandez', 'contraseña120', 'raquel.fernandez@empresa.com', 'marketing'),
('Victor Herrera', 'contraseña121', 'victor.herrera@empresa.com', 'ventas'),
('Teresa Castro', 'contraseña122', 'teresa.castro@empresa.com', 'soporte'),
('Ricardo Lopez', 'contraseña1234', 'ricardo.lopez@empresa.com', 'desarrollo'),
('Sofia Morales', 'contraseña1235', 'sofia.morales@empresa.com', 'marketing'),
('Ezequiel Perez', 'contraseña1236', 'ezequiel.perez@empresa.com', 'ventas'),
('Rosa Ortega', 'contraseña1237', 'rosa.ortega@empresa.com', 'soporte'),
('Antonio Diaz', 'contraseña1238', 'antonio.diaz@empresa.com', 'desarrollo'),
('Lola Ruiz', 'contraseña1239', 'lola.ruiz@empresa.com', 'marketing'),
('Manuel Sanchez', 'contraseña1240', 'manuel.sanchez@empresa.com', 'ventas'),
('Carmen Garcia', 'contraseña1241', 'carmen.garcia@empresa.com', 'soporte'),
('Javier Martinez', 'contraseña1242', 'javier.martinez@empresa.com', 'desarrollo'),
('Eva Lopez', 'contraseña1243', 'eva.lopez@empresa.com', 'marketing'),
('Pablo Gomez', 'contraseña1244', 'pablo.gomez@empresa.com', 'ventas'),
('Martina Fernandez', 'contraseña1245', 'martina.fernandez@empresa.com', 'soporte'),
('Cristina Jimenez', 'contraseña1246', 'cristina.jimenez@empresa.com', 'desarrollo'),
('Luis Gonzalez', 'contraseña1247', 'luis.gonzalez@empresa.com', 'marketing'),
('Elena Alvarez', 'contraseña1248', 'elena.alvarez@empresa.com', 'ventas');


INSERT INTO incidencias (usuario_id, tipo_problema, descripcion, urgencia, estado) VALUES
(1, 'Fallo de red', 'No puedo acceder a la red interna desde mi computadora', 2, 'pendiente'),
(2, 'Error en el sistema', 'El sistema de gestión de empleados no carga correctamente', 1, 'pendiente'),
(3, 'Problema de acceso', 'No puedo acceder a mi cuenta de correo electrónico', 3, 'pendiente'),
(4, 'Fallo de hardware', 'La impresora de mi departamento no responde', 2, 'pendiente'),
(5, 'Problema con el servidor', 'El servidor se encuentra caído desde ayer', 1, 'pendiente'),
(6, 'Error en la aplicación', 'La aplicación de contabilidad tiene errores al generar informes', 3, 'pendiente'),
(7, 'Fallo de red', 'No puedo conectarme a la VPN desde casa', 2, 'pendiente'),
(8, 'Problema de acceso', 'Olvidé mi contraseña para el acceso al sistema', 3, 'pendiente'),
(9, 'Error en el sistema', 'No puedo cargar la página de inicio de la plataforma', 2, 'pendiente'),
(10, 'Problema con el servidor', 'La base de datos se encuentra inaccesible', 1, 'pendiente'),
(11, 'Fallo de hardware', 'El monitor de mi equipo no enciende', 3, 'pendiente'),
(12, 'Fallo de red', 'La conexión WiFi en la oficina está muy lenta', 2, 'pendiente'),
(13, 'Error en la aplicación', 'La aplicación no me deja actualizar mis datos', 3, 'pendiente'),
(14, 'Problema de acceso', 'No puedo iniciar sesión en la herramienta de ventas', 1, 'pendiente'),
(15, 'Fallo de hardware', 'El teclado de mi computadora no funciona correctamente', 2, 'pendiente'),
(16, 'Error en el sistema', 'La página de reporte de incidencias muestra errores', 2, 'pendiente'),
(17, 'Fallo de red', 'No tengo conexión a Internet en mi computadora', 3, 'pendiente'),
(18, 'Problema de acceso', 'Olvidé mi contraseña para el acceso al sistema', 1, 'pendiente'),
(19, 'Error en el sistema', 'El sistema de pagos está generando errores al procesar transacciones', 2, 'pendiente'),
(20, 'Problema con el servidor', 'El servidor de correo no envía mensajes', 3, 'pendiente'),
(21, 'Fallo de hardware', 'El ratón de mi computadora no funciona correctamente', 2, 'pendiente'),
(22, 'Error en la aplicación', 'La aplicación de marketing no carga bien las gráficas', 2, 'pendiente'),
(23, 'Fallo de red', 'El servidor proxy está interrumpiendo el acceso a Internet', 3, 'pendiente'),
(24, 'Problema de acceso', 'No puedo acceder a la plataforma de recursos humanos', 1, 'pendiente'),
(25, 'Fallo de hardware', 'El proyector de la sala de reuniones no está funcionando', 3, 'pendiente'),
(26, 'Error en el sistema', 'El sistema de pagos está realizando deducciones incorrectas', 2, 'pendiente'),
(27, 'Problema con el servidor', 'El servidor de respaldo está inactivo', 1, 'pendiente'),
(28, 'Fallo de red', 'La red WiFi está intermitente en toda la oficina', 3, 'pendiente'),
(29, 'Error en la aplicación', 'La aplicación no me permite generar reportes', 2, 'pendiente'),
(30, 'Fallo de hardware', 'La impresora no responde al intentar imprimir documentos', 1, 'pendiente');
