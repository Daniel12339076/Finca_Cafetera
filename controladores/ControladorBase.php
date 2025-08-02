<?php
class ControladorBase {
    
    protected function cargarVista($vista, $datos = []) {
        extract($datos);
        require_once "vistas/{$vista}.php";
    }
    
    protected function redireccionar($url) {
        header("Location: {$url}");
        exit();
    }
    
    protected function validarSesion() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            $this->redireccionar('index.php?accion=login');
        }
    }
}
?>
