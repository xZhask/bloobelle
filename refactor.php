<?php
$content = file_get_contents('app/views/perfumes/index.php');

function removeBlock(&$text, $start, $end) {
    $s = strpos($text, $start);
    if ($s === false) { echo "Start not found: $start\n"; return; }
    $e = strpos($text, $end, $s);
    if ($e === false) { echo "End not found: $end\n"; return; }
    $text = substr($text, 0, $s) . substr($text, $e + strlen($end));
}

// Remove Header CSS
removeBlock($content, '    .header {', '    .btn-new:hover {
      background: var(--color-accent-hover);
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }
');

$content = preg_replace('/\s*\.user-chip\{.*?\}/', '', $content);
$content = preg_replace('/\s*\.user-av\{.*?\}/', '', $content);
$content = preg_replace('/\s*\.btn-logout\{.*?\}/', '', $content);

// In media query max-width 768px: remove .btn-filters-mobile, .btn-new, .nav-link, .user-chip, .btn-logout display: none
$content = preg_replace('/      \.btn-filters-mobile \{[^}]+?\}\s*/s', '', $content);
$content = preg_replace('/      \.btn-new,\s*\.nav-link,\s*\.user-chip,\s*\.btn-logout\s*\{[^}]+?\}\s*/s', '', $content);
// Also remove .header-content and .logo inside media query
$content = preg_replace('/      \.header-content\s*\{[^}]+?\}\s*/s', '', $content);
$content = preg_replace('/      \.logo\s*\{[^}]+?\}\s*/s', '', $content);

// Remove Nav Drawer CSS
removeBlock($content, '    .nav-drawer{', '@media(min-width:861px){ .nav-drawer,#btn-menu{display:none !important;} }
');

// Replace HTML
$headerHtmlStart = '  <!-- Header -->';
$drawerHtmlEnd = '</aside>';
$drawerPosEnd = strpos($content, $drawerHtmlEnd, strpos($content, '<aside class="nav-drawer"'));
if ($drawerPosEnd !== false) {
    $drawerPosEnd += strlen($drawerHtmlEnd);
    $htmlToReplace = substr($content, strpos($content, $headerHtmlStart), $drawerPosEnd - strpos($content, $headerHtmlStart));
    $content = str_replace($htmlToReplace, "  <?php \$showFilters = true; include __DIR__ . '/../partials/app_header.php'; ?>\n", $content);
}

// Remove JS
removeBlock($content, "  window.closePanels = () => {", "  });\n"); // Removes inside DOMContentLoaded
// Remove theme JS entirely
removeBlock($content, "<script>\n(function(){\n  var root=document.documentElement;", "})();\n</script>\n");

file_put_contents('app/views/perfumes/index.php', $content);
echo "Perfumes index refactored!\n";
