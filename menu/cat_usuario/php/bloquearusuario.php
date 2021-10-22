<?php
require('../../../php/conexion.php');
$return = Array('ok'=>TRUE);

$idregistro = $_REQUEST['idregistro'];

$update = 'UPDATE usuarios SET habilitado ="0" WHERE id = "'.$idregistro.'"';
$resultados = mysqli_query($conexion, $update);


if(mysqli_affected_rows($conexion)>0){
	$return = Array('ok' => TRUE, 'msg' => "usuario fue bloqueado correctamente!!");
}else{
	$return = Array('ok' => FALSE, 'msg' => "Error al bloquear el usuario!!");
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);
?>