-- =====================================================
-- Sistema de Gestión de Recolección de Café
-- Base de datos completa con estructura y datos iniciales
-- =====================================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS cafe_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE cafe_db;

-- =====================================================
-- ESTRUCTURA DE TABLAS
-- =====================================================

-- Tabla de usuarios
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'operador') DEFAULT 'operador',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE
);

-- Tabla de trabajadores
DROP TABLE IF EXISTS trabajadores;
CREATE TABLE trabajadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    identificacion VARCHAR(20) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE
);

-- Configuración de precios por calidad
DROP TABLE IF EXISTS config_precios;
CREATE TABLE config_precios (
    calidad ENUM('bueno', 'regular', 'malo') PRIMARY KEY,
    precio_kg DECIMAL(10,2) NOT NULL,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de recolección diaria
DROP TABLE IF EXISTS recolecciones;
CREATE TABLE recolecciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trabajador_id INT NOT NULL,
    fecha DATE NOT NULL,
    calidad ENUM('bueno', 'regular', 'malo') NOT NULL,
    kilos DECIMAL(10,2) NOT NULL,
    valor_pagado DECIMAL(10,2) NOT NULL,
    observaciones TEXT,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_recoleccion (trabajador_id, fecha, calidad),
    FOREIGN KEY (trabajador_id) REFERENCES trabajadores(id) ON DELETE CASCADE,
    INDEX idx_fecha (fecha),
    INDEX idx_trabajador_fecha (trabajador_id, fecha)
);

-- Tabla de pagos (opcional para control de pagos realizados)
DROP TABLE IF EXISTS pagos;
CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trabajador_id INT NOT NULL,
    fecha_pago DATE NOT NULL,
    periodo_inicio DATE NOT NULL,
    periodo_fin DATE NOT NULL,
    monto_total DECIMAL(10,2) NOT NULL,
    observacion TEXT,
    usuario_registro INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (trabajador_id) REFERENCES trabajadores(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_registro) REFERENCES usuarios(id),
    INDEX idx_trabajador_pago (trabajador_id, fecha_pago)
);

-- Tabla de auditoría (para llevar registro de cambios importantes)
DROP TABLE IF EXISTS auditoria;
CREATE TABLE auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tabla VARCHAR(50) NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    registro_id INT NOT NULL,
    datos_anteriores JSON,
    datos_nuevos JSON,
    usuario_id INT,
    fecha_accion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    INDEX idx_tabla_fecha (tabla, fecha_accion)
);

-- =====================================================
-- DATOS INICIALES
-- =====================================================

