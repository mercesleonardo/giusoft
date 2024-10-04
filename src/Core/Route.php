<?php

namespace App\Core;

use JsonException;

class Route
{
    private static array $routes = [];

    public static function get($route, $action): void
    {
        self::$routes['GET'][$route] = $action;
    }

    public static function post($route, $action): void
    {
        self::$routes['POST'][$route] = $action;
    }

    public static function put($route, $action): void
    {
        self::$routes['PUT'][$route] = $action;
    }

    public static function delete($route, $action): void
    {
        self::$routes['DELETE'][$route] = $action;
    }

    public static function loadRoutesFromFile($file): void
    {
        if (file_exists($file)) {
            require $file;
        }
    }

    /**
     * @throws JsonException
     */
    public static function resolve()
    {
        $path   = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $path = strtok($path, '?');

        if (isset(self::$routes[$method])) {
            foreach (self::$routes[$method] as $route => $action) {
                $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
                $routePattern = str_replace('/', '\/', $routePattern);

                if (preg_match('/^' . $routePattern . '$/', $path, $matches)) {
                    array_shift($matches);

                    return self::callAction($action, $matches);
                }
            }
        }

        http_response_code(404);
        echo json_encode(['message' => 'Rota nao encontrada'], JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    private static function callAction($action, $params = [])
    {
        if (is_string($action)) {
            [$controller, $method] = explode('@', $action);

            $controller = 'App\\Controllers\\' . $controller;

            if (class_exists($controller) && method_exists($controller, $method)) {
                $repository     = new \App\Repositories\ProductRepository();
                $productService = new \App\Services\ProductService($repository);

                $controllerInstance = new $controller($productService);

                return call_user_func_array([$controllerInstance, $method], $params);
            }
        }

        http_response_code(500);
        echo json_encode(['message' => 'Controller ou método não encontrado'], JSON_THROW_ON_ERROR);
    }
}
