<?php
use App\Core\Auth;
$user = Auth::user();
$isAdmin = $user['rol'] === 'admin';
$activeTab = 'stock';
ob_start();
?>
<div id="stock">
  <div class="body">
    <div class="h">Stock de frascos</div>
    <p class="sub">Listado ordenado: genéricos primero, luego diseño</p>

    <?php if($isAdmin): ?>
    <div style="margin-bottom:1rem; display:flex; gap:0.5rem">
        <button class="cbtn acc" onclick="openEntradaModal()">+ Registrar entrada</button>
        <button class="cbtn" onclick="promptPrecio()">Fijar precio</button>
    </div>
    <?php endif; ?>

    <div id="stocklist">
        <!-- JS injeta aquí -->
        <div style="text-align:center; padding: 2rem; color:var(--muted)">Cargando stock...</div>
    </div>
  </div>
</div>

<script>
let allFrascos = [];
async function loadStockList() {
    const res = await fetch('/api/stock', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({sucursal_id: getSucursalId()})
    });
    const frascos = await res.json();
    allFrascos = frascos;
    
    document.getElementById('stocklist').innerHTML = frascos.map(f => {
        let icon = SVG.botella;
        let lower = f.nombre.toLowerCase();
        if(lower.includes('coraz')) icon = SVG.corazon;
        else if(lower.includes('paris') || lower.includes('parís')) icon = SVG.paris;
        else if(lower.includes('camara') || lower.includes('cámara')) icon = SVG.camara;

        let badge = f.bajo ? '<span class="badge low">Bajo</span>' : '<span class="badge ok">OK</span>';
        let desc = f.descripcion || '';
        let catBadge = f.categoria === 'diseno' ? '<span class="tipo">diseño</span>' : '';

        return `
        <div class="srow">
            <span class="mini">${icon}</span>
            <span class="sinfo">
                <div class="ml">${f.nombre} ${catBadge}</div>
                <div class="sd">${desc} · S/ ${f.precio ? parseFloat(f.precio).toFixed(2) : '0.00'}</div>
            </span>
            <span class="q">${f.cantidad}${badge}</span>
        </div>`;
    }).join('');
}

<?php if($isAdmin): ?>
function openEntradaModal() {
    const sel = document.getElementById('mdlFrasco');
    sel.innerHTML = allFrascos.map(f => `<option value="${f.id}">${f.nombre} (S/ ${f.precio ? parseFloat(f.precio).toFixed(2) : '0.00'})</option>`).join('');
    document.getElementById('mdlCant').value = 1;
    document.getElementById('modalEntrada').classList.add('open');
}

function closeEntradaModal() {
    document.getElementById('modalEntrada').classList.remove('open');
}

async function submitEntrada() {
    const frasco_id = document.getElementById('mdlFrasco').value;
    const cant = document.getElementById('mdlCant').value;
    
    if(!frasco_id || !cant || cant <= 0) return;
    
    const res = await fetch('/api/stock/entrada', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            sucursal_id: getSucursalId(),
            frasco_id: parseInt(frasco_id),
            cantidad: parseInt(cant)
        })
    });
    const data = await res.json();
    if(data.ok) {
        closeEntradaModal();
        loadStockList();
        if(typeof loadDesktopStock === 'function') loadDesktopStock();
    } else {
        alert(data.error);
    }
}

async function promptPrecio() {
    let frasco_id = prompt("ID del Frasco:");
    if(!frasco_id) return;
    let precio = prompt("Nuevo Precio (ej: 45.00):");
    if(!precio) return;

    const res = await fetch('/api/precios', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            sucursal_id: getSucursalId(),
            frasco_id: parseInt(frasco_id),
            precio: parseFloat(precio)
        })
    });
    const data = await res.json();
    if(data.ok) {
        loadStockList();
        if(typeof loadDesktopStock === 'function') loadDesktopStock();
    } else alert(data.error);
}
<?php endif; ?>

loadStockList();
</script>
<?php
$content = ob_get_clean();

// Desktop Content (Admin)
if ($isAdmin) {
    ob_start();
    ?>
    <h1 class="title">Verificación de Stock</h1>
    <p class="csub">Revisión general de existencias</p>

    <div class="card">
        <div class="chead"><h2>Stock de frascos</h2><button class="cbtn acc" onclick="openEntradaModal()">+ Registrar entrada</button></div>
        <div class="cbody">
          <table id="desktopStockTable">
            <thead><tr><th>Frasco</th><th>Precio</th><th style="text-align:right">Quedan</th><th>Estado</th></tr></thead>
            <tbody>
              <tr><td colspan="4" style="text-align:center">Cargando...</td></tr>
            </tbody>
          </table>
        </div>
    </div>
    <script>
    async function loadDesktopStock() {
        const res = await fetch('/api/stock', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({sucursal_id: getSucursalId()})
        });
        const frascos = await res.json();
        document.querySelector('#desktopStockTable tbody').innerHTML = frascos.map(f => {
            let badge = f.bajo ? '<span class="badge low">Bajo</span>' : '<span class="badge ok">OK</span>';
            let catBadge = f.categoria === 'diseno' ? '<span class="tipo">diseño</span>' : '';
            return `
            <tr>
                <td>${f.nombre} ${catBadge}</td>
                <td class="price">S/ ${f.precio ? parseFloat(f.precio).toFixed(2) : '0.00'}</td>
                <td class="num">${f.cantidad}</td>
                <td>${badge}</td>
            </tr>`;
        }).join('');
    }
    loadDesktopStock();
    </script>
    
    <!-- Modal para Admin Desktop -->
    <div class="modal-overlay" id="modalEntrada">
      <div class="modal">
        <h3 class="modal-title">Registrar Entrada</h3>
        <p class="modal-desc">Suma unidades de frascos vacíos al inventario de la sucursal.</p>
        
        <div class="field">
          <label>Frasco a ingresar</label>
          <select id="mdlFrasco" class="inp"></select>
        </div>
        
        <div class="field">
          <label>Cantidad (unidades)</label>
          <input type="number" id="mdlCant" class="inp" min="1" value="1">
        </div>
        
        <div class="modal-actions">
          <button class="cbtn" onclick="closeEntradaModal()">Cancelar</button>
          <button class="cbtn acc" onclick="submitEntrada()">Guardar stock</button>
        </div>
      </div>
    </div>
    
    <?php
    $desktopContent = ob_get_clean();
}

require APP_ROOT . '/app/views/tienda/layout.php';
