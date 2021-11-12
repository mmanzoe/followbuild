<?php

$serie = $_REQUEST['serie'];
$documento = $_REQUEST['documento'];
$proveedor = $_REQUEST['proveedor'];

$directorio = opendir("../../ingreso_factura_proveedor/factura/"); //ruta de la carpeta factura donde se cargan copias de las facturas
while ($archivo = readdir($directorio)){//obtenemos un archivo y luego otro sucesivamente

    if (!is_dir($archivo)){//verificamos si es o no un directorio   
        //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
		
		$nombre = explode(".", $archivo);
		
		if($nombre[0] == $serie.$documento.$proveedor){
			echo $archivo;
			break;
		}
		
    }
  
}


?>