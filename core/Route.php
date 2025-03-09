<?php

namespace Core;

class Route
{
    public function run()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : 'home/index';
        $url = explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));

        $controllerName = str_replace('_', '', ucwords($url[0], '_')) . 'Controller';
        $method = isset($url[1]) ? $url[1] : 'index';

        $controllerPath = "../app/controllers/$controllerName.php";

        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controllerClass = "App\\Controllers\\$controllerName";
            $controller = new $controllerClass();

            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], array_slice($url, 2));
            } else {
                echo "404 - Method not found";
            }
        } else {
            echo "404 - Controller not found";
        }
    }
}
