<?php
class Conexion {
    private $host = 'localhost';
    private $usuario = 'root';
    private $contrasena = '';
    private $base_datos = 'cafe_db';
    private $conexion;
    
    public function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->base_datos};charset=utf8mb4",
                $this->usuario,
                $this->contrasena,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    public function obtenerConexion() {
        return $this->conexion;
    }
}
?>
