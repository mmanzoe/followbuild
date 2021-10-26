<?php

date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
require('class.pdfproyecto.php');
$return = Array();

class Proyecto{
   
    private $id_asignado;
	private $registros = [];
    private $empresa;
    private $cod_proyecto;
    private $nom_empresa;
    private $descripcion;
    private $monto;
    
	function __construct(){
		$this->conn = new Conexion();
	}

	function listado($estado){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT cat_proyecto.*, cat_empresa.nombre as nombre_empresa, usuario.nombre as nombre_encargado FROM cat_proyecto INNER JOIN cat_empresa ON (cat_empresa.id_empresa = cat_proyecto.id_empresa) INNER JOIN usuario ON (usuario.id = cat_proyecto.id_encargado) WHERE cat_proyecto.estado = '".$estado."' ORDER BY id DESC");

        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $id_empresa, $cod_proyecto, $nombre_proyecto, $descripcion, $monto, $encargado, $estado, $id_usuario, $fecha_ingresa, $nombre_empresa, $nombre_encargado);

            while ($consulta->fetch()) {    
				array_push($this->registros,array("id"=>$id, "id_empresa"=>$id_empresa, "cod_proyecto"=>$cod_proyecto, "nombre_proyecto"=>$nombre_proyecto, "descripcion"=>$descripcion, "monto"=>$monto, "nombre_encargado"=>$nombre_encargado, "id_usuario"=>$id_usuario, "fecha_ingresa"=>$fecha_ingresa, "nombre_empresa"=>$nombre_empresa));
            }
    
        }

		return $this->registros;

    }

    function grabar($id, $id_empresa, $cod_proyecto, $nombre_proyecto, $descripcion, $monto, $encargado, $fases, $gastos, $id_usuario){
        
        $conexion = $this->conn->conectar();
        $consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT id FROM cat_proyecto WHERE cod_proyecto=?");
        $consulta->bind_param('s', $cod_proyecto);
        $consulta->execute();
		$consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($idregistro);            

        }else{

            $consulta = $conexion->prepare("INSERT INTO cat_proyecto (id_empresa, cod_proyecto, nombre_proyecto, descripcion, monto, id_encargado, id_usuario) VALUES('$id_empresa', '$cod_proyecto', '$nombre_proyecto', '$descripcion', '$monto', '$encargado', '$id_usuario')");
            
        }
        
		if($consulta->execute()){
            $this->id_asignado = $conexion->insert_id;
            return true;
            
        }else{
            return false;
        }       

    }

    function cierre_proyecto($id_proyecto){
        
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("UPDATE cat_proyecto set estado = 2 WHERE id=?");
        $consulta->bind_param('i', $id_proyecto);
        
		if($consulta->execute()){
            return true;
        }else{
            return false;
        }       

    }

    function grabarfases($fases){
        $conexion = $this->conn->conectar();

        for($n=0; $n<count($fases); $n++){
            $consulta = $conexion->prepare("INSERT INTO detalle_fase_proyecto(id_proyecto, id_fase, fecha_inicio, fecha_final) VALUES('".$this->id_asignado."','".$fases[$n]['id_fase']."','".$fases[$n]['fecha_inicial']."','".$fases[$n]['fecha_final']."')");
            $consulta->execute();
        }

    }

    function grabargastos($gastos, $id_susario){
        $conexion = $this->conn->conectar();

        for($n=0; $n<count($gastos); $n++){
            $consulta = $conexion->prepare("INSERT INTO detalle_gasto_proyecto(id_proyecto, id_tipo_gasto, monto, id_usuario) VALUES('".$this->id_asignado."','".$gastos[$n]['id_gasto']."','".$gastos[$n]['monto']."','".$id_susario."')");
            $consulta->execute();
        }
    }

    function enviopdf($empresa, $cod_proyecto, $nom_proyecto, $descripcion, $monto, $encargado, $fases, $gastos){
        
        $enviopdf = new EnviaPdfProyecto($empresa, $cod_proyecto, $nom_proyecto, $descripcion, $monto, $encargado, $fases, $gastos);
        $enviopdf->enviapdfproyecto();

    }

    function listafasesproyecto($id_proyecto){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT dfp.*, cfp.nombre FROM detalle_fase_proyecto AS dfp INNER JOIN cat_fase_proyecto AS cfp ON(cfp.id = dfp.id_fase) WHERE id_proyecto='".$id_proyecto."'");
        $consulta->execute();
		$consulta->store_result();

        $fasesproyecto = Array(); 

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $id_proyecto, $id_fase, $fecha_inicio, $fecha_final, $nombre);

            while ($consulta->fetch()) {    
				array_push($fasesproyecto,Array("id"=>$id, "start_date"=>$fecha_inicio, "end_date"=>$fecha_final, "text"=>$nombre));
            }
    
        }

		return $fasesproyecto;

    }

    function listagastosproyecto($id_proyecto){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT dgp.*, ctg.nombre FROM detalle_gasto_proyecto AS dgp INNER JOIN cat_tipo_gasto AS ctg ON(ctg.id = dgp.id_tipo_gasto) WHERE id_proyecto='".$id_proyecto."'");
        $consulta->execute();
		$consulta->store_result();

        $gastosproyecto = Array(); 

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $id_proyecto, $id_tipo_gasto, $monto, $id_usuario, $fecha_ingresa, $nombre);

            while ($consulta->fetch()) {    
				array_push($gastosproyecto,Array("id"=>$id, "id_proyecto"=>$id_proyecto, "id_tipo_gasto"=>$id_tipo_gasto, "monto"=>$monto, "id_usuario"=>$id_usuario, "nombre"=>$nombre));
            }
    
        }

		return $gastosproyecto;

    }


}



?>