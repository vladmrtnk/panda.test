<?php

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\LogoutController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Dashboard\DashboardController;
use App\Controllers\Dashboard\PollController;
use App\Controllers\HomeController;
use App\Router;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use App\Controllers\Api\PollController as ApiPollController;


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
$routes->add('dashboard', (new Route('/dashboard', [new DashboardController(), 'index']))->setMethods('GET'));
$routes->add('dashboard-poll', (new Route('/dashboard/poll', [new PollController(), 'index']))->setMethods('GET'));
$routes->add('dashboard-poll-show', (new Route('/dashboard/poll/vote/{id}', [new PollController(), 'show']))->setMethods('GET'));
$routes->add('dashboard-poll-store-votes', (new Route('/dashboard/poll/{id}/store', [new PollController(), 'storeVotes']))->setMethods('POST'));
$routes->add('dashboard-poll-create', (new Route('/dashboard/poll/create', [new PollController(), 'create']))->setMethods('GET'));
$routes->add('dashboard-poll-store', (new Route('/dashboard/poll', [new PollController(), 'store']))->setMethods('POST'));
$routes->add('dashboard-poll-publish', (new Route('/dashboard/poll/publish', [new PollController(), 'publish']))->setMethods('POST'));
$routes->add('dashboard-poll-delete', (new Route('/dashboard/poll/{id}/delete', [new PollController(), 'delete'])));

$routes->add('home', new Route('/', [new HomeController(), 'index']));

/*
 * Api routes
 */
$routes->add('api-poll', (new Route('/api/poll', [new ApiPollController(), 'show']))->setMethods('GET'));


$router = new Router();
$router($routes);