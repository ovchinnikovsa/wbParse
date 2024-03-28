<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/hello/{name}', function (Request $request, Response $response) {
	$routeContext = RouteContext::fromRequest($request);
	$routingResults = $routeContext->getRoutingResults();

	$routeArguments = $routingResults->getRouteArguments();

	$allowedMethods = $routingResults->getAllowedMethods();
	$response->getBody()->write("Hello, {$routeArguments['name']}! You are visiting this page using {$request->getMethod()}!");
	return $response;
});

$app->get('/', function (Request $request, Response $response) {
	$response->getBody()->write("Hello, Slim!");
	return $response;
});


$app->run();