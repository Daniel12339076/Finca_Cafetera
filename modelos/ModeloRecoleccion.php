<?php
require_once 'modelos/ModeloBase.php';

class ModeloRecoleccion extends ModeloBase {
    
    public function obtenerPrecios() {
        $sql = "SELECT * FROM config_precios";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function obtenerPrecioPorCalidad($calidad) {
        $sql = "SELECT precio_kg FROM config_precios WHERE calidad = :calidad";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':calidad', $calidad);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado ? $resultado['precio_kg'] : 0;
    }
    
    public function registrarRecoleccion($trabajadorId, $fecha, $calidad, $kilos) {
        $precio = $this->obtenerPrecioPorCalidad($calidad);
        $valorPagado = $kilos * $precio;
        
        $sql = "INSERT INTO recolecciones (trabajador_id, fecha, calidad, kilos, valor_pagado) 
                VALUES (:trabajador_id, :fecha, :calidad, :kilos, :valor_pagado)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':trabajador_id', $trabajadorId);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':calidad', $calidad);
        $stmt->bindParam(':kilos', $kilos);
        $stmt->bindParam(':valor_pagado', $valorPagado);
        
        return $stmt->execute();
    }
    
    public function obtenerRecoleccionesPorTrabajador($trabajadorId, $fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT r.*, t.nombre as nombre_trabajador 
                FROM recolecciones r 
                JOIN trabajadores t ON r.trabajador_id = t.id 
                WHERE r.trabajador_id = :trabajador_id";
        
        if ($fechaInicio && $fechaFin) {
            $sql .= " AND r.fecha BETWEEN :fecha_inicio AND :fecha_fin";
        }
        
        $sql .= " ORDER BY r.fecha DESC";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':trabajador_id', $trabajadorId);
        
        if ($fechaInicio && $fechaFin) {
            $stmt->bindParam(':fecha_inicio', $fechaInicio);
            $stmt->bindParam(':fecha_fin', $fechaFin);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function obtenerReporteGeneral($fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT r.*, t.nombre as nombre_trabajador 
                FROM recolecciones r 
                JOIN trabajadores t ON r.trabajador_id = t.id";
        
        if ($fechaInicio && $fechaFin) {
            $sql .= " WHERE r.fecha BETWEEN :fecha_inicio AND :fecha_fin";
        }
        
        $sql .= " ORDER BY r.fecha DESC, t.nombre";
        
        $stmt = $this->conexion->prepare($sql);
        
        if ($fechaInicio && $fechaFin) {
            $stmt->bindParam(':fecha_inicio', $fechaInicio);
            $stmt->bindParam(':fecha_fin', $fechaFin);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
