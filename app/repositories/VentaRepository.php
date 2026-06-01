<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class VentaRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function buscarPerfume(string $q): array {
        $searchTerm = '%' . trim($q) . '%';
        $stmt = $this->pdo->prepare("
            SELECT p.id, p.codigo, p.referencia, d.nombre AS marca
            FROM perfumes p
            LEFT JOIN designers d ON d.id = p.designer_id
            WHERE p.referencia LIKE :q OR p.codigo LIKE :q OR d.nombre LIKE :q
            ORDER BY p.referencia ASC
            LIMIT 20
        ");
        $stmt->execute(['q' => $searchTerm]);
        return $stmt->fetchAll();
    }

    public function store(array $ventaData, array $items): array {
        $this->pdo->beginTransaction();
        try {
            $sucursal_id = $ventaData['sucursal_id'];
            $vendedor_id = $ventaData['vendedor_id'];
            $metodo_pago = $ventaData['metodo_pago'];
            $nota = $ventaData['nota'] ?? null;
            $total = (float)($ventaData['total'] ?? 0);

            // Insertamos la cabecera
            $stmtVenta = $this->pdo->prepare("
                INSERT INTO ventas (sucursal_id, vendedor_id, metodo_pago, nota, total)
                VALUES (:sucursal_id, :vendedor_id, :metodo_pago, :nota, :total)
            ");
            $stmtVenta->execute([
                'sucursal_id' => $sucursal_id,
                'vendedor_id' => $vendedor_id,
                'metodo_pago' => $metodo_pago,
                'nota' => $nota,
                'total' => $total
            ]);
            $venta_id = (int)$this->pdo->lastInsertId();

            $stmtCtrl     = $this->pdo->prepare("SELECT controla_stock FROM frascos WHERE id = ?");
            $stmtStock    = $this->pdo->prepare("SELECT cantidad FROM stock WHERE sucursal_id = ? AND frasco_id = ? FOR UPDATE");
            $stmtItem     = $this->pdo->prepare("
                INSERT INTO venta_items (venta_id, perfume_id, frasco_id, cantidad)
                VALUES (?, ?, ?, ?)
            ");
            $stmtUpdStock = $this->pdo->prepare("UPDATE stock SET cantidad = cantidad - ? WHERE sucursal_id = ? AND frasco_id = ?");
            $stmtMov      = $this->pdo->prepare("
                INSERT INTO movimientos_stock (sucursal_id, frasco_id, tipo, cantidad, motivo, usuario_id, venta_id)
                VALUES (?, ?, 'venta', ?, 'Venta POS', ?, ?)
            ");

            foreach ($items as $item) {
                $frasco_id  = (int)$item['frasco_id'];
                $perfume_id = (int)$item['perfume_id'];
                $cantidad   = (int)$item['cantidad'];

                // El item siempre se registra
                $stmtItem->execute([$venta_id, $perfume_id, $frasco_id, $cantidad]);

                // ¿Este frasco controla stock?
                $stmtCtrl->execute([$frasco_id]);
                $controla = (int)$stmtCtrl->fetchColumn();

                if ($controla === 1) {
                    $stmtStock->execute([$sucursal_id, $frasco_id]);
                    $stock = $stmtStock->fetchColumn();
                    if ($stock === false || $stock < $cantidad) {
                        throw new \Exception("Stock insuficiente para el frasco ID $frasco_id");
                    }
                    $stmtUpdStock->execute([$cantidad, $sucursal_id, $frasco_id]);
                    $stmtMov->execute([$sucursal_id, $frasco_id, -$cantidad, $vendedor_id, $venta_id]);
                }
                // controla_stock = 0: solo queda el item, sin tocar stock ni movimientos
            }

            $this->pdo->commit();
            return ['venta_id' => $venta_id, 'total' => $total];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function reporte(int $sucursal_id, string $desde, string $hasta): array {
        $params = ['sucursal_id' => $sucursal_id, 'desde' => $desde, 'hasta' => $hasta];

        // Ventas e ingresos (sin join a items para no inflar totales)
        $stmtRes = $this->pdo->prepare("
            SELECT COUNT(*) as ventas, COALESCE(SUM(total), 0) as ingresos
            FROM ventas
            WHERE sucursal_id = :sucursal_id AND DATE(fecha) >= :desde AND DATE(fecha) <= :hasta
        ");
        $stmtRes->execute($params);
        $resBase = $stmtRes->fetch();

        // Frascos (controla_stock=1) vs Rellenos (controla_stock=0)
        $stmtUnid = $this->pdo->prepare("
            SELECT
              COALESCE(SUM(CASE WHEN f.controla_stock = 1 THEN vi.cantidad ELSE 0 END), 0) as frascos,
              COALESCE(SUM(CASE WHEN f.controla_stock = 0 THEN vi.cantidad ELSE 0 END), 0) as rellenos
            FROM venta_items vi
            JOIN ventas v  ON v.id = vi.venta_id
            JOIN frascos f ON f.id = vi.frasco_id
            WHERE v.sucursal_id = :sucursal_id AND DATE(v.fecha) >= :desde AND DATE(v.fecha) <= :hasta
        ");
        $stmtUnid->execute($params);
        $resUnid = $stmtUnid->fetch();

        // Top Frascos (solo con controla_stock = 1)
        $stmtF = $this->pdo->prepare("
            SELECT f.nombre, SUM(vi.cantidad) as cantidad
            FROM venta_items vi
            JOIN ventas v  ON v.id = vi.venta_id
            JOIN frascos f ON f.id = vi.frasco_id
            WHERE v.sucursal_id = :sucursal_id AND DATE(v.fecha) >= :desde AND DATE(v.fecha) <= :hasta
              AND f.controla_stock = 1
            GROUP BY vi.frasco_id
            ORDER BY cantidad DESC LIMIT 5
        ");
        $stmtF->execute($params);
        $topFrascos = $stmtF->fetchAll();

        // Top Perfumes (incluye todo: frasco propio o de tienda)
        $stmtP = $this->pdo->prepare("
            SELECT p.referencia as nombre, SUM(vi.cantidad) as cantidad
            FROM venta_items vi
            JOIN ventas v  ON v.id = vi.venta_id
            JOIN perfumes p ON p.id = vi.perfume_id
            WHERE v.sucursal_id = :sucursal_id AND DATE(v.fecha) >= :desde AND DATE(v.fecha) <= :hasta
            GROUP BY vi.perfume_id
            ORDER BY cantidad DESC LIMIT 5
        ");
        $stmtP->execute($params);
        $topPerfumes = $stmtP->fetchAll();

        // Desglose por tipo de pago
        $stmtPago = $this->pdo->prepare("
            SELECT metodo_pago, COALESCE(SUM(total),0) AS monto
            FROM ventas
            WHERE sucursal_id = :sucursal_id AND DATE(fecha) >= :desde AND DATE(fecha) <= :hasta
            GROUP BY metodo_pago
            ORDER BY monto DESC
        ");
        $stmtPago->execute($params);
        $porPago = $stmtPago->fetchAll();

        // Ventas del rango
        $stmtV = $this->pdo->prepare("
            SELECT v.id, v.fecha, u.nombre as vendedora, v.metodo_pago, v.total,
                   (
                       SELECT GROUP_CONCAT(CONCAT(p.referencia, ' (', f.nombre, ') ×', vi2.cantidad) SEPARATOR ', ')
                       FROM venta_items vi2
                       JOIN frascos f  ON f.id  = vi2.frasco_id
                       JOIN perfumes p ON p.id  = vi2.perfume_id
                       WHERE vi2.venta_id = v.id
                   ) as detalle
            FROM ventas v
            JOIN usuarios u ON u.id = v.vendedor_id
            WHERE v.sucursal_id = :sucursal_id AND DATE(v.fecha) >= :desde AND DATE(v.fecha) <= :hasta
            ORDER BY v.fecha DESC LIMIT 50
        ");
        $stmtV->execute($params);
        $ventas = $stmtV->fetchAll();

        return [
            'resumen' => [
                'ventas'   => (int)$resBase['ventas'],
                'ingresos' => (float)$resBase['ingresos'],
                'frascos'  => (int)$resUnid['frascos'],
                'rellenos' => (int)$resUnid['rellenos'],
            ],
            'topFrascos'  => $topFrascos,
            'topPerfumes' => $topPerfumes,
            'porPago'     => $porPago,
            'ventas'      => $ventas
        ];
    }
}
