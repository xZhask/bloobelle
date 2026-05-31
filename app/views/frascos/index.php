<?php
use App\Core\Auth;
$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>BlooBelle · Gestión de frascos</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/theme.css">
  <script>
  (function(){try{
    var t=localStorage.getItem('bb-theme');
    if(!t){t=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';}
    document.documentElement.setAttribute('data-theme',t);
  }catch(e){}})();
  </script>
  <style>
    :root{
      --fd:'Playfair Display',serif;--fb:'Jost',sans-serif;
    }
  *{margin:0;padding:0;box-sizing:border-box}
  body{font-family:var(--fb);background:var(--color-bg);color:var(--color-text-primary);-webkit-font-smoothing:antialiased}
  
  .crumb-bar { font-size: .72rem; letter-spacing: .14em; text-transform: uppercase; color: var(--color-text-secondary); padding-bottom: .55rem; margin-bottom: 1rem; border-bottom: 1px solid var(--color-border); }
  .crumb-bar b { color: var(--color-accent); font-weight: 500; }
  .titlerow { display: flex; align-items: flex-start; justify-content: space-between; gap: 0.8rem; margin-bottom: 0.2rem; }
  .newbtn { flex: none; display: inline-flex; align-items: center; gap: 0.35rem; background: var(--color-accent); color: var(--color-on-accent); border: none; border-radius: 999px; padding: 0.6rem 1.1rem; font-family: var(--fb); font-size: 0.88rem; font-weight: 500; cursor: pointer; }
  .newbtn svg { width: 18px; height: 18px; }
  .newbtn:hover { background: var(--color-accent-hover); }

  /* Mobile Cards for Frascos */
  .frascos-cards { display: none; margin-top: 1rem; }
  .fcard { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 14px; padding: 0.7rem 0.8rem; margin-bottom: 0.6rem; }
  .fcard.off { opacity: 0.5; }
  .fcard .top { display: flex; align-items: flex-start; gap: 0.7rem; }
  .fcard .thumb { width: 46px; height: 46px; border-radius: 10px; background: var(--color-bg); flex: none; display: flex; align-items: center; justify-content: center; }
  .fcard .thumb.dis { background: #2A1D1B; }
  .fcard .thumb svg { height: 32px; width: 32px; }
  .fcard .info { flex: 1; min-width: 0; }
  .fcard .nm { font-weight: 500; font-size: 0.98rem; line-height: 1.2; color: var(--color-text-primary); }
  .fcard .chip { display: inline-block; font-size: 0.6rem; letter-spacing: 0.06em; text-transform: uppercase; padding: 0.1rem 0.45rem; border-radius: 999px; margin-top: 0.25rem; }
  .fcard .chip.gen { background: var(--color-bg); color: var(--color-text-secondary); }
  .fcard .chip.dis { background: #2A1D1B; color: #D98F86; border: 1px solid #4a2e2b; }
  .fcard .edit { flex: none; border: 1px solid var(--color-border); background: var(--color-surface); color: var(--color-text-primary); border-radius: 9px; padding: 0.4rem 0.5rem; font-family: var(--fb); font-size: 0.76rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem; }
  .fcard .edit svg { width: 13px; height: 13px; color: var(--color-text-primary); }
  .fcard .bottom { display: flex; align-items: center; justify-content: space-between; margin-top: 0.65rem; padding-top: 0.6rem; border-top: 1px solid var(--color-border); }
  .fcard .meta { font-size: 0.78rem; color: var(--color-text-secondary); font-variant-numeric: tabular-nums; }
  
  @media (max-width: 820px) {
    .frascos-table { display: none; }
    .frascos-cards { display: block; }
  }

  .wrap{max-width:1240px;margin:0 auto;padding:2rem}
  .h1{font-family:var(--fd);font-size:1.9rem;font-weight:500;margin-bottom:.2rem}
  .h1sub{color:var(--color-text-secondary);font-size:.9rem;margin-bottom:1.4rem}

  /* Toolbar */
  .toolbar{display:flex;align-items:center;gap:.8rem;flex-wrap:wrap;margin-bottom:1.1rem}
  .search{position:relative;flex:1;min-width:240px;max-width:380px}
  .search input{width:100%;padding:.7rem .8rem .7rem 2.2rem;border:1px solid var(--color-border);border-radius:10px;font-family:var(--fb);font-size:.95rem;background:var(--color-surface);color:var(--color-text-primary);transition:.2s}
  .search input:focus{outline:none;border-color:var(--color-accent)}
  .search svg{position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:var(--color-text-secondary)}
  .segs{display:flex;gap:.3rem;background:var(--color-surface);border:1px solid var(--color-border);padding:.25rem;border-radius:999px;margin-bottom:.5rem;overflow:hidden}
  .segs button{flex:1;border:none;background:transparent;color:var(--color-text-secondary);font-family:var(--fb);font-size:.78rem;padding:.4rem 1rem;border-radius:999px;cursor:pointer;white-space:nowrap}
  .segs button.on{background:var(--color-bg);color:var(--color-text-primary);font-weight:500;box-shadow:0 1px 3px rgba(0,0,0,.1)}
  .count{font-size:.8rem;color:var(--color-text-secondary);margin-left:auto}

  /* Tabla */
  .card{background:var(--color-surface);border:1px solid var(--color-border);border-radius:16px;overflow-x:auto}
  table{width:100%;border-collapse:collapse;text-align:left;font-size:.9rem}
  th{font-weight:500;color:var(--color-text-secondary);border-bottom:1px solid var(--color-border);padding:1rem .8rem;text-transform:uppercase;font-size:.75rem;letter-spacing:.05em}
  td{padding:1rem .8rem;border-bottom:1px solid var(--color-border);vertical-align:middle}
  tr:last-child td{border-bottom:none}
  tr.grouprow td{background:var(--color-bg);font-weight:600;font-size:.8rem;text-transform:uppercase;letter-spacing:.1em;color:var(--color-text-secondary);padding:.6rem .8rem}
  
  .thumb{width:46px;height:46px;border-radius:10px;background:var(--color-bg);display:flex;align-items:center;justify-content:center}
  .thumb.dis{background:#2A1D1B}
  .thumb svg{height:32px;width:32px;}
  .name{font-weight:500;font-size:.98rem;margin-bottom:.2rem}
  .chip{display:inline-block;font-size:.6rem;letter-spacing:.06em;text-transform:uppercase;padding:.1rem .45rem;border-radius:999px}
  .chip.gen{background:var(--color-bg);color:var(--color-text-secondary)}
  .chip.dis{background:#2A1D1B;color:#D98F86;border:1px solid #4a2e2b}
  
  .desc{color:var(--color-text-secondary);font-size:.85rem;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .num{font-variant-numeric:tabular-nums;color:var(--color-text-secondary)}
  .center{text-align:center}
  .ord{background:var(--color-bg);border:1px solid var(--color-border);border-radius:6px;padding:.2rem .5rem;font-size:.85rem;display:inline-flex;align-items:center;gap:.3rem}
  .drag{color:var(--color-text-secondary);opacity:.5;cursor:grab;font-size:.9rem}

  .estado{display:inline-flex;align-items:center;gap:.5rem}
  .switch{position:relative;width:40px;height:23px;border-radius:999px;background:var(--color-border);cursor:pointer;transition:.2s}
  .switch::after{content:"";position:absolute;top:3px;left:3px;width:17px;height:17px;border-radius:50%;background:#fff;transition:.2s;box-shadow:0 2px 4px rgba(0,0,0,.15)}
  .switch.on{background:var(--color-success)}
  .switch.on::after{left:21px}
  .lbl{font-size:.78rem;color:var(--color-success);font-weight:500;min-width:54px}
  .lbl.off{color:var(--color-text-secondary)}

  .iconbtn{border:1px solid var(--color-border);background:var(--color-surface);border-radius:10px;padding:.45rem .55rem;cursor:pointer;color:var(--color-text-primary);display:inline-flex;align-items:center;gap:.35rem;font-family:var(--fb);font-size:.82rem}
  .iconbtn:hover{border-color:var(--color-accent);color:var(--color-accent)}

  tr.inactive{opacity:.5}
  tr.inactive .name{text-decoration:none}

  @media(max-width:820px){
    .nav{display:none}.desc{display:none}
    .wrap{padding:1.1rem}
    .newbtn-long{display:none}
    .count{order:10;width:100%;margin-left:0;margin-top:.1rem}
    .crumb-bar{margin-left:-1.1rem;margin-right:-1.1rem;padding-left:1.1rem;padding-right:1.1rem}
    .segs{width:100%}
    .search{max-width:100%}
  }

  /* MODAL (Added for Edit) */
  .modal-overlay {
      position: fixed; top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.4); backdrop-filter: blur(2px);
      display: none; align-items: center; justify-content: center; z-index: 1000;
  }
  .modal-overlay.open { display: flex; }
  .modal {
      background: var(--color-surface); padding: 2rem; border-radius: 16px;
      width: 90%; max-width: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      max-height: 90vh; overflow-y: auto;
  }
  @media (max-width: 500px) {
      .modal { padding: 1.5rem 1.25rem; }
  }
  .modal h3 { font-family: var(--fd); font-size: 1.5rem; margin-bottom: 1.5rem; }
  .form-group { margin-bottom: 1rem; }
  .form-label { display: block; font-size: 0.85rem; color: var(--color-text-secondary); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 1px; }
  .form-input { width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--color-border); border-radius: 8px; font-family: var(--fb); font-size: 1rem; background: var(--color-elevated); color: var(--color-text-primary); transition: border-color 0.2s; }
  .form-input:focus { outline: none; border-color: var(--color-accent); }
  .form-input::placeholder { color: var(--color-text-tertiary); }
  .file-upload-area { border: 1px dashed var(--color-border); border-radius: 8px; padding: 1.5rem; text-align: center; position: relative; cursor: pointer; transition: all 0.2s; background: var(--color-bg); }
  .file-input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
  .modal-actions { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem; }
  .modal-actions button {
      padding: 0.6rem 1.25rem; font-family: var(--fb); font-size: 0.95rem;
      font-weight: 500; border-radius: 999px; cursor: pointer; border: none;
  }
  .btn-cancel { background: transparent; color: var(--color-text-secondary); }
  .btn-cancel:hover { color: var(--color-text-primary); }
  .btn-save { background: var(--color-accent); color: white; }
  .btn-save:hover { background: var(--color-accent-hover); }
</style>
</head>
<body>
  <?php $showFilters = false; $hideNewPerfume = true; $hideStoreSwitcher = true; include __DIR__ . '/../partials/app_header.php'; ?>

  <div class="wrap">
    <div class="crumb-bar">Catálogo › <b>Frascos</b></div>
    <div class="titlerow">
      <div>
        <h1 class="h1">Frascos</h1>
      </div>
      <button class="newbtn" onclick="openCreateModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg> Nuevo<span class="newbtn-long"> frasco</span>
      </button>
    </div>
    <p class="h1sub">Datos del frasco (imagen, nombre, estado) aplican a todas las sucursales.</p>

    <div class="toolbar">
      <div class="search">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
        <input type="text" id="searchInput" placeholder="Buscar por nombre o descripción…" onkeyup="filterTable()">
      </div>
      <div class="segs" id="catFilter">
        <button class="on" onclick="filterCat('todas')">Todas</button>
        <button onclick="filterCat('generico')">Genéricos</button>
        <button onclick="filterCat('diseno')">Diseño</button>
      </div>
      <div class="segs" id="stateFilter">
        <button class="on" onclick="filterState('todos')">Todos</button>
        <button onclick="filterState('activos')">Activos</button>
        <button onclick="filterState('inactivos')">Inactivos</button>
      </div>
      <span class="count"><?= count($frascos) ?> frascos · <?= count(array_filter($frascos, fn($f) => $f['activo'])) ?> activos</span>
    </div>

    <div class="card frascos-table">
      <table id="frascosTable">
        <thead>
          <tr>
            <th style="width:64px">Img</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th class="num" style="width:90px">Capacidad</th>
            <th class="center" style="width:90px">Orden</th>
            <th style="width:150px">Estado</th>
            <th style="width:90px"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $currentCat = '';
          foreach($frascos as $f):
            if(($f['controla_stock'] ?? 1) == 0) continue;
            if($f['categoria'] !== $currentCat):
                $currentCat = $f['categoria'];
          ?>
            <tr class="grouprow" data-cat="group"><td colspan="7"><?= $currentCat === 'generico' ? 'Genéricos' : 'Diseño' ?></td></tr>
          <?php endif; ?>

          <?php
            $icon = '<svg viewBox="0 0 40 56"><rect x="16" y="2" width="8" height="7" rx="2" fill="#b88e5d"/><rect x="14" y="9" width="12" height="5" fill="#cdab82"/><rect x="9" y="14" width="22" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>';
            $lower = strtolower($f['nombre']);
            if (str_contains($lower, 'coraz')) {
                $icon = '<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 52C6 40 8 22 20 26C32 22 34 40 20 52Z" fill="#f0c9c0" stroke="#b88e5d" stroke-width="1.2"/></svg>';
            } elseif (str_contains($lower, 'paris') || str_contains($lower, 'parís')) {
                $icon = '<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 10 L27 30 L30 54 L10 54 L13 30 Z" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>';
            } elseif (str_contains($lower, 'camara') || str_contains($lower, 'cámara')) {
                $icon = '<svg viewBox="0 0 40 56"><rect x="16" y="4" width="8" height="6" rx="2" fill="#b88e5d"/><rect x="8" y="12" width="24" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/><circle cx="20" cy="32" r="8" fill="#fff" stroke="#b88e5d" stroke-width="1.2"/></svg>';
            }
          ?>
          <tr class="itemrow <?= $f['activo'] ? '' : 'inactive' ?>" data-cat="<?= htmlspecialchars($f['categoria']) ?>" data-state="<?= $f['activo'] ? '1' : '0' ?>" data-name="<?= htmlspecialchars(strtolower($f['nombre'])) ?>" data-desc="<?= htmlspecialchars(strtolower($f['descripcion'] ?? '')) ?>">
            <td>
              <div class="thumb <?= $f['categoria'] === 'diseno' ? 'dis' : '' ?>">
                <?php if(!empty($f['imagen'])): ?>
                  <img src="<?= htmlspecialchars($f['imagen']) ?>" style="width:100%; height:100%; object-fit:cover; border-radius:10px;" alt="">
                <?php else: ?>
                  <?= $icon ?>
                <?php endif; ?>
              </div>
            </td>
            <td>
                <div class="name"><?= htmlspecialchars($f['nombre']) ?></div>
                <span class="chip <?= $f['categoria'] === 'diseno' ? 'dis' : 'gen' ?>"><?= $f['categoria'] === 'generico' ? 'Genérico' : 'Diseño' ?></span>
            </td>
            <td class="desc"><?= htmlspecialchars($f['descripcion'] ?? '-') ?></td>
            <td class="num"><?= $f['capacidad_ml'] ? $f['capacidad_ml'].' ml' : '-' ?></td>
            <td class="center"><span class="ord"><span class="drag">⋮⋮</span><?= $f['orden'] ?></span></td>
            <td>
              <div class="estado">
                <div class="switch <?= $f['activo'] ? 'on' : '' ?>" onclick="togAPI(this, <?= $f['id'] ?>)"></div>
                <span class="lbl <?= $f['activo'] ? '' : 'off' ?>"><?= $f['activo'] ? 'Activo' : 'Inactivo' ?></span>
              </div>
            </td>
            <td><button class="iconbtn" onclick="openEditModal(<?= htmlspecialchars(json_encode($f)) ?>)">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path opacity="0.4" d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13"/>
                <path d="M16.0399 3.01976L8.15988 10.8998C7.85988 11.1998 7.55988 11.7898 7.49988 12.2198L7.06988 15.2298C6.90988 16.3198 7.67988 17.0798 8.76988 16.9298L11.7799 16.4998C12.1999 16.4398 12.7899 16.1398 13.0999 15.8398L20.9799 7.95976C22.3399 6.59976 22.9799 5.01976 20.9799 3.01976C18.9799 1.01976 17.3999 1.65976 16.0399 3.01976Z"/>
                <path opacity="0.4" d="M14.9102 4.1499C15.5802 6.5399 17.4502 8.4099 19.8502 9.0899"/>
              </svg>
              Editar
            </button></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="frascos-cards">
      <?php
      $currentCat = "";
      foreach($frascos as $f):
          if(($f['controla_stock'] ?? 1) == 0) continue;
          if($f['categoria'] !== $currentCat):
              $currentCat = $f['categoria'];
      ?>
        <div style="font-size: .64rem; letter-spacing: .14em; text-transform: uppercase; color: var(--color-text-secondary); margin: 1rem 0 .55rem;">
          <?= $currentCat === 'generico' ? 'Genéricos' : 'Diseño' ?>
        </div>
      <?php endif; ?>
      <?php
        $icon = '<svg viewBox="0 0 40 56"><rect x="16" y="2" width="8" height="7" rx="2" fill="#b88e5d"/><rect x="14" y="9" width="12" height="5" fill="#cdab82"/><rect x="9" y="14" width="22" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>';
        $lower = strtolower($f['nombre']);
        if (str_contains($lower, 'coraz')) {
            $icon = '<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 52C6 40 8 22 20 26C32 22 34 40 20 52Z" fill="#f0c9c0" stroke="#b88e5d" stroke-width="1.2"/></svg>';
        } elseif (str_contains($lower, 'paris') || str_contains($lower, 'parís')) {
            $icon = '<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 10 L27 30 L30 54 L10 54 L13 30 Z" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>';
        } elseif (str_contains($lower, 'camara') || str_contains($lower, 'cámara')) {
            $icon = '<svg viewBox="0 0 40 56"><rect x="16" y="4" width="8" height="6" rx="2" fill="#b88e5d"/><rect x="8" y="12" width="24" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/><circle cx="20" cy="32" r="8" fill="#fff" stroke="#b88e5d" stroke-width="1.2"/></svg>';
        }
      ?>
      <div class="fcard itemrow <?= $f['activo'] ? '' : 'off' ?>" data-cat="<?= htmlspecialchars($f['categoria']) ?>" data-state="<?= $f['activo'] ? '1' : '0' ?>" data-name="<?= htmlspecialchars(strtolower($f['nombre'])) ?>" data-desc="<?= htmlspecialchars(strtolower($f['descripcion'] ?? '')) ?>">
        <div class="top">
          <div class="thumb <?= $f['categoria'] === 'diseno' ? 'dis' : '' ?>">
            <?php if(!empty($f['imagen'])): ?>
              <img src="<?= htmlspecialchars($f['imagen']) ?>" style="width:100%; height:100%; object-fit:cover; border-radius:10px;" alt="">
            <?php else: ?>
              <?= $icon ?>
            <?php endif; ?>
          </div>
          <div class="info">
            <div class="nm"><?= htmlspecialchars($f['nombre']) ?></div>
            <span class="chip <?= $f['categoria'] === 'diseno' ? 'dis' : 'gen' ?>"><?= $f['categoria'] === 'generico' ? 'Genérico' : 'Diseño' ?></span>
          </div>
          <button class="edit" onclick="openEditModal(<?= htmlspecialchars(json_encode($f)) ?>)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path opacity="0.4" d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13"/>
              <path d="M16.0399 3.01976L8.15988 10.8998C7.85988 11.1998 7.55988 11.7898 7.49988 12.2198L7.06988 15.2298C6.90988 16.3198 7.67988 17.0798 8.76988 16.9298L11.7799 16.4998C12.1999 16.4398 12.7899 16.1398 13.0999 15.8398L20.9799 7.95976C22.3399 6.59976 22.9799 5.01976 20.9799 3.01976C18.9799 1.01976 17.3999 1.65976 16.0399 3.01976Z"/>
              <path opacity="0.4" d="M14.9102 4.1499C15.5802 6.5399 17.4502 8.4099 19.8502 9.0899"/>
            </svg>
            Editar
          </button>
        </div>
        <div class="bottom">
          <div class="meta"><?= $f['capacidad_ml'] ? $f['capacidad_ml'].' ml' : '-' ?> · orden <?= $f['orden'] ?></div>
          <div class="estado">
            <div class="switch <?= $f['activo'] ? 'on' : '' ?>" onclick="togAPI(this, <?= $f['id'] ?>)"></div>
            <span class="lbl <?= $f['activo'] ? '' : 'off' ?>"><?= $f['activo'] ? 'Activo' : 'Inactivo' ?></span>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Modal Edit / Create -->
  <div class="modal-overlay" id="modalEdit">
    <div class="modal">
      <h3 id="modalTitle">Editar Frasco</h3>
      <form id="editForm">
        <input type="hidden" id="e_id">
        
        <div class="form-group">
          <label class="form-label">Nombre</label>
          <input type="text" id="e_nombre" class="form-input" required>
        </div>
        
        <div style="display:flex; gap:1rem;">
            <div class="form-group" style="flex:1">
            <label class="form-label">Categoría</label>
            <select id="e_categoria" class="form-input" required>
                <option value="generico">Genérico</option>
                <option value="diseno">Diseño</option>
            </select>
            </div>
            <div class="form-group" style="flex:1">
            <label class="form-label">Capacidad (ml)</label>
            <input type="number" id="e_capacidad" class="form-input">
            </div>
        </div>
        
        <div class="form-group">
          <label class="form-label">Imagen (opcional)</label>
          <div class="file-upload-area" id="file-upload-area" style="display:flex; flex-direction:column; align-items:center; gap:0.5rem;">
            <input type="file" id="e_file" class="file-input" accept="image/jpeg,image/png,image/webp">
            <img id="e_img_preview" src="" alt="Vista previa" style="display:none; max-width:80px; max-height:80px; border-radius:8px; object-fit:cover; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
            <span style="font-size:0.85rem; color:var(--color-text-secondary);" id="file-name">Click o arrastrar para subir imagen</span>
          </div>
        </div>
        
        <div class="form-group">
          <label class="form-label">Descripción</label>
          <input type="text" id="e_descripcion" class="form-input">
        </div>
        
        <div class="form-group">
          <label class="form-label">Orden</label>
          <input type="number" id="e_orden" class="form-input" value="0">
        </div>
        
        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="document.getElementById('modalEdit').classList.remove('open')">Cancelar</button>
          <button type="submit" class="btn-save" id="btnSave">Guardar</button>
        </div>
      </form>
    </div>
  </div>

<script>
  let currentCatFilter = 'todas';
  let currentStateFilter = 'todos';

  function filterCat(cat) {
      currentCatFilter = cat;
      const btns = document.querySelectorAll('#catFilter button');
      btns.forEach(b => b.classList.remove('on'));
      event.target.classList.add('on');
      applyFilters();
  }

  function filterState(state) {
      currentStateFilter = state;
      const btns = document.querySelectorAll('#stateFilter button');
      btns.forEach(b => b.classList.remove('on'));
      event.target.classList.add('on');
      applyFilters();
  }

  function filterTable() {
      applyFilters();
  }

  function applyFilters() {
      const q = document.getElementById('searchInput').value.toLowerCase();
      const rows = document.querySelectorAll('.itemrow');
      rows.forEach(r => {
          const cat = r.getAttribute('data-cat');
          const state = r.getAttribute('data-state');
          const name = r.getAttribute('data-name');
          const desc = r.getAttribute('data-desc');

          let show = true;
          if (currentCatFilter !== 'todas' && cat !== currentCatFilter) show = false;
          if (currentStateFilter === 'activos' && state !== '1') show = false;
          if (currentStateFilter === 'inactivos' && state !== '0') show = false;
          if (q && !name.includes(q) && !desc.includes(q)) show = false;

          r.style.display = show ? '' : 'none';
      });
  }

  async function togAPI(sw, id) {
      const on = sw.classList.contains('on');
      const nuevoEstado = !on; // toggle
      if(!confirm('¿Deseas ' + (nuevoEstado ? 'activar' : 'desactivar') + ' este frasco?')) return;
      
      try {
          const res = await fetch('/api/frascos/estado', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ id: id, activo: nuevoEstado })
          });
          const data = await res.json();
          if(data.ok) {
              sw.classList.toggle('on', nuevoEstado);
              const lbl = sw.parentElement.querySelector('.lbl');
              lbl.textContent = nuevoEstado ? 'Activo' : 'Inactivo';
              lbl.classList.toggle('off', !nuevoEstado);
              const row = sw.closest('.itemrow');
              row.classList.toggle('inactive', !nuevoEstado);
              row.classList.toggle('off', !nuevoEstado);
              row.setAttribute('data-state', nuevoEstado ? '1' : '0');
              // apply to both desktop and mobile rows
              applyFilters();
          } else {
              alert(data.error);
          }
      } catch(e) {
          alert('Error de conexión');
      }
  }

  document.getElementById('e_file').addEventListener('change', function(e) {
      const file = e.target.files[0];
      const preview = document.getElementById('e_img_preview');
      const nameLabel = document.getElementById('file-name');
      
      if (file) {
          nameLabel.innerText = file.name;
          preview.src = URL.createObjectURL(file);
          preview.style.display = 'block';
      } else {
          nameLabel.innerText = 'Click o arrastrar para subir imagen';
          preview.src = '';
          preview.style.display = 'none';
      }
  });

  function openCreateModal() {
      let maxOrden = 0;
      document.querySelectorAll('.ord').forEach(el => {
          const val = parseInt(el.textContent.replace(/[^0-9]/g, ''), 10);
          if (!isNaN(val) && val > maxOrden) {
              maxOrden = val;
          }
      });
      const nextOrden = maxOrden + 1;

      document.getElementById('modalTitle').innerText = 'Nuevo Frasco';
      document.getElementById('e_id').value = '';
      document.getElementById('e_nombre').value = '';
      document.getElementById('e_categoria').value = 'generico';
      document.getElementById('e_capacidad').value = '';
      document.getElementById('e_descripcion').value = '';
      document.getElementById('e_orden').value = nextOrden;
      document.getElementById('e_file').value = '';
      document.getElementById('file-name').innerText = 'Click o arrastrar para subir imagen';
      document.getElementById('e_img_preview').src = '';
      document.getElementById('e_img_preview').style.display = 'none';
      document.getElementById('modalEdit').classList.add('open');
  }

  function openEditModal(f) {
      document.getElementById('modalTitle').innerText = 'Editar Frasco';
      document.getElementById('e_id').value = f.id;
      document.getElementById('e_nombre').value = f.nombre;
      document.getElementById('e_categoria').value = f.categoria;
      document.getElementById('e_capacidad').value = f.capacidad_ml || '';
      document.getElementById('e_descripcion').value = f.descripcion || '';
      document.getElementById('e_orden').value = f.orden || 0;
      document.getElementById('e_file').value = '';
      document.getElementById('file-name').innerText = 'Click o arrastrar para subir nueva imagen';
      
      const preview = document.getElementById('e_img_preview');
      if (f.imagen) {
          preview.src = f.imagen;
          preview.style.display = 'block';
      } else {
          preview.src = '';
          preview.style.display = 'none';
      }
      
      document.getElementById('modalEdit').classList.add('open');
  }

  document.getElementById('editForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      const btn = document.getElementById('btnSave');
      btn.disabled = true;
      btn.innerText = 'Guardando...';

      let rutaImagen = null;
      const fileInput = document.getElementById('e_file');
      
      if (fileInput.files.length > 0) {
          const fd = new FormData();
          fd.append('image', fileInput.files[0]);
          try {
              const uploadRes = await fetch('/api/frascos/upload-image', { method: 'POST', body: fd });
              const uploadData = await uploadRes.json();
              if(!uploadData.ok) throw new Error(uploadData.error);
              rutaImagen = uploadData.path;
          } catch(err) {
              alert('Error subiendo imagen: ' + err.message);
              btn.disabled = false;
              btn.innerText = 'Guardar';
              return;
          }
      }

      const id = document.getElementById('e_id').value;
      const isCreate = !id;

      const payload = {
          nombre: document.getElementById('e_nombre').value.trim(),
          categoria: document.getElementById('e_categoria').value.trim(),
          capacidad_ml: document.getElementById('e_capacidad').value || null,
          descripcion: document.getElementById('e_descripcion').value.trim(),
          orden: document.getElementById('e_orden').value || 0
      };
      if (rutaImagen) payload.imagen = rutaImagen;
      if (!isCreate) payload.id = id;

      try {
          const endpoint = isCreate ? '/api/frascos' : '/api/frascos/update';
          const res = await fetch(endpoint, {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(payload)
          });
          const data = await res.json();
          if(data.ok) window.location.reload();
          else {
              alert(data.error);
              btn.disabled = false;
              btn.innerText = 'Guardar';
          }
      } catch(err) {
          alert('Error de conexión');
          btn.disabled = false;
          btn.innerText = 'Guardar';
      }
  });
</script>
</body>
</html>
