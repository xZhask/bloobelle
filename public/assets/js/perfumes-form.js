function getCheckedIds(name) {
  return Array.from(document.querySelectorAll(`input[name="${name}"]:checked`))
    .map(el => Number(el.value))
    .filter(n => Number.isFinite(n) && n > 0);
}

document.addEventListener('DOMContentLoaded', () => {
  const msg = document.getElementById('msg');

  document.getElementById('btn-guardar')?.addEventListener('click', async () => {
    msg.textContent = '';
    msg.className = 'text-sm';

    const payload = {
      codigo: document.getElementById('codigo').value.trim(),
      referencia: document.getElementById('referencia').value.trim(),
      genero_id: Number(document.getElementById('genero_id').value),
      designer_id: Number(document.getElementById('designer_id').value),
      tipos_ids: getCheckedIds('tipos_ids[]'),
      componentes_ids: getCheckedIds('componentes_ids[]')
    };

    const res = await fetch('/api/perfumes', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });

    const data = await res.json();

    if (data.ok) {
      msg.className = 'text-sm text-green-700';
      msg.textContent = 'Guardado correctamente. ID: ' + data.id;
      setTimeout(() => window.location.href = '/perfumes', 700);
    } else {
      msg.className = 'text-sm text-red-700';
      msg.textContent = data.error || 'Error al guardar';
    }
  });
});
