<?php
 header('Content-Type: application/json'); 
 
 // Incluir el archivo de conexión a la base de datos
 include('database.php');
 
 // Leer los datos enviados por AJAX
 $data = json_decode(file_get_contents("php://input"), true);
 
 // Validar que el ID del producto esté presente
 if (!isset($data['id']) || empty($data['id'])) {
     echo json_encode(["status" => "error", "message" => "ID de producto no proporcionado"]);
     exit;
 }
 
 $id = intval($data['id']); // Convertir el ID a entero
 
 // Validar los demás campos
 $nombre = isset($data['nombre']) ? trim($data['nombre']) : '';
 $precio = isset($data['precio']) ? floatval($data['precio']) : 0;
 $unidades = isset($data['unidades']) ? intval($data['unidades']) : 1;
 $modelo = isset($data['modelo']) ? trim($data['modelo']) : 'XX-000';
 $marca = isset($data['marca']) ? trim($data['marca']) : 'NA';
 $detalles = isset($data['detalles']) ? trim($data['detalles']) : 'NA';
 $imagen = isset($data['imagen']) ? trim($data['imagen']) : 'img/default.png';
 
 // Validar que el producto exista en la base de datos
 $sql_check = "SELECT id FROM productos WHERE id = ?";
 $stmt_check = $conexion->prepare($sql_check);
 
 if (!$stmt_check) {
     echo json_encode(["status" => "error", "message" => "Error al preparar la consulta de verificación"]);
     exit;
 }
 
 $stmt_check->bind_param("i", $id);
 $stmt_check->execute();
 $result = $stmt_check->get_result();
 
 if ($result->num_rows === 0) {
     echo json_encode(["status" => "error", "message" => "Producto no encontrado"]);
     exit;
 }
 
 // Actualizar el producto en la base de datos
 $sql = "UPDATE productos SET nombre=?, precio=?, unidades=?, modelo=?, marca=?, detalles=?, imagen=? WHERE id=?";
 $stmt = $conexion->prepare($sql);
 
 if (!$stmt) {
     echo json_encode(["status" => "error", "message" => "Error al preparar la consulta de actualización"]);
     exit;
 }
 
 $stmt->bind_param("sdissssi", $nombre, $precio, $unidades, $modelo, $marca, $detalles, $imagen, $id);
 
 if ($stmt->execute()) {
     echo json_encode(["status" => "success", "message" => "Producto actualizado correctamente"]);
 } else {
     echo json_encode(["status" => "error", "message" => "Error al actualizar el producto"]);
 }
 
 $stmt->close();
 $conexion->close();
 ?>