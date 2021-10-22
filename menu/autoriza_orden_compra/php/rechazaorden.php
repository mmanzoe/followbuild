<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
$return = Array('ok'=>TRUE);

$idregistro = $_REQUEST['idregistro'];

$update = "UPDATE orden_compra_encabezado SET estado = '3', nombre_autoriza='".$_SESSION['datos_logueo']['idusuario']."', fecha_autoriza='".date('Y-m-d H:i:s')."' WHERE id ='".$idregistro."'";
$resultado = mysqli_query($conexion, $update);


if(mysqli_affected_rows($conexion)>0){
	$return = Array('ok' => TRUE, 'msg' => "registro rechazado correctamente");
}else{
	$return = Array('ok' => FALSE, 'msg' => "Error de rechazo de registro");
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);

?>