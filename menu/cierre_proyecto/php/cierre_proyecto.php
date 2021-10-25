<?php
include_once('../../cat_proyecto/php/class.proyecto.php');

$id_proyecto = $_REQUEST['id_proyecto'];

$proyecto = new Proyecto();
$registros = $proyecto->cierre_proyecto($id_proyecto);
header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>