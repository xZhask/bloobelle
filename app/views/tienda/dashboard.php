<?php
use App\Core\Auth;
$user = Auth::user();
$isAdmin = $user['rol'] === 'admin';
$activeTab = 'venta';
ob_start();
?>
<div id="venta">
  <div class="body">
    <div class="field" style="position:relative;">
      <label>Perfume (se llena al momento)</label>
      <input type="text" id="busquedaPerfume" class="inp" placeholder="Buscar referencia o marca…" autocomplete="off">
      <div class="res-box hide" id="resBusqueda"></div>
    </div>

    <label>Elegir frasco</label>
    <div id="gridRelleno" style="margin-bottom:0.6rem;"></div>
    <div class="grouplbl">Genéricos</div>
    <div class="fgrid" id="gridGenericos"></div>
    <div class="grouplbl">Diseño</div>
    <div class="fgrid" id="gridDiseno"></div>

    <div class="preview hide" id="previewFrasco"></div>

    <div class="field">
      <label>Cantidad</label>
      <div class="stepper">
        <button type="button" onclick="cambiarCant(-1)">−</button>
        <span class="n" id="qtySpan">1</span>
        <button type="button" onclick="cambiarCant(1)">+</button>
      </div>
    </div>
    <button class="add" id="btnAddCart">+ Agregar a la venta</button>

    <div class="cart" id="cartSection" style="display:none;">
      <div class="ct">En esta venta</div>
      <div id="cartItems"></div>
    </div>
  </div>
  <div class="paybar">
    <div class="field">
      <label>Método de Pago</label>
      <select id="metodoPago" class="inp" style="padding:0.5rem; margin-bottom:0.5rem;">
        <option value="efectivo">Efectivo</option>
        <option value="yape_plin">Yape / Plin</option>
        <option value="tarjeta">Tarjeta</option>
        <option value="otro">Otro</option>
      </select>
    </div>
    <div class="field" style="margin-top:1rem;">
      <label>Total de la venta (S/)</label>
      <input type="number" id="inpTotal" class="inp" min="0" step="0.01" placeholder="0.00" style="font-size:1.5rem; font-weight:bold; text-align:right; padding:0.5rem;">
    </div>
    <button class="pay" id="btnPay" disabled style="margin-top:1rem;">Registrar venta</button>
  </div>
</div>

<script>
let frascos = [];
let perfumeSeleccionado = null;
let frascoSeleccionado = null;
let cantidadForm = 1;
let carrito = [];

async function loadStock() {
    const res = await fetch('/api/stock', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({sucursal_id: getSucursalId()})
    });
    frascos = await res.json();
    renderFrascos();
}

function getIcon(n, cat) {
    let lower = n.toLowerCase();
    if(lower.includes('coraz')) return 'corazon';
    if(lower.includes('paris') || lower.includes('parís')) return 'paris';
    if(lower.includes('camara') || lower.includes('cámara')) return 'camara';
    return 'botella';
}

function renderFrascos() {
    const relleno = frascos.filter(f => f.controla_stock == 0);
    const gen     = frascos.filter(f => f.categoria === 'generico' && f.controla_stock != 0);
    const dis     = frascos.filter(f => f.categoria === 'diseno'   && f.controla_stock != 0);

    const relDiv = document.getElementById('gridRelleno');
    if (relleno.length > 0) {
        relDiv.innerHTML = `<div class="grouplbl" style="color:var(--color-accent);">Relleno (frasco del cliente)</div><div class="fgrid">${relleno.map(f => cardFrasco(f)).join('')}</div>`;
    } else {
        relDiv.innerHTML = '';
    }
    document.getElementById('gridGenericos').innerHTML = gen.map(f => cardFrasco(f)).join('');
    document.getElementById('gridDiseno').innerHTML    = dis.map(f => cardFrasco(f)).join('');
}

