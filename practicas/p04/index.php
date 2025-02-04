<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        // AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
        
        unset($_myvar, $_7var, $myvar, $var7, $_element1);
    ?>
    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    
    <?php 
    $a = "ManejadorSQL";
    $b = 'MySQL';
    $c = &$a;
    
    echo "<p>El valor de \$a es: $a</p>";
    echo "<p>El valor de \$b es: $b</p>";
    echo "<p>El valor de \$c es: $c</p>";
    $a = "PHP server";
    $b = &$a;
    echo "<p>El valor de \$a es: $a</p>";
    echo "<p>El valor de \$b es: $b</p>";

    unset($a, $b, $c);  // Liberando variables aquí también
    ?>
    <p>El valor de la nueva variable `$a` fue pasado a la variable `$b`. Se asignó por referencia, por ende, imprime el mismo valor.</p>

    <h2>Ejercicio 3</h2>
    <?php
    // 1. Asignación de $a
    $a = "PHP5 ";
    echo "<p>1. Después de asignar \$a: $a</p>";

    // 2. Asignación de $z (referencia a $a)
    $z[] = &$a;
    echo "<p>2. Después de asignar \$z: ";
    var_dump($z);
    echo "</p>";
    $b = "5a version de PHP";
    echo "<p>3. Después de asignar \$b: $b</p>";
    $c = $b * 10; // Extraemos el número de $b de manera explícita
    echo "<p>4. Después de multiplicar  b * 10, \$c: $c</p>";
    $a .=$b;
    echo "<p>5. Después de concatenar a con b  \$a: $a</p>";
    $b= $b * $c;
    echo "<p>6. Después de multiplicar \$b y \$c: $b</p>";
    $z[0] = "MySQL";
    var_dump($z);

    echo "<h2> EJERCICIO 4</h2>";
    echo "<p>\$a: " . $GLOBALS['a'] . "</p>";
echo "<p>\$b: " . $GLOBALS['b'] . "</p>";
echo "<p>\$c: " . $GLOBALS['c'] . "</p>";
echo "<p>\$z: " . $GLOBALS['z'][0] . "</p>";
 // Liberando variables aquí también
    ?>


<?php
 
?>
<h2>EJERCICIO 5</h2>
<?php
$a = "7 personas";
$b = (integer) $a;
$a = "9E3";
$c = (double) $a;
echo "<p>= \$a es: $a</p>";
echo "<p>= \$b es: $b</p>";
echo "<p>= \$c es: $c</p>";

unset($a, $b, $c);  

?>
<h2>EJERCICIO 6</h2>
<?php
$a = "0";
$b = "TRUE";
$c = FALSE;
$d = ($a OR $b);
$e = ($a AND $c);
$f = ($a XOR $b);


echo "d: " . var_export($d, true) . "<br>";
echo "e: " . var_export($e, true) . "<br>";
echo "f: " . var_export($f, true) . "<br>";
?>

</body>
</html>
