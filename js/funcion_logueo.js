$(document).ready(inicioEventos);

function inicioEventos(){
    $('#login').submit(validaAcceso);
    $('#solicitudAcceso').click(solicitudAcceso);
    $('#envioSolicitud').submit(envioSolicitud);
    $('#recuperaAcceso').click(recuperaAcceso);
    $('#cambioAcceso').submit(cambioAcceso);
    $('#validaToken').submit(validaToken);
}

function validaAcceso(event){
    event.preventDefault();

    let usuario = $('#usuario').val();
    let contrasena = $('#contrasena').val();
   
    $.ajax({
        async:true,
        type:"POST",
        dataType:"JSON",
        contentType:"application/x-www-form-urlencoded",
        url:"php/validaLogin.php",
        data:"usuario="+usuario + "&contrasena="+contrasena,
        beforeSend: function(){
            alertify.info('validando credenciales...')
        },
        success: function(Data){
            
            $('.alertify-log').remove();
            if(Data.ok == true){
                alertify.success(Data.msg);
                window.location="token.html";
            }else if(Data.ok == false){
                alertify.error(Data.msg);
            }
        },
        error: function(){
            $('.alertify-log').remove();
            alertify.error("Error de conexion...");
        }
    })

}

function solicitudAcceso(event){
    event.preventDefault();
    $('#nombre').val('');
    $('#email').val('');
    $('#modalSolicitudAcceso').modal('show');
}

function envioSolicitud(event){
    event.preventDefault();

    let nombre = $('#nombre').val();
    let correo = $('#email').val();

    $.ajax({
        async:true,
        type: "POST",
        dataType: "JSON",
        contentType: "application/x-www-form-urlencoded",
        url:"php/nuevoUsuario.php",
        data: "nombre="+nombre + "&correo="+correo,
        beforeSend: function(){
            alertify.info("Enviando solicitud...");
        },
        success: function(Data){
            $('.alertify-log').remove();

            if(Data.ok == true){
                alertify.success(Data.msg);
            }else if(Data.ok == false){
                alertify.error(Data.msg);
            }else{
                alertify.error(Data.msg);
            }

        },
        error:function(){
            $('.alertify-log').remove();
            alertify.error("Error de conexion...");

        }
    })

}

function recuperaAcceso(){
    $('#email_recupera').val('');
    $('#modalRecuperaAcceso').modal('show');
}

function cambioAcceso(event){
    event.preventDefault();

    let correo = $('#email_recupera').val();

    $.ajax({
        async:true,
        type:"POST",
        dataType:"JSON",
        contentType:"application/x-www-form-urlencoded",
        url:"php/cambioContrasena.php",
        data:"correo="+correo,
        beforeSend: function(){
            alertify.info('Enviando correo de recuperacion...');
        },
        success: function(Data){
            $('.alertify-log').remove();

            console.log(Data);

            if(Data.ok === true){
                alertify.success(Data.msg);
            }else if(Data.ok === false){
                alertify.error(Data.msg)
            }else{
                alertify.error(Data);
            }
            
        },
        error: function(){
            $('.alertify-log').remove();
            alertify.error('Error de conexion...');

        } 
    })

}

function validaToken(event){
    event.preventDefault();

    let token = $('#token').val();

    $.ajax({
        async:true,
        type:"POST",
        dataType:"JSON",
        contentType:"application/x-www-form-urlencoded",
        url:"php/validaToken.php",
        data:"token="+token,
        beforeSend: function(){
            alertify.info('validando...');
        },
        success: function(Data){
            $('.alertify-log').remove();


            if(Data.ok === true){
                alertify.success(Data.msg);
                window.location="menu/index.php";
            }else if(Data.ok === false){
                alertify.error(Data.msg)
            }else{
                alertify.error(Data);
            }
            
        },
        error: function(){
            $('.alertify-log').remove();
            alertify.error('Error de conexion...');

        } 
    })

}