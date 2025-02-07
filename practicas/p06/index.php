<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
        if(isset($_GET['numero']))
        {
            require_once('src/funciones.php');
            isMultipliplo5y7($_GET['numero']);
        }
    ?>
    <h2>EJERCICIO 2</h2>
    <p>2. Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una
    secuencia compuesta</p>
    <?php
    require_once('src/funciones.php');
    numerosAleatorios();
   ?>
   <H2>EJERCICIO 3</H2>
   <?php
   require_once('src/funciones.php');

   
   if (isset($_GET['numerito'])) {
       // Obtener el valor de 'numerito' desde la URL
       $numerito = intval($_GET['numerito']);
   
       
       echo numeroPar($numerito);
   } else {
       
       echo "<h3>Por favor, proporciona un número en la URL usando el parámetro 'numerito'.</h3>";
   }
   ?>
   <h2>Ejercicio 4</h2>
   <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’
a la ‘z’. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner
el valor en cada índice. Es decir:<br>
[97] => a<br>
[98] => b<br>
[99] => c<br>   
[98] => b<br>
[99] => c<br>
...
[122] => z
✓ Crea el arreglo con un ciclo for
✓ Lee el arreglo y crea una tabla en XHTML con echo y un ciclo foreach</p>
   <table>
    <tr>
        <th>Índice (ASCII)</th>
        <th>Letra</th>
    </tr>

    <?php
    require_once('src/funciones.php');
  
    foreach ($arreglo as $key => $value) {
        echo "<tr>";
        echo "<td>$key </td>";
        echo "<td>$value</td>";
        echo "</tr>";
    }
    ?>
   </table>

    <h2>Ejemplo de POST</h2>
    <form action="http://localhost/tec_Web/practicas/p06/index.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
    <br>
    <?php
        if(isset($_POST["name"]) && isset($_POST["email"]))
        {
            echo $_POST["name"];
            echo '<br>';
            echo $_POST["email"];
        }
    ?>
    <h2>EJERCICIO 5</h2>
    <h2>Ingrese sus datos</h2>
    <form action="src/xhtml.php" method="post">
        <label for="edad">Edad:</label>
        <input type="number" name="edad" id="edad" required><br><br>

        <label>Sexo:</label>
        <input type="radio" name="sexo" value="femenino" required> Femenino
        <input type="radio" name="sexo" value="masculino" required> Masculino <br><br>

        <input type="submit" value="Enviar">
    </form>

    <h2>EJERCICIO 6</h2>
    <h2>Consultar Información de Autos</h2>
<form method="post">
    <label for="matricula">Buscar por matrícula:</label>
    <input type="text" name="matricula" id="matricula">
    <button type="submit">Buscar</button>
    <br><br>
    <button type="submit" name="mostrar_todos">Mostrar Todos los Autos</button>
</form>

<hr>

<?php
require_once 'src/funciones.php';

$resultado = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['matricula']) && !empty($_POST['matricula'])) {
        $matricula = $_POST['matricula'];
        $resultado = buscarPorMatricula($matricula);
    }
}
?>

<?php if ($resultado): ?>
    <h3>Información del Auto</h3>
    <?php print_r($resultado); ?>
<?php elseif (isset($_POST['mostrar_todos'])): ?>
    <h3>Lista de Autos Registrados</h3>
    
    <?php
    $todosLosAutos = obtenerTodosLosAutos();
    print_r($todosLosAutos);
    ?>

<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p>No se encontraron resultados.</p>
<?php endif; ?>
 



</body>
</html>