<?php
session_start();
require('class.proyecto.php');

$proyecto = new Proyecto();

if($_REQUEST['tipo']=='read'){

    $registros = $proyecto->listado();

}else if($_REQUEST['tipo']=='create'){

    $empresa='';
    $cod_proyecto='';
    $nom_proyecto = '';
    $descripcion='';
    $monto='';
    $encargado = '';
    $fases = Array();
    $gastos = Array();

    $datos =  json_decode($_REQUEST['datos']);
    foreach ($datos as $nombre=>$key) {
        
        if($nombre == 'empresa'){
            $empresa = $key;
        }
        if($nombre == 'cod_proyecto'){
            $cod_proyecto = $key;
        }
        if($nombre == 'nom_proyecto'){
            $nom_proyecto = $key;
        }
        if($nombre == 'descripcion'){
            $descripcion = $key;
        }
        if($nombre == 'monto'){
            $monto = $key;
        }
        if($nombre == 'encargado'){
            $encargado = $key;
        }
        if($nombre == 'fases'){
            
            $fases = json_decode(json_encode($key), true);
            
        }
        if($nombre == 'gastos'){
            $gastos = json_decode(json_encode($key), true);
        }

    }
    
    
    $registros = $proyecto->grabar('', $empresa, strtoupper($cod_proyecto), strtoupper($nom_proyecto), strtoupper($descripcion), strtoupper($monto), $encargado, $fases, $gastos, $_SESSION['datos_logueo']['idusuario']);
                                                                                                                                                                                                                                           
    if($registros===true){
        $grabarfases = $proyecto->grabarfases($fases);
        $grabarfases = $proyecto->grabargastos($gastos, $_SESSION['datos_logueo']['idusuario']);
        $proyecto->enviopdf($empresa, strtoupper($cod_proyecto), strtoupper($nom_proyecto), strtoupper($descripcion), strtoupper($monto), $encargado, $fases, $gastos);
        $registros = Array("ok"=>true, "msg"=>"Registro grabado correctamente");
        
    }else{
        $registros = Array("ok"=>false, "msg"=>"Error al grabar el registro ");
    }
    
     
}



header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>