<?php
require_once 'controladores/ControladorBase.php';
require_once 'modelos/ModeloUsuario.php';

class ControladorAuth extends ControladorBase {
    private $modeloUsuario;
    
    public function __construct() {
        $this->modeloUsuario = new ModeloUsuario();
    }
    
    public function mostrarLogin() {
        $this->cargarVista('auth/login');
    }
    
    public function procesarLogin() {
        if ($_POST) {
            $usuario = $_POST['usuario'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            
            $usuarioAutenticado = $this->modeloUsuario->autenticar($usuario, $contrasena);
            
            if ($usuarioAutenticado) {
                session_start();
                $_SESSION['usuario_id'] = $usuarioAutenticado['id'];
                $_SESSION['usuario_nombre'] = $usuarioAutenticado['nombre_usuario'];
                $_SESSION['usuario_rol'] = $usuarioAutenticado['rol'];
                
                $this->redireccionar('index.php?accion=dashboard');
            } else {
                $error = "Usuario o contraseña incorrectos";
                $this->cargarVista('auth/login', ['error' => $error]);
            }
        }
    }
    
    public function cerrarSesion() {
        session_start();
        session_destroy();
        $this->redireccionar('index.php?accion=login');
    }
}
?>
