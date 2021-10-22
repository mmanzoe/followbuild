<?php

require_once('vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new html2pdf('A4');
$html2pdf->writeHTML('<h3>hola</h3>');
$html2pdf->output('nombre.pdf');

?>