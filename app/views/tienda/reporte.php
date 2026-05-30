<?php
use App\Core\Auth;
$user = Auth::user();
$isAdmin = $user['rol'] === 'admin';
$activeTab = 'reporte';
ob_start();
?>
<div id="rep">
  <div class="body">
    <div class="h">Reporte del día</div>
    <p class="sub" id="lblFechaMovil">Cargando...</p>

    <div class="stats">
      <div class="stat a"><div class="num" id="statFrascos">0</div><div class="lbl">Frascos</div></div>
      <div class="stat"><div class="num" id="statVentas">0</div><div class="lbl">Ventas</div></div>
      <div class="stat"><div class="num" id="statIngresos">0</div><div class="lbl">S/ ingresos</div></div>
    </div>
    
    <div class="ct" style="margin-bottom:.6rem">Frascos más vendidos</div>
    <div id="topFrascosMovil"></div>

    <div class="ct" style="margin:1rem 0 .6rem">Perfumes más vendidos</div>
    <div id="topPerfumesMovil"></div>
  </div>
</div>

<script>
async function loadReporteMovil() {
    let hoyStr = new Date().toISOString().split('T')[0];
    document.getElementById('lblFechaMovil').innerText = new Date().toLocaleDateString('es-PE', {weekday:'long', year:'numeric', month:'long', day:'numeric'});

    const res = await fetch('/api/ventas/reporte', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            sucursal_id: getSucursalId(),
            desde: hoyStr,
            hasta: hoyStr
        })
    });
    const data = await res.json();
    if(data.error) return;

    document.getElementById('statFrascos').innerText = data.resumen.frascos;
    document.getElementById('statVentas').innerText = data.resumen.ventas;
    document.getElementById('statIngresos').innerText = (data.resumen.ingresos/1000 >= 1) ? (data.resumen.ingresos/1000).toFixed(1)+'k' : data.resumen.ingresos.toFixed(0);

    document.getElementById('topFrascosMovil').innerHTML = data.topFrascos.map(f => `
        <div class="srow"><span class="sinfo"><span class="ml">${f.nombre}</span></span><span class="q">${f.cantidad}</span></div>
    `).join('') || '<div class="sd">Sin datos</div>';

    document.getElementById('topPerfumesMovil').innerHTML = data.topPerfumes.map(p => `
        <div class="srow"><span class="sinfo"><span class="ml" style="font-weight:400">${p.nombre}</span></span><span class="q">${p.cantidad}</span></div>
    `).join('') || '<div class="sd">Sin datos</div>';
}
loadReporteMovil();
</script>
<?php
$content = ob_get_clean();

// Desktop Content (Admin)
if ($isAdmin) {
    ob_start();
    ?>
    <h1 class="title">Dashboard — Resumen</h1>
    <p class="csub" id="lblFechaDesktop">Cargando...</p>

    <div class="stats">
      <div class="stat a"><div class="num" id="dStatFrascos">0</div><div class="lbl">Frascos vendidos hoy</div></div>
      <div class="stat"><div class="num" id="dStatVentas">0</div><div class="lbl">Ventas hoy</div></div>
      <div class="stat"><div class="num" id="dStatIngresos">S/ 0</div><div class="lbl">Ingresos hoy</div></div>
      <div class="stat"><div class="num" id="dStatStock">-</div><div class="lbl">Stock Actual</div></div>
    </div>

    <div class="cols">
      <!-- RANKINGS -->
      <div class="card">
        <div class="chead"><h2>Frascos más vendidos hoy</h2></div>
        <div class="cbody" id="dTopFrascos"></div>
      </div>

      <div class="card">
        <div class="chead"><h2>Perfumes más vendidos hoy</h2></div>
        <div class="cbody" id="dTopPerfumes"></div>
      </div>

      <!-- VENTAS RECIENTES -->
      <div class="card full">
        <div class="chead"><h2>Ventas de hoy</h2></div>
        <div class="cbody">
          <table>
            <thead><tr><th>Hora</th><th>Vendedora</th><th>Detalle</th><th>Pago</th><th style="text-align:right">Total</th></tr></thead>
            <tbody id="dVentasTabla">
              <tr><td colspan="5" style="text-align:center">Cargando...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <script>
    async function loadReporteDesktop() {
        let hoyStr = new Date().toISOString().split('T')[0];
        document.getElementById('lblFechaDesktop').innerText = new Date().toLocaleDateString('es-PE', {weekday:'long', year:'numeric', month:'long', day:'numeric'});

        const res = await fetch('/api/ventas/reporte', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                sucursal_id: getSucursalId(),
                desde: hoyStr,
                hasta: hoyStr
            })
        });
        const data = await res.json();
        if(data.error) return;

        document.getElementById('dStatFrascos').innerText = data.resumen.frascos;
        document.getElementById('dStatVentas').innerText = data.resumen.ventas;
        document.getElementById('dStatIngresos').innerText = 'S/ ' + parseFloat(data.resumen.ingresos).toFixed(0);

        // Ranking Frascos con barras
        let maxF = Math.max(...data.topFrascos.map(x => x.cantidad), 1);
        document.getElementById('dTopFrascos').innerHTML = data.topFrascos.map(f => `
            <div class="rank">
                <div class="lc">
                    <span>${f.nombre}</span>
                    <div class="barwrap"><div class="bar" style="width:${(f.cantidad/maxF)*100}%"></div></div>
                </div>
                <span class="num">${f.cantidad}</span>
            </div>
        `).join('') || '<div style="color:var(--muted)">Sin datos</div>';

        // Ranking Perfumes
        let maxP = Math.max(...data.topPerfumes.map(x => x.cantidad), 1);
        document.getElementById('dTopPerfumes').innerHTML = data.topPerfumes.map(p => `
            <div class="rank">
                <div class="lc">
                    <span>${p.nombre}</span>
                    <div class="barwrap"><div class="bar" style="width:${(p.cantidad/maxP)*100}%"></div></div>
                </div>
                <span class="num">${p.cantidad}</span>
            </div>
        `).join('') || '<div style="color:var(--muted)">Sin datos</div>';

        // Ventas tabla
        document.getElementById('dVentasTabla').innerHTML = data.ventas.map(v => {
            let hora = v.fecha.split(' ')[1].substring(0, 5);
            return `
            <tr>
                <td>${hora}</td>
                <td>${v.vendedora}</td>
                <td style="max-width:300px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="${v.detalle}">${v.detalle || '-'}</td>
                <td>${v.metodo_pago}</td>
                <td class="num">S/ ${parseFloat(v.total).toFixed(2)}</td>
            </tr>`;
        }).join('') || '<tr><td colspan="5" style="text-align:center">Sin ventas</td></tr>';

        // Extra: load total stock summary
        const resStock = await fetch('/api/stock', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({sucursal_id: getSucursalId()})
        });
        const stockData = await resStock.json();
        let totalStock = stockData.reduce((acc, curr) => acc + curr.cantidad, 0);
        document.getElementById('dStatStock').innerText = totalStock;
    }
    loadReporteDesktop();
    </script>
    <?php
    $desktopContent = ob_get_clean();
}

require APP_ROOT . '/app/views/tienda/layout.php';
