$(document).ready(inicioEventos);

function inicioEventos(){
	
	listaRegistro();

	$('.nuevo').click(function(){
		limpiarCampos();
	})

	$('#grabar').submit(grabaRegistro);
	
	$('.busca-proyecto').click(listaProyecto);
	$('.resultadoproyecto').on('click','.agregaproyecto',agregaproyecto);

	$('.busca-cliente').click(listaCliente);
	$('.resultadocliente').on('click','.agregacliente',agregacliente);

	$('#monto').numeric('.');

}


function listaRegistro(){	

	
	var registros = [];
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
		url:"php/Factura.php",
		data: "tipo=read",
        success: function(Data){

			console.log(Data);
			
            for(var x=0;x<Data.length;x++){
                registros.push({"id":Data[x]["id"], "id_cliente":Data[x]["id_cliente"], "serie":Data[x]["serie"], "factura":Data[x]["factura"], "fecha_factura":Data[x]["fecha_factura"], "monto":Data[x]["monto"], "id_usuario_ingresa":Data[x]["id_usuario_ingresa"], "fecha_ingresa":Data[x]["fecha_ingresa"], "nombre_usuario":Data[x]["nombre_usuario"] })	
			}

			loadPanel.hide();

			$("#resultados").dxDataGrid({
				dataSource: registros,
				showBorders: true,
				columns:[
					"id",
					"id_cliente",
					"serie",
					"factura",
					"fecha_factura",
					"monto",
					"nombre_usuario",
					{
                        dataField: "fecha_ingresa",
                        dataType: "date",
                        format: 'dd-MM-yyyy' 
                    },
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
                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'facturas.xlsx');
                    });
                });
                e.cancel = true;
                },
			})

        },
		error: function(){
			console.log('adsdassda');
		}
    })

}

function grabaRegistro(event){
	event.preventDefault();
	
	var id_proyecto = $('#id_proyecto').val();
	var serie_factura = $('#serie_factura').val();
	var no_factura = $('#no_factura').val();
	var fecha_factura = $('#fecha_factura').val();
	var monto = $('#monto').val();
	var id_cliente = $('#id_cliente').val();
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/Factura.php",
		data:"tipo=create" + "&id_proyecto="+id_proyecto + "&serie_factura="+serie_factura + "&no_factura="+no_factura + "&fecha_factura="+fecha_factura + "&monto="+monto + "&id_cliente="+id_cliente,
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
			$('.alertify-log').remove();
			alertify.error('error de conexion, intentelo mas tarde!');
		}
	});
}

function listaProyecto(){
	var nombre_proyecto = $('#busca_nombre_proyecto').val();
	$('.resultadoproyecto').load('php/lista_proyecto.php',{'nombre_proyecto':nombre_proyecto});
}

function agregaproyecto(event){
	event.preventDefault();
	
	$('#id_proyecto').val($(this).attr('id'));
	$('#nombre_proyecto').val($(this).attr('nombreproyecto'));
	$('#modal-buscar-proyecto').modal('hide');

}

function listaCliente(){
	var nombre_cliente = $('#busca_nombre_cliente').val();
	$('.resultadocliente').load('php/lista_cliente.php',{'nombre_cliente':nombre_cliente});
}

function agregacliente(event){
	event.preventDefault();
	
	$('#id_cliente').val($(this).attr('id'));
	$('#nombre_cliente').val($(this).attr('nombre'));
	$('#modal-buscar-cliente').modal('hide');

}

function recuperaRegistro(event){
	event.preventDefault();

	$('#codigo').val($(this).attr('id'));
	$('#nombre').val($(this).attr('nombre'));
	$('#descripcion').val($(this).attr('descripcion'))
	$('#modal_add').modal('show');
}


function limpiarCampos(){
	$('#id_proyecto').val('');
	$('#nombre_proyecto').val('');
	$('#serie_factura').val('');
	$('#no_factura').val('');
	$('#fecha_factura').val('');
	$('#monto').val('');
	$('#id_cliente').val('');
	$('#nombre_cliente').val('');
	
}
