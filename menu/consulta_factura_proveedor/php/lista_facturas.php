<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$no_factura = $_REQUEST['no_factura'];
$tipo_factura = $_REQUEST['tipo_factura'];
$fecha_i = $_REQUEST['fecha_i'];
$fecha_f = $_REQUEST['fecha_f'];
$tipo_fecha = $_REQUEST['tipo_fecha'];
$result = Array();


if($tipo_factura == 'TODO'){
	$validacion = " fac_en.tipo_factura != ''";
}else{
	$validacion = " fac_en.tipo_factura = '".$tipo_factura."'";
}

if($tipo_fecha == '1'){
    $factura = 'fecha_ingresa';
}else{
    $factura = 'fecha_factura';
}

if($no_factura=="" && $fecha_i=="" && $fecha_f==""){
	$consu = "SELECT fac_en.*, ROUND(((fac_en.total_factura/1.12)*(fac_en.impuesto/100)),2) as iva, (fac_en.total_factura- ROUND(((fac_en.total_factura/1.12)*(fac_en.impuesto/100)),2)) as siniva, cat_proveedor.nombre as nom_proveedor, cef.nombre as nombre_estado FROM factura_proveedor_encabezado as fac_en INNER JOIN cat_proveedor ON(cat_proveedor.nit = fac_en.proveedor) INNER JOIN cat_estado_factura AS cef ON(cef.id = fac_en.estado) WHERE ".$validacion." ORDER BY fac_en.".$factura." asc";
}else if($no_factura != "" && $fecha_i=="" && $fecha_f ==""){
	$consu = "SELECT fac_en.*, ROUND(((fac_en.total_factura/1.12)*(fac_en.impuesto/100)),2) as iva, (fac_en.total_factura- ROUND(((fac_en.total_factura/1.12)*(fac_en.impuesto/100)),2)) as siniva, cat_proveedor.nombre as nom_proveedor, cef.nombre as nombre_estado FROM factura_proveedor_encabezado as fac_en INNER JOIN cat_proveedor ON(cat_proveedor.nit = fac_en.proveedor) INNER JOIN cat_estado_factura AS cef ON(cef.id = fac_en.estado) WHERE fac_en.documento = '".$no_factura."' AND ".$validacion." ORDER BY fac_en.".$factura." asc";
}else if($no_factura == "" && $fecha_i != "" && $fecha_f != ""){
	$consu = "SELECT fac_en.*, ROUND(((fac_en.total_factura/1.12)*(fac_en.impuesto/100)),2) as iva, (fac_en.total_factura- ROUND(((fac_en.total_factura/1.12)*(fac_en.impuesto/100)),2)) as siniva, cat_proveedor.nombre as nom_proveedor, cef.nombre as nombre_estado FROM factura_proveedor_encabezado as fac_en INNER JOIN cat_proveedor ON(cat_proveedor.nit = fac_en.proveedor) INNER JOIN cat_estado_factura AS cef ON(cef.id = fac_en.estado) WHERE DATE(fac_en.".$factura.") BETWEEN  DATE('".$fecha_i."') AND DATE('".$fecha_f."') AND ".$validacion." ORDER BY fac_en.".$factura." asc";
}

$resultados = mysqli_query($conexion, $consu);

		
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	if($fila['estado']=='1'){
		$linkelimina = '<a href="" title="eliminar" idregistro="'.$fila['id'].'" serie="'.$fila['serie'].'" documento="'.$fila['documento'].'" proveedor="'.$fila['proveedor'].'" tipo_fac="'.$fila['tipo_factura'].'" class="eliminar"><span class="fa fa-times-circle"></span></a></td>';
	}else if($fila['estado']=='2'){
		$linkelimina = "";
	}
      

	array_push($result,["no_orden"=>$fila['no_orden'], "serie"=>$fila['serie'], "documento"=>$fila['documento'], "fecha_factura"=>date_format(date_create($fila['fecha_factura']),'d-m-Y'),
						"proveedor"=>$fila['proveedor'], "nom_proveedor"=>$fila['nom_proveedor'], "iva"=>number_format($fila['iva'],2,'.',','),
						"sin_iva"=>number_format($fila['siniva'],2,'.',','), "total_factura"=>number_format($fila['total_factura'],2,'.',','),
						"nombre_ingresa"=>$fila['nombre_ingresa'], "fecha_ingresa"=>date_format(date_create($fila['fecha_ingresa']),'d-m-Y'),
						"estado"=>$fila['nombre_estado'], "acciones"=>'<a href="" title="detalle factura"><span class="fa fa-list detalle" idregistro="'.$fila['id'].'" tipo_fac="'.$fila['tipo_factura'].'"></span></a> | <a href="" class="visualiza" title="visualiza factura" idregistro="'.$fila['id'].'" serie="'.$fila['serie'].'" documento="'.$fila['documento'].'" proveedor="'.$fila['proveedor'].'" tipo_fac="'.$tipo_factura.'"><span class="fa fa-image"></span></a> | <a href="" class="detallepago" title="detalle pago" idregistro="'.$fila['id'].'" serie="'.$fila['serie'].'" documento="'.$fila['documento'].'" proveedor="'.$fila['proveedor'].'" tipo_fac="'.$tipo_factura.'"><span class="fa fa-list"></span></a> | '.$linkelimina ]);
	
	
}		


header ('Content-type: application/json; charset=utf8-8');
echo json_encode($result);


?>