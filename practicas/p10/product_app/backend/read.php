<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    
    // SE VERIFICA HABER RECIBIDO EL TÉRMINO DE BÚSQUEDA
    if (isset($_POST['busqueda'])) {
        $busqueda = $conexion->real_escape_string($_POST['busqueda']);
        
        // consulta nueva para buscar en la base de datos
        $query = "SELECT * FROM productos WHERE nombre LIKE '%$busqueda%'
         OR marca LIKE '%$busqueda%' 
         OR detalles LIKE '%$busqueda%'";
        
        if ($result = $conexion->query($query)) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    } 
    
    // conversion del array a JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>