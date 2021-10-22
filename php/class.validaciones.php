<?php

include __DIR__ . '/class.conexion.php';

class Validaciones{

    function generaContrasena(){

        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $password = "";
        
        for($i=0;$i<10;$i++) {
            $password .= substr($str,rand(0,62),1);
        }

        return $password;
    }

    function validaCorreo($correo){

        $conn = new Conexion();
        $conexion = $conn->conectar();

        $query = "SELECT * FROM usuario WHERE correo='".$correo."' LIMIT 1";
        $resultado = mysqli_query($conexion, $query);

        if(mysqli_num_rows($resultado)>0){
            return true;
        }else{
            return false;
        }
    }

    function actualizaContrasena($correo, $contrasena){

        $conn = new Conexion();
        $conexion = $conn->conectar();
     
        mysqli_query($conexion, "START TRANSACTION");
        $update = "UPDATE usuario SET contrasena='".password_hash($contrasena, PASSWORD_DEFAULT)."' WHERE correo='".$correo."'";
        $resultado = mysqli_query($conexion, $update);

        if($resultado){
            mysqli_query($conexion, "COMMIT");
            return true;
        }else{
            mysqli_query($conexion, "ROLLBACK");
            return false;
        }

    }

    function validaContrasena($id, $usuario, $pass){

        $conn = new Conexion();
        $conexion = $conn->conectar();
        
        $consulta = $conexion->prepare("SELECT * FROM usuario WHERE id=?");
        $consulta->bind_param('s', $id);
        $consulta->execute();
        $consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $correo, $area_asignada, $usuario, $contrasena, $estado, $idsesion, $token);
            
            while ($consulta->fetch()) {
                
                if(password_verify($pass, $contrasena)){
                    return true;
                }else{
                    return false;
                }
            }
    
        }else{
            return false;
        }
       
    }

}


?>