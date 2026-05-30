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

    public function fijarPrecio(int $sucursal_id, int $frasco_id, float $precio): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO precios (sucursal_id, frasco_id, precio)
            VALUES (:sucursal_id, :frasco_id, :precio)
            ON DUPLICATE KEY UPDATE precio = VALUES(precio)
        ");
        $stmt->execute([
            'sucursal_id' => $sucursal_id,
            'frasco_id' => $frasco_id,
            'precio' => $precio
        ]);
    }
}
