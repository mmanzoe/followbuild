<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();


class Proveedor{

	private $ruta = null;
	private $archivo_rtu = null;
	
	
	function __construct($tipo, $archivo, $nit, $tipo_contribuyente, $nombre, $direccion, $tel_proveedor, $dias_credito, $email_proveedor, $contacto, $tel_contacto, $email_contacto, $id){
		$this->conn = new Conexion();
		$this->tipo = $tipo;
		$this->archivo = $archivo;
		$this->nit = $nit;
		$this->tipo_contribuyente = $tipo_contribuyente;
		$this->nombre = $nombre;
		$this->direccion = $direccion;
		$this->tel_proveedor = $tel_proveedor;
		$this->dias_credito = $dias_credito;
		$this->email_proveedor = $email_proveedor;
		$this->contacto = $contacto;
		$this->tel_contacto = $tel_contacto;
		$this->email_contacto = $email_contacto;
		$this->id = $id;

	}

	function altaPtoveedor(){
		
		$archivo = $this->archivo;
		
		if (array_sum($archivo['size'])>0){
		
			$file = $archivo;
			$extension = explode(".", $file["name"][0]);
			$this->archivo_rtu = ($this->nit.'.'.$extension[1]);
			
		}else{
			
			$this->archivo_rtu = "";
		}
		
		$conexion = $this->conn->conectar();

		if($this->tipo == 'create'){
			$consulta = $conexion->prepare("INSERT INTO cat_proveedor (nit, id_tipo_contribuyente, nombre, direccion, tel_proveedor, credito, email_proveedor, archivo_rtu, nombre_contacto, tel_contacto, email_contacto, nombre_ingresa, fecha_ingresa) SELECT '".$this->nit."', '".$this->tipo_contribuyente."', '".$this->nombre."', '".$this->direccion."', '".$this->tel_proveedor."', '".$this->dias_credito."', '".$this->email_proveedor."', '".$this->archivo_rtu."', '".$this->contacto."', '".$this->tel_contacto."', '".$this->email_contacto."', '".$_SESSION['datos_logueo']['idusuario']."', '".date('Y-m-d H:i:s')."' FROM dual WHERE not exists(SELECT * FROM cat_proveedor WHERE nit = '$this->nit')");
		}else if($this->tipo == 'update'){
			$consulta = $conexion->prepare("UPDATE cat_proveedor SET nit='$this->nit', id_tipo_contribuyente='$this->tipo_contribuyente', nombre='$this->nombre', direccion='$this->nombre', tel_proveedor='$this->tel_proveedor', credito='$this->dias_credito', email_proveedor='$this->email_proveedor', archivo_rtu='$this->archivo_rtu', nombre_contacto='$this->contacto', tel_contacto='$this->tel_contacto', email_contacto='$this->email_contacto'  WHERE id = '$this->id'");
			//return "UPDATE cat_proveedor SET nit='$this->nit', id_tipo_contribuyente='$this->tipo_contribuyente', nombre='$this->nombre', direccion='$this->nombre', tel_proveedor='$this->tel_proveedor', credito='$this->dias_credito', email_proveedor='$this->email_proveedor', archivo_rtu='$this->archivo_rtu', nombre_contacto='$this->contacto', tel_contacto='$this->tel_contacto', email_contacto='$this->email_contacto'  WHERE id = '$this->id'";
		}
        
		
		if($consulta->execute()){
			$consulta->store_result();
			return true;
			
		}else{
			return false;
		}
		
		
	}
	

	function cargaImagenRtu(){

		$archivo = $this->archivo;

		$carpeta="../archivo/";
		@mkdir($carpeta, 0777, true);
		@chmod($carpeta, 0777);
		$return = Array('ok'=>TRUE);

		if (isset($archivo)){

			$reporte = null;
	   
			for($x=0; $x<count($archivo["name"]); $x++){
		   
			   $file = $archivo;
		   
			   $nombre = $file["name"][$x];
		   
			   $tipo = $file["type"][$x];
		   
			   $ruta_provisional = $file["tmp_name"][$x];
		   
			   $size = $file["size"][$x];
		   
			   $dimensiones = getimagesize($ruta_provisional);
		   
			   $width = $dimensiones[0];
		   
			   $height = $dimensiones[1];
		   
			   $carpeta = "../archivo/";
		   
			   if($size > 5024*5024){
		   
				   $reporte .= "<p class='bg-danger mensaje'>Error $nombre, el tamaño máximo permitido es 1mb</p>";
				   //$return = Array('ok' => FALSE, 'msg' => "Error $nombre, el tamaño máximo permitido es 1mb");
		   
			   }else if($width > 15000 || $height > 15000){
		   
				   $reporte .= "<p class='bg-danger mensaje'>Error $nombre, la anchura y la altura máxima permitida es de 500px</p>";
		   
			   }else{
				   
				   $extension = explode(".",$nombre);
				   
				   $origen= $ruta_provisional;
				   $destino="../archivo/".$this->nit.'.'.$extension[1];
				   //$destino_temporal=tempnam("tmp/","tmp");
				   
				   $src = $carpeta.$this->nit.'.'.$extension[1];
		   
				   move_uploaded_file($ruta_provisional, $src);
				   
		   
			   }
	   
		   }
			   
	   }

	   return true;

	}
	

}

$proveedor= new Proveedor($_REQUEST['tipo'], $_FILES['file'], $_REQUEST['nit'], $_REQUEST['tipo_contribuyente'], $_REQUEST['nombre'], $_REQUEST['direccion'], $_REQUEST['tel_proveedor'], $_REQUEST['dias_credito'], $_REQUEST['email_proveedor'], $_REQUEST['contacto'], $_REQUEST['tel_contacto'], $_REQUEST['email_contacto'], isset($_REQUEST['idregistro'])?$_REQUEST['idregistro']:null);
$resultado = $proveedor->altaPtoveedor();


if($resultado===true){

	$resultado = $proveedor->cargaImagenRtu();
	if($resultado){
		$result = Array('ok'=>true, 'msg'=>'Proveedor grabado correctamente');
	}else{
		$result = Array('ok'=>'', 'msg'=>'Proveedor grabado, problemas con la carga de imagen');
	}

}else{
	$result = Array('ok'=>false, 'msg'=>'Error al crear el proveedor y/o  proveedor ya registrado');
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($result);

?>