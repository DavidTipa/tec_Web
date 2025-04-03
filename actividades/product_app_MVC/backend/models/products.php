<?php

namespace tec_Web\myapi;

use mysqli;
use tec_Web\myapi\DataBase as DataBase;

require_once __DIR__.'/DataBase.php';

class products extends DataBase {
    

    private $data= NULL;
    public function __construct($db= 'marketzone', $user= 'root', $pass='gatin_123') {
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
public function add($jsonOBJ){
$this->data = array(
    'status' => 'error',
    'message' => 'Ya existe un producto con ese nombre'
);
$sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
$result = $this->conexion->query($sql);
if ($result->num_rows == 0) {
    $this->conexion->set_charset("utf8");
    $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
    if($this->conexion->query($sql)){
        $this->data['status'] =  "success";
        $this->data['message'] =  "Producto agregado";
    } else {
        $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
    }

}
$result->free();
$this->conexion->close();
return json_encode($this->data, JSON_PRETTY_PRINT);
}
public function getData(){
    return json_encode($this->data, JSON_PRETTY_PRINT);

}

public function delete($id){
    $this->data = array(
        'status' => 'error',
        'message' => 'La consulta falló'
    );
    $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
    if ( $this->conexion->query($sql) ) {
        
        $this->data['status'] =  "success";
        $this->data['message'] =  "Producto eliminado";
    } else {
        $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
    }
    $this->conexion->close();
    return json_encode($this->data, JSON_PRETTY_PRINT);
}
public function update($jsonOBJ){
    $this->data = array(
        'status' => 'error',
        'message' => 'No se pudo actualizar el producto'
    );
    $sql = "UPDATE productos SET nombre='{$jsonOBJ->nombre}', marca='{$jsonOBJ->marca}', modelo='{$jsonOBJ->modelo}', precio={$jsonOBJ->precio}, detalles='{$jsonOBJ->detalles}', unidades={$jsonOBJ->unidades}, imagen='{$jsonOBJ->imagen}' WHERE id = {$jsonOBJ->id}";
    if ( $this->conexion->query($sql) ) {
        $this->data['status'] =  "success";
        $this->data['message'] =  "Producto actualizado";
    } else {
        $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
    }
    $this->conexion->close();
    return json_encode($this->data, JSON_PRETTY_PRINT);
}

public function search(){
    $this->data = array();
    if( isset($_GET['search']) ) {
        $search = $_GET['search'];
        $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
        if ( $result = $this->conexion->query($sql) ) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)) {
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data[$num][$key] = utf8_encode($value);
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    } 
    return json_encode($this->data, JSON_PRETTY_PRINT);
}

public function single($id){
    $this->data = array();
    if( isset($id) ) {
        $sql = "SELECT * FROM productos WHERE id = {$id}";
        if ( $result = $this->conexion->query($sql) ) {
            $row = $result->fetch_assoc();
            if(!is_null($row)) {
                foreach($row as $key => $value) {
                    $this->data[$key] = utf8_encode($value);
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }
    return json_encode($this->data, JSON_PRETTY_PRINT);
}


public function singleByName($name){
    $this->data = array();
    if( isset($name) ) {
        $sql = "SELECT * FROM productos WHERE nombre LIKE '%{$name}%' AND eliminado = 0";
        if ( $result = $this->conexion->query($sql) ) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)) {
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data[$num][$key] = utf8_encode($value);
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    } 
    return json_encode($this->data, JSON_PRETTY_PRINT);
    
}
}


?>