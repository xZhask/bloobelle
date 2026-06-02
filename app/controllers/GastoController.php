<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\GastoRepository;

class GastoController {
    private GastoRepository $repo;

    public function __construct() {
        $this->repo = new GastoRepository();
    }

    public function store(): void {
        Auth::requireRole('vendedor', 'admin');
        $user = Auth::user();
        $data = Request::json();

        $descripcion = trim($data['descripcion'] ?? '');
        $monto       = $data['monto'] ?? null;

        if ($descripcion === '') {
            Response::json(['error' => 'La descripción no puede estar vacía'], 400);
            return;
        }
        if (!is_numeric($monto) || (float)$monto <= 0) {
            Response::json(['error' => 'El monto debe ser un número mayor a 0'], 400);
            return;
        }

        $sucursal_id = $user['rol'] === 'vendedor'
            ? $user['sucursal_id']
            : ($data['sucursal_id'] ?? 1);

        try {
            $id = $this->repo->store((int)$sucursal_id, $user['id'], $descripcion, (float)$monto);
            Response::json(['ok' => true, 'id' => $id]);
        } catch (\Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function listar(): void {
        Auth::requireLogin();
        $user = Auth::user();
        $data = Request::json();

        if ($user['rol'] === 'vendedor') {
            $sucursal_id = $user['sucursal_id'];
            $desde       = date('Y-m-d');
            $hasta       = date('Y-m-d');
        } else {
            $sucursal_id = $data['sucursal_id'] ?? 1;
            $desde       = $data['desde'] ?? date('Y-m-d');
            $hasta       = $data['hasta'] ?? date('Y-m-d');
        }

        try {
            $result = $this->repo->listar((int)$sucursal_id, $desde, $hasta);
            Response::json($result);
        } catch (\Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }
}
