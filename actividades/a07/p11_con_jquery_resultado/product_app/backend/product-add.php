<?php

    use tec_Web\myapi\products as products;
require_once __DIR__.'/myapi/products.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del POST
    $jsonOBJ = json_decode(json_encode($_POST));

   
    $proObj = new products('marketzone');

   
    $response = $proObj->add($jsonOBJ);

    
    echo $response;
} else {
    
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Solicitud no válida'
    ), JSON_PRETTY_PRINT);
}
?>