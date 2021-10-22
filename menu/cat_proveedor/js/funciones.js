$(document).ready(inicioEventos);

function inicioEventos(){
	
	listaProveedor();
    cargatipocontribuyente();
	$('#grabar').submit(grabaProveedor);
	$('#actualizar').submit(actualizaProveedor);
	$('.resultados').on('click','.actualizar', recuperaProveedor);
	$('.resultados').on('click','.muestra_rtu', muestra_rtu);
	$('.resultados').on('click','.muestra_contacto', muestra_contacto);
	
	
}

function cargatipocontribuyente(){

	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:"application/www-form-urlencoded",
        url:"php/tipo_contribuyente.php",
        
        success: function(Data){

            for(var x=0;x<Data.length;x++){
				$('#tipo_contribuyente').prepend("<option value='"+Data[x]["id"]+"'>"+Data[x]["nombre"]+"</option>");
                $('#edit_tipo_contribuyente').prepend("<option value='"+Data[x]["id"]+"'>"+Data[x]["nombre"]+"</option>");
			}
			
        }
    })

}

function listaProveedor(){

	var proveedores = [];
    
    $.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:"application/www-form-urlencoded",
        url:"php/Proveedor.php",
        
        success: function(Data){

            for(var x=0;x<Data.length;x++){
                proveedores.push({"nit":Data[x]["nit"],"contribuyente":Data[x]["contribuyente"],"empresa":Data[x]["nombre"],"direccion":Data[x]["direccion"],"credito":Data[x]["credito"],"rtu":Data[x]["rtu"],"contacto":Data[x]["nombre_contacto"],"accion":"<a href='' class='actualizar' idregistro='"+Data[x]["id"]+"' nit='"+Data[x]["nit"]+"' contribuyente='' nombre='"+Data[x]["nombre"]+"' direccion='"+Data[x]["direccion"]+"' credito='"+Data[x]["credito"]+"' tel_proveedor='"+Data[x]["tel_proveedor"]+"' email_proveedor='"+Data[x]["email_proveedor"]+"' tipo_contribuyente='"+Data[x]["contribuyente"]+" ><i class='fa fa-edit' title='editar' ></i> </a> | <a href='' class='muestra_contacto' email_proveedor='"+Data[x]["email_proveedor"]+"' contacto='"+Data[x]["contacto"]+"' tel_contacto='"+Data[x]["tel_contacto"]+"' email_contacto='"+Data[x]["email_contacto"]+"'><i class='fa fa-address-book' title='contacto' ></i></a> | </a> <a href='' class='muestra_rtu' archivo='"+Data[x]["rtu"]+"' ><i class='fa fa-file-pdf' title='rtu'></i></a>"})	
			}

            $('#registros').bootstrapTable('destroy');
            $('#registros').bootstrapTable({data: proveedores})

        }
    })

	
}


function grabaProveedor(event){
	event.preventDefault();
	
	if($('#file').val()==""){
            var confirmar = confirm("Grabar proveedor sin archivo RTU");
            
            if(confirmar == false){
                return false;
            }
        
            
        }
        
	var nit = $('#nit').val();	
	nit = nit.replace("-","");
	nit = nit.replace(" ","");
	
        
	
	var formData = new FormData($("#grabar")[0]);
	formData.append("tipo","create");
	formData.append("nit",nit);
    formData.append("tipo_contribuyente", $('#tipo_contribuyente').val());
	formData.append("nombre",$('#nombre').val());
	formData.append("direccion",$('#direccion').val());
	formData.append("tel_proveedor",$('#tel_proveedor').val());
	formData.append("dias_credito",$('#dias_credito').val());
	formData.append("email_proveedor",$('#email_proveedor').val());
	formData.append("contacto",$('#contacto').val());
	formData.append("tel_contacto",$('#tel_contacto').val());
	formData.append("email_contacto",$('#email_contacto').val());

	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:false,
		processData:false,
		url:"php/grabar.php",
		data: formData,
		beforeSend: function(){
			alertify.info('grabando registro...');
		},
		success: function(Data){

			console.log(Data);
			
			$('.alertify-log').remove();
			
			if(Data.ok === true){
				listaProveedor();
				$('#modal_add_proveedor').modal('hide');
				alertify.success(Data.msg);
				limpiaCampos();
			}else if(Data.ok === false){
				alertify.danger(Data.msg);
		    }else{
				alertify.danger(Data.msg);
			}
			
		},
		error: function(){
			$('.alertify-log').remove();
			alertify.error('error de conexion');
		}
	});
	
}

