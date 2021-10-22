$(document).ready(inicioEventos);

function inicioEventos(){
	
	$('.modal-buscar-orden-compra').click(function(){
		$('.resultadoordencompra').html('');
	});
        
	$('.busca-ordencompra').click(listaOrdenCompra);
	$('.resultadoordencompra').on('click','.agregaordencompra',agregaordencompra);
	
	
	$('.busca-mpep').click(lista_mpep);
	$('.resultadompep').on('click','.agregaproducto', agregampep);
	
	$('#materia_prima').change(cargamedida);
	
	$('#agregar').submit(listaregistros);
	
	$('#listadoEnvio').on('click','.editar', actualizaregistro);
	$('#listadoEnvio').on('click','.elimina', eliminaregistro);
	$('#listadoEnvio').on('click','.agregarregistro', formagregaregistro);
	$('#inserta-registro-mpep').submit(insertaregistrofactura);

	
	$('#listadoEnvio').on('click','.trasladaorden', trasladarFactura);
	
	
}


function listaOrdenCompra(){
	
	var nombre_proveedor = $('#busca_nombre_proveedor_orden').val();
	$('.resultadoordencompra').load('php/lista_ordencompra.php',{'nombre_proveedor':nombre_proveedor});
	
}


function agregaordencompra(event){
	event.preventDefault();
	
	var ordencompra = $(this).attr('no_orden');
	var nombre_proveedor = $(this).attr('nombreproveedor');	
	var nit_proveedor = $(this).attr('nit');
	var credito = $(this).attr('credito');
	var tipo_orden = $(this).attr('tipoorden');
    var tipo_contribuyente = $(this).attr('tipo_contribuyente');
    var impuesto = $(this).attr('impuesto');
	var id_proyecto = $(this).attr('id_proyecto');
	var id_gasto_proyecto = $(this).attr('id_tipo_gasto');
	
    $('#orden_compra').val(ordencompra);
	$('#proveedor').val(nit_proveedor);
	$('#nombre_proveedor').val(nombre_proveedor);	
    $('#tipo_contribuyente').val(tipo_contribuyente);
    $('#impuesto').val(impuesto);
	$('#dias_credito').val(credito);
	$('#proyecto').val(id_proyecto);
	$('#tipo_gasto').val(id_gasto_proyecto);
	$('#modal-buscar-orden-compra').modal('hide');
	
	if(tipo_orden == 'MPEP'){
		$('#tipo_fac').val('MP');
	}else if(tipo_orden == 'EP'){
		$('#tipo_fac').val('EP');
	}else if(tipo_orden == 'SERVICIO'){
		$('#tipo_fac').val('SR');
	}else if(tipo_orden == 'SUMINISTRO'){
		$('#tipo_fac').val('SM');
	}else if(tipo_orden == 'ACTIVOFIJO'){
		$('#tipo_fac').val('AF');
	}
	
	//muestraform();
	
}


function listaProveedores(){
	
	var nombre_proveedor = $('#busca_nombre_proveedor').val();
	$('.resultadoproveedor').load('php/lista_proveedor.php',{'nombreproveedor':nombre_proveedor});
	
}


function agregaproveedor(event){
	event.preventDefault();
	
	var nit = $(this).attr('nit');	
	var nombre = $(this).attr('nombre');
	var credito = $(this).attr('credito');	
	$('#proveedor').val(nit);
	$('#nombre_proveedor').val(nombre);	
	$('#dias_credito').val(credito);
	$('#modal-buscar-proveedor').modal('hide');
	
}


function lista_mpep(){
	var nombre_mpep = $('#nombre_mpep').val();
	var tipo_fac = $('#tipo_fac').val();
	$('.resultadompep').load('php/lista_material.php',{'nombre_mpep':nombre_mpep,'tipo_fac':tipo_fac});	
}


function agregampep(event){
	event.preventDefault();
	
	$('#materia_prima').val($(this).attr('cod_producto'));
	$('#medida').html('<option value="'+$(this).attr('id_medida')+'" peso_kg="'+$(this).attr('peso_kg')+'" unidad="'+$(this).attr('unidad')+'">'+$(this).attr('nom_medida')+'</option>');
	$('#descripcion').val($(this).attr('nombre'));
	$('#modal-buscar-mp').modal('hide');
	
}


function cargamedida(){
	
	var proveedor = $('#proveedor').val();
	var codmp = $('#materia_prima').val();
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"HTML",
		contentType:"application/x-www-form-urlencoded",
		url:"php/cargamedida.php",
		data:"proveedor="+proveedor + "&codmp="+codmp,
		success: function(Data){
			$('#medida').html(Data);
		}
	})
}


