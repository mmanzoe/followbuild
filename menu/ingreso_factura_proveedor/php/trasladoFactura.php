<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$no_orden = $_REQUEST['no_orden'];
$serie = str_replace(" ", "", strtoupper($_REQUEST['serie']));
$documento = str_replace(" ", "", $_REQUEST['documento']);
$fecha_documento = $_REQUEST['fecha_factura'];
$proveedor = $_REQUEST['proveedor'];
$tipo_contribuyente = $_REQUEST['tipo_contribuyente'];
$impuesto = $_REQUEST['impuesto'];
$dias_credito = $_REQUEST['dias_credito'];
$proyecto = $_REQUEST['proyecto'];
$tipo_gasto = $_REQUEST['tipo_gasto'];
$totalfactura = 0;

$return = Array('ok'=>TRUE);

$consultaorden = "SELECT orden.*, cat_producto.id_medida FROM orden_compra_detalle as orden INNER JOIN cat_producto ON(cat_producto.codigo_producto = orden.cod_producto) WHERE orden.id_orden_compra = '".$no_orden."'";
$resultadosorden = mysqli_query($conexion, $consultaorden);
    
    
    for($n=0; $n<mysqli_num_rows($resultadosorden); $n++){
        $fila = mysqli_fetch_assoc($resultadosorden);
		
		/* INICIO MOVIMIENTO DE BODEGA
		$consulta = "SELECT * FROM inventario_bodega WHERE codigo_producto = '".$fila['cod_producto']."' LIMIT 1";
		$resuConsu = mysqli_query($conexion, $consulta);
		$cantidadResu = mysqli_num_rows($resuConsu);
	  
		if($cantidadResu>0){
			
			$row = mysqli_fetch_assoc($resuConsu);
		
			//actualiza inventarido bodega con los registros ingresados en la factura
			$query = "UPDATE inventario_bodega SET pendiente_incorporar = '".($fila['cantidad']+$row['pendiente_incorporar'])."', fecha_entrada='".date('Y-m-d H:i:s')."' WHERE codigo_producto ='".$row['codigo_producto']."'";
			$resultados = mysqli_query($conexion, $query);
			
			$totalfactura = $totalfactura + ($fila['cantidad']*$fila['valor']);
			
			
		}else{
			
			
			$query = "INSERT INTO inventario_bodega(codigo_producto, pendiente_incorporar, fecha_entrada) VALUES('".$fila['cod_producto']."','".$fila['cantidad']."','".date('Y-m-d H:i:s')."' )"; 
			$resultados = mysqli_query($conexion, $query);
			
			$totalfactura = $totalfactura + ($fila['cantidad']*$fila['valor']);
			
		}
	  FIN MOVIMIENTO DE BODEGA */

	  //inserta detale de factura
	  $insertDetalleFactura = "INSERT INTO factura_proveedor_detalle(serie, documento, proveedor, codigo_producto, no_orden, medida, cantidad, valor) VALUES('".$serie."','".$documento."','".$proveedor."','".$fila['cod_producto']."','".$no_orden."','".$fila['id_medida']."','".$fila['cantidad']."','".$fila['valor']."')";
	  $reulinsertDetalle = mysqli_query($conexion, $insertDetalleFactura);
	  $totalfactura = $totalfactura + ($fila['cantidad']*$fila['valor']);
	  
    }
 


$insertFactura = "INSERT INTO factura_proveedor_encabezado (tipo_factura, serie, documento, fecha_factura, proveedor, impuesto, credito, total_factura, id_proyecto, id_gasto_proyecto, no_orden, nombre_ingresa) VALUES('MATERIAL','".$serie."','".$documento."','".$fecha_documento."','".$proveedor."','".$impuesto."','".$dias_credito."','".$totalfactura."','".$proyecto."','".$tipo_gasto."','".$no_orden."','".$_SESSION['datos_logueo']['idusuario']."')";
$resinsert = mysqli_query($conexion, $insertFactura);

if(mysqli_affected_rows($conexion)>0){
	
	unset($_SESSION['productos']);
	
	if(!isset($_SESSION['productos'])){
            $_SESSION['productos'] = array();
        }
        cargaimg($serie,$documento,$proveedor);
	
	$return = Array('ok' => TRUE, 'msg' => "Factura grabada correctamente!!");
	
}else{
	$return = Array('ok' => FALSE, 'msg' => "Error al registrar la factura!! ".$insertFactura);
}




function cargaimg($serie, $documento, $proveedor){
	
	
$carpeta="../factura/";
@mkdir($carpeta, 0777, true);
@chmod($carpeta, 0777);

$cant = 0;

if (isset($_FILES["file"])){

     $reporte = null;

     for($x=0; $x<count($_FILES["file"]["name"]); $x++){
	
		$file = $_FILES["file"];
	
		$nombre = $file["name"][$x];
	
		$tipo = $file["type"][$x];
	
		$ruta_provisional = $file["tmp_name"][$x];
	
		$size = $file["size"][$x];
	
		$dimensiones = getimagesize($ruta_provisional);
	
		$width = $dimensiones[0];
	
		$height = $dimensiones[1];
	
		$carpeta = "../factura/";
	
	    if($size > 5024*5024){
	
			$reporte .= "<p class='bg-danger mensaje'>Error $nombre, el tamaño máximo permitido es 1mb</p>";
			//$return = Array('ok' => FALSE, 'msg' => "Error $nombre, el tamaño máximo permitido es 1mb");
	
		}else if($width > 15000 || $height > 15000){
	
			$reporte .= "<p class='bg-danger mensaje'>Error $nombre, la anchura y la altura máxima permitida es de 500px</p>";
	
		}else{
			
			$extension = explode(".",$nombre);
			
			$origen= $ruta_provisional;
			"../factura/".$serie.$documento.$proveedor.'.'.$extension[1];
			//$destino_temporal=tempnam("tmp/","tmp");
			
			$src = "../factura/".$serie.$documento.$proveedor.'.'.$extension[1];
	
			move_uploaded_file($ruta_provisional, $src);
			$cant = $cant + 1;

		}

    }
        
}
}





header('Content-type: application/json; charset=utf-8');
echo json_encode($return);



?>