<?php
$content = file_get_contents('app/views/perfumes/index.php');

function getBlock($text, $start, $end) {
    $s = strpos($text, $start);
    if ($s === false) return '';
    $e = strpos($text, $end, $s);
    if ($e === false) return '';
    return substr($text, $s, $e - $s + strlen($end));
}

$css_header = getBlock($content, '    .header {', '    .btn-new:hover {');
$css_header = substr($css_header, 0, strpos($css_header, '    /* Main Layout */'));

preg_match('/(\s*\.user-chip\{.*?\})/', $content, $m1);
preg_match('/(\s*\.user-av\{.*?\})/', $content, $m2);
preg_match('/(\s*\.btn-logout\{.*?\})/', $content, $m3);
$css_user = ($m1[1]??'').($m2[1]??'').($m3[1]??'');

$css_media = getBlock($content, '    @media (max-width: 768px) {', '      .btn-logout {
        display: none;
      }
    }');

$css_drawer = getBlock($content, '    .nav-drawer{', '@media(min-width:861px){ .nav-drawer,#btn-menu{display:none !important;} }');

$css = "<style>\n" . $css_header . $css_user . "\n" . $css_media . "\n" . $css_drawer . "\n</style>\n";

$html_header = getBlock($content, '  <!-- Header -->', '  </header>');
$html_overlay = getBlock($content, '  <!-- Overlay -->', '</div>');
$html_drawer = getBlock($content, '    <aside class="nav-drawer"', '    </aside>');

$html = $html_header . "\n" . $html_overlay . "\n" . $html_drawer . "\n";

$js = "<script>
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
        ? '<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" width=\"18\" height=\"18\"><circle cx=\"12\" cy=\"12\" r=\"4\"/><path d=\"M12 2v2M12 20v2M2 12h2M20 12h2M5 5l1.4 1.4M17.6 17.6L19 19M19 5l-1.4 1.4M6.4 17.6L5 19\"/></svg>'
        : '<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" width=\"18\" height=\"18\"><path d=\"M21 12.8A9 9 0 1111.2 3 7 7 0 0021 12.8z\"/></svg>');
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
</script>";

file_put_contents('app/views/partials/app_header.php', $css . $html . $js);
echo "app_header.php created successfully.\n";
