<?php
session_start();
require('../../../php/conect.php');

$total = 0;
$simbolo = $_REQUEST['simbolo'];


echo '<table class="table table-small-font">
      <thead>
	    <tr>
		  <th>Proveedor</th>
		  <th>Cod. Mp/Ep</th>
		  <th>Descripcion</th>
		  <th>Cantidad</th>
		  <th>Valor</th>
		  <th>Total</th>
		  <th>eliminar</th>
		</tr>
	  </thead>
	  <tbody>';

if(isset($_SESSION['productos'])){
	  
  for($n=0; $n<= count($_SESSION['productos']) -1; $n++){
	  
	  echo '<tr>';
	  echo '<td>'.$_SESSION['productos'][$n][0].'</td>';
	  echo '<td>'.$_SESSION['productos'][$n][1].'</td>';
	  echo '<td>'.$_SESSION['productos'][$n][2].'</td>';
	  echo '<td>'.$_SESSION['productos'][$n][4].'</td>';
	  echo '<td class="text-right">'.$simbolo.number_format($_SESSION['productos'][$n][3],2,'.',',').'</td>';
	  echo '<td class="text-right">'.$simbolo.number_format($_SESSION['productos'][$n][5],2,'.',',').'</td>';
	  echo '<td class="text-center"><a href="" class="eliminar" id="'.$n.'"><span class="fa fa-remove fa-2x"></span></a></td>';
	  echo '</tr>';
	  
	  $total = $total + (@$_SESSION['productos'][$n][5]);
      $proveedor = $_SESSION['productos'][$n][0];
  
  }
}


$consuproveedor = "SELECT cat_proveedor.*, ctc.impuesto FROM cat_proveedor INNER JOIN cat_tipo_contribuyente as ctc ON(ctc.id = cat_proveedor.id_tipo_contribuyente) WHERE cat_proveedor.nit ='".$proveedor."' LIMIT 1";
$resulproveedor = mysqli_query($conexion, $consuproveedor);
$row = mysqli_fetch_assoc($resulproveedor);



$iva = round ((($total/1.12) * ($row['impuesto']/100)),2);
$siva = $total - $iva;


echo '<tr><td colspan="7"></td></tr>
      <tr>
        <td colspan="4">&nbsp;</td>
		<td>SIN IVA</td>
		<td class="text-right">'.$simbolo.number_format($siva, 2, '.', ',').'</td>
		<td>&nbsp;</td>
      </tr>
	  <tr>
        <td colspan="4">&nbsp;</td>
		<td>IVA</td>
		<td class="text-right">'.$simbolo.number_format($iva, 2, '.', ',').'</td>
		<td>&nbsp;</td>
      </tr>
	  <tr>
        <td colspan="4">&nbsp;</td>
		<td>TOTAL</td>
		<td class="text-right">'.$simbolo.number_format($total, 2, '.', ',').'</td>
		<td>&nbsp;</td>
      </tr>
	  <tr><td colspan="7"></td></tr>
	  <tr><td colspan="7"><input type="button" class="btn btn-success trasladar" value="Trasladar"></td></tr>';

echo '</tbody></table>';


?>