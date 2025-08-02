# Sistema de Gestión de Recolección de Café

Sistema web desarrollado en PHP con arquitectura MVC para gestionar el proceso de recolección de café en fincas caficultoras.

## Características

- **Gestión de Trabajadores**: Registro, edición y eliminación de trabajadores recolectores
- **Registro de Recolección**: Control diario de kilos recolectados por calidad
- **Cálculo Automático**: Cálculo automático de pagos según configuración de precios
- **Reportes**: Consultas por trabajador, fecha y tipo de calidad
- **Autenticación**: Sistema de login con roles (admin/operador)
- **Responsive**: Interfaz adaptable a dispositivos móviles

## Estructura del Proyecto

\`\`\`
sistema-cafe/
├── config/
│   └── conexion.php
├── controladores/
│   ├── ControladorBase.php
│   ├── ControladorAuth.php
│   ├── ControladorTrabajador.php
│   └── ControladorRecoleccion.php
├── modelos/
│   ├── ModeloBase.php
│   ├── ModeloUsuario.php
│   ├── ModeloTrabajador.php
│   └── ModeloRecoleccion.php
├── vistas/
│   ├── auth/
│   ├── layout/
│   ├── trabajadores/
│   └── recolecciones/
├── assets/
│   ├── css/
│   └── js/
├── scripts/
│   └── inicializar_datos.sql
└── index.php
\`\`\`

## Instalación

1. **Configurar Base de Datos**:
   - Crear la base de datos usando el script SQL proporcionado
   - Ejecutar el script de inicialización de datos

2. **Configurar Conexión**:
   - Editar `config/conexion.php` con los datos de tu base de datos

3. **Servidor Web**:
   - Colocar los archivos en el directorio del servidor web
   - Asegurar que PHP tenga permisos de escritura

## Uso

### Credenciales por Defecto
- **Usuario**: admin
- **Contraseña**: password

### Funcionalidades Principales

1. **Dashboard**: Vista general del sistema
2. **Trabajadores**: Gestión completa de trabajadores
3. **Recolección**: Registro diario de recolección
4. **Reportes**: Consultas y estadísticas

## Tecnologías Utilizadas

- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Bootstrap 5
- **Arquitectura**: MVC (Modelo-Vista-Controlador)

## Características Técnicas

- Validaciones en frontend y backend
- Protección contra inyección SQL (PDO)
- Sesiones seguras
- Responsive design
- Código limpio y documentado

## Soporte

Para soporte técnico o consultas, contactar al desarrollador.
