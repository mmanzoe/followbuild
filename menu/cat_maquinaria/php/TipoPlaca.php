<?php
require('../../../php/class.conexion.php');
$return = Array();

$con = new Conexion();
$conexion = $con->conectar();
$consulta = $conexion->query("SET NAMES 'utf8'");
$consulta = $conexion->prepare("SELECT * FROM cat_tipo_placa");
$consulta->execute();
$consulta->store_result();

if($consulta->num_rows>0){

    $consulta->bind_result($id, $tipo, $descripcion);

    while($consulta->fetch()){

        array_push($return, ["id"=>$id, "tipo"=>$tipo, "descripcion"=>$descripcion]);

    }

}

header('Content-type: application/json; charset=utf-8');
echo json_encode($return);

?>