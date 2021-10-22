<?php
require('../../../php/class.validaciones.php');
$return = Array('ok'=>FALSE);


$id = $_REQUEST['id'];
$correo = $_REQUEST['correo'];
$usuario = $_REQUEST['usuario'];
$pass_actual = $_REQUEST['pass_actual'];
$new_pass = $_REQUEST['new_pass'];

$validaciones = new Validaciones;

if($validaciones->validaContrasena($id, $usuario, $pass_actual) === true){
    
    if($validaciones->actualizaContrasena($correo, $new_pass) === true){
        $return = Array('ok'=>TRUE);
    }else{
        $return = Array('ok'=>FALSE);
    }
    
}else{
    $return = Array('ok'=>FALSE);
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);

?>