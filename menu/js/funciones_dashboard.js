$(document).ready(inicioEventos);

function inicioEventos(){
    proyectoActivo();
    facturaPago();
    facturaCobro();
    proyectoVencimiento();
    ordenCompraPendienteValida();

}


function proyectoActivo(){

    $.ajax({
		dataType:"JSON",
		url:"php/dashboard.php",
		data: "busqueda=1",
        success: function(Data){

            $('.cant_proyecto').html(Data[0]['cantidad']);

        }

    })
}

function facturaPago(){

    $.ajax({
		dataType:"JSON",
		url:"php/dashboard.php",
		data: "busqueda=2",
        success: function(Data){

            $('.cant_fac_pago').html(Data[0]['cantidad']);

        }

    })

}

function facturaCobro(){

    $.ajax({
		dataType:"JSON",
		url:"php/dashboard.php",
		data: "busqueda=3",
        success: function(Data){

            $('.cant_fac_cobro').html(Data[0]['cantidad']);

        }

    })

}

function proyectoVencimiento(){

    $.ajax({
		dataType:"JSON",
		url:"php/dashboard.php",
		data: "busqueda=4",
        success: function(Data){
            console.log(Data);

            $('.cant_proyecto_vencimiento').html(Data[0]['cantidad']);

        }

    })

}

function ordenCompraPendienteValida(){

    $.ajax({
		dataType:"JSON",
		url:"php/dashboard.php",
		data: "busqueda=5",
        success: function(Data){

            $('.cant_oc_pendiente_valida').html(Data[0]['cantidad']);

        }

    })

}