<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$query = "SELECT * FROM cat_tipo_pago_proveedor ORDER BY nombre asc";
$resultado = mysqli_query($conexion, $query);

echo '<option value="" selected disabled>SELECCIONE</option>';

for($n=0; $n<mysqli_num_rows($resultado); $n++){
	$fila = mysqli_fetch_assoc($resultado);
	
	echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
}


?>