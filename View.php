<?php

namespace cva67\phpmvc;

class View
{


    public  function render(string $page, array|object $params = [])
    {
        extract($params);
        ob_start();
        $viewPath =  "../pages/$page.php";
        if (!file_exists($viewPath)) {
            throw new \Exception("View {$viewPath} not found");
        }

        include $viewPath;
        $content = ob_get_clean();
        include  $this->layoutRender();
    }

    public  function layoutRender()
    {
        $layoutPath =  "../pages/layouts/main.php";
        if (!file_exists($layoutPath)) {
            throw new \Exception("Layout Page not found");
        }
        return $layoutPath;
    }
}
