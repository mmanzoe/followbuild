$(document).ready(inicioEventos);

function inicioEventos(){
	
	listaRegistro();
	listaTipoPlaca();
	listaTipoMaquinaria();
	listaMarca();
	$('#marca').change(listaLinea);
	$('.nuevo').click(function(){
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
		url:"php/Maquinaria.php",
		data: "tipo=read",
        success: function(Data){
			
            for(var x=0;x<Data.length;x++){
                registros.push({"id":Data[x]["id"], "tipo_placa":Data[x]["tipo_placa"], "placa":Data[x]["placa"], "tipo":Data[x]["tipo"], "marca":Data[x]["marca"], "linea":Data[x]["linea"], "modelo":Data[x]["modelo"], "descripcion":Data[x]['descripcion'], "accion":"<a href='' class='actualizar' id='"+Data[x]['id']+"', tipo_placa='"+Data[x]["id_tipo_placa"]+"', placa='"+Data[x]["placa"]+"', tipo='"+Data[x]["id_tipo"]+"', marca='"+Data[x]["id_marca"]+"', linea= '"+Data[x]["id_linea"]+"', modelo='"+Data[x]["modelo"]+"', descripcion='"+Data[x]['descripcion']+"'><i class='fa fa-edit' title='editar'></i> </a>"})	
			}

            $('#registros').bootstrapTable('destroy');
            $('#registros').bootstrapTable({data: registros})

        }
    })

}

function listaTipoMaquinaria(){

	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:'application/x-www-form-url-encoded',
		url:"php/TipoMaquinaria.php",
		success: function(Data){

			for(var n=0; n<Data.length; n++){
				
				$('#tipo_maquinaria').append('<option value="'+Data[n]['id']+'">'+Data[n]['nombre']+'</option>')
			}
			
		},
		error: function(){
			$('.alertify-log-info').remove();
			alertify.error('error de conexion');
		}
	});

}

function listaMarca(){

	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:'application/x-www-form-url-encoded',
		url:"php/Marca.php",
		success: function(Data){

			$('#marca').append('<option disabled selected>SELECCIONE</option>');
			for(var n=0; n<Data.length; n++){
				
				$('#marca').append('<option value="'+Data[n]['id']+'">'+Data[n]['nombre']+'</option>')
			}
			
		},
		error: function(){
			$('.alertify-log-info').remove();
			alertify.error('error de conexion');
		}
	});

}

function listaLinea(){

	var marca = $('#marca').val();
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:"application/x-www-form-urlencoded",
		url:"php/Linea.php",
		data: "marca="+marca,
		success: function(Data){

			$('#linea').empty();

			for(var n=0; n<Data.length; n++){
				
				$('#linea').append('<option value="'+Data[n]['id']+'">'+Data[n]['nombre']+'</option>')
			}
			
		},
		error: function(){
			$('.alertify-log-info').remove();
			alertify.error('error de conexion');
		}
	});

}

function listaTipoPlaca(){

	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:'application/x-www-form-url-encoded',
		url:"php/TipoPlaca.php",
		success: function(Data){

			for(var n=0; n<Data.length; n++){
				
				$('#tipo_placa').append('<option value="'+Data[n]['id']+'">'+Data[n]['tipo']+'</option>');
			}
			
		},
		error: function(){
			$('.alertify-log-info').remove();
			alertify.error('error de conexion');
		}
	});

}

function grabaRegistro(event){
	event.preventDefault();
	
	var tipomaquinaria = $('#tipo_maquinaria').val();
	var tipoplaca = $('#tipo_placa').val();
	var placa = $('#placa').val();
	var marca = $('#marca').val();
	var linea = $('#linea').val();
	var modelo = $('#modelo').val();
	var descripcion = $('#descripcion').val();

	
	var formData = new FormData($("#grabar")[0]);
	formData.append("tipo","create");
	formData.append("tipomaquinaria",tipomaquinaria);
	formData.append("tipoplaca",tipoplaca);
	formData.append("placa",placa);
	formData.append("marca",marca);
	formData.append("linea",linea);
	formData.append("modelo",modelo);
	formData.append("descripcion",descripcion);
	
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:false,
		processData:false,
		url:"php/Maquinaria.php",
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

/*
function eliminaCliente(event){
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
*/

function recuperaRegistro(event){
	event.preventDefault();


	$('#tipo_maquinaria').val($(this).attr('tipo'));
	$('#tipo_placa').val($(this).attr('tipo_placa'));
	$('#placa').val($(this).attr('placa'))
	$('#marca').val($(this).attr('marca'));
	$('#linea').val($(this).attr('linea'));
	$('#modelo').val($(this).attr('modelo'));
	$('#descripcion').val($(this).attr('descripcion'));
	
	$('#modal_add').modal('show');
}

/*
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
*/


function limpiarCampos(){
	$('#tipo_maquinaria').val(1);
	$('#tipo_placa').val(1);
	$('#placa').val('');
	$('#marca').val(0);
	$('#modelo').val('');
	$('#descripcion').val('');
	
}
