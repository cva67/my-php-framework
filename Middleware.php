<?php

namespace MyApp\core;

use MyApp\core\App;

abstract class Middleware
{
    abstract public function handle();

    protected function redirect(string $url)
    {
        App::$app->response->redirect($url);
        return false;
    }

    protected function abort(int $code = 403)
    {
        App::$app->response->setStatusCode($code);
        return false;
    }
}
