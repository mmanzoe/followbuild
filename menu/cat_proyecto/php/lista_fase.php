<?php
require('../../cat_fase_proyecto/php/class.faseproyecto.php');

$faseproyecto = new FaseProyecto();
$registros = $faseproyecto->listado();

for($n=0;$n<count($registros);$n++){
	echo '<option value="'.$registros[$n]['id'].'" nombre="'.$registros[$n]['nombre'].'">'.$registros[$n]['nombre'].'</option>';
}


?>