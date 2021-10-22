<?php

class Conexion{

    private $host = "localhost";
    //private $user = "root";
    //private $pass = "";
    private $user = "ceiba";
    private $pass = "c31bqn3t";
    private $data = "followbuild";
    public $conexion;

    function getConexion(){
        $this->conexion = new mysqli($this->host, $this->user, $this->pass, $this->data) or die("Error servidor");
    }

    function closeConexion(){
        mysqli_close($this->conexion);
    }

    function conectar(){
        return new mysqli($this->host, $this->user, $this->pass, $this->data);
    }

}


?>