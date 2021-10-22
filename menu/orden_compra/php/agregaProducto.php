<?php
session_start();
header('Content-type: application/json; charset=utf-8');

$cambio_moneda = $_REQUEST['cambio_moneda'];
$proveedor = $_REQUEST['proveedor'];
$observacion = $_REQUEST['observacion'];
$material = $_REQUEST['codigo_material'];
$descripcionmpep = $_REQUEST['descripcionmpep'];
$precio = $_REQUEST['precio'];
$cantidad = $_REQUEST['cantidad'];
$forma_pago = $_REQUEST['forma_pago'];
$tipo_solicitud = $_REQUEST['tipo_solicitud'];
$return = Array('ok'=>TRUE);
$agregar = 'true';


if(!isset($_SESSION['productos'])){
	$_SESSION['productos'] = array();
}


$articulos = array();	
$articulos[0] = $proveedor;
$articulos[1] = $material;
$articulos[2] = $descripcionmpep;
$articulos[3] = ($precio/$cambio_moneda);
$articulos[4] = $cantidad;
$articulos[5] = ($articulos[3]) * $cantidad;
$articulos[6] = $forma_pago;
$articulos[7] = $tipo_solicitud;
$articulos[8] = $observacion;


for($n=0; $n<count($_SESSION['productos']);$n++){
	if($_SESSION['productos'][$n][1] == $material){
		$agregar = 'false';			
	}
}


if($agregar == 'true'){
	array_push($_SESSION['productos'], $articulos);
	$return = Array('ok' => TRUE, 'msg' => "articulo agregado!!");
}

if($agregar == 'false'){
	$return = Array('ok' => FALSE, 'msg' => "articulo ya agregado en la lista!!");
}


echo json_encode($return);


?>