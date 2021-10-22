<?php
require('class.faseproyecto.php');

$faseproyecto = new FaseProyecto();

if($_REQUEST['tipo']=='read'){

    $registros = $faseproyecto->listado();

}else if($_REQUEST['tipo']=='create'){
    
    $registros = $faseproyecto->grabar($_REQUEST['codigo'], strtoupper($_REQUEST['nombre']), strtoupper($_REQUEST['descripcion']), $_SESSION['datos_logueo']['idusuario']);
    
    if($registros===true){
        
        $registros = Array("ok"=>true, "msg"=>"Registro grabado correctamente");
        
    }else{
        $registros = Array("ok"=>false, "msg"=>"Error al grabar el registro ");
    }
     
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>