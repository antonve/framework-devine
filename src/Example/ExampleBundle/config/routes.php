<?php

// routes.php - Routes configuration for the JsonApiExample module
// By Anton Van Eechaute

use Devine\Framework\RouteCollection;
use Devine\Framework\Route;

$routes = new RouteCollection();
$routes->addRoute(new Route('index', '/', 'Example\ExampleBundle\Controller\TestController::indexAction'));

return $routes;