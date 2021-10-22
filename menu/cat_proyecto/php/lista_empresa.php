<?php
require('../../cat_empresa/php/class.empresa.php');

$empresa = new Empresa();
$registros = $empresa->listaEmpresa();

for($n=0;$n<count($registros);$n++){
	echo '<option value="'.$registros[$n]['id'].'">'.$registros[$n]['nombre'].'</option>';
}


?>