<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class GastoRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function store(int $sucursal_id, int $usuario_id, string $descripcion, float $monto): int {
        $stmt = $this->pdo->prepare("
            INSERT INTO gastos (sucursal_id, usuario_id, descripcion, monto)
            VALUES (:sucursal_id, :usuario_id, :descripcion, :monto)
        ");
        $stmt->execute([
            'sucursal_id' => $sucursal_id,
            'usuario_id'  => $usuario_id,
            'descripcion' => $descripcion,
            'monto'       => $monto,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function listar(int $sucursal_id, string $desde, string $hasta): array {
        $stmt = $this->pdo->prepare("
            SELECT g.id, g.descripcion, g.monto, g.fecha, u.nombre AS usuario
            FROM gastos g
            JOIN usuarios u ON u.id = g.usuario_id
            WHERE g.sucursal_id = :sucursal_id
              AND DATE(g.fecha) >= :desde
              AND DATE(g.fecha) <= :hasta
            ORDER BY g.fecha DESC
        ");
        $stmt->execute([
            'sucursal_id' => $sucursal_id,
            'desde'       => $desde,
            'hasta'       => $hasta,
        ]);
        $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = 0.0;
        foreach ($gastos as &$g) {
            $g['monto'] = (float)$g['monto'];
            $total += $g['monto'];
        }

        return ['gastos' => $gastos, 'total' => $total];
    }
}
