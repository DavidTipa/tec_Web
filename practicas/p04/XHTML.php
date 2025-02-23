<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>

    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar, $_7var, myvar, $myvar, $var7, $_element1, $house*5</p>
    <?php
        // Código PHP
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
        echo '<li>myvar es inválida porque no tiene el signo de dólar ($).</li>';
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

        unset($a, $b, $c);
    ?>
    <p>El valor de la nueva variable `$a` fue pasado a la variable `$b`. Se asignó por referencia, por ende, imprime el mismo valor.</p>

    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación:</p>
    <?php
        $a = "PHP5 ";
        echo "<p>1. Después de asignar \$a: $a</p>";

        $z[] = &$a;
        echo "<p>2. Después de asignar \$z:</p>";
        echo "<div><pre>" . htmlspecialchars(print_r($z, true)) . "</pre></div>";

        $b = "5a version de PHP";
        echo "<p>3. Después de asignar \$b: $b</p>";

        $c = (int)$b * 10; // Convertir a entero para evitar advertencias
        echo "<p>4. Después de multiplicar b * 10, \$c: $c</p>";

        $a .= $b;
        echo "<p>5. Después de concatenar a con b, \$a: $a</p>";

        $b = (int)$b * $c; // Convertir a entero para evitar advertencias
        echo "<p>6. Después de multiplicar \$b y \$c: $b</p>";

        $z[0] = "MySQL";
        echo "<p>7. Después de modificar \$z[0]:</p>";
        echo "<div><pre>" . htmlspecialchars(print_r($z, true)) . "</pre></div>";
    ?>

    <h2>EJERCICIO 4</h2>
    <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de la matriz $GLOBALS o del modificador global de PHP.</p>
    <?php
        echo "<p>\$a: " . $GLOBALS['a'] . "</p>";
        echo "<p>\$b: " . $GLOBALS['b'] . "</p>";
        echo "<p>\$c: " . $GLOBALS['c'] . "</p>";
        echo "<p>\$z:</p>";
        echo "<div><pre>" . htmlspecialchars(print_r($GLOBALS['z'], true)) . "</pre></div>";
    ?>

    <h2>EJERCICIO 5</h2>
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>
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
    <p>Dar y comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f y muéstralas:</p>
    <?php
        $a = "0";
        $b = "TRUE";
        $c = FALSE;
        $d = ($a OR $b);
        $e = ($a AND $c);
        $f = ($a XOR $b);

        echo '<ul>';
        echo '<li>$a = ' . htmlspecialchars(var_export($a, true)) . '</li>';
        echo '<li>$b = ' . htmlspecialchars(var_export($b, true)) . '</li>';
        echo '<li>$c = ' . htmlspecialchars(var_export($c, true)) . '</li>';
        echo '<li>$d = ' . htmlspecialchars(var_export($d, true)) . '</li>';
        echo '<li>$e = ' . htmlspecialchars(var_export($e, true)) . '</li>';
        echo '<li>$f = ' . htmlspecialchars(var_export($f, true)) . '</li>';
        echo '</ul>';

        echo '<h4>Transformar el valor booleano de $c y $e en uno que se pueda mostrar con un echo:</h4>';
        echo "<p>c: " . var_export($c, true) . "</p>";
        echo "<p>e: " . var_export($e, true) . "</p>";
        echo "<p>f: " . var_export($f, true) . "</p>";

        unset($a, $b, $c, $d, $e, $f);
    ?>

    <h2>EJERCICIO 7</h2>
    <p>Usando la variable predefinida $_SERVER, determina lo siguiente:</p>
    <ul>
        <li>a. La versión de Apache y PHP: <?php echo htmlspecialchars($_SERVER['SERVER_SOFTWARE']); ?></li>
        <li>b. El nombre del sistema operativo (servidor): <?php echo htmlspecialchars(PHP_OS); ?></li>
        <li>c. El idioma del navegador (cliente): <?php echo htmlspecialchars($_SERVER['HTTP_ACCEPT_LANGUAGE']); ?></li>
    </ul>
    <div>
    <p>
    <a href="https://validator.w3.org/markup/check?uri=referer"><img
      src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
  </p>
    </div>
</body>
</html>