<?php
use App\Core\Auth;
$user = Auth::user();
$isAdmin = $user['rol'] === 'admin';
$activeTab = 'reporte';
ob_start();
?>
<style>
#rep .rep-header {
  padding: 1.1rem 0 .9rem;
  border-bottom: 1px solid var(--color-border);
  margin-bottom: 1rem;
}
#rep .rep-label {
  font-size: 0.62rem;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  color: var(--color-accent);
  font-weight: 500;
  margin-bottom: 0.4rem;
}
#rep .rep-fecha {
  font-family: var(--fd);
  font-size: 1.3rem;
  font-weight: 500;
  color: var(--color-text-primary);
  line-height: 1.2;
}
.date-row{display:flex;gap:.4rem;align-items:center;flex-wrap:wrap;margin-bottom:.85rem}
.date-row input[type=date]{flex:1;min-width:110px;background:var(--color-surface);border:1px solid var(--color-border);border-radius:10px;color:var(--color-text-primary);padding:.5rem .7rem;font-family:var(--font-body);font-size:.85rem;outline:none}
.date-row input[type=date]:focus{border-color:var(--color-accent)}
.date-row button{background:var(--color-accent);color:var(--color-on-accent,#fff);border:none;border-radius:10px;padding:.5rem 1rem;font-family:var(--font-body);font-size:.85rem;cursor:pointer;white-space:nowrap}
.por-pago-row{font-size:.78rem;color:var(--color-text-secondary);margin-bottom:.9rem;min-height:1.1rem}
</style>
<div id="rep">
  <div class="body">
    <div class="rep-header">
      <div class="rep-label">Reporte</div>
      <div class="rep-fecha" id="lblFechaMovil">—</div>
    </div>

    <div class="date-row">
      <input type="date" id="rep-desde-m" aria-label="Desde">
      <span style="color:var(--color-text-secondary);font-size:.8rem">—</span>
      <input type="date" id="rep-hasta-m" aria-label="Hasta">
      <button onclick="loadReporteMovil()">Aplicar</button>
    </div>

    <div class="stats">
      <div class="stat a"><div class="num" id="statFrascos">0</div><div class="lbl">Frascos</div></div>
      <div class="stat"><div class="num" id="statRellenos">0</div><div class="lbl">Rellenos</div></div>
      <div class="stat"><div class="num" id="statVentas">0</div><div class="lbl">Ventas</div></div>
      <div class="stat"><div class="num" id="statIngresos">0</div><div class="lbl">S/ ingresos</div></div>
    </div>

    <div class="por-pago-row" id="porPagoMovil"></div>

    <div class="ct" style="margin-bottom:.6rem">Frascos más vendidos</div>
    <div id="topFrascosMovil"></div>

    <div class="ct" style="margin:1rem 0 .6rem">Perfumes más vendidos</div>
    <div id="topPerfumesMovil"></div>
  </div>
</div>

<script>
const PAGO_LABELS = {efectivo:'Efectivo', yape_plin:'Yape/Plin', tarjeta:'Tarjeta', otro:'Otro'};
function pagoLabel(m) { return PAGO_LABELS[m] || m; }

function localDateStr(d) {
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}
function todayStr() { return localDateStr(new Date()); }

(function initDatesMovil() {
  const hoy = todayStr();
  document.getElementById('rep-desde-m').value = hoy;
  document.getElementById('rep-hasta-m').value = hoy;
})();

async function loadReporteMovil() {
    const desde = document.getElementById('rep-desde-m').value || todayStr();
    const hasta = document.getElementById('rep-hasta-m').value || todayStr();

    const fmtDate = s => {
      const d = new Date(s + 'T00:00:00');
      return d.toLocaleDateString('es-PE', {day:'numeric', month:'short', year:'numeric'}).replace('.','');
    };
    document.getElementById('lblFechaMovil').textContent =
      desde === hasta ? fmtDate(desde) : `${fmtDate(desde)} – ${fmtDate(hasta)}`;

    const res = await fetch('/api/ventas/reporte', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ sucursal_id: getSucursalId(), desde, hasta })
    });
    const data = await res.json();
    if (data.error) return;

    document.getElementById('statFrascos').innerText  = data.resumen.frascos;
    document.getElementById('statRellenos').innerText = data.resumen.rellenos ?? 0;
    document.getElementById('statVentas').innerText   = data.resumen.ventas;
    document.getElementById('statIngresos').innerText = (data.resumen.ingresos/1000 >= 1)
      ? (data.resumen.ingresos/1000).toFixed(1)+'k'
      : data.resumen.ingresos.toFixed(0);

    const pagoTxt = (data.porPago || [])
      .filter(p => parseFloat(p.monto) > 0)
      .map(p => `${pagoLabel(p.metodo_pago)}: S/ ${parseFloat(p.monto).toFixed(0)}`)
      .join(' · ');
    document.getElementById('porPagoMovil').textContent = pagoTxt || '';

    document.getElementById('topFrascosMovil').innerHTML = data.topFrascos.map(f =>
        `<div class="srow"><span class="sinfo"><span class="ml">${f.nombre}</span></span><div class="qty ok"><div class="num">${f.cantidad}</div></div></div>`
    ).join('') || '<div class="sd">Sin datos</div>';

    document.getElementById('topPerfumesMovil').innerHTML = data.topPerfumes.map(p =>
        `<div class="srow"><span class="sinfo"><span class="ml" style="font-weight:400">${p.nombre}</span></span><div class="qty ok"><div class="num">${p.cantidad}</div></div></div>`
    ).join('') || '<div class="sd">Sin datos</div>';
}
loadReporteMovil();
</script>
<?php
$content = ob_get_clean();

