<?php
require('../../../php/conect.php');
header('Content-type: application/json; charset=utf-8');
$return = Array('ok'=>TRUE);

$idregistro = $_REQUEST['idregistro'];
$serie = $_REQUEST['serie'];
$documento = $_REQUEST['documento'];
$proveedor = $_REQUEST['proveedor'];
$tipo_fac = $_REQUEST['tipo_fac'];


if($tipo_fac == 'MPEP'){
	
	$consu = "SELECT factdetalle.*, inventario_bodega.pendiente_incorporar as pendiente, cat_materia_prima.tipo_materia, cat_materia_prima.peso_kg, cat_materia_prima.unidad FROM factura_detalle as factdetalle INNER JOIN inventario_bodega ON (inventario_bodega.codigo_producto = factdetalle.cod_materia_prima) INNER JOIN cat_materia_prima ON(cat_materia_prima.cod_producto = factdetalle.cod_materia_prima) WHERE factdetalle.serie='".$serie."' AND factdetalle.documento='".$documento."' AND factdetalle.proveedor='".$proveedor."'";
	$resultados = mysqli_query($conexion, $consu);
	
	for($x=0; $x<mysqli_num_rows($resultados); $x++){
		$fila = mysqli_fetch_assoc($resultados);
		
		if($fila['tipo_materia']=='MPR'){
			$update = "UPDATE inventario_bodega SET pendiente_incorporar = '".($fila['pendiente'] - ($fila['cantidad']*$fila['peso_kg']))."' WHERE codigo_producto = '".$fila['cod_materia_prima']."'";
		$resupdate = mysqli_query($conexion, $update);
			
		}else if($fila['tipo_materia']=='EPQ'){
			$update = "UPDATE inventario_bodega SET pendiente_incorporar = '".($fila['pendiente'] - ($fila['cantidad']*$fila['unidad']))."' WHERE codigo_producto = '".$fila['cod_materia_prima']."'";
		$resupdate = mysqli_query($conexion, $update);
		}
		
		
		
	}
	
	$deletedetalle ="DELETE FROM factura_detalle WHERE serie='".$serie."' AND documento = '".$documento."' AND proveedor='".$proveedor."'";
	
}else if($tipo_fac == 'SUMINISTRO'){
	
	$deletedetalle ="DELETE FROM factura_detalle_sm WHERE serie='".$serie."' AND documento = '".$documento."' AND proveedor='".$proveedor."'";

}else if($tipo_fac == 'SERVICIO'){
	
	$deletedetalle ="DELETE FROM factura_detalle_sr WHERE serie='".$serie."' AND documento = '".$documento."' AND proveedor='".$proveedor."'";
	
}else if($tipo_fac == 'ACTIVOFIJO'){
    $deletedetalle ="DELETE FROM factura_detalle_af WHERE serie='".$serie."' AND documento = '".$documento."' AND proveedor='".$proveedor."'";
}



$deletefactura = "DELETE FROM factura_encabezado WHERE serie='".$serie."' AND documento = '".$documento."' AND proveedor='".$proveedor."'";
$resdeletefactura = mysqli_query($conexion, $deletefactura);
$resdedetedetalle = mysqli_query($conexion, $deletedetalle); 



$return = Array('ok' => TRUE, 'msg' => "Factura Eliminada correctamente!");
echo json_encode($return);

?>