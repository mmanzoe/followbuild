<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conexion.php');
$return = Array('ok'=>TRUE);

$id_pais = $_REQUEST['id_pais'];
$id_depto = $_REQUEST['id_depto'];
$nombre_municipio = strtoupper($_REQUEST['nombre_municipio']);

mysqli_query($conexion, "START TRANSACTION");

$insert = "
INSERT INTO cat_municipio (id_departamento, nombre) 
SELECT '".$id_depto."', '".$nombre_municipio."'
FROM dual WHERE not exists(SELECT * FROM cat_municipio WHERE nombre = '".$nombre_municipio."' AND id_departamento='".$id_depto."')";
$resultados = mysqli_query($conexion, $insert);


if($resultados){
    mysqli_query($conexion, "COMMIT");
    $return = Array('ok' => TRUE, 'msg' => "registro grabado correctamente");
}else{
    mysqli_query($conexion, "ROLLBACK");
    $return = Array('ok' => FALSE, 'msg' => "Error al grabar el municipio, verifique si ya esta ingresado!");
}



header('Content-type: application/json; charset=utf-8');
echo json_encode($return);

?>