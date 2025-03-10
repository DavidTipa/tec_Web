<?php
 header('Content-Type: application/json; charset=utf-8');
 include_once __DIR__.'/database.php';
 
 if (isset($_POST['id'])) {
     $id = mysqli_real_escape_string($conexion, $_POST['id']);
 
     $query = "SELECT * FROM productos WHERE id = {$id}";
     $result = mysqli_query($conexion, $query);
     if (!$result) {
         die('Query Failed: ' . mysqli_error($conexion));
     }
 
   //id unico
     if ($row = mysqli_fetch_assoc($result)) {
         $json = array(
             'id'       => $row['id'],
             'nombre'   => $row['nombre'],
             'precio'   => $row['precio'],
             'unidades' => $row['unidades'],
             'modelo'   => $row['modelo'],
             'marca'    => $row['marca'],
             'detalles' => $row['detalles'],
             'imagen'   => $row['imagen']
         );
     } else {
         // En caso de no encontrar el producto, se envía un mensaje de error
         $json = array(
             'status'  => 'error',
             'message' => 'Producto no encontrado'
         );
     }
     
     echo json_encode($json, JSON_PRETTY_PRINT);
 }
 ?>