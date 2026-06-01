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

  public function updatePerfume(int $id, array $data): void {
    $codigo = trim((string)($data['codigo'] ?? ''));
    $ref = trim((string)($data['referencia'] ?? ''));
    $rutaImg = trim((string)($data['ruta_img'] ?? ''));
    $descripcion = trim((string)($data['descripcion'] ?? ''));
    $generoId = (int)($data['genero_id'] ?? 0);
    $designerId = (int)($data['designer_id'] ?? 0);
    $tipos = $data['tipos_ids'] ?? [];
    $comps = $data['componentes_ids'] ?? [];

    if ($id <= 0 || $codigo === '' || $ref === '' || $generoId <= 0 || $designerId <= 0) {
      throw new \Exception("Campos obligatorios: codigo, referencia, genero_id, designer_id.");
    }

    $this->db->beginTransaction();
    try {
      if ($rutaImg !== '') {
          // Obtener la imagen anterior para eliminarla si cambia
          $stmtOld = $this->db->prepare("SELECT ruta_img FROM perfumes WHERE id = ?");
          $stmtOld->execute([$id]);
          $oldImg = $stmtOld->fetchColumn();

          $stmt = $this->db->prepare("UPDATE perfumes SET codigo=?, referencia=?, ruta_img=?, descripcion=?, genero_id=?, designer_id=? WHERE id=?");
          $stmt->execute([$codigo, $ref, $rutaImg, $descripcion ?: null, $generoId, $designerId, $id]);

          // Si se guardó correctamente y hay una imagen vieja diferente, la borramos del servidor
          if ($oldImg && $oldImg !== $rutaImg) {
              $oldImgPath = dirname(__DIR__, 2) . '/public' . $oldImg;
              if (file_exists($oldImgPath) && is_file($oldImgPath)) {
                  @unlink($oldImgPath);
              }
          }
      } else {
          $stmt = $this->db->prepare("UPDATE perfumes SET codigo=?, referencia=?, descripcion=?, genero_id=?, designer_id=? WHERE id=?");
          $stmt->execute([$codigo, $ref, $descripcion ?: null, $generoId, $designerId, $id]);
      }

      $this->db->prepare("DELETE FROM perfume_tipos_aroma WHERE perfume_id=?")->execute([$id]);
      $this->db->prepare("DELETE FROM perfume_componentes WHERE perfume_id=?")->execute([$id]);

      if (is_array($tipos) && count($tipos)) {
        $stmtT = $this->db->prepare("INSERT IGNORE INTO perfume_tipos_aroma(perfume_id, tipo_aroma_id) VALUES(?, ?)");
        foreach ($tipos as $tid) {
          $tid = (int)$tid;
          if ($tid > 0) $stmtT->execute([$id, $tid]);
        }
      }

      if (is_array($comps) && count($comps)) {
        $stmtC = $this->db->prepare("INSERT IGNORE INTO perfume_componentes(perfume_id, componente_id) VALUES(?, ?)");
        foreach ($comps as $cid) {
          $cid = (int)$cid;
          if ($cid > 0) $stmtC->execute([$id, $cid]);
        }
      }

      $this->db->commit();
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

  public function detalle(int $id): ?array {
      $stmt = $this->db->prepare("
          SELECT p.id, p.codigo, p.referencia, p.ruta_img, p.descripcion,
                 p.genero_id, p.designer_id,
                 g.nombre AS genero, d.nombre AS marca
          FROM perfumes p
          JOIN designers d ON d.id = p.designer_id
          JOIN generos  g ON g.id = p.genero_id
          WHERE p.id = :id
      ");
      $stmt->execute(['id' => $id]);
      $perfume = $stmt->fetch();
      if (!$perfume) return null;

      $c = $this->db->prepare("
          SELECT c.nombre, c.id FROM perfume_componentes pc
          JOIN componentes c ON c.id = pc.componente_id
          WHERE pc.perfume_id = :id ORDER BY c.nombre
      ");
      $c->execute(['id' => $id]);
      $perfume['componentes'] = $c->fetchAll(\PDO::FETCH_ASSOC);

      $t = $this->db->prepare("
          SELECT ta.nombre, ta.id FROM perfume_tipos_aroma pta
          JOIN tipos_aroma ta ON ta.id = pta.tipo_aroma_id
          WHERE pta.perfume_id = :id ORDER BY ta.nombre
      ");
      $t->execute(['id' => $id]);
      $perfume['tipos_aroma'] = $t->fetchAll(\PDO::FETCH_ASSOC);

      return $perfume;
  }
}
