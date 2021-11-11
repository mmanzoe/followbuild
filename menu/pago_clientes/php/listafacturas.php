<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
$result = Array();


$consu = "SELECT fac_en.*, cat_cliente.nombre, (SELECT SUM(valor) FROM detalle_pago_cliente WHERE id_factura=fac_en.id) as pagado 
FROM factura_cliente_encabezado as fac_en 
INNER JOIN cat_cliente ON(cat_cliente.id = fac_en.id_cliente) 
WHERE fac_en.estado='1' ORDER BY fac_en.id DESC";

$resultados = mysqli_query($conexion, $consu);


for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	if($fila['pagado'] < $fila['monto']){
            
		$consuabono = "SELECT SUM(valor) as abonado FROM detalle_pago_cliente WHERE id_factura = '".$fila['id']."'";
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
		
		array_push($result,["id"=>intval($fila['id']), "id_cliente"=>$fila['id_cliente'], "serie"=>$fila['serie'], "factura"=>$fila['factura'], "nombre"=>$fila['nombre'], "fecha_factura"=>date_format(date_create($fila['fecha_factura']),'m-d-Y'), "credito"=>intval($fila['credito']), "monto"=>floatval($fila['monto']), "abono"=>$registro['abonado'], "saldo"=>($fila['monto']-$registro['abonado']), "id_usuario_ingresa"=>$fila['id_usuario_ingresa'], "fecha_ingresa"=>date_format(date_create($fila['fecha_ingresa']),'d-m-Y'), "acciones"=>'<a href=""><span style="color:green" class="fa fa-check-circle valida" idregistro="'.$fila['id'].'"></span></a>']);
        
	}

}	

header ('Content-type: application/json; charset=utf8-8');
echo json_encode($result);


?>