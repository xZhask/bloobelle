<?php
declare(strict_types=1);
session_start();

define('APP_ROOT', dirname(__DIR__));

spl_autoload_register(function (string $class): void {
    $prefix  = 'App\\';
    $baseDir = APP_ROOT . '/app/';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) return;
    $file = $baseDir . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (file_exists($file)) require_once $file;
});

$coreFiles = [
    APP_ROOT . '/app/core/Router.php',
    APP_ROOT . '/app/core/Database.php',
    APP_ROOT . '/app/core/Request.php',
    APP_ROOT . '/app/core/Response.php',
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
