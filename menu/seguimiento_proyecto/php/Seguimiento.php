<?php
require('class.seguimientoproyecto.php');

$faseproyecto = new SeguimientoProyecto();
$registros = $faseproyecto->listadoproyecto();

header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>