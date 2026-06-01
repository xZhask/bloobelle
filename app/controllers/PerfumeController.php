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

  public function detalle(): void {
      $data = Request::json();
      $id = (int)($data['id'] ?? 0);
      if ($id <= 0) { 
          Response::json(['error' => 'id inválido'], 400); 
          return; 
      }
      $perfume = (new PerfumeRepository())->detalle($id);
      if (!$perfume) { 
          Response::json(['error' => 'No encontrado'], 404); 
          return; 
      }
      Response::json($perfume);
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

  public function edit(): void {
    $id = (int)($_GET['id'] ?? 0);
    if ($id <= 0) {
        die('ID de perfume inválido');
    }
    $repo = new PerfumeRepository();
    $perfume = $repo->detalle($id);
    if (!$perfume) {
        die('Perfume no encontrado');
    }
    $generos = $repo->getGeneros();
    $designers = $repo->getDesigners();
    $tiposAroma = $repo->getTiposAroma();
    $componentes = $repo->getComponentes();
    require __DIR__ . '/../views/perfumes/edit.php';
  }

  public function update(): void {
    $data = Request::json();
    $id = (int)($data['id'] ?? 0);
    $repo = new PerfumeRepository();
    try {
      $repo->updatePerfume($id, $data);
      Response::json(['ok' => true], 200);
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

      // Validar tamaño (10MB máximo ahora que comprimimos)
      if ($file['size'] > 10 * 1024 * 1024) {
        Response::json(['ok' => false, 'error' => 'La imagen debe ser menor a 10MB'], 400);
        return;
      }

      $uploadDir = dirname(__DIR__, 2) . '/public/assets/images/perfumes';
      $filename = \App\Core\ImageProcessor::processAndSave($file['tmp_name'], $uploadDir, 'perfume_');

      if (!$filename) {
        Response::json(['ok' => false, 'error' => 'Error al procesar o guardar la imagen'], 500);
        return;
      }

      // Devolver ruta relativa
      $rutaRelativa = '/assets/images/perfumes/' . $filename;
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
