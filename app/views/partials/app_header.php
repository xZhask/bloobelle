<?php
if ($user && $user['rol'] === 'admin') {
    $pdo = \App\Core\Database::connect();
    $_header_sucs = $pdo->query("SELECT id, nombre FROM sucursales WHERE activo = 1 ORDER BY id")->fetchAll();
} else {
    $_header_sucs = [];
}
?>
<style>
    .header {
      background: var(--color-surface);
      border-bottom: 1px solid var(--color-border);
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .header-content {
      max-width: 1800px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 80px;
    }
    .logo {
      font-family: var(--font-display);
      font-size: 28px;
      font-weight: 500;
      letter-spacing: 1px;
      color: var(--color-text-primary);
      text-decoration: none;
      transition: var(--transition-smooth);
    }
    .logo:hover {
      color: var(--color-accent);
    }
    .nav-link {
      font-size: 14px;
      font-weight: 500;
      color: var(--color-text-secondary);
      text-decoration: none;
      transition: var(--transition-smooth);
      letter-spacing: 0.5px;
    }
    .nav-link:hover {
      color: var(--color-accent);
    }
    .header-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .header-actions .actions {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-filters-mobile {
      display: none;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1.2rem;
      background: var(--color-text-primary);
      color: var(--color-surface);
      border: none;
      border-radius: 8px;
      font-family: var(--font-body);
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition-smooth);
      letter-spacing: 0.5px;
    }
    .btn-filters-mobile:hover {
      background: var(--color-accent);
      transform: translateY(-2px);
    }
    .btn-new {
      padding: 0.75rem 1.5rem;
      background: var(--color-accent);
      color: var(--color-surface);
      border: none;
      border-radius: 8px;
      font-family: var(--font-body);
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition-smooth);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      letter-spacing: 0.5px;
    }
    .btn-new:hover {
      background: var(--color-accent-hover);
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }
    .user-chip{display:inline-flex;align-items:center;gap:.5rem;font-size:.85rem;color:var(--color-text-primary,#1a1614)}
    .user-av{width:32px;height:32px;border-radius:50%;background:var(--color-elevated);color:var(--color-accent);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:1rem;border:1px solid var(--color-border)}
    .btn-logout{text-decoration:none;color:var(--color-text-secondary);font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;border-left:1px solid var(--color-border);padding-left:1rem;transition:color .2s}
    .btn-logout:hover{color:var(--color-accent)}
    .btn-pass{background:transparent;border:none;color:var(--color-text-secondary);cursor:pointer;padding:.2rem;display:inline-grid;place-items:center;border-left:1px solid var(--color-border);padding-left:.8rem;margin-left:.2rem}
    .btn-pass:hover{color:var(--color-accent)}
    .drawer-pass{background:transparent;border:none;color:var(--color-text-secondary);font-size:.85rem;text-align:left;padding:.3rem 0;cursor:pointer;flex-basis:100%}
    .drawer-pass:hover{color:var(--color-accent)}

    @media (max-width: 768px) {
      .header-content {
        height: 70px;
        padding: 0 1rem;
      }
      .logo {
        font-size: 22px;
      }
      .btn-filters-mobile {
        display: flex;
      }
      .btn-new,
      .nav-link,
      .user-chip,
      .btn-logout,
      .btn-pass,
      .store-select {
        display: none;
      }
    }
    .nav-drawer{position:fixed;top:0;right:0;bottom:0;width:84%;max-width:340px;
      background:var(--color-elevated,#292319);border-left:1px solid var(--color-border);
      transform:translateX(100%);transition:transform .28s ease;z-index:1100;
      display:flex;flex-direction:column;padding:1.3rem 1.2rem;}
    .nav-drawer.open{transform:none;}
    .nav-drawer-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;}
    .nav-drawer-title{font-family:var(--font-display);font-size:1.5rem;}
    .drawer-nav{display:flex;flex-direction:column;}
    .drawer-link{display:flex;align-items:center;gap:.7rem;padding:.8rem .2rem;
      color:var(--color-text-primary);text-decoration:none;border-bottom:1px solid var(--color-border);font-size:1rem;}
    .drawer-link svg{width:18px;height:18px;color:var(--color-accent);}
    .drawer-cta{display:flex;align-items:center;justify-content:center;gap:.5rem;
      background:var(--color-accent);color:var(--color-on-accent,#14110D);border:none;
      border-radius:12px;padding:.85rem;font-family:var(--font-body);font-weight:500;
      font-size:.95rem;margin-top:1rem;cursor:pointer;text-decoration:none;}
    .drawer-spacer{flex:1;}
    .drawer-account{display:flex;align-items:center;gap:.6rem;border-top:1px solid var(--color-border);padding-top:1rem;flex-wrap:wrap;}
    .drawer-account .who{flex:1;display:flex;flex-direction:column;line-height:1.1;}
    .drawer-account .rl{font-size:.66rem;text-transform:uppercase;letter-spacing:.08em;color:var(--color-text-secondary);}
    @media(min-width:861px){ .nav-drawer,#btn-menu{display:none !important;} }
</style>

<!-- Header -->
<header class="header">
  <div class="header-content">
    <a href="/perfumes" class="logo">BlooBelle</a>
    <div class="header-actions">
      <?php if(isset($showFilters) && $showFilters): ?>
      <button class="btn-filters-mobile" id="btn-toggle-filters" aria-label="Filtros">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M4 5h16M7 12h10M10 19h4"/></svg> Filtros
      </button>
      <?php endif; ?>
      <div class="actions">
      <button class="theme-toggle" id="theme-toggle-desktop" aria-label="Cambiar tema" title="Cambiar tema" style="background:transparent;border:1px solid var(--color-border);border-radius:50%;width:32px;height:32px;cursor:pointer;color:var(--color-accent);display:grid;place-items:center;">
        <span id="theme-icon-desktop" style="display:flex;align-items:center;justify-content:center;line-height:0;"></span>
      </button>
      <button class="theme-toggle" id="btn-menu" aria-label="Menú" title="Menú" aria-controls="nav-drawer" style="background:transparent;border:1px solid var(--color-border);border-radius:50%;width:32px;height:32px;cursor:pointer;color:var(--color-text-primary);display:grid;place-items:center;margin-left:0.5rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
      </div>

      <?php if ($user === null): ?>
        <button class="btn-new" id="btn-open-login"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" style="vertical-align:text-bottom;margin-right:4px;"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg> Iniciar sesión</button>

      <?php elseif ($user['rol'] === 'admin'): ?>
        <a href="/tienda/reporte" class="nav-link">Dashboard</a>
        <a href="/tienda/stock" class="nav-link">Stock</a>
        <a href="/tienda?pos=1" class="nav-link">Punto de Venta</a>
        <?php if(!isset($hideNewPerfume)): ?>
        <a href="/perfumes/create" class="btn-new"><span>+</span> Nuevo Perfume</a>
        <?php endif; ?>
        <?php if(isset($hideNewPerfume)): ?>
        <a href="/perfumes" class="btn-new" style="background:var(--color-surface); color:var(--color-accent); border:1px solid var(--color-accent); margin-right:1rem;">Catálogo de Perfumes</a>
        <?php else: ?>
        <a href="/catalogo/frascos" class="btn-new" style="background:var(--color-surface); color:var(--color-accent); border:1px solid var(--color-accent); margin-right:1rem;">Catálogo de Frascos</a>
        <?php endif; ?>
        <?php if(!isset($hideStoreSwitcher)): ?>
        <select class="store-select" id="header-sucursal-selector" style="background:var(--color-surface); border:1px solid var(--color-border); color:var(--color-text-primary); border-radius:6px; padding:0.4rem 0.6rem; font-family:var(--font-body); font-size:0.85rem; outline:none; cursor:pointer;">
          <?php foreach($_header_sucs as $s): ?>
            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
        <?php endif; ?>
        <span class="user-chip">
          <span class="user-av"><?= strtoupper(substr($user['nombre'], 0, 1)) ?></span>
          <span style="display:flex;flex-direction:column;line-height:1">
            <?= htmlspecialchars($user['nombre']) ?>
            <span style="font-size:10px;text-transform:uppercase;color:var(--color-text-secondary)">Admin</span>
          </span>
        </span>
        <button type="button" class="btn-pass js-open-password" title="Cambiar contraseña" aria-label="Cambiar contraseña">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="15" r="4"/><path d="M10.8 12.2 19 4l2 2-1.5 1.5L21 9l-2 2-1.5-1.5"/></svg>
        </button>
        <a href="/logout" class="btn-logout">Salir</a>

      <?php else: /* vendedor */ ?>
        <a href="/tienda?pos=1" class="btn-new"><span>+</span> Registrar venta</a>
        <a href="/tienda/stock" class="btn-new">Stock</a>
        <span class="user-chip">
          <span class="user-av"><?= strtoupper(substr($user['nombre'], 0, 1)) ?></span>
          <span style="display:flex;flex-direction:column;line-height:1">
            <?= htmlspecialchars($user['nombre']) ?>
            <span style="font-size:10px;text-transform:uppercase;color:var(--color-text-secondary)">Vendedora</span>
          </span>
        </span>
        <button type="button" class="btn-pass js-open-password" title="Cambiar contraseña" aria-label="Cambiar contraseña">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="15" r="4"/><path d="M10.8 12.2 19 4l2 2-1.5 1.5L21 9l-2 2-1.5-1.5"/></svg>
        </button>
        <a href="/logout" class="btn-logout">Salir</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>

<!-- Nav Drawer -->
<aside class="nav-drawer" id="nav-drawer" aria-hidden="true">
  <div class="nav-drawer-header">
    <span class="nav-drawer-title">Menú</span>
    <button class="theme-toggle" id="btn-menu-close" aria-label="Cerrar menú" style="background:transparent;border:1px solid var(--color-border);border-radius:50%;width:32px;height:32px;cursor:pointer;color:var(--color-text-primary);display:grid;place-items:center;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M6 6l12 12M18 6L6 18"/></svg>
    </button>
  </div>

  <?php if ($user === null): ?>
    <button class="drawer-cta" id="btn-open-login-drawer">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
      Iniciar sesión
    </button>
  <?php elseif ($user['rol'] === 'admin'): ?>
    <nav class="drawer-nav">
      <a href="/tienda/reporte" class="drawer-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M4 20V10M10 20V4M16 20v-6M22 20H2"/></svg>Dashboard</a>
      <a href="/tienda/stock" class="drawer-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M12 3l9 4-9 4-9-4 9-4zM3 12l9 4 9-4M3 17l9 4 9-4"/></svg>Stock</a>
      <a href="/tienda?pos=1" class="drawer-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M5 3h14v18l-2.5-1.5L14 21l-2-1.5L10 21l-2.5-1.5L5 21V3z"/><path d="M9 8h6M9 12h6"/></svg>Punto de Venta</a>
      <a href="/perfumes" class="drawer-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M9 2h6v3l1 2v12a2 2 0 01-2 2H10a2 2 0 01-2-2V7l1-2V2z"/><path d="M9 11h6"/></svg>Catálogo de Perfumes</a>
      <a href="/catalogo/frascos" class="drawer-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M9 2h6v3l1 2v12a2 2 0 01-2 2H10a2 2 0 01-2-2V7l1-2V2z"/><path d="M7 7h10M7 11h10M7 15h6"/></svg>Catálogo de Frascos</a>
    </nav>
    <a href="/perfumes/create" class="drawer-cta"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M12 5v14M5 12h14"/></svg>Nuevo Perfume</a>
    <div class="drawer-spacer"></div>
    <?php if(!isset($hideStoreSwitcher)): ?>
    <div style="padding:0 0.2rem 1rem;">
      <select id="header-sucursal-selector-drawer" style="width:100%; background:var(--color-bg); border:1px solid var(--color-border); color:var(--color-text-primary); border-radius:8px; padding:0.7rem 0.8rem; font-family:var(--font-body); font-size:0.95rem; outline:none; cursor:pointer;">
        <?php foreach($_header_sucs as $s): ?>
          <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <?php endif; ?>
    <div class="drawer-account">
      <span class="user-av"><?= strtoupper(substr($user['nombre'], 0, 1)) ?></span>
      <span class="who">
        <span class="nm"><?= htmlspecialchars($user['nombre']) ?></span>
        <span class="rl">Admin</span>
      </span>
      <a href="/logout" class="btn-logout" style="display:block; border-left:none; padding-left:0;">Salir</a>
      <button type="button" class="drawer-pass js-open-password">Cambiar contraseña</button>
    </div>
  <?php else: /* vendedor */ ?>
    <nav class="drawer-nav">
      <a href="/tienda?pos=1" class="drawer-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M5 3h14v18l-2.5-1.5L14 21l-2-1.5L10 21l-2.5-1.5L5 21V3z"/><path d="M9 8h6M9 12h6"/></svg>Registrar venta</a>
      <a href="/tienda/stock" class="drawer-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M12 3l9 4-9 4-9-4 9-4zM3 12l9 4 9-4M3 17l9 4 9-4"/></svg>Stock</a>
    </nav>
    <div class="drawer-spacer"></div>
    <div class="drawer-account">
      <span class="user-av"><?= strtoupper(substr($user['nombre'], 0, 1)) ?></span>
      <span class="who">
        <span class="nm"><?= htmlspecialchars($user['nombre']) ?></span>
        <span class="rl">Vendedora</span>
      </span>
      <a href="/logout" class="btn-logout" style="display:block; border-left:none; padding-left:0;">Salir</a>
      <button type="button" class="drawer-pass js-open-password">Cambiar contraseña</button>
    </div>
  <?php endif; ?>
</aside>

<?php require APP_ROOT . '/app/views/partials/password_modal.php'; ?>
<script>
function getSucursalId() {
  return parseInt(localStorage.getItem('admin_sucursal') || 1);
}

(function setupSucursalSelectors() {
  const syncSelectors = () => {
    const saved = localStorage.getItem('admin_sucursal');
    ['header-sucursal-selector', 'header-sucursal-selector-drawer'].forEach(id => {
      const sel = document.getElementById(id);
      if (!sel) return;
      if (saved) sel.value = saved;
      sel.addEventListener('change', () => {
        localStorage.setItem('admin_sucursal', sel.value);
        window.location.reload();
      });
    });
  };
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', syncSelectors);
  } else {
    syncSelectors();
  }
})();

document.addEventListener('DOMContentLoaded', () => {
  const overlay = document.getElementById('overlay');
  const sidebar = document.getElementById('sidebar');
  const navDrawer = document.getElementById('nav-drawer');

  window.closePanels = () => {
    sidebar?.classList.remove('active');
    navDrawer?.classList.remove('open');
    navDrawer?.setAttribute('aria-hidden', 'true');
    overlay?.classList.remove('active');
    document.body.style.overflow = '';
  };

  document.getElementById('btn-toggle-filters')?.addEventListener('click', () => {
    window.closePanels();
    sidebar?.classList.add('active');
    overlay?.classList.add('active');
    document.body.style.overflow = 'hidden';
  });

  document.getElementById('btn-menu')?.addEventListener('click', () => {
    window.closePanels();
    navDrawer?.classList.add('open');
    navDrawer?.setAttribute('aria-hidden', 'false');
    overlay?.classList.add('active');
    document.body.style.overflow = 'hidden';
    document.getElementById('btn-menu-close')?.focus();
  });

  document.getElementById('btn-menu-close')?.addEventListener('click', window.closePanels);
  overlay?.addEventListener('click', window.closePanels);
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') window.closePanels();
  });
});
</script>
<script>
(function(){
  var root=document.documentElement;
  function paint(t){ 
    var id = document.getElementById('theme-icon-desktop'); 
    if(id) {
      id.innerHTML = (t==='dark'
        ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M5 5l1.4 1.4M17.6 17.6L19 19M19 5l-1.4 1.4M6.4 17.6L5 19"/></svg>'
        : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M21 12.8A9 9 0 1111.2 3 7 7 0 0021 12.8z"/></svg>');
    }
  }
  paint(root.getAttribute('data-theme'));
  window.toggleTheme = function() {
    var n = root.getAttribute('data-theme')==='dark' ? 'light' : 'dark';
    root.setAttribute('data-theme', n);
    try{ localStorage.setItem('bb-theme', n); }catch(e){}
    paint(n);
  };
  var bd = document.getElementById('theme-toggle-desktop'); if(bd) bd.addEventListener('click', window.toggleTheme);
})();
</script>