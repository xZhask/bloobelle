<?php
use App\Controllers\PerfumeController;
use App\Controllers\AuthController;
use App\Controllers\TiendaController;
use App\Controllers\StockController;
use App\Controllers\VentaController;

$router->get('/', [PerfumeController::class, 'index']);
$router->get('/perfumes', [PerfumeController::class, 'index']);
$router->get('/perfumes/create', [PerfumeController::class, 'create']);

// Tienda routes
$router->get('/login', [AuthController::class, 'showLogin']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/tienda', [TiendaController::class, 'dashboard']);
$router->get('/tienda/stock', [StockController::class, 'page']);
$router->get('/tienda/reporte', [VentaController::class, 'reportePage']);
