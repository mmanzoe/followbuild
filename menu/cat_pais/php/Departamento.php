<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();


class Departamento{
    private $departamento = [];

    function __construct(){
		$this->conn = new Conexion();
	}

    function listaDepartamento($id_pais){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT * FROM cat_departamento WHERE id_pais='".$id_pais."' ORDER BY nombre ASC");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $idpais);

            while ($consulta->fetch()) {
                //crear array()
				array_push($this->departamento,array("id"=>$id,"nombre"=>$nombre, "id_pais"=>$idpais));
            }
    
        }

		return $this->departamento;

    }


}


$departamento = new Departamento();

if($_REQUEST['tipo']=='read'){
	$registros = $departamento->listaDepartamento($_REQUEST['id_pais']);
}else if($_REQUEST['tipo']=='create'){
	$registros = $departamento->grabaDepartamento( isset($_REQUEST['id'])?$_REQUEST['id']:null, strtoupper($_REQUEST['nombre_pais']));

	
	if($registros){
		$registros = Array('ok'=>true, 'msg'=>'Registro grabado correctamente');
	}else{
		$registros = Array('ok'=>false, 'msg'=>'Error al grabar el registro');
	}
	
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);


?>