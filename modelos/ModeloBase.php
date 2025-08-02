<?php
require_once 'config/conexion.php';

class ModeloBase {
    protected $conexion;
    
    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->obtenerConexion();
    }
}
?>
