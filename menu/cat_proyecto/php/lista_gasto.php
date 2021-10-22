<?php
require('../../cat_gasto_proyecto/php/class.gastoproyecto.php');

$faseproyecto = new GastoProyecto();
$registros = $faseproyecto->listado();

for($n=0;$n<count($registros);$n++){
	echo '<option value="'.$registros[$n]['id'].'" nombre="'.$registros[$n]['nombre'].'">'.$registros[$n]['nombre'].'</option>';
}


?>