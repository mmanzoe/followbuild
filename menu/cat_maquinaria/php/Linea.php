<?php
require('../../../php/class.conexion.php');
$return = Array();

$con = new Conexion();
$conexion = $con->conectar();
$consulta = $conexion->query("SET NAMES 'utf8'");
$consulta = $conexion->prepare("SELECT * FROM cat_linea_maquinaria WHERE id_marca_maquinaria = ? ");
$consulta->bind_param('i', $_REQUEST['marca']);
$consulta->execute();
$consulta->store_result();

if($consulta->num_rows>0){

    $consulta->bind_result($id, $id_marca_maquinaria, $nombre);

    while($consulta->fetch()){

        array_push($return, ["id"=>$id, "nombre"=>$nombre]);

    }

}


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);

?>