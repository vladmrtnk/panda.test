<?php

use App\Controllers\AuthController;
use App\Router;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


$routes = new RouteCollection();
$routes->add('login', new Route('/login', [new AuthController(), 'login']));

$routes->add('home', new Route('/'));


$router = new Router();
$router($routes);