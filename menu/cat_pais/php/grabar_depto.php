<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conexion.php');
$return = Array('ok'=>TRUE);

$id_pais = $_REQUEST['id_pais'];
$nombre_depto = strtoupper($_REQUEST['nombre_depto']);

mysqli_query($conexion, "START TRANSACTION");

$insert = "
INSERT INTO cat_departamento (nombre, id_pais) 
SELECT '".$nombre_depto."', '".$id_pais."'
FROM dual WHERE not exists(SELECT * FROM cat_departamento WHERE nombre = '".$nombre_depto."' AND id_pais='".$id_pais."')";
$resultados = mysqli_query($conexion, $insert);


if($resultados){
    mysqli_query($conexion, "COMMIT");
    $return = Array('ok' => TRUE, 'msg' => "registro grabado correctamente");
}else{
    mysqli_query($conexion, "ROLLBACK");
    $return = Array('ok' => FALSE, 'msg' => "Error al grabar el departamento, verifique si ya esta ingresado!");
}



header('Content-type: application/json; charset=utf-8');
echo json_encode($return);

?>