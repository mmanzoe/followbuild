<?php
require ('../../../php/class.conexion.php');

$con = new Conexion();
$conexion = $con->conectar();
$consulta = $conexion->prepare("SELECT * FROM usuario ORDER BY nombre ASC");
$consulta->execute();
$consulta->store_result();
$datos = Array();

if($consulta->num_rows>0){

    $consulta->bind_result($id, $nombre, $correo, $tipo, $usuario, $contrasena, $estado, $idsesion, $token);

    while ($consulta->fetch()) {

        array_push($datos, ["id"=>$id, "nombre"=>$nombre, "correo"=>$correo, "tipo"=>$tipo, "usuario"=>$usuario, "contrasena"=>$contrasena, "estado"=>$estado]);

    }

}

header('Content-type: application/json; charset=utf-8');
echo json_encode($datos);


?>