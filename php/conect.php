<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$data = 'followbuild';

$conexion = mysqli_connect($host, $user, $pass);
mysqli_select_db($conexion, $data);

?>