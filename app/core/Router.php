<?php

namespace Core;

class Router
{
    private array $routes = [];
    private array $middleware = [];

    public function register(string $method, string $path, callable|array $handler, array $middleware = []): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $this->convertToRegex($path),
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }

    public function dispatch(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && preg_match($route['path'], $requestUri, $matches)) {
                array_shift($matches); // Remove the full match from regex results

                // Run middleware first
                foreach ($route['middleware'] as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    if (!$middleware->handle()) {
                        return; // Stop if middleware fails
                    }
                }

                $handler = $route['handler'];
                if (is_callable($handler)) {
                    call_user_func_array($handler, $matches);
                } elseif (is_array($handler) && class_exists($handler[0]) && method_exists($handler[0], $handler[1])) {
                    call_user_func_array([new $handler[0], $handler[1]], $matches);
                }
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
    }

    private function convertToRegex(string $path): string
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_]+)', $path);
        return "#^" . rtrim($pattern, '/') . "$#";
    }
}