function cardFrasco(f) {
    const selClass   = (frascoSeleccionado && frascoSeleccionado.id === f.id) ? 'on' : '';
    const sinStock   = f.controla_stock == 0;
    const agotado    = !sinStock && f.cantidad <= 0;
    const nm         = f.nombre.replace('Genérico ', '');
    let thumbHTML = '';
    if (f.imagen) {
        let src = f.imagen.startsWith('/') ? f.imagen : '/' + f.imagen;
        thumbHTML = `<img src="${src}" alt="${nm}" style="height:42px; object-fit:contain;">`;
    } else {
        const icon = getIcon(f.nombre, f.categoria);
        thumbHTML = SVG[icon] || SVG.botella;
    }
    const qtyLabel = sinStock
        ? `<div class="fqty" style="color:var(--color-accent);">Trae su frasco</div>`
        : `<div class="fqty">${agotado ? '<span style="color:var(--color-error)">Agotado</span>' : 'quedan ' + f.cantidad}</div>`;
    const disabledStyle = agotado ? 'opacity:0.45;pointer-events:none;' : '';
    return `
    <div class="fcard ${selClass}" onclick="selFrasco(${f.id})" style="${disabledStyle}">
      <div class="fthumb">${thumbHTML}</div>
      <div class="fname">${nm}</div>
      ${qtyLabel}
    </div>`;
}

function selFrasco(id) {
    frascoSeleccionado = frascos.find(f => f.id === id);
    cantidadForm = 1;
    document.getElementById('qtySpan').innerText = cantidadForm;
    renderFrascos(); // re-render to update 'on' class

    const p = document.getElementById('previewFrasco');
    if(!frascoSeleccionado) { p.classList.add('hide'); return; }

    let thumbHTML = '';
    if (frascoSeleccionado.imagen) {
        let src = frascoSeleccionado.imagen.startsWith('/') ? frascoSeleccionado.imagen : '/' + frascoSeleccionado.imagen;
        thumbHTML = `<img src="${src}" alt="${frascoSeleccionado.nombre}" style="height:50px; object-fit:contain;">`;
    } else {
        const icon = getIcon(frascoSeleccionado.nombre, frascoSeleccionado.categoria);
        thumbHTML = SVG[icon] || SVG.botella;
    }
    p.innerHTML = `
      <div class="pimg">${thumbHTML}</div>
      <div>
        <div class="pname">${frascoSeleccionado.nombre}</div>
        <div class="pdesc">${frascoSeleccionado.descripcion || ''}</div>
        <div class="pprice">${frascoSeleccionado.controla_stock == 0 ? 'El cliente trae su frasco' : 'quedan ' + frascoSeleccionado.cantidad}</div>
      </div>
    `;
    p.classList.remove('hide');
    validateAddBtn();
}

function cambiarCant(d) {
    if(!frascoSeleccionado) return;
    let nf = cantidadForm + d;
    const maxCant = frascoSeleccionado.controla_stock == 0 ? 99 : frascoSeleccionado.cantidad;
    if(nf >= 1 && nf <= maxCant) {
        cantidadForm = nf;
        document.getElementById('qtySpan').innerText = cantidadForm;
    }
}

let timeoutBusqueda;
document.getElementById('busquedaPerfume').addEventListener('input', (e) => {
    clearTimeout(timeoutBusqueda);
    const q = e.target.value;
    const box = document.getElementById('resBusqueda');
    
    perfumeSeleccionado = null;
    validateAddBtn();

    if(q.length < 2) {
        box.classList.add('hide');
        return;
    }
    
    timeoutBusqueda = setTimeout(async () => {
        const res = await fetch('/api/perfumes/buscar', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({q})
        });
        const items = await res.json();
        
        if(items.length > 0) {
            box.innerHTML = items.map(i => `
                <div class="res-item" onclick="selPerfume(${i.id}, '${i.referencia.replace(/'/g, "\\'")}', '${i.marca ? i.marca.replace(/'/g, "\\'") : ''}')">
                    <span class="r" style="font-weight:500">${i.referencia}</span>
                    <div class="m">${i.marca || 'Sin marca'} · ${i.codigo || ''}</div>
                </div>
            `).join('');
            box.classList.remove('hide');
        } else {
            box.innerHTML = `<div class="res-item"><div class="m">No se encontraron resultados</div></div>`;
            box.classList.remove('hide');
        }
    }, 300);
});

