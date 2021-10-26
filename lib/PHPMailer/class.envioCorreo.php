<?php

include __DIR__.'/class.phpmailer.php';
include __DIR__.'/class.smtp.php';


class EnvioCorreo{

    private $correoDestino;
    private $asunto;
    private $mensaje;

    function __construct($correoDestino, $asunto, $mensaje){
        $this->correoDestino = $correoDestino;
        $this->asunto = $asunto;
        $this->mensaje = $mensaje;
    }
    
    function envioMensaje($conexionPHPMailer){

        $mail = $conexionPHPMailer;
        $mensaje = '<div align="center"><table cellspacing="0" bgcolor="#f2f2f2" width="393px"><tbody><tr><td><img src="../img/encabezado_mail.jpg"></td></tr>';
        $mensaje = $mensaje.$this->mensaje;
        $mensaje = $mensaje.'<tr><td><img src="../img/footer_mail.jpg"></td></tr></tbody></table></div>';
        
        //$mensaje = $mensaje.'<div width="393px" height="206px"  style="background-image: url('."'../img/logo.png'".'); width: 393px; height: 206px; background-repeat: no-repeat"></div>';
        

        $mail->IsSMTP(); 

        //Sustituye (ServidorDeCorreoSMTP)  por el host de tu servidor de correo SMTP
        $mail->Host = "smtp.gmail.com";		
        $mail->Port       = 465;  
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl"; 
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        
        //Sustituye  ( CuentaDeEnvio )  por la cuenta desde la que deseas enviar por ejem. prueba@domitienda.com  
        $mail->From     = "mario22121985@gmail.com";
        $mail->FromName = "Followbuild";
        $mail->Subject  = $this->asunto;
        $mail->AltBody  = "Leer"; 
        $mail->MsgHTML($mensaje);

        // Sustituye  (CuentaDestino )  por la cuenta a la que deseas enviar por ejem. usuario@destino.com  
        $mail->AddAddress($this->correoDestino,'');
        $mail->SMTPAuth = true;

        // Sustituye (CuentaDeEnvio )  por la misma cuenta que usaste en la parte superior en este caso  prueba@midominio.com  y sustituye (ContraseñaDeEnvio)  por la contraseña que tenga dicha cuenta 
        $mail->Username = "mario22121985@gmail.com";
        $mail->Password = "Mrme22121985.";
        $mail->Send();
    
    }
    
    function envioMensajeAdjunto($conexionPHPMailer, $adjunto){

        $mail = $conexionPHPMailer;
        $mensaje = '<div align="center"><table cellspacing="0" bgcolor="#f2f2f2" width="393px"><tbody><tr><td><img src="../img/encabezado_mail.jpg"></td></tr>';
        $mensaje = $mensaje.$this->mensaje;
        $mensaje = $mensaje.'<tr><td><img src="../img/footer_mail.jpg"></td></tr></tbody></table></div>';
        
        //$mensaje = $mensaje.'<div width="393px" height="206px"  style="background-image: url('."'../img/logo.png'".'); width: 393px; height: 206px; background-repeat: no-repeat"></div>';
        

        $mail->IsSMTP(); 

        //Sustituye (ServidorDeCorreoSMTP)  por el host de tu servidor de correo SMTP
        $mail->Host = "smtp.gmail.com";		
        $mail->Port       = 465;  
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl"; 
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        
        //Sustituye  ( CuentaDeEnvio )  por la cuenta desde la que deseas enviar por ejem. prueba@domitienda.com  
        $mail->From     = "mario22121985@gmail.com";
        $mail->FromName = "Followbuild";
        $mail->Subject  = $this->asunto;
        $mail->AltBody  = "Leer"; 
        $mail->MsgHTML($mensaje);
        $mail->AddStringAttachment($adjunto, 'Proyecto.pdf', 'base64', 'application/pdf');// attachment

        // Sustituye  (CuentaDestino )  por la cuenta a la que deseas enviar por ejem. usuario@destino.com  
        $mail->AddAddress($this->correoDestino,'');
        $mail->SMTPAuth = true;

        // Sustituye (CuentaDeEnvio )  por la misma cuenta que usaste en la parte superior en este caso  prueba@midominio.com  y sustituye (ContraseñaDeEnvio)  por la contraseña que tenga dicha cuenta 
        $mail->Username = "mario22121985@gmail.com";
        $mail->Password = "Mrme22121985.";
        $mail->Send();
    
    }

}


?>