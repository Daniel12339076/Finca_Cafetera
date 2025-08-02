<?php
require_once 'controladores/ControladorBase.php';
require_once 'modelos/ModeloTrabajador.php';

class ControladorTrabajador extends ControladorBase {
    private $modeloTrabajador;
    
    public function __construct() {
        $this->validarSesion();
        $this->modeloTrabajador = new ModeloTrabajador();
    }
    
    public function listar() {
        $trabajadores = $this->modeloTrabajador->obtenerTodos();
        $this->cargarVista('trabajadores/listar', ['trabajadores' => $trabajadores]);
    }
    
    public function mostrarFormulario($id = null) {
        $trabajador = null;
        if ($id) {
            $trabajador = $this->modeloTrabajador->obtenerPorId($id);
        }
        $this->cargarVista('trabajadores/formulario', ['trabajador' => $trabajador]);
    }
    
    public function guardar() {
        if ($_POST) {
            $nombre = $_POST['nombre'] ?? '';
            $identificacion = $_POST['identificacion'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $id = $_POST['id'] ?? null;
            
            if ($id) {
                $resultado = $this->modeloTrabajador->actualizar($id, $nombre, $identificacion, $telefono);
            } else {
                $resultado = $this->modeloTrabajador->crear($nombre, $identificacion, $telefono);
            }
            
            if ($resultado) {
                $this->redireccionar('index.php?accion=trabajadores');
            } else {
                $error = "Error al guardar el trabajador";
                $this->cargarVista('trabajadores/formulario', ['error' => $error]);
            }
        }
    }
    
    public function eliminar($id) {
        $resultado = $this->modeloTrabajador->eliminar($id);
        $this->redireccionar('index.php?accion=trabajadores');
    }
}
?>
