<?php
namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Repositories\PerfumeRepository;

class PerfumeController {

  public function index(): void {
    $repo = new PerfumeRepository();
    $generos = $repo->getGeneros();
    $productos = $repo->listarInicial(30);
    $user = \App\Core\Auth::user();
    require __DIR__ . '/../views/perfumes/index.php';
  }

  public function create(): void {
    $repo = new PerfumeRepository();
    $generos = $repo->getGeneros();
    $designers = $repo->getDesigners();
    $tiposAroma = $repo->getTiposAroma();
    $componentes = $repo->getComponentes();
    require __DIR__ . '/../views/perfumes/create.php';
  }

  public function filter(): void {
    $filtros = Request::json();
    $repo = new PerfumeRepository();
    Response::json($repo->filtrar($filtros));
  }

  public function store(): void {
    $data = Request::json();
    $repo = new PerfumeRepository();
    try {
      $id = $repo->crearPerfume($data);
      Response::json(['ok' => true, 'id' => $id], 201);
    } catch (\Throwable $e) {
      Response::json(['ok' => false, 'error' => $e->getMessage()], 400);
    }
  }

  public function uploadImage(): void {
    try {
      // Verificar que se subió un archivo
      if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        Response::json(['ok' => false, 'error' => 'No se recibió ninguna imagen'], 400);
        return;
      }

      $file = $_FILES['imagen'];

      // Validar tipo de archivo
      $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
      if (!in_array($file['type'], $allowedTypes)) {
        Response::json(['ok' => false, 'error' => 'Tipo de archivo no permitido'], 400);
        return;
      }

      // Validar tamaño (2MB máximo)
      if ($file['size'] > 2 * 1024 * 1024) {
        Response::json(['ok' => false, 'error' => 'La imagen debe ser menor a 2MB'], 400);
        return;
      }

      // Crear directorio si no existe
      $uploadDir = dirname(__DIR__, 2) . '/public/assets/images/perfumes';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
      }

      // Generar nombre único
      $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
      $fileName = uniqid('perfume_') . '.' . $extension;
      $targetPath = $uploadDir . '/' . $fileName;

      // Mover archivo
      if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        Response::json(['ok' => false, 'error' => 'Error al guardar la imagen'], 500);
        return;
      }

      // Devolver ruta relativa
      $rutaRelativa = '/assets/images/perfumes/' . $fileName;
      Response::json(['ok' => true, 'ruta' => $rutaRelativa], 200);

    } catch (\Throwable $e) {
      Response::json(['ok' => false, 'error' => $e->getMessage()], 500);
    }
  }

  public function storeDesigner(): void {
    $data = Request::json();
    $repo = new PerfumeRepository();
    try {
      $id = $repo->crearDesigner($data);
      Response::json(['ok' => true, 'id' => $id], 201);
    } catch (\Throwable $e) {
      Response::json(['ok' => false, 'error' => $e->getMessage()], 400);
    }
  }

  public function storeComponente(): void {
    $data = Request::json();
    $repo = new PerfumeRepository();
    try {
      $id = $repo->crearComponente($data);
      Response::json(['ok' => true, 'id' => $id], 201);
    } catch (\Throwable $e) {
      Response::json(['ok' => false, 'error' => $e->getMessage()], 400);
    }
  }

  public function storeTipoAroma(): void {
    $data = Request::json();
    $repo = new PerfumeRepository();
    try {
      $id = $repo->crearTipoAroma($data);
      Response::json(['ok' => true, 'id' => $id], 201);
    } catch (\Throwable $e) {
      Response::json(['ok' => false, 'error' => $e->getMessage()], 400);
    }
  }
}
