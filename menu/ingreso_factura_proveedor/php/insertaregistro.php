<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
$return = Array('ok'=>TRUE);

$orden_compra = $_REQUEST['orden_compra'];
$tipo_factura = $_REQUEST['tipo_factura'];

$materia_prima = $_REQUEST['materia_prima']; 
$consuregistro = "SELECT * FROM orden_compra_detalle WHERE cod_producto = '".$materia_prima."' AND id_orden_compra='".$orden_compra."' LIMIT 1";

$resulconsulta = mysqli_query($conexion, $consuregistro);


if(mysqli_num_rows($resulconsulta)>0){
    $return = Array('ok' => FALSE, 'msg' => "Registro ya se encuentra en la lista!");
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($return);
    die();
}

mysqli_query($conexion, "START TRANSACTION");
    
   
$materia_prima = $_REQUEST['materia_prima'];
$no_lote = $_REQUEST['no_lote'];
$fecha_vence = $_REQUEST['fecha_vence'];
$cantidad = $_REQUEST['cantidad'];
$medida = $_REQUEST['medida'];
$valor = $_REQUEST['valor'];
$insert = "INSERT INTO orden_compra_detalle(id_orden_compra, cod_producto, cantidad, valor) VALUES('".$orden_compra."','".$materia_prima."','".$cantidad."','".$valor."')";  
$totalorden = "SELECT SUM(cantidad*valor) as totalfac FROM orden_compra_detalle WHERE id_orden_compra='".$orden_compra."' ";


$resultados = mysqli_query($conexion, $insert);

$restotalfac = mysqli_query($conexion, $totalorden);
$row = mysqli_fetch_assoc($restotalfac);

$updateencabezado = "UPDATE orden_compra_encabezado SET total_ordencompra='".$row['totalfac']."' WHERE id='".$orden_compra."' ";
$resulupdate = mysqli_query($conexion, $updateencabezado);


if($resultados && $resulupdate){
    
    mysqli_query($conexion, "COMMIT");
    $return = Array('ok' => TRUE, 'msg' => "Registro insertado correctamente!!");
}else{
    mysqli_query($conexion, "ROLLBACK");
    $return = Array('ok' => FALSE, 'msg' => "Error al insertar el registro!!");
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);



?>