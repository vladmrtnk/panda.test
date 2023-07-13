<?php

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\LogoutController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Dashboard\PollController;
use App\Controllers\HomeController;
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
$routes->add('logout', (new Route('/logout', [new LogoutController(), 'index']))->setMethods('GET'));

/*
 * Dashboard routes
 */
$routes->add('dashboard-poll', (new Route('/dashboard/poll', [new PollController(), 'index']))->setMethods('GET'));
$routes->add('dashboard-poll-create', (new Route('/dashboard/poll/create', [new PollController(), 'create']))->setMethods('GET'));
$routes->add('dashboard-poll-store', (new Route('/dashboard/poll', [new PollController(), 'store']))->setMethods('POST'));

$routes->add('home', new Route('/', [new HomeController(), 'index']));

$router = new Router();
$router($routes);