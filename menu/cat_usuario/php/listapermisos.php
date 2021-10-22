<?php
session_start();
require('../../../php/conexion.php');

$idregistro = $_REQUEST['idregistro'];
$query = "SELECT upermiso.*, c_permiso.nombre as nom_permiso FROM usuario_permiso as upermiso INNER JOIN c_permiso ON(upermiso.id_permiso = c_permiso.id_permiso) WHERE upermiso.id_usuario='".$idregistro."' ORDER BY c_permiso.nombre ASC";
$resultados = mysqli_query($conexion, $query);

echo '<table class="table table-small-font table-bordered table-striped">
		<thead>
		  <tr>
			<th>Nombre</th>
			<th>Eliminar</th>
		  </tr>
		</thead>
		<tbody>';


for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	echo '<tr>
			<td>'.$fila['nom_permiso'].'</td>
			<td><a href="" class="eliminapermiso" idregistro="'.$fila['id'].'"><span class="fa fa-trash fa-2x"></span></a></td>
		  </tr>';
	
}

echo'</tbody></table>';


?>