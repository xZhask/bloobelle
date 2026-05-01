<?php
use App\Controllers\PerfumeController;

$router->get('/', [PerfumeController::class, 'index']);
$router->get('/perfumes', [PerfumeController::class, 'index']);
$router->get('/perfumes/create', [PerfumeController::class, 'create']);
