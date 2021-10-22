<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();

class Pais{

	private $pais = [];

	function __construct(){
        $this->conn = new Conexion();
    }

	function listaPais(){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT cat_pais.id, cat_pais.nombre, usuario.nombre as nombre_ingresa FROM cat_pais INNER JOIN usuario ON(usuario.id = cat_pais.usuario_ingresa) ORDER BY cat_pais.nombre desc");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $nombre_ingresa);

            while ($consulta->fetch()) {
                //crear array()
				array_push($this->pais,array("id"=>$id,"nombre"=>$nombre));
            }
    
        }

		return $this->pais;

    }

	function grabaPais($id, $nombre){

		$conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT * FROM cat_pais WHERE id='".$id."'");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){

            $consulta = $conexion->prepare("UPDATE cat_pais SET nombre = '".$nombre."' WHERE id='".$id."'");
        	
        }else{

			$consulta = $conexion->prepare("INSERT INTO cat_pais(nombre, usuario_ingresa) VALUES('".$nombre."','".$_SESSION['datos_logueo']['idusuario']."')");
			//return "INSERT INTO cat_pais(nombre) VALUES('".$nombre."')";
		}

		
		if($consulta->execute()){
			return true;
		}else{
			return false;
		}
		
	}

}

$pais = new Pais();

if($_REQUEST['tipo']=='read'){
	$registros = $pais->listaPais();
}else if($_REQUEST['tipo']=='create'){
	$registros = $pais->grabaPais( isset($_REQUEST['id'])?$_REQUEST['id']:null, strtoupper($_REQUEST['nombre_pais']));

	
	if($registros){
		$registros = Array('ok'=>true, 'msg'=>'Registro grabado correctamente');
	}else{
		$registros = Array('ok'=>false, 'msg'=>'Error al grabar el registro');
	}
	
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);



?>