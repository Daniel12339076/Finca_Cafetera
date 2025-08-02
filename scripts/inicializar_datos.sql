-- Script para inicializar datos básicos del sistema

-- Insertar usuario administrador por defecto
INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Contraseña: password

-- Insertar configuración de precios por defecto
INSERT INTO config_precios (calidad, precio_kg) VALUES 
('bueno', 5000.00),
('regular', 4000.00),
('malo', 3000.00);

-- Insertar algunos trabajadores de ejemplo
INSERT INTO trabajadores (nombre, identificacion, telefono) VALUES 
('Juan Pérez', '12345678', '3001234567'),
('María González', '87654321', '3009876543'),
('Carlos Rodríguez', '11223344', '3005566778');

-- Insertar algunas recolecciones de ejemplo
INSERT INTO recolecciones (trabajador_id, fecha, calidad, kilos, valor_pagado) VALUES 
(1, '2024-01-15', 'bueno', 25.50, 127500.00),
(1, '2024-01-15', 'regular', 10.25, 41000.00),
(2, '2024-01-15', 'bueno', 30.75, 153750.00),
(3, '2024-01-15', 'malo', 15.00, 45000.00);
