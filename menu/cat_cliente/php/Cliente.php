<?php
require('class.cliente.php');

$cliente = new Cliente();

if($_REQUEST['tipo']=='read'){

    $registros = $cliente->listaCliente();

}else if($_REQUEST['tipo']=='create'){
    
    $registros = $cliente->grabarCliente($_REQUEST['tipo'], $_FILES['file'], strtoupper($_REQUEST['nombre']), strtoupper($_REQUEST['razon']), strtoupper($_REQUEST['direccion']), $_REQUEST['tel1'], $_REQUEST['tel2'], strtoupper($_REQUEST['nit']), strtoupper($_REQUEST['email']), strtoupper($_REQUEST['contacto']), $_REQUEST['telcontacto'], strtoupper($_REQUEST['comentario']), $_REQUEST['idregistro']);
    
    
    if($registros===true){
        
        $cargartu = $cliente->cargaRtu();
       
        if($cargartu===true){
            $registros = Array("ok"=>true, "msg"=>"Registro grabado correctamente");
        }else{
            $registros = Array("ok"=>false, "msg"=>"Registro grabado correctamente, problemas al cargar el PDF");
        }

    }else{
        $registros = Array("ok"=>false, "msg"=>"Error al grabar el registro");
    }
        
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);

?>