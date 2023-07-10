<?php

namespace App;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    /**
     * @param  RouteCollection  $routes
     *
     * @return void
     */
    public function __invoke(RouteCollection $routes): void
    {
        session_start();
        $request = Request::createFromGlobals();
        $context = (new RequestContext())->fromRequest($request);

        $matcher = new UrlMatcher($routes, $context);
        try {
            $parameters = $matcher->match($request->getPathInfo());

            /* Check if authorised */
            $route = explode('-', array_pop($parameters));
            if (!isset($_SESSION[AUTHENTICATED_USER]) || !$_SESSION[AUTHENTICATED_USER]) {
                if ($route[0] != 'login') {
                    header('Location: /login');
                    exit;
                }
            } else {
                if ($route[0] == 'sign') {
                    header('Location: /');
                    exit;
                }
            }

            call_user_func([$parameters[0], $parameters[1]], end($parameters));

            $response = new Response(ob_get_clean());
        } catch (MethodNotAllowedException $e) {
            $response = new Response('Method Not Allowed', 405);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not Found', 404);
        } catch (Exception $e) {
            $response = new Response('Internal Server Error', 500);
        }

        $response->send();
    }
}