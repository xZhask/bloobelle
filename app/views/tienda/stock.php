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
    
    document.getElementById('stocklist').innerHTML = frascos.filter(f => f.controla_stock != 0).map(f => {
        let thumbHTML = '';
        if (f.imagen) {
            let src = f.imagen.startsWith('/') ? f.imagen : '/' + f.imagen;
            thumbHTML = `<img src="${src}" alt="${f.nombre}" style="height:100%; max-height:40px; object-fit:contain;">`;
        } else {
            let icon = SVG.botella;
            let lower = f.nombre.toLowerCase();
            if(lower.includes('coraz')) icon = SVG.corazon;
            else if(lower.includes('paris') || lower.includes('parís')) icon = SVG.paris;
            else if(lower.includes('camara') || lower.includes('cámara')) icon = SVG.camara;
            thumbHTML = icon;
        }

        let badge = f.bajo ? '<span class="badge low">Bajo</span>' : '<span class="badge ok">OK</span>';
        let desc = f.descripcion || '';
        let catBadge = f.categoria === 'diseno' ? '<span class="tipo">diseño</span>' : '';

        let actionBtn = '';
        let editGlobalLink = '';
        <?php if($isAdmin): ?>
        editGlobalLink = `<a href="/catalogo/frascos" onclick="alert('Los cambios de imagen, nombre y estado aplican a todas las sucursales.')" style="color:var(--text); text-decoration:none; margin-left:0.5rem; display:inline-flex; align-items:center;" title="Editar Frasco Global">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.6; transition:color 0.2s;" onmouseover="this.style.color='var(--accent)'; this.style.opacity='1'" onmouseout="this.style.color='currentColor'; this.style.opacity='0.6'">
                <path opacity="0.4" d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13"/>
                <path d="M16.0399 3.01976L8.15988 10.8998C7.85988 11.1998 7.55988 11.7898 7.49988 12.2198L7.06988 15.2298C6.90988 16.3198 7.67988 17.0798 8.76988 16.9298L11.7799 16.4998C12.1999 16.4398 12.7899 16.1398 13.0999 15.8398L20.9799 7.95976C22.3399 6.59976 22.9799 5.01976 20.9799 3.01976C18.9799 1.01976 17.3999 1.65976 16.0399 3.01976Z"/>
                <path opacity="0.4" d="M14.9102 4.1499C15.5802 6.5399 17.4502 8.4099 19.8502 9.0899"/>
            </svg>
        </a>`;
        <?php endif; ?>

        return `
        <div class="srow">
            <span class="mini">${thumbHTML}</span>
            <span class="sinfo">
                <div class="ml">${f.nombre} ${catBadge} ${editGlobalLink}</div>
                <div class="sd">${desc}</div>
            </span>
            <span class="q">${f.cantidad}${badge}</span>
        </div>`;
    }).join('');
}

<?php if($isAdmin): ?>
function openEntradaModal() {
    const sel = document.getElementById('mdlFrasco');
    sel.innerHTML = allFrascos.filter(f => f.controla_stock != 0).map(f => `<option value="${f.id}">${f.nombre}</option>`).join('');
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
        <div class="chead">
            <h2>Stock de frascos</h2>
            <button class="cbtn acc" onclick="openEntradaModal()">+ Registrar entrada</button>
        </div>
        <div class="cbody">
          <table id="desktopStockTable">
            <thead><tr><th>Frasco</th><th style="text-align:right">Quedan</th><th>Estado</th></tr></thead>
            <tbody>
              <tr><td colspan="3" style="text-align:center">Cargando...</td></tr>
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
        document.querySelector('#desktopStockTable tbody').innerHTML = frascos.filter(f => f.controla_stock != 0).map(f => {
            let thumbHTML = '';
            if (f.imagen) {
                let src = f.imagen.startsWith('/') ? f.imagen : '/' + f.imagen;
                thumbHTML = `<img src="${src}" alt="${f.nombre}" style="height:24px; object-fit:contain;">`;
            } else {
                let icon = SVG.botella;
                let lower = f.nombre.toLowerCase();
                if(lower.includes('coraz')) icon = SVG.corazon;
                else if(lower.includes('paris') || lower.includes('parís')) icon = SVG.paris;
                else if(lower.includes('camara') || lower.includes('cámara')) icon = SVG.camara;
                thumbHTML = icon;
            }

            let badge = f.bajo ? '<span class="badge low">Bajo</span>' : '<span class="badge ok">OK</span>';
            let catBadge = f.categoria === 'diseno' ? '<span class="tipo">diseño</span>' : '';
            let editGlobalLink = `<a href="/catalogo/frascos" onclick="alert('Los cambios de imagen, nombre y estado aplican a todas las sucursales.')" style="color:var(--text); text-decoration:none; margin-left:0.5rem; display:inline-flex; align-items:center;" title="Editar Frasco Global">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.6; transition:color 0.2s;" onmouseover="this.style.color='var(--accent)'; this.style.opacity='1'" onmouseout="this.style.color='currentColor'; this.style.opacity='0.6'">
                    <path opacity="0.4" d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13"/>
                    <path d="M16.0399 3.01976L8.15988 10.8998C7.85988 11.1998 7.55988 11.7898 7.49988 12.2198L7.06988 15.2298C6.90988 16.3198 7.67988 17.0798 8.76988 16.9298L11.7799 16.4998C12.1999 16.4398 12.7899 16.1398 13.0999 15.8398L20.9799 7.95976C22.3399 6.59976 22.9799 5.01976 20.9799 3.01976C18.9799 1.01976 17.3999 1.65976 16.0399 3.01976Z"/>
                    <path opacity="0.4" d="M14.9102 4.1499C15.5802 6.5399 17.4502 8.4099 19.8502 9.0899"/>
                </svg>
            </a>`;
            
            return `
            <tr>
                <td style="display: flex; align-items: center; gap: 0.8rem;">
                    <span style="display:inline-block; width:24px; height:24px;">${thumbHTML}</span>
                    <span>${f.nombre} ${catBadge} ${editGlobalLink}</span>
                </td>
                <td class="num">${f.cantidad}</td>
                <td>${badge}</td>
            </tr>`;
        }).join('');
    }
    loadDesktopStock();
    </script>
    
    <?php
    $desktopContent = ob_get_clean();
}

if ($isAdmin) {
    ob_start();
    ?>
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
    $modals = ob_get_clean();
}

require APP_ROOT . '/app/views/tienda/layout.php';
