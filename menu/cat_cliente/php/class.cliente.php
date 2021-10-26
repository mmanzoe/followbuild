<?php
session_start();
require('../../../php/class.conexion.php');
$return = Array();

class Cliente{
	private $cliente = [];
    private $archivo;
    private $nombre;
    private $razon;
    private $direccion;
    private $telefono1;
    private $telefono2;
    private $nit;
    private $email;
    private $contacto;
    private $telcontacto;
    private $comentario;
    private $id;


	function __construct(){
		$this->conn = new Conexion();
	}

	function listaCliente(){
        $conexion = $this->conn->conectar();
		$consulta = $conexion->query("SET NAMES 'utf8'");
        $consulta = $conexion->prepare("SELECT * FROM cat_cliente");
        $consulta->execute();
		$consulta->store_result();

		if($consulta->num_rows>0){
            $consulta->bind_result($id, $nombre, $razon_social, $direccion, $telefono1, $telefono2, $nit, $email, $credito, $contacto, $tel_contacto, $comentario, $nombre_ingresa, $fecha_ingresa);

            while ($consulta->fetch()) {
                //crear array()
				array_push($this->cliente,array("id"=>$id,"nit"=>$nit,"nombre"=>$nombre, "direccion"=>$direccion,"razon_social"=>$razon_social, "telefono1"=>$telefono1, "telefono2"=>$telefono2, "email"=>$email, "credito"=>$credito, "contacto"=>$contacto, "tel_contacto"=>$tel_contacto, "comentario"=>$comentario, "nombre_ingresa"=>$nombre_ingresa, "fecha_ingresa"=>$fecha_ingresa ));
            }
    
        }

		return $this->cliente;

    }

    function grabarCliente($tipo, $archivo, $nombre, $razon, $direccion, $tel1, $tel2, $nit, $email, $contacto, $telcontacto, $comentario, $id){
        
        $this->nit = $nit;
        $this->archivo = $archivo;

        $conexion = $this->conn->conectar();
        $consulta = $conexion->prepare("SELECT id FROM cat_cliente WHERE nit='".$nit."' AND id='".$id."'");
        $consulta->execute();
		$consulta->store_result();

        if($consulta->num_rows>0){
            $consulta->bind_result($idregistro);            

            $consulta = $conexion->prepare("UPDATE cat_cliente SET nombre='".$nombre."', razon_social='".$razon."', direccion='".$direccion."', telefono1='".$tel1."', telefono2='".$tel2."', nit='".$nit."', email='".$email."', contacto='".$contacto."', tel_contacto='".$telcontacto."', comentario='".$comentario."', nombre_ingresa='".$_SESSION['datos_logueo']['idusuario']."' WHERE id='".$id."' ");
            $this->id = $id;
        }else{

            $consulta = $conexion->prepare("INSERT INTO cat_cliente (nombre, razon_social, direccion, telefono1, telefono2, nit, email, contacto, tel_contacto, comentario, nombre_ingresa) VALUES( '$razon', '$nombre', '$direccion', '$tel1', '$tel2', '$nit', '$email', '$contacto', '$telcontacto','$comentario', '".$_SESSION['datos_logueo']['idusuario']."')");

        }

        
		if($consulta->execute()){
			$this->id = $conexion->insert_id;
            return true;
        }else{
            return false;
        }
        

    }

    function cargaRtu(){

		$archivo = $this->archivo;

		$carpeta="../archivo/";
		@mkdir($carpeta, 0777, true);
		@chmod($carpeta, 0777);
		$return = Array('ok'=>TRUE);

		if (isset($archivo)  && array_sum($archivo['size'])>0){

			$reporte = null;
	   
			for($x=0; $x<count($archivo["name"]); $x++){
		   
			   $file = $archivo;
		   
			   $nombre = $file["name"][$x];
		   
			   $tipo = $file["type"][$x];
		   
			   $ruta_provisional = $file["tmp_name"][$x];
		   
			   $size = $file["size"][$x];
		   
			   $dimensiones = getimagesize($ruta_provisional);
		   
			   $width = $dimensiones[0];
		   
			   $height = $dimensiones[1];
		   
			   $carpeta = "../archivo/";
		   
			   if($size > 5024*5024){
		   
				   $reporte .= "<p class='bg-danger mensaje'>Error $nombre, el tamaño máximo permitido es 1mb</p>";
				   //$return = Array('ok' => FALSE, 'msg' => "Error $nombre, el tamaño máximo permitido es 1mb");
		   
			   }else if($width > 15000 || $height > 15000){
		   
				   $reporte .= "<p class='bg-danger mensaje'>Error $nombre, la anchura y la altura máxima permitida es de 500px</p>";
		   
			   }else{
				   
				   $extension = explode(".",$nombre);
				   
				   $origen= $ruta_provisional;
				   $destino="../archivo/".$this->id.'.'.$extension[1];
				   //$destino_temporal=tempnam("tmp/","tmp");
				   
				   $src = $carpeta.$this->id.'.'.$extension[1];
		   
				   move_uploaded_file($ruta_provisional, $src);
				   
		   
			   }
	   
		   }
			   
	   }

	   return true;

	}

}


?>