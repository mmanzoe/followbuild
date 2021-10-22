<?php 
require('../../php/conexion.php');
require('../../php/mpdf5/mpdf.php');

$id_registro = $_REQUEST['id_registro'];
$tipo_orden = $_REQUEST['tipo_orden'];
$observaciones = $_REQUEST['observaciones'];
$proveedor = $_REQUEST['proveedor'];
$total = 0;
$nitproveedor = '';

$consuproveedor = "SELECT ordenc.fecha_ingresa as fechaorden, ordenc.estado, ordenc.nombre_autoriza, ordenc.fecha_autoriza, proveedor.* FROM orden_compra_encabezado as ordenc INNER JOIN proveedor ON(ordenc.cod_proveedor = proveedor.nit) WHERE ordenc.id='".$id_registro."' LIMIT 1";

$resproveedor = mysqli_query($conexion, $consuproveedor);
$row = mysqli_fetch_assoc($resproveedor);

$nombreProveedor = $row['nombre'];
$direccion = $row['direccion'];
$correo = $row['email_proveedor'];
$telefono = $row['tel_proveedor'];


if($row['estado']=='0'){
	$estado = 'Sin Accion';
	$nombreAutoriza = '';
	$fechaAutoriza = '';
}elseif($row['estado']=='1'){
	$estado = 'Validada';
	$nombreAutoriza = $row['nombre_autoriza'];
    $fechaAutoriza = date_format(date_create($row['fecha_autoriza']),'d-m-Y H:i:s');
}elseif($row['estado']=='2'){
	$estado = 'Rechazada';
	$nombreAutoriza = $row['nombre_autoriza'];
    $fechaAutoriza = date_format(date_create($row['fecha_autoriza']),'d-m-Y H:i:s');
}


$plantillaPDF = '<header class="clearfix">
      <div id="logo">
        <img src="../../img/senke.png">
      </div>
      <h1>ALPROMASA ORDEN DE COMPRA No. '.$id_registro.'</h1>
	  <h3>Fecha Solicitud: '.date_format(date_create($row['fechaorden']),'d-m-Y H:i:s').'</h3>
      <div id="project">
        <div><span>NIT PROVEEDOR:</span> '.$proveedor.'</div>
        <div><span>PROVEEDOR:</span> '.$nombreProveedor.'</div>
        <div><span>DIRECCION:</span> '.$direccion.'</div>
        <div><span>CORREO:</span> '.$correo.'</div>
        <div><span>TELEFONO:</span> '.$telefono.'</div>
      </div>
    </header>
	<main>
      <table>
        <thead>
          <tr>
            <th class="service">COD. PRODUCTO</th>
            <th class="desc">DESCRIPCION</th>
            <th>CANTIDAD</th>
            <th>VALOR</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>';





if($tipo_orden == 'MPEP'){	
	$query = "SELECT *, cat_materia_prima.nombre, (valor * cantidad) as total FROM orden_compra_detalle INNER JOIN cat_materia_prima ON (cat_materia_prima.cod_producto = orden_compra_detalle.cod_producto ) INNER JOIN orden_compra_encabezado as ordenc ON (ordenc.id = orden_compra_detalle.id_orden_compra) WHERE id_orden_compra = '".$id_registro."'";
}else if($tipo_orden == 'SUMINISTRO'){
	$query = "SELECT *, (valor * cantidad) as total FROM orden_compra_detalle_sm INNER JOIN orden_compra_encabezado as ordenc ON (ordenc.id = orden_compra_detalle_sm.id_orden_compra) WHERE id_orden_compra = '".$id_registro."'";
}else if($tipo_orden == 'SERVICIO'){
	$query = "SELECT *, (valor * cantidad) as total FROM orden_compra_detalle_sr INNER JOIN orden_compra_encabezado as ordenc ON (ordenc.id = orden_compra_detalle_sr.id_orden_compra) WHERE id_orden_compra = '".$id_registro."'";
}else if($tipo_orden == 'ACTIVOFIJO'){
	$query = "SELECT *, (valor * cantidad) as total FROM orden_compra_detalle_af INNER JOIN orden_compra_encabezado as ordenc ON (ordenc.id = orden_compra_detalle_af.id_orden_compra) WHERE id_orden_compra = '".$id_registro."'";
}

$resultados = mysqli_query($conexion, $query);



for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	$plantillaPDF = $plantillaPDF.'<tr>
									<td class="service">'.@$fila['cod_producto'].'</td>
									<td class="desc">'.@$fila['nombre'].@$fila['descripcion'].'</td>
									<td class="unit">'.$fila['cantidad'].'</td>
									<td class="qty">'.$fila['valor'].'</td>
									<td class="total">'.number_format($fila['total'],2,'.',',').'</td>
								  </tr>';
	$total = ($total + $fila['total']);
	
}

$siva = $total/1.12;
$iva = $total - $siva;

$plantillaPDF = $plantillaPDF.'
	  <tr>
	    <td colspan="3" class="grand total">&nbsp;</td>
		<td class="grand total">IVA</td>
		<td class="qty grand total">'.number_format(($siva),2,'.',',').'</td>
	  </tr>
	  <tr>
	    <td colspan="3">&nbsp;</td>
		<td>SIN IVA</td>
		<td class="qty">'.number_format((($iva)),2,'.',',').'</td>
	  </tr>
	  <tr>
	    <td colspan="3">&nbsp;</td>
		<td>TOTAL</td>
		<td class="qty">'.number_format($total,2,'.',',').'</td>
	  </tr>
	  </tbody>
      </table>
      <div id="notices">
        <div>Observaciones</div>
        <div class="notice">'.$observaciones.'</div>
		<br>
		<div>Estado de Orden de Compra</div>
        <div class="notice">Estado: '.$estado.'</div>
		<div class="notice">Nombre Valida: '.$nombreAutoriza.'</div>
		<div class="notice">Fecha Valida: '.$fechaAutoriza.'</div>
      </div>
    </main>';

$mpdf = new mPDF('c','A4');
$css = file_get_contents('../../php/mpdf5/plantilla.css');
$mpdf -> writeHTML($css, 1);
$mpdf -> writeHTML('<div>'.$plantillaPDF.'</div>');
$mpdf ->Output('Reporte.pdf','I');

?>