<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Registro de Producto</title>
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
		// Conexión a la base de datos
		@$link = new mysqli('localhost', 'root', 'OlakeaZe1', 'marketzone');

		// Verificar conexión
		if ($link->connect_errno) {
			die("<h1>Error de conexión:</h1> <p>No se pudo conectar a la base de datos: " . $link->connect_error . "</p>");
		}

		// Recoger datos del formulario
		$nombre = $_POST['nombre'] ?? 'No proporcionado';
		$marca = $_POST['marca'] ?? 'No proporcionado';
		$modelo = $_POST['modelo'] ?? 'No proporcionado';
		$precio = $_POST['precio'] ?? 'No proporcionado';
		$detalles = $_POST['detalles'] ?? 'No proporcionado';
		$unidades = $_POST['unidades'] ?? 'No proporcionado';
        $eliminado = $_POST['eliminado'] ?? 'No proporcionado';

		// Validar que el nombre, marca y modelo no existan en la base de datos
		$sql_check = "SELECT * FROM productos WHERE nombre = '$nombre' OR marca = '$marca' OR modelo = '$modelo'";
		$result = $link->query($sql_check);

		if ($result->num_rows > 0) {
			// Si ya existe un producto con el mismo nombre, marca o modelo
			echo "<h1>Error:</h1>";
			echo "<p>El nombre, marca o modelo ya existen en la base de datos. Por favor, verifica los datos e intenta nuevamente.</p>";
		} else {
			// Si no existen, proceder con la inserción

			// Manejo de la imagen
			$imagen = '';
			if ($_FILES['imagen']['error'] == 0) {
				$imagen = $_FILES['imagen']['name'];
				$imagen_tmp = $_FILES['imagen']['tmp_name'];

				// Verificar si la carpeta "uploads" existe, si no, crearla
				if (!is_dir("uploads")) {
					mkdir("uploads", 0777, true);
				}

				// Mover la imagen a la carpeta "uploads"
				if (move_uploaded_file($imagen_tmp, "uploads/" . $imagen)) {
					echo "<p>Imagen subida correctamente.</p>";
				} else {
					echo "<p>Error al subir la imagen.</p>";
				}
			}

			// Insertar datos en la base de datos
			$sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) VALUES ('$nombre', '$marca', '$modelo', '$precio', '$detalles', '$unidades', '$imagen', '0')";

			if ($link->query($sql_insert) === TRUE) {
				// Si la inserción fue exitosa, mostrar un resumen
				echo "<h1>¡Registro exitoso!</h1>";
				echo "<p>Gracias por registrar tu producto en MarketZone. Hemos recibido la siguiente información:</p>";

				echo "<h2>Resumen del producto:</h2>";
				echo "<ul>";
				echo "<li><strong>Nombre:</strong> <em>" . htmlspecialchars($nombre) . "</em></li>";
				echo "<li><strong>Marca:</strong> <em>" . htmlspecialchars($marca) . "</em></li>";
				echo "<li><strong>Modelo:</strong> <em>" . htmlspecialchars($modelo) . "</em></li>";
				echo "<li><strong>Precio:</strong> <em>" . htmlspecialchars($precio) . "</em></li>";
				echo "<li><strong>Detalles:</strong> <em>" . htmlspecialchars($detalles) . "</em></li>";
				echo "<li><strong>Unidades:</strong> <em>" . htmlspecialchars($unidades) . "</em></li>";
				if (!empty($imagen)) {
					echo "<li><strong>Imagen:</strong> <em><img src='uploads/$imagen' alt='Imagen del producto' width='100'></em></li>";
				}
				echo "</ul>";
			} else {
				// Si hubo un error en la inserción
				echo "<h1>Error:</h1>";
				echo "<p>Hubo un problema al registrar el producto. Por favor, intenta nuevamente.</p>";
				echo "<p>Detalles del error: " . $link->error . "</p>";
			}
		}

		// Cerrar conexión
		$link->close();
		?>
	</body>
</html>