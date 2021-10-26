<?php
session_start();
date_default_timezone_set('America/Guatemala');
header('Content-Type: text/html; charset=UTF-8');
require('../../../php/class.conexion.php');
$return = Array();


class FaseProyecto{

	private $registros = [];
    private $codigo;
    private $nombre;
    private $descripcion;
    
	function __construct(){
		$this->conn = new Conexion();
	}

	function listado(){

       
        $conexion = $this->conn->conectar();
        $consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT * FROM cat_fase_proyecto");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $descripcion, $usuario_ingresa, $fecha_ingresa);

            while ($consulta->fetch()) {
                
				array_push($this->registros,array("id"=>$id, "nombre"=>$nombre, "descripcion"=>$descripcion, "usuario_ingresa"=>$usuario_ingresa, "fecha_ingresa"=>$fecha_ingresa));
            }
    
        }

		return $this->registros;

    }

    function grabar($id, $nombre, $descripcion, $usuario_ingresa){
        
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT id FROM cat_fase_proyecto WHERE id=?");
        $consulta->bind_param('i', $id);
        $consulta->execute();
		$consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($idregistro);            

            $consulta = $conexion->prepare("UPDATE cat_fase_proyecto SET nombre='".$nombre."', descripcion='".$descripcion."' WHERE id = ?");
            $consulta->bind_param('i',$id);

        }else{

            $consulta = $conexion->prepare("INSERT INTO cat_fase_proyecto (nombre, descripcion, usuario_ingresa) VALUES( '$nombre', '$descripcion', '$usuario_ingresa')");
            
        }
        
		if($consulta->execute()){
            return true;
        }else{
            return false;
        }       

    }

}




?>