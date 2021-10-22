<?php
require('../../../php/conexion.php');
header('Content-type: application/json; charset=utf-8');
$return = Array('ok'=>TRUE);


$idregistro = $_REQUEST['idregistro'];

$delete = "DELETE FROM usuario_permiso WHERE id='".$idregistro."'";
$resultados = mysqli_query($conexion, $delete);


if(mysqli_affected_rows($conexion)>0){
	$return = Array('ok' => TRUE, 'msg' => "permiso retirado correctamente!!");
}else{
	$return = Array('ok' => FALSE, 'msg' => "Error al asignar permiso!!");
}



echo json_encode($return);
?>