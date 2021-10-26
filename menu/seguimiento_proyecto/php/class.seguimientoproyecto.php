<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();


class SeguimientoProyecto{
	private $registros = [];
    private $codigo;
    private $nombre;
    private $descripcion;
    
	function __construct(){
		$this->conn = new Conexion();
	}

	function listadoproyecto(){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT cat_proyecto.*,
        (SELECT SUM(total_factura) FROM factura_proveedor_encabezado AS fpe WHERE id_proyecto= cat_proyecto.id) as total_gasto
        FROM cat_proyecto");

        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $id_empresa, $cod_proyecto, $nombre_proyecto, $descripcion, $monto, $id_encargado, $estado, $id_usuario, $fecha_ingresa, $total_gasto);

            while ($consulta->fetch()) {                
				array_push($this->registros,array("id"=>$id, "id_empresa"=>$id_empresa, "cod_proyecto"=>$cod_proyecto, "nombre_proyecto"=>$nombre_proyecto, "descripcion"=>$descripcion, "monto"=>round($monto,2), "estado"=>$estado, "id_usuario"=>$id_usuario, "fecha_ingresa"=>$fecha_ingresa, "total_gasto"=>round($total_gasto,2)));
            }
    
        }

		return $this->registros;

    }

    function listadogastos($id_proyecto){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT dgp.*, ctg.nombre as nombre_gasto, (SELECT SUM(total_factura) FROM factura_proveedor_encabezado as fpe WHERE id_proyecto=dgp.id_proyecto AND id_gasto_proyecto = dgp.id_tipo_gasto) AS total_gasto FROM detalle_gasto_proyecto as dgp 
        INNER JOIN cat_tipo_gasto AS ctg ON (ctg.id = dgp.id_tipo_gasto)
        WHERE dgp.id_proyecto='".$id_proyecto."'");

        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $id_proyecto, $id_tipo_gasto, $monto, $id_usuario, $fecha_ingresa, $nombre_gasto, $total_gasto);

            while ($consulta->fetch()) {                
				array_push($this->registros,array("id"=>$id, "id_proyecto"=>$id_proyecto, "id_tipo_gasto"=>$id_tipo_gasto, "monto"=>round($monto,2), "id_usuario"=>$id_usuario, "fecha_ingresa"=>$fecha_ingresa, "nombre_gasto"=>$nombre_gasto, "total_gasto"=>round($total_gasto,2)));
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