<?php
require('../../php/class.conexion.php');
$return = Array();


class Dashboard{

    private $registros = [];

    function __construct(){
		$this->conn = new Conexion();
	}

    function proyectoActivo(){
        $conexion = $this->conn->conectar();
		$consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT COUNT(*) AS TOTAL FROM cat_proyecto WHERE estado = '1'");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($cantidad);

            while ($consulta->fetch()) {
				array_push($this->registros,array( "cantidad"=>$cantidad ));
            }
    
        }

		return $this->registros;

    }

    function facturaPago(){
        
        $conexion = $this->conn->conectar();
		$consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT COUNT(*) AS TOTAL FROM factura_proveedor_encabezado WHERE estado ='1'");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($cantidad);

            while ($consulta->fetch()) {
				array_push($this->registros,array( "cantidad"=>$cantidad ));
            }
    
        }

		return $this->registros;
    }

    function facturaCobro(){
        
        $conexion = $this->conn->conectar();
		$consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT COUNT(*) AS TOTAL FROM factura_cliente_encabezado WHERE estado ='1'");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($cantidad);

            while ($consulta->fetch()) {
				array_push($this->registros,array( "cantidad"=>$cantidad ));
            }
    
        }

		return $this->registros;
    }

    function proyectoVencimiento(){

        $conexion = $this->conn->conectar();
		$consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT COUNT(*) AS TOTAL FROM cat_proyecto WHERE id IN (SELECT id_proyecto FROM detalle_fase_proyecto WHERE MONTH(fecha_final) = MONTH(NOW()) GROUP BY id_proyecto)");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($cantidad);

            while ($consulta->fetch()) {
				array_push($this->registros,array( "cantidad"=>$cantidad ));
            }
    
        }

		return $this->registros;

    }

    function ordenCompraPendienteValidacion(){

        $conexion = $this->conn->conectar();
		$consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT COUNT(*) AS TOTAL FROM orden_compra_encabezado WHERE estado = '1'");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($cantidad);

            while ($consulta->fetch()) {
				array_push($this->registros,array( "cantidad"=>$cantidad ));
            }
    
        }

		return $this->registros;

    }

}





?>