<?php
require('../../../php/conexion.php');

$busqueda = $_REQUEST['busqueda'];
$query = "SELECT * FROM usuario WHERE nombre like '%".$busqueda."%'";
$resultados = mysqli_query($conexion, $query);

echo '<table class="table table-small-font table-bordered table-striped">
		<thead>
		  <tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Correo</th>
			<th>Usuario</th>
			<th>Clave</th>
			<th>Estado</th>
			<th>Accion</th>
			<th>Permisos</th>
		  </tr>
		</thead>
		<tbody>';


for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	
	if($fila['habilitado'] == '1'){
		$activo = 'Activo';
		$accion = '<a href="" class="bloquear" idregistro="'.$fila['id'].'"><span class="fa fa-lock fa-2x"></span></a>';
	}else if($fila['habilitado'] == '0'){
		$activo = 'Bloqueado';
		$accion = '<a href="" class="activar" idregistro="'.$fila['id'].'"><span class="fa fa-unlock fa-2x"></span></a>';
	}
	
	echo '<tr>
	        <td>'.($n+1).'</td>
			<td>'.$fila['nombre'].'</td>
			<td>'.$fila['email'].'</td>
			<td>'.$fila['usuario'].'</td>
			<td>'.$fila['password'].'</td>
			<td>'.$activo.'</td>
			<td>'.$accion.'</td>
			<td><a href="" class="permiso" idregistro="'.$fila['id'].'"><span class="fa fa-user-plus fa-2x"></span></a></td>
		  </tr>';
	
}

echo'</tbody></table>';


?>