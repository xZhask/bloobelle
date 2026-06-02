<?php
use App\Core\Auth;
$user    = Auth::user();
$isAdmin = $user['rol'] === 'admin';
$activeTab = 'reporte';

// ── MOBILE CONTENT ($content) ─────────────────────────────────────────────
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
.rep-section-head{display:flex;align-items:center;justify-content:space-between;margin:1rem 0 .6rem}
.rep-section-head .ct{margin:0}
.btn-gasto-m{background:var(--color-accent);color:var(--color-on-accent,#fff);border:none;border-radius:8px;padding:.35rem .75rem;font-family:var(--font-body);font-size:.78rem;cursor:pointer;white-space:nowrap}
/* Tarjeta Resumen del día */
.rd-card{background:var(--color-surface);border:1px solid var(--color-border);border-radius:16px;padding:1rem 1.1rem;box-shadow:var(--shadow-sm)}
.rd-heading{font-size:.6rem;letter-spacing:.15em;text-transform:uppercase;color:var(--color-text-secondary);margin-bottom:.8rem}
.rd-mini-row{display:flex;gap:.6rem;margin-bottom:.75rem;justify-content:space-between}
.rd-mini{display:flex;align-items:center;justify-content:center;gap:.55rem;border-radius:10px;padding:.55rem .8rem;flex:1}
.rd-ing{background:var(--color-pos-bg)}
.rd-gas{background:var(--color-neg-bg)}
.rd-mini-ico{font-size:1.1rem;font-weight:700;line-height:1}
.rd-ing .rd-mini-ico,.rd-ing .rd-mini-val{color:var(--color-pos-text)}
.rd-gas .rd-mini-ico,.rd-gas .rd-mini-val{color:var(--color-neg-text)}
.rd-mini-text{display:flex;flex-direction:column}
.rd-mini-lbl{font-size:.6rem;letter-spacing:.08em;text-transform:uppercase;color:var(--color-text-secondary);margin-bottom:.18rem}
.rd-mini-val{font-family:var(--fd);font-size:1rem;line-height:1}
@media(min-width:861px){.card.full .rd-mini-row{justify-content:center;gap:2rem}.card.full .rd-mini-val{font-size:1.15rem}}
.rd-sep{border-top:1px solid var(--color-border);margin:.1rem 0 .75rem}
.rd-neto-row{display:flex;align-items:center;justify-content:space-between;gap:.5rem}
.rd-neto-lbl{font-size:.62rem;letter-spacing:.1em;text-transform:uppercase;color:var(--color-text-secondary);margin-bottom:.2rem}
.rd-neto-val{font-family:var(--fd);font-size:1.6rem;font-weight:500;line-height:1}
.rd-neto-val.rd-pos{color:var(--color-pos-text)}
.rd-neto-val.rd-neg{color:var(--color-neg-text)}
.rd-chip{font-size:.67rem;padding:.22rem .65rem;border-radius:999px;font-weight:500;white-space:nowrap}
.rd-chip-pos{background:var(--color-pos-bg);color:var(--color-pos-text)}
.rd-chip-neg{background:var(--color-neg-bg);color:var(--color-neg-text)}
.card.full .rd-neto-val{font-size:2rem}
</style>
<div id="rep">
  <div class="body">
    <div class="rep-header">
      <div class="rep-label">Reporte</div>
      <div class="rep-fecha" id="lblFechaMovil">—</div>
    </div>

    <?php if ($isAdmin): ?>
    <div class="date-row">
      <input type="date" id="rep-desde-m" aria-label="Desde">
      <span style="color:var(--color-text-secondary);font-size:.8rem">—</span>
      <input type="date" id="rep-hasta-m" aria-label="Hasta">
      <button onclick="loadReporteMovil()">Aplicar</button>
    </div>
    <?php endif; ?>

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

    <div class="ct" style="margin:1rem 0 .6rem">Ventas del día</div>
    <div id="ventasMovilList"></div>

    <div class="rep-section-head">
      <span class="ct">Gastos</span>
      <button class="btn-gasto-m" onclick="openGastoModal()">+ Registrar gasto</button>
    </div>
    <div id="gastosMovilList"></div>
    <div class="por-pago-row" id="gastosTotalMovil"></div>
    <div class="rd-card" id="netoMovilCard" style="margin-top:.75rem;display:none"></div>
  </div>
</div>

<script>
const PAGO_LABELS = {efectivo:'Efectivo', yape_plin:'Yape/Plin', tarjeta:'Tarjeta', otro:'Otro'};
function pagoLabel(m) { return PAGO_LABELS[m] || m; }

function localDateStr(d) {
    const year  = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day   = String(d.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}
function todayStr() { return localDateStr(new Date()); }

(function initDatesMovil() {
  const hoy = todayStr();
  const d = document.getElementById('rep-desde-m');
  const h = document.getElementById('rep-hasta-m');
  if (d) d.value = hoy;
  if (h) h.value = hoy;
})();

async function loadReporteMovil() {
    const desde = document.getElementById('rep-desde-m')?.value || todayStr();
    const hasta = document.getElementById('rep-hasta-m')?.value || todayStr();

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
    window._ingresosMovil = data.resumen.ingresos;
    document.getElementById('statIngresos').innerText = (data.resumen.ingresos / 1000 >= 1)
      ? (data.resumen.ingresos / 1000).toFixed(1) + 'k'
      : data.resumen.ingresos.toFixed(0);

    const pagoTxt = (data.porPago || [])
      .filter(p => parseFloat(p.monto) > 0)
      .map(p => `${pagoLabel(p.metodo_pago)}: S/ ${parseFloat(p.monto).toFixed(0)}`)
      .join(' · ');
    document.getElementById('porPagoMovil').textContent = pagoTxt || '';

    document.getElementById('topFrascosMovil').innerHTML = (data.topFrascos || []).map(f =>
        `<div class="srow"><span class="sinfo"><span class="ml">${f.nombre}</span></span><div class="qty ok"><div class="num">${f.cantidad}</div></div></div>`
    ).join('') || '<div class="sd">Sin datos</div>';

    document.getElementById('topPerfumesMovil').innerHTML = (data.topPerfumes || []).map(p =>
        `<div class="srow"><span class="sinfo"><span class="ml" style="font-weight:400">${p.nombre}</span></span><div class="qty ok"><div class="num">${p.cantidad}</div></div></div>`
    ).join('') || '<div class="sd">Sin datos</div>';

    document.getElementById('ventasMovilList').innerHTML = (data.ventas || []).map(v => {
        const hora    = v.fecha.split(' ')[1]?.substring(0, 5) || '';
        const detalle = v.detalle || '—';
        const total   = 'S/ ' + parseFloat(v.total).toFixed(2);
        return `<div class="srow"><span class="sinfo"><span class="ml">${hora} · ${detalle}</span></span><div style="display:flex;flex-direction:column;align-items:flex-end;gap:.28rem"><div class="qty ok" style="min-width:auto;padding:.3rem .55rem"><div class="num" style="font-size:1rem">${total}</div></div><span class="badge ${v.metodo_pago||'otro'}">${pagoLabel(v.metodo_pago)}</span></div></div>`;
    }).join('') || '<div class="sd">Sin ventas</div>';

    if (window.loadGastos) loadGastos();
}
loadReporteMovil();
</script>
<?php
$content = ob_get_clean();

// ── DESKTOP CONTENT ($desktopContent) ─────────────────────────────────────
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
      <button onclick="openGastoModal()" style="background:var(--color-accent);color:var(--color-on-accent,#fff);border:none;border-radius:8px;padding:.45rem 1rem;font-family:var(--font-body);font-size:.85rem;cursor:pointer;margin-left:.4rem">+ Registrar gasto</button>
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

      <div class="card full">
        <div class="chead"><h2>Gastos del periodo</h2></div>
        <div class="cbody">
          <table>
            <thead><tr><th>Hora</th><th>Registrado por</th><th>Descripción</th><th style="text-align:right">Monto</th></tr></thead>
            <tbody id="gastosDesktopTabla">
              <tr><td colspan="4" style="text-align:center">Cargando...</td></tr>
            </tbody>
          </table>
          <div id="gastosTotalDesktop" style="text-align:right;margin-top:.6rem;font-size:.88rem;color:var(--color-text-secondary)"></div>
        </div>
      </div>

      <div class="card full" id="netoDesktopCard" style="padding:1.1rem 1.3rem;display:none"></div>
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
      const hoy   = new Date();
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

        document.getElementById('dStatFrascos').innerText  = data.resumen.frascos;
        document.getElementById('dStatVentas').innerText   = data.resumen.ventas;
        window._ingresosDesktop = parseFloat(data.resumen.ingresos);
        document.getElementById('dStatIngresos').innerText = 'S/ ' + window._ingresosDesktop.toFixed(0);

        const pagoTxt = (data.porPago || [])
          .filter(p => parseFloat(p.monto) > 0)
          .map(p => `${pagoLabel(p.metodo_pago)}: S/ ${parseFloat(p.monto).toFixed(0)}`)
          .join(' · ');
        document.getElementById('dPorPago').textContent = pagoTxt || '';

        let maxF = Math.max(...(data.topFrascos || []).map(x => x.cantidad), 1);
        document.getElementById('dTopFrascos').innerHTML = (data.topFrascos || []).map(f => `
            <div class="rank">
                <div class="lc">
                    <span>${f.nombre}</span>
                    <div class="barwrap"><div class="bar" style="width:${(f.cantidad / maxF) * 100}%"></div></div>
                </div>
                <span class="num">${f.cantidad}</span>
            </div>
        `).join('') || '<div style="color:var(--muted)">Sin datos</div>';

        let maxP = Math.max(...(data.topPerfumes || []).map(x => x.cantidad), 1);
        document.getElementById('dTopPerfumes').innerHTML = (data.topPerfumes || []).map(p => `
            <div class="rank">
                <div class="lc">
                    <span>${p.nombre}</span>
                    <div class="barwrap"><div class="bar" style="width:${(p.cantidad / maxP) * 100}%"></div></div>
                </div>
                <span class="num">${p.cantidad}</span>
            </div>
        `).join('') || '<div style="color:var(--muted)">Sin datos</div>';

        document.getElementById('dVentasTabla').innerHTML = (data.ventas || []).map(v => {
            const hora = v.fecha.split(' ')[1].substring(0, 5);
            return `
            <tr>
                <td>${hora}</td>
                <td>${v.vendedora}</td>
                <td style="max-width:300px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="${v.detalle}">${v.detalle || '-'}</td>
                <td><span class="badge ${v.metodo_pago || 'otro'}">${pagoLabel(v.metodo_pago)}</span></td>
                <td class="num">S/ ${parseFloat(v.total).toFixed(2)}</td>
            </tr>`;
        }).join('') || '<tr><td colspan="5" style="text-align:center">Sin ventas</td></tr>';

        const resStock = await fetch('/api/stock', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ sucursal_id: getSucursalId() })
        });
        const stockData = await resStock.json();
        document.getElementById('dStatStock').innerText = stockData.reduce((acc, curr) => acc + curr.cantidad, 0);

        if (window.loadGastos) loadGastos();
    }
    loadReporteDesktop();
    </script>
    <?php
    $desktopContent = ob_get_clean();
}

