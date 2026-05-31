<div class="pwd-overlay" id="pwd-overlay" role="dialog" aria-modal="true" aria-labelledby="pwd-title">
  <div class="pwd-card">
    <button class="pwd-close" id="pwd-close" aria-label="Cerrar">&#x2715;</button>
    <h3 id="pwd-title">Cambiar contraseña</h3>
    <div class="pwd-msg" id="pwd-msg"></div>
    <label for="pwd-actual">Contraseña actual</label>
    <input type="password" id="pwd-actual" autocomplete="current-password">
    <label for="pwd-nueva">Nueva contraseña</label>
    <input type="password" id="pwd-nueva" autocomplete="new-password">
    <label for="pwd-confirmar">Confirmar nueva contraseña</label>
    <input type="password" id="pwd-confirmar" autocomplete="new-password">
    <div class="pwd-actions">
      <button class="pwd-btn cancel" id="pwd-cancel">Cancelar</button>
      <button class="pwd-btn go" id="pwd-go">Guardar</button>
    </div>
  </div>
</div>

<style>
.pwd-overlay{position:fixed;inset:0;background:var(--color-overlay,rgba(0,0,0,.5));backdrop-filter:blur(3px);display:none;align-items:center;justify-content:center;padding:1.2rem;z-index:1200}
.pwd-overlay.open{display:flex}
.pwd-card{position:relative;background:var(--color-elevated,#fff);border:1px solid var(--color-border);border-radius:18px;padding:1.8rem;width:360px;max-width:92vw;box-shadow:var(--shadow-md,0 12px 28px rgba(0,0,0,.2))}
.pwd-card h3{font-family:var(--font-display,serif);font-weight:500;font-size:1.4rem;margin-bottom:1rem}
.pwd-card label{display:block;font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;color:var(--color-text-secondary);margin:.7rem 0 .3rem}
.pwd-card input{width:100%;padding:.7rem .85rem;border:1px solid var(--color-border);border-radius:10px;background:var(--color-surface);color:var(--color-text-primary);font-family:inherit;font-size:.95rem;box-sizing:border-box}
.pwd-card input:focus{outline:none;border-color:var(--color-accent)}
.pwd-close{position:absolute;top:.9rem;right:.9rem;width:32px;height:32px;border:none;border-radius:50%;background:var(--color-soft,#eee);color:var(--color-text-primary);cursor:pointer;font-size:1rem;display:grid;place-items:center}
.pwd-msg{font-size:.82rem;margin-bottom:.4rem;display:none;padding:.5rem .7rem;border-radius:8px}
.pwd-msg.err{display:block;background:var(--color-error-light,rgba(196,69,54,.12));color:var(--color-error,#c44536)}
.pwd-msg.ok{display:block;background:var(--color-success-light,rgba(74,124,89,.12));color:var(--color-success,#4a7c59)}
.pwd-actions{display:flex;gap:.6rem;justify-content:flex-end;margin-top:1.3rem}
.pwd-btn{border:none;border-radius:10px;padding:.65rem 1.1rem;font-family:inherit;font-size:.9rem;font-weight:500;cursor:pointer}
.pwd-btn.cancel{background:var(--color-soft,#f3efe9);color:var(--color-text-primary)}
.pwd-btn.go{background:var(--color-accent);color:var(--color-on-accent,#fff)}
.pwd-btn:disabled{opacity:.6;cursor:default}
</style>

<script>
(function(){
  var ov=document.getElementById('pwd-overlay'); if(!ov) return;
  var msg=document.getElementById('pwd-msg'), go=document.getElementById('pwd-go');
  var fa=document.getElementById('pwd-actual'), fn=document.getElementById('pwd-nueva'), fc=document.getElementById('pwd-confirmar');
  var lastFocus=null;
  function open(t){lastFocus=t||document.activeElement;reset();ov.classList.add('open');document.body.style.overflow='hidden';fa.focus();}
  function close(){ov.classList.remove('open');document.body.style.overflow='';if(lastFocus)lastFocus.focus();}
  function reset(){msg.className='pwd-msg';msg.textContent='';fa.value=fn.value=fc.value='';}
  function show(type,txt){msg.className='pwd-msg '+type;msg.textContent=txt;}
  document.querySelectorAll('.js-open-password').forEach(function(b){b.addEventListener('click',function(){open(b);});});
  document.getElementById('pwd-close').addEventListener('click',close);
  document.getElementById('pwd-cancel').addEventListener('click',close);
  ov.addEventListener('click',function(e){if(e.target===ov)close();});
  document.addEventListener('keydown',function(e){if(e.key==='Escape'&&ov.classList.contains('open'))close();});
  go.addEventListener('click',async function(){
    if(fn.value!==fc.value){show('err','La nueva contraseña no coincide');return;}
    if(fn.value.length<8){show('err','La nueva contraseña debe tener al menos 8 caracteres');return;}
    go.disabled=true;
    try{
      var r=await fetch('/api/auth/password',{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json'},
        body:JSON.stringify({actual:fa.value,nueva:fn.value,confirmar:fc.value})});
      var d=await r.json();
      if(r.ok&&d.ok){show('ok','Contraseña actualizada');setTimeout(close,1100);}
      else show('err',d.error||'No se pudo actualizar');
    }catch(e){show('err','Error de conexión');}
    go.disabled=false;
  });
})();
</script>
