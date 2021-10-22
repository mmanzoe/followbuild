<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();


class Producto{
	private $registros = [];
    
	function __construct(){
		$this->conn = new Conexion();
	}

	function listado(){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT cat_producto.*, cat_medida.nombre as nombre_medida FROM cat_producto INNER JOIN cat_medida ON (cat_medida.id = cat_producto.id_medida)");

        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $codigo, $nombre, $descripcion, $precio, $id_medida, $usuario_ingresa, $fecha_ingresa, $nombre_medida);

            while ($consulta->fetch()) {
                
				array_push($this->registros,array("id"=>$id, "codigo"=>$codigo, "nombre"=>$nombre, "descripcion"=>$descripcion, "precio"=>$precio, "id_medida"=>$id_medida, "usuario_ingresa"=>$usuario_ingresa, "fecha_ingresa"=>$fecha_ingresa, "nombre_medida"=>$nombre_medida));
            }
    
        }

		return $this->registros;

    }

    function grabar($codigo, $nombre, $descripcion, $precio, $usuario_ingresa){
        
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT id FROM cat_producto WHERE codigo_producto=?");
        $consulta->bind_param('i', $codigo);
        $consulta->execute();
		$consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($idregistro);            

            $consulta = $conexion->prepare("UPDATE cat_producto SET nombre='".$nombre."', descripcion='".$descripcion."', precio='".$precio."', usuario_ingresa='".$usuario_ingresa."' WHERE codigo_producto = ?");
            $consulta->bind_param('i',$codigo);

        }else{

            $consulta = $conexion->prepare("INSERT INTO cat_producto (codigo_producto, nombre, descripcion, precio, id_medida, usuario_ingresa) VALUES( '$codigo', '$nombre', '$descripcion', '$precio', '1', '$usuario_ingresa')");
            
        }
        
		if($consulta->execute()){
            return true;
        }else{
            return false;
        }
        

    }

}

?>