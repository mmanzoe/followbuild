<?php
require ('../../../php/class.conexion.php');

$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
$correo = $_REQUEST['correo'];
$area = $_REQUEST['area'];
$contrasena = password_hash($_REQUEST['contrasena'], PASSWORD_DEFAULT);
$resultado = Array("ok"=>true);

$con = new Conexion();
$conexion = $con->conectar();
$consulta = $conexion->prepare("UPDATE usuario SET nombre=?, correo=?, tipo=?, contrasena=? WHERE id=?");
$consulta->bind_param('sssss', $nombre, $correo, $area, $contrasena, $id);

if($consulta->execute()){
    $resultado = Array("ok"=>true, "msg"=>"Actualizacion correcta");
}else{
    $resultado = Array("ok"=>false, "msg"=>"Error al realizar la actualizacion");
}


$consulta->close();


header('Content-type: application/json; charset=utf-8');

echo json_encode($resultado);


?>