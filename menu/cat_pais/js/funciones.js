$(document).ready(inicioEventos);

function inicioEventos(){
	
    listapais();
    $('#grabar').submit(grabapais);
    $('.nuevo_pais').click(limpiaCampos)

    $('.resultados').on('click','.ingreso_depto', modal_ingreso_depto);
	$('.resultados').on('click','.actualizar_pais', actualiza_pais);
    $('.resultados_depto').on('click','.ingreso_municipio', modal_ingreso_municipio);
    $('#grabar_depto').submit(grabadepto); 
    $('#grabar_municipio').submit(grabamunicipio);
	
}

function listapais(){

	var pais = [];
    
    $.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:"application/x-www-form-urlencoded",
        url:"php/Pais.php",
        data:"tipo=read",
        success: function(Data){

			
            for(var x=0;x<Data.length;x++){
                pais.push({"id":Data[x]["id"],"nombre":Data[x]["nombre"], "accion":"<a href='' class='actualizar_pais' id='"+Data[x]["id"]+"' nombre='"+Data[x]["nombre"]+"'><i class='fa fa-edit' title='editar' ></i></a> | <a href='' class='ingreso_depto' id='"+Data[x]["id"]+"' nombre='"+Data[x]["nombre"]+"'><i class='fa fa-map' title='Asigna Depto'></i></a>"})	
			}

            $('#registros').bootstrapTable('destroy');
            $('#registros').bootstrapTable({data: pais})

        }
    })
    
}

function listadepto(){

	var departamento = [];
	var id_pais = $('#id_pais').val();
    
    $.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:"application/x-www-form-urlencoded",
        url:"php/Departamento.php",
        data:"tipo=read" + "&id_pais="+id_pais,
        success: function(Data){

			
            for(var x=0;x<Data.length;x++){
                departamento.push({"id":Data[x]["id"],"nombre":Data[x]["nombre"], "id_pais":Data[x]["id_pais"], "accion":"<a href='' class='actualizar_pais' id='"+Data[x]["id"]+"' nombre='"+Data[x]["nombre"]+"'><i class='fa fa-edit' title='editar' ></i></a> | <a href='' class='ingreso_municipio' id='"+Data[x]["id"]+"' nombre='"+Data[x]["nombre"]+"' id_pais='"+Data[x]["id_pais"]+"'><i class='fa fa-map' title='Asigna Municipio'></i></a>"})	
			}

            $('#resultados_depto').bootstrapTable('destroy');
            $('#resultados_depto').bootstrapTable({data: departamento})

        }
    })
    
}

function listamunicipios(){

	var municipio = [];
	var id_pais = $('#id_paisdepto').val();
    var id_departamento = $('#id_departamento').val();
    
    $.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:"application/x-www-form-urlencoded",
        url:"php/Municipio.php",
        data:"tipo=read" + "&id_pais="+id_pais + "&id_departamento="+id_departamento,
        success: function(Data){

			console.log(Data);
            for(var x=0;x<Data.length;x++){
                municipio.push({"id":Data[x]["id"],"nombre":Data[x]["nombre"], "id_pais":Data[x]["id_pais"], "accion":"<a href='' class='actualizar_pais' id='"+Data[x]["id"]+"' nombre='"+Data[x]["nombre"]+"'><i class='fa fa-edit' title='editar' ></i></a>"})	
			}

            $('#resultados_municipio').bootstrapTable('destroy');
            $('#resultados_municipio').bootstrapTable({data: municipio})

        }
    })
    
    
    //$('.resultados_municipio').load('php/lista_municipio.php',{'id_pais':id_pais,'id_departamento':id_departamento});
    
}

function actualiza_pais(event){
	event.preventDefault();
	$('#id_grabar_pais').val($(this).attr('id'))
	$('#nombre_pais').val($(this).attr('nombre'))
	$('#modal_add_pais').modal('show');
}

function grabapais(event){
	event.preventDefault();
	
	var nombre_pais = $('#nombre_pais').val();
	var id = $('#id_grabar_pais').val();
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/Pais.php",
		data:"tipo=create" + "&id="+id + "&nombre_pais="+nombre_pais,
		beforeSend: function(){
			alertify.info("Grabando registro...");
		},
		success: function(Data){

			console.log(Data);
                    
			$('.alertify-log').remove();
			
			if(Data.ok===true){
				alertify.success(Data.msg);
				listapais();
			}else if(Data.ok===false){
				alertify.error(Data.msg);
			}
		},
		error: function(){
			$('.alertify-log').remove();
			alertify.error("Error de conexion");
		}
	
	})
	
}


function modal_ingreso_depto(event){
    event.preventDefault();
    
    $('#modal_add_departamento').modal('show');
    $('#id_pais').val($(this).attr('id'));
    
    listadepto();
    
}

function grabadepto(event){
    event.preventDefault();
    
    var id_pais = $('#id_pais').val();
    var nombre_depto = $('#nombre_departamento').val();
    
    
    $.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/grabar_depto.php",
		data:"id_pais="+id_pais + '&nombre_depto='+nombre_depto,
		beforeSend: function(){
			alertify.info("Grabando registro...");
		},
		success: function(Data){
                    
			$('.alertify-log').remove();
			
			if(Data.ok==true){
				alertify.success(Data.msg);
				listadepto();
			}else if(Data.ok==false){
				alertify.error(Data.msg);
			}
		},
		error: function(){
			$('.alertify-log').remove();
			alertify.error("Error de conexion");
		}
	})   
}


function modal_ingreso_municipio(event){
    event.preventDefault();
    
    $('#modal_add_municipio').modal('show');
    $('#id_paisdepto').val($(this).attr('id_pais'));
    $('#id_departamento').val($(this).attr('id'));
    
    listamunicipios();
    
}


function grabamunicipio(event){
    event.preventDefault();
    
    var id_pais = $('#id_paisdepto').val();
    var id_departamento = $('#id_departamento').val();
    var nombre_municipio = $('#nombre_municipio').val();
    
    $.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/grabar_municipio.php",
		data:"id_pais="+id_pais + '&id_depto='+id_departamento + '&nombre_municipio='+nombre_municipio ,
		beforeSend: function(){
			alertify.info("Grabando registro...");
		},
		success: function(Data){
                    
			$('.alertify-log').remove();
			
			if(Data.ok==true){
				alertify.success(Data.msg);
				listamunicipios();
			}else if(Data.ok==false){
				alertify.error(Data.msg);
			}
		},
		error: function(){
			$('.alertify-log').remove();
			alertify.error("Error de conexion");
		}
	})
    
}

function limpiaCampos(){
	$('#id_grabar_pais').val('');
	$('#nombre_pais').val('');
}