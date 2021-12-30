<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$no_factura = $_REQUEST['no_factura'];
$fecha_i = $_REQUEST['fecha_i'];
$fecha_f = $_REQUEST['fecha_f'];
$tipo_fecha = $_REQUEST['tipo_fecha'];
$result = Array();


if($tipo_fecha == '1'){
    $factura = 'fecha_ingresa';
}else{
    $factura = 'fecha_factura';
}

if($no_factura=="" && $fecha_i=="" && $fecha_f==""){
	$consu = "SELECT fac_en.*, cat_cliente.nombre as nombre_cliente, usuario.nombre as nombre_ingresa, cef.nombre as nombre_estado FROM factura_cliente_encabezado as fac_en INNER JOIN cat_cliente ON (cat_cliente.id = fac_en.id_cliente) INNER JOIN usuario ON (usuario.id = fac_en.id_usuario_ingresa) INNER JOIN cat_estado_factura AS cef ON(cef.id = fac_en.estado) ORDER BY fac_en.".$factura." asc";
}else if($no_factura != "" && $fecha_i=="" && $fecha_f ==""){
	$consu = "SELECT fac_en.*, cat_cliente.nombre as nombre_cliente, usuario.nombre as nombre_ingresa, cef.nombre as nombre_estado FROM factura_cliente_encabezado as fac_en INNER JOIN cat_cliente ON (cat_cliente.id = fac_en.id_cliente) INNER JOIN usuario ON (usuario.id = fac_en.id_usuario_ingresa) INNER JOIN cat_estado_factura AS cef ON(cef.id = fac_en.estado) WHERE fac_en.factura = '".$no_factura."'  ORDER BY fac_en.".$factura." asc";
}else if($no_factura == "" && $fecha_i != "" && $fecha_f != ""){
	$consu = "SELECT fac_en.*, cat_cliente.nombre as nombre_cliente, usuario.nombre as nombre_ingresa, cef.nombre as nombre_estado FROM factura_cliente_encabezado as fac_en INNER JOIN cat_cliente ON (cat_cliente.id = fac_en.id_cliente) INNER JOIN usuario ON (usuario.id = fac_en.id_usuario_ingresa) INNER JOIN cat_estado_factura AS cef ON(cef.id = fac_en.estado) WHERE DATE(fac_en.".$factura.") BETWEEN  DATE('".$fecha_i."') AND DATE('".$fecha_f."') ORDER BY fac_en.".$factura." asc";
}

$resultados = mysqli_query($conexion, $consu);

		
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	if($fila['estado']=='1'){
		$linkelimina = '<a href="" title="eliminar" idregistro="'.$fila['id'].'" serie="'.$fila['serie'].'" factura="'.$fila['factura'].'" nombre_cliente="'.$fila['nombre_cliente'].'" class="eliminar"><span class="fa fa-times-circle"></span></a></td>';
	}else if($fila['estado']=='2'){
		$linkelimina = "";
	}
      

	array_push($result,["serie"=>$fila['serie'], "factura"=>$fila['factura'], "fecha_factura"=>date_format(date_create($fila['fecha_factura']),'d-m-Y'), "monto"=>$fila['monto'],
						"nombre_cliente"=>$fila['nombre_cliente'],"total_factura"=>number_format($fila['monto'],2,'.',','),
						"nombre_ingresa"=>$fila['nombre_ingresa'], "fecha_ingresa"=>date_format(date_create($fila['fecha_ingresa']),'d-m-Y'),
						"nombre_estado"=>$fila['nombre_estado'], "acciones"=>'<a href="reporte.php?reg='.MD5($fila['id']).'" target="_blank" ><span class="fa fa-file-invoice"></span></a> | <a href="" class="detallepago" title="detalle pago" idregistro="'.$fila['id'].'" serie="'.$fila['serie'].'" factura="'.$fila['factura'].'" ><span class="fa fa-list"></span></a> | '.$linkelimina ]);
	
	
}		


header ('Content-type: application/json; charset=utf8-8');
echo json_encode($result);


?>