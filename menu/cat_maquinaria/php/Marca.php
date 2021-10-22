<?php
require('../../../php/class.conexion.php');
$return = Array();

$con = new Conexion();
$conexion = $con->conectar();

$consulta = $conexion->prepare("SELECT * FROM cat_marca_maquinaria");
$consulta->execute();
$consulta->store_result();

if($consulta->num_rows>0){

    $consulta->bind_result($id, $nombre);

    while($consulta->fetch()){

        array_push($return, ["id"=>$id, "nombre"=>$nombre]);

    }

}

header('Content-type: application/json; charset=utf-8');
echo json_encode($return);

?>