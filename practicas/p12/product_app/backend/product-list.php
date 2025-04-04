<?php
require __DIR__ . '/../vendor/autoload.php';

use TECWEB\MYAPI\Read\Read;
    

    $productos = new Read('marketzone');
    $productos->list();
    echo $productos->getData();
?>