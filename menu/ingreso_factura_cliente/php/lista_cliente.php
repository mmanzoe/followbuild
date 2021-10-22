<?php
require('../../cat_cliente/php/class.cliente.php');

$cliente = new Cliente();
$registros = $cliente->listaCliente();


echo '<table class="table table-small-font table-bordered table-striped">
      <thead>
	    <tr>
		  <th>ID</th>
          <th>Cod Proyecto</th>
		  <th>Nombre</th>
          <th></th>
		</tr>
	  </thead>
	  <tbody>';

	  

for($n=0; $n<count($registros); $n++){
	
	echo '<tr>
	        <td>'.$registros[$n]['id'].'</td>
			<td>'.$registros[$n]['nombre'].'</td>
			<td><a href="" class="agregacliente" id="'.$registros[$n]['id'].'" nombre="'.$registros[$n]['nombre'].'"><span class="fa fa-plus-circle"></span></a></td>
	      </tr>';
	
}

echo '</tbody></table>';

?>