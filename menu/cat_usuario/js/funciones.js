$(document).ready(inicioEventos);

function inicioEventos(){
	listausuarios();
	cargapermisos();
	$('#grabar').submit(grabarusuario);
	$('#buscar_usuario').click(listausuarios);
	$('.resultados').on('click', '.activar', activausuario);
	$('.resultados').on('click', '.bloquear', bloquearusuario);
	$('.resultados').on('click', '.permiso', muestrapermisos);
	$('#grabapermiso').click(grabapermiso);
	$('.listapermisos').on('click', '.eliminapermiso', eliminapermiso);
	
	$( ".usuarios" ).trigger( "click" );
	
}

function listausuarios(){
	
	var busqueda = $('#nombre_busca').val();
	$('.resultados').load('php/listausuarios.php',{'busqueda':busqueda});
}


function grabarusuario(event){
	event.preventDefault();
	
	var nombre = $('#nombre').val();
	var correo = $('#correo').val();
	var usuario = $('#usuario').val();
	var password = $('#password').val();
	var passwordc = $('#passwordc').val();
	
	if(password != passwordc){
		alertify.danger('contraseñas ingresadas son distintas!!')
	}else{
		
		$.ajax({
			async:true,
			type:"POST",
			dataType:"JSON",
			contentType:"application/x-www-form-urlencoded",
			url:"php/grabarusuario.php",
			data:'nombre='+nombre + '&correo='+correo + '&usuario='+usuario + '&password='+password,
			beforeSend: function(){
				alertify.info('grabando usuario');
			},
			success: function(Data){
				$('.alertify-log').remove();
				
				if(Data.ok == true){
					alertify.success(Data.msg);
					listausuarios();
				}else if(Data.ok == false){
					alertify.error(Data.msg);
					listausuarios();
				}
				
			},
			error: function(){
				$('.alertify-log').remove();
				alertify.error('Error de conexion');
			}
		})
		
	}
	
}

function activausuario(event){
	event.preventDefault();
	
	var idregistro = $(this).attr('idregistro');	
	var confirmacion = confirm('Esta seguro de activar el usuario');
	
	if(confirmacion == true){
		
		$.ajax({
			async:true,
			type:"POST",
			dataType:"JSON",
			contentType:"application/x-www-form-urlencoded",
			url:"php/activarusuario.php",
			data:'idregistro='+idregistro,
			beforeSend: function(){
				alertify.info('activando usuario');
			},
			success: function(Data){
				$('.alertify-log').remove();
				
				if(Data.ok == true){
					alertify.success(Data.msg);
					listausuarios();
				}else if(Data.ok == false){
					alertify.error(Data.msg);
				}
				
			},
			error: function(){
				$('.alertify-log').remove();
				alertify.error('Error de conexion');
			}
		})	
	}
}

function bloquearusuario(event){
	event.preventDefault();
	
	var idregistro = $(this).attr('idregistro');	
	var confirmacion = confirm('Esta seguro de bloquear el usuario');
	
	if(confirmacion == true){
		
		$.ajax({
			async:true,
			type:"POST",
			dataType:"JSON",
			contentType:"application/x-www-form-urlencoded",
			url:"php/bloquearusuario.php",
			data:'idregistro='+idregistro,
			beforeSend: function(){
				alertify.info('bloqueando usuario');
			},
			success: function(Data){
				$('.alertify-log').remove();
				
				if(Data.ok == true){
					alertify.success(Data.msg);
					listausuarios();
				}else if(Data.ok == false){
					alertify.error(Data.msg);
				}
				
			},
			error: function(){
				$('.alertify-log').remove();
				alertify.error('Error de conexion');
			}
		})	
	}
}

function cargapermisos(){
	$('#permisos').load('php/cargapermisos.php');
}


function muestrapermisos(event){
	event.preventDefault();
	$('#idregistro').val($(this).attr('idregistro'));
	$('#modal-permiso').modal('show');
	listapermisousuario($(this).attr('idregistro'));
}


function listapermisousuario(usuario){
	$('.listapermisos').load('php/listapermisos.php',{'idregistro':usuario});
}


function grabapermiso(){
	
	var permiso = $('#permisos').val();
	var idregistro = $('#idregistro').val();
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/grabarpermiso.php",
		data:'permiso='+permiso + '&idregistro='+idregistro,
		beforeSend: function(){
			alertify.info('agregando permiso...');
		},
		success: function(Data){
			$('.alertify-log').remove();
			
			if(Data.ok == 'TRUE'){
				alertify.success(Data.msg);
				listapermisousuario(idregistro);
			}else if(Data.ok == 'EXISTE'){
				alertify.danger(Data.msg);
			}else if(Data.ok == 'FALSE'){
				alertify.error(Data.msg);
			}
		
		},
		error: function(){
			$('.alertify-log').remove();
		    alertify.error('Error de conexion');
		}
	})
	
}

function eliminapermiso(event){
	event.preventDefault();
	
	var valida = confirm('Esta seguro de quitar el permiso al usuario?');
	var idregistro = $(this).attr('idregistro');
	
	if(valida == true){
		
		$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/eliminapermiso.php",
		data:'idregistro='+idregistro,
		beforeSend: function(){
			alertify.info('eliminando permiso...');
		},
		success: function(Data){
			$('.alertify-log').remove();
			
			if(Data.ok == true){
				alertify.success(Data.msg);
				listapermisousuario(idregistro);
			}else if(Data.ok == false){
				alertify.error(Data.msg);
			}
		
		},
		error: function(){
			$('.alertify-log').remove();
		    alertify.error('Error de conexion');
		}
	})
		
	}
	
}


function limpiarcampos(){
	
	$('#nombre').val('');
	$('#correo').val('');
	$('#telefono').val('');
	$('#usuario').val('');
	$('#password').val('');
	$('#passwordc').val('');
}