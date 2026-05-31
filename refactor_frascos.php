<?php
$content = file_get_contents('app/views/frascos/index.php');

function replaceStr(&$text, $search, $replace) {
    if(strpos($text, $search) !== false) {
        $text = str_replace($search, $replace, $text);
    } else {
        echo "Could not find: $search\n";
    }
}

function removeBlock(&$text, $start, $end) {
    $s = strpos($text, $start);
    if ($s === false) return;
    $e = strpos($text, $end, $s);
    if ($e === false) return;
    $text = substr($text, 0, $s) . substr($text, $e + strlen($end));
}

// 1. Remove header CSS entirely (from .header{ down to .btn-new:hover{...} )
removeBlock($content, '  .header{', '}
  .btn-new:hover{background:var(--color-accent-hover)}

');

// 2. Replace Header HTML with include
$headerStart = '  <header class="header">';
$headerEnd = '</header>';
$headerEndPos = strpos($content, $headerEnd);
if($headerEndPos !== false) {
    $headerHtml = substr($content, strpos($content, $headerStart), $headerEndPos + strlen($headerEnd) - strpos($content, $headerStart));
    $content = str_replace($headerHtml, "  <?php \$showFilters = false; \$hideNewPerfume = true; include __DIR__ . '/../partials/app_header.php'; ?>\n", $content);
}

// 3. Add titlerow styling
$cssCards = "
  .crumb-bar { font-size: .72rem; letter-spacing: .14em; text-transform: uppercase; color: var(--color-text-secondary); margin-bottom: 1rem; }
  .crumb-bar b { color: var(--color-accent); font-weight: 500; }
  .titlerow { display: flex; align-items: flex-start; justify-content: space-between; gap: 0.8rem; margin-bottom: 0.2rem; }
  .newbtn { flex: none; display: inline-flex; align-items: center; gap: 0.35rem; background: var(--color-accent); color: var(--color-on-accent); border: none; border-radius: 999px; padding: 0.6rem 1.1rem; font-family: var(--font-body); font-size: 0.88rem; font-weight: 500; cursor: pointer; }
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
  .fcard .edit { flex: none; border: 1px solid var(--color-border); background: var(--color-surface); color: var(--color-text-primary); border-radius: 9px; padding: 0.4rem 0.5rem; font-family: var(--font-body); font-size: 0.76rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem; }
  .fcard .edit svg { width: 13px; height: 13px; color: var(--color-text-primary); }
  .fcard .bottom { display: flex; align-items: center; justify-content: space-between; margin-top: 0.65rem; padding-top: 0.6rem; border-top: 1px solid var(--color-border); }
  .fcard .meta { font-size: 0.78rem; color: var(--color-text-secondary); font-variant-numeric: tabular-nums; }
  
  @media (max-width: 820px) {
    .frascos-table { display: none; }
    .frascos-cards { display: block; }
  }
";
replaceStr($content, '  /* MODAL (Added for Edit) */', $cssCards . "\n  /* MODAL (Added for Edit) */");

// 4. Update title layout
$titleHtmlOld = '    <h1 class="h1">Frascos</h1>
    <p class="h1sub">Datos del frasco (imagen, nombre, estado) aplican a todas las sucursales.</p>';
$titleHtmlNew = '    <div class="crumb-bar">Catálogo › <b>Frascos</b></div>
    <div class="titlerow">
      <div>
        <h1 class="h1">Frascos</h1>
      </div>
      <button class="newbtn" onclick="openCreateModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg> Nuevo frasco
      </button>
    </div>
    <p class="h1sub">Datos del frasco (imagen, nombre, estado) aplican a todas las sucursales.</p>';
replaceStr($content, $titleHtmlOld, $titleHtmlNew);

// 5. Replace card class to table-wrapper and hide it correctly
replaceStr($content, '<div class="card">', '<div class="card frascos-table">');

// 6. Generate the Cards HTML loop
$cardsHtml = '    <div class="frascos-cards">
      <?php 
      $currentCat = "";
      foreach($frascos as $f): 
          if($f[\'categoria\'] !== $currentCat): 
              $currentCat = $f[\'categoria\'];
      ?>
        <div style="font-size: .64rem; letter-spacing: .14em; text-transform: uppercase; color: var(--color-text-secondary); margin: 1rem 0 .55rem;">
          <?= $currentCat === \'generico\' ? \'Genéricos\' : \'Diseño\' ?>
        </div>
      <?php endif; ?>
      <?php
        $icon = \'<svg viewBox="0 0 40 56"><rect x="16" y="2" width="8" height="7" rx="2" fill="#b88e5d"/><rect x="14" y="9" width="12" height="5" fill="#cdab82"/><rect x="9" y="14" width="22" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>\';
        $lower = strtolower($f[\'nombre\']);
        if (str_contains($lower, \'coraz\')) {
            $icon = \'<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 52C6 40 8 22 20 26C32 22 34 40 20 52Z" fill="#f0c9c0" stroke="#b88e5d" stroke-width="1.2"/></svg>\';
        } elseif (str_contains($lower, \'paris\') || str_contains($lower, \'parís\')) {
            $icon = \'<svg viewBox="0 0 40 56"><rect x="17" y="2" width="6" height="6" rx="2" fill="#b88e5d"/><path d="M20 10 L27 30 L30 54 L10 54 L13 30 Z" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/></svg>\';
        } elseif (str_contains($lower, \'camara\') || str_contains($lower, \'cámara\')) {
            $icon = \'<svg viewBox="0 0 40 56"><rect x="16" y="4" width="8" height="6" rx="2" fill="#b88e5d"/><rect x="8" y="12" width="24" height="40" rx="6" fill="#e7d6bd" stroke="#b88e5d" stroke-width="1.2"/><circle cx="20" cy="32" r="8" fill="#fff" stroke="#b88e5d" stroke-width="1.2"/></svg>\';
        }
      ?>
      <div class="fcard itemrow <?= $f[\'activo\'] ? \'\' : \'off\' ?>" data-cat="<?= htmlspecialchars($f[\'categoria\']) ?>" data-state="<?= $f[\'activo\'] ? \'1\' : \'0\' ?>" data-name="<?= htmlspecialchars(strtolower($f[\'nombre\'])) ?>" data-desc="<?= htmlspecialchars(strtolower($f[\'descripcion\'] ?? \'\')) ?>">
        <div class="top">
          <div class="thumb <?= $f[\'categoria\'] === \'diseno\' ? \'dis\' : \'\' ?>">
            <?php if(!empty($f[\'imagen\'])): ?>
              <img src="<?= htmlspecialchars($f[\'imagen\']) ?>" style="width:100%; height:100%; object-fit:cover; border-radius:10px;" alt="">
            <?php else: ?>
              <?= $icon ?>
            <?php endif; ?>
          </div>
          <div class="info">
            <div class="nm"><?= htmlspecialchars($f[\'nombre\']) ?></div>
            <span class="chip <?= $f[\'categoria\'] === \'diseno\' ? \'dis\' : \'gen\' ?>"><?= $f[\'categoria\'] === \'generico\' ? \'Genérico\' : \'Diseño\' ?></span>
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
          <div class="meta"><?= $f[\'capacidad_ml\'] ? $f[\'capacidad_ml\'].\' ml\' : \'-\' ?> · Ord: <?= $f[\'orden\'] ?></div>
          <div class="estado">
            <div class="switch <?= $f[\'activo\'] ? \'on\' : \'\' ?>" onclick="togAPI(this, <?= $f[\'id\'] ?>)"></div>
            <span class="lbl <?= $f[\'activo\'] ? \'\' : \'off\' ?>"><?= $f[\'activo\'] ? \'Activo\' : \'Inactivo\' ?></span>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>';

replaceStr($content, '    </div>
  </div>

  <!-- Modal Edit / Create -->', '    </div>
' . $cardsHtml . '
  </div>

  <!-- Modal Edit / Create -->');

file_put_contents('app/views/frascos/index.php', $content);
echo "Frascos updated!\n";
