<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BlooBelle · Login Tienda</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/tienda.css">
<style>
  body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background: var(--bg); }
  .login-card { background: var(--surface); padding: 3rem 2rem; border-radius: 20px; box-shadow: var(--shadow); text-align: center; width: 100%; max-width: 380px; border: 1px solid var(--border); }
  .logo { font-family: var(--fd); font-size: 2.2rem; color: var(--text); margin-bottom: 0.5rem; }
  .sub { font-size: 0.9rem; color: var(--muted); margin-bottom: 2rem; letter-spacing: 0.1em; text-transform: uppercase; }
  .inp { width: 100%; padding: 1rem; border: 1px solid var(--border); border-radius: 12px; margin-bottom: 1rem; font-family: var(--fb); font-size: 1rem; }
  .inp:focus { outline: none; border-color: var(--accent); }
  .btn { width: 100%; padding: 1rem; background: var(--text); color: #fff; border: none; border-radius: 12px; font-family: var(--fb); font-size: 1.05rem; cursor: pointer; margin-top: 0.5rem; transition: 0.2s; }
  .btn:hover { background: var(--accent); }
  .err { color: var(--error); font-size: 0.85rem; margin-bottom: 1rem; display: none; }
</style>
</head>
<body>
  <div class="login-card">
    <div class="logo">BlooBelle</div>
    <div class="sub">Acceso Tienda</div>
    <div class="err" id="errorMsg">Credenciales incorrectas</div>
    <form id="loginForm">
      <input type="text" id="user" class="inp" placeholder="Usuario" required>
      <input type="password" id="pass" class="inp" placeholder="Contraseña" required>
      <button type="submit" class="btn">Ingresar</button>
    </form>
  </div>
  <script>
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const u = document.getElementById('user').value;
      const p = document.getElementById('pass').value;
      try {
        const res = await fetch('/api/auth/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ usuario: u, password: p })
        });
        const data = await res.json();
        if (data.ok) {
          window.location.href = '/tienda';
        } else {
          document.getElementById('errorMsg').style.display = 'block';
          document.getElementById('errorMsg').textContent = data.error || 'Error al ingresar';
        }
      } catch (err) {
        document.getElementById('errorMsg').style.display = 'block';
        document.getElementById('errorMsg').textContent = 'Error de conexión';
      }
    });
  </script>
</body>
</html>
