<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\VentaRepository;

class VentaController {
    private VentaRepository $repo;

    public function __construct() {
        $this->repo = new VentaRepository();
    }

    public function reportePage(): void {
        Auth::requireRole('admin');
        require APP_ROOT . '/app/views/tienda/reporte.php';
    }

    public function buscarPerfume(): void {
        Auth::requireLogin();
        $data = Request::json();
        $q = $data['q'] ?? '';
        if (strlen(trim($q)) < 2) {
            Response::json([]);
            return;
        }

        try {
            $resultados = $this->repo->buscarPerfume($q);
            Response::json($resultados);
        } catch (\Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(): void {
        Auth::requireRole('vendedor', 'admin');
        $user = Auth::user();
        $data = Request::json();

        if (empty($data['items']) || !is_array($data['items'])) {
            Response::json(['error' => 'No hay items en la venta'], 400);
            return;
        }

        $sucursal_id = $user['rol'] === 'vendedor' ? $user['sucursal_id'] : ($data['sucursal_id'] ?? null);
        if (!$sucursal_id) {
            Response::json(['error' => 'Sucursal no definida'], 400);
            return;
        }

        if (!isset($data['total']) || !is_numeric($data['total']) || (float)$data['total'] < 0) {
            Response::json(['error' => 'El total de la venta es inválido o falta'], 400);
            return;
        }

        $ventaData = [
            'sucursal_id' => (int)$sucursal_id,
            'vendedor_id' => $user['id'],
            'metodo_pago' => $data['metodo_pago'] ?? 'efectivo',
            'nota' => $data['nota'] ?? null,
            'total' => (float)$data['total']
        ];

        try {
            $resultado = $this->repo->store($ventaData, $data['items']);
            Response::json(array_merge(['ok' => true], $resultado));
        } catch (\Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function reporte(): void {
        Auth::requireLogin();
        $user = Auth::user();
        $data = Request::json();

        $sucursal_id = $user['rol'] === 'vendedor' ? $user['sucursal_id'] : ($data['sucursal_id'] ?? 1); // fallback 1
        $desde = $data['desde'] ?? date('Y-m-d');
        $hasta = $data['hasta'] ?? date('Y-m-d');

        try {
            $reporte = $this->repo->reporte((int)$sucursal_id, $desde, $hasta);
            Response::json($reporte);
        } catch (\Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }
}
