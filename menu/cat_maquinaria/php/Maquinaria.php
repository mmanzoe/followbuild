<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();


class Maquinaria{
	private $registros = [];
    private $tipomaquinaria;
    private $tipoplaca;
    private $placa;
    private $marca;
    private $linea;
    private $modelo;
    private $descripcion;


	function __construct(){
		$this->conn = new Conexion();
	}

	function listado(){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT CM.id, CM.placa, CTP.tipo AS tipo_placa, CTM.Nombre as tipo, CMM.Nombre as marca, CLM.nombre as linea, CM.modelo, CM.descripcion, CM.tipo_placa as id_tipo_placa, CM.tipo as id_tipo, CM.marca as id_marca, CM.linea as id_linea
        FROM cat_maquinaria AS CM
        INNER JOIN cat_tipo_placa AS CTP ON (CTP.id = CM.tipo_placa )
        INNER JOIN cat_tipo_maquinaria AS CTM ON(CTM.id = CM.tipo)
        INNER JOIN cat_marca_maquinaria AS CMM ON (CMM.id = CM.marca)
        INNER JOIN cat_linea_maquinaria AS CLM ON (CLM.id = CM.linea)");

        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $placa, $tipo_placa, $tipo, $marca, $linea, $modelo, $descripcion, $id_tipo_placa, $id_tipo, $id_marca, $id_linea);

            while ($consulta->fetch()) {
                
				array_push($this->registros,array("id"=>$id, "tipo_placa"=>$tipo_placa, "placa"=>$placa, "tipo"=>$tipo, "marca"=>$marca, "linea"=>$linea, "modelo"=>$modelo, "descripcion"=>$descripcion, "id_tipo_placa"=>$id_tipo_placa, "id_tipo"=>$id_tipo, "id_marca"=>$id_marca, "id_linea"=>$id_linea));
            }
    
        }

		return $this->registros;

    }

    function grabar($tipo, $tipomaquinaria, $tipoplaca, $placa, $marca, $linea, $modelo, $descripcion){
        
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT id FROM cat_maquinaria WHERE placa=?");
        $consulta->bind_param('i', $placa);
        $consulta->execute();
		$consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($idregistro);            

            $consulta = $conexion->prepare("UPDATE cat_maquinaria SET tipo_placa='".$tipoplaca."', placa='".$placa."', tipo='".$tipomaquinaria."', marca='".$marca."', linea='".$linea."', modelo='".$modelo."', descripcion='".$descripcion."' WHERE placa='".$placa."' ");
            
        }else{

            $consulta = $conexion->prepare("INSERT INTO cat_maquinaria (tipo_placa, placa, tipo, marca, linea, modelo, descripcion) VALUES( '$tipoplaca', '$placa', '$tipomaquinaria', '$marca', '$linea', '$modelo', '$descripcion')");
            
        }

        
		if($consulta->execute()){
            return true;
        }else{
            return false;
        }
        

    }

}

$maquinaria = new Maquinaria();

if($_REQUEST['tipo']=='read'){

    $registros = $maquinaria->listado();

}else if($_REQUEST['tipo']=='create'){
    
    $registros = $maquinaria->grabar($_REQUEST['tipo'], strtoupper($_REQUEST['tipomaquinaria']), strtoupper($_REQUEST['tipoplaca']), strtoupper($_REQUEST['placa']), $_REQUEST['marca'], $_REQUEST['linea'], strtoupper($_REQUEST['modelo']), strtoupper($_REQUEST['descripcion']));
    
    if($registros===true){
        
        $registros = Array("ok"=>true, "msg"=>"Registro grabado correctamente");
        
    }else{
        $registros = Array("ok"=>false, "msg"=>"Error al grabar el registro ");
    }
     
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>