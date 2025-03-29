<?php

namespace MyApp\core;

use MyApp\config\config;

class App
{
    private Router $router;
    private Request $request;
    public Response $response;
    public View $view;
    public Session $session;
    public static App $app;

    public function __construct()
    {

        config::load(BASE_PATH . '/config');

        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->view = new View();

        $this->router = new Router($this->response, $this->view);
        $this->loadRoutes();
        self::$app = $this;
    }

    public function run()
    {
        try {
            $uri = $this->request->getUri();
            $method = $this->request->getMethod();
            $route = $this->router->resolve($uri, $method, $this->request);
            // echo $route;
        } catch (\Exception $e) {
            // echo "Server error:-" . $e;
            $this->response->setStatusCode($e->getCode() ?? 500);
            $this->view->render('errors/_error', [
                'exception' => $e
            ]);
        }
    }

    private function loadRoutes()
    {
        $routeFile = __DIR__ . '/../routes/web.php';
        if (file_exists($routeFile)) {
            $router = $this->router;
            require_once $routeFile;
        }
    }
}
