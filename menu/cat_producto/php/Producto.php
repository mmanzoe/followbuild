<?php
date_default_timezone_set('America/Guatemala');
require('class.producto.php');
$return = Array();


$producto = new Producto();

if($_REQUEST['tipo']=='read'){

    $registros = $producto->listado();

}else if($_REQUEST['tipo']=='create'){
    
    $registros = $producto->grabar($_REQUEST['codigo'], strtoupper($_REQUEST['nombre']), strtoupper($_REQUEST['descripcion']),($_REQUEST['precio']), $_SESSION['datos_logueo']['idusuario']);
    
    if($registros===true){
        
        $registros = Array("ok"=>true, "msg"=>"Registro grabado correctamente");
        
    }else{
        $registros = Array("ok"=>false, "msg"=>"Error al grabar el registro ");
    }
     
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>