<?php

class NuevoUsuario{

    private $nombre;
    private $correo;
    private $usuario;
    private $contrasena;
    private $conn;
    private $estado = false;

    function __construct($nombre, $correo){
        $this->conn = new Conexion();
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->usuario = $correo;
    }

    function altaUSuario(){
        
        $validaciones = new Validaciones();
        $conexion = $this->conn->conectar();

        if($validaciones->validaCorreo($this->correo) === false){

            
            $this->contrasena = $validaciones->generaContrasena();
            $pass = password_hash($this->contrasena, PASSWORD_DEFAULT);

            mysqli_query($conexion, "START TRANSACTION");
            $insert = "INSERT INTO usuario(nombre, correo, usuario, contrasena) VALUES('$this->nombre','$this->correo','$this->usuario','$pass')";
            $resultado = mysqli_query($conexion, $insert);
            
            
            if($resultado){
                mysqli_query($conexion, "COMMIT");
                $this->estado = true;
            }else{
                mysqli_query($conexion, "ROLLBACK");
                $this->estado = false;   
            }

        }else{
            $this->estado = 'correo electronico ya registrado'; 
        }

    }


    function getCreaUsuario(){
        $this->altaUSuario();
        return $this->estado;
    }

    function getUsuario(){
        return $this->usuario;
    }

    function getContrasena(){
        return $this->contrasena;
    }

    function getCorreo(){
        return $this->correo;
    }

    function getEstado(){
        return $this->estado;
    }

}



?>