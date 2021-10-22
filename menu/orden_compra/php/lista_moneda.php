<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();

class Moneda{

    function __construct(){
		$this->conn = new Conexion();
	}
   
    function listaMoneda(){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT * FROM cat_moneda ORDER BY nombre ASC");
        $consulta->execute();
		$consulta->store_result();
        $moneda = '';

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $simbolo);

            while ($consulta->fetch()) {
                
                if($fid =='1'){
                    echo '<option value="'.$id.'" simbolo="'.$simbolo.'" selected>'.$nombre.'</option>';
                }else{
                    echo '<option value="'.$id.'" simbolo="'.$simbolo.'">'.$nombre.'</option>';
                }
				//array_push($this->departamento,array("id"=>$id,"nombre"=>$nombre, "id_pais"=>$idpais));
            }
    
        }

		return $moneda;

    }
}


$moneda = new Moneda();
$registros = $moneda->listaMoneda();
echo $registro;

?>