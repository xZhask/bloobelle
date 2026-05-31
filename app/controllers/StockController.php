<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\StockRepository;

class StockController {
    private StockRepository $repo;

    public function __construct() {
        $this->repo = new StockRepository();
    }

    public function page(): void {
        Auth::requireLogin();
        require APP_ROOT . '/app/views/tienda/stock.php';
    }

    public function listar(): void {
        Auth::requireLogin();
        $user = Auth::user();
        
        $data = Request::json();
        // Si es vendedor, usa su sucursal. Si es admin, puede enviar la sucursal o usar una global
        $sucursal_id = $user['rol'] === 'vendedor' ? $user['sucursal_id'] : ($data['sucursal_id'] ?? 1); // fallback 1
        
        if (!$sucursal_id) {
            Response::json(['error' => 'Sucursal no definida'], 400);
            return;
        }

        try {
            $list = $this->repo->listar((int)$sucursal_id);
            // Formatear a boolean el campo 'bajo' que MySQL devuelve como int(0/1)
            foreach($list as &$item) {
                $item['bajo'] = (bool)$item['bajo'];
                $item['cantidad'] = (int)$item['cantidad'];
            }
            Response::json($list);
        } catch (\Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function entrada(): void {
        Auth::requireRole('admin');
        $data = Request::json();

        if (empty($data['sucursal_id']) || empty($data['frasco_id']) || empty($data['cantidad'])) {
            Response::json(['error' => 'Faltan datos'], 400);
            return;
        }

        try {
            $user = Auth::user();
            $this->repo->entrada(
                (int)$data['sucursal_id'],
                (int)$data['frasco_id'],
                (int)$data['cantidad'],
                $data['motivo'] ?? 'Entrada de stock',
                $user['id']
            );
            Response::json(['ok' => true]);
        } catch (\Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function ajuste(): void {
        Auth::requireRole('admin');
        $data = Request::json();

        if (empty($data['sucursal_id']) || empty($data['frasco_id']) || !isset($data['cantidad'])) {
            Response::json(['error' => 'Faltan datos'], 400);
            return;
        }

        try {
            $user = Auth::user();
            $this->repo->ajuste(
                (int)$data['sucursal_id'],
                (int)$data['frasco_id'],
                (int)$data['cantidad'],
                $data['motivo'] ?? 'Ajuste manual',
                $user['id']
            );
            Response::json(['ok' => true]);
        } catch (\Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }
}
