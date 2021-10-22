<?php
session_start();
require('class.validaLogin.php');
$return = Array('ok'=>TRUE);

$usuario = $_REQUEST['usuario'];
$contrasena = $_REQUEST['contrasena'];

$validacion = new ValidaLogin($usuario, $contrasena);

if($validacion->getValidacion() === true){
    $return = Array('ok' => TRUE, 'msg'=> "Acceso correcto");
}else if($validacion->getValidacion() === false){
    $return = Array('ok' => FALSE, 'msg' => "Usuario y/o contraseña incorrectos");
}else{
    $return = Array('ok' => FALSE, 'msg' => $validacion->getValidacion());
};


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);


?>