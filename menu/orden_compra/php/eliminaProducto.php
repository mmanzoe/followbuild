<?php
session_start();

$valorArreglo = $_REQUEST['valorArreglo'];
array_splice($_SESSION['productos'], $valorArreglo, 1);

?>