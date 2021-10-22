<?php
require ('../../../php/class.conexion.php');

$permiso = $_REQUEST['permiso'];
$id_acceso = intval($_REQUEST['id_acceso']);
$id_usuario = intval($_REQUEST['id_usuario']);

$resultado = Array("ok"=>true);


$con = new Conexion();
$conexion = $con->conectar();

if($permiso=='add'){
    $consulta = $conexion->prepare("INSERT INTO permiso_usuario (id_usuario, id_sub_modulo, usuario_ingresa) VALUES('".$id_usuario."','".$id_acceso."','1')");
    //$consulta->bind_param('iii', $id_usuario, $id_acceso,1);
}else{
    $consulta = $conexion->prepare("DELETE FROM permiso_usuario WHERE id_usuario=? AND id_sub_modulo=?");
    $consulta->bind_param('ii', $id_usuario, $id_acceso);
}

if($consulta->execute()){
    $resultado = Array("ok"=>true, "msg"=>"Actualizacion correcta");
}else{
    $resultado = Array("ok"=>false, "msg"=>"Error al realizar la actualizacion");
}


//$resultado = Array("ok"=>false, "permiso"=>$permiso, "id_acceso"=>$id_acceso, "id_usuario"=>$id_usuario);
header('Content-type: application/json; charset=utf-8');
echo json_encode($resultado);

?>