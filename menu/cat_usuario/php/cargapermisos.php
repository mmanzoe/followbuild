<?php
require('../../../php/conexion.php');

$query = "SELECT * FROM c_permiso GROUP BY modulo ORDER BY modulo asc";
$resultados = mysqli_query($conexion, $query);


for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
        
        echo '<optgroup label="'.$fila['modulo'].'">';
        
        $consupermiso = "SELECT * FROM c_permiso WHERE modulo='".$fila['modulo']."'";
        $resulpermiso = mysqli_query($conexion, $consupermiso);
	
        for($i=0; $i<mysqli_num_rows($resulpermiso); $i++){
            $row = mysqli_fetch_assoc($resulpermiso);
            
            echo '<option value="'.$row['id_permiso'].'">'.$row['nombre'].'</option>';
        }
        
        
        echo '</optgroup>';
        
}

?>