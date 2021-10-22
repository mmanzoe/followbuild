<?php
require ('../../../php/class.conexion.php');

$conn = new Conexion();
$conexion = $conn->conectar();

$id_registro = $_REQUEST['id_usuario'];
$modulo = Array();


$consulta = $conexion->prepare("SELECT * FROM modulo");
$consulta->execute();
$consulta->store_result();

if($consulta->num_rows>0){

    $consulta->bind_result($id, $nombre, $icono, $prioridad, $usuario_ingresa, $fecha_ingresa);

    while ($consulta->fetch()) {

        array_push($modulo, ["id_modulo"=>$id, "nombre"=>$nombre, "icono"=>$icono, "prioridad"=>$prioridad, "acceso"=>Array()]);
        
    }

}

$permisos = Array("modulo"=>$modulo);



$consulta = $conexion->prepare("SELECT sub_modulo.id, sub_modulo.nombre, sub_modulo.modulo, sub_modulo.icono, PU.id_usuario, PU.id AS id_permiso_usuario, modulo.nombre as nombre_modulo  
FROM sub_modulo
LEFT JOIN (SELECT permiso_usuario.* FROM permiso_usuario WHERE id_usuario = ?) AS PU ON (PU.id_sub_modulo = sub_modulo.id)
INNER JOIN modulo ON(modulo.id = sub_modulo.modulo)");
$consulta->bind_param('i',$id_registro);
$consulta->execute();
$consulta->store_result();


if($consulta->num_rows>0){

    $consulta->bind_result($id, $nombre, $id_modulo, $icono, $id_usuario , $id_permiso_usuario, $nombre_modulo);

   
    while ($consulta->fetch()) {
        
        
        for($n=0; $n<count($modulo); $n++){


            if($permisos['modulo'][$n]['id_modulo']==$id_modulo){

                if($id_usuario != null){
                    $acceso = true;
                }else{
                    $acceso = false;
                }
                array_push($permisos['modulo'][$n]['acceso'], ["id_acceso"=>$id, "nombre"=>$nombre, "icono"=>$icono, "permiso"=>$acceso, "id_permiso_usuario"=>$id_permiso_usuario]);
            }
            
        }        
        
    }

}

header('Content-type: application/json; charset=utf-8');
echo json_encode($permisos);


?>