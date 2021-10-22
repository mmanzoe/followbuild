<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();


class GastoProyecto{
	private $registros = [];
    private $codigo;
    private $nombre;
    
	function __construct(){
		$this->conn = new Conexion();
	}

	function listado(){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT * FROM cat_tipo_gasto");

        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $usuario_ingresa, $fecha_ingresa);

            while ($consulta->fetch()) {
                
				array_push($this->registros,array("id"=>$id, "nombre"=>$nombre, "usuario_ingresa"=>$usuario_ingresa, "fecha_ingresa"=>$fecha_ingresa));
            }
    
        }

		return $this->registros;

    }

    function grabar($id, $nombre, $descripcion, $usuario_ingresa){
        
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT id FROM cat_tipo_gasto WHERE id=?");
        $consulta->bind_param('i', $id);
        $consulta->execute();
		$consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($idregistro);            

            $consulta = $conexion->prepare("UPDATE cat_tipo_gasto SET nombre='".$nombre."' WHERE id = ?");
            $consulta->bind_param('i',$id);

        }else{

            $consulta = $conexion->prepare("INSERT INTO cat_tipo_gasto (nombre, usuario_ingresa) VALUES( '$nombre', '$usuario_ingresa')");
            
        }
        
		if($consulta->execute()){
            return true;
        }else{
            return false;
        }       

    }

}



?>