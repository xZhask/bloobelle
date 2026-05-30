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
            $total = 0;

            // Primero, insertamos la cabecera (actualizaremos el total después)
            $stmtVenta = $this->pdo->prepare("
                INSERT INTO ventas (sucursal_id, vendedor_id, metodo_pago, nota, total)
                VALUES (:sucursal_id, :vendedor_id, :metodo_pago, :nota, 0)
            ");
            $stmtVenta->execute([
                'sucursal_id' => $sucursal_id,
                'vendedor_id' => $vendedor_id,
                'metodo_pago' => $metodo_pago,
                'nota' => $nota
            ]);
            $venta_id = (int)$this->pdo->lastInsertId();

            $stmtStock = $this->pdo->prepare("SELECT cantidad FROM stock WHERE sucursal_id = ? AND frasco_id = ? FOR UPDATE");
            $stmtPrecio = $this->pdo->prepare("SELECT precio FROM precios WHERE sucursal_id = ? AND frasco_id = ?");
            $stmtItem = $this->pdo->prepare("
                INSERT INTO venta_items (venta_id, perfume_id, frasco_id, cantidad, precio_unitario, subtotal)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmtUpdStock = $this->pdo->prepare("UPDATE stock SET cantidad = cantidad - ? WHERE sucursal_id = ? AND frasco_id = ?");
            $stmtMov = $this->pdo->prepare("
                INSERT INTO movimientos_stock (sucursal_id, frasco_id, tipo, cantidad, motivo, usuario_id, venta_id)
                VALUES (?, ?, 'venta', ?, 'Venta POS', ?, ?)
            ");

            foreach ($items as $item) {
                $frasco_id = (int)$item['frasco_id'];
                $perfume_id = (int)$item['perfume_id'];
                $cantidad = (int)$item['cantidad'];

                // 1. Bloquear y leer stock
                $stmtStock->execute([$sucursal_id, $frasco_id]);
                $stock = $stmtStock->fetchColumn();
                if ($stock === false || $stock < $cantidad) {
                    throw new \Exception("Stock insuficiente para el frasco ID $frasco_id");
                }

                // 2. Leer precio
                $stmtPrecio->execute([$sucursal_id, $frasco_id]);
                $precio = $stmtPrecio->fetchColumn();
                if ($precio === false) {
                    throw new \Exception("Precio no configurado para el frasco ID $frasco_id en esta sucursal");
                }
                
                $precio = (float)$precio;
                $subtotal = $precio * $cantidad;
                $total += $subtotal;

                // 3. Insertar item
                $stmtItem->execute([$venta_id, $perfume_id, $frasco_id, $cantidad, $precio, $subtotal]);

                // 4. Descontar stock
                $stmtUpdStock->execute([$cantidad, $sucursal_id, $frasco_id]);

                // 5. Registrar movimiento de stock (negativo)
                $stmtMov->execute([$sucursal_id, $frasco_id, -$cantidad, $vendedor_id, $venta_id]);
            }

            // Actualizar total de la venta
            $stmtUpdVenta = $this->pdo->prepare("UPDATE ventas SET total = ? WHERE id = ?");
            $stmtUpdVenta->execute([$total, $venta_id]);

            $this->pdo->commit();
            return ['venta_id' => $venta_id, 'total' => $total];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function reporte(int $sucursal_id, string $desde, string $hasta): array {
        // Resumen general
        $stmtRes = $this->pdo->prepare("
            SELECT COUNT(DISTINCT v.id) as ventas, 
                   COALESCE(SUM(v.total), 0) as ingresos,
                   COALESCE(SUM(vi.cantidad), 0) as frascos
            FROM ventas v
            LEFT JOIN venta_items vi ON vi.venta_id = v.id
            WHERE v.sucursal_id = :sucursal_id AND DATE(v.fecha) >= :desde AND DATE(v.fecha) <= :hasta
        ");
        $stmtRes->execute(['sucursal_id' => $sucursal_id, 'desde' => $desde, 'hasta' => $hasta]);
        $resumen = $stmtRes->fetch();

        // Top Frascos
        $stmtF = $this->pdo->prepare("
            SELECT f.nombre, SUM(vi.cantidad) as cantidad
            FROM venta_items vi
            JOIN ventas v ON v.id = vi.venta_id
            JOIN frascos f ON f.id = vi.frasco_id
            WHERE v.sucursal_id = :sucursal_id AND DATE(v.fecha) >= :desde AND DATE(v.fecha) <= :hasta
            GROUP BY vi.frasco_id
            ORDER BY cantidad DESC LIMIT 5
        ");
        $stmtF->execute(['sucursal_id' => $sucursal_id, 'desde' => $desde, 'hasta' => $hasta]);
        $topFrascos = $stmtF->fetchAll();

        // Top Perfumes
        $stmtP = $this->pdo->prepare("
            SELECT p.referencia as nombre, SUM(vi.cantidad) as cantidad
            FROM venta_items vi
            JOIN ventas v ON v.id = vi.venta_id
            JOIN perfumes p ON p.id = vi.perfume_id
            WHERE v.sucursal_id = :sucursal_id AND DATE(v.fecha) >= :desde AND DATE(v.fecha) <= :hasta
            GROUP BY vi.perfume_id
            ORDER BY cantidad DESC LIMIT 5
        ");
        $stmtP->execute(['sucursal_id' => $sucursal_id, 'desde' => $desde, 'hasta' => $hasta]);
        $topPerfumes = $stmtP->fetchAll();

        // Ventas de hoy (o del rango)
        $stmtV = $this->pdo->prepare("
            SELECT v.id, v.fecha, u.nombre as vendedora, v.metodo_pago, v.total,
                   (
                       SELECT GROUP_CONCAT(CONCAT(p.referencia, ' (', f.nombre, ') ×', vi2.cantidad) SEPARATOR ', ')
                       FROM venta_items vi2
                       JOIN frascos f ON f.id = vi2.frasco_id
                       JOIN perfumes p ON p.id = vi2.perfume_id
                       WHERE vi2.venta_id = v.id
                   ) as detalle
            FROM ventas v
            JOIN usuarios u ON u.id = v.vendedor_id
            WHERE v.sucursal_id = :sucursal_id AND DATE(v.fecha) >= :desde AND DATE(v.fecha) <= :hasta
            ORDER BY v.fecha DESC LIMIT 50
        ");
        $stmtV->execute(['sucursal_id' => $sucursal_id, 'desde' => $desde, 'hasta' => $hasta]);
        $ventas = $stmtV->fetchAll();

        return [
            'resumen' => [
                'ventas' => (int)$resumen['ventas'],
                'ingresos' => (float)$resumen['ingresos'],
                'frascos' => (int)$resumen['frascos']
            ],
            'topFrascos' => $topFrascos,
            'topPerfumes' => $topPerfumes,
            'ventas' => $ventas
        ];
    }
}
