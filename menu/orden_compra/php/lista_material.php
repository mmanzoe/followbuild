<?php
date_default_timezone_set('America/Guatemala');
require('../../cat_producto/php/class.producto.php');


$producto = new Producto();
$resultados = $producto->listado();
//$resultados = $producto->listado($_REQUEST['nombre_material']);

echo '<table class="table table-small-font table-bordered table-striped">
      <thead>
	    <tr>
		  <th>Cod. Material</th>
		  <th>Nombre</th>
		  <th>Agregar</th>
		</tr>
	  </thead>
	  <tbody>';

$n=0;	  
while($n<count($resultados)){

	echo '<tr>
	<td>'.$resultados[$n]['codigo'].'</td>
	<td>'.$resultados[$n]['nombre'].'</td>
	<td><a href="" class="agregamaterial" cod_producto="'.$resultados[$n]['codigo'].'" nombre="'.$resultados[$n]['nombre'].'"  valor_compra="'.$resultados[$n]['precio'].'" id_medida="'.$resultados[$n]['id_medida'].'" nombre_medida="'.$resultados[$n]['nombre_medida'].'" ><span class="fa fa-plus-circle"></span></a></td>
</tr>';
	
	$n++;
}	  



echo '</tbody></table>';


?>