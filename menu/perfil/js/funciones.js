$(document).ready(inicioEventos);

function inicioEventos(){

    $('#actualizarPerfil').submit(actualizarPerfil);
   
}

function actualizarPerfil(event){
    event.preventDefault();

    let id = $('#idusuario').val();
    let correo = $('#correo').val();
    let usuario = $('#usuario').val();
    let pass_actual = $('#pass_actual').val();
    let new_pass = $('#new_pass').val();
    let conf_pass = $('#conf_pass').val();

    if(new_pass != conf_pass){
        alertify.info("contraseñas son distintas");
    }

    $.ajax({
        async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
        url:"php/actualizaPerfil.php",
        data: "id="+id + "&correo="+correo + "&usuario="+usuario + "&pass_actual="+pass_actual + "&new_pass="+new_pass,
        timeout: 0,
        beforeSend: function(){
            alertify.info("Actualizando perfil...");
        },
        success: function(Data){
            if(Data.ok === true){
                alertify.success("Actualizacion realizada correctamente");
            }else{
                alertify.error("Error al actualizar los datos");
            }
        },
        error: function(){
            alertify.error("Error de conexion");
        }
    })


}
