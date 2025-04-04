<?php
    use TECWEB\MYAPI\Read\Read;
    require __DIR__ . '/../vendor/autoload.php';

    $productos = new Read('marketzone');
    $productos->single( $_POST['id'] );
    echo $productos->getData();
?>