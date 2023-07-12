<?php

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Router;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


$routes = new RouteCollection();

/*
 * User registration and authentication routes
 */
$routes->add('login', (new Route('/login', [new LoginController(), 'index']))->setMethods('GET'));
$routes->add('login-store', (new Route('/login', [new LoginController(), 'store']))->setMethods('POST'));
$routes->add('register', (new Route('/register', [new RegisterController(), 'index']))->setMethods('GET'));
$routes->add('register-store', (new Route('/register', [new RegisterController(), 'store']))->setMethods('POST'));


$routes->add('home', new Route('/'));


$router = new Router();
$router($routes);