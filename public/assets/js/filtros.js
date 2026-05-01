function getCheckedValues(name) {
  return Array.from(document.querySelectorAll(`input[name="${name}"]:checked`))
    .map(el => el.value);
}

function escapeHtml(str) {
  return String(str)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');
}

function renderProductos(productos) {
  const cont = document.getElementById('productos');
  cont.innerHTML = '';

  if (!productos.length) {
    cont.innerHTML = `<div class="col-span-full text-sm text-gray-500">No hay resultados.</div>`;
    return;
  }

  for (const p of productos) {
    cont.insertAdjacentHTML('beforeend', `
      <div class="bg-white rounded-2xl shadow-sm p-4 hover:shadow-md transition">
        <div class="h-40 bg-gray-100 rounded-xl mb-4"></div>
        <h3 class="font-medium">${escapeHtml(p.referencia)}</h3>
        <p class="text-sm text-gray-500">${escapeHtml(p.marca)} · ${escapeHtml(p.genero)}</p>
        <p class="text-xs text-gray-400 mt-1">${escapeHtml(p.codigo)}</p>
      </div>
    `);
  }
}

async function aplicarFiltros() {
  const payload = {
    genero: getCheckedValues('genero[]'),
    designers: getCheckedValues('designers[]').map(Number),
    tipos: getCheckedValues('tipos[]'),
    componentes: getCheckedValues('componentes[]')
  };

  const res = await fetch('/api/perfumes/filter', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  });

  const data = await res.json();
  renderProductos(data);
}

function limpiarFiltros() {
  document.querySelectorAll('#filtros input[type="checkbox"]').forEach(cb => cb.checked = false);
  aplicarFiltros();
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('btn-aplicar-filtros')?.addEventListener('click', () => {
    aplicarFiltros();
    document.getElementById('filtros')?.classList.add('hidden');
  });

  document.getElementById('btn-limpiar')?.addEventListener('click', () => {
    limpiarFiltros();
  });
});
