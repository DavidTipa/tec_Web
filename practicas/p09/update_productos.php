<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>Actualización de Producto</title>
    <style type="text/css">
        body {
            margin: 20px; 
            background-color: #C4DF9B;
            font-family: Verdana, Helvetica, sans-serif;
            font-size: 90%;
        }
        h1 {
            color: #005825;
            border-bottom: 1px solid #005825;
        }
        h2 {
            font-size: 1.2em;
            color: #4A0048;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        strong {
            color: #005825;
        }
        em {
            color: #4A0048;
        }
    </style>
</head>
<body>
    <?php
    
    @$link = new mysqli('localhost', 'root', 'OlakeaZe1', 'marketzone');

    // verifica conexion
    if ($link->connect_errno) {
        die("<h1>Error de conexión:</h1> <p>No se pudo conectar a la base de datos: " . $link->connect_error . "</p>");
    }

   
    $id = $_POST['id'] ?? null; 
    $nombre = $_POST['nombre'] ?? 'No proporcionado';
    $marca = $_POST['marca'] ?? 'No proporcionado';
    $modelo = $_POST['modelo'] ?? 'No proporcionado';
    $precio = $_POST['precio'] ?? 'No proporcionado';
    $detalles = $_POST['detalles'] ?? 'No proporcionado';
    $unidades = $_POST['unidades'] ?? 'No proporcionado';

    $sql_check = "SELECT * FROM productos WHERE id = ?";
    $stmt = $link->prepare($sql_check);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql_update = "UPDATE productos SET nombre=?, marca=?, modelo=?, precio=?, detalles=?, unidades=? WHERE id=?";
        $stmt = $link->prepare($sql_update);
        $stmt->bind_param("ssssssi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $id);

        if ($stmt->execute()) {
            echo "<h1>¡Producto actualizado correctamente!</h1>";
			echo "<h1><a href= get_productos_vigentes_v2.php>vuelva a los productos vigentes aqui</a></h1>";
			echo "<h1><a href= get_products_xhtml_v2.php>vuelva a ver todos los productos aqui</a></h1>";
        } else {
            echo "<h1>Error al actualizar el producto.</h1>";
        }

       
        if ($_FILES['imagen']['error'] == 0) {
            $imagen = $_FILES['imagen']['name'];
            $imagen_tmp = $_FILES['imagen']['tmp_name'];

            
            if (!is_dir("img")) {
                mkdir("img", 0777, true);
            }

            
            if (move_uploaded_file($imagen_tmp, "img/" . $imagen)) {
                $sql_update_img = "UPDATE productos SET imagen=? WHERE id=?";
                $stmt_img = $link->prepare($sql_update_img);
                $stmt_img->bind_param("si", $imagen, $id);
                $stmt_img->execute();
                echo "<p>Imagen actualizada correctamente.</p>";
            } else {
                echo "<p>Error al subir la imagen.</p>";
            }
        }
    } else {
        echo "<h1>Error:</h1>";
        echo "<p>El producto con ID $id no existe.</p>";
    }

    $link->close();
    ?>
</body>
</html>
