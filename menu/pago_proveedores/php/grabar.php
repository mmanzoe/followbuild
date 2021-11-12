<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
$return = Array('ok'=>TRUE);


$idfactura = $_REQUEST['idfactura'];
$formapago = $_REQUEST['formapago'];
$tipo = $_REQUEST['tipo'];
$valor = $_REQUEST['monto'];
$docvalida = $_REQUEST['docvalida'];


if (array_sum($_FILES['file']['size'])>0){
	
	$file = $_FILES["file"];
        $extension = explode(".", $file["name"][0]);
	$ruta = ($_REQUEST['idfactura'].'_'.$_REQUEST['docvalida'].'.'.$extension[1]);

}else{
	
	$ruta = "";
}


$validapago = "SELECT fac_en.total_factura, (SELECT SUM(valor) FROM detalle_pago_proveedor WHERE id_factura='".$idfactura."') as pagado, (fac_en.total_factura - (SELECT SUM(valor) FROM detalle_pago_proveedor WHERE id_factura='".$idfactura."') ) as diferencia FROM factura_proveedor_encabezado as fac_en WHERE fac_en.id ='".$idfactura."'";
$resulpago = mysqli_query($conexion, $validapago);
$fila = mysqli_fetch_assoc($resulpago);

if ($fila['diferencia'] == ''){
    $diferencia = $fila['total_factura'];
}else{
    $diferencia = $fila['diferencia'];
} 

if($valor > $diferencia){
	$return = Array('ok' => FALSE, 'msg' => "El monto ingresado es superior al monto pendiente de pago en la factura! ");
}else{
	
	//VALIDA DOCUMENTO REPETIDO
	$consudocto = "SELECT * FROM detalle_pago_proveedor WHERE id_tipo_pago='".$formapago."' AND id_banco='".$tipo."' AND documento_valida='".$docvalida."' LIMIT 1";
	$resdocto = mysqli_query($conexion, $consudocto);

	if(mysqli_num_rows($resdocto)>0){
		$return = Array('ok' => FALSE, 'msg' => "Documento ya registrado anteriormente");
	}else{

		$insert = "INSERT INTO detalle_pago_proveedor (id_factura, id_tipo_pago, id_banco, documento_valida, archivo_retencion, valor, nombre_ingresa) VALUES('".$idfactura."','".$formapago."','".$tipo."','".$docvalida."', '".$ruta."', '".$valor."','".$_SESSION['datos_logueo']['idusuario']."')";
		$resultados = mysqli_query($conexion, $insert);
		
		cargaimg($idfactura, $docvalida);
		
		if(mysqli_affected_rows($conexion)>0){
			$return = Array('ok' => TRUE, 'msg' => "registro grabado correctamente");
		}else{
			$return = Array('ok' => FALSE, 'msg' => "Error de grabacion");
		}

	}

    
}

/*
$consupago = "SELECT fac_en.total_factura, (SELECT SUM(valor) FROM detalle_pago_proveedor WHERE id_factura='".$idfactura."') as pagado FROM factura_proveedor_encabezado as fac_en WHERE fac_en.id ='".$idfactura."'";
$resultadopagado = mysqli_query($conexion, $consupago);
$row = mysqli_fetch_assoc($resultadopagado);

if($row['total_factura'] == $row['pagado']){
     $update = "UPDATE factura_encabezado SET estado = '1', fecha_pago='".date('Y-m-d H:i:s')."' WHERE id='".$idfactura."'";
	 $resupdatae = mysqli_query($conexion, $update);	
}
*/



function cargaimg($idfactura, $docvalida){
	
	
$carpeta="../RETENCIONES/";
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
	
		$carpeta = "../RETENCIONES/";
	
	    
			
		$extension = explode(".",$nombre);
		
		$origen= $ruta_provisional;
		$destino="../RETENCIONES/".$idfactura.'_'.$docvalida.'.'.$extension[1];
		$destino_temporal=tempnam("tmp/","tmp");
		
		$src = $carpeta.$idfactura.'_'.$docvalida.'.'.$extension[1];

		move_uploaded_file($ruta_provisional, $src);
		$cant = $cant + 1;	

    }
        
}
	
	
}





header('Content-type: application/json; charset=utf-8');
echo json_encode($return);


?>