function validaOrdenCompra(){
	
	var proveedor = $('#proveedor').val();
	var tipo_factura = $('#tipo_fac').val();
	var ordencompra = $('#orden_compra').val();
	var mpep = $('#materia_prima').val();
	var des_sm = $('#des_sm').val();
	var des_sr = $('#des_sr').val();
	var des_af = $('#des_af').val();
	var valor = 'ver';
	
	$.ajax({
		async:false,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/validaordencompra.php",
		data: 'proveedor='+proveedor + '&ordencompra='+ordencompra + '&mpep='+mpep + '&des_sm='+des_sm + '&des_sr='+des_sr + '&des_af='+des_af + '&tipo_factura='+tipo_factura,
		beforeSend: function(){
			alertify.info('verificando orden de compra...');
		},
		success: function(Data){
			$('.alertify-log').remove();
			
			if(Data.ok == true){
				alertify.success(Data.msg);			
				//$('.agregar').removeAttr('disabled');
				valor = 'true';
				
				
			}else if(Data.ok == false ){				
				alertify.error(Data.msg);
				//$('.agregar').attr('disabled','disabled');	
				valor = 'false';
				
				
			}
	    },
			
		
		error: function(){
			$('.alertify-log').remove();
			alertify.error('Error de conexion');

		}
		
	})
	
	return valor;
}

function listaregistros(event){
    event.preventDefault();
    
    
    var orden_compra = $('#orden_compra').val();
    var serie = $('#serie_factura').val();
	var no_factura = $('#no_factura').val();
    var fecha_factura = $('#fecha_factura').val();
	var proveedor = $('#proveedor').val();
    var tipo_factura = $('#tipo_fac').val();
    var credito = $('#dias_credito').val();
       
        $.ajax({
            async: true,
            type: "POST",
            dataType: "HTML",
            contentType: "application/x-www-form-urlencoded",
            url: "php/listaregistros.php",
            data: "orden_compra="+orden_compra + "&tipo_factura="+tipo_factura,
            beforeSend: function(){
                alertify.info("Recuperando orden de compra");
            },
            success: function(Data){
                $('.alertify-log').remove();
                $('#listadoEnvio').html(Data);
                
            },
            error: function(){
                $('.alertify-log').remove();
                alertify.error("Error de conexion");
                
            }
        })
        
    
}


function actualizaregistro(event){
    event.preventDefault();
    
    var orden_compra = $('#orden_compra').val();
    var tipo_factura = $(this).attr('tipo_factura');
    var idregistro = $(this).attr('idregistro');
    var cantidad = $('#cant'+idregistro).val();
    var valor = $('#val'+idregistro).val();
    
    
    $.ajax({
        async:true,
        type:"POST",
        dataType:"JSON",
        contentType: "application/x-www-form-urlencoded",
        url: "php/actualizaregistro.php",
        data: "orden_compra="+orden_compra + "&tipo_factura="+tipo_factura + "&idregistro="+idregistro + "&cantidad="+cantidad + "&valor="+valor,
        beforeSend: function(){
            alertify.info("Actualizando registro!");
        },
        success: function(Data){
            $('.alertify-log').remove();
            
            if(Data.ok == true){
                alertify.success(Data.msg);
                $('#agregar').trigger("submit");
            }else if(Data.ok == false){
                alertify.error(Data.msg);
            }
            
        },
        error: function(){
            $('.alertify-log').remove();
            alertify.error("Error de conexion");
        }
    })
    
}


function eliminaregistro(event){
    event.preventDefault();
    
    var orden_compra = $('#orden_compra').val();
    var tipo_factura = $(this).attr('tipo_factura');
    var idregistro = $(this).attr('idregistro');
    var confirmacion = confirm("Esta seguro de eliminar el registro?");
    
    if(confirmacion!=true){
        return false;
    }
    
    $.ajax({
        async:true,
        type:"POST",
        dataType:"JSON",
        contentType: "application/x-www-form-urlencoded",
        url: "php/eliminaregistro.php",
        data: "orden_compra="+orden_compra + "&tipo_factura="+tipo_factura + "&idregistro="+idregistro,
        beforeSend: function(){
            alertify.info("Eliminando registro!");
        },
        success: function(Data){
            $('.alertify-log').remove();
            
            if(Data.ok == true){
                alertify.success(Data.msg);
                $('#agregar').trigger("submit");
            }else if(Data.ok == false){
                alertify.error(Data.msg);
            }
            
        },
        error: function(){
            $('.alertify-log').remove();
            alertify.error("Error de conexion");
        }
    })
    
}


function formagregaregistro(){
    
    var tipo_factura = $('#tipo_fac').val();
   
    if(tipo_factura == 'MP' || tipo_factura == 'EP'){
        $('#modal-form-mpep').modal('show');
    }else if(tipo_factura == 'SR'){
        $('#modal-form-servicio').modal('show');
    }else if(tipo_factura == 'SM'){
        $('#modal-form-suministro').modal('show');
    }else if(tipo_factura == 'AF'){
        $('#modal-form-activofijo').modal('show');
    }
    
    
}


