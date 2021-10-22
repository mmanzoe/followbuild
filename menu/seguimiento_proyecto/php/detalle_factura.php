<?php
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
$result = Array();

$id_proyecto  = $_REQUEST['id_proyecto'];
$id_gasto = $_REQUEST['id_gasto'];

$consu = "SELECT fac_en.*, cat_proveedor.nombre, (SELECT SUM(valor) FROM detalle_pago_proveedor WHERE id_factura=fac_en.id) as pagado 
FROM factura_proveedor_encabezado as fac_en 
INNER JOIN cat_proveedor ON(cat_proveedor.nit = fac_en.proveedor) 
WHERE fac_en.estado='1' AND id_proyecto = '".$id_proyecto."' AND id_gasto_proyecto = '".$id_gasto."' ";

$resultados = mysqli_query($conexion, $consu);


for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	array_push($result,["id"=>$fila['id'], "serie"=>$fila['serie'], "documento"=>$fila['documento'], "proveedor"=>$fila['proveedor'], "total_factura"=>$fila['total_factura']]);
      
}	

header ('Content-type: application/json; charset=utf8-8');
echo json_encode($result);
?>