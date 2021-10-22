$(document).ready(inicioEventos);

function inicioEventos(){
	
	listaproveedor();
	$('#buscar').click(listaReporte);
	$('#resultados').on('click','.listadetalle', muestraDetalle);
    $('#resultados').on('click','.rechazar', rechazaordenpedido);
        
}

function listaproveedor(){
	$('#proveedor').load('php/lista_proveedor.php');
}

function listaReporte(event){
	event.preventDefault();
	
	var proveedor = $('#proveedor').val();
	var estado = $('#estado').val();
	var fechai = $('#fechai').val();
	var fechaf = $('#fechaf').val();
	var tipo_orden = $('#tipo_orden').val();
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
		url:"php/reporte.php",
		data: "proveedor="+proveedor + '&estado='+estado + "&fechai="+fechai + "&fechaf="+fechaf + "&tipo_orden="+tipo_orden,
		beforeSend: function(){
			$('#modal-parametros').modal('hide');
		},
		success: function(Data){

			for(var x=0; x<Data.length; x++){
				console.log(Data[x]['id']);
				ordenc.push({"id":Data[x]['id'], "nom_proveedor":Data[x]['nom_proveedor'], "tipo_orden":Data[x]['tipo_orden'], "monto":Data[x]['monto'], "nombre_ingresa":Data[x]['nombre_ingresa'], "fecha_ingresa":Data[x]['fecha_ingresa'], "estado":Data[x]['nombre_estado'], "nombre_autoriza":Data[x]['nombre_autoriza'], "fecha_autoriza":Data[x]['fecha_autoriza'], "acciones":Data[x]['acciones']  });
			}

			loadPanel.hide();

			$("#resultados").dxDataGrid({
				dataSource: ordenc,
				showBorders: true,
				columns: [
					"id",
					"nom_proveedor",
					"tipo_orden",
					"monto",
					"nombre_ingresa",
					"fecha_ingresa",
					"estado",
					"nombre_autoriza",
					"fecha_autoriza",
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
			$('.alertify-log').remove();
			alertify.error("Error de conexion!");
		}
	})
		
}


function muestraDetalle(event){
	event.preventDefault();
	
	$('#modal-detalle-pedido').modal('show');
	
	var idregistro = $(this).attr('idregistro');
        var tipo_orden = $(this).attr('tipo_orden');
	
	$.ajax({
		async: true,
		type:"POST",
		dataType:"HTML",
		contentType:"application/x-www-form-urlencoded",
		url:"php/detalle_pedido.php",
		data:"idregistro="+idregistro + "&tipo_orden="+tipo_orden,
		beforeSend: function(){
			
		},
		success: function(Data){
			$('.resultadodetalle').html(Data);
		},
		error: function(){
			alertify.error('Error de conexion');
		}
	})
	
}


function rechazaordenpedido(event){
    event.preventDefault();
    
    var idregistro = $(this).attr('id_registro');
    var validacion = confirm("Esta seguro de rechazar la orden de compra: "+idregistro+"?");
    
    if(validacion != true){
        return false;
    }
    
    $.ajax({
		async: true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/rechazar_ordencompra.php",
		data:"idregistro="+idregistro,
		beforeSend: function(){
			alertify.info('Rechazando orden de pedido..');
		},
		success: function(Data){
                        $('.alertify-log').remove();
                        
                        if(Data.ok == true){
                            alertify.success(Data.msg)
                            listaproveedor();
                        }else{
                            alertify.error(Data.msg)
                        }
                        
                        
		},
		error: function(){
                        $('.alertify-log').remove();
			alertify.error('Error de conexion');
		}
	})
    
}