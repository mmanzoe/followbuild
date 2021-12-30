<?php 

require('../../php/conect.php');
require('../../lib/mpdf5/vendor/autoload.php');

$id_registro = $_REQUEST['reg'];
$total = 0;
$nitproveedor = '';

$consufactura = "SELECT fce.*, cat_cliente.nombre as nombre_cliente, cat_cliente.direccion, cat_cliente.email, cat_cliente.telefono1, cat_cliente.nit, cat_empresa.nombre as nombre_empresa, cat_empresa.nit as nit_empresa, cat_empresa.direccion as direccion_empresa, cat_empresa.telefono1 as telefono_empresa 
FROM factura_cliente_encabezado AS fce 
INNER JOIN cat_cliente ON (cat_cliente.id = fce.id_cliente) 
INNER JOIN factura_cliente_detalle AS fcd ON(fcd.id_factura = fce.id) 
INNER JOIN cat_proyecto ON (cat_proyecto.id = fcd.id_proyecto) 
INNER JOIN cat_empresa ON (cat_empresa.id_empresa = cat_proyecto.id_empresa) WHERE MD5(fce.id)='".$id_registro."' LIMIT 1";
$resfactura = mysqli_query($conexion, $consufactura);
$row = mysqli_fetch_assoc($resfactura);




$plantillaPDF = '<header class="clearfix">
      <div id="logo">
        <img src="../../img/logo.png" width="10%">
      </div>
      <h1 style="font-size:20px">'.$row['nombre_empresa'].'<br> NIT: '.$row['nit'].'</h1>
	  <div>

		<div width="45%" id="project">
			<div><span>NIT:</span> '.$row['nit'].'</div>
			<div><span>NOMBRE:</span> '.$row['nombre_cliente'].'</div>
			<div><span>DIRECCION:</span> '.$row['direccion'].'</div>
			<div><span>CORREO:</span> '.$row['email'].'</div>
			<div><span>TELEFONO:</span> '.$row['telefono1'].'</div>
		</div>
		<div width="45%" id="project">
			<div><span>FECHA FACTURA:</span> '.date_format(date_create($row['fecha_factura']), 'd-m-Y').'</div>
			<div><span>SERIE:</span> '.$row['serie'].'</div>
			<div><span>NUMERO:</span> '.$row['factura'].'</div>
			<div><span>TELEFONO:</span> '.$row['telefono_empresa'].'</div>
			<div><span>DIRECCION:</span> '.$row['direccion_empresa'].'</div>
		</div>

	  </div>

    </header>
	<main>
      <table>
        <thead>
          <tr>
            <th class="service">CANTIDAD</th>
            <th class="desc">DESCRIPCION</th>
            <th>VALOR</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>';

$query = "SELECT fcd.*, cat_proyecto.nombre_proyecto, cat_proyecto.descripcion 
FROM factura_cliente_detalle AS fcd
INNER JOIN cat_proyecto ON (cat_proyecto.id = fcd.id_proyecto)
WHERE MD5(fcd.id_factura) ='".$id_registro."'";		

$resultados = mysqli_query($conexion, $query);


for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	$plantillaPDF = $plantillaPDF.'<tr>
									<td class="service">1</td>
									<td class="desc">'.$fila['nombre_proyecto'].', '.$fila['descripcion'].'</td>
									<td class="qty"> Q'.number_format($fila['monto'],2,'.',',').'</td>
									<td class="total"> Q'.number_format($fila['monto'],2,'.',',').'</td>
								  </tr>';
	$total = ($total + $fila['monto']);
	
}

$iva = round((($total/1.12) * ($row['monto']/100)),2) ;
$siva = $total - $iva;

$plantillaPDF = $plantillaPDF.'
	  <tr>
	    <td colspan="2">&nbsp;</td>
		<td>TOTAL</td>
		<td class="qty"> Q'.number_format($total,2,'.',',').'</td>
	  </tr>
	  </tbody>
      </table>
    </main>';

$mpdf = new \Mpdf\Mpdf(['format' => [216,170]]);	
//$mpdf = new mPDF('c','A4');
$css = file_get_contents('../../lib/mpdf5/vendor/plantilla.css');
$mpdf -> writeHTML($css, 1);
$mpdf -> writeHTML('<div>'.$plantillaPDF.'</div>');
$mpdf ->Output('FACTURA.pdf','I');

?>