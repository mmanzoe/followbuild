<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
$result = Array();

$proveedor = $_REQUEST['proveedor'];
$estado = $_REQUEST['estado'];
$tipo_orden = $_REQUEST['tipo_orden'];
$fechai = $_REQUEST['fechai'];
$fechaf = $_REQUEST['fechaf'];


if($proveedor == ''){
	$proveedorsql = " oce.cod_proveedor != '' ";
}else{
	$proveedorsql = " oce.cod_proveedor = '".$proveedor."' ";
}

if($estado == ''){
	$estadosql = " AND oce.estado != '9' ";
}else{
	$estadosql = " AND oce.estado = '".$estado."' ";
}

if($tipo_orden == ''){
        $tipoordensql = "AND oce.tipo_orden != '' ";
}else{
        $tipoordensql = "AND oce.tipo_orden = '".$tipo_orden."'";
}

if($fechai == '' || $fechaf == ''){
	$fecha = "";
}elseif($fechai != '0000-00-00' || $fechaf != '0000-00-00'){
	$fecha = " AND DATE(oce.fecha_ingresa) BETWEEN DATE('".$fechai."') AND DATE('".$fechaf."')";
}

$consulta = "SELECT oce.*, cat_proveedor.nombre as nom_proveedor, fac_en.documento, fac_en.serie, ceoc.nombre as nombre_estado, usuario.nombre as nombre_ingresa, usuario_au.nombre as nombre_valida FROM orden_compra_encabezado as oce
INNER JOIN cat_proveedor ON (cat_proveedor.nit = oce.cod_proveedor)
INNER JOIN cat_estado_orden_compra AS ceoc ON (ceoc.id = oce.estado)
INNER JOIN usuario ON (usuario.id = oce.id_usuario_ingresa)
INNER JOIN usuario AS usuario_au ON (usuario_au.id = oce.nombre_autoriza)
LEFT JOIN factura_proveedor_encabezado as fac_en ON(fac_en.no_orden = oce.id) WHERE ".$proveedorsql.$estadosql.$tipoordensql.$fecha." ORDER BY oce.id asc";
$resultados = mysqli_query($conexion, $consulta);

	 
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
        
        $colorfila = '';
        
        if($fila['documento'] == NULL){
            $rutafactura = '';
            
            if($fila['estado'] == '1'){
                $accion = '<a href="#" class="rechazar" id_registro="'.$fila['id'].'" alt="rechazar"><span class="fa fa-times-circle" ></span></a>';
            }else{
                $accion = '';
            }
            
        }else{
            $rutafactura = '<a href="../ingreso_factura_proveedor/factura/'.$fila['serie'].$fila['documento'].$fila['cod_proveedor'].'.JPG" alt="visualiza factura" target="_blank"><span class="fa fa-download"></span></a>';
            $accion = '';
                    
        }
        
        array_push($result,["id"=>$fila['id'], "nom_proveedor"=>$fila['nom_proveedor'], "tipo_orden"=>$fila['tipo_orden'], 
        "monto"=>number_format($fila['total_ordencompra'],2,'.',','), "nombre_ingresa"=>$fila['nombre_ingresa'], 
        "fecha_ingresa"=>date_format(date_create($fila['fecha_ingresa']),'d-m-Y H:i:s'), "nombre_estado"=>$fila['nombre_estado'], 
        "nombre_autoriza"=>$fila['nombre_valida'], "fecha_autoriza"=>date_format(date_create($fila['fecha_autoriza']),'d-m-Y H:i:s'), 
        "acciones"=>'<a href="" class="listadetalle" alt="detalle" idregistro="'.$fila['id'].'" tipo_orden="'.$fila['tipo_orden'].'" proveedor="'.$fila['cod_proveedor'].'"  observaciones="'.$fila['observaciones'].'" target="_blank"><span class="fa fa-list"></span></a> | <a href="../autoriza_orden_compra/reporte.php?id_registro='.$fila['id'].'&tipo_orden='.$fila['tipo_orden'].'&proveedor='.$fila['cod_proveedor'].'&observaciones='.$fila['observaciones'].'" target="_blank" alt="Descarga pdf"><span class="fa fa-download"></span></a> | '.$rutafactura.' | '.$accion ] );
	
}


header ('Content-type: application/json; charset=utf8-8');
echo json_encode($result);

?>