$(document).ready(inicioEventos);

function inicioEventos(){
	
    listamoneda();
	listaproyecto();
	$('#proyecto').change(listaTipoGasto);
    $('#moneda').change(validamoneda);
	$('.busca-proveedor').click(listaProveedores);
	$('.resultadoproveedor').on('click','.agregaproveedor',agregaproveedor);
	
	$('.busca-material').click(lista_material);
	$('.resultadomaterial').on('click','.agregamaterial', agregamaterial);
	
	//$('#tipo_solicitud').change(muestraform);
	
	$('#agregar').submit(agregaArticulo);
	$('.resultados').on("click",".eliminar",eliminarProducto);
	$('.resultados').on('click','.trasladar',trasladarProducto);

	$('#cantidad_material').numeric('.');
	
	
}

function listamoneda(){
    $('#moneda').load('php/lista_moneda.php');
}

function listaproyecto(){
	$('#proyecto').load('php/lista_proyecto.php');
}

function listaTipoGasto(){
	var id_proyecto = $('option:selected', '#proyecto').attr('id_proyecto');
	console.log(id_proyecto);
	$('#tipo_gasto').load('php/lista_tipo_gasto.php?id_proyecto='+id_proyecto);
}

function validamoneda(){
    
    if($('#moneda').val()=='1'){
        $('.group-cambio-moneda').attr('hidden','hidden');
        $('#cambio_moneda').val('1');
    }else{
        $('.group-cambio-moneda').removeAttr('hidden');
        $('#cambio_moneda').val('0');
    }
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

function lista_material(){
	
	var nombre_material = $('#nombre_material').val();
	$('.resultadomaterial').load('php/lista_material.php',{'nombre_material':nombre_material});	
}


function agregamaterial(event){
	event.preventDefault();
	
	var codigo = $(this).attr('cod_producto');
	
	$('#codigo_material').val($(this).attr('cod_producto'));
	$('#medida').html('<option value="'+$(this).attr('id_medida')+'" peso_kg="'+$(this).attr('peso_kg')+'" unidad="'+$(this).attr('unidad')+'">'+$(this).attr('nom_medida')+'</option>');
	$('#descripcion').val($(this).attr('nombre'));
	$('#modal-buscar-mp').modal('hide');
	$('#medida_material').val($(this).attr('nombre_medida'));
	$('#precio_material').val($(this).attr('valor_compra'));
	
	var linkarchivo = '../cat_materia_prima/archivo/'+codigo+'/'+codigo+'.pdf';
	
	$('#muestra_pdf').attr('src',linkarchivo);
	
}


function agregaArticulo(event){
	event.preventDefault();
        
	if($('#cambio_moneda').val()< 1){
		alert('Ingrese monto del cambio de moneda para continuar!');
		return false;
	}
	
	if($('#proveedor').val() == ''){
		alert('selecciona proveedor para continuar');
		return false;
	}
	
    var simbolo = $('option:selected', '#moneda').attr('simbolo');
    var cambio_moneda = $('#cambio_moneda').val();
	var proveedor = $('#proveedor').val();
	var forma_pago = $('#forma_pago').val();
	var tipo_solicitud = $('#tipo_solicitud').val();
	var observacion = $('#observaciones').val();
	
	var codigo_material = $('#codigo_material').val();
	var descripcionmpep = $('#descripcion').val();
	var precio = $('#precio_material').val();
	var cantidad = $('#cantidad_material').val();
	
	var des_sr = $('#des_sr').val();
	var valor_sr = $('#valor_sr').val();
	
	if(tipo_solicitud == 'MATERIAL'){
		var datosenvio = "simbolo="+simbolo + "&cambio_moneda="+cambio_moneda + "&proveedor="+proveedor + '&forma_pago='+forma_pago + '&tipo_solicitud='+tipo_solicitud + '&codigo_material='+codigo_material + '&descripcionmpep='+descripcionmpep + '&precio='+precio + '&cantidad='+cantidad + '&observacion='+observacion;
		var urlenvio = "php/agregaProducto.php"
		var listadoProducto = 'php/listadoProducto.php';
		
	}else if(tipo_solicitud == 'SERVICIO'){
		var datosenvio = "simbolo="+simbolo + "&cambio_moneda="+cambio_moneda + "&proveedor="+proveedor + "&des_sr="+des_sr + "&valor_sr="+valor_sr + '&forma_pago='+forma_pago + '&tipo_solicitud='+tipo_solicitud + '&observacion='+observacion;
		var urlenvio = "php/agregaProductoSR.php"
		var listadoProducto = 'php/listadoProductoSR.php';
		
	}
	
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:urlenvio,
		data:datosenvio,
		beforeSend: function(){
			alertify.info('agregando registro');
			
		},
		success: function(Data){
			$('.alertify-log').remove();
			
			if(Data.ok == true){
				alertify.success(Data.msg);
				
                $('#moneda').attr('disabled','disabled');
                $('#cambio_moneda').attr('disabled','disabled');
				$('.modal-buscar-proveedor').attr('disabled','disabled');
				$('#tipo_solicitud').attr('disabled','disabled');
				$('#proyecto').attr('disabled','disabled');
				$('#tipo_gasto').attr('disabled','disabled');
				$('#forma_pago').attr('disabled','disabled');
				$('#observaciones').attr('disabled','disabled');
				$('.resultados').load(listadoProducto, {'simbolo':simbolo});
			}else if(Data.ok == false){
				alertify.danger(Data.msg);
				$('.resultados').load(listadoProducto, {'simbolo':simbolo});
			}
			
		},
		error: function(){
			$('.alertify-log').remove();
			alertify.error('Error de conexion...');
			
		}
	})
	
}


