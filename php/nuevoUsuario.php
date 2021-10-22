<?php
session_start();
require('class.validaciones.php');
require('class.nuevoUsuario.php');
require('../lib/PHPMailer/class.envioCorreo.php');

$return = Array('ok'=>TRUE);

$nombre = $_REQUEST['nombre'];
$correo = $_REQUEST['correo'];

$nuevoUsuario = new NuevoUsuario($nombre, $correo);

if($nuevoUsuario->getCreaUsuario() === true){

    $mensaje = "<table>
        <tbody background='../../img/fondo_correo.jpg'>
        <tr>
            <td>Usuario</td>
            <td>".$nuevoUsuario->getCorreo()."</td>
        </tr>
        <tr>
            <td>Password</td>
            <td>".$nuevoUsuario->getContrasena()."</td>
        </tr>
        </tbody>
    </table>";


    $enviocorreo = new EnvioCorreo($nuevoUsuario->getCorreo(),'Acceso Sistema Facturas ', $mensaje); 
    $enviocorreo->envioMensaje(new PHPMailer());

    $return = Array('ok'=>TRUE, 'msg'=>'Solicitud enviada correctamente a su correo electronico!');
    
}else if($nuevoUsuario->getCreaUsuario() === false){
    $return = Array('ok'=>FALSE, 'msg'=>'Error al enviar la solicitud, intentelo mas tarde...');
}else{
    $return = Array('ok'=>FALSE, 'msg'=>$nuevoUsuario->getEstado());
};


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);


?>