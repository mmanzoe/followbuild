<?php
include __DIR__ . '/class.conexion.php';
include '../lib/PHPMailer/class.envioCorreo.php';

class ValidaLogin{

    private $usuario;
    private $contrasena;
    private $estado = false;
    public $conn;
    
    function __construct($usuario, $contrasena){
        $this->conn = new Conexion();
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
    }

    private function token($id, $correo){

        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $token = "";
        
        for($i=0;$i<4;$i++) {
            $token .= substr($str,rand(0,62),1);
        }

        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("UPDATE usuario set token =? WHERE id=?");
        $consulta->bind_param('si', $token, $id);
        $consulta->execute();

        $asunto = 'token accesos sistema';
        $mensaje = "<tr>
                        <td align='center'><b>VALIDACIÓN ACCESO DE DOS PASOS</b></td>
                    </tr>
                    <tr>
                        <td style='padding:20px'>A continuación se detalla el tocken generado para su validación </td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <td style='padding-left:20px'>Token: <h2>".$token."</h2></td>
                    </tr>";
        

        $envioToken = new EnvioCorreo($correo, $asunto, $mensaje);
        $envioToken->envioMensaje(new PHPMailer());

    }

    private function actulizaSession($idregistro, $idsesion){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("UPDATE usuario set idsesion =? WHERE id=?");
        $consulta->bind_param('si', $idsesion, $idregistro);
        $consulta->execute();
    }

    private function variableSesion($idregistro, $area_asignada, $nombre, $correo, $usuario){
        $_SESSION['datos_logueo']['estado'] = true;
        $_SESSION['datos_logueo']['sistema'] = 'FollowBuild';
        $_SESSION['datos_logueo']['idusuario'] = $idregistro;
        $_SESSION['datos_logueo']['area_asignada'] = $area_asignada;
        $_SESSION['datos_logueo']['session'] = session_id();
        $_SESSION['datos_logueo']['nombre_usuario'] = $nombre;
        $_SESSION['datos_logueo']['correo'] = $correo;
        $_SESSION['datos_logueo']['usuario'] = $usuario;
    }

    function validaToken($token){
        $conexion = $this->conn->conectar();
        
        $consulta = $conexion->prepare("SELECT * FROM usuario WHERE id=? ANd token=?");
        $consulta->bind_param('is', $_SESSION['datos_logueo']['idusuario'], $token);
        $consulta->execute();
        $consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $correo, $area_asignada, $usuario, $contrasena, $estado, $idsesion, $token);
                 
            //$this->variableSesion($id, $area_asignada, $nombre, $correo, $usuario);
            $this->estado = true;
            
    
        }else{
            $this->estado = false;
        }
        return $this->estado;
    }
    
    function getValidacion(){
        $conexion = $this->conn->conectar();
        
        $consulta = $conexion->prepare("SELECT * FROM usuario WHERE usuario=?");
        $consulta->bind_param('s', $this->usuario);
        $consulta->execute();
        $consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $correo, $area_asignada, $usuario, $contrasena, $estado, $idsesion, $token);
            
            while ($consulta->fetch()) {
                
                if(password_verify($this->contrasena, $contrasena)){
                    $this->estado = true;
                    $this->token($id, $correo);
                    $this->variableSesion($id, $area_asignada, $nombre, $correo, $usuario);
                    $this->actulizaSession($id, session_id());
                    
                    break;
                }else{
                    $this->estado = false;
                }
            }
    
        }else{
            $this->estado = false;
        }
        return $this->estado;
    }

    function getEstado(){
        return $this->estado;
    }

}


?>

