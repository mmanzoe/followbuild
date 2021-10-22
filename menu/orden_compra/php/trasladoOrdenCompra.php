<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$eliminaArray = 'false';
$return = Array('ok'=>TRUE);
$moneda = $_REQUEST['moneda'];
$cambio_moneda = $_REQUEST['cambio_moneda'];
$proyecto = $_REQUEST['proyecto'];
$tipo_gasto = $_REQUEST['tipo_gasto'];
$total_orden = 0;


mysqli_query($conexion, "START TRANSACTION");

$insertenc = "INSERT INTO orden_compra_encabezado (cod_proveedor, tipo_orden, moneda, cambio_moneda, tipo_pago, id_proyecto, id_gasto_proyecto, observaciones, id_usuario_ingresa) VALUES('".$_SESSION['productos'][0][0]."','".$_SESSION['productos'][0][7]."','".$moneda."','".$cambio_moneda."','".$_SESSION['productos'][0][6]."','".$proyecto."','".$tipo_gasto."','".$_SESSION['productos'][0][8]."','".$_SESSION['datos_logueo']['idusuario']."')";
$resinsertenc = mysqli_query($conexion, $insertenc);
$id = mysqli_insert_id($conexion);

$insertocd = "INSERT INTO orden_compra_detalle (id_orden_compra, cod_producto, cantidad, valor) VALUES ";

if(!empty($_SESSION['productos']) ){
	
	for($n=0; $n<count($_SESSION['productos']); $n++){
	
	    $insertocd = $insertocd." ('".$id."','".$_SESSION['productos'][$n][1]."','".$_SESSION['productos'][$n][4]."','".$_SESSION['productos'][$n][3]."'),";
		$total_orden = $total_orden + ($_SESSION['productos'][$n][4] * $_SESSION['productos'][$n][3]);
		    
    }
	
}

$insertocd = rtrim($insertocd, ",");
$reulinsertDetalle = mysqli_query($conexion, $insertocd);

$update = "UPDATE orden_compra_encabezado SET total_ordencompra = '".$total_orden."' WHERE id='".$id."'";
$resupdate = mysqli_query($conexion, $update);


if($resinsertenc && $reulinsertDetalle && $resupdate){
	
	unset($_SESSION['productos']);
	
	if(!isset($_SESSION['productos'])){
	  $_SESSION['productos'] = array();
        }
	
        mysqli_query($conexion, "COMMIT");
	$return = Array('ok' => TRUE, 'msg' => "Orden de compra grabada correctamente!!");
	
}else{
        mysqli_query($conexion, "ROLLBACK");
	$return = Array('ok' => FALSE, 'msg' => "Error al registrar la orden de compra!! ".$insertocd);
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);



?>