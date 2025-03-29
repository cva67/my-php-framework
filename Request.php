<?php

namespace cva67\phpmvc\core;

class Request
{

    public function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];

        return $uri;
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isGet(): bool
    {
        return $this->getMethod() === 'GET';
    }
    public function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }

    public function getAll()
    {
        $body = [];
        if ($this->isGet()) {

            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            $body = [];
            foreach ($_POST as $key => $value) {

                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
