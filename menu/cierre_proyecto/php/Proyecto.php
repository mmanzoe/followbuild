<?php
session_start();
include_once('../../cat_proyecto/php/class.proyecto.php');

$proyecto = new Proyecto();
$registros = $proyecto->listado('1');

header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>