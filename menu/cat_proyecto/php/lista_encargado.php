<?php
require('../../../php/conect.php');


$query = "SELECT * FROM usuario WHERE tipo = '2'";
$resultados = mysqli_query($conexion, $query);


for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
    echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
	
	
}




?>