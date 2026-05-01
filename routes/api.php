<?php
use App\Controllers\PerfumeController;

$router->post('/api/perfumes/filter', [PerfumeController::class, 'filter']);
$router->post('/api/perfumes', [PerfumeController::class, 'store']);
$router->post('/api/perfumes/upload-image', [PerfumeController::class, 'uploadImage']);
$router->post('/api/designers', [PerfumeController::class, 'storeDesigner']);
$router->post('/api/componentes', [PerfumeController::class, 'storeComponente']);
$router->post('/api/tipos-aroma', [PerfumeController::class, 'storeTipoAroma']);
