<?php

use tec_Web\myapi\products as products;
require_once __DIR__.'/myapi/products.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener los datos del GET
    $search = $_GET['search'];

    $proObj = new products('marketzone');

    $response = $proObj->search($search);

    echo $response;
} else {
    
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Solicitud no válida'
    ), JSON_PRETTY_PRINT);
}

?>