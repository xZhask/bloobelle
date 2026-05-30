# Catálogo como entrada + login visible — snippets listos para pegar

Para `bloobelle` (tu código actual). Tres piezas: (A) header condicional,
(B) modal de login, (C) guardas de servidor. La (C) es la que de verdad protege.

---

## A. Header consciente de sesión — `app/views/perfumes/index.php`

### A.1 Pasar el usuario a la vista — `PerfumeController::index()`
```php
public function index(): void {
  $repo = new PerfumeRepository();
  $generos   = $repo->getGeneros();
  $productos = $repo->listarInicial(30);
  $user = \App\Core\Auth::user();   // <— añadir esta línea
  require __DIR__ . '/../views/perfumes/index.php';
}
```

### A.2 Reemplazar el bloque `.header-actions` actual por este
```php
<div class="header-actions">
  <button class="btn-filters-mobile" id="btn-toggle-filters">
    <span>✦</span> Filtros
  </button>

  <?php if ($user === null): ?>
    <!-- SIN SESIÓN: catálogo público, solo opción de entrar -->
    <button class="btn-new" id="btn-open-login"><span>✦</span> Iniciar sesión</button>

  <?php elseif ($user['rol'] === 'admin'): ?>
    <!-- ADMIN: registros de catálogo -->
    <a href="/perfumes/create" class="btn-new"><span>+</span> Nuevo Perfume</a>
    <a href="/catalogo/frascos" class="btn-new"><span>+</span> Nuevo Frasco</a>
    <a href="/catalogo/precios" class="btn-new">Precios</a>
    <span class="user-chip">
      <span class="user-av"><?= strtoupper(substr($user['nombre'], 0, 1)) ?></span>
      <?= htmlspecialchars($user['nombre']) ?>
    </span>
    <a href="/logout" class="btn-logout">Salir</a>

  <?php else: /* vendedor */ ?>
    <!-- VENDEDOR: sus formularios asignados, sin registros de catálogo -->
    <a href="/tienda?pos=1" class="btn-new"><span>+</span> Registrar venta</a>
    <a href="/tienda/stock" class="btn-new">Stock</a>
    <a href="/tienda/reporte" class="btn-new">Reporte</a>
    <span class="user-chip">
      <span class="user-av"><?= strtoupper(substr($user['nombre'], 0, 1)) ?></span>
      <?= htmlspecialchars($user['nombre']) ?>
    </span>
    <a href="/logout" class="btn-logout">Salir</a>
  <?php endif; ?>
</div>
```
> Nota: los botones "Nuevo Frasco" y "Precios" apuntan al hub de catálogo
> (sección 5b del brief). Si aún no creas esas páginas, déjalos comentados y usa
> solo "Nuevo Perfume" por ahora.

### A.3 Estilos a añadir al `<style>` existente (paleta ya en uso)
```css
.user-chip{display:inline-flex;align-items:center;gap:.5rem;font-size:.85rem;color:var(--color-text-primary,#1a1614)}
.user-av{width:28px;height:28px;border-radius:50%;background:var(--color-accent,#b88e5d);color:#fff;display:grid;place-items:center;font-weight:600;font-size:.8rem}
.btn-logout{font-size:.82rem;color:var(--color-text-secondary,#766f68);text-decoration:none;border:1px solid var(--color-border,#e8e3dc);padding:.4rem .8rem;border-radius:999px}
.btn-logout:hover{color:#c44536;border-color:#c44536}

/* Modal login */
.login-overlay{position:fixed;inset:0;background:rgba(26,22,20,.45);backdrop-filter:blur(3px);display:none;align-items:center;justify-content:center;z-index:1000}
.login-overlay.open{display:flex}
.login-card{background:#fff;border-radius:18px;padding:2rem 1.8rem;width:340px;max-width:92vw;box-shadow:0 24px 60px rgba(0,0,0,.22)}
.login-card h3{font-family:'Playfair Display',serif;font-weight:500;font-size:1.5rem;margin-bottom:.3rem}
.login-card p{color:var(--color-text-secondary,#766f68);font-size:.85rem;margin-bottom:1.2rem}
.login-card label{display:block;font-size:.72rem;letter-spacing:.07em;text-transform:uppercase;color:var(--color-text-secondary,#766f68);margin-bottom:.35rem}
.login-card input{width:100%;padding:.8rem .9rem;border:1px solid var(--color-border,#e8e3dc);border-radius:10px;font-size:1rem;margin-bottom:1rem;font-family:inherit}
.login-card input:focus{outline:none;border-color:var(--color-accent,#b88e5d)}
.login-card .err{color:#c44536;font-size:.8rem;margin-bottom:.8rem;display:none}
.login-card .actions{display:flex;gap:.6rem;justify-content:flex-end;margin-top:.4rem}
.login-card .b{border:none;border-radius:10px;padding:.7rem 1.1rem;font-family:inherit;font-size:.9rem;cursor:pointer}
.login-card .b.cancel{background:var(--color-soft,#f3efe9);color:var(--color-text-primary,#1a1614)}
.login-card .b.go{background:var(--color-accent,#b88e5d);color:#fff}
```

---

## B. Modal de login — añadir antes de `</body>` en `index.php`
```html
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
  var ov = document.getElementById('login-overlay');
  var open = document.getElementById('btn-open-login');
  if (open) open.addEventListener('click', function () { ov.classList.add('open'); });
  var cancel = document.getElementById('login-cancel');
  if (cancel) cancel.addEventListener('click', function () { ov.classList.remove('open'); });
  if (ov) ov.addEventListener('click', function (e) { if (e.target === ov) ov.classList.remove('open'); });

  var go = document.getElementById('login-go');
  if (go) go.addEventListener('click', async function () {
    var err = document.getElementById('login-err');
    err.style.display = 'none';
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
        location.reload();              // el header pasa al estado logueado
      } else {
        err.textContent = data.error || 'No se pudo iniciar sesión';
        err.style.display = 'block';
      }
    } catch (e) {
      err.textContent = 'Error de conexión';
      err.style.display = 'block';
    }
  });
})();
</script>
```

---

## C. Guardas de servidor (IMPRESCINDIBLE) — primera línea de cada método
Sin esto, ocultar botones no protege nada (la URL/API siguen abiertas).

Exigir **admin** → `\App\Core\Auth::requireRole('admin');`
- `PerfumeController`: `create`, `store`, `uploadImage`, `storeDesigner`,
  `storeComponente`, `storeTipoAroma`
- `FrascoController`: `store`, `uploadImage`, `fijarPrecio`
- `StockController`: `entrada`, `ajuste`

Exigir **sesión** (vendedor o admin) → `\App\Core\Auth::requireLogin();`
- `VentaController`: `store`, `reporte`, `buscarPerfume`
- `StockController`: `listar`

**Públicas** (catálogo visible) — sin guarda:
- `PerfumeController`: `index`, `filter`

### C.1 Ajuste al guard para que las APIs respondan JSON (no redirect)
En `Auth::requireLogin()` / `requireRole()`, detectar la API por la ruta en vez de
por la cabecera `Accept`:
```php
$isApi = isset($_SERVER['REQUEST_URI']) && strncmp($_SERVER['REQUEST_URI'], '/api/', 5) === 0;
if ($isApi) { Response::json(['error' => 'No autenticado'], 401); exit; }
header('Location: /login'); exit;
```
Así un `POST /api/...` sin sesión recibe 401 en JSON y el front lo maneja; una
página protegida sí redirige a `/login`.
