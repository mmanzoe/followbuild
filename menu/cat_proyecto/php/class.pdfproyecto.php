<?php
include ('../../../lib/PHPMailer/class.envioCorreo.php');
require('../../../lib/mpdf5/vendor/autoload.php');
date_default_timezone_set('America/Guatemala');
$return = Array();

class EnviaPdfProyecto{

    private $empresa;
    private $cod_proyecto;
    private $nom_proyecto;
    private $descripcion;
    private $monto;
    private $encargado;
    private $fases;
    private $gastos;
    private $fecha_creacion;


    function __construct($empresa, $cod_proyecto, $nom_proyecto, $descripcion, $monto, $encargado, $fases, $gastos){
        $this->empresa = $empresa;
        $this->cod_proyecto = $cod_proyecto;
        $this->nom_proyecto = $nom_proyecto;
        $this->descripcion = $descripcion;
        $this->monto = $monto;
        $this->encargado = $encargado;
        $this->fases = $fases;
        $this->gastos = $gastos;
        $this->fecha_creacion = date('d-m-Y H:i:s');
    }

    function enviapdfproyecto(){

        $fase = '';
        foreach ($this->fases as $val) {
            $fase = $fase.'<tr><td>'.$val['nombre'].'</td><td>'.date_format(date_create($val['fecha_inicial']),'d-m-Y').'</td><td>'.date_format(date_create($val['fecha_final']),'d-m-Y').'</td></tr>';
        }

        $gasto = '';
        foreach ($this->gastos as $val) {
            $gasto = $gasto.'<tr><td>'.$val['nombre'].'</td><td>'.$val['monto'].'</td></tr>';
        }
        

        $plantillaPDF = '<header class="clearfix">
          <div id="logo">
            <img src="../../../img/logo.png" width="10%">
          </div>
          <h1>CODIGO PROYECTO '.$this->cod_proyecto.'</h1>
          <h3>FECHA CREACION: '.$this->fecha_creacion.'</h3>
          <div id="project">
            <div><span>NOMBRE: </span>'.$this->nom_proyecto.'</div>
            <div><span>DESCRIPCION: </span>'. $this->descripcion.'</div>
            <div><span>MONTO: </span>'.number_format($this->monto,2,'.',',').'</div>
            <div><span>ENCARGADO: </span>'.$this->encargado.'</div>
          </div>
        </header>
            <main>
          <table>
            <thead>
              <tr><th colspan="3">DETALLE FASES DE PROYECTO</th></tr>
              <tr>
                <th>FASE</th>
                <th>FECHA INICIO</th>
                <th>FECHA FINAL</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                    '.$fase.'
                </tr>
            </tbody>
          </table>
          <table>
            <thead>
              <tr><th colspan="2">DETALLE GASTOS DE PROYECTO</th></tr>
              <tr>
                <th>GASTO</th>
                <th>MONTO</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                    '.$gasto.'
                </tr>
            </tbody>
          </table>
        </main>';

        $mpdf = new \Mpdf\Mpdf();
        $css = file_get_contents('../../../lib/mpdf5/vendor/plantilla.css');
        $mpdf -> writeHTML($css, 1);
        $mpdf -> writeHTML('<div>'.$plantillaPDF.'</div>');
        $mpdf->SetHTMLFooter('{PAGENO}/{nbpg}');
        $emailAttachment = $mpdf->Output('','S');

        $envioCorreo = new EnvioCorreo('mario22121985@gmail.com', 'detalle proyecto creado', 'Adjunto envío pdf del detalle del proyecto generado');
        $envioCorreo->envioMensajeAdjunto(new PHPMailer(), $emailAttachment);

    } 
    
}

?>