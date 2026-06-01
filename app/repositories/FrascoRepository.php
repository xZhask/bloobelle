<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class FrascoRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function create(array $data): int {
        $stmt = $this->pdo->prepare("
            INSERT INTO frascos (nombre, categoria, capacidad_ml, imagen, descripcion, orden) 
            VALUES (:nombre, :categoria, :capacidad_ml, :imagen, :descripcion, :orden)
        ");
        $stmt->execute([
            'nombre' => $data['nombre'],
            'categoria' => $data['categoria'] ?? 'generico',
            'capacidad_ml' => $data['capacidad_ml'] ?? null,
            'imagen' => $data['imagen'] ?? null,
            'descripcion' => $data['descripcion'] ?? null,
            'orden' => $data['orden'] ?? 0,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function all(): array {
        return $this->pdo->query("
            SELECT id, nombre, categoria, capacidad_ml, imagen, descripcion, orden, activo, controla_stock
            FROM frascos
            ORDER BY (categoria='diseno') ASC, orden ASC, nombre ASC
        ")->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM frascos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function update(int $id, array $d): void {
        // Obtener la imagen anterior para eliminarla si cambia
        $stmtOld = $this->pdo->prepare("SELECT imagen FROM frascos WHERE id = ?");
        $stmtOld->execute([$id]);
        $oldImg = $stmtOld->fetchColumn();

        $stmt = $this->pdo->prepare("
            UPDATE frascos 
            SET nombre = :nombre, 
                categoria = :categoria, 
                capacidad_ml = :capacidad_ml,
                imagen = COALESCE(:imagen, imagen), 
                descripcion = :descripcion, 
                orden = :orden 
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $id,
            'nombre' => $d['nombre'],
            'categoria' => $d['categoria'] ?? 'generico',
            'capacidad_ml' => $d['capacidad_ml'] ?? null,
            'imagen' => $d['imagen'] ?? null,
            'descripcion' => $d['descripcion'] ?? null,
            'orden' => $d['orden'] ?? 0
        ]);

        // Si se guardó correctamente y se pasó una imagen nueva diferente a la anterior, la borramos
        if (!empty($d['imagen']) && $oldImg && $oldImg !== $d['imagen']) {
            $oldImgPath = dirname(__DIR__, 2) . '/public' . $oldImg;
            if (file_exists($oldImgPath) && is_file($oldImgPath)) {
                @unlink($oldImgPath);
            }
        }
    }

    public function setActivo(int $id, bool $activo): void {
        $stmt = $this->pdo->prepare("UPDATE frascos SET activo = :activo WHERE id = :id");
        $stmt->execute([
            'activo' => $activo ? 1 : 0,
            'id' => $id
        ]);
    }
}
