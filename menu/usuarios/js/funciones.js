$(document).ready(inicioEventos);

function inicioEventos(){

    obtieneArea();
    //listatipoproveedor();  
    //listaregimen();  
    //listarareaempresa();
    $('#registros').on('click','.edit', modalEdit);
    $('#registros').on('click','.permiso', modalPermiso);
    $('.permisos').on('click','.cambio_acceso', cambioAcceso);
    //$('#grabarProveedor').submit(grabarProveedor);
    $('#actualizaUsuario').submit(actualizaUsuario);

}

/*
function modalAddProveedor(event){
    event.preventDefault();

    $('#nit').val('');
    $('#nombre').val('');
    $('#modalAddProveedor').modal('show');
}
*/

function listaUsuarios(area){

    var usuarios = [];

    areas= (JSON.parse(area));
    
    $.ajax({
        async:true,
        type:"POST",
        dataType: "JSON",
        contentType: "application/x-www-form-urlencoded",
        url:"php/usuario.php",
        data: "",
        success: function(Data){

            for(var x=0;x<Data.length;x++){
                usuarios.push({"id":Data[x]["id"],"nombre":Data[x]["nombre"],"correo":Data[x]["correo"],"usuario":Data[x]["usuario"],"area":areas[parseInt(Data[x]["tipo"])] , "estado":Data[x]['estado'],"accion":"<a href='' class='edit' id='"+Data[x]["id"]+"' nombre='"+Data[x]["nombre"]+"' correo='"+Data[x]["correo"]+"' usuario='"+Data[x]['usuario']+"' area='"+Data[x]['tipo']+"' estado='"+Data[x]['estado']+"'><i class='fa fa-edit'></i> | </a> <a href='' class='bloqueo' id='"+Data[x]['id']+"'><i class='fa fa-lock'></i></a> | </a> <a href='' class='permiso' id='"+Data[x]['id']+"'><i class='fa fa-key'></i></a>"})
            }

            $('#registros').bootstrapTable('destroy');
            $('#registros').bootstrapTable({data: usuarios})

        },
        error: function(){    
            alertify.error('Error de conexion..');
        }
    })
}

function obtieneArea(){

    var area = []
    
    $.ajax({
        method: "GET",
        url:"https://www.aceiba.com.gt:4457/catalogos/AreaEmpresa",
        timeout: 0,
        success: function(Data){

            for(var x=0;x<Data.length;x++){
                area[parseInt(Data[x]["DEPARTAMENTO"])] = Data[x]["NOMBRE"];
                $('#editArea').append($("<option>", {
                    value: Data[x]["DEPARTAMENTO"],
                    text: Data[x]["NOMBRE"]
                }));
                
            }

            listaUsuarios(JSON.stringify(area));

        }
    })

}


function modalEdit(event){
    event.preventDefault();
    
    $('#editId').val($(this).attr('id'));
    $('#editUsuario').val($(this).attr('usuario'));
    $('#editNombre').val($(this).attr('nombre'));
    $('#editCorreo').val($(this).attr('correo'));   
    $('#editArea').val($(this).attr('area'));
    $('#editContrasena').val('');
    $('#editValidaContrasena').val('');
    $('#modalEdit').modal('show');
    
}



function actualizaUsuario(event){
    event.preventDefault();
    
    const id = $('#editId').val();
    const usuario = $('#editUsuario').val();
    const nombre = $('#editNombre').val().toUpperCase();
    const correo = $('#editCorreo').val().toUpperCase();
    const area = $('#editArea').val()
    const contrasena = $('#editContrasena').val(); 
    const valida_contrasena = $('#editValidaContrasena').val(); 

    if(contrasena != valida_contrasena){
        alertify.info("Las contraseñas son distintas");
        return false;
    }

    
    $.ajax({
        async:true,
        type:"POST",
        dataType: "JSON",
        contentType: "application/x-www-form-urlencoded",
        url:"php/updateUsuario.php",
        data: "id="+id + "&usuario="+usuario + "&nombre="+nombre + "&correo="+correo + "&area="+area + "&contrasena="+contrasena,
        success: function(Data){
            
            console.log(Data);

            if(Data["ok"]==true){
                alertify.success(Data["msg"]);
                obtieneArea();
                $('#modalEdit').modal('hide');
            }else{
                alertify.error(Data["msg"]);
            }
            
        },
        error: function(){
           alertify.error('Error de conexion'); 
        }
    })

}

function modalPermiso(event){
    event.preventDefault();

    var id_usuario = $(this).attr('id');
    

    $.ajax({
        async:true,
        type:"POST",
        dataType: "HTML",
        contentType: "application/x-www-form-urlencoded",
        url:"php/permiso.php",
        data: "id_usuario="+id_usuario,
        success: function(Data){
            var registros = JSON.parse(Data);
            var permisos = '';

            for(var n=0; n<registros['modulo'].length; n++){
                
                //console.log(registros['modulo'][n]['nombre']); 
                //console.log( (registros['modulo'][n]['acceso']).length);
                var accesos = '<ul style="list-style:none">';

                for(var i=0; i<(registros['modulo'][n]['acceso'].length); i++ ){
                    //console.log(registros['modulo'][n]['acceso'][i]);

                    if(registros['modulo'][n]['acceso'][i]['permiso'] === false){
                        accesos = accesos + '<li><div class="form-check form-switch"><input class="form-check-input cambio_acceso" id_usuario="'+id_usuario+'"  id_acceso="'+registros['modulo'][n]['acceso'][i]['id_acceso']+'" type="checkbox"><label class="form-check-label">'+registros['modulo'][n]['acceso'][i]['nombre']+'</label></div></li>';
                    }else{
                        accesos = accesos + '<li><div class="form-check form-switch"><input class="form-check-input cambio_acceso" id_usuario="'+id_usuario+'" id_acceso="'+registros['modulo'][n]['acceso'][i]['id_acceso']+'" type="checkbox" checked><label class="form-check-label">'+registros['modulo'][n]['acceso'][i]['nombre']+'</label></div></li>';
                    }
                    
                }
                accesos = accesos + '</ul>';

                permisos = permisos + '<div class="card"><div class="card-header"><strong class="card-title">'+registros['modulo'][n]['nombre']+'</strong></div><div class="card-body">'+accesos+'</div></div>';
                
            }
            
            $('.permisos').html(permisos);
            
        },
        error: function(){
           alertify.error('Error de conexion'); 
        }
    })


    $('#modalPermiso').modal('show');

}

function cambioAcceso(){

    
    if( $(this).prop('checked') ){
        var permiso = 'add'
    }else{
        var permiso = 'remove';
    }

    let id_acceso = $(this).attr('id_acceso');
    let id_usuario = $(this).attr('id_usuario');

    $.ajax({
        async:true,
        type:"POST",
        dataType: "JSON",
        contentType: "application/x-www-form-urlencoded",
        url:"php/updatePermiso.php",
        data: "permiso="+permiso + "&id_acceso="+id_acceso + "&id_usuario="+id_usuario,
        success: function(Data){
            
            console.log(Data);

            if(Data["ok"]==true){
                alertify.success(Data["msg"]);
            }else{
                alertify.error(Data["msg"]);
            }
            
        },
        error: function(){
           alertify.error('Error de conexion'); 
        }
    })

    
}