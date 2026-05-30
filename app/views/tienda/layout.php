<?php
use App\Core\Auth;
use App\Core\Database;

$user = Auth::user();
$isAdmin = $user['rol'] === 'admin';
$activeTab = $activeTab ?? 'venta';

$cityName = 'Admin';
if (!$isAdmin && !empty($user['sucursal_id'])) {
    $pdo = Database::connect();
    $stmt = $pdo->prepare("SELECT ciudad FROM sucursales WHERE id = ?");
    $stmt->execute([$user['sucursal_id']]);
    $ciudadDb = $stmt->fetchColumn();
    if ($ciudadDb) {
        $cityName = $ciudadDb;
    } else {
        $cityName = 'Sucursal ' . $user['sucursal_id'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>BlooBelle · Tienda</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/tienda.css">
<script>
  function getSucursalId() {
      return <?= $user['sucursal_id'] ?? 1 ?>;
  }
</script>
</head>
<body>

<style>
.d-nav { display: flex; gap: 1.5rem; align-items: center; margin-left: 2rem; flex: 1; }
.d-nav a { text-decoration: none; color: var(--muted); font-weight: 500; font-size: 0.95rem; transition: 0.2s; border-bottom: 2px solid transparent; padding: 1.25rem 0; }
.d-nav a:hover { color: var(--text); }
.d-nav a.active { color: var(--text); border-bottom-color: var(--accent); }
</style>
<!-- DESKTOP HEADER (Admin) -->
<header class="header desktop-only" style="<?= !$isAdmin ? 'display:none;' : '' ?>">
  <div class="hc">
    <a href="/tienda/reporte" class="brand" style="text-decoration:none;"><span class="logo">BlooBelle</span><span class="tag">Panel admin</span></a>
    
    <nav class="d-nav">
        <a href="/tienda/reporte" class="<?= $activeTab === 'reporte' ? 'active' : '' ?>">Dashboard</a>
        <a href="/tienda/stock" class="<?= $activeTab === 'stock' ? 'active' : '' ?>">Stock</a>
        <a href="/tienda?pos=1" class="<?= $activeTab === 'venta' ? 'active' : '' ?>">Punto de Venta</a>
    </nav>

    <div class="right">
      <div class="who">
        <div class="av"><?= strtoupper(substr($user['nombre'],0,1)) ?></div>
        <div>
          <div class="n"><?= htmlspecialchars($user['nombre']) ?></div>
          <div class="r"><a href="/logout" style="color:var(--muted); text-decoration:none;">SALIR</a></div>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- MOBILE LAYOUT -->
<div class="phone <?= $isAdmin ? 'mobile-only' : '' ?>" style="margin: 0 auto; max-width: 480px; min-height: 100vh; background: var(--bg); box-shadow: var(--shadow); border-left: 1px solid var(--border); border-right: 1px solid var(--border); position: relative;">
  <?php if (!$isAdmin): ?>
  <div class="notch" style="display:none"></div>
  <?php endif; ?>
  <div class="screen" style="min-height:100vh; background:var(--bg);">
    <div class="topbar">
      <div class="brand"><span class="logo">BlooBelle</span><?php if(!$isAdmin): ?><span class="city"><?= htmlspecialchars(strtoupper($cityName)) ?></span><?php endif; ?></div>
      <div style="display:flex; align-items:center; gap:0.6rem">
        <span class="av"><?= strtoupper(substr($user['nombre'],0,1)) ?></span>
        <a href="/logout" style="color:var(--muted); font-size:0.75rem; text-decoration:none; text-transform:uppercase; letter-spacing:1px; border-left:1px solid var(--border); padding-left:0.6rem;">Salir</a>
      </div>
    </div>
    
    <div class="seg">
      <button class="<?= $activeTab === 'venta' ? 'on' : '' ?>" onclick="window.location.href='/tienda'">Venta</button>
      <button class="<?= $activeTab === 'stock' ? 'on' : '' ?>" onclick="window.location.href='/tienda/stock'">Stock</button>
      <?php if ($isAdmin): ?>
      <button class="<?= $activeTab === 'reporte' ? 'on' : '' ?>" onclick="window.location.href='/tienda/reporte'">Reporte</button>
      <?php endif; ?>
    </div>

    <!-- MAIN CONTENT INJECTED HERE -->
    <div id="content_wrapper">
        <?= $content ?? '' ?>
    </div>
  </div>
</div>

<!-- DESKTOP DASHBOARD CONTENT INJECTED HERE -->
<?php if ($isAdmin): ?>
<div class="desktop-only wrap">
    <?= $desktopContent ?? '' ?>
</div>
<?php endif; ?>

<script>
  const SVG = {
    botella:'<svg viewBox="0 0 40 56"><rect x="16" y="2" width="8" height="7" rx="2" fill="#b88e5d"/><rect x="14" y="9" width="12" height="5" fill="#cdab82"/><rect x="9" y="14" width="22" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>',
    corazon:'<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 52C6 40 8 22 20 26C32 22 34 40 20 52Z" fill="#f0c9c0" stroke="#b88e5d" stroke-width="1.2"/></svg>',
    paris:'<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 10 L27 30 L30 54 L10 54 L13 30 Z" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>',
    camara:'<svg viewBox="0 0 40 56"><rect x="16" y="4" width="8" height="6" rx="2" fill="#b88e5d"/><rect x="8" y="12" width="24" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/><circle cx="20" cy="32" r="8" fill="#fff" stroke="#b88e5d" stroke-width="1.2"/></svg>'
  };
</script>
</body>
</html>
