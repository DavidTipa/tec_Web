<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h3 class="text-center">Lista de Productos</h3>
        <br/>

        <?php
        /** Obtener el valor de "tope" desde la URL */
        if(isset($_GET['tope'])) {
            $tope = (int) $_GET['tope'];
        } else {
            die('<div class="alert alert-danger">Parámetro "tope" no detectado...</div>');
        }

        /** SE CREA EL OBJETO DE CONEXION */
        @$link = new mysqli('localhost', 'root', 'OlakeaZe1', 'marketzone');
        
        /** comprobar la conexión */
        if ($link->connect_errno) 
        {
            die('<div class="alert alert-danger">Falló la conexión: '.$link->connect_error.'</div>');
        }

        /** Consulta para obtener los productos con unidades menores o iguales a "tope" */
        $query = "SELECT * FROM productos WHERE unidades <= $tope";
        $result = $link->query($query);
        
        if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Precio</th>
                        <th>Unidades</th>
                        <th>Detalles</th>
                        <th>Imagen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)): ?>
                        <tr>
                            <th scope="row"> <?= htmlspecialchars($row['id']) ?> </th>
                            <td> <?= htmlspecialchars($row['nombre']) ?> </td>
                            <td> <?= htmlspecialchars($row['marca']) ?> </td>
                            <td> <?= htmlspecialchars($row['modelo']) ?> </td>
                            <td> <?= htmlspecialchars($row['precio']) ?> </td>
                            <td> <?= htmlspecialchars($row['unidades']) ?> </td>
                            <td> <?= htmlspecialchars($row['detalles']) ?> </td>
                            <td> <img src="<?= htmlspecialchars($row['imagen']) ?>" width="100" alt="Imagen del producto" /> </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">No hay productos disponibles con unidades menores o iguales a <?= $tope ?>.</div>
        <?php endif;
        
        
        $result->free();
        $link->close();
        ?>
    </div>
</body>
</html>
