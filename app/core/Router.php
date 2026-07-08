<?php

class Router
{
    private array $routes = [];

    public function get(string $url, string $controller, string $method)
    {
        $this->routes['GET'][$url] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function post(string $url, string $controller, string $method)
    {
        $this->routes['POST'][$url] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function run()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $url = $_GET['url'] ?? '/';
        $url = trim($url, '/');

        if ($url === '') {
            $url = '/';
        }

        if (isset($this->routes[$requestMethod][$url])) {
            $route = $this->routes[$requestMethod][$url];

            $controllerName = $route['controller'];
            $methodName = $route['method'];

            $controllerPath = __DIR__ . '/../controllers/' . $controllerName . '.php';

            if (!file_exists($controllerPath)) {
                die("El controlador no existe: " . $controllerName);
            }

            require_once $controllerPath;

            $controller = new $controllerName();

            if (!method_exists($controller, $methodName)) {
                die("El método no existe: " . $methodName);
            }

            $controller->$methodName();
        } else {
            http_response_code(404);
            echo "404 - Página no encontrada";
        }
    }
}
