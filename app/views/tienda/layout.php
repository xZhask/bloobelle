<?php
use App\Core\Auth;
use App\Core\Database;

$user = Auth::user();
$isAdmin = $user['rol'] === 'admin';
$activeTab = $activeTab ?? 'venta';

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
</head>
<body>

<?php require APP_ROOT . '/app/views/partials/app_header.php'; ?>
<?php if (!$isAdmin): ?>
<script>function getSucursalId() { return <?= (int)($user['sucursal_id'] ?? 1) ?>; }</script>
<?php endif; ?>

<!-- MOBILE LAYOUT -->
<div class="phone <?= ($isAdmin && $activeTab !== 'venta') ? 'mobile-only' : '' ?>" style="margin: 0 auto; max-width: 480px; min-height: 100vh; background: var(--color-bg); box-shadow: var(--shadow); border-left: 1px solid var(--color-border); border-right: 1px solid var(--color-border); position: relative;">
  <?php if (!$isAdmin): ?>
  <div class="notch" style="display:none"></div>
  <?php endif; ?>
  <div class="screen" style="min-height:100vh; background:var(--color-bg);">
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

<?= $modals ?? '' ?>

<div id="toastContainer"></div>

<script>
  const SVG = {
    botella:'<svg viewBox="0 0 40 56"><rect x="16" y="2" width="8" height="7" rx="2" fill="#b88e5d"/><rect x="14" y="9" width="12" height="5" fill="#cdab82"/><rect x="9" y="14" width="22" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>',
    corazon:'<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 52C6 40 8 22 20 26C32 22 34 40 20 52Z" fill="#f0c9c0" stroke="#b88e5d" stroke-width="1.2"/></svg>',
    paris:'<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 10 L27 30 L30 54 L10 54 L13 30 Z" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>',
    camara:'<svg viewBox="0 0 40 56"><rect x="16" y="4" width="8" height="6" rx="2" fill="#b88e5d"/><rect x="8" y="12" width="24" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/><circle cx="20" cy="32" r="8" fill="#fff" stroke="#b88e5d" stroke-width="1.2"/></svg>'
  };

  function showToast(message, type = 'success') {
      const container = document.getElementById('toastContainer');
      if (!container) return;
      const toast = document.createElement('div');
      toast.className = `toast ${type}`;
      
      let icon = '';
      if(type === 'success') {
          icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
      } else if(type === 'error') {
          icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
      }

      toast.innerHTML = `${icon} <span>${message}</span>`;
      container.appendChild(toast);
      
      setTimeout(() => toast.classList.add('show'), 10);
      setTimeout(() => {
          toast.classList.remove('show');
          setTimeout(() => toast.remove(), 300);
      }, 3500);
  }
</script>
</body>
</html>
