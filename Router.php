<?php

namespace MyApp\core;

class Router
{

    protected array $routes = [];

    protected Response $response;
    protected View $view;

    public function __construct(Response $response, View $view)
    {
        $this->response = $response;
        $this->view = $view;
    }

    public function get(string $uri, $callback): void
    {
        $this->routes['GET'][$uri] = $callback;
    }

    public function post(string $uri, $callback): void
    {
        $this->routes['POST'][$uri] = $callback;
    }

    public function resolve(string $uri, string $method, Request $request)
    {

        $call = $this->handleRoute($method, $uri);

        if ($call) {
            if (is_callable($call['callback'])) {
                return call_user_func($call['callback']);
            } elseif (is_array($call['callback']) && count($call['callback']) === 2) {
                [$controllerClass, $methodName] = $call['callback'];
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    $controller->runMiddlewares($methodName);
                    if (method_exists($controllerClass, $methodName)) {
                        return call_user_func_array([$controller, $methodName], [$request, $call['params']]);
                    } else {
                        throw new \Exception("Method $method not found");
                    }
                } else {
                    throw new \Exception("Controller $controllerClass not found");
                }
            }
        }
        $this->response->setStatusCode(404);
        $this->view->render('errors/404');
    }

    private function handleRoute($method, $uri)
    {

        foreach ($this->routes[$method] as $routeUri => $callback) {
            $pattern = preg_replace('/\{([a-z_]+)\}/', '(?P<$1>[^/]+)', $routeUri);
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                return $call = [
                    'callback' => $callback,
                    'params' => $matches,
                ];
            }
        }
    }
}
