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

    <h2>Ejemplo de POST</h2>
    <form action="http://localhost/tecweb/practicas/p04/index.php" method="post">
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
</body>
</html>