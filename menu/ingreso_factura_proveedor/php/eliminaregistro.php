<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
$return = Array('ok'=>TRUE);

$orden_compra = $_REQUEST['orden_compra'];
$idregistro = $_REQUEST['idregistro'];


mysqli_query($conexion, "START TRANSACTION");

$delete = "DELETE FROM orden_compra_detalle WHERE id='".$idregistro."'";
$totalorden = "SELECT SUM(cantidad*valor) as totalfac FROM orden_compra_detalle WHERE id_orden_compra='".$orden_compra."' ";

$resultados = mysqli_query($conexion, $delete);

$restotalfac = mysqli_query($conexion, $totalorden);
$row = mysqli_fetch_assoc($restotalfac);

$updateencabezado = "UPDATE orden_compra_encabezado SET total_ordencompra='".$row['totalfac']."' WHERE id='".$orden_compra."' ";
$resulupdate = mysqli_query($conexion, $updateencabezado);


if($resultados && $resulupdate){
    mysqli_query($conexion, "COMMIT");
    $return = Array('ok' => TRUE, 'msg' => "Registro eliminado correctamente!!");
}else{
    mysqli_query($conexion, "ROLLBACK");
    $return = Array('ok' => FALSE, 'msg' => "Error al eliminar el registro!!");
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);



?>