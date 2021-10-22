<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conexion.php');
$return = Array('ok'=>TRUE);


$nit = $_REQUEST['nit'];
$tipo_contribuyente = $_REQUEST['tipo_contribuyente'];
$nombre = strtoupper($_REQUEST['nombre']);
$direccion = strtoupper($_REQUEST['direccion']);
$tel_proveedor = $_REQUEST['tel_proveedor'];
$dias_credito = $_REQUEST['dias_credito'];
$email_proveedor = $_REQUEST['email_proveedor'];
$contacto = strtoupper($_REQUEST['contacto']);
$tel_contacto = $_REQUEST['tel_contacto'];
$email_contacto = $_REQUEST['email_contacto'];

if (array_sum($_FILES['file']['size'])>0){
	
	$file = $_FILES["file"];
        $extension = explode(".", $file["name"][0]);
	$ruta = ($_REQUEST['nit'].'.'.$extension[1]);
	
	$update = "UPDATE proveedor SET id_tipo_contribuyente='".$tipo_contribuyente."', nombre='".$nombre."', direccion='".$direccion."', tel_proveedor='".$tel_proveedor."', credito='".$dias_credito."', email_proveedor='".$email_proveedor."', archivo_rtu ='".$ruta."', nombre_contacto='".$contacto."', tel_contacto='".$tel_contacto."', email_contacto='".$email_contacto."', nombre_ingresa='".$_SESSION['nombre']."', fecha_ingresa='".date('Y-m-d H:i:s')."' WHERE nit='".$nit."'";
	
	
}else{
	
	$update = "UPDATE proveedor SET id_tipo_contribuyente='".$tipo_contribuyente."', nombre='".$nombre."', direccion='".$direccion."', tel_proveedor='".$tel_proveedor."', credito='".$dias_credito."', email_proveedor='".$email_proveedor."', nombre_contacto='".$contacto."', tel_contacto='".$tel_contacto."', email_contacto='".$email_contacto."', nombre_ingresa='".$_SESSION['nombre']."', fecha_ingresa='".date('Y-m-d H:i:s')."' WHERE nit='".$nit."'";


}



$resultados = mysqli_query($conexion, $update);


if(mysqli_affected_rows($conexion)>0){
	$return = Array('ok' => TRUE, 'msg' => "registro actulizado correctamente");
    cargaimg($nit);
}else{
	$return = Array('ok' => FALSE, 'msg' => "Error de actualizacion");
}



function cargaimg($nit){
	
	
$carpeta="../archivo/";
@mkdir($carpeta, 0777, true);
@chmod($carpeta, 0777);
$return = Array('ok'=>TRUE);

$cant = 0;

if (isset($_FILES["file"]) && array_sum($_FILES['file']['size'])>0){

     $reporte = null;

     for($x=0; $x<count($_FILES["file"]["name"]); $x++){
	
		$file = $_FILES["file"];
	
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
			$destino="../archivo/".$nit.'.'.$extension[1];
			$destino_temporal=tempnam("tmp/","tmp");
			
			$src = $carpeta.$nit.'.'.$extension[1];
	
			move_uploaded_file($ruta_provisional, $src);
			$cant = $cant + 1;
			
	
		}

    }
        
}
	
	
}





header('Content-type: application/json; charset=utf-8');
echo json_encode($return);

?>