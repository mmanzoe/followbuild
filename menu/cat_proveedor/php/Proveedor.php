<?php
require('class.proveedor.php');

$proveedor= new Proveedor();
$registros = $proveedor->listaProveedor();

header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>