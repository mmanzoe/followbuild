<?php
session_start();
require_once ('../../../class/class.session.php');
require_once ('../../../php/conect.php');

$validaAcceso = new validasesion();
//if($validaAcceso->getValidaLogin()===true){}else{header('location: ../');};

if(!isset( $_SESSION['datos_logueo']['estado'] )){
    if( $_SESSION['datos_logueo']['estado']!=TRUE){
        header('location: ../');
    }
    header('location: ../');
}

$orden_compra = $_REQUEST['orden_compra'];
//$tipo_factura = $_REQUEST['tipo_factura'];
$total = 0;

$consulta = "SELECT oce.cod_proveedor, ordenc.*, cat_producto.nombre as nombre_materia_prima, cat_medida.nombre as nombre_medida FROM orden_compra_detalle as ordenc INNER JOIN orden_compra_encabezado as oce ON(oce.id = ordenc.id_orden_compra) INNER JOIN cat_producto ON(cat_producto.codigo_producto = ordenc.cod_producto) INNER JOIN cat_medida ON(cat_medida.id = cat_producto.id_medida) WHERE id_orden_compra = '".$orden_compra."' ";
$resultados = mysqli_query($conexion, $consulta);


echo '<table class="table table-small-font table-bordered table-striped">
        <thead>
        <tr>
                <th>Codigo Producto</th>
                <th>Nombre producto</th>
                <th>Cantidad</th>
                <th>Medida</th>
                <th>Valor</th>
                <th>Total</th>
                <th>Acciones</th>
                
            </tr>
        </thead>
        <tbody>';
      

for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
            
    echo '<tr>
            <td>'.$fila['cod_producto'].'</td>
            <td>'.$fila['nombre_materia_prima'].'</td>
            <td><input type="text" value="'.$fila['cantidad'].'" id="cant'.$fila['id'].'"></td>
            <td>'.$fila['nombre_medida'].'</td>    
            <td><input type="text" value="'.$fila['valor'].'" id="val'.$fila['id'].'"></td>
            <td>Q '.number_format(($fila['cantidad']*$fila['valor']),2,'.',',').'</td>
            <td><a href="" idregistro="'.$fila['id'].'" class="elimina"><span class="fa fa-times-circle"></span></a> | <a href="" idregistro="'.$fila['id'].'" class="editar"><span class="fa fa-refresh"></span></a></td>
            </tr>';
    
    $proveedor = $fila['cod_proveedor'];
           
    $total = $total +($fila['cantidad']*$fila['valor']); 
	
}


$consuproveedor = "SELECT cat_proveedor.*, ctc.impuesto FROM cat_proveedor INNER JOIN cat_tipo_contribuyente as ctc ON(ctc.id = cat_proveedor.id_tipo_contribuyente) WHERE cat_proveedor.nit ='".$proveedor."' LIMIT 1";
$resulproveedor = mysqli_query($conexion, $consuproveedor);
$row = mysqli_fetch_assoc($resulproveedor);

$iva = round ((($total/1.12) * ($row['impuesto']/100)),2);
$siva = $total - $iva;

echo '<tr>'
. '<td colspan="8">&nbsp;</td>'
. '</tr>'
        . '<tr>'
        . '<td colspan="7"><input type="button" class="btn btn-info btn-sm agregarregistro" value="Agregar"> <input type="button" class="btn btn-success btn-sm trasladaorden" value="Valida Factura"></td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="4" class="text-right">IVA</td>'
        . '<td colspan="3">Q '.number_format($iva,2,'.',',').'</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="4" class="text-right">SIN IVA</td>'
        . '<td colspan="3">Q '.number_format($siva,2,'.',',').'</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="4" class="text-right">TOTAL</td>'
        . '<td colspan="3">Q '.number_format($total,2,'.',',').'</td>'
        . '</tr>';

echo '<tbody></table>';

?>