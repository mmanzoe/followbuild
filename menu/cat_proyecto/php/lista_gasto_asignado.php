<?php
require('class.proyecto.php');

$gasto_asignado_proyecto = new Proyecto();
$registros = $gasto_asignado_proyecto->listagastosproyecto($_REQUEST['id_proyecto']);

header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>