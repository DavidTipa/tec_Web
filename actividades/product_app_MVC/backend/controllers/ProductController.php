<?php
require_once '../models/products.php';

use tec_Web\myapi\products as Products;

// Instancia del modelo
$product = new Products('marketzone');

// Obtén la acción a realizar a partir de un parámetro 'action'
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'list':
        $product->list();
        echo $product->getData();
        break;
    case 'add':
        // Se espera que los datos lleguen vía POST
        $jsonOBJ = json_decode(json_encode($_POST));
        echo $product->add($jsonOBJ);
        break;
    case 'delete':
        $jsonOBJ = json_decode(json_encode($_POST));
        echo $product->delete($jsonOBJ->id);
        break;
    case 'edit':
        $jsonOBJ = json_decode(json_encode($_POST));
        echo $product->update($jsonOBJ);
        break;
    case 'search':
        echo $product->search();
        break;
    case 'single':
        $jsonOBJ = json_decode(json_encode($_POST));
        echo $product->single($jsonOBJ->id);
        break;
    case 'singleByName':
        if(isset($_GET['name'])){
            echo $product->singleByName($_GET['name']);
        } else {
            echo json_encode(['status'=>'error','message'=>'Parámetro "name" no proporcionado']);
        }
        break;
    default:
        echo json_encode(['status'=>'error','message'=>'Acción no definida']);
        break;
}
?>