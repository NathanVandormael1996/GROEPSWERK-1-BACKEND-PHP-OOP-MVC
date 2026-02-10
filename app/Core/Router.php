<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void { $this->addRoute('GET', $path, $handler); }
    public function post(string $path, callable $handler): void { $this->addRoute('POST', $path, $handler); }

    private function addRoute(string $method, string $path, callable $handler): void
    {
        $pattern = '#^' . preg_replace('/\{id\}/', '(\d+)', '/' . trim($path, '/')) . '$#';
        $this->routes[$method][] = ['pattern' => $pattern, 'handler' => $handler];
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = '/' . trim(parse_url($uri, PHP_URL_PATH), '/');
        if (!isset($this->routes[$method])) {
            http_response_code(404);
            echo "404 - Sector Unknown";
            return;
        }

        foreach ($this->routes[$method] as $route) {
            if (preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }
    }
}