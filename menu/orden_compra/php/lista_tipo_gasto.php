<?php
require('../../cat_proyecto/php/class.proyecto.php');

$proyecto = new Proyecto();
$resultados = $proyecto->listagastosproyecto($_REQUEST['id_proyecto']);


for($n=0; $n<count($resultados); $n++){
    echo '<option id_gasto="'.$resultados[$n]['id_tipo_gasto'].'">'.$resultados[$n]['nombre'].'</option>';
}

?>