$(document).ready(inicioEventos);

function inicioEventos(){
	
	listaRegistro();

	$('.nuevo').click(function(){
		$('#codigo').removeAttr('disabled');
		limpiarCampos();
	})
	$('#grabar').submit(grabaRegistro);
	//$('.resultados').on("click",".eliminar",eliminaCliente);	
	$('.resultados').on('click','.actualizar', recuperaRegistro);
	  
}



function listaRegistro(){	
	
	var registros = [];
    
    $.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:"application/x-www-form-urlencoded",
		url:"php/Producto.php",
		data: "tipo=read",
        success: function(Data){
			
            for(var x=0;x<Data.length;x++){
                registros.push({"id":Data[x]["id"], "codigo":Data[x]["codigo"], "nombre":Data[x]["nombre"], "descripcion":Data[x]["descripcion"],  "precio":Data[x]['precio'], "accion":"<a href='' class='actualizar' id='"+Data[x]['id']+"', codigo='"+Data[x]["codigo"]+"', nombre='"+Data[x]["nombre"]+"', descripcion='"+Data[x]["descripcion"]+"', precio='"+Data[x]["precio"]+"'><i class='fa fa-edit' title='editar'></i> </a>"})	
			}

            $('#registros').bootstrapTable('destroy');
            $('#registros').bootstrapTable({data: registros})

        }
    })

}



function grabaRegistro(event){
	event.preventDefault();
	
	var codigo = $('#codigo').val();
	var nombre = $('#nombre').val();
	var descripcion = $('#descripcion').val();
	var precio = $('#precio').val();
	
	
	var formData = new FormData($("#grabar")[0]);
	formData.append("tipo","create");
	formData.append("codigo",codigo);
	formData.append("nombre",nombre);
	formData.append("descripcion",descripcion);
	formData.append("precio",precio);

	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:false,
		processData:false,
		url:"php/Producto.php",
		data:formData,
		beforeSend: function(){
			alertify.info('grabando registro...');
		},
		success: function(Data){

			console.log(Data);
			
			$('.alertify-log').remove();
			
			if(Data.ok == true){
			  listaRegistro();
			  limpiarCampos();
			  $('#modal_add').modal('hide');
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

function recuperaRegistro(event){
	event.preventDefault();


	$('#codigo').val($(this).attr('codigo'));
	$('#nombre').val($(this).attr('nombre'));
	$('#descripcion').val($(this).attr('descripcion'))
	$('#precio').val($(this).attr('precio'));
	$('#codigo').attr('disabled',true)
	$('#modal_add').modal('show');
}


function limpiarCampos(){
	$('#codigo').val('');
	$('#nombre').val('');
	$('#descripcion').val('');
	$('#precio').val('');
	
}
