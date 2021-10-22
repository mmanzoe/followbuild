<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$idfactura = $_REQUEST['idfactura'];

$total = 0;
$subtotal = 0;


$query = "SELECT detalle_pago.*, fpen.tipo_factura, fpen.serie, fpen.documento, fpen.proveedor, fpen.total_factura, ctpp.nombre as nom_pago, cat_banco.nombre as nom_banco 
FROM detalle_pago_proveedor as detalle_pago 
INNER JOIN factura_proveedor_encabezado AS fpen ON (detalle_pago.id_factura = fpen.id) 
INNER JOIN cat_tipo_pago_proveedor as ctpp ON(ctpp.id = detalle_pago.id_tipo_pago) 
INNER JOIN cat_forma_pago_proveedor AS cfpp ON(cfpp.id = detalle_pago.id_banco) 
INNER JOIN cat_banco ON (cat_banco.id = cfpp.id_cat_banco)
WHERE detalle_pago.id_factura='".$idfactura."'";
$resultado = mysqli_query($conexion, $query);

for($n=0; $n<mysqli_num_rows($resultado); $n++){
	$fila = mysqli_fetch_assoc($resultado);
	
	
	echo '<div class="row" style="font-size:12px">';
	echo '<div class="col-3">'.$fila['nom_pago'].'</div>';
	echo '<div class="col-3">'.$fila['nom_banco'].'</div>';
	echo '<div class="col-3">'.$fila['documento_valida'].'</div>';
	echo '<div class="col-3">'.$fila['valor'].'</div>';
	echo '</div>';
	
	$total = $fila['total_factura'];
	$subtotal = $subtotal + $fila['valor'];

}

if($total>$subtotal){
	echo '~true';
}else{
	echo '~false';
}


?>