<?php
require('../../../php/conexion.php');
header('Content-type: application/json; charset=utf-8');
$return = Array('ok'=>'TRUE');


$idregistro = $_REQUEST['idregistro'];
$permiso = $_REQUEST['permiso'];


$consu = "SELECT * FROM usuario_permiso WHERE id_usuario = '".$idregistro."' AND id_permiso='".$permiso."' LIMIT 1";
$resulconsu = mysqli_query($conexion, $consu);


if(mysqli_num_rows($resulconsu)>0){
	$return = Array('ok' => 'EXISTE', 'msg' => "permiso asignado anteriormente al usuario!!");
	echo json_encode($return);
	die();
}



$insert = "INSERT INTO usuario_permiso(id_usuario, id_permiso) VALUES('".$idregistro."','".$permiso."')";
$resultados = mysqli_query($conexion, $insert);


if(mysqli_affected_rows($conexion)>0){
	$return = Array('ok' => 'TRUE', 'msg' => "permiso asignado correctamente!!");
}else{
	$return = Array('ok' => 'FALSE', 'msg' => "Error al asignar permiso!!");
}



echo json_encode($return);
?>