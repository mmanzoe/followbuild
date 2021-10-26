<?php
session_start();
date_default_timezone_set('America/Guatemala');
require('../../../php/conect.php');
require('../../../lib/mpdf5/vendor/autoload.php');
require('../../../lib/PHPMailer/class.phpmailer.php');
require('../../../lib/PHPMailer/class.smtp.php');
$return = Array('ok'=>TRUE);

$idregistro = $_REQUEST['idregistro'];
$correo = $_REQUEST['correo'];


$update = "UPDATE orden_compra_encabezado SET estado = '2', nombre_autoriza='".$_SESSION['datos_logueo']['idusuario']."', fecha_autoriza='".date('Y-m-d H:i:s')."' WHERE id ='".$idregistro."'";
$resultado = mysqli_query($conexion, $update);


if(mysqli_affected_rows($conexion)>0){
	$return = Array('ok' => TRUE, 'msg' => "registro autorizado correctamente");
}else{
	$return = Array('ok' => FALSE, 'msg' => "Error de autorizaion de registro ");
}


if($correo == 'true'){
    $consuorden = "SELECT * FROM orden_compra_encabezado WHERE id='".$idregistro."' LIMIT 1";
    $resulconsu = mysqli_query($conexion, $consuorden);
    $registro = mysqli_fetch_assoc($resulconsu);
    
    enviocorreo($idregistro, $registro['cod_proveedor'], $registro['tipo_orden'], $registro['observaciones']);
}