function eliminarProducto(event){
	event.preventDefault();
	
	var valorArreglo = $(this).attr("id");
	
	$.ajax({
		async: true,
		type:"POST",
		dataType:"HTML",
		contentType:"application/x-www-form-urlencoded",
		url: "php/eliminaProducto.php",
		data: "valorArreglo="+valorArreglo,
		beforeSend: function(){},
		success: function(Datos){
			
			
			if($('#tipo_solicitud').val() == 'MPEP'){
				$('.resultados').load('php/listadoProducto.php');
			}else if($('#tipo_solicitud').val() == 'SUMINISTRO'){
				$('.resultados').load('php/listadoProductoSM.php');
			}else if($('#tipo_solicitud').val() == 'SERVICIO'){
				$('.resultados').load('php/listadoProductoSR.php');
			}else if($('#tipo_solicitud').val() == 'ACTIVOFIJO'){
				$('.resultados').load('php/listadoProductoAF.php');
			}
			
			},
		error: function(){}
	});
	
}

function trasladarProducto(event){
	event.preventDefault();
	
	if($('#tipo_solicitud').val() == 'MATERIAL'){
		var urltraslado = "php/trasladoOrdenCompra.php";
		var listadoProducto = 'php/listadoProducto.php';
		
	}else if($('#tipo_solicitud').val() == 'SERVICIO'){
		var urltraslado = "php/trasladoOrdenCompraSR.php";
		var listadoProducto = 'php/listadoProductoSR.php';
		
	}
	
	//var formData = new FormData($("#agregar")[0]);
	
	var moneda = $('#moneda').val();
	var cambio_moneda = $('#cambio_moneda').val();
	var proyecto = $('option:selected', '#proyecto').attr('id_proyecto');
	var tipo_gasto = $('option:selected', '#tipo_gasto').attr('id_gasto');

	console.log('proyecto: '+proyecto+' tipo_gasto: '+tipo_gasto);
        
	$.ajax({
		async:true,
		type:"POST",
		dataType:"JSON",
		contentType:"application/x-www-form-urlencoded",
		url:urltraslado,
		data: 'moneda='+moneda + '&cambio_moneda='+cambio_moneda+ "&proyecto="+proyecto + "&tipo_gasto="+tipo_gasto,
		beforeSend: function(){
			alertify.info("Trasladando orden de compra");
		},
		success: function(Data){
			$('.alertify-log').remove();
			
			if(Data.ok == true){
			   alertify.success(Data.msg);	
			   limpiarcampos();
			   muestraform();		   
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


function limpiarcampos(){
	
	$('#proveedor').val('');
	$('#nombre_proveedor').val('');
	$('#dias_credito').val('');
	$('#forma_pago').val(0);
	$('#observaciones').val('');
	$('#tipo_solicitud').val('MP/EP');	
	$('#materia_prima').val('');
	$('#descripcion').val('');
	$('#precio_mpep').val('');
	$('#cantidad_mpep').val('');	
	$('#des_sm').val('');
	$('#cant_sm').val('');
	$('#valor_sm').val('');
	$('#des_sr').val('');
	$('#valor_sr').val('');
	$('#des_af').val('');
	$('#valor_af').val('');
	
	$('.resultados').html('');
	
	$('.modal-buscar-proveedor').removeAttr('disabled');
	$('#tipo_solicitud').removeAttr('disabled');
	$('#forma_pago').removeAttr('disabled');
	$('#proyecto').removeAttr('disabled');
	$('#tipo_gasto').removeAttr('disabled');
	$('#observaciones').removeAttr('disabled');
	
}
