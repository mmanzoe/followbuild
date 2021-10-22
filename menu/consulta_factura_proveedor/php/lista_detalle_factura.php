<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$id_registro = $_REQUEST['idregistro'];
$tipo_factura = $_REQUEST['tipo_factura'];


$query = "SELECT fac.*, fac_d.codigo_producto, fac_d.cantidad, fac_d.valor, cat_producto.nombre as nomproducto, cat_medida.nombre as nom_medida FROM factura_proveedor_encabezado as fac INNER JOIN factura_proveedor_detalle as fac_d ON (fac_d.serie = fac.serie AND fac_d.documento = fac.documento AND fac_d.proveedor = fac.proveedor) INNER JOIN cat_producto ON(cat_producto.codigo_producto = fac_d.codigo_producto) INNER JOIN cat_medida ON (cat_medida.id = fac_d.medida) WHERE fac.id = '".$id_registro."'";
$resultados = mysqli_query($conexion, $query);


	
echo '<table class="table table-small-font table-bordered table-striped">
	<thead>
		<tr>
		<th>Registro</th>
		<th>Codigo</th>
		<th>Descripcion</th>
		<th>Medida</th>
		<th>Cantidad</th>
		<th>Valor</th>
		</tr>
	</thead>
	<tbody>';
	

		
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
		
	echo '<tr>
		<td>'.($n+1).'</td>
		<td>'.$fila['codigo_producto'].'</td>
		<td>'.$fila['nomproducto'].'</td>
		<td>'.$fila['nom_medida'].'</td>
		<td>'.$fila['cantidad'].'</td>
		<td>'.$fila['valor'].'</td>
		</tr>';
	
}		

echo'</tbody></table>';


?>