function selPerfume(id, ref, marca) {
    perfumeSeleccionado = {id, ref, marca};
    document.getElementById('busquedaPerfume').value = ref;
    document.getElementById('resBusqueda').classList.add('hide');
    validateAddBtn();
}

function validateAddBtn() {
    const btn = document.getElementById('btnAddCart');
    const frascoOk = frascoSeleccionado && (frascoSeleccionado.controla_stock == 0 || frascoSeleccionado.cantidad > 0);
    if(perfumeSeleccionado && frascoOk) {
        btn.style.opacity = '1';
        btn.disabled = false;
    } else {
        btn.style.opacity = '0.5';
        btn.disabled = true;
    }
}

document.getElementById('btnAddCart').addEventListener('click', () => {
    if(!perfumeSeleccionado || !frascoSeleccionado) return;
    
    carrito.push({
        perfume_id: perfumeSeleccionado.id,
        perfume_ref: perfumeSeleccionado.ref,
        frasco_id: frascoSeleccionado.id,
        frasco_n: frascoSeleccionado.nombre,
        cantidad: cantidadForm
    });

    // Solo descontar stock local para frascos que controlan stock
    if(frascoSeleccionado.controla_stock != 0) {
        frascoSeleccionado.cantidad -= cantidadForm;
    }
    
    perfumeSeleccionado = null;
    frascoSeleccionado = null;
    document.getElementById('busquedaPerfume').value = '';
    document.getElementById('previewFrasco').classList.add('hide');
    renderFrascos();
    renderCart();
    validateAddBtn();
});

function rmCart(idx) {
    const it = carrito[idx];
    // Devolver stock local solo si el frasco lo controla
    const f = frascos.find(x => x.id === it.frasco_id);
    if(f && f.controla_stock != 0) f.cantidad += it.cantidad;

    carrito.splice(idx, 1);
    renderFrascos();
    renderCart();
}

function renderCart() {
    const sec = document.getElementById('cartSection');
    const itemsDiv = document.getElementById('cartItems');
    const btnPay = document.getElementById('btnPay');

    if(carrito.length === 0) {
        sec.style.display = 'none';
        btnPay.disabled = true;
        btnPay.style.opacity = '0.5';
        return;
    }

    sec.style.display = 'block';
    itemsDiv.innerHTML = carrito.map((c, i) => {
        return `
        <div class="line">
            <div class="info">
                <div class="r">${c.perfume_ref}</div>
                <div class="mm">${c.frasco_n} × ${c.cantidad}</div>
            </div>
            <div class="x" onclick="rmCart(${i})">×</div>
        </div>`;
    }).join('');

    btnPay.disabled = false;
    btnPay.style.opacity = '1';
}

document.getElementById('btnPay').addEventListener('click', async () => {
    if(carrito.length === 0) return;
    const inpTotal = document.getElementById('inpTotal').value;
    if(inpTotal === '' || parseFloat(inpTotal) < 0) {
        showToast('Por favor ingrese un Total válido mayor o igual a 0.', 'error');
        return;
    }

    const btn = document.getElementById('btnPay');
    btn.disabled = true;
    btn.innerText = 'Registrando...';

    const payload = {
        sucursal_id: getSucursalId(),
        metodo_pago: document.getElementById('metodoPago').value,
        total: parseFloat(inpTotal),
        items: carrito.map(c => ({
            perfume_id: c.perfume_id,
            frasco_id: c.frasco_id,
            cantidad: c.cantidad
        }))
    };

    try {
        const res = await fetch('/api/ventas', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        
        if(data.ok) {
            showToast('Venta registrada con éxito (ID: ' + data.venta_id + ')', 'success');
            carrito = [];
            document.getElementById('inpTotal').value = '';
            renderCart();
            await loadStock();
        } else {
            showToast('Error: ' + (data.error || 'Desconocido'), 'error');
        }
    } catch(err) {
        showToast('Error de conexión al registrar venta', 'error');
    }
    btn.innerText = 'Registrar venta';
    btn.disabled = false;
});

// Init
validateAddBtn();
loadStock();
</script>
<?php
$content = ob_get_clean();

require APP_ROOT . '/app/views/tienda/layout.php';
