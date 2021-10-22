<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$id_registro = $_REQUEST['idregistro'];
//$tipo_orden = $_REQUEST['tipo_orden'];

$query = "SELECT *, cat_producto.nombre, (valor * cantidad) as total FROM orden_compra_detalle INNER JOIN cat_producto ON (cat_producto.codigo_producto = orden_compra_detalle.cod_producto ) WHERE id_orden_compra = '".$id_registro."'";


$resultados = mysqli_query($conexion, $query);

$totalordencompra = 0;


echo '<table class="table table-small-font table-bordered table-striped">
	<thead>
		<tr>
		<th>Registro</th>
		<th>Cod. Producto</th>
		<th>Nombre</th>
		<th>Cantidad</th>
		<th>Valor</th>
		<th>Total</th>
		</tr>
	</thead>
	<tbody>';
	

		
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	
		
	echo '<tr>
		<td>'.($n+1).'</td>
		<td>'.$fila['cod_producto'].'</td>
		<td>'.$fila['nombre'].'</td>
		<td>'.$fila['cantidad'].'</td>
		<td align="right">'.number_format($fila['valor'],2,'.',',').'</td>
		<td align="right">'.number_format($fila['total'],2,'.',',').'</td>
		</tr>';
			
	$totalordencompra = $totalordencompra + $fila['total'];
		
	  
	
	
}		


echo '<tr><td colspan="6">&nbsp;</td></tr>';
echo '<tr><td colspan="5" align="right">TOTAL</td><td>'.number_format($totalordencompra,2,'.',',').'</td></tr>';
echo'</tbody></table>';


?>