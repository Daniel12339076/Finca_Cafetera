<?php
require_once 'modelos/ModeloBase.php';

class ModeloUsuario extends ModeloBase {
    
    public function autenticar($nombreUsuario, $contrasena) {
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = :usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':usuario', $nombreUsuario);
        $stmt->execute();
        
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            return $usuario;
        }
        return false;
    }
    
    public function crearUsuario($nombreUsuario, $contrasena, $rol = 'operador') {
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES (:usuario, :contrasena, :rol)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':usuario', $nombreUsuario);
        $stmt->bindParam(':contrasena', $contrasenaHash);
        $stmt->bindParam(':rol', $rol);
        
        return $stmt->execute();
    }
}
?>
