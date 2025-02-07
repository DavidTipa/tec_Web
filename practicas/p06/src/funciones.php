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
            return "<h3>El número $numerito es par y múltiplo del numero generado aleatoriamente $num</h3>";
        }
        else {
            return "<h3>El número $numerito NO es par o múltiplo del numero generado aleatoriamente $num</h3>";
        }

    } while (true); 

}
?>
<?php
$arreglo=array();
for($i=97;$i<=122;$i++)
{
    $arreglo[$i]=chr($i);
}
?>
<?php

$array = array(
    'UBN6338' => array(
        'Auto' => array(
            'marca' => 'HONDA',
            'modelo' => 2020,
            'tipo' => 'camioneta'
        ),
        'Propietario' => array(
            'nombre' => 'Alfonzo Esparza',
            'ciudad' => 'Puebla, Pue.',
            'direccion' => 'C.U., Jardines de San Manuel'
        )
    ),
    'UBN6339' => array(
        'Auto' => array(
            'marca' => 'VW',
            'modelo' => 2019,
            'tipo' => 'sedan'
        ),
        'Propietario' => array(
            'nombre' => 'Ma. del Consuelo Molina',
            'ciudad' => 'Puebla, Pue.',
            'direccion' => '97 oriente'
        )
        ),
    'JGB7896'=> array(
        'Auto' => array(
            'marca' => 'Chevrolet',
            'modelo' => 2018,
            'tipo' => 'sedan'
        ),
        'Propietario' => array(
            'nombre' => 'Juan Carlos',
            'ciudad' => 'Puebla, Pue.',
            'direccion' => 'San Manuel'
        )
        ),
    'JGB7823'=> array(
        'Auto' => array(
            'marca' => 'BMW',
            'modelo' => 2010,
            'tipo' => 'sedan'
        ),
        'Propietario' => array(
            'nombre' => 'Miguel angel',
            'ciudad' => 'Ciudad de México',
            'direccion' => 'calle la ballenita'
        )
        ), 
    'JGB7824'=> array(
        'Auto' => array(
            'marca' => 'Audi',
            'modelo' => 2015,
            'tipo' => 'sedan'
        ),
        'Propietario' => array(
            'nombre' => 'Luisa',
            'ciudad' => 'Tonala, Chis.',
            'direccion' => 'San Miguel de Totanaca'
        )
        ), 
    'JGB7825'=> array(
        'Auto' => array(
            'marca' => 'Nissan',
            'modelo' => 2017,
            'tipo' => 'sedan'
        ),
        'Propietario' => array(
            'nombre' => 'Piratita',
            'ciudad' => 'Tuxtla Gutierrez, Chis.',
            'direccion' => 'De las totoncas apasiwuere'
        )
        ),
    'JGB7826'=> array(
        'Auto' => array(
            'marca' => 'Ford',
            'modelo' => 2016,
            'tipo' => 'sedan'
        ),
        'Propietario' => array(
            'nombre' => 'Kima',
            'ciudad' => 'Monterrey, Nuevo Leon.',
            'direccion' => 'la chiwuis ciudad'
        )
        ),
    'JGB7827'=> array(
        'Auto' => array(
            'marca' => 'Toyota',
            'modelo' => 2014,
            'tipo' => 'carga'
        ),
        'Propietario' => array(
            'nombre' => 'Ikonic Ramirez',
            'ciudad' => 'Tlaxacala, Tlax.',
            'direccion' => 'la chona'
        )
        ),
    'JGB7828'=> array(
        'Auto' => array(
            'marca' => 'Mazda',
            'modelo' => 2013,
            'tipo' => 'Trocona'
        ),
        'Propietario' => array(
            'nombre' => 'Tomas de Aquino',
            'ciudad' => 'Villaflores, Chis.',
            'direccion' => 'Calle pentelico 180-4'
        )
    ),
    'JGB7829'=> array(
        'Auto' => array(
            'marca' => 'Mercedes Benz',
            'modelo' => 2012,
            'tipo' => 'mamalona'
        ),
        'Propietario' => array(
            'nombre' => 'skibidi',
            'ciudad' => 'Buenavista. Madrid',
            'direccion' => 'San Miguel de Totanaca'
        )
        ),
    'JGB7830'=> array(
        'Auto' => array(
            'marca' => 'KIA',
            'modelo' => 2011,
            'tipo' => 'sedan'
        ),
        'Propietario' => array(
            'nombre' => 'cafecito de las totoncas',
            'ciudad' => 'Apasowuere, Chis.',
            'direccion' => 'Texcoco, calle tilin s/n'
        )
        ),'JGB7831' => array(
        'Auto' => array(
            'marca' => 'Hyundai',
            'modelo' => 2021,
            'tipo' => 'SUV'
        ),
        'Propietario' => array(
            'nombre' => 'Carlos Perez',
            'ciudad' => 'Guadalajara, Jal.',
            'direccion' => 'Av. Chapultepec 123'
        )
    ),
    'JGB7832' => array(
        'Auto' => array(
            'marca' => 'Tesla',
            'modelo' => 2022,
            'tipo' => 'eléctrico'
        ),
        'Propietario' => array(
            'nombre' => 'Ana Gomez',
            'ciudad' => 'Monterrey, NL',
            'direccion' => 'Calle Reforma 456'
        )
    ),
    'JGB7833' => array(
        'Auto' => array(
            'marca' => 'Ferrari',
            'modelo' => 2020,
            'tipo' => 'deportivo'
        ),
        'Propietario' => array(
            'nombre' => 'Luis Martinez',
            'ciudad' => 'Cancún, QR',
            'direccion' => 'Blvd. Kukulcan 789'
        )
    ),
    'JGB7834' => array(
        'Auto' => array(
            'marca' => 'Lamborghini',
            'modelo' => 2021,
            'tipo' => 'deportivo'
        ),
        'Propietario' => array(
            'nombre' => 'Maria Lopez',
            'ciudad' => 'Tijuana, BC',
            'direccion' => 'Calle Revolución 101'
        )
    )
);
function buscarPorMatricula($matricula) {
    global $array;
    if (isset($array[$matricula])) {
        return $array[$matricula];
    } else {
        return null;
    }
}


function obtenerTodosLosAutos() {
    global $array;
    return $array;
}
?>
?>


