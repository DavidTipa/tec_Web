<?php

use tec_Web\myapi\products as products;
require_once __DIR__.'/myapi/products.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener el parámetro 'name' desde la URL
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
        $proObj = new products('marketzone');
        $response = $proObj->singleByName($name);
        echo $response;
    } else {
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Parámetro "name" no proporcionado'
        ), JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Solicitud no válida'
    ), JSON_PRETTY_PRINT);
}

?>