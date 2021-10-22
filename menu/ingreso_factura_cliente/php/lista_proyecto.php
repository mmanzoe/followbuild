<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$nombre_proyecto = $_REQUEST['nombre_proyecto'];

$consulta = "SELECT cat_proyecto.* FROM cat_proyecto
LEFT JOIN factura_cliente_detalle AS fcd ON(fcd.id_proyecto = cat_proyecto.id)
WHERE fcd.id is NULL AND nombre_proyecto LIKE '%".$nombre_proyecto."%'";
$resultados = mysqli_query($conexion, $consulta);


echo '<table class="table table-small-font table-bordered table-striped">
      <thead>
	    <tr>
		  <th>ID</th>
          <th>Cod Proyecto</th>
		  <th>Nombre</th>
          <th></th>
		</tr>
	  </thead>
	  <tbody>';
	 
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	echo '<tr>
	        <td>'.$fila['id'].'</td>
			<td>'.$fila['cod_proyecto'].'</td>
			<td>'.$fila['nombre_proyecto'].'</td>
			<td><a href="" class="agregaproyecto" id="'.$fila['id'].'" cod_proyecto="'.$fila['cod_proyecto'].'" nombreproyecto="'.$fila['nombre_proyecto'].'" ><span class="fa fa-plus-circle"></span></a></td>
	      </tr>';
	
}

echo '';

?>