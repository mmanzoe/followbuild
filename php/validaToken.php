<?php
session_start();
require('class.validaLogin.php');
$return = Array('ok'=>TRUE);

$token = $_REQUEST['token'];

$validacion = new ValidaLogin("","");
$validacion->validaToken($token);

if($validacion->getEstado() === true){
    $return = Array('ok' => TRUE, 'msg'=> "Acceso correcto");
}else if($validacion->getEstado() === false){
    $return = Array('ok' => FALSE, 'msg' => "Token incorrecto", 'estado'=>$validacion->getEstado());
}else{
    $return = Array('ok' => FALSE, 'msg' => $validacion->getEstado());
};


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);


?>