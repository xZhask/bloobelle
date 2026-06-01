<?php
declare(strict_types=1);
date_default_timezone_set('America/Lima');
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(['lifetime' => 1800, 'samesite' => 'Lax']);
session_start();

define('APP_ROOT', dirname(__DIR__));

spl_autoload_register(function (string $class): void {
    $prefix  = 'App\\';
    $baseDir = APP_ROOT . '/app/';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) return;
    
    $relativeClass = substr($class, strlen($prefix));
    $parts = explode('\\', $relativeClass);
    $className = array_pop($parts);
    $parts = array_map('strtolower', $parts);
    array_push($parts, $className);
    
    $file = $baseDir . implode('/', $parts) . '.php';
    if (file_exists($file)) require_once $file;
});

set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) return;
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function (\Throwable $e) {
    if (class_exists('App\\Core\\Logger')) {
        \App\Core\Logger::error("Uncaught Exception: " . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
    http_response_code(500);
    if (!headers_sent()) {
        header('Content-Type: application/json');
    }
    echo json_encode(['ok' => false, 'error' => 'Internal Server Error']);
    exit;
});

$coreFiles = [
    APP_ROOT . '/app/core/Logger.php',
    APP_ROOT . '/app/core/Router.php',
    APP_ROOT . '/app/core/Database.php',
    APP_ROOT . '/app/core/Request.php',
    APP_ROOT . '/app/core/Response.php',
    APP_ROOT . '/app/core/ImageProcessor.php',
    APP_ROOT . '/app/repositories/PerfumeRepository.php',
    APP_ROOT . '/app/controllers/PerfumeController.php',
    APP_ROOT . '/app/core/Auth.php',
    APP_ROOT . '/app/repositories/FrascoRepository.php',
    APP_ROOT . '/app/controllers/FrascoController.php',
    APP_ROOT . '/app/repositories/StockRepository.php',
    APP_ROOT . '/app/controllers/StockController.php',
    APP_ROOT . '/app/repositories/VentaRepository.php',
    APP_ROOT . '/app/controllers/VentaController.php',
    APP_ROOT . '/app/controllers/AuthController.php',
    APP_ROOT . '/app/controllers/TiendaController.php',
];

foreach ($coreFiles as $file) {
    if (file_exists($file)) {
        require_once $file;
    } else {
        die("Archivo no encontrado: $file");
    }
}

$router = new App\Core\Router();
require APP_ROOT . '/routes/web.php';
require APP_ROOT . '/routes/api.php';
$router->dispatch();
