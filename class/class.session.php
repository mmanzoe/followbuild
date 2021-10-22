<?php
include_once __DIR__ . '/../php/class.conexion.php';

class validasesion
{
    private $conn;
    private $login;
    private $idlogin;
    private $sesion;    

    function __construct()
    {
        $this->conn = new Conexion();
        $this->login = $_SESSION['datos_logueo']['estado'];
        $this->idlogin = $_SESSION['datos_logueo']['idusuario'];
        $this->sesion = $_SESSION['datos_logueo']['session'];
    }

    function getValidaLogin(){
        
        if($this->login ===true){
            header("../../");
        }else{return true;die();}
        
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT id, idsesion FROM usuario WHERE id=? AND idsesion=?");
        $consulta->bind_param('is', $this->idlogin, $this->sesion);
        $consulta->execute();
        $consulta->store_result();

        if($consulta->num_rows>0){return true;}else{header("../../");}
        
    }

}

?>