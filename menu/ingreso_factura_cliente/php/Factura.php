<?php
require ('class.facturacliente.php');

$factura = new Factura();

if($_REQUEST['tipo']=='read'){
   
    $registros = $factura->listado();

}else if($_REQUEST['tipo']=='create'){

    $registros = $factura->grabar($_REQUEST['id_proyecto'], strval($_REQUEST['serie_factura']), strval($_REQUEST['no_factura']), $_REQUEST['fecha_factura'], $_REQUEST['monto'], $_REQUEST['id_cliente']);

}


header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

/*
session_start();
require('../../../php/conect.php');

$id_proyecto = $_REQUEST['id_proyecto'];
$serie_factura = $_REQUEST['serie_factura'];
$no_factura = $_REQUEST['no_factura'];
$fecha_factura = $_REQUEST['fecha_factura'];
$monto = $_REQUEST['monto'];
$id_cliente = $_REQUEST['id_cliente'];
$return = Array("ok"=>true);

mysqli_query($conexion, "START TRANSACTION");
$insertEnca = "INSERT INTO factura_cliente_encabezado (id_cliente, serie, factura, fecha_factura, monto, id_usuario_ingresa) VALUES('".$id_cliente."','".$serie_factura."','".$no_factura."','".$fecha_factura."','".$monto."','".$_SESSION['datos_logueo']['idusuario']."')";
$resInsert = mysqli_query($conexion, $insertEnca);

$insertDet = "INSERT INTO factura_cliente_detalle (id_factura, id_proyecto, monto) VALUES('".mysqli_insert_id($conexion)."','".$id_proyecto."','".$monto."')"; 
$resDet = mysqli_query($conexion, $insertDet);

if($resInsert && $resDet){
    mysqli_query($conexion, "COMMIT");
    $return = Array("ok"=>true, "msg"=>"Registro grabado correctamente!");
}else{
    mysqli_query($conexion, "ROLLBACK");
    $return = Array("ok"=>false, "msg"=>"Error de grabacion...");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($return);
*/
?>