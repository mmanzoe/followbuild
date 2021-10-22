<?php
/*
$dpi = (isset($_REQUEST['dpi']))?$_REQUEST['dpi']:null;
$nombre = (isset($_REQUEST['nombre']))?$_REQUEST['nombre']:null;
*/

$dpi = $_REQUEST['dpi']??null;
$nombre = $_REQUEST['nombre']??null;
$correo = array('1','2','3','4');


datos($dpi,$nombre,'manzo','35',$correo);

function datos($dpi, $nombre, $apellido, $edad=null, $correo=null){

    //echo $dpi.' '.$nombre.' '.$apellido.' '.$edad;
    echo gettype($dpi);
    print_r($correo);

}

?>