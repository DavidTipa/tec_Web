<?php
/*
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();

    if( isset($_POST['id']) ) {
        $id = $_POST['id'];
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ( $result = $conexion->query("SELECT * FROM productos WHERE id = {$id}") ) {
            // SE OBTIENEN LOS RESULTADOS
            $row = $result->fetch_assoc();

            if(!is_null($row)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach($row as $key => $value) {
                    $data[$key] = utf8_encode($value);
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
*/

use tec_Web\myapi\products as products;
require_once __DIR__.'/myapi/products.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del POST
    $jsonOBJ = json_decode(json_encode($_POST));

    $proObj = new products('marketzone');
    $response = $proObj->single($jsonOBJ->id);
    echo $response;
} else {
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Solicitud no válida'
    ), JSON_PRETTY_PRINT);
}
?>