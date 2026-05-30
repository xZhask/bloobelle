<?php
use App\Controllers\PerfumeController;
use App\Controllers\AuthController;
use App\Controllers\FrascoController;
use App\Controllers\StockController;
use App\Controllers\VentaController;

$router->post('/api/perfumes/filter', [PerfumeController::class, 'filter']);
$router->post('/api/perfumes', [PerfumeController::class, 'store']);
$router->post('/api/perfumes/upload-image', [PerfumeController::class, 'uploadImage']);
$router->post('/api/designers', [PerfumeController::class, 'storeDesigner']);
$router->post('/api/componentes', [PerfumeController::class, 'storeComponente']);
$router->post('/api/tipos-aroma', [PerfumeController::class, 'storeTipoAroma']);

// Tienda API routes
$router->post('/api/auth/login', [AuthController::class, 'login']);
$router->post('/api/frascos', [FrascoController::class, 'store']);
$router->post('/api/frascos/upload-image', [FrascoController::class, 'uploadImage']);
$router->post('/api/precios', [FrascoController::class, 'fijarPrecio']);
$router->post('/api/perfumes/buscar', [VentaController::class, 'buscarPerfume']);
$router->post('/api/stock', [StockController::class, 'listar']);
$router->post('/api/stock/entrada', [StockController::class, 'entrada']);
$router->post('/api/stock/ajuste', [StockController::class, 'ajuste']);
$router->post('/api/ventas', [VentaController::class, 'store']);
$router->post('/api/ventas/reporte', [VentaController::class, 'reporte']);
