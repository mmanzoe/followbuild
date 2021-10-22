<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conexion.php');

$return = Array('ok'=>TRUE);

$proveedor = $_REQUEST['proveedor'];
$tipo_factura = $_REQUEST['tipo_factura'];
$ordencompra = $_REQUEST['ordencompra'];
$producto = $_REQUEST['mpep'];
$des_sm = $_REQUEST['des_sm'];
$des_sr = $_REQUEST['des_sr'];
$des_af = $_REQUEST['des_af'];

$consulta = "SELECT * FROM orden_compra_encabezado WHERE id = '".$ordencompra."' AND estado = '1' AND cod_proveedor = '".$proveedor."' LIMIT 1";
$resultados = mysqli_query($conexion, $consulta);

if(mysqli_num_rows($resultados)>0){
	
	if($tipo_factura == 'MP'){
		$query = "SELECT * FROM orden_compra_detalle WHERE cod_producto = '".$producto."' AND id_orden_compra='".$ordencompra."' LIMIT 1";
	}else if($tipo_factura == 'EP'){ 
	    $query = "SELECT * FROM orden_compra_detalle WHERE cod_producto = '".$producto."' AND id_orden_compra='".$ordencompra."' LIMIT 1";
	}else if($tipo_factura == 'SM'){
		$query = "SELECT * FROM orden_compra_detalle_sm WHERE descripcion = '".$des_sm."' AND id_orden_compra='".$ordencompra."' LIMIT 1";
	}else if($tipo_factura == 'SR'){
		$query = "SELECT * FROM orden_compra_detalle_sr WHERE descripcion = '".$des_sr."' AND id_orden_compra='".$ordencompra."' LIMIT 1";
	}else if($tipo_factura == 'AF'){
		$query = "SELECT * FROM orden_compra_detalle_af WHERE descripcion = '".$des_af."' AND id_orden_compra='".$ordencompra."' LIMIT 1";	
	}
	
	$resquery = mysqli_query($conexion, $query);
	
	if(mysqli_num_rows($resquery)>0){
		$fila = mysqli_fetch_assoc($resquery);
		$return = Array('ok' => TRUE, 'msg' => "Orden de compra validada", 'valor' => $fila['cantidad']);
	}else{
		$return = Array('ok' => FALSE, 'msg' => "Producto no solicitado en orden de compra");
	}
	
}else{
	$return = Array('ok' => FALSE, 'msg' => "Numero de orden no existe, no esta autorizada y/o proveedor no valido!");
}



header('Content-type: application/json; charset=utf-8');
echo json_encode($return);



?>