// Desktop Content (Admin)
if ($isAdmin) {
    ob_start();
    ?>
    <h1 class="title">Reporte</h1>

    <div style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;margin-bottom:1.2rem">
      <input type="date" id="rep-desde-d" style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:8px;color:var(--color-text-primary);padding:.45rem .7rem;font-family:var(--font-body);font-size:.9rem;outline:none">
      <span style="color:var(--color-text-secondary)">—</span>
      <input type="date" id="rep-hasta-d" style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:8px;color:var(--color-text-primary);padding:.45rem .7rem;font-family:var(--font-body);font-size:.9rem;outline:none">
      <button onclick="loadReporteDesktop()" style="background:var(--color-accent);color:var(--color-on-accent,#fff);border:none;border-radius:8px;padding:.45rem 1.1rem;font-family:var(--font-body);font-size:.9rem;cursor:pointer">Aplicar</button>
      <button onclick="setRango(7)" style="background:transparent;border:1px solid var(--color-border);border-radius:8px;padding:.45rem .8rem;font-family:var(--font-body);font-size:.85rem;cursor:pointer;color:var(--color-text-secondary)">Últimos 7 días</button>
      <button onclick="setEsteMes()" style="background:transparent;border:1px solid var(--color-border);border-radius:8px;padding:.45rem .8rem;font-family:var(--font-body);font-size:.85rem;cursor:pointer;color:var(--color-text-secondary)">Este mes</button>
      <p class="csub" id="lblFechaDesktop" style="margin:0;flex-basis:100%;font-size:.85rem"></p>
    </div>

    <div class="stats">
      <div class="stat a"><div class="num" id="dStatFrascos">0</div><div class="lbl">Frascos vendidos</div></div>
      <div class="stat"><div class="num" id="dStatVentas">0</div><div class="lbl">Ventas</div></div>
      <div class="stat"><div class="num" id="dStatIngresos">S/ 0</div><div class="lbl">Ingresos</div></div>
      <div class="stat"><div class="num" id="dStatStock">-</div><div class="lbl">Stock Actual</div></div>
    </div>

    <p id="dPorPago" style="font-size:.85rem;color:var(--color-text-secondary);margin-bottom:1.2rem;min-height:1.2rem"></p>

    <div class="cols">
      <div class="card">
        <div class="chead"><h2>Frascos más vendidos</h2></div>
        <div class="cbody" id="dTopFrascos"></div>
      </div>

      <div class="card">
        <div class="chead"><h2>Perfumes más vendidos</h2></div>
        <div class="cbody" id="dTopPerfumes"></div>
      </div>

      <div class="card full">
        <div class="chead"><h2>Ventas del periodo</h2></div>
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
    function setRango(dias) {
      const hasta = new Date();
      const desde = new Date();
      desde.setDate(hasta.getDate() - (dias - 1));
      document.getElementById('rep-desde-d').value = localDateStr(desde);
      document.getElementById('rep-hasta-d').value = localDateStr(hasta);
      loadReporteDesktop();
    }
    function setEsteMes() {
      const hoy = new Date();
      const desde = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
      document.getElementById('rep-desde-d').value = localDateStr(desde);
      document.getElementById('rep-hasta-d').value = localDateStr(hoy);
      loadReporteDesktop();
    }

    (function initDatesDesktop() {
      const hoy = todayStr();
      document.getElementById('rep-desde-d').value = hoy;
      document.getElementById('rep-hasta-d').value = hoy;
    })();

    async function loadReporteDesktop() {
        const desde = document.getElementById('rep-desde-d').value || todayStr();
        const hasta = document.getElementById('rep-hasta-d').value || todayStr();

        const fmtFull = s => new Date(s + 'T00:00:00').toLocaleDateString('es-PE',
          {weekday:'long', year:'numeric', month:'long', day:'numeric'});
        document.getElementById('lblFechaDesktop').textContent =
          desde === hasta ? fmtFull(desde) : `${desde} — ${hasta}`;

        const res = await fetch('/api/ventas/reporte', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ sucursal_id: getSucursalId(), desde, hasta })
        });
        const data = await res.json();
        if (data.error) return;

        document.getElementById('dStatFrascos').innerText = data.resumen.frascos;
        document.getElementById('dStatVentas').innerText  = data.resumen.ventas;
        document.getElementById('dStatIngresos').innerText = 'S/ ' + parseFloat(data.resumen.ingresos).toFixed(0);

        const pagoTxt = (data.porPago || [])
          .filter(p => parseFloat(p.monto) > 0)
          .map(p => `${pagoLabel(p.metodo_pago)}: S/ ${parseFloat(p.monto).toFixed(0)}`)
          .join(' · ');
        document.getElementById('dPorPago').textContent = pagoTxt || '';

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

        document.getElementById('dVentasTabla').innerHTML = data.ventas.map(v => {
            let hora = v.fecha.split(' ')[1].substring(0, 5);
            return `
            <tr>
                <td>${hora}</td>
                <td>${v.vendedora}</td>
                <td style="max-width:300px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="${v.detalle}">${v.detalle || '-'}</td>
                <td><span class="badge ${v.metodo_pago || 'otro'}">${pagoLabel(v.metodo_pago)}</span></td>
                <td class="num">S/ ${parseFloat(v.total).toFixed(2)}</td>
            </tr>`;
        }).join('') || '<tr><td colspan="5" style="text-align:center">Sin ventas</td></tr>';

        const resStock = await fetch('/api/stock', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({sucursal_id: getSucursalId()})
        });
        const stockData = await resStock.json();
        document.getElementById('dStatStock').innerText = stockData.reduce((acc, curr) => acc + curr.cantidad, 0);
    }
    loadReporteDesktop();
    </script>
    <?php
    $desktopContent = ob_get_clean();
}

require APP_ROOT . '/app/views/tienda/layout.php';
