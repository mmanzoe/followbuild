<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');


class Proveedor{

	private $proveedor = '';

	function __construct(){
        $this->conn = new Conexion();
    }

	function listaProveedor($nombre){
        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT id, nit, nombre, credito FROM cat_proveedor WHERE nombre LIKE '%".$nombre."%' ORDER BY nit asc");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $nit, $nombre, $credito);

            while ($consulta->fetch()) {
                //crear array()
				@$proveedor = $proveedor.'<tr>
											<td>'.$nit.'</td>
											<td>'.$nombre.'</td>
											<td><a href="" class="agregaproveedor" nit="'.$nit.'" nombre="'.$nombre.'" credito="'.$credito.'"><span class="fa fa-plus-circle"></span></a></td>
										</tr>';
				//array_push($this->tipocontribuyente,array("id"=>$id, "nombre"=>$nombre, "impuesto"=>$impuesto));
            }
    
        }

		return $proveedor;

    }

}


$proveedor = new Proveedor();
$registros = $proveedor->listaProveedor($_REQUEST['nombreproveedor']);


echo '<table class="table table-small-font table-bordered table-striped">
      <thead>
	    <tr>
		  <th>Nit</th>
		  <th>Nombre</th>
		  <th>Agregar</th>
		</tr>
	  </thead>
	  <tbody>';
echo $registros;
echo '</tbody></table>';

?>