$(document).ready(inicioEventos);

function inicioEventos(){
	//listaCuntasContables();
	busca_orden_factura();	
	$('#resultados').on('click','.autoriza', autorizaOrden);
	//$('#autorizaorden').click(autorizaOrden);
	$('#resultados').on('click','.rechaza', rechazaOrden);
	
}

function listaCuntasContables(){
	
	$('#tipo_gasto').load('php/listacuentascontables.php')
	
}

function busca_orden_factura(){
	
	var no_orden = $('#no_orden').val();
	var tipo_orden = $('#tipo_orden').val();
	var fecha_i = $('#fecha_i').val();
	var fecha_f = $('#fecha_f').val();
	ordenc = [];

	var loadPanel = $(".loadpanel").dxLoadPanel({
        shadingColor: "rgba(0,0,0,0.4)",
        position: { of: "#resultados" },
        visible: false,
        showIndicator: true,
        showPane: true,
        shading: true,
        closeOnOutsideClick: false,
    }).dxLoadPanel("instance");
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/lista_ordencompra.php",
		data:'no_orden='+no_orden + '&tipo_orden='+tipo_orden + '&fecha_i='+fecha_i + '&fecha_f='+fecha_f,
		beforeSend: function(){
			loadPanel.show();
		},
		success: function(Data){

			for(var x=0; x<Data.length; x++){
				console.log(Data[x]['id']);
				ordenc.push({"id":Data[x]['id'], "codigo_proveedor":Data[x]['cod_proveedor'], "nom_proveedor":Data[x]['nom_proveedor'], "tipo_orden":Data[x]['tipo_orden'], "tipo_pago":Data[x]['tipo_pago'], "observaciones":Data[x]['observaciones'], "moneda":Data[x]['nombre_moneda'], "monto":Data[x]['monto'], "nombre_ingresa":Data[x]['nombre_ingresa'], "acciones":Data[x]['acciones'] });
			}

			loadPanel.hide();

			$("#resultados").dxDataGrid({
				dataSource: ordenc,
				showBorders: true,
				columns: [
					"id",
					"codigo_proveedor",
					"nom_proveedor",
					"tipo_orden",
					"monto",
					"tipo_pago",
					"observaciones",
					"moneda",
					"monto",
					"nombre_ingresa",
					{
						dataField: "acciones",
						cellTemplate: function (container, options){
							container.append($("<a href='#'>"+options.value+"</a>")).appendTo(container);
						},
						aligment: "center",
						width: 100,
					}

				],
				searchPanel: {
					visible: true
				},
			})

			
		},
		error: function(){
			alertify.error('Error de conexion');
			
		}
	});
	
}

/*
function modalAutorizaOrden(event){
	event.preventDefault();	
	$('.autoriza_orden_compra').modal('show');
	$('#idregistro').val($(this).attr('idregistro'));
}
*/

function autorizaOrden(event){
	event.preventDefault();
		
	var idregistro = $(this).attr('idregistro');
    var correo = confirm("Quiere enviar por correo electronico la orden de compra?");
	
        
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/validaorden.php",
		data: 'idregistro='+idregistro + '&correo='+correo,
		beforeSend: function(){
			alertify.info('validando orden de compra');
		},
		success: function(Data){
			$('.alertify-log').remove();
			
                        
			if(Data.ok == true){
				alertify.success(Data.msg);
				$('.autoriza_orden_compra').modal('hide');
				busca_orden_factura();
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

function rechazaOrden(event){
	event.preventDefault();
	
	var confirmacion = confirm("Esta seguro de rechazar la orden de compra?");
	
	if(confirmacion == true){
		
		var idregistro = $(this).attr('idregistro');
		
		$.ajax({
			async:true,
			type:"POST",
			dataType:"JSON",
			contentType:"application/x-www-form-urlencoded",
			url:"php/rechazaorden.php",
			data: 'idregistro='+idregistro,
			beforeSend: function(){
				alertify.info('rechazando orden de compra');
			},
			success: function(Data){
				$('.alertify-log').remove();
				
				if(Data.ok == true){
					alertify.success(Data.msg);
					busca_orden_factura();
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


