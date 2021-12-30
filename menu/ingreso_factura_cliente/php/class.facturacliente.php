<?php
session_start();
require('../../../php/class.conexion.php');
$return = Array();

class Factura{
	private $registros = [];
    
	function __construct(){
		$this->conn = new Conexion();
	}

	function listado(){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT fce.*, usuario.nombre as nombre_usuario FROM factura_cliente_encabezado AS fce INNER JOIN usuario ON(usuario.id = fce.id_usuario_ingresa)");

        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $id_cliente, $serie, $factura, $fecha_factura, $monto, $credito, $estado, $id_usuario_ingresa, $fecha_ingresa, $nombre_usuario);

            while ($consulta->fetch()) {
                
				array_push($this->registros,array("id"=>$id, "id_cliente"=>$id_cliente, "serie"=>$serie, "factura"=>$factura, "fecha_factura"=>$fecha_factura, "monto"=>$monto, "id_usuario_ingresa"=>$id_usuario_ingresa, "fecha_ingresa"=>$fecha_ingresa, "nombre_usuario"=>$nombre_usuario ));
            }
    
        }

		return $this->registros;

    }

    function grabar($id_proyecto, $serie_factura, $no_factura, $fecha_factura, $monto, $id_cliente){
        
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT * FROM factura_cliente_encabezado WHERE serie=? AND factura=?");
        $consulta->bind_param('ss', $serie_factura, $no_factura);
        //$consulta->bind_param('s', $no_factura);
        $consulta->execute();
		$consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($idregistro);            

            //$consulta = $conexion->prepare("UPDATE cat_producto SET nombre='".$nombre."', descripcion='".$descripcion."', precio='".$precio."', usuario_ingresa='".$usuario_ingresa."' WHERE codigo_producto = ?");
            //$consulta->bind_param('i',$codigo);

        }else{

            $consulta = $conexion->prepare("INSERT INTO factura_cliente_encabezado (id_cliente, serie, factura, fecha_factura, monto, id_usuario_ingresa) VALUES('".$id_cliente."','".$serie_factura."','".$no_factura."','".$fecha_factura."','".$monto."','".$_SESSION['datos_logueo']['idusuario']."')");
            $consulta->execute();
            $consulta = $conexion->prepare(  "INSERT INTO factura_cliente_detalle (id_factura, id_proyecto, monto) VALUES('".$conexion->insert_id."','".$id_proyecto."','".$monto."')" );
        }
        
		if($consulta->execute()){
            return Array("ok"=>true, "msg"=>"Registro grabado correctamente!");
        }else{
            return Array("ok"=>false, "msg"=>"Error de grabacion...");;
        }
        

    }

}


?>