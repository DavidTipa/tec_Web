<?php
    use TECWEB\MYAPI\Read\Read;
    require __DIR__ . '/../vendor/autoload.php';

    $productos = new    Read('marketzone');
    $productos->search( $_GET['search'] );
    echo $productos->getData();
?>