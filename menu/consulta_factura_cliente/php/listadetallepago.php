<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');

$id_registro = $_REQUEST['idregistro'];

$query = "SELECT detalle.*, cat_banco.nombre as nom_banco, tipo_pago.nombre as nom_tipopago FROM detalle_pago_cliente as detalle INNER JOIN cat_banco ON(cat_banco.id = detalle.id_banco) INNER JOIN cat_tipo_pago_proveedor AS tipo_pago ON(detalle.id_tipo_pago = tipo_pago.id) WHERE detalle.id_factura ='".$id_registro."'";
$resultados = mysqli_query($conexion, $query);

	
echo '<table class="table table-small-font table-bordered table-striped">
	<thead>
	  <tr>
		<th>Banco</th>
		<th>Tipo Pago</th>
		<th>Documento Valida</th>
		<th>Valor</th>
		<th>Nombre Valida</th>
		<th>Fecha Valida</th>
	  </tr>
	</thead>
	<tbody>';
	

		
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
        if($fila['nom_tipopago'] == 'RETENCION'){
            $nombre_pago = '<a href="" class="retencion" ruta="'.$fila['archivo_retencion'].'">'.$fila['nom_tipopago'].'</a>';
        }else{
            $nombre_pago = $fila['nom_tipopago'];
        }
        
	echo '<tr>
	  <td>'.$fila['nom_banco'].'</td>
	  <td>'.$nombre_pago.'</td>
	  <td>'.$fila['documento_valida'].'</td>
	  <td>'.$fila['valor'].'</td>
	  <td>'.$fila['nombre_ingresa'].'</td>
	  <td>'.$fila['fecha_ingresa'].'</td>
	</tr>';
	
}		

echo'</tbody></table>';


?>