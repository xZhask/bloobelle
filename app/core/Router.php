<?php
namespace App\Core;

class Router {
  private array $routes = ['GET' => [], 'POST' => []];

  public function get(string $path, array $handler): void {
    $this->routes['GET'][$this->normalize($path)] = $handler;
  }

  public function post(string $path, array $handler): void {
    $this->routes['POST'][$this->normalize($path)] = $handler;
  }

  public function dispatch(): void {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($uri, PHP_URL_PATH) ?? '/';
    $path = preg_replace('#^/(bloobelle[^/]*|public)#', '', $path) ?? '/';
    if ($path === '' || $path === null) $path = '/';
    $path = $this->normalize($path);
    $handler = $this->routes[$method][$path] ?? null;

    if (!$handler) {
      http_response_code(404);
      echo "404 Not Found: {$method} {$path}";
      return;
    }

    [$class, $action] = $handler;
    if (!class_exists($class)) {
      http_response_code(500);
      echo "Controller no encontrado: {$class}";
      return;
    }

    $controller = new $class();
    if (!method_exists($controller, $action)) {
      http_response_code(500);
      echo "Método no encontrado: {$class}::{$action}";
      return;
    }

    $controller->{$action}();
  }

  private function normalize(string $path): string {
    if ($path === '') return '/';
    if ($path[0] !== '/') $path = '/' . $path;
    $path = rtrim($path, '/');
    return $path === '' ? '/' : $path;
  }
}
