<?php
session_start();
require('../../../php/conect.php');
header('Content-type: application/json; charset=utf-8');

$cambio_moneda = $_REQUEST['cambio_moneda'];
$proveedor = $_REQUEST['proveedor'];
$observacion = $_REQUEST['observacion'];

$descripcion = $_REQUEST['des_sr'];
$valor_sm = $_REQUEST['valor_sr'];

$forma_pago = $_REQUEST['forma_pago'];
$tipo_solicitud = $_REQUEST['tipo_solicitud'];

if(!isset($_SESSION['productos'])){
	$_SESSION['productos'] = array();
}

$return = Array('ok'=>TRUE);

$articulos = array();	
$articulos[0] = $proveedor;
$articulos[1] = $descripcion;
$articulos[2] = ($valor_sm/$cambio_moneda);
$articulos[3] = $forma_pago;
$articulos[4] = $tipo_solicitud;
$articulos[5] = $observacion;

$agregar = 'true';

for($n=0; $n<count($_SESSION['productos']);$n++){
	if($_SESSION['productos'][$n][1] == $descripcion){
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