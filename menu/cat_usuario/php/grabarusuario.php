<?php
require('../../../php/conexion.php');
$return = Array('ok'=>TRUE);

$nombre = strtoupper($_REQUEST['nombre']);
$correo = strtoupper($_REQUEST['correo']);
$usuario = strtoupper($_REQUEST['usuario']);
$password = strtoupper($_REQUEST['password']);

$query = "INSERT INTO usuarios (nombre, departamento, tipo_usuario, email, usuario,  password, habilitado) VALUES('".$nombre."','1','1','".$correo."','".$usuario."','".$password."','1')";
$resultados = mysqli_query($conexion, $query);

if(mysqli_affected_rows($conexion)>0){
	$return = Array('ok' => TRUE, 'msg' => "usuario fue creado correctamente!!");
}else{
	$return = Array('ok' => FALSE, 'msg' => "Error al registrar el usuario");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($return);


?>