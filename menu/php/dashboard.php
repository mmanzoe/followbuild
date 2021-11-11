<?php
require ('class.dashboard.php');

$dashboard = new Dashboard();

if($_REQUEST['busqueda']=='1'){
    $result = $dashboard->proyectoActivo();
}

if($_REQUEST['busqueda']=='2'){
    $result = $dashboard->facturaPago();
}

if($_REQUEST['busqueda']=='3'){
    $result = $dashboard->facturaCobro();
}

if($_REQUEST['busqueda']=='4'){
    $result = $dashboard->proyectoVencimiento();
}

if($_REQUEST['busqueda']=='5'){
    $result = $dashboard->ordenCompraPendienteValidacion();
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($result);



?>