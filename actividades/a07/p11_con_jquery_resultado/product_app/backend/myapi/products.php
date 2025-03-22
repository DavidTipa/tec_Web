<?php

namespace tec_Web\myapi;

use mysqli;
use tec_Web\myapi\DataBase as DataBase;

require_once __DIR__.'/DataBase.php';

class products extends DataBase {
    

    private $data= NULL;
    public function __construct($db= 'marketzone', $user= 'root', $pass='OlakeaZe1') {
        $this->data = array();
        parent::__construct($db, $user, $pass);
    }
public function list(){
    $this-> data= array();
    if($result= $this->conexion->query('SELECT * FROM productos WHERE eliminado =0' )){
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        if(!is_null($rows)){
            foreach($rows as $num=>$row){
                foreach($row as $key=>$value){
                    $this->data[$num][$key]=$value;
                }
            }
        }
       

    }
    else{
        die('Error en la consulta'.$this->conexion->error);
    }
$this->conexion->close();


}
public function getData(){
    return json_encode($this->data, JSON_PRETTY_PRINT);

}

}


?>
