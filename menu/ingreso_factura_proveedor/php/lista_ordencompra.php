<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$nombre_proveedor = $_REQUEST['nombre_proveedor'];

$consulta = "SELECT orden.*, cat_proveedor.nombre as nom_proveedor, cat_proveedor.credito, tc.nombre as tipo_contribuyente, tc.impuesto, fac_en.id as idfactura FROM orden_compra_encabezado as orden INNER JOIN cat_proveedor ON(orden.cod_proveedor = cat_proveedor.nit) INNER JOIN cat_tipo_contribuyente as tc ON(tc.id = cat_proveedor.id_tipo_contribuyente) LEFT JOIN factura_proveedor_encabezado as fac_en ON(fac_en.no_orden = orden.id) WHERE cat_proveedor.nombre LIKE '%".$nombre_proveedor."%' AND orden.estado = '2'  AND fac_en.id is null ORDER BY orden.id asc";
$resultados = mysqli_query($conexion, $consulta);


echo '<table class="table table-small-font table-bordered table-striped">
      <thead>
	    <tr>
		  <th>No. orden</th>
		  <th>Proveedor</th>
		  <th>Tipo Orden</th>
		  <th>Monto</th>
		  <th>Agregar</th>
		</tr>
	  </thead>
	  <tbody>';
	 
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	echo '<tr>
	        <td>'.$fila['id'].'</td>
			<td>'.$fila['nom_proveedor'].'</td>
			<td>'.$fila['tipo_orden'].'</td>
			<td>'.$fila['total_ordencompra'].'</td>
			<td><a href="" class="agregaordencompra" no_orden="'.$fila['id'].'" nit="'.$fila['cod_proveedor'].'" nombreproveedor="'.$fila['nom_proveedor'].'" credito="'.$fila['credito'].'" tipoorden="'.$fila['tipo_orden'].'" tipo_contribuyente="'.$fila['tipo_contribuyente'].'" impuesto="'.$fila['impuesto'].'" id_proyecto="'.$fila['id_proyecto'].'" id_tipo_gasto="'.$fila['id_gasto_proyecto'].'"><span class="fa fa-plus-circle"></span></a></td>
	      </tr>';
	
}

echo '';

?>