<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\FrascoRepository;

class FrascoController {
    private FrascoRepository $repo;

    public function __construct() {
        $this->repo = new FrascoRepository();
    }

    public function index(): void {
        Auth::requireRole('admin');
        $user = Auth::user();
        $frascos = $this->repo->all();
        require __DIR__ . '/../views/frascos/index.php';
    }

    public function create(): void {
        Auth::requireRole('admin');
        require __DIR__ . '/../views/frascos/create.php';
    }

    public function store(): void {
        Auth::requireRole('admin');
        $data = Request::json();

        if (empty($data['nombre'])) {
            Response::json(['error' => 'Nombre es requerido'], 400);
            return;
        }

        try {
            $id = $this->repo->create($data);
            Response::json(['ok' => true, 'id' => $id]);
        } catch (\Exception $e) {
            \App\Core\Logger::error("Error in store Frasco: " . $e->getMessage());
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function uploadImage(): void {
        Auth::requireRole('admin');

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            Response::json(['error' => 'Error subiendo la imagen'], 400);
            return;
        }

        $file = $_FILES['image'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed)) {
            Response::json(['error' => 'Formato no permitido'], 400);
            return;
        }

        $destDir = APP_ROOT . '/public/assets/images/frascos';
        $filename = \App\Core\ImageProcessor::processAndSave($file['tmp_name'], $destDir, 'frasco_');

        if ($filename) {
            Response::json([
                'ok' => true,
                'path' => '/assets/images/frascos/' . $filename
            ]);
        } else {
            Response::json(['error' => 'Error al procesar o guardar la imagen'], 500);
        }
    }

    public function update(): void {
        Auth::requireRole('admin');
        $data = Request::json();

        if (empty($data['id']) || empty($data['nombre'])) {
            Response::json(['error' => 'Faltan datos obligatorios'], 400);
            return;
        }

        try {
            $this->repo->update((int)$data['id'], $data);
            Response::json(['ok' => true]);
        } catch (\Exception $e) {
            \App\Core\Logger::error("Error in update Frasco: " . $e->getMessage());
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function toggleEstado(): void {
        Auth::requireRole('admin');
        $data = Request::json();

        if (empty($data['id']) || !isset($data['activo'])) {
            Response::json(['error' => 'Faltan datos'], 400);
            return;
        }

        try {
            $this->repo->setActivo((int)$data['id'], (bool)$data['activo']);
            Response::json(['ok' => true]);
        } catch (\Exception $e) {
            \App\Core\Logger::error("Error in toggleEstado Frasco: " . $e->getMessage());
            Response::json(['error' => $e->getMessage()], 500);
        }
    }
}
