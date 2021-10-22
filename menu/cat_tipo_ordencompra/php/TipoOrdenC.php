<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();


class TipoOrdenCompra{
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
        $consulta = $conexion->prepare("SELECT * FROM cat_tipo_ordencompra");

        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $usuario_ingresa, $fecha_ingresa);

            while ($consulta->fetch()) {
                
				array_push($this->registros,array("id"=>$id, "nombre"=>$nombre, "usuario_ingresa"=>$usuario_ingresa, "fecha_ingresa"=>$fecha_ingresa));
            }
    
        }

		return $this->registros;

    }

    function grabar($id, $nombre, $usuario_ingresa){
        
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT id FROM cat_tipo_ordencompra WHERE id=?");
        $consulta->bind_param('i', $id);
        $consulta->execute();
		$consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($idregistro);            

            $consulta = $conexion->prepare("UPDATE cat_tipo_ordencompra SET nombre='".$nombre."' WHERE id = ?");
            $consulta->bind_param('i',$id);

        }else{

            $consulta = $conexion->prepare("INSERT INTO cat_tipo_ordencompra (nombre, usuario_ingresa) VALUES( '$nombre', '$usuario_ingresa')");
            
        }
        
		if($consulta->execute()){
            return true;
        }else{
            return false;
        }
        

    }

}

$tipoordencompra = new TipoOrdenCompra();

if($_REQUEST['tipo']=='read'){

    $registros = $tipoordencompra->listado();

}else if($_REQUEST['tipo']=='create'){
    
    $registros = $tipoordencompra->grabar($_REQUEST['codigo'], strtoupper($_REQUEST['nombre']), $_SESSION['datos_logueo']['idusuario']);
    
    if($registros===true){
        
        $registros = Array("ok"=>true, "msg"=>"Registro grabado correctamente");
        
    }else{
        $registros = Array("ok"=>false, "msg"=>"Error al grabar el registro ");
    }
     
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>