// ── MODAL GASTOS ($modals) ─────────────────────────────────────────────────
ob_start();
?>
<div class="gasto-overlay" id="gasto-overlay" role="dialog" aria-modal="true" aria-labelledby="gasto-title">
  <div class="gasto-card">
    <button class="gasto-close" id="gasto-close" aria-label="Cerrar">&#x2715;</button>
    <h3 id="gasto-title">Registrar gasto</h3>
    <div class="gasto-msg" id="gasto-msg"></div>
    <label for="gasto-desc">Descripción</label>
    <input type="text" id="gasto-desc" maxlength="255" autocomplete="off" placeholder="Ej: Alcohol, pasaje...">
    <label for="gasto-monto">Monto (S/)</label>
    <input type="number" id="gasto-monto" step="0.01" min="0" placeholder="0.00">
    <div class="gasto-actions">
      <button class="gasto-btn cancel" onclick="closeGastoModal()">Cancelar</button>
      <button class="gasto-btn go" id="gasto-go" onclick="submitGasto()">Guardar</button>
    </div>
  </div>
</div>

<style>
.gasto-overlay{position:fixed;inset:0;background:var(--color-overlay,rgba(0,0,0,.5));backdrop-filter:blur(3px);display:none;align-items:center;justify-content:center;padding:1.2rem;z-index:1200}
.gasto-overlay.open{display:flex}
.gasto-card{position:relative;background:var(--color-elevated,#fff);border:1px solid var(--color-border);border-radius:18px;padding:1.8rem;width:360px;max-width:92vw;box-shadow:var(--shadow-md,0 12px 28px rgba(0,0,0,.2))}
.gasto-card h3{font-family:var(--font-display,serif);font-weight:500;font-size:1.4rem;margin-bottom:1rem}
.gasto-card label{display:block;font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;color:var(--color-text-secondary);margin:.7rem 0 .3rem}
.gasto-card input{width:100%;padding:.7rem .85rem;border:1px solid var(--color-border);border-radius:10px;background:var(--color-surface);color:var(--color-text-primary);font-family:inherit;font-size:.95rem;box-sizing:border-box}
.gasto-card input:focus{outline:none;border-color:var(--color-accent)}
.gasto-close{position:absolute;top:.9rem;right:.9rem;width:32px;height:32px;border:none;border-radius:50%;background:var(--color-soft,#eee);color:var(--color-text-primary);cursor:pointer;font-size:1rem;display:grid;place-items:center}
.gasto-msg{font-size:.82rem;margin-bottom:.4rem;display:none;padding:.5rem .7rem;border-radius:8px}
.gasto-msg.err{display:block;background:var(--color-error-light,rgba(196,69,54,.12));color:var(--color-error,#c44536)}
.gasto-msg.ok{display:block;background:var(--color-success-light,rgba(74,124,89,.12));color:var(--color-success,#4a7c59)}
.gasto-actions{display:flex;gap:.6rem;justify-content:flex-end;margin-top:1.3rem}
.gasto-btn{border:none;border-radius:10px;padding:.65rem 1.1rem;font-family:inherit;font-size:.9rem;font-weight:500;cursor:pointer}
.gasto-btn.cancel{background:var(--color-soft,#f3efe9);color:var(--color-text-primary)}
.gasto-btn.go{background:var(--color-accent);color:var(--color-on-accent,#fff)}
.gasto-btn:disabled{opacity:.6;cursor:default}
</style>

<script>
(function () {
  var ov    = document.getElementById('gasto-overlay');
  var msg   = document.getElementById('gasto-msg');
  var go    = document.getElementById('gasto-go');
  var fdesc = document.getElementById('gasto-desc');
  var fmont = document.getElementById('gasto-monto');

  function esc(s) { return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

  function showMsg(type, txt) {
    msg.className = 'gasto-msg ' + type;
    msg.textContent = txt;
  }

  window.openGastoModal = function () {
    fdesc.value = '';
    fmont.value = '';
    msg.className = 'gasto-msg';
    msg.textContent = '';
    ov.classList.add('open');
    document.body.style.overflow = 'hidden';
    fdesc.focus();
  };

  window.closeGastoModal = function () {
    ov.classList.remove('open');
    document.body.style.overflow = '';
  };

  document.getElementById('gasto-close').addEventListener('click', window.closeGastoModal);
  ov.addEventListener('click', function (e) { if (e.target === ov) window.closeGastoModal(); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && ov.classList.contains('open')) window.closeGastoModal();
  });

  window.submitGasto = async function () {
    var desc  = fdesc.value.trim();
    var monto = parseFloat(fmont.value);
    if (!desc)               { showMsg('err', 'La descripción no puede estar vacía'); return; }
    if (isNaN(monto) || monto <= 0) { showMsg('err', 'El monto debe ser mayor a 0'); return; }
    go.disabled = true;
    try {
      var r = await fetch('/api/gastos', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ sucursal_id: getSucursalId(), descripcion: desc, monto: monto })
      });
      var d = await r.json();
      if (r.ok && d.ok) {
        showToast('Gasto registrado');
        window.closeGastoModal();
        window.loadGastos();
      } else {
        showMsg('err', d.error || 'No se pudo guardar');
      }
    } catch (e) { showMsg('err', 'Error de conexión'); }
    go.disabled = false;
  };

  function buildNetoInner(ingresos, gastos, esAdmin) {
    var neto = parseFloat((ingresos - gastos).toFixed(2));
    var pos  = neto >= 0;
    var h    = esAdmin ? 'Resumen del periodo' : 'Resumen del día';
    var nl   = esAdmin ? 'Neto del periodo'    : 'Neto del día';
    return '<div class="rd-heading">' + h + '</div>'
         + '<div class="rd-mini-row">'
         + '<div class="rd-mini rd-ing"><div class="rd-mini-ico">↑</div><div class="rd-mini-text"><div class="rd-mini-lbl">Ingresos</div><div class="rd-mini-val">S/ ' + ingresos.toFixed(2) + '</div></div></div>'
         + '<div class="rd-mini rd-gas"><div class="rd-mini-ico">↓</div><div class="rd-mini-text"><div class="rd-mini-lbl">Gastos</div><div class="rd-mini-val">S/ ' + gastos.toFixed(2) + '</div></div></div>'
         + '</div>'
         + '<div class="rd-sep"></div>'
         + '<div class="rd-neto-row">'
         + '<div><div class="rd-neto-lbl">' + nl + '</div>'
         + '<div class="rd-neto-val ' + (pos ? 'rd-pos' : 'rd-neg') + '">' + (pos ? '+' : '−') + 'S/ ' + Math.abs(neto).toFixed(2) + '</div></div>'
         + '<span class="rd-chip ' + (pos ? 'rd-chip-pos' : 'rd-chip-neg') + '">' + (pos ? '↗ Ganancia' : '↘ Pérdida') + '</span>'
         + '</div>';
  }

  window.loadGastos = async function () {
    var desde = document.getElementById('rep-desde-m')?.value
             || document.getElementById('rep-desde-d')?.value
             || todayStr();
    var hasta = document.getElementById('rep-hasta-m')?.value
             || document.getElementById('rep-hasta-d')?.value
             || todayStr();

    try {
      var r = await fetch('/api/gastos/listar', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ sucursal_id: getSucursalId(), desde: desde, hasta: hasta })
      });
      var data = await r.json();
      var gastos = data.gastos || [];
      var total  = parseFloat(data.total || 0);

      // Lista móvil
      var mList = document.getElementById('gastosMovilList');
      if (mList) {
        mList.innerHTML = gastos.map(function (g) {
          var hora = g.fecha.split(' ')[1]?.substring(0, 5) || '';
          return '<div class="srow"><span class="sinfo"><span class="ml">' + hora + ' · ' + esc(g.descripcion) + '</span></span>'
               + '<div class="qty"><div class="num">S/ ' + parseFloat(g.monto).toFixed(2) + '</div></div></div>';
        }).join('') || '<div class="sd">Sin gastos</div>';
        var mTotal = document.getElementById('gastosTotalMovil');
        if (mTotal) mTotal.textContent = gastos.length ? 'Total: S/ ' + total.toFixed(2) : '';
      }

      // Tabla escritorio
      var dTabla = document.getElementById('gastosDesktopTabla');
      if (dTabla) {
        dTabla.innerHTML = gastos.map(function (g) {
          var hora = g.fecha.split(' ')[1]?.substring(0, 5) || '';
          return '<tr><td>' + hora + '</td><td>' + esc(g.usuario) + '</td><td>' + esc(g.descripcion) + '</td>'
               + '<td class="num">S/ ' + parseFloat(g.monto).toFixed(2) + '</td></tr>';
        }).join('') || '<tr><td colspan="4" style="text-align:center">Sin gastos</td></tr>';
        var dTotal = document.getElementById('gastosTotalDesktop');
        if (dTotal) dTotal.textContent = gastos.length ? 'Total gastos: S/ ' + total.toFixed(2) : '';
      }

      // Tarjeta Resumen del día — móvil
      var mCard = document.getElementById('netoMovilCard');
      if (mCard) {
        mCard.innerHTML = buildNetoInner(window._ingresosMovil || 0, total, false);
        mCard.style.display = '';
      }

      // Tarjeta Resumen del periodo — escritorio
      var dCard = document.getElementById('netoDesktopCard');
      if (dCard) {
        dCard.innerHTML = buildNetoInner(window._ingresosDesktop || 0, total, true);
        dCard.style.display = '';
      }
    } catch (e) { /* silencioso si la tabla aún no existe en DOM */ }
  };

  // Carga inicial de gastos
  window.loadGastos();
})();
</script>
<?php
$modals = ob_get_clean();

require APP_ROOT . '/app/views/tienda/layout.php';
