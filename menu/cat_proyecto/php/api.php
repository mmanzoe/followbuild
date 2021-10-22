<?php
include_once('class.proyecto.php');

$proyecto = new Proyecto();
$registros = $proyecto->listafasesproyecto($_REQUEST['id_proyecto']);
header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);



?>