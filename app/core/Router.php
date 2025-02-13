<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function addRoute($method, $pattern, $controllerAction)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'controllerAction' => $controllerAction
        ];
    }

    public function handleRequest()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        $basePath = trim(str_replace('/public', '', $scriptName), '/');

        if ($basePath && strpos($requestUri, "/$basePath") === 0) {
            $requestUri = substr($requestUri, strlen("/$basePath"));
        }

        foreach ($this->routes as $route) {
            $pattern = $route['pattern'];
            $method = $route['method'];

            if ($method === $requestMethod && preg_match("#^$pattern$#", $requestUri, $matches)) {

                [$controllerName, $action] = explode('@', $route['controllerAction']);
                $controllerClass = "App\\Controllers\\$controllerName";

                $controller = new $controllerClass();

                if (isset($matches[1])) {
                    $controller->$action($matches[1]);
                } else {
                    $controller->$action();
                }
                return;
            }
        }

        http_response_code(404);
        echo "Página no encontrada";
    }
}