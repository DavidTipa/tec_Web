<?php

header("Content-Type: application/xhtml+xml; charset=UTF-8");


if (isset($_POST["edad"]) && isset($_POST["sexo"])) {
    $edad = (int) $_POST["edad"]; 
    $sexo = strtolower($_POST["sexo"]); 

  
    echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Resultado</title>
</head>
<body>
    <?php
    if ($sexo == "femenino" && $edad >= 18 && $edad <= 35) {
        echo "<h2>Bienvenida, usted está en el rango de edad permitido.</h2>";
    } else {
        echo "<h2>Lo sentimos, usted no cumple con los requisitos.</h2>";
    }
    ?>
</body>
</html>
<?php
} else {
    echo "Error: No se recibieron los datos del formulario.";
}
?>
