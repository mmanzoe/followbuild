<?php
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();

class TipoContribuyente{

	private $tipocontribuyente = [];

	function __construct(){
        $this->conn = new Conexion();
    }

	function listaTipoContribuyente(){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT * FROM cat_tipo_contribuyente");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $impuesto);

            while ($consulta->fetch()) {
                //crear array()
				array_push($this->tipocontribuyente,array("id"=>$id, "nombre"=>$nombre, "impuesto"=>$impuesto));
            }
    
        }

		return $this->tipocontribuyente;

    }

}


$tipocontribuyente= new TipoContribuyente();
$registros = $tipocontribuyente->listaTipoContribuyente();

header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>