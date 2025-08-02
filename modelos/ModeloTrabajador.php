<?php
require_once 'modelos/ModeloBase.php';

class ModeloTrabajador extends ModeloBase {
    
    public function obtenerTodos() {
        $sql = "SELECT * FROM trabajadores ORDER BY nombre";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM trabajadores WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function crear($nombre, $identificacion, $telefono) {
        $sql = "INSERT INTO trabajadores (nombre, identificacion, telefono) VALUES (:nombre, :identificacion, :telefono)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->bindParam(':telefono', $telefono);
        
        return $stmt->execute();
    }
    
    public function actualizar($id, $nombre, $identificacion, $telefono) {
        $sql = "UPDATE trabajadores SET nombre = :nombre, identificacion = :identificacion, telefono = :telefono WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->bindParam(':telefono', $telefono);
        
        return $stmt->execute();
    }
    
    public function eliminar($id) {
        $sql = "DELETE FROM trabajadores WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
?>