function muestra_rtu(event){
	event.preventDefault();
	
	var ruta = $(this).attr('archivo');	
	$('#despliega_rtu').html('');
	
	if(ruta != ''){
		$('#despliega_rtu').append('<embed src="archivo/'+ruta+'" width="100%" height="400" id="pdf">');
	}else{
		$('#despliega_rtu').html('NO HAY ARCHIVO CARGADO!');
	}
	
	$('#modal_despliega_rtu').modal('show');
	
}

function recuperaProveedor(event){
	event.preventDefault();
	
	$('#idregistro').val($(this).attr('idregistro'));
	$('#edit_nit').val($(this).attr('nit'));
    $('#edit_tipo_contribuyente').val($(this).attr('tipo_contribuyente'));
	$('#edit_nombre').val($(this).attr('nombre'));
	$('#edit_direccion').val($(this).attr('direccion'));
	$('#edit_tel_proveedor').val($(this).attr('tel_proveedor'));
	$('#edit_dias_credito').val($(this).attr('credito'));
	$('#edit_email_proveedor').val($(this).attr('email_proveedor'));
	$('#edit_contacto').val($(this).attr('contacto'));
	$('#edit_tel_contacto').val($(this).attr('tel_contacto'));
	$('#edit_email_contacto').val($(this).attr('email_contacto'));

	$('#modal_edit_proveedor').modal('show');
	
}

function actualizaProveedor(event){
	event.preventDefault();
	
	var nit = $('#edit_nit').val();
    var tipo_contribuyente = $('#edit_tipo_contribuyente').val();
	var nombre = $('#edit_nombre').val();
	var direccion = $('#edit_direccion').val();
	var tel_proveedor = $('#edit_tel_proveedor').val();
	var dias_credito = $('#edit_dias_credito').val();
	var email_proveedor = $('#edit_email_proveedor').val();
	var contacto = $('#edit_contacto').val();
	var tel_contacto = $('#edit_tel_contacto').val();
	var email_contacto = $('#edit_email_contacto').val();
	
	nit = nit.replace("-","");
	nit = nit.replace(" ","");	
	
	var formData = new FormData($("#actualizar")[0]);
	formData.append("tipo","update");
	formData.append("idregistro",$('#idregistro').val());
	formData.append("nit",nit);
    formData.append("tipo_contribuyente", tipo_contribuyente);
	formData.append("nombre",$('#edit_nombre').val());
	formData.append("direccion",$('#edit_direccion').val());
	formData.append("tel_proveedor",$('#edit_tel_proveedor').val());
	formData.append("dias_credito",$('#edit_dias_credito').val());
	formData.append("email_proveedor",$('#edit_email_proveedor').val());
	formData.append("contacto",$('#edit_contacto').val());
	formData.append("tel_contacto",$('#edit_tel_contacto').val());
	formData.append("email_contacto",$('#edit_email_contacto').val());
	
		
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:false,
		processData:false,
		url:"php/grabar.php",
		data:formData,
		beforeSend: function(){
			alertify.info('actualizando registro');
		},
		success: function(Data){
			console.log(Data);
			
			$('.alertify-log').remove();
			
			if(Data.ok == true){
			  listaProveedor();
			  $('#modal_edit_contacto').modal('hide');
			  alertify.success(Data.msg);
			  limpiaCampos();
			}else if(Data.ok == false){
			  alertify.danger(Data.msg);
		    }
			
		},
		error: function(){
			$('.alertify-log').remove();
			alertify.error('error de conexion');
		}
	});
	
}

function muestra_contacto(event){
	event.preventDefault();

	$('#modal_contacto').modal('show');

	$('.actualizar_contacto').html('<ul><li><span class="fa fa-2x fa-envelope-square"></span> '+$(this).attr('email_proveedor')+'</li><li><span class="fa fa-2x fa-user"></span> '+$(this).attr('contacto')+'</li><li><span class="fa fa-2x fa-mobile-alt"></span> '+$(this).attr('tel_contacto')+'</li><li><span class="fa fa-2x fa-envelope-square"></span> '+$(this).attr('email_contacto')+'</li></ul>')


}

function limpiaCampos(){
	
	$('#nit').val('');
	$('#nombre').val('');
	$('#direccion').val('');
	$('#tel_proveedor').val('');
	$('#dias_credito').val('');
	$('#email_proveedor').val('');
	$('#contacto').val('');
	$('#tel_contacto').val('');
	$('#email_contacto').val('');
	
}
