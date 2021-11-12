$(document).ready(inicioEventos);

function inicioEventos(){
	
    $('#monto').numeric('.');
	listafacturas();
	listaforampago();
	$('#buscar_requerimiento').click(listafacturas);
	$('#resultados').on('click', '.valida', modalPago);
	$('#forma_pago').change(cargatipopago);
	$('#grabar').submit(grabaregistro);
    
}


function listafacturas(){

	facturas = [];
	
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
		url:"php/listafacturas.php",
		beforeSend: function(){
			loadPanel.show();
		},
		success: function(Data){

			for(var x=0; x<Data.length; x++){
				//console.log(Data[x]['id']);
				facturas.push({"no_orden":Data[x]['no_orden'], "serie":Data[x]['serie'], "documento":Data[x]['documento'], "nombre":Data[x]['nombre'], "fecha_factura":Data[x]['fecha_factura'], "credito":Data[x]['credito'], "total_factura":Data[x]['total_factura'], "abono":Data[x]['abono'], "saldo":Data[x]['saldo'], "usuario_ingresa":Data[x]['usuario_ingresa'], "fecha_ingresa":Data[x]['fecha_ingresa'], "acciones":Data[x]['acciones'] });
			}

			loadPanel.hide();

			$("#resultados").dxDataGrid({
				dataSource: facturas,
				showBorders: true,
				columns: [
					"no_orden",
					"serie",
					"documento",
					"nombre",
					"fecha_factura",
					"credito",
					"total_factura",
					"abono",
					"saldo",
					"usuario_ingresa",
					"fecha_ingresa",
					{
						dataField: "acciones",
						cellTemplate: function (container, options){
							container.append($("<a href='#'>"+options.value+"</a>")).appendTo(container);
						},
						aligment: "center",
						width: 100,
					},
				],
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
                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'pago_proveedor.xlsx');
                    });
                });
                e.cancel = true;
                },
				searchPanel: {
					visible: true
				},
				summary: {
					totalItems: [{
						column: "total_factura",
						summaryType: "sum",

						valueFormat: {  
							type: "decimal",  
							precision: 2  
						},
					}, 
					{
						column: "abono",
						summaryType: "sum",
						
						valueFormat: {  
							type: "decimal",  
							precision: 2  
						},
					},
					{
						column: "saldo",
						summaryType: "sum",
						
						valueFormat: {  
							type: "decimal",  
							precision: 2  
						},
					}]
				},
			})

			
		},
		error: function(){
			alertify.error('Error de conexion');
			
		}
	});

	//var id_busca = $('#id_busca').val();
	//$('.resultados').load('php/listafacturas.php',{'id_busca':id_busca});
        
}


function listaforampago(){
	$('#forma_pago').load('php/listaformapago.php');
}


function modalPago(event){
	event.preventDefault();	 
	$('.modal-pago').modal('show');
	$('#idfactura').val($(this).attr('idregistro'));
	listadetallepago();
	$('#monto').val('');
	$('#doc_valida').val('');
	
}


function listadetallepago(){
	
	$('.detalle-pago').html('');
	var idfactura = $('#idfactura').val();

	$.ajax({
		async:true,
		type:"POST",
		dataType:"HTML",
		contentType:"application/x-www-form-urlencoded",
		url:"php/listadetallepago.php",
		data: "idfactura="+idfactura,
		beforeSend: function(){
			
		},
		success: function(Data){
			
			var result = Data.split("~");
			
			if(result[1] == 'false'){
				$('.modal-pago').modal('hide');
				listafacturas();
			}else{
				$('.detalle-pago').html(result[0]);
			}
				
		    
		},
		error: function(){
		
		}	
	})
		
}


function cargatipopago(event){
	event.preventDefault();
	
	var tipo_pago = $('#forma_pago').val();
	$('#tipo').html('');
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"HTML",
		contentType:"application/x-www-form-urlencoded",
		url:"php/cargabancos.php",
		data: "tipo_pago="+tipo_pago,
		beforeSend: function(){
			
		},
		success: function(Data){
		
			$('#tipo').html(Data);
		},
		error: function(){
		
		}
	})
	
}

function grabaregistro(event){
	event.preventDefault();
	
    var idfactura = $('#idfactura').val();
	var formapago = $('#forma_pago').val();
	var tipo = $('#tipo').val();
	var monto = $('#monto').val();
	var docvalida = $('#doc_valida').val();
        
    var formData = new FormData($("#grabar")[0]);
	formData.append("idfactura",idfactura);
        formData.append("formapago",formapago);
        formData.append("tipo",tipo);
        formData.append("monto",monto);
        formData.append("docvalida",docvalida);
    
		//console.log("idfactura="+idfactura+" formapago="+formapago+" tipo="+tipo+" monto="+monto+" docvalida="+docvalida);
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:false,
		processData:false,
		//contentType:"application/x-www-form-urlencoded",
		url:'php/grabar.php',
		data:formData,
		beforeSend: function(){
			alertify.info('Grabando...');
		},
		success: function(Data){
			$('.alertify-log').remove();
			
			if(Data.ok == true){
				//listadetallepago();
				alertify.success(Data.msg);
				$('.modal-pago').modal('hide');
				listafacturas();
			}else if(Data.ok == false){
				alertify.error(Data.msg);
			}
			
		},
		error: function(){
			$('.alertify-log').remove();
			alertify.error('Error de conexion!');
		}
	})

}