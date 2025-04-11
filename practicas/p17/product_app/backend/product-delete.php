<?php
    use TECWEB\MYAPI\Delete\Delete;
    require __DIR__ . '/../vendor/autoload.php';

    $productos = new Delete('marketzone');
    $productos->delete( $_POST['id'] );
    echo $productos->getData();
?>