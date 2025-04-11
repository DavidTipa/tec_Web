<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/practicas/p17/product_app/backend");
$app->get('/',function(Request $request, Response $response, $args) {
    $response->getBody()->write("hola mundo ");
    return $response;
});
$app->get("/hola[/{nombre}]",function(Request $request, Response $response, $args){
    $response->getBody()->write("Hola,". $args["nombre"]);
    return $response;
});

$app->post("/pruebapost",function(Request $request, Response $response, $args){
    $reqPost=$request->getParsedBody();
    $val1=$reqPost["val1"];
    $val2=$reqPost["val2"];
    $response->getBody()->write("Valores: ". $val1 . " " . $val2);
    return $response;
});
$app->get("/testjson",function(Request $request, Response $response, $args){
    $reqPost=$request->getQueryParams();

    $data[0]["nombre"]=$reqPost["nombre"];
    $data[0]["apellido"]=$reqPost["apellido"];

    $response->getBody()->write(json_encode($data,JSON_PRETTY_PRINT));
    return $response;
});
$app->run();
?>