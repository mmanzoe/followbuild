<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$nombre = $_REQUEST['nombre_mpep'];
//$tipo_fac = $_REQUEST['tipo_fac'];


$consulta = "SELECT mp.*, cat_medida.nombre as nom_medida FROM cat_producto as mp INNER JOIN cat_medida ON(cat_medida.id = mp.id_medida) WHERE mp.nombre LIKE '%".$nombre."%' ORDER BY mp.nombre asc";
$resultados = mysqli_query($conexion, $consulta);

echo '<table class="table table-small-font table-bordered table-striped">
      <thead>
	    <tr>
		  <th>Cod. Producto</th>
		  <th>Nombre</th>
		  <th>Agregar</th>
		</tr>
	  </thead>
	  <tbody>';
	 
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	echo '<tr>
	        <td>'.$fila['codigo_material'].'</td>
			<td>'.$fila['nombre'].'</td>
			<td><a href="" class="agregaproducto" cod_producto="'.$fila['codigo_producto'].'" nombre="'.$fila['nombre'].'" tipo_materia="'.$fila['tipo_materia'].'" id_medida="'.$fila['id_medida'].'" nom_medida="'.$fila['nom_medida'].'" peso_kg="'.$fila['peso_kg'].'" unidad="'.$fila['unidad'].'"><span class="fa fa-plus-circle"></span></a></td>
	      </tr>';
	
}

echo '';

?>