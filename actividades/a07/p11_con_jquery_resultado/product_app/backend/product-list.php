
<?php



use tec_Web\myapi\products as products;
require_once __DIR__.'/myapi/products.php';

$proObj = new products('marketzone');
$proObj->list();
echo $proObj->getData();
?>