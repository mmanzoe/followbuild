<?php
$host = '192.168.86.200';
$user = 'root';
$pass = 'm.estrada';
$data = 'prueba';

$conn = mysqli_connect($host, $user, $pass) or die('Error al conectar con el servidor');
mysqli_select_db($conn, $data) or die('problemas con la base de datos');

mysqli_query($conn,"CREATE TABLE `c_banco` (
    `id` int(10) NOT NULL,
    `nombre` varchar(50) NOT NULL,
    `cuenta` varchar(25) NOT NULL,
    `fecha_crea` datetime NOT NULL,
    `tipo_banco` int(2) NOT NULL DEFAULT 1,
    `usuario_crea` int(10) NOT NULL,
    `estado` tinyint(4) NOT NULL DEFAULT 1
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

?>