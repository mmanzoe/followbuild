<?php

require('class.validaciones.php');
require('../lib/PHPMailer/class.envioCorreo.php');

$correo = $_REQUEST['correo'];
$return = Array('ok'=>TRUE);

$validaciones = new Validaciones;

//valida que el correo este registrado
if($validaciones->validaCorreo($correo) === true){
    
    $nuevoPass = $validaciones->generaContrasena();

    if($validaciones->actualizaContrasena($correo, $nuevoPass) === true){

        $mensaje = "
            <tr>
                <td align='center'><b>SOLICITUD RECUPERACION DE CONTRASENA</b></td>
            </tr>
            <tr>
                <td style='padding:20px'>A continuación se detalla el usuario y contraseña</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td style='padding-left:20px'>Usuario: ".$correo."</td>
            </tr>
            <tr>
                <td style='padding-left:20px'>Contrasena: ".$nuevoPass."</td>
            </tr>";

        $enviocorreo = new EnvioCorreo($correo, 'Acceso Sistema Facturas ', $mensaje); 
        $enviocorreo->envioMensaje(new PHPMailer());

        $return = Array('ok'=>TRUE, 'msg'=>'Nuevas credenciales enviadas por correo electronico');

    }else{
        $return = Array('ok'=>FALSE, 'msg'=>'Error al realizar la recuperacion, intentelo mas tarde!'); 
    }

}else{
    $return = Array('ok'=>FALSE, 'msg'=>'Correo electronico no registrado...');
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($return);


?>