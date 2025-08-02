<?php
require_once 'controladores/ControladorBase.php';
require_once 'modelos/ModeloRecoleccion.php';
require_once 'modelos/ModeloTrabajador.php';

class ControladorRecoleccion extends ControladorBase {
    private $modeloRecoleccion;
    private $modeloTrabajador;
    
    public function __construct() {
        $this->validarSesion();
        $this->modeloRecoleccion = new ModeloRecoleccion();
        $this->modeloTrabajador = new ModeloTrabajador();
    }
    
    public function mostrarFormulario() {
        $trabajadores = $this->modeloTrabajador->obtenerTodos();
        $precios = $this->modeloRecoleccion->obtenerPrecios();
        $this->cargarVista('recolecciones/formulario', [
            'trabajadores' => $trabajadores,
            'precios' => $precios
        ]);
    }
    
    public function registrar() {
        if ($_POST) {
            $trabajadorId = $_POST['trabajador_id'] ?? '';
            $fecha = $_POST['fecha'] ?? '';
            $calidad = $_POST['calidad'] ?? '';
            $kilos = $_POST['kilos'] ?? '';
            
            $resultado = $this->modeloRecoleccion->registrarRecoleccion($trabajadorId, $fecha, $calidad, $kilos);
            
            if ($resultado) {
                $this->redireccionar('index.php?accion=recolecciones_formulario&success=1');
            } else {
                $error = "Error al registrar la recolección";
                $trabajadores = $this->modeloTrabajador->obtenerTodos();
                $precios = $this->modeloRecoleccion->obtenerPrecios();
                $this->cargarVista('recolecciones/formulario', [
                    'trabajadores' => $trabajadores,
                    'precios' => $precios,
                    'error' => $error
                ]);
            }
        }
    }
    
    public function reportes() {
        $trabajadores = $this->modeloTrabajador->obtenerTodos();
        $this->cargarVista('recolecciones/reportes', ['trabajadores' => $trabajadores]);
    }
    
    public function obtenerReporte() {
        $trabajadorId = $_GET['trabajador_id'] ?? '';
        $fechaInicio = $_GET['fecha_inicio'] ?? '';
        $fechaFin = $_GET['fecha_fin'] ?? '';
        
        if ($trabajadorId) {
            $recolecciones = $this->modeloRecoleccion->obtenerRecoleccionesPorTrabajador($trabajadorId, $fechaInicio, $fechaFin);
        } else {
            $recolecciones = $this->modeloRecoleccion->obtenerReporteGeneral($fechaInicio, $fechaFin);
        }
        
        header('Content-Type: application/json');
        echo json_encode($recolecciones);
    }
}
?>
