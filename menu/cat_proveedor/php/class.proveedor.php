<?php
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');


class Proveedor{

	private $proveedor = [];

	function __construct(){
        $this->conn = new Conexion();
    }

	function listaProveedor(){
        $return = Array();
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT cat_proveedor.*, tc.nombre as nombre_tipo_contribuyente FROM cat_proveedor INNER JOIN cat_tipo_contribuyente as tc ON(tc.id = cat_proveedor.id_tipo_contribuyente)");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $nit, $id_tipo_contribuyente, $nombre, $direccion, $tel_proveedor, $credito, $email_proveedor, $archivo_rtu, $nombre_contacto, $tel_contacto, $email_contacto, $nombre_ingresa, $fecha_ingresa, $nombre_tipo_contribuyente);

            while ($consulta->fetch()) {
                //crear array()
				array_push($this->proveedor,array("id"=>$id,"nit"=>$nit,"nombre"=>$nombre, "direccion"=>$direccion,"contribuyente"=>$nombre_tipo_contribuyente, "credito"=>$credito, "rtu"=>$archivo_rtu, "tel_proveedor"=>$tel_proveedor, "email_proveedor"=>$email_proveedor, "contacto"=>$nombre_contacto, "tel_contacto"=>$tel_contacto, "email_contacto"=>$email_contacto));
            }
    
        }

		return $this->proveedor;

    }

}

?>