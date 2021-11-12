$(document).ready(inicioEventos);

function inicioEventos(){
	$('#buscar').click(busca_factura);
	$('#resultados').on('click','.detalle', muestradetallefactura);
	$('#resultados').on('click','.visualiza', muestrafactura);
	$('#resultados').on('click','.detallepago', muestradetallepago);
	$('#resultados').on('click','.eliminar', eliminafactura);
    $('.muestra_detalle_pago_factura').on('click','.retencion', muestraretencion);
        
}

function busca_factura(){
	
	var no_factura = $('#no_factura').val();
	var fecha_i = $('#fecha_i').val();
	var fecha_f = $('#fecha_f').val();
    var tipo_fecha = $('#tipo_fecha').val();
	var facturas = [];

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
		url:"php/lista_facturas.php",
		data:'no_factura='+no_factura + '&fecha_i='+fecha_i + '&fecha_f='+fecha_f + '&tipo_fecha='+tipo_fecha,
		beforeSend: function(){
			loadPanel.show();
			$('#modal-parametros').modal('hide');
		},
		success: function(Data){

			for(var x=0; x<Data.length; x++){
				
				facturas.push({"serie":Data[x]['serie'], "factura":Data[x]['factura'], "fecha_factura":Data[x]['fecha_factura'], "monto":Data[x]['monto'], "nombre_ingresa":Data[x]['nombre_ingresa'], "fecha_ingresa":Data[x]['fecha_ingresa'], "nombre_estado":Data[x]['nombre_estado'], "nombre_cliente":Data[x]['nombre_cliente'], "estado":Data[x]['nombre_estado'], "acciones":Data[x]['acciones']  });
			}

			loadPanel.hide();

			$("#resultados").dxDataGrid({
				dataSource: facturas,
				showBorders: true,
				columns: [
					"serie",
					"factura",
					"fecha_factura",
					"fecha_ingresa",
					"nombre_cliente",
					"nombre_ingresa",
					"monto",
					"nombre_estado",
					{
						dataField: "acciones",
						cellTemplate: function (container, options){
							container.append($("<a href='#'>"+options.value+"</a>")).appendTo(container);
						},
						aligment: "center",
						width: 150,
					}

				],
				searchPanel: {
					visible: true
				},

				export: {
                    enabled: true,
                },
                onExporting: function(e) {
                var workbook = new ExcelJS.Workbook();
                var worksheet = workbook.addWorksheet('facturas');
                
                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet: worksheet,
                    autoFilterEnabled: true
                }).then(function() {
                    workbook.xlsx.writeBuffer().then(function(buffer) {
                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Factura_Cliente.xlsx');
                    });
                });
                e.cancel = true;
                },

			})
			
		},
		error: function(){
			
			alertify.error('Error de conexion');
			
		}
	});
	
}

function muestradetallefactura(event){
	event.preventDefault();
	
	var idregistro = $(this).attr('idregistro');
	var tipo_factura = $(this).attr('tipo_fac');
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"HTML",
		contentType:"application/x-www-form-urlencoded",
		url:"php/lista_detalle_factura.php",
		data:"idregistro="+idregistro + "&tipo_factura="+tipo_factura,
		beforeSend: function(){
			alertify.info('Generando...');
		},
		success: function(Data){
			$('.alertify-log').remove();
			$('.muestra_detalle_factura').html(Data);
			$('.detalle_factura').modal('show');
		},
		error: function(){
			alertify.error('Error de conexion');
		}	
	});
	
}

function muestrafactura(event){
	event.preventDefault();
	
	var serie = $(this).attr('serie');
	var documento = $(this).attr('documento');
	var proveedor = $(this).attr('proveedor');
	
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"HTML",
		contentType:"application/x-www-form-urlencoded",
		url:"php/consu_img_factura.php",
		data:"serie="+serie + "&documento="+documento + "&proveedor="+proveedor,
		beforeSend: function(){
			alertify.info('Generando...');
		},
		success: function(Data){
			$('.alertify-log').remove();		
			$('.image_factura').modal('show');
			$('.muestra_factura').empty();
			
			if(Data != ''){
				$('.muestra_factura').append('<embed src="../ingreso_factura_proveedor/factura/'+Data+'" width="100%" height="400" id="pdf">');
				$('.descarga_img').attr("href","../ingreso_factura_proveedor/factura/"+Data);
				$('.descarga_img').attr("download",Data);
			}else{
				$('.muestra_factura').html('no se encuentra el archivo');
			}
			
		},
		error: function(){
			alertify.error('Error de conexion');
		}	
	});
	
	
}

function muestradetallepago(event){
	event.preventDefault();
	
	var idregistro = $(this).attr('idregistro');
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"HTML",
		contentType:"application/x-www-form-urlencoded",
		url:"php/listadetallepago.php",
		data:"idregistro="+idregistro,
		beforeSend: function(){
			
		},
		success: function(Data){
		    $('.muestra_detalle_pago_factura').html(Data);
		},
		error: function(){
		
		}
	})
	
	$('.detalle_pago_factura').modal('show');
}

function eliminafactura(event){
	event.preventDefault();
	
	var confirmacion = confirm('Esta seguro de eliminar la factura?');
	
	
	if(confirmacion == true){
		
		var idregistro = $(this).attr('idregistro');
		var serie = $(this).attr('serie');
		var documento = $(this).attr('documento');
		var proveedor = $(this).attr('proveedor');
		var tipo_fac = $(this).attr('tipo_fac');
		
		$.ajax({
			async: true,
			type:"POST",
			dataType:"JSON",
			contentType:"application/x-www-form-urlencoded",
			url:"php/eliminaFactura.php",
			data:"idregistro="+idregistro + "&serie="+serie + "&documento="+documento + "&proveedor="+proveedor + "&tipo_fac="+tipo_fac,
			beforeSend: function(){
				alertify.info('Eliminando factura, espere un momento!');
			},
			success: function(Data){
				$('.alertify-log').remove();
							
				if(Data.ok == true){
					alertify.success(Data.msg);
					$('#buscar').trigger('click');
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
	
} 


function muestraretencion(event){
    event.preventDefault();
    
    
    $('.retencion_pago_factura').modal('show');
    var imagen = $(this).attr('ruta');
    
    $('.muestra_retencion_pago_factura').empty();
    $('.muestra_retencion_pago_factura').append('<img src="../pago_proveedores/RETENCIONES/'+imagen+'" class="img-fluid">');
    
}