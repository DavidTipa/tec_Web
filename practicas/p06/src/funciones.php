<?php

function isMultipliplo5y7($num)
{
    if ($num%5==0 && $num%7==0)
    {
        echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
    }
    else
    {
        echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
    }
}
?>

<?php

function esPar($num)
    {
        return $num % 2 == 0;
    }
function numerosAleatorios()
{
    

    $matriz = []; 
    $iteraciones = 0;
    $totalNumeros = 0;

    do {
        $num1 = rand(1, 100);
        $num2 = rand(1, 100);
        $num3 = rand(1, 100);

        $iteraciones++;
        $totalNumeros += 3;
        $matriz[] = [$num1, $num2, $num3]; 

    } while (!(($num1 % 2 != 0) && esPar($num2) && ($num3 % 2 != 0)));

  
   


    echo "<br><h3>Iteraciones: $iteraciones</h3>";
    echo "<h3>Total de números generados: $totalNumeros</h3>";
}



?>
<?php

function numeroPar($numerito) {
   
    do {
        $num = rand(1, 100); 

        if (($num % 2 == 0) && ($num % $numerito == 0)) { 
            return "<h3>El número $numerito es par y múltiplo de $num</h3>";
        }
        else {
            return "<h3>El número $numerito NO es par o múltiplo de $num</h3>";
        }

    } while (true); 

}
?>



