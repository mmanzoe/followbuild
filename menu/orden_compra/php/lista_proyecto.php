<?php
require('../../cat_proyecto/php/class.proyecto.php');

$proyecto = new Proyecto();
$resultados = $proyecto->listado();

echo '<option>SELECCIONE</option>';
for($n=0; $n<count($resultados); $n++){
    echo '<option id_proyecto="'.$resultados[$n]['id'].'">'.$resultados[$n]['nombre_proyecto'].'</option>';
}

?>