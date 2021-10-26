$(document).ready(inicioEventos);

function inicioEventos(){
	
	listaRegistro();
	$('.proyectos').on('click','.detalle_proyetco', detalleproyecto);
	$('#resultados').on('click','.lista-factura', listaFactura);
	$('#resultados_factura').on('click','.view_image', muestraImagefactura);
	  
}


function listaRegistro(){	
	
	var registros = [];
    
    $.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
        contentType:"application/x-www-form-urlencoded",
		url:"php/Seguimiento.php",
		data: "tipo=read",
        success: function(Data){
			
            for(var x=0;x<Data.length;x++){
                registros.push({"id":Data[x]["id"], "id_empresa":Data[x]["id_empresa"], "cod_proyecto":Data[x]['cod_proyecto'], "nombre_proyecto":Data[x]['nombre_proyecto'], "descripcion":Data[x]["descripcion"], "monto":Data[x]['monto'], "estado":Data[x]['estado'], "total_gasto":Data[x]['total_gasto'] })	
				
				if(Data[x]['total_gasto']>Data[x]['monto']){
					var color = 'bg-danger';
				}else{
					var color = 'bg-success';
				}

				var proyecto = '<div class="col-12 col-sm-6 col-md-6 col-lg-4">'+
					'<div class="card" style="width: 18rem;">'+
						'<div class="card-header text-white '+color+'">'+
							'<div class=""><span class="fa fa-chart-line fa-2x"></span></div>'+
						'</div>'+
						
						'<div class="card-body">'+
							'<h5 class="card-title">'+Data[x]['nombre_proyecto']+'</h5>'+
							'<p class="card-text">'+Data[x]['descripcion']+'</p>'+
							'<a href="#" id_proyecto="'+Data[x]['id']+'"  class="detalle_proyetco">ver detalles de gastos</a>'+
						'</div>'+
				
						'<div class="card-footer">'+
							'<div class="text-info">Monto proyecto: <span class=" fa fa-coins pull-right"> '+Data[x]['monto']+'</span></div>'+
							'<div class="text-danger">Gasto proyecto: <span class=" fa fa-coins pull-right"> '+Data[x]['total_gasto']+'</span></div>'+
						'</div>'+
			
					'</div>'+
				'</div>';

				$('.proyectos').append(proyecto);
			}

        }
    })

}

function detalleproyecto(event){
	event.preventDefault();
	$('#modal_detalle_gasto').modal('show');

	var id_proyecto = $(this).attr('id_proyecto');
	detallegasto = [];

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
		url:"php/lista_detalle_gasto.php",
		data:'id_proyecto='+id_proyecto,
		beforeSend: function(){
			loadPanel.show();
		},
		success: function(Data){

			for(var x=0; x<Data.length; x++){
				detallegasto.push({"id":Data[x]['id'], "nombre_gasto":Data[x]['nombre_gasto'], "monto":Data[x]['monto'], "total_gasto":Data[x]['total_gasto'], "acciones":"<a href='#' class='lista-factura' id_proyecto='"+Data[x]['id_proyecto']+"' id_tipo_gasto='"+Data[x]['id_tipo_gasto']+"'><span class='fa fa-file-alt'></span></a>" });
			}

			loadPanel.hide();

			$("#resultados").dxDataGrid({
				dataSource: detallegasto,
				showBorders: true,
				columns: [
					"id",
					"nombre_gasto",
					"monto",
					"total_gasto",
					{
						dataField: "acciones",
						cellTemplate: function (container, options){
							container.append($("<a href='#'>"+options.value+"</a>")).appendTo(container);
						},
						aligment: "center",
						width: 90,
					},
				],
				
			})

			
		},
		error: function(){
			alertify.error('Error de conexion');
			
		}
	});


}

function listaFactura(event){
	event.preventDefault();
	$('.visualiza-factura').html('');

	var id_proyecto = $(this).attr('id_proyecto');
	var id_gasto = $(this).attr('id_tipo_gasto');
	factura = [];

	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/detalle_factura.php",
		data:'id_proyecto='+id_proyecto + '&id_gasto='+id_gasto,
		beforeSend: function(){
			
		},
		success: function(Data){

			console.log(Data);

			for(var x=0; x<Data.length; x++){
				factura.push({"id":Data[x]['id'], "serie":Data[x]['serie'], "documento":Data[x]['documento'], "proveedor":Data[x]['proveedor'], "total_factura":Data[x]['total_factura'], "acciones":"<a href='#' class='view_image' factura='"+Data[x]['serie']+Data[x]['documento']+Data[x]['proveedor']+"'><span class='fa fa-image'></span></a>" });
			}


			$("#resultados_factura").dxDataGrid({
				dataSource: factura,
				showBorders: true,
				columns: [
					"serie",
					"documento",
					"proveedor",
					"total_factura",
					{
						dataField: "acciones",
						cellTemplate: function (container, options){
							container.append($("<a href='#'>"+options.value+"</a>")).appendTo(container);
						},
						aligment: "center",
						width: 90,
					},
				],
				
			})

			
		},
		error: function(){
			alertify.error('Error de conexion');
			
		}
	});

	$('#modal_detalle_factura').modal('show');

}

function muestraImagefactura(event){
	event.preventDefault();

	var factura = $(this).attr('factura');
	$('.visualiza-factura').html('');
	$('.visualiza-factura').append('<embed src="../ingreso_factura_proveedor/factura/'+factura+'.JPG" width="100%" />');
	//$('.visualiza-factura').append('<iframe src="../ingreso_factura_proveedor/factura/A1614940450.jpg" width="100%"></iframe>');

}



