<?php
require __DIR__ . '/../vendor/autoload.php';

use TECWEB\MYAPI\Read\Read;

header('Content-Type: application/json');

try {
    $productos = new Read('marketzone');
    $productos->list();
    echo $productos->getData();
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}