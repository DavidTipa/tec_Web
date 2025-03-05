<?php
include_once __DIR__ . '/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');

if (!empty($producto)) {
    // SE TRANSFORMA EL STRING DEL JSON A OBJETO
    $jsonOBJ = json_decode($producto);

    // Verificar si el JSON es válido
    if (!$jsonOBJ) {
        echo json_encode(["status" => "error", "message" => "Formato JSON inválido."]);
        exit;
    }

    // VALIDACIÓN DE CAMPOS OBLIGATORIOS
    $nombre = trim($jsonOBJ->nombre);
    $marca = trim($jsonOBJ->marca);
    $modelo = trim($jsonOBJ->modelo);
    $precio = $jsonOBJ->precio;
    $unidades = $jsonOBJ->unidades;
    $detalles = trim($jsonOBJ->detalles);
    $imagen = trim($jsonOBJ->imagen);

    if (empty($nombre) || empty($marca) || empty($modelo) || empty($precio) || empty($unidades)) {
        echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
        exit;
    }

    // VALIDACIÓN DE TIPOS DE DATOS Y RANGOS
    if (!is_numeric($precio) || $precio < 100 || $precio > 1000000) {
        echo json_encode(["status" => "error", "message" => "El precio debe ser un número válido, mayor o igual a 100 y menor o igual a 1,000,000."]);
        exit;
    }

    if (!is_numeric($unidades) || $unidades < 0 || $unidades > 10000) {
        echo json_encode(["status" => "error", "message" => "Las unidades deben ser un número válido, mayor o igual a 0 y menor o igual a 10,000."]);
        exit;
    }

    // VERIFICAR SI EL PRODUCTO YA EXISTE
    $query = "SELECT id FROM productos WHERE eliminado = 0 AND ((nombre = ? AND marca = ?) OR (marca = ? AND modelo = ?))";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssss", $nombre, $marca, $marca, $modelo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "El producto ya existe en la base de datos."]);
        exit;
    }

    // INSERTAR EL NUEVO PRODUCTO
    $query = "INSERT INTO productos (nombre, marca, modelo, precio, unidades, detalles, imagen, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssdiss", $nombre, $marca, $modelo, $precio, $unidades, $detalles, $imagen);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Producto agregado exitosamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al insertar el producto en la base de datos."]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["status" => "error", "message" => "No se recibieron datos del producto."]);
}
?>