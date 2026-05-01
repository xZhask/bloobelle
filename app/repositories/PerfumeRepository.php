<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class PerfumeRepository {
  private PDO $db;

  public function __construct() {
    $this->db = Database::connect();
  }

  public function getGeneros(): array {
    return $this->db->query("SELECT id, nombre FROM generos ORDER BY nombre")->fetchAll();
  }

  public function getDesigners(): array {
    return $this->db->query("SELECT id, nombre FROM designers ORDER BY nombre")->fetchAll();
  }

  public function getTiposAroma(): array {
    return $this->db->query("SELECT id, nombre, categoria FROM tipos_aroma ORDER BY nombre")->fetchAll();
  }

  public function getComponentes(): array {
    return $this->db->query("SELECT id, nombre FROM componentes ORDER BY nombre")->fetchAll();
  }

  public function listarInicial(int $limit = 30): array {
    $stmt = $this->db->prepare("
      SELECT p.id, p.codigo, p.referencia, p.ruta_img, p.descripcion,
             d.nombre AS marca,
             g.nombre AS genero
      FROM perfumes p
      JOIN designers d ON d.id = p.designer_id
      JOIN generos g ON g.id = p.genero_id
      ORDER BY p.id DESC
      LIMIT ?
    ");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function filtrar(array $f): array {
    $sql = "
      SELECT DISTINCT
        p.id, p.codigo, p.referencia, p.ruta_img, p.descripcion,
        d.nombre AS marca,
        g.nombre AS genero
      FROM perfumes p
      JOIN designers d ON d.id = p.designer_id
      JOIN generos g ON g.id = p.genero_id      
      LEFT JOIN perfume_componentes pc ON p.id = pc.perfume_id
      LEFT JOIN componentes c ON pc.componente_id = c.id
      LEFT JOIN perfume_tipos_aroma pta ON p.id = pta.perfume_id
      LEFT JOIN tipos_aroma ta ON pta.tipo_aroma_id = ta.id
      WHERE 1=1
    ";

    $params = [];

    if (!empty($f['search'])) {
      $searchTerm = '%' . trim($f['search']) . '%';
      // Expandimos el OR para incluir las nuevas columnas
      $sql .= " AND (
          p.referencia LIKE ? 
          OR p.codigo LIKE ? 
          OR d.nombre LIKE ? 
          OR p.descripcion LIKE ?
          OR c.nombre LIKE ? 
          OR ta.nombre LIKE ?
      )";
      
      $params[] = $searchTerm; // referencia
      $params[] = $searchTerm; // codigo
      $params[] = $searchTerm; // marca
      $params[] = $searchTerm; // descripcion
      $params[] = $searchTerm; // componente
      $params[] = $searchTerm; // tipo de aroma
    }

    if (!empty($f['genero'])) {
      [$clause, $p] = $this->inClause('g.nombre', $f['genero'], false);
      $sql .= " AND $clause";
      $params = array_merge($params, $p);
    }

    // Opcional: Si tienes filtros específicos para componentes (select múltiple)
    if (!empty($f['componentes'])) {
        [$clause, $p] = $this->inClause('c.nombre', $f['componentes'], false);
        $sql .= " AND $clause";
        $params = array_merge($params, $p);
    }

    $sql .= " ORDER BY p.id DESC LIMIT 300";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

  private function inClause(string $field, array $values, bool $numeric): array {
    $values = array_values(array_filter($values, fn($v) => $v !== null && $v !== ''));
    if (!$values) return ["1=1", []];
    $placeholders = implode(',', array_fill(0, count($values), '?'));
    $params = $numeric ? array_map('intval', $values) : array_map('strval', $values);
    return ["$field IN ($placeholders)", $params];
  }

  public function crearPerfume(array $data): int {
    $codigo = trim((string)($data['codigo'] ?? ''));
    $ref = trim((string)($data['referencia'] ?? ''));
    $rutaImg = trim((string)($data['ruta_img'] ?? ''));
    $descripcion = trim((string)($data['descripcion'] ?? ''));
    $generoId = (int)($data['genero_id'] ?? 0);
    $designerId = (int)($data['designer_id'] ?? 0);
    $tipos = $data['tipos_ids'] ?? [];
    $comps = $data['componentes_ids'] ?? [];

    if ($codigo === '' || $ref === '' || $generoId <= 0 || $designerId <= 0) {
      throw new \Exception("Campos obligatorios: codigo, referencia, genero_id, designer_id.");
    }

    $this->db->beginTransaction();
    try {
      $stmt = $this->db->prepare("INSERT INTO perfumes(codigo, referencia, ruta_img, descripcion, genero_id, designer_id) VALUES(?, ?, ?, ?, ?, ?)");
      $stmt->execute([$codigo, $ref, $rutaImg ?: null, $descripcion ?: null, $generoId, $designerId]);
      $perfumeId = (int)$this->db->lastInsertId();

      if (is_array($tipos) && count($tipos)) {
        $stmtT = $this->db->prepare("INSERT IGNORE INTO perfume_tipos_aroma(perfume_id, tipo_aroma_id) VALUES(?, ?)");
        foreach ($tipos as $tid) {
          $tid = (int)$tid;
          if ($tid > 0) $stmtT->execute([$perfumeId, $tid]);
        }
      }

      if (is_array($comps) && count($comps)) {
        $stmtC = $this->db->prepare("INSERT IGNORE INTO perfume_componentes(perfume_id, componente_id) VALUES(?, ?)");
        foreach ($comps as $cid) {
          $cid = (int)$cid;
          if ($cid > 0) $stmtC->execute([$perfumeId, $cid]);
        }
      }

      $this->db->commit();
      return $perfumeId;
    } catch (\Throwable $e) {
      $this->db->rollBack();
      throw $e;
    }
  }

  public function crearDesigner(array $data): int {
    $nombre = trim(strtoupper((string)($data['nombre'] ?? '')));
    if ($nombre === '') {
      throw new \Exception("El nombre del diseñador es obligatorio.");
    }

    // Verificar duplicado
    $check = $this->db->prepare("SELECT id FROM designers WHERE nombre = ?");
    $check->execute([$nombre]);
    if ($existing = $check->fetch()) {
      throw new \Exception("El diseñador '{$nombre}' ya existe.");
    }

    $stmt = $this->db->prepare("INSERT INTO designers(nombre) VALUES(?)");
    $stmt->execute([$nombre]);
    return (int)$this->db->lastInsertId();
  }

  public function crearComponente(array $data): int {
    $nombre = trim(strtoupper((string)($data['nombre'] ?? '')));
    if ($nombre === '') {
      throw new \Exception("El nombre del componente es obligatorio.");
    }

    $check = $this->db->prepare("SELECT id FROM componentes WHERE nombre = ?");
    $check->execute([$nombre]);
    if ($existing = $check->fetch()) {
      throw new \Exception("El componente '{$nombre}' ya existe.");
    }

    $stmt = $this->db->prepare("INSERT INTO componentes(nombre) VALUES(?)");
    $stmt->execute([$nombre]);
    return (int)$this->db->lastInsertId();
  }

  public function crearTipoAroma(array $data): int {
    $nombre = trim(strtoupper((string)($data['nombre'] ?? '')));
    if ($nombre === '') {
      throw new \Exception("El nombre del tipo de aroma es obligatorio.");
    }

    $check = $this->db->prepare("SELECT id FROM tipos_aroma WHERE nombre = ?");
    $check->execute([$nombre]);
    if ($existing = $check->fetch()) {
      throw new \Exception("El tipo de aroma '{$nombre}' ya existe.");
    }

    $stmt = $this->db->prepare("INSERT INTO tipos_aroma(nombre, categoria) VALUES(?, 'perfil')");
    $stmt->execute([$nombre]);
    return (int)$this->db->lastInsertId();
  }
}
