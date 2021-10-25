$(document).ready(inicioEventos);

function inicioEventos(){
	
	listaRegistro();
	
	$('.nuevo').click(function(){
		limpiarCampos();
	});


	$('#resultados').on('click','.cierre_proyecto', cierre_proyecto);
	  
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
                registros.push({"id":Data[x]["id"], "id_empresa":Data[x]["id_empresa"], "cod_proyecto":Data[x]['cod_proyecto'], "nombre_proyecto":Data[x]["nombre_proyecto"], "descripcion":Data[x]["descripcion"], "nombre_empresa":Data[x]['nombre_empresa'], "monto":Data[x]['monto'], "nombre_encargado":Data[x]['nombre_encargado'], "acciones":"<a href='' class='cierre_proyecto' id_proyecto='"+Data[x]['id']+"' title='eliminar'><i style='color:red' class='fa fa-times-circle'></i> </a>"})	
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


function cierre_proyecto(event){
	event.preventDefault();

	var validacion = confirm("Esta seguro de cerrar el proyecto, no podrar asignar gastos!");
	
	if(validacion === false){
		return false;
	}

	var id_proyecto = $(this).attr('id_proyecto');

	console.log(id_proyecto);

	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:"php/cierre_proyecto.php",
		data:"id_proyecto="+id_proyecto,
		beforeSend: function(){
			alertify.info('Cerrando proyecto');
		},
		success: function(Data){
			
			if(Data === true){
				$('.alertify-log').remove();
				alertify.success("Proyecto cerrado correctamente!");
				listaRegistro();
			}else{
				alertify.error("Error al cerrar el proyecto");
			}

			console.log(Data);
			
		},
		error: function(){
			$('.alertify-log').remove();
			alertify.error('error de conexion');
		}
	});

}


