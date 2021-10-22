$(document).ready(inicioEventos);

function inicioEventos(){
	
	$('#grabar').submit(grabaEmpresa);
	$('.resultados').on("click",".eliminar",eliminaEmpresa);
	listaEmpresa();
	$('.resultados').on('click','.actualizar', recuperaEmpresa);
	$('.resultados').on('click','.muestra_rtu', muestra_rtu);
	$('.resultados').on('click','.muestra_contacto', muestra_contacto);    
}



function listaEmpresa(){	
	
	var cliente = [];
    
    $.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:"application/x-www-form-urlencoded",
		url:"php/Empresa.php",
		data: "tipo=read",
        success: function(Data){

            for(var x=0;x<Data.length;x++){
                cliente.push({"nit":Data[x]["nit"], "razon_social":Data[x]["razon_social"], "nombre":Data[x]["nombre"], "direccion":Data[x]["direccion"], "telefono1":Data[x]["telefono1"], "telefono2":Data[x]["telefono2"], "accion":"<a href='' class='actualizar' idregistro='"+Data[x]["id"]+"' nit='"+Data[x]["nit"]+"' razon_social='"+Data[x]["razon_social"]+"' nombre='"+Data[x]["nombre"]+"' direccion='"+Data[x]["direccion"]+"' telefono1='"+Data[x]["telefono1"]+"' telefono2='"+Data[x]["telefono2"]+"' ><i class='fa fa-edit' title='editar'></i> </a> | <a href='' class='muestra_contacto' email_proveedor='"+Data[x]["email_proveedor"]+"' contacto='"+Data[x]["contacto"]+"' tel_contacto='"+Data[x]["tel_contacto"]+"' email_contacto='"+Data[x]["email_contacto"]+"' comentario='"+Data[x]["comentario"]+"'><i class='fa fa-address-book' title='contacto'></i></a> | <a href='' class='muestra_rtu' archivo='"+Data[x]["id"]+"'><i class='fa fa-file-pdf' title='rtu'></i></a>"})	
			}

            $('#registros').bootstrapTable('destroy');
            $('#registros').bootstrapTable({data: cliente})

        }
    })

}

function grabaEmpresa(event){
	event.preventDefault();
	
	var idregistro = $('#idregistro').val();
	var nombre = $('#nombre_c').val();
	var razon = $('#razon_s').val();
	var direccion = $('#direccion').val();
	var tel1 = $('#telefono1').val();
	var tel2 = $('#telefono2').val();
	var nit = $('#nit').val();
	var email = $('#email').val();
	var contacto = $('#contacto').val();
	var telcontacto = $('#tel_contacto').val();
	var comentario = $('#comentario').val();
	
	var formData = new FormData($("#grabar")[0]);
	formData.append("tipo","create");
	formData.append("idregistro",idregistro);
	formData.append("nombre",nombre);
	formData.append("razon",razon);
	formData.append("direccion",direccion);
	formData.append("tel1",tel1);
	formData.append("tel2",tel2);
	formData.append("nit",nit);
	formData.append("email",email);
	formData.append("contacto",contacto);
	formData.append("telcontacto",telcontacto);
	formData.append("comentario",comentario);
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:false,
		processData:false,
		url:"php/Cliente.php",
		data:formData,
		beforeSend: function(){
			alertify.info('grabando registro...');
		},
		success: function(Data){

			console.log(Data);
			
			$('.alertify-log').remove();
			
			if(Data.ok == true){
			  listaCliente();
			  limpiarCampos();
			  $('#modal_add_cliente').modal('hide');
			  alertify.success(Data.msg);
			}else if(Data.ok == false){
			  alertify.danger(Data.msg);
		    }
			
		},
		error: function(){
			$('.alertify-log-info').remove();
			alertify.error('error de conexion');
		}
	});
}

function eliminaEmpresa(event){
	event.preventDefault();
	
	var confirma = confirm('Esta seguro de eliminar el Cliente?');
	
	if(confirma != true){
		return true;
	}
	
	var id = ($(this).attr('idregistro'));
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/eliminar.php",
		data:"id="+id,
		beforeSend: function(){
			alertify.info('Eliminando registro...');
		},
		success: function(Data){
			$('.alertify-log').remove();
			
			if(Data.ok == true){
				alertify.success(Data.msg);
				listaCliente();
			}else{
			    alertify.danger(Data.msg);
			}
		},
		error: function(){
			$('.alertify-log').remove();
			alertify.error('Error de conexion');
		}
	})
	
}

function recuperaEmpresa(event){
	event.preventDefault();

	$('#idregistro').val($(this).attr('idregistro'));
	$('#nombre_c').val($(this).attr('nombre'));
	$('#razon_s').val($(this).attr('razon_social'))
	$('#direccion').val($(this).attr('direccion'));
	$('#telefono1').val($(this).attr('telefono1'));
	$('#telefono2').val($(this).attr('telefono2'));
	$('#nit').val($(this).attr('nit'));
	$('#email').val($(this).attr('email'));
	$('#contacto').val($(this).attr('contacto'));
	$('#tel_contacto').val($(this).attr('tel_contacto'));
	$('#email_contacto').val($(this).attr('email_contacto'));
	$('#comentario').val($(this).attr('comentario'));

	$('#modal_add_cliente').modal('show');
}

function muestra_rtu(event){
	event.preventDefault();
	
	var ruta = $(this).attr('archivo');	
	$('#despliega_rtu').html('');
	
	if(ruta != ''){
		$('#despliega_rtu').append('<embed src="archivo/'+ruta+'.pdf" width="100%" height="400" id="pdf">');
	}else{
		$('#despliega_rtu').html('NO HAY ARCHIVO CARGADO!');
	}
	
	$('#modal_despliega_rtu').modal('show');
	
}

function muestra_contacto(event){
	event.preventDefault();

	$('#modal_contacto').modal('show');

	$('.actualizar_contacto').html('<ul><li><span class="fa fa-2x fa-user"></span> '+$(this).attr('contacto')+'</li><li><span class="fa fa-2x fa-mobile-alt"></span> '+$(this).attr('tel_contacto')+'</li><li><span class="fa fa-2x fa-comments"></span> '+$(this).attr('comentario')+'</li></ul>')


}

function limpiarCampos(){
	
	$('#nombre_c').val('');
	$('#razon_s').val('');
	$('#direccion').val('');
	$('#telefono1').val('');
	$('#telefono2').val('');
	$('#email').val('');
	$('#contacto').val('');
	$('#tel_contacto').val('');
	$('#comentario').val('');
	$('#nit').val('');
	
}
