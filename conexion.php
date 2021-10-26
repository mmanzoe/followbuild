<?php
$host = 'localhost';
$user = 'pgacom_followbuild';
$pass = 'followbuild.';
$data = 'pgacom_followbuild';

$conn = mysqli_connect($host, $user, $pass) or die('Error al conectar con el servidor');
mysqli_select_db($conn, $data) or die('problemas con la base de datos');



?>