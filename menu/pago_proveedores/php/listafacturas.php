<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
$result = Array();


$consu = "SELECT fac_en.*, cat_proveedor.nombre, (SELECT SUM(valor) FROM detalle_pago_proveedor WHERE id_factura=fac_en.id) as pagado 
FROM factura_proveedor_encabezado as fac_en 
INNER JOIN cat_proveedor ON(cat_proveedor.nit = fac_en.proveedor) 
WHERE fac_en.estado='1' ORDER BY fac_en.no_orden asc";

$resultados = mysqli_query($conexion, $consu);


for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	if($fila['pagado'] < $fila['total_factura']){
            
		$consuabono = "SELECT SUM(valor) as abonado FROM detalle_pago_proveedor WHERE id_factura = '".$fila['id']."'";
		$resconsu = mysqli_query($conexion, $consuabono);
		$registro = mysqli_fetch_assoc($resconsu);
		
		$nuevafecha = date("d-m-Y",strtotime($fila['fecha_ingresa']."+ $fila[credito] days"));
		
		$fecha_actual = strtotime(date("d-m-Y",time()));
		$fecha_entrada = strtotime($nuevafecha);
		
		if($fecha_actual > $fecha_entrada){
			$estadofactura = "vencido";
			$colorcelda = "table-danger";
		}else{
			$estadofactura = "vigente";
			$colorcelda = "table-success";
		}
		
		array_push($result,["no_orden"=>$fila['no_orden'], "serie"=>$fila['serie'], "documento"=>$fila['documento'], "nombre"=>$fila['nombre'], "fecha_factura"=>date_format(date_create($fila['fecha_factura']),'m-d-Y'), "credito"=>intval($fila['credito']), "total_factura"=>floatval($fila['total_factura']), "abono"=>floatval($registro['abonado']), "saldo"=>floatval($fila['total_factura']-$registro['abonado']), "nombre_ingresa"=>$fila['nombre_ingresa'], "fecha_ingresa"=>date_format(date_create($fila['fecha_ingresa']),'d-m-Y'), "acciones"=>'<a href=""><span style="color:blue" class="fa fa-check-circle valida" idregistro="'.$fila['id'].'"></span></a>']);
        
	}

}	

header ('Content-type: application/json; charset=utf8-8');
echo json_encode($result);


?>