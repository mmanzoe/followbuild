$(document).ready(inicioEventos);

arrayfases = [];
arraygastos = [];

function inicioEventos(){
	
	listaRegistro();
	listaempresa();
	listaencargado();
	listafase();
	listagasto();

	$('.nuevo').click(function(){
		limpiarCampos();
	});


	$('#agregar_fase').click(agregarfase);
	$('#agregar_gasto').click(agregargasto);

	$('#grabar').submit(grabaRegistro);
	$('#resultados').on('click','.actualizar', recuperaRegistro);
	$('#resultados').on('click','.detalle-gasto', gastoproyecto);
	  
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
		url:"php/Proyecto.php",
		data: "tipo=read",
		beforeSend: function(){
			loadPanel.show();
		},
        success: function(Data){
			
            for(var x=0;x<Data.length;x++){
                registros.push({"id":Data[x]["id"], "id_empresa":Data[x]["id_empresa"], "cod_proyecto":Data[x]['cod_proyecto'], "nombre_proyecto":Data[x]["nombre_proyecto"], "descripcion":Data[x]["descripcion"], "nombre_empresa":Data[x]['nombre_empresa'], "monto":Data[x]['monto'], "nombre_encargado":Data[x]['nombre_encargado'], "acciones":"<a href='' class='actualizar' id='"+Data[x]['id']+"' ><i style='color:blue' class='fa fa-edit' title='editar'></i> </a> | <a href='calendario.html?id_proyecto="+Data[x]["id"]+"' target='_blank'  title='calendario' class='calendario'><span style='color:green' class='fa fa-calendar'></span></a> | <a href='' title='gastos' class='detalle-gasto' id_proyecto='"+Data[x]["id"]+"'><span style='color:orange' class='fa fa-coins'></span></a>"})	
			}

			loadPanel.hide();

			$("#resultados").dxDataGrid({
				dataSource: registros,
				showBorders: true,
				columns:[
					"id",
					"nombre_empresa",
					"cod_proyecto",
					"nombre_proyecto",
					"nombre_encargado",
					"descripcion",
					{
						dataField:"monto",
						dataType:Number,
					},
					
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

        }
    })

}

function listaempresa(){	
	$('#empresa').load('php/lista_empresa.php');
}

function listaencargado(){	
	$('#encargado').load('php/lista_encargado.php');
}

function listafase(){	
	$('#fase').load('php/lista_fase.php');
}

function listagasto(){	
	$('#gasto').load('php/lista_gasto.php');
}


function agregarfase(){
	var fase = $('#fase').val();
	var fecha_fase_inicial = $('#fecha_fase_inicial').val();
	var fecha_fase_final = $('#fecha_fase_final').val();
	var nombre = $('#fase>option:selected').attr("nombre");

	arrayfases.push({"id_fase":fase, "nombre":nombre, "fecha_inicial":fecha_fase_inicial, "fecha_final":fecha_fase_final});
	
	$("#resultados_fases").dxDataGrid({
		dataSource: arrayfases,
		showBorders: true,
	})

	$('#modal_add_fase').modal('hide');

}

function agregargasto(){
	var gasto = $('#gasto').val();
	var monto = $('#monto_gasto').val();
	var nombre = $('#gasto>option:selected').attr("nombre");
	
	arraygastos.push({"id_gasto":gasto, "nombre":nombre, "monto":monto});

	$("#resultados_gastos").dxDataGrid({
		dataSource: arraygastos,
		showBorders: true,
	})

	$('#modal_add_gasto').modal('hide');

}


function grabaRegistro(event){
	event.preventDefault();
	
	var empresa = $('#empresa').val();
	var cod_proyecto = $('#cod_proyecto').val();
	var nom_proyecto = $('#nom_proyecto').val();
	var descripcion = $('#descripcion').val();
	var monto = $('#monto').val();
	var encargado = $('#encargado').val();
	var fases = arrayfases;
	var gastos = arraygastos;
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/Proyecto.php",
		data:"tipo="+"create" + "&datos="+JSON.stringify({"empresa":empresa, "cod_proyecto":cod_proyecto, "nom_proyecto":nom_proyecto, "descripcion":descripcion, "monto":monto, "encargado":encargado, "fases":fases, "gastos":gastos}),
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
			alertify.error('error de conexion');
		}
	});
}


function gastoproyecto(event){
	event.preventDefault();
	$('#modal_lista_gasto').modal('show');

	var registros = [];
	var id_proyecto = $(this).attr('id_proyecto');

	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/lista_gasto_asignado.php",
		data:"id_proyecto="+id_proyecto,
		beforeSend: function(){
			
		},
		success: function(Data){
			
			for(var x=0;x<Data.length;x++){
                registros.push({"id":Data[x]["id"], "nombre_gasto":Data[x]["nombre"], "monto":Data[x]['monto']})	
			}
	
			$("#resultados_gasto_proyecto").dxDataGrid({
				dataSource: registros,
				showBorders: true,
				columns:[
					"nombre_gasto",
					"monto",
				],

			})
			
		},
		error: function(){
			$('.alertify-log').remove();
			alertify.error('error de conexion');
		}
	});

}


function recuperaRegistro(event){
	event.preventDefault();

	$('#codigo').val($(this).attr('id'));
	$('#nombre').val($(this).attr('nombre'));
	$('#descripcion').val($(this).attr('descripcion'))
	$('#modal_add').modal('show');
}


function limpiarCampos(){

	$('#empresa').val(0);
	$('#cod_proyecto').val('');
	$('#nom_proyecto').val('');
	$('#descripcion').val('');
	$('#monto').val('');
	arrayfases = [];
	arraygastos = [];
	
}
