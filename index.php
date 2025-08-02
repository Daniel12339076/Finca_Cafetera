<?php
// Archivo principal del sistema - Controlador frontal

// Incluir controladores
require_once 'controladores/ControladorAuth.php';
require_once 'controladores/ControladorTrabajador.php';
require_once 'controladores/ControladorRecoleccion.php';

// Obtener la acción solicitada
$accion = $_GET['accion'] ?? 'login';

// Enrutador principal
switch ($accion) {
    // Autenticación
    case 'login':
        $controlador = new ControladorAuth();
        $controlador->mostrarLogin();
        break;
        
    case 'procesar_login':
        $controlador = new ControladorAuth();
        $controlador->procesarLogin();
        break;
        
    case 'cerrar_sesion':
        $controlador = new ControladorAuth();
        $controlador->cerrarSesion();
        break;
        
    // Dashboard
    case 'dashboard':
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?accion=login');
            exit();
        }
        include 'vistas/dashboard.php';
        break;
        
    // Trabajadores
    case 'trabajadores':
        $controlador = new ControladorTrabajador();
        $controlador->listar();
        break;
        
    case 'trabajador_formulario':
        $controlador = new ControladorTrabajador();
        $id = $_GET['id'] ?? null;
        $controlador->mostrarFormulario($id);
        break;
        
    case 'trabajador_guardar':
        $controlador = new ControladorTrabajador();
        $controlador->guardar();
        break;
        
    case 'trabajador_eliminar':
        $controlador = new ControladorTrabajador();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controlador->eliminar($id);
        }
        break;
        
    // Recolecciones
    case 'recolecciones_formulario':
        $controlador = new ControladorRecoleccion();
        $controlador->mostrarFormulario();
        break;
        
    case 'recoleccion_registrar':
        $controlador = new ControladorRecoleccion();
        $controlador->registrar();
        break;
        
    case 'reportes':
        $controlador = new ControladorRecoleccion();
        $controlador->reportes();
        break;
        
    case 'obtener_reporte':
        $controlador = new ControladorRecoleccion();
        $controlador->obtenerReporte();
        break;
        
    // Acción por defecto
    default:
        header('Location: index.php?accion=login');
        break;
}
?>
