<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/class.conexion.php');
$return = Array();



class Municipio{
    private $municipio = [];

    function __construct(){
		$this->conn = new Conexion();
	}

    function listaMunicipio($id_pais, $id_departamento){
        $conexion = $this->conn->conectar();
		$consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT cat_municipio.*, cat_departamento.id_pais FROM cat_municipio INNER JOIN cat_departamento ON(cat_departamento.id = cat_municipio.id_departamento)
		WHERE cat_municipio.id_departamento='".$id_departamento."' AND cat_departamento.id_pais='".$id_pais."'  ORDER BY nombre ASC");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $id_departamento, $nombre, $idpais);

            while ($consulta->fetch()) {
                //crear array()
				array_push($this->municipio,array("id"=>$id, "id_departamento"=>$id_departamento, "nombre"=>$nombre, "id_pais"=>$idpais ));
            }
    
        }

		return $this->municipio;

    }


}

/*
$id_departamento = $_REQUEST['id_departamento'];
$id_pais = $_REQUEST['id_pais'];

$consu = "SELECT cat_municipio.*, cat_departamento.id_pais FROM cat_municipio INNER JOIN cat_departamento ON(cat_departamento.id = cat_municipio.id_departamento)
 WHERE cat_municipio.id_departamento='".$id_departamento."' AND cat_departamento.id_pais='".$id_pais."'  ORDER BY nombre ASC";
$resultados = mysqli_query($conexion, $consu);

echo '<table class="table table-small-font table-bordered table-striped">
		<thead>
		  <tr>
                        <th>Municipio</th>
		  </tr>
		</thead>
		<tbody>';
		
for($n=0; $n<mysqli_num_rows($resultados); $n++){
	$fila = mysqli_fetch_assoc($resultados);
	
	echo '<tr>
                        <td>'.$fila['nombre'].'</td>
		  </tr>';
	
}		

echo'</tbody></table>';
*/


$municipio = new Municipio();

if($_REQUEST['tipo']=='read'){
	$registros = $municipio->listaMunicipio($_REQUEST['id_pais'], $_REQUEST['id_departamento']);
}else if($_REQUEST['tipo']=='create'){
	$registros = $municipio->grabaMunicipio( isset($_REQUEST['id'])?$_REQUEST['id']:null, strtoupper($_REQUEST['nombre_pais']));

	
	if($registros){
		$registros = Array('ok'=>true, 'msg'=>'Registro grabado correctamente');
	}else{
		$registros = Array('ok'=>false, 'msg'=>'Error al grabar el registro');
	}
	
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($registros);


?>