function enviocorreo($id_registro, $proveedor, $tipo_orden, $observaciones){
    
    require('../../../php/conect.php');
    /*
    $id_registro = $idregistro;
    $proveedor = $registro['cod_proveedor'];
    $tipo_orden = $registro['tipo_orden'];
    $observaciones = $registro['observaciones'];
    */
    
    $consuproveedor = "SELECT ordenc.fecha_ingresa as fechaorden, ordenc.estado, ordenc.nombre_autoriza, ordenc.fecha_autoriza, cat_proveedor.*, ctc.impuesto FROM orden_compra_encabezado as ordenc "
            . "INNER JOIN cat_proveedor ON(ordenc.cod_proveedor = cat_proveedor.nit) "
            . "INNER JOIN cat_tipo_contribuyente as ctc ON(ctc.id = cat_proveedor.id_tipo_contribuyente)"
            . "WHERE ordenc.id='".$id_registro."' LIMIT 1";

    $resproveedor = mysqli_query($conexion, $consuproveedor);
    $row = mysqli_fetch_assoc($resproveedor);

    $nombreProveedor = $row['nombre'];
    $direccion = $row['direccion'];
    $correo = $row['email_proveedor'];
    $telefono = $row['tel_proveedor'];
    $estado = 'Validada';
    $nombreAutoriza = $row['nombre_autoriza'];
    $fechaAutoriza = date_format(date_create($row['fecha_autoriza']),'d-m-Y H:i:s');


    $plantillaPDF = '<header class="clearfix">
          <div id="logo">
            <img src="../../../img/logo.png" width="10%">
          </div>
          <h1>ORDEN DE COMPRA No. '.$id_registro.'</h1>
              <h3>Fecha Solicitud: '.date_format(date_create($row['fechaorden']),'d-m-Y H:i:s').'</h3>
          <div id="project">
            <div><span>NIT PROVEEDOR:</span> '.$proveedor.'</div>
            <div><span>PROVEEDOR:</span> '.$nombreProveedor.'</div>
            <div><span>DIRECCION:</span> '.$direccion.'</div>
            <div><span>CORREO:</span> '.$correo.'</div>
            <div><span>TELEFONO:</span> '.$telefono.'</div>
          </div>
        </header>
            <main>
          <table>
            <thead>
              <tr>
                <th class="service">COD. PRODUCTO</th>
                <th class="desc">DESCRIPCION</th>
                <th>CANTIDAD</th>
                <th>VALOR</th>
                <th>TOTAL</th>
              </tr>
            </thead>
            <tbody>';


    	
        $query = "SELECT *, cat_producto.nombre, (valor * cantidad) as total FROM orden_compra_detalle INNER JOIN cat_producto ON (cat_producto.codigo_producto = orden_compra_detalle.cod_producto ) INNER JOIN orden_compra_encabezado as ordenc ON (ordenc.id = orden_compra_detalle.id_orden_compra) WHERE id_orden_compra = '".$id_registro."'";
        $resultados = mysqli_query($conexion, $query);


        $total = 0;
    for($n=0; $n<mysqli_num_rows($resultados); $n++){
            $fila = mysqli_fetch_assoc($resultados);

            $plantillaPDF = $plantillaPDF.'<tr>
                                                <td class="service">'.@$fila['cod_producto'].'</td>
                                                <td class="desc">'.@$fila['nombre'].@$fila['descripcion'].'</td>
                                                <td class="unit">'.$fila['cantidad'].'</td>
                                                <td class="qty">'.$fila['valor'].'</td>
                                                <td class="total">'.number_format($fila['total'],2,'.',',').'</td>
                                          </tr>';
            $total = ($total + $fila['total']);

    }
    
    $iva = round((($total/1.12)*($row['impuesto']/100)),2);
    $siva = $total - $iva;

    $plantillaPDF = $plantillaPDF.'
              <tr>
                <td colspan="3" class="grand total">&nbsp;</td>
                    <td class="grand total">IVA</td>
                    <td class="qty grand total">'.number_format($iva,2,'.',',').'</td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
                    <td>SIN IVA</td>
                    <td class="qty">'.number_format($siva,2,'.',',').'</td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
                    <td>TOTAL</td>
                    <td class="qty">'.number_format($total,2,'.',',').'</td>
              </tr>
              </tbody>
          </table>
          <div id="notices">
            <div>Observaciones</div>
            <div class="notice">'.$observaciones.'</div>
                    <br>
                    <div>Estado de Orden de Compra</div>
                    <div class="notice">Estado: '.$estado.'</div>
                    <div class="notice">Fecha Valida: '.$fechaAutoriza.'</div>
          </div>
        </main>';

        $mpdf = new \Mpdf\Mpdf();
        $css = file_get_contents('../../../lib/mpdf5/vendor/plantilla.css');
        $mpdf -> writeHTML($css, 1);
        $mpdf -> writeHTML('<div>'.$plantillaPDF.'</div>');
        $emailAttachment = $mpdf->Output('','S');
    


        $mensaje = "<table>
              <tr>
		            <td>Followbuild</td>
                <td>Adjunto envio solicitud de orden de compra, corrreo enviado automaticamente</td>
                <td>Cualquier duda o comentario por favor de comunicarse con Followbuild</td>
              </tr>
            </table>";



//Envio de correo electronico


	$mail = new PHPMailer();
    
	$mail->IsSMTP(); 

	//Sustituye (ServidorDeCorreoSMTP)  por el host de tu servidor de correo SMTP
  $mail->Host = "smtp.gmail.com";		
  $mail->Port       = 465;  
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = "ssl"; 
  $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	
	//Sustituye  ( CuentaDeEnvio )  por la cuenta desde la que deseas enviar
	$mail->From     = 'mario22121985@gmail.com';
	$mail->FromName = "Orden Compra Followbuild";
	$mail->Subject  = "Orden Compra Followbuild";
	$mail->AltBody  = "Leer"; 
	$mail->MsgHTML($mensaje);
	$mail->AddStringAttachment($emailAttachment, 'ORDEN_DE_COMPRA.pdf', 'base64', 'application/pdf');// attachment

	// Sustituye  (CuentaDestino )  por la cuenta a la que deseas enviar por ejem. usuario@destino.com  
	//$mail->AddAddress($correo,'');
        $mail->AddAddress('mario22121985@hotmail.com','');
	$mail->SMTPAuth = true;

	$mail->Username = 'mario22121985@gmail.com';
	$mail->Password = 'Mrme22121985.';
	$mail->Send();

    
}


header('Content-type: application/json; charset=utf-8');
echo json_encode($return);

?>