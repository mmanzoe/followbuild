<?php
//session_start();
include_once __DIR__ . '/class.conexion.php';

function root_path(){ 
	$this_directory = dirname(__FILE__); 
	$archivos = scandir($this_directory); 
	$atras = ""; 
	$cuenta = 0; 
	while (true){ 
		foreach($archivos as $actual){ 
			if ($actual == "ruta_actual.php"){ 
				if ($cuenta == 0) 
				return "./"; 
				return $atras; 
			} 
		} 
		$cuenta++; 
		$atras = $atras . "../"; 
		$archivos = scandir($atras); 
	} 
}  

$raiz = root_path();


$conn = new Conexion();
$conexion = $conn->conectar();
$consulta = $conexion->prepare("SELECT sub_modulo.modulo, modulo.nombre, modulo.icono 
FROM permiso_usuario AS PU 
INNER JOIN sub_modulo ON(sub_modulo.id = PU.id_sub_modulo) 
INNER JOIN modulo ON (modulo.id = sub_modulo.modulo)
WHERE PU.id_usuario = '".$_SESSION['datos_logueo']['idusuario']."'
GROUP by sub_modulo.modulo
ORDER BY modulo.prioridad asc");
$consulta->execute();
$consulta->store_result();

if($consulta->num_rows>0){

	$categoria = array();
	$consulta->bind_result($id, $nombre, $icono);

	while ($consulta->fetch()) {
		
		$consul = $conexion->prepare("SELECT PU.id_usuario, sub_modulo.nombre AS NOMSUBMODULO, sub_modulo.ruta, modulo.nombre AS NOMMODULO, sub_modulo.icono FROM permiso_usuario AS PU
		INNER JOIN sub_modulo ON(sub_modulo.id = PU.id_sub_modulo)
		INNER JOIN modulo ON(modulo.id = sub_modulo.modulo) WHERE PU.id_usuario='".$_SESSION['datos_logueo']['idusuario']."' AND modulo.id =".$id);
		$consul->execute();
		$consul->store_result();

		if($consul->num_rows>0){
			$dato=array();
			$consul->bind_result($idcat, $nombrecat, $ruta, $modulocat, $iconocat);
			
			while($consul->fetch()){
				array_push($dato, array("categoria"=>$nombrecat,"ruta"=>$ruta,"icon_submodulo"=>$iconocat, "icon_modulo"=>$icono));
			}

		}
		$categoria[$nombre] = $dato;
	}
}

$conexion->close();

echo '<h3 class="menu-title"></h3>';
if($consulta->num_rows>0){

	foreach($categoria as $registro=>$ago){

		echo '<li class="menu-item-has-children dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa '.$categoria[$registro][0]['icon_modulo'].'"></i>'.$registro.'</a>
					<ul class="sub-menu children dropdown-menu">';
	
		for($n=0; $n<count($categoria[$registro]);$n++){
			echo '<li><i class="fa '.$categoria[$registro][$n]['icon_submodulo'].'"></i><a href="'.$raiz.'menu/'.$categoria[$registro][$n]['ruta'].'">'.$categoria[$registro][$n]['categoria'].'</a></li>';
			
		}
	
		echo '</ul></li>';
	}


}


?>