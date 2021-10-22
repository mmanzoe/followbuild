<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
$result = Array();

$consu = "SELECT ordenc.*, cat_proveedor.nombre as nom_proveedor, (ordenc.total_ordencompra*0.12) as iva, (ordenc.total_ordencompra-(ordenc.total_ordencompra*0.12)) as siniva, cat_moneda.nombre as nombre_moneda, cat_moneda.simbolo, usuario.nombre as nombre_ingresa  FROM orden_compra_encabezado as ordenc INNER JOIN cat_proveedor ON(cat_proveedor.nit = ordenc.cod_proveedor) INNER JOIN cat_moneda ON(cat_moneda.id = ordenc.moneda) INNER JOIN usuario ON(usuario.id = ordenc.id_usuario_ingresa) WHERE ordenc.estado = '1'";
$resultados = mysqli_query($conexion, $consu);

		
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	if($fila['estado'] == '1'){
		$estado = 'sin accion';
		$autoriza = '<a href="#" class="autoriza" idregistro="'.$fila['id'].'"><span class="fa fa-check-circle"></span></a>';
		$rechaza = '<a href="#" class="rechaza" idregistro="'.$fila['id'].'"><span class="fa fa-times-circle"></span></a>';
	}else if($fila['estado'] == '2'){
		$estado = 'Autorizado';
		$autoriza = '';
		$rechaza = '';
	}
	else if($fila['estado'] == '2'){
		$estado = 'Rechazada';
		$autoriza = '';
		$rechaza = '';
	}

	array_push($result,["id"=>$fila['id'], "cod_proveedor"=>$fila['cod_proveedor'], "nom_proveedor"=>$fila['nom_proveedor'], "tipo_orden"=>$fila['tipo_orden'], "tipo_pago"=>$fila['tipo_pago'], "observaciones"=>$fila['observaciones'], "nombre_moneda"=>$fila['nombre_moneda'], "monto"=>$fila['simbolo'].number_format($fila['total_ordencompra'],2,'.',','), "nombre_ingresa"=>$fila['nombre_ingresa'], "estado"=>$estado, "acciones"=>'<a href="reporte.php?id_registro='.$fila['id'].'&tipo_orden='.$fila['tipo_orden'].'&observaciones='.$fila['observaciones'].'&proveedor='.$fila['cod_proveedor'].'" target="_blank" class="visualiza"><span class="fa fa-download"></span></a> | '.$autoriza.' | '.$rechaza ] );

	
}		


header ('Content-type: application/json; charset=utf8-8');
echo json_encode($result);


?>