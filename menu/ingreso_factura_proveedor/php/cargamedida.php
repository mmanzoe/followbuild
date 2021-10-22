<?php
session_start();
require('../../../php/conexion.php');

$proveedor = $_REQUEST['proveedor'];
$codmp = $_REQUEST['codmp'];

$consu = "SELECT cat_materia_prima.*, cat_medida.nombre as nom_medida, cat_medida.id as id_medida FROM cat_materia_prima INNER JOIN cat_medida ON (cat_medida.id = cat_materia_prima.medida) INNER JOIN proveedor ON (proveedor.id = cat_materia_prima.cod_proveedor) WHERE cod_producto = '".$codmp."' AND proveedor.nit = '".$proveedor."'";
$resultados = mysqli_query($conexion, $consu);


for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	echo '<option value="'.$fila['id_medida'].'">'.$fila['nom_medida'].'</option>';
	
}

?>