<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class StockRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function listar(int $sucursal_id): array {
        $stmt = $this->pdo->prepare("
            SELECT f.id, f.nombre, f.categoria, f.imagen, f.descripcion, f.capacidad_ml,
                   f.controla_stock,
                   COALESCE(s.cantidad, 0) as cantidad,
                   COALESCE(s.umbral_bajo, 5) as umbral_bajo,
                   (COALESCE(s.cantidad, 0) <= COALESCE(s.umbral_bajo, 5)) as bajo
            FROM frascos f
            LEFT JOIN stock s ON s.frasco_id = f.id AND s.sucursal_id = :sucursal_id
            WHERE f.activo = 1
            ORDER BY (f.categoria = 'diseno') ASC, f.orden ASC, f.nombre ASC
        ");
        $stmt->execute(['sucursal_id' => $sucursal_id]);
        return $stmt->fetchAll();
    }

    public function entrada(int $sucursal_id, int $frasco_id, int $cantidad, string $motivo, ?int $usuario_id = null): void {
        $this->pdo->beginTransaction();
        try {
            // Upsert stock
            $stmt = $this->pdo->prepare("
                INSERT INTO stock (sucursal_id, frasco_id, cantidad)
                VALUES (:sucursal_id, :frasco_id, :cantidad)
                ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad)
            ");
            $stmt->execute([
                'sucursal_id' => $sucursal_id,
                'frasco_id' => $frasco_id,
                'cantidad' => $cantidad
            ]);

            // Registrar movimiento
            $stmtMov = $this->pdo->prepare("
                INSERT INTO movimientos_stock (sucursal_id, frasco_id, tipo, cantidad, motivo, usuario_id)
                VALUES (:sucursal_id, :frasco_id, 'entrada', :cantidad, :motivo, :usuario_id)
            ");
            $stmtMov->execute([
                'sucursal_id' => $sucursal_id,
                'frasco_id' => $frasco_id,
                'cantidad' => $cantidad,
                'motivo' => $motivo,
                'usuario_id' => $usuario_id
            ]);

            $this->pdo->commit();
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function ajuste(int $sucursal_id, int $frasco_id, int $cantidad, string $motivo, ?int $usuario_id = null): void {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare("
                UPDATE stock SET cantidad = cantidad + :cantidad
                WHERE sucursal_id = :sucursal_id AND frasco_id = :frasco_id
            ");
            $stmt->execute([
                'sucursal_id' => $sucursal_id,
                'frasco_id' => $frasco_id,
                'cantidad' => $cantidad // Puede ser negativo
            ]);

            $stmtMov = $this->pdo->prepare("
                INSERT INTO movimientos_stock (sucursal_id, frasco_id, tipo, cantidad, motivo, usuario_id)
                VALUES (:sucursal_id, :frasco_id, 'ajuste', :cantidad, :motivo, :usuario_id)
            ");
            $stmtMov->execute([
                'sucursal_id' => $sucursal_id,
                'frasco_id' => $frasco_id,
                'cantidad' => $cantidad,
                'motivo' => $motivo,
                'usuario_id' => $usuario_id
            ]);

            $this->pdo->commit();
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
