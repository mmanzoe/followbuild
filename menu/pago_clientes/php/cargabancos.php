<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$tipo_pago_proveedor = $_REQUEST['tipo_pago'];

$query = "SELECT cfpp.*, cat_banco.nombre FROM cat_forma_pago_proveedor AS cfpp
LEFT JOIN cat_banco ON(cat_banco.id = cfpp.id_cat_banco) 
WHERE id_cat_tipo_pago_proveedor= '".$tipo_pago_proveedor."' ORDER BY cuenta asc";

$resultado = mysqli_query($conexion, $query);

for($n=0; $n<mysqli_num_rows($resultado); $n++){
	$fila = mysqli_fetch_assoc($resultado);
	
	echo '<option value="'.$fila['id'].'">'.$fila['nombre'].' - '.$fila['cuenta'].'</option>';
}


?>