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
<link rel="stylesheet" href="/assets/css/theme.css">
<script>
(function(){try{
  var t=localStorage.getItem('bb-theme');
  if(!t){t=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';}
  document.documentElement.setAttribute('data-theme',t);
}catch(e){}})();
</script>
<script>
  window.addEventListener('DOMContentLoaded', () => {
      let saved = localStorage.getItem('admin_sucursal');
      const setupSel = (id) => {
          const sel = document.getElementById(id);
          if(sel) {
              if(saved) sel.value = saved;
              sel.addEventListener('change', () => {
                  localStorage.setItem('admin_sucursal', sel.value);
                  window.location.reload();
              });
          }
      };
      setupSel('admin-sucursal-selector');
      setupSel('admin-sucursal-selector-mobile');
  });

  function getSucursalId() {
      <?php if ($isAdmin): ?>
      return parseInt(localStorage.getItem('admin_sucursal') || 1);
      <?php else: ?>
      return <?= $user['sucursal_id'] ?? 1 ?>;
      <?php endif; ?>
  }
</script>
</head>
<body>

<style>
.d-nav { display: flex; gap: 1.5rem; align-items: center; margin-left: 2rem; flex: 1; }
.d-nav a { text-decoration: none; color: var(--color-text-secondary); font-weight: 500; font-size: 0.95rem; transition: 0.2s; border-bottom: 2px solid transparent; padding: 1.25rem 0; white-space: nowrap; }
.d-nav a:hover { color: var(--color-text-primary); }
.d-nav a.active { color: var(--color-text-primary); border-bottom-color: var(--color-accent); }
.btn-logout{text-decoration:none;color:var(--color-text-secondary);font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;border-left:1px solid var(--color-border);padding-left:1rem;transition:color .2s}
.btn-logout:hover{color:var(--color-accent)}
.btn-pass{background:transparent;border:none;color:var(--color-text-secondary);cursor:pointer;padding:.2rem;display:inline-grid;place-items:center;border-left:1px solid var(--color-border);padding-left:.8rem;margin-left:.2rem}
.btn-pass:hover{color:var(--color-accent)}
</style>
<!-- DESKTOP HEADER (Admin) -->
<header class="header desktop-only" style="<?= !$isAdmin ? 'display:none;' : '' ?>">
  <div class="hc">
    <a href="/tienda/reporte" class="brand" style="text-decoration:none;"><span class="logo">BlooBelle</span><span class="tag">Panel admin</span></a>

    <div class="right" style="display:flex; align-items:center; gap:1rem; flex:1; justify-content:flex-end;">
      <button class="theme-toggle" id="theme-toggle-desktop" aria-label="Cambiar tema" title="Cambiar tema" style="background:transparent;border:1px solid var(--color-border);border-radius:50%;width:32px;height:32px;cursor:pointer;color:var(--color-accent);display:grid;place-items:center;">
        <span id="theme-icon-desktop" style="display:flex;align-items:center;justify-content:center;line-height:0;"></span>
      </button>

      <nav class="d-nav" style="margin-left:0; flex:0; gap:1.5rem;">
        <a href="/perfumes" style="font-size:14px;">Catálogo</a>
        <a href="/tienda/reporte" style="font-size:14px;" class="<?= $activeTab === 'reporte' ? 'active' : '' ?>">Dashboard</a>
        <a href="/tienda/stock" style="font-size:14px;" class="<?= $activeTab === 'stock' ? 'active' : '' ?>">Stock</a>
        <a href="/tienda?pos=1" style="font-size:14px;" class="<?= $activeTab === 'venta' ? 'active' : '' ?>">Punto de Venta</a>
      </nav>

      <?php if ($isAdmin): ?>
      <select id="admin-sucursal-selector" style="font-family: 'Jost', sans-serif; font-size: 0.85rem; padding: 0.4rem 0.6rem; border: 1px solid var(--color-border); border-radius: 6px; background: var(--color-surface); color: var(--color-text-primary); outline:none; cursor:pointer;">
          <?php
          $pdo = \App\Core\Database::connect();
          $sucs = $pdo->query("SELECT id, nombre FROM sucursales WHERE activo = 1")->fetchAll();
          foreach($sucs as $s):
          ?>
              <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
          <?php endforeach; ?>
      </select>
      <?php endif; ?>

      <span class="who">
        <span class="av"><?= strtoupper(substr($user['nombre'],0,1)) ?></span>
        <span style="display:flex;flex-direction:column;line-height:1;">
          <span class="n"><?= htmlspecialchars($user['nombre']) ?></span>
          <span style="font-size:10px;text-transform:uppercase;color:var(--color-text-secondary);">Admin</span>
        </span>
      </span>
      <button type="button" class="btn-pass js-open-password" title="Cambiar contraseña" aria-label="Cambiar contraseña">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="15" r="4"/><path d="M10.8 12.2 19 4l2 2-1.5 1.5L21 9l-2 2-1.5-1.5"/></svg>
      </button>
      <a href="/logout" class="btn-logout">Salir</a>
    </div>
  </div>
</header>

<!-- MOBILE LAYOUT -->
<div class="phone <?= ($isAdmin && $activeTab !== 'venta') ? 'mobile-only' : '' ?>" style="margin: 0 auto; max-width: 480px; min-height: 100vh; background: var(--color-bg); box-shadow: var(--shadow); border-left: 1px solid var(--color-border); border-right: 1px solid var(--color-border); position: relative;">
  <?php if (!$isAdmin): ?>
  <div class="notch" style="display:none"></div>
  <?php endif; ?>
  <div class="screen" style="min-height:100vh; background:var(--color-bg);">
    <div class="topbar <?= $isAdmin ? 'mobile-only' : '' ?>">
      <div class="brand"><span class="logo">BlooBelle</span><?php if(!$isAdmin): ?><span class="city"><?= htmlspecialchars(strtoupper($cityName)) ?></span><?php endif; ?></div>
      <?php if ($isAdmin): ?>
      <select id="admin-sucursal-selector-mobile" style="font-family: 'Jost', sans-serif; font-size: 0.8rem; padding: 0.2rem 0.4rem; border: 1px solid var(--color-border); border-radius: 4px; background: var(--color-bg); color: var(--color-text-primary); margin-left: auto;">
          <?php 
          $pdo = \App\Core\Database::connect();
          $sucs = $pdo->query("SELECT id, nombre FROM sucursales WHERE activo = 1")->fetchAll();
          foreach($sucs as $s): 
          ?>
              <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
          <?php endforeach; ?>
      </select>
      <?php endif; ?>
      <div style="display:flex; align-items:center; gap:0.6rem; <?= $isAdmin ? 'margin-left: 0.5rem;' : 'margin-left: auto;' ?>">
        <button class="theme-toggle" id="theme-toggle-mobile" style="background:transparent;border:1px solid var(--color-border);border-radius:50%;width:28px;height:28px;cursor:pointer;color:var(--color-text-primary);display:grid;place-items:center;">
          <span id="theme-icon-mobile"></span>
        </button>
        <span class="av"><?= strtoupper(substr($user['nombre'],0,1)) ?></span>
        <button type="button" class="btn-pass js-open-password" title="Cambiar contraseña" aria-label="Cambiar contraseña">
          <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="15" r="4"/><path d="M10.8 12.2 19 4l2 2-1.5 1.5L21 9l-2 2-1.5-1.5"/></svg>
        </button>
        <a href="/logout" style="color:var(--color-text-secondary); font-size:0.75rem; text-decoration:none; text-transform:uppercase; letter-spacing:1px; border-left:1px solid var(--color-border); padding-left:0.6rem;">Salir</a>
      </div>
    </div>
    
    <div class="seg <?= $isAdmin ? 'mobile-only' : '' ?>">
      <button onclick="window.location.href='/perfumes'">Catálogo</button>
      <button class="<?= $activeTab === 'venta' ? 'on' : '' ?>" onclick="window.location.href='/tienda<?= $isAdmin ? '?pos=1' : '' ?>'">Venta</button>
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

<?php require APP_ROOT . '/app/views/partials/password_modal.php'; ?>
<?= $modals ?? '' ?>

<script>
  const SVG = {
    botella:'<svg viewBox="0 0 40 56"><rect x="16" y="2" width="8" height="7" rx="2" fill="#b88e5d"/><rect x="14" y="9" width="12" height="5" fill="#cdab82"/><rect x="9" y="14" width="22" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>',
    corazon:'<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 52C6 40 8 22 20 26C32 22 34 40 20 52Z" fill="#f0c9c0" stroke="#b88e5d" stroke-width="1.2"/></svg>',
    paris:'<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 10 L27 30 L30 54 L10 54 L13 30 Z" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>',
    camara:'<svg viewBox="0 0 40 56"><rect x="16" y="4" width="8" height="6" rx="2" fill="#b88e5d"/><rect x="8" y="12" width="24" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/><circle cx="20" cy="32" r="8" fill="#fff" stroke="#b88e5d" stroke-width="1.2"/></svg>'
  };
</script>
<script>
(function(){
  var root=document.documentElement;
  function paint(t){ 
    var id = document.getElementById('theme-icon-desktop'); 
    var im = document.getElementById('theme-icon-mobile'); 
    var svg = (t==='dark'
      ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M5 5l1.4 1.4M17.6 17.6L19 19M19 5l-1.4 1.4M6.4 17.6L5 19"/></svg>'
      : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M21 12.8A9 9 0 1111.2 3 7 7 0 0021 12.8z"/></svg>'
    );
    if(id) id.innerHTML = svg; 
    if(im) im.innerHTML = svg; 
  }
  paint(root.getAttribute('data-theme'));
  function toggleTheme() {
    var n = root.getAttribute('data-theme')==='dark' ? 'light' : 'dark';
    root.setAttribute('data-theme', n);
    try{ localStorage.setItem('bb-theme', n); }catch(e){}
    paint(n);
  }
  var bd = document.getElementById('theme-toggle-desktop'); if(bd) bd.addEventListener('click', toggleTheme);
  var bm = document.getElementById('theme-toggle-mobile'); if(bm) bm.addEventListener('click', toggleTheme);
})();
</script>
</body>
</html>