-- Insertar usuario administrador por defecto
-- Contraseña: admin123 (hasheada con password_hash)
INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('operador1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'operador');

-- Insertar configuración de precios por defecto (en pesos colombianos)
INSERT INTO config_precios (calidad, precio_kg) VALUES 
('bueno', 5500.00),
('regular', 4500.00),
('malo', 3500.00);

-- Insertar trabajadores de ejemplo
INSERT INTO trabajadores (nombre, identificacion, telefono, direccion) VALUES 
('Juan Carlos Pérez', '12345678', '3001234567', 'Vereda La Esperanza, Finca El Cafetal'),
('María Elena González', '87654321', '3009876543', 'Vereda San José, Finca Los Naranjos'),
('Carlos Alberto Rodríguez', '11223344', '3005566778', 'Vereda El Progreso, Finca Villa María'),
('Ana Lucía Martínez', '44332211', '3007788990', 'Vereda La Palma, Finca El Descanso'),
('José Miguel Hernández', '55667788', '3002233445', 'Vereda Buenos Aires, Finca La Primavera');

-- Insertar recolecciones de ejemplo (últimos 30 días)
INSERT INTO recolecciones (trabajador_id, fecha, calidad, kilos, valor_pagado, observaciones) VALUES 
-- Recolecciones de Juan Carlos Pérez
(1, '2024-01-15', 'bueno', 25.50, 140250.00, 'Café de excelente calidad'),
(1, '2024-01-15', 'regular', 10.25, 46125.00, NULL),
(1, '2024-01-16', 'bueno', 28.75, 158125.00, NULL),
(1, '2024-01-16', 'malo', 5.00, 17500.00, 'Granos con defectos'),
(1, '2024-01-17', 'bueno', 32.00, 176000.00, NULL),

-- Recolecciones de María Elena González
(2, '2024-01-15', 'bueno', 30.75, 169125.00, NULL),
(2, '2024-01-15', 'regular', 8.50, 38250.00, NULL),
(2, '2024-01-16', 'bueno', 27.25, 149875.00, 'Muy buen día de recolección'),
(2, '2024-01-17', 'bueno', 29.50, 162250.00, NULL),
(2, '2024-01-17', 'regular', 12.75, 57375.00, NULL),

-- Recolecciones de Carlos Alberto Rodríguez
(3, '2024-01-15', 'malo', 15.00, 52500.00, 'Café afectado por lluvia'),
(3, '2024-01-15', 'regular', 20.50, 92250.00, NULL),
(3, '2024-01-16', 'bueno', 22.75, 125125.00, NULL),
(3, '2024-01-16', 'regular', 18.25, 82125.00, NULL),
(3, '2024-01-17', 'bueno', 26.00, 143000.00, NULL),

-- Recolecciones de Ana Lucía Martínez
(4, '2024-01-15', 'bueno', 24.25, 133375.00, NULL),
(4, '2024-01-16', 'bueno', 31.50, 173250.00, 'Excelente jornada'),
(4, '2024-01-16', 'regular', 7.75, 34875.00, NULL),
(4, '2024-01-17', 'bueno', 28.00, 154000.00, NULL),

-- Recolecciones de José Miguel Hernández
(5, '2024-01-15', 'regular', 22.50, 101250.00, NULL),
(5, '2024-01-15', 'malo', 8.75, 30625.00, NULL),
(5, '2024-01-16', 'bueno', 25.75, 141625.00, NULL),
(5, '2024-01-17', 'bueno', 30.25, 166375.00, NULL),
(5, '2024-01-17', 'regular', 15.50, 69750.00, NULL);

-- Insertar algunos pagos de ejemplo
INSERT INTO pagos (trabajador_id, fecha_pago, periodo_inicio, periodo_fin, monto_total, observacion, usuario_registro) VALUES 
(1, '2024-01-20', '2024-01-15', '2024-01-17', 538000.00, 'Pago semanal completo', 1),
(2, '2024-01-20', '2024-01-15', '2024-01-17', 576875.00, 'Pago semanal completo', 1),
(3, '2024-01-20', '2024-01-15', '2024-01-17', 495000.00, 'Pago semanal completo', 1);

-- =====================================================
-- VISTAS ÚTILES
-- =====================================================

-- Vista para resumen diario de recolección
CREATE OR REPLACE VIEW vista_resumen_diario AS
SELECT 
    r.fecha,
    t.nombre as trabajador,
    t.identificacion,
    SUM(CASE WHEN r.calidad = 'bueno' THEN r.kilos ELSE 0 END) as kilos_bueno,
    SUM(CASE WHEN r.calidad = 'regular' THEN r.kilos ELSE 0 END) as kilos_regular,
    SUM(CASE WHEN r.calidad = 'malo' THEN r.kilos ELSE 0 END) as kilos_malo,
    SUM(r.kilos) as total_kilos,
    SUM(r.valor_pagado) as total_valor
FROM recolecciones r
JOIN trabajadores t ON r.trabajador_id = t.id
GROUP BY r.fecha, r.trabajador_id, t.nombre, t.identificacion
ORDER BY r.fecha DESC, t.nombre;

-- Vista para estadísticas por trabajador
CREATE OR REPLACE VIEW vista_estadisticas_trabajador AS
SELECT 
    t.id,
    t.nombre,
    t.identificacion,
    COUNT(DISTINCT r.fecha) as dias_trabajados,
    SUM(r.kilos) as total_kilos,
    SUM(r.valor_pagado) as total_ganado,
    AVG(r.kilos) as promedio_kilos_dia,
    MAX(r.fecha) as ultima_recoleccion
FROM trabajadores t
LEFT JOIN recolecciones r ON t.id = r.trabajador_id
WHERE t.activo = TRUE
GROUP BY t.id, t.nombre, t.identificacion
ORDER BY total_kilos DESC;

-- Vista para reporte de productividad
CREATE OR REPLACE VIEW vista_productividad_mensual AS
SELECT 
    YEAR(r.fecha) as año,
    MONTH(r.fecha) as mes,
    MONTHNAME(r.fecha) as nombre_mes,
    COUNT(DISTINCT r.trabajador_id) as trabajadores_activos,
    SUM(r.kilos) as total_kilos,
    SUM(r.valor_pagado) as total_pagado,
    AVG(r.kilos) as promedio_kilos_dia
FROM recolecciones r
GROUP BY YEAR(r.fecha), MONTH(r.fecha), MONTHNAME(r.fecha)
ORDER BY año DESC, mes DESC;

-- =====================================================
-- PROCEDIMIENTOS ALMACENADOS
-- =====================================================

-- Procedimiento para calcular pago de un trabajador en un período
DELIMITER //
CREATE PROCEDURE CalcularPagoTrabajador(
    IN p_trabajador_id INT,
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE,
    OUT p_total_kilos DECIMAL(10,2),
    OUT p_total_pago DECIMAL(10,2)
)
BEGIN
    SELECT 
        COALESCE(SUM(kilos), 0),
        COALESCE(SUM(valor_pagado), 0)
    INTO p_total_kilos, p_total_pago
    FROM recolecciones 
    WHERE trabajador_id = p_trabajador_id 
    AND fecha BETWEEN p_fecha_inicio AND p_fecha_fin;
END //
DELIMITER ;

-- Procedimiento para obtener top trabajadores por período
DELIMITER //
CREATE PROCEDURE TopTrabajadoresPeriodo(
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE,
    IN p_limite INT
)
BEGIN
    SELECT 
        t.nombre,
        t.identificacion,
        SUM(r.kilos) as total_kilos,
        SUM(r.valor_pagado) as total_ganado,
        COUNT(DISTINCT r.fecha) as dias_trabajados
    FROM trabajadores t
    JOIN recolecciones r ON t.id = r.trabajador_id
    WHERE r.fecha BETWEEN p_fecha_inicio AND p_fecha_fin
    GROUP BY t.id, t.nombre, t.identificacion
    ORDER BY total_kilos DESC
    LIMIT p_limite;
END //
DELIMITER ;

-- =====================================================
-- TRIGGERS PARA AUDITORÍA
-- =====================================================

-- Trigger para auditar cambios en trabajadores
DELIMITER //
CREATE TRIGGER tr_trabajadores_audit_update
AFTER UPDATE ON trabajadores
FOR EACH ROW
BEGIN
    INSERT INTO auditoria (tabla, accion, registro_id, datos_anteriores, datos_nuevos)
    VALUES (
        'trabajadores',
        'UPDATE',
        NEW.id,
        JSON_OBJECT('nombre', OLD.nombre, 'identificacion', OLD.identificacion, 'telefono', OLD.telefono),
        JSON_OBJECT('nombre', NEW.nombre, 'identificacion', NEW.identificacion, 'telefono', NEW.telefono)
    );
END //
DELIMITER ;

-- Trigger para auditar eliminación de trabajadores
DELIMITER //
CREATE TRIGGER tr_trabajadores_audit_delete
AFTER DELETE ON trabajadores
FOR EACH ROW
BEGIN
    INSERT INTO auditoria (tabla, accion, registro_id, datos_anteriores)
    VALUES (
        'trabajadores',
        'DELETE',
        OLD.id,
        JSON_OBJECT('nombre', OLD.nombre, 'identificacion', OLD.identificacion, 'telefono', OLD.telefono)
    );
END //
DELIMITER ;

-- =====================================================
-- ÍNDICES ADICIONALES PARA OPTIMIZACIÓN
-- =====================================================

-- Índices para mejorar rendimiento en consultas frecuentes
CREATE INDEX idx_recolecciones_fecha_calidad ON recolecciones(fecha, calidad);
CREATE INDEX idx_trabajadores_nombre ON trabajadores(nombre);
CREATE INDEX idx_pagos_fecha ON pagos(fecha_pago);

-- =====================================================
-- DATOS DE CONFIGURACIÓN ADICIONALES
-- =====================================================

-- Insertar más recolecciones para tener datos de prueba más robustos
INSERT INTO recolecciones (trabajador_id, fecha, calidad, kilos, valor_pagado) VALUES 
-- Semana anterior
(1, '2024-01-08', 'bueno', 27.50, 151250.00),
(1, '2024-01-09', 'bueno', 29.25, 160875.00),
(1, '2024-01-10', 'regular', 15.75, 70875.00),
(2, '2024-01-08', 'bueno', 31.00, 170500.00),
(2, '2024-01-09', 'regular', 18.50, 83250.00),
(3, '2024-01-08', 'malo', 12.25, 42875.00),
(3, '2024-01-09', 'bueno', 24.75, 136125.00),
(4, '2024-01-08', 'bueno', 26.50, 145750.00),
(5, '2024-01-08', 'regular', 20.00, 90000.00);

-- =====================================================
-- CONSULTAS DE VERIFICACIÓN
-- =====================================================

-- Verificar que todo se creó correctamente
SELECT 'Usuarios creados:' as info, COUNT(*) as cantidad FROM usuarios
UNION ALL
SELECT 'Trabajadores creados:', COUNT(*) FROM trabajadores
UNION ALL
SELECT 'Precios configurados:', COUNT(*) FROM config_precios
UNION ALL
SELECT 'Recolecciones registradas:', COUNT(*) FROM recolecciones
UNION ALL
SELECT 'Pagos registrados:', COUNT(*) FROM pagos;

-- Mostrar resumen de recolecciones por trabajador
SELECT 
    t.nombre,
    COUNT(*) as registros,
    SUM(r.kilos) as total_kilos,
    SUM(r.valor_pagado) as total_valor
FROM trabajadores t
JOIN recolecciones r ON t.id = r.trabajador_id
GROUP BY t.id, t.nombre
ORDER BY total_kilos DESC;

-- =====================================================
-- COMENTARIOS FINALES
-- =====================================================

/*
Este script SQL crea una base de datos completa para el sistema de gestión 
de recolección de café con las siguientes características:

1. Estructura de tablas optimizada con índices
2. Datos de prueba realistas
3. Vistas para consultas frecuentes
4. Procedimientos almacenados para cálculos complejos
5. Triggers para auditoría
6. Configuración de precios flexible

Credenciales por defecto:
- Usuario: admin, Contraseña: admin123
- Usuario: operador1, Contraseña: admin123

Para usar en producción, cambiar las contraseñas y ajustar los precios
según las necesidades específicas de la finca.
*/