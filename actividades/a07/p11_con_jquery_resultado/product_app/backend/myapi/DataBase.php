<?php
namespace tec_Web\myapi;
abstract class DataBase {

    protected $conexion;

    public function __construct($db, $user, $pass) {
        $this->conexion = new \mysqli('localhost', $user, $pass, $db);
    
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        } 
    }
}

?>