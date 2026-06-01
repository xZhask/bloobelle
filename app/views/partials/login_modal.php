<style>
.login-overlay{position:fixed;inset:0;background:rgba(26,22,20,.45);backdrop-filter:blur(3px);display:none;align-items:center;justify-content:center;z-index:2000}
.login-overlay.open{display:flex}
.login-card{background:var(--color-surface);border-radius:18px;padding:2rem 1.8rem;width:340px;max-width:92vw;box-shadow:0 24px 60px rgba(0,0,0,.32);border:1px solid var(--color-border)}
.login-card h3{font-family:var(--font-display,'Playfair Display',serif);font-weight:500;font-size:1.5rem;margin-bottom:.3rem;color:var(--color-text-primary)}
.login-card p{color:var(--color-text-secondary);font-size:.85rem;margin-bottom:1.2rem}
.login-card label{display:block;font-size:.72rem;letter-spacing:.07em;text-transform:uppercase;color:var(--color-text-secondary);margin-bottom:.35rem}
.login-card input{width:100%;padding:.8rem .9rem;border:1px solid var(--color-border);border-radius:10px;font-size:1rem;margin-bottom:1rem;font-family:inherit;background:var(--color-bg);color:var(--color-text-primary)}
.login-card input:focus{outline:none;border-color:var(--color-accent)}
.login-card .err{color:var(--color-error,#c44536);font-size:.8rem;margin-bottom:.8rem;display:none}
.login-card .actions{display:flex;gap:.6rem;justify-content:flex-end;margin-top:.4rem}
.login-card .b{border:none;border-radius:10px;padding:.7rem 1.1rem;font-family:inherit;font-size:.9rem;cursor:pointer}
.login-card .b.cancel{background:var(--color-soft);color:var(--color-text-primary)}
.login-card .b.go{background:var(--color-accent);color:var(--color-on-accent,#fff)}
</style>

<div class="login-overlay" id="login-overlay">
  <div class="login-card">
    <h3>BlooBelle</h3>
    <p>Inicia sesión para administrar el catálogo o registrar ventas.</p>
    <div class="err" id="login-err"></div>
    <label>Usuario</label>
    <input type="text" id="login-user" autocomplete="username">
    <label>Contraseña</label>
    <input type="password" id="login-pass" autocomplete="current-password">
    <div class="actions">
      <button class="b cancel" id="login-cancel">Cancelar</button>
      <button class="b go" id="login-go">Entrar</button>
    </div>
  </div>
</div>

<script>
(function () {
  var ov     = document.getElementById('login-overlay');
  var errEl  = document.getElementById('login-err');

  function openLogin() {
    if (typeof window.closePanels === 'function') window.closePanels();
    ov.classList.add('open');
    document.getElementById('login-user').focus();
  }
  function closeLogin() { ov.classList.remove('open'); }

  document.getElementById('btn-open-login')?.addEventListener('click', openLogin);
  document.getElementById('btn-open-login-drawer')?.addEventListener('click', openLogin);
  document.getElementById('login-cancel')?.addEventListener('click', closeLogin);
  ov?.addEventListener('click', function (e) { if (e.target === ov) closeLogin(); });

  document.getElementById('login-pass')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') document.getElementById('login-go').click();
  });

  document.getElementById('login-go')?.addEventListener('click', async function () {
    errEl.style.display = 'none';
    try {
      var r = await fetch('/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({
          usuario: document.getElementById('login-user').value,
          password: document.getElementById('login-pass').value
        })
      });
      var data = await r.json();
      if (r.ok && data.ok) {
        location.reload();
      } else {
        errEl.textContent = data.error || 'No se pudo iniciar sesión';
        errEl.style.display = 'block';
      }
    } catch (e) {
      errEl.textContent = 'Error de conexión';
      errEl.style.display = 'block';
    }
  });
})();
</script>
