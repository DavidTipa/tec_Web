<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use TECWEB\MYAPI\Read\Read;
use TECWEB\MYAPI\Create\Create;
use TECWEB\MYAPI\Update\Update;
use TECWEB\MYAPI\Delete\Delete;
require '../vendor/autoload.php';
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->setBasepath("/tec_Web/actividades/a09/product_app/backend");
$app->get('/product/{id}', function(Request $request, Response $response, $args) {
    $productos = new Read('marketzone');
    $productos->single($args['id']);
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

//para listar
$app->get('/products', function(Request $request, Response $response) {
    $productos = new Read('marketzone');
    $productos->list();
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

//para buscar
$app->get('/products/{search}', function(Request $request, Response $response, $args) {
    $productos = new Read('marketzone');
    $productos->search($args['search']);
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// para agregar un producto
$app->post('/product', function(Request $request, Response $response) {
    $data = json_decode(json_encode($request->getParsedBody()));
    $productos = new Create('marketzone');
    $productos->add($data);
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});
//para editar
$app->put('/product', function(Request $request, Response $response) {
    $data = json_decode(json_encode($request->getParsedBody()));
    $productos = new Update('marketzone');
    $productos->edit($data);
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

//para eliminar
$app->delete('/product', function(Request $request, Response $response) {
    $data = json_decode(json_encode($request->getParsedBody()));
    $productos = new Delete('marketzone');
    $productos->delete($data->id);
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});
$app->run();
?>