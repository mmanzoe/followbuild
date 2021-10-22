<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
$return = Array('ok'=>TRUE);

$idregistro = $_REQUEST['idregistro'];

mysqli_query($conexion, "START TRANSACTION");

$update = "UPDATE orden_compra_encabezado SET estado = '3', nombre_autoriza = '".$_SESSION['datos_logueo']['idusuario']."', fecha_autoriza = '".date('Y-m-d H:i:s')."' WHERE id='".$idregistro."'";
$resultados = mysqli_query($conexion, $update);


if($resultados){
    mysqli_query($conexion, "COMMIT");
    $return = Array('ok' => TRUE, 'msg' => "registro actualizado correctamente");
}else{
    mysqli_query($conexion, "ROLLBACK");
    $return = Array('ok' => FALSE, 'msg' => "error al actualizar el registro");
}



header('Content-type: application/json; charset=utf-8');
echo json_encode($return);

?>