function insertaregistrofactura(event){
    event.preventDefault();
    
    var tipo_factura = $('#tipo_fac').val();
    
    if(tipo_factura == 'MP' || tipo_factura == 'EP'){
        
        var formData = new FormData($("#inserta-registro-mpepo")[0]);
	formData.append("materia_prima",$('#materia_prima').val());
	formData.append("no_lote",$('#no_lote').val());
        formData.append("fecha_vence",$('#fecha_vence').val());
        formData.append("cantidad",$('#cantidad').val());
        formData.append("medida",$('#medida').val());
        formData.append("valor",$('#valor').val());
        formData.append("orden_compra",$('#orden_compra').val());
        formData.append("tipo_factura",$('#tipo_fac').val());
        
    }else if(tipo_factura == 'SR'){
        var formData = new FormData($("#inserta-registro-mpepo")[0]);
	formData.append("des_sr",$('#des_sr').val());
        formData.append("valor_sr",$('#valor_sr').val());
        formData.append("orden_compra",$('#orden_compra').val());
        formData.append("tipo_factura",$('#tipo_fac').val());
        
    }else if(tipo_factura == 'SM'){
        
        var formData = new FormData($("#inserta-registro-mpepo")[0]);
        formData.append("orden_compra",$('#orden_compra').val());
        formData.append("tipo_factura",$('#tipo_fac').val());
        formData.append("des_sm",$('#des_sm').val());
        formData.append("cant_sm",$('#cant_sm').val());
        formData.append("valor_sm",$('#valor_sm').val());
        
    }else if(tipo_factura == 'AF'){
        
        var formData = new FormData($("#inserta-registro-mpepo")[0]);
        formData.append("orden_compra",$('#orden_compra').val());
        formData.append("tipo_factura",$('#tipo_fac').val());
        formData.append("des_af",$('#des_af').val());
        formData.append("valor_af",$('#valor_af').val());
        
    }
    
    
    $.ajax({
        async:true,
        type:"POST",
        dataType:"JSON",
        contentType: false,
        processData: false,
        url: "php/insertaregistro.php",
        data:formData,
        beforeSend: function(){
                alertify.info("Agregando....");
        },
        success: function(Datos){

                $('.alertify-log').remove();

                if(Datos.ok == true){

                    alertify.success(Datos.msg);
                    $('#agregar').trigger("submit");
                    limpiarcampos();

                }else if(Datos.ok == false){
                    alertify.error(Datos.msg);
                }else if(Datos.ok == 'EXISTE'){
                    alertify.danger(Datos.msg);
                }

        },
        error: function(){
                $('.alertify-log').remove();
                alertify.error("error de grabacion intentelo mas tarde");
        }

    })
    
}


function trasladarFactura(){
	
	
	var confirmacion = confirm("Esta seguro de validar el ingreso de la factura?");

	if(confirmacion!=true){
		return false;
	}
    
	
	var formData = new FormData($("#agregar")[0]);
	formData.append("serie",$('#serie_factura').val());
	formData.append("documento",$('#no_factura').val());
	formData.append("fecha_factura",$('#fecha_factura').val());
	formData.append("proveedor",$('#proveedor').val());
	formData.append("tipo_contribuyente",$('#tipo_contribuyente').val());
	formData.append("impuesto",$('#impuesto').val());
	formData.append("dias_credito",$('#dias_credito').val());
	formData.append("no_orden",$('#orden_compra').val());
	formData.append("proyecto",$('#proyecto').val());
	formData.append("tipo_gasto",$('#tipo_gasto').val());
    

	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:false,
		processData:false,
		url:'php/trasladoFactura.php',
        data: formData,    
		beforeSend: function(){
			  alertify.info('realizando traslado...');
			},
		success: function(Datos){
			console.log(Datos);
			  
			$('.alertify-log-info').remove();
						
			if(Datos.ok == true){
				
				alertify.success(Datos.msg);
				$('#listadoEnvio').html('');  
				
				$('.trasladar').attr('disabled','disabled');
				$('#serie_factura').removeAttr('disabled');
				$('#orden_compra').val('');
				$('#serie_factura').val('');
				$('#no_factura').val('');
				$('#fecha_factura').val('0000-00-00');
				$('#proveedor').val('');
				$('#nombre_proveedor').val('');
				$('#materia_prima').val('');
				$('#descripcion').val('');
				$('#dias_credito').val('');
				$('#proyecto').val('');
				$('#tipo_gasto').val('');
				$('#file').val('');
				//$('.btn-collapse').attr('hidden','hidden');
				//$('#encabezado_fac').collapse('show');
				  
				  
			  }else if(Datos.ok == false){
				alertify.danger(Datos.msg);
				$('#listadoEnvio').load('php/listadoProductos.php');
				  
			  }else{
				alertify.danger(Datos.mgs);			  
			  }			
			  
			},
		error: function(){
			  alertify.danger('Error de conexion...');
			}
	})
	
}


function limpiarcampos(){
	
	$('#materia_prima').val(0);
	$('#desc_materia_p').val('');
	$('#cantidad').val('');
	$('#medida').val(0);
	$('#valor').val('');
	$('#des_sm').val('');
	$('#cant_sm').val('');
	$('#valor_sm').val('');
	$('#des_sr').val('');
	$('#valor_sr').val('');
	$('#des_af').val('');
	$('#valor_af').val('');
	
}



