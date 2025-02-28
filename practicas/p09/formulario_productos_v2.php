<?php
// Conectar a la base de datos
$link = new mysqli('localhost', 'root', 'OlakeaZe1', 'marketzone');

// Verificar conexión
if ($link->connect_errno) {
    die('<div class="alert alert-danger">Falló la conexión: '.$link->connect_error.'</div>');
}

// Obtener el ID del producto de la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$producto = null;

if ($id > 0) {
    // Usar consulta preparada para evitar inyección SQL
    $stmt = $link->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    }
    $stmt->close();
}

// Cerrar conexión después de obtener los datos
$link->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h3 class="text-center">Editar Producto</h3>

        <?php if ($producto): ?>
            <form id="formularioMarketzone" action="update_productos.php" method="post" enctype="multipart/form-data">
                <!-- Campo oculto con el ID del producto -->
                <input type="hidden" name="id" value="<?= $producto['id'] ?>">

                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="form-name" class="form-control" required maxlength="100" value="<?= htmlspecialchars($producto['nombre']) ?>">
                    <small class="text-danger" id="error-name"></small>
                </div>

                <div class="form-group">
                    <label for="marca">Marca:</label>
                    <select name="marca" id="form-marca" class="form-control" required>
                        <option value="Roccat" <?= $producto['marca'] == 'Roccat' ? 'selected' : '' ?>>Roccat</option>
                        <option value="Razer" <?= $producto['marca'] == 'Razer' ? 'selected' : '' ?>>Razer</option>
                        <option value="Logitech" <?= $producto['marca'] == 'Logitech' ? 'selected' : '' ?>>Logitech</option>
                        <option value="Tunderbolt" <?= $producto['marca'] == 'Tunderbolt' ? 'selected' : '' ?>>Tunderbolt</option>
                    </select>
                    <small class="text-danger" id="error-marca"></small>
                </div>

                <div class="form-group">
                    <label for="modelo">Modelo:</label>
                    <input type="text" name="modelo" id="form-modelo" class="form-control" required maxlength="25" value="<?= htmlspecialchars($producto['modelo']) ?>">
                    <small class="text-danger" id="error-modelo"></small>
                </div>

                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" name="precio" id="form-precio" class="form-control" required step="0.01" min="100" value="<?= htmlspecialchars($producto['precio']) ?>">
                    <small class="text-danger" id="error-precio"></small>
                </div>

                <div class="form-group">
                    <label for="unidades">Unidades:</label>
                    <input type="number" name="unidades" id="form-unidades" class="form-control" required min="0" value="<?= htmlspecialchars($producto['unidades']) ?>">
                    <small class="text-danger" id="error-unidades"></small>
                </div>

                <div class="form-group">
                    <label for="detalles">Detalles:</label>
                    <textarea name="detalles" id="form-details" class="form-control" rows="4" maxlength="250"><?= htmlspecialchars($producto['detalles']) ?></textarea>
                    <small class="text-danger" id="error-details"></small>
                </div>

                <div class="form-group">
                    <label for="imagen">Imagen del Producto:</label>
                    <input type="file" name="imagen" id="form-imagen" class="form-control-file">
                    <small>(Dejar vacío si no deseas cambiar la imagen)</small>
                    <br>
                    <img src="<?= htmlspecialchars($producto['imagen']) ?>" width="100" alt="Imagen actual">
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                <a href="productos.php" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">Producto no encontrado.</div>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById("formularioMarketzone").addEventListener("submit", function(event) {
            let isValid = true;
            
            const name = document.getElementById("form-name");
            if (name.value.trim().length > 100) {
                document.getElementById("error-name").textContent = "Máximo 100 caracteres";
                isValid = false;
            } else {
                document.getElementById("error-name").textContent = "";
            }
            
            const marca = document.getElementById("form-marca");
            if (marca.value === "") {
                document.getElementById("error-marca").textContent = "Seleccione una marca";
                isValid = false;
            } else {
                document.getElementById("error-marca").textContent = "";
            }
            
            const modelo = document.getElementById("form-modelo");
            if (!modelo.value.match(/^[A-Za-z0-9 ]+$/)) {
                document.getElementById("error-modelo").textContent = "Solo caracteres alfanuméricos";
                isValid = false;
            } else {
                document.getElementById("error-modelo").textContent = "";
            }
            
            const precio = document.getElementById("form-precio");
            if (parseFloat(precio.value) < 100.00) {
                document.getElementById("error-precio").textContent = "Debe ser mayor o igual a 100.00";
                isValid = false;
            } else {
                document.getElementById("error-precio").textContent = "";
            }
            
            const detalles = document.getElementById("form-details");
            if (detalles.value.length > 250) {
                document.getElementById("error-details").textContent = "Máximo 250 caracteres";
                isValid = false;
            } else {
                document.getElementById("error-details").textContent = "";
            }
            
            const unidades = document.getElementById("form-unidades");
            if (parseInt(unidades.value) < 0) {
                document.getElementById("error-unidades").textContent = "Debe ser mayor o igual a 0";
                isValid = false;
            } else {
                document.getElementById("error-unidades").textContent = "";
            }
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
