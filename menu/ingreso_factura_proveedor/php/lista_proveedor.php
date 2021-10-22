<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$nombre = $_REQUEST['nombreproveedor'];

$consulta = "SELECT * FROM cat_proveedor WHERE nombre LIKE '%".$nombre."%' ORDER BY nit asc";
$resultados = mysqli_query($conexion, $consulta);

echo '<table class="table table-small-font table-bordered table-striped">
      <thead>
	    <tr>
		  <th>Nit</th>
		  <th>Nombre</th>
		  <th>Agregar</th>
		</tr>
	  </thead>
	  <tbody>';
	 
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	echo '<tr>
	        <td>'.$fila['nit'].'</td>
			<td>'.$fila['nombre'].'</td>
			<td><a href="" class="agregaproveedor" nit="'.$fila['nit'].'" nombre="'.$fila['nombre'].'" credito="'.$fila['credito'].'"><span class="fa fa-plus-circle fa-2x"></span></a></td>
	      </tr>';
	
}

echo '';

?>