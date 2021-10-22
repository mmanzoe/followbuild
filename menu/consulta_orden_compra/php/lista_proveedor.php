<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$query = "SELECT * FROM cat_proveedor ORDER BY nombre ASC";
$resultados = mysqli_query($conexion, $query);
	
	echo '<option value="">TODO</option>';
	 
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	echo '<option value="'.$fila['nit'].'">'.$fila['nombre'].'</option>';
	
}



?>