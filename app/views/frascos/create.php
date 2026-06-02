<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nuevo Perfume Â· BlooBelle</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="/assets/images/marca/favicon-2.png">
  <link rel="stylesheet" href="/assets/css/theme.css?v=<?= filemtime(APP_ROOT . '/public/assets/css/theme.css') ?>">
  <script>
  (function(){try{
    var t=localStorage.getItem('bb-theme');
    if(!t){t=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';}
    document.documentElement.setAttribute('data-theme',t);
  }catch(e){}})();
  </script>
  <style>
    :root {
      --font-display: 'Playfair Display', serif;
      --font-body: 'Jost', sans-serif;
      
      --transition-smooth: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: var(--font-body);
      background: var(--color-bg);
      color: var(--color-text-primary);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
    }

    .container {
      max-width: 920px;
      margin: 0 auto;
      padding: 3rem 2rem;
      min-height: 100vh;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 3rem;
      padding-bottom: 2rem;
      border-bottom: 1px solid var(--color-border);
    }

    .header h1 {
      font-family: var(--font-display);
      font-size: 42px;
      font-weight: 500;
      letter-spacing: 0.5px;
    }

    .btn-back {
      padding: 0.75rem 1.5rem;
      background: transparent;
      color: var(--color-text-primary);
      border: 1.5px solid var(--color-border);
      border-radius: 8px;
      font-family: var(--font-body);
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition-smooth);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      letter-spacing: 0.5px;
    }

    .btn-back:hover {
      background: var(--color-bg);
      border-color: var(--color-text-primary);
      transform: translateX(-4px);
    }

    .form-card {
      background: var(--color-surface);
      border-radius: 16px;
      padding: 3rem;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--color-border);
    }

    .form-section { margin-bottom: 2.5rem; }
    .form-section:last-child { margin-bottom: 0; }

    .section-title {
      font-family: var(--font-display);
      font-size: 24px;
      font-weight: 500;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--color-border);
      letter-spacing: 0.5px;
    }

    .form-group { margin-bottom: 1.5rem; }

    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--color-text-secondary);
      margin-bottom: 0.75rem;
    }

    .form-input, .form-select {
      width: 100%;
      padding: 1rem 1.25rem;
      border: 1.5px solid var(--color-border);
      border-radius: 10px;
      font-family: var(--font-body);
      font-size: 15px;
      background: var(--color-bg);
      transition: var(--transition-smooth);
      color: var(--color-text-primary);
    }

    .form-input:focus, .form-select:focus {
      outline: none;
      border-color: var(--color-accent);
      background: var(--color-surface);
      box-shadow: 0 0 0 4px rgba(184, 142, 93, 0.1);
    }

    .form-input::placeholder {
      color: var(--color-text-secondary);
      font-weight: 300;
    }

    .form-help {
      font-size: 13px;
      color: var(--color-text-secondary);
      margin-top: 0.5rem;
      font-weight: 300;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }

    /* â”€â”€ File Upload â”€â”€ */
    .file-upload-area {
      position: relative;
      border: 2px dashed var(--color-border);
      border-radius: 12px;
      cursor: pointer;
      transition: var(--transition-smooth);
      overflow: hidden;
      background: var(--color-bg);
    }

    .file-upload-area:hover,
    .file-upload-area.drag-over {
      border-color: var(--color-accent);
      background: var(--color-accent-light);
    }

    .file-upload-area.drag-over { transform: scale(1.01); }

    .file-input {
      position: absolute;
      inset: 0;
      opacity: 0;
      cursor: pointer;
      z-index: 2;
    }

    .file-upload-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2.5rem 1.5rem;
      gap: 0.5rem;
      pointer-events: none;
    }

    .file-upload-icon {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: var(--color-accent-light);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 0.5rem;
      transition: var(--transition-smooth);
    }

    .file-upload-icon svg {
      width: 24px;
      height: 24px;
      color: var(--color-accent);
    }

    .file-upload-area:hover .file-upload-icon {
      background: rgba(184, 142, 93, 0.15);
      transform: scale(1.05);
    }

    .file-upload-text {
      font-size: 15px;
      font-weight: 500;
      color: var(--color-text-primary);
    }

    .file-upload-formats {
      font-size: 13px;
      color: var(--color-text-secondary);
      font-weight: 300;
    }

    .file-preview {
      position: relative;
      display: flex;
      align-items: center;
      gap: 1.25rem;
      padding: 1.25rem;
    }

    .file-preview img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 10px;
      border: 1px solid var(--color-border);
    }

    .file-preview-info { flex: 1; }

    .file-preview-name {
      font-size: 14px;
      font-weight: 500;
      color: var(--color-text-primary);
      margin-bottom: 2px;
      word-break: break-all;
    }

    .file-preview-size {
      font-size: 13px;
      color: var(--color-text-secondary);
      font-weight: 300;
    }

    .btn-remove-image {
      position: absolute;
      top: 0.75rem;
      right: 0.75rem;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      border: none;
      background: var(--color-error-light);
      color: var(--color-error);
      font-size: 14px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition-smooth);
      z-index: 3;
    }

    .btn-remove-image:hover {
      background: var(--color-error);
      color: white;
      transform: scale(1.1);
    }

    /* â”€â”€ Select + Add â”€â”€ */
    .select-with-add {
      display: flex;
      gap: 0.5rem;
      align-items: stretch;
    }

    .select-with-add .form-select { flex: 1; }

    .btn-add-inline {
      width: 44px;
      min-width: 44px;
      border: 1.5px solid var(--color-border);
      border-radius: 10px;
      background: var(--color-bg);
      color: var(--color-accent);
      font-size: 22px;
      font-weight: 300;
      cursor: pointer;
      transition: var(--transition-smooth);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .btn-add-inline:hover {
      border-color: var(--color-accent);
      background: var(--color-accent-light);
      color: var(--color-accent-hover);
      transform: scale(1.05);
    }

    /* â”€â”€ Checkbox Section â”€â”€ */
    .checkbox-section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
      gap: 1rem;
    }

    .checkbox-section-header .section-title {
      margin-bottom: 0;
      padding-bottom: 0;
      border-bottom: none;
      white-space: nowrap;
    }

    .search-inline {
      position: relative;
      flex: 1;
      max-width: 280px;
    }

    .search-inline input {
      width: 100%;
      padding: 0.6rem 1rem 0.6rem 2.25rem;
      border: 1.5px solid var(--color-border);
      border-radius: 8px;
      font-family: var(--font-body);
      font-size: 14px;
      background: var(--color-bg);
      transition: var(--transition-smooth);
      color: var(--color-text-primary);
    }

    .search-inline input:focus {
      outline: none;
      border-color: var(--color-accent);
      background: var(--color-surface);
      box-shadow: 0 0 0 3px rgba(184, 142, 93, 0.08);
    }

    .search-inline input::placeholder {
      color: var(--color-text-secondary);
      font-weight: 300;
    }

    .search-inline svg {
      position: absolute;
      left: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      color: var(--color-text-secondary);
      pointer-events: none;
    }

    .checkbox-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 0.5rem;
      max-height: 280px;
      overflow-y: auto;
      padding: 1rem;
      border: 1.5px solid var(--color-border);
      border-radius: 10px;
      background: var(--color-bg);
    }

    .checkbox-grid::-webkit-scrollbar { width: 5px; }
    .checkbox-grid::-webkit-scrollbar-track { background: transparent; }
    .checkbox-grid::-webkit-scrollbar-thumb { background: var(--color-border); border-radius: 3px; }
    .checkbox-grid::-webkit-scrollbar-thumb:hover { background: var(--color-text-secondary); }

    .checkbox-option {
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: var(--transition-smooth);
      padding: 0.45rem 0.6rem;
      border-radius: 6px;
      user-select: none;
    }

    .checkbox-option:hover { background: var(--color-surface); }
    .checkbox-option.hidden { display: none; }
    .checkbox-option input[type="checkbox"] { display: none; }

    .checkbox-custom {
      width: 18px;
      height: 18px;
      border: 1.5px solid var(--color-border);
      border-radius: 4px;
      margin-right: 0.6rem;
      position: relative;
      transition: var(--transition-smooth);
      flex-shrink: 0;
      background: var(--color-surface);
    }

    .checkbox-option:hover .checkbox-custom { border-color: var(--color-accent); }

    .checkbox-option input[type="checkbox"]:checked + .checkbox-custom {
      background: var(--color-accent);
      border-color: var(--color-accent);
    }

    .checkbox-option input[type="checkbox"]:checked + .checkbox-custom::after {
      content: '\2713';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-size: 11px;
      font-weight: 600;
    }

    .checkbox-label {
      font-size: 13px;
      color: var(--color-text-primary);
      font-weight: 400;
      line-height: 1.3;
    }

    .selection-count {
      font-size: 12px;
      color: var(--color-accent);
      font-weight: 500;
      padding: 0.25rem 0.6rem;
      background: var(--color-accent-light);
      border-radius: 12px;
      white-space: nowrap;
    }

    .btn-add-to-grid {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 0.75rem;
      border: 1.5px dashed var(--color-border);
      border-radius: 8px;
      background: transparent;
      color: var(--color-accent);
      font-family: var(--font-body);
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition-smooth);
      margin-top: 0.75rem;
    }

    .btn-add-to-grid:hover {
      border-color: var(--color-accent);
      background: var(--color-accent-light);
    }

    .btn-add-to-grid svg { width: 16px; height: 16px; }

    /* â”€â”€ Inline Add Form â”€â”€ */
    .inline-add-form {
      display: none;
      align-items: center;
      gap: 0.5rem;
      margin-top: 0.75rem;
      animation: slideDown 0.25s ease;
    }

    .inline-add-form.active { display: flex; }

    .inline-add-form input {
      flex: 1;
      padding: 0.6rem 0.85rem;
      border: 1.5px solid var(--color-accent);
      border-radius: 8px;
      font-family: var(--font-body);
      font-size: 14px;
      background: var(--color-surface);
      color: var(--color-text-primary);
      transition: var(--transition-smooth);
    }

    .inline-add-form input:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(184, 142, 93, 0.1);
    }

    .inline-add-form input::placeholder { color: var(--color-text-secondary); font-weight: 300; }

    .btn-inline-confirm {
      padding: 0.6rem 1rem;
      border: none;
      border-radius: 8px;
      background: var(--color-accent);
      color: white;
      font-family: var(--font-body);
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition-smooth);
      white-space: nowrap;
    }

    .btn-inline-confirm:hover { background: var(--color-accent-hover); }
    .btn-inline-confirm:disabled { opacity: 0.5; cursor: not-allowed; }

    .btn-inline-cancel {
      padding: 0.6rem;
      border: 1.5px solid var(--color-border);
      border-radius: 8px;
      background: transparent;
      color: var(--color-text-secondary);
      font-size: 14px;
      cursor: pointer;
      transition: var(--transition-smooth);
      display: flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      min-width: 36px;
    }

    .btn-inline-cancel:hover { border-color: var(--color-error); color: var(--color-error); }

    /* â”€â”€ Actions â”€â”€ */
    .form-actions {
      display: flex;
      gap: 1rem;
      margin-top: 2.5rem;
      padding-top: 2rem;
      border-top: 1px solid var(--color-border);
    }

    .btn-submit {
      flex: 1;
      padding: 1rem 2rem;
      background: var(--color-text-primary);
      color: var(--color-surface);
      border: none;
      border-radius: 10px;
      font-family: var(--font-body);
      font-size: 15px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition-smooth);
      letter-spacing: 0.5px;
    }

    .btn-submit:hover {
      background: var(--color-accent);
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }

    .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    .btn-reset {
      padding: 1rem 1.5rem;
      background: transparent;
      color: var(--color-text-secondary);
      border: 1.5px solid var(--color-border);
      border-radius: 10px;
      font-family: var(--font-body);
      font-size: 15px;
      font-weight: 400;
      cursor: pointer;
      transition: var(--transition-smooth);
    }

    .btn-reset:hover { border-color: var(--color-text-primary); color: var(--color-text-primary); }

    /* â”€â”€ Messages â”€â”€ */
    .message {
      margin-top: 1rem;
      padding: 1rem 1.25rem;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 500;
      letter-spacing: 0.3px;
      display: none;
      animation: slideDown 0.3s ease;
    }

    .message.success { display: block; background: var(--color-success-light); color: var(--color-success); border: 1px solid var(--color-success); }
    .message.error { display: block; background: var(--color-error-light); color: var(--color-error); border: 1px solid var(--color-error); }

    /* â”€â”€ Modal â”€â”€ */
    .modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: var(--color-overlay);
      z-index: 100;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(4px);
      animation: fadeIn 0.2s ease;
    }

    .modal-overlay.active { display: flex; }

    .modal-content {
      background: var(--color-surface);
      border-radius: 16px;
      padding: 2rem;
      width: 90%;
      max-width: 420px;
      box-shadow: var(--shadow-lg);
      animation: slideUp 0.3s ease;
    }

    .modal-title {
      font-family: var(--font-display);
      font-size: 20px;
      font-weight: 500;
      margin-bottom: 1.25rem;
    }

    .modal-actions {
      display: flex;
      gap: 0.75rem;
      margin-top: 1.5rem;
    }

    .modal-actions button {
      flex: 1;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      font-family: var(--font-body);
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition-smooth);
    }

    .btn-modal-cancel { border: 1.5px solid var(--color-border); background: transparent; color: var(--color-text-secondary); }
    .btn-modal-cancel:hover { border-color: var(--color-text-primary); color: var(--color-text-primary); }
    .btn-modal-confirm { border: none; background: var(--color-accent); color: white; }
    .btn-modal-confirm:hover { background: var(--color-accent-hover); }
    .btn-modal-confirm:disabled { opacity: 0.5; cursor: not-allowed; }

    /* â”€â”€ Toast â”€â”€ */
    .toast {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      padding: 0.85rem 1.25rem;
      border-radius: 10px;
      font-family: var(--font-body);
      font-size: 14px;
      font-weight: 500;
      color: white;
      background: var(--color-success);
      box-shadow: var(--shadow-md);
      z-index: 200;
      animation: toastIn 0.35s ease, toastOut 0.35s ease 2.5s forwards;
      pointer-events: none;
    }

    /* â”€â”€ Animations â”€â”€ */
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes toastIn { from { opacity: 0; transform: translateY(16px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
    @keyframes toastOut { from { opacity: 1; transform: translateY(0); } to { opacity: 0; transform: translateY(8px); } }

    /* â”€â”€ Responsive â”€â”€ */
    @media (max-width: 768px) {
      .container { padding: 2rem 1rem; }
      .header { flex-direction: column; align-items: flex-start; gap: 1rem; }
      .header h1 { font-size: 32px; }
      .form-card { padding: 2rem 1.5rem; }
      .form-grid { grid-template-columns: 1fr; }
      .checkbox-grid { grid-template-columns: repeat(2, 1fr); }
      .checkbox-section-header { flex-direction: column; align-items: flex-start; }
      .search-inline { max-width: 100%; }
    }

    @media (max-width: 480px) {
      .checkbox-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Nuevo Frasco</h1>
      <a href="/perfumes" class="btn-back">&#8592; Volver al Catálogo</a>
    </div>

    <div class="form-card">
      <form id="frasco-form">
        <div class="form-section">
          <h2 class="section-title">Información del Frasco</h2>
          
          <div class="form-grid">
            <div class="form-group">
              <label class="form-label">Nombre del Frasco</label>
              <input type="text" class="form-input" id="nombre" placeholder="Ej: Frasco Genérico 50ml" required />
            </div>
            <div class="form-group">
              <label class="form-label">Categoría</label>
              <input type="text" class="form-input" id="categoria" placeholder="Ej: generico, lujo..." value="generico" required />
            </div>
          </div>

          <div class="form-grid">
            <div class="form-group">
              <label class="form-label">Capacidad (ml)</label>
              <input type="number" class="form-input" id="capacidad_ml" placeholder="Ej: 50" min="1" />
            </div>
            <div class="form-group">
              <label class="form-label">Orden (Prioridad)</label>
              <input type="number" class="form-input" id="orden" placeholder="0" value="0" />
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Imagen del Frasco</label>
            <div class="file-upload-area" id="file-upload-area">
              <input type="file" class="file-input" id="imagen_file" accept="image/jpeg,image/jpg,image/png,image/webp" />
              <div class="file-upload-content" id="file-upload-content">
                <div class="file-upload-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                  </svg>
                </div>
                <p class="file-upload-text">Arrastra una imagen o haz click aquí</p>
                <p class="file-upload-formats">JPG, PNG o WebP · máx. 2MB</p>
              </div>
              <div class="file-preview" id="file-preview" style="display: none;">
                <img id="preview-image" src="" alt="Preview" />
                <div class="file-preview-info">
                  <p class="file-preview-name" id="file-preview-name"></p>
                  <p class="file-preview-size" id="file-preview-size"></p>
                </div>
                <button type="button" class="btn-remove-image" id="btn-remove-image" title="Quitar imagen">&#10005;</button>
              </div>
            </div>
            <p class="form-help">Opcional · Se guardará en /assets/images/frascos/</p>
          </div>

          <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea class="form-input" id="descripcion" rows="3" placeholder="Descripción breve del frasco..."></textarea>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn-reset" onclick="resetForm()">Limpiar</button>
          <button type="submit" class="btn-submit" id="btn-submit">Guardar Frasco</button>
        </div>
        <div class="message" id="message"></div>
      </form>
    </div>
  </div>

  <script>
    let selectedFile = null;
    const fileInput = document.getElementById('imagen_file');
    const fileUploadArea = document.getElementById('file-upload-area');
    const fileUploadContent = document.getElementById('file-upload-content');
    const filePreview = document.getElementById('file-preview');
    const previewImage = document.getElementById('preview-image');
    const btnRemoveImage = document.getElementById('btn-remove-image');

    function handleFile(file) {
      if (!file) return;
      if (file.size > 2 * 1024 * 1024) { showToast('La imagen debe ser menor a 2MB', true); return; }
      if (!file.type.match('image/(jpeg|jpg|png|webp)')) { showToast('Solo se permiten JPG, PNG o WebP', true); return; }
      selectedFile = file;
      const reader = new FileReader();
      reader.onload = (e) => {
        previewImage.src = e.target.result;
        document.getElementById('file-preview-name').textContent = file.name;
        document.getElementById('file-preview-size').textContent = formatSize(file.size);
        filePreview.style.display = 'flex';
        fileUploadContent.style.display = 'none';
      };
      reader.readAsDataURL(file);
    }

    function formatSize(bytes) {
      if (bytes < 1024) return bytes + ' B';
      if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
      return (bytes / 1048576).toFixed(1) + ' MB';
    }

    fileInput.addEventListener('change', (e) => handleFile(e.target.files[0]));
    ['dragenter', 'dragover'].forEach(ev => {
      fileUploadArea.addEventListener(ev, (e) => { e.preventDefault(); fileUploadArea.classList.add('drag-over'); });
    });
    ['dragleave', 'drop'].forEach(ev => {
      fileUploadArea.addEventListener(ev, (e) => { e.preventDefault(); fileUploadArea.classList.remove('drag-over'); });
    });
    fileUploadArea.addEventListener('drop', (e) => { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });

    btnRemoveImage.addEventListener('click', (e) => {
      e.stopPropagation();
      selectedFile = null;
      fileInput.value = '';
      previewImage.src = '';
      filePreview.style.display = 'none';
      fileUploadContent.style.display = 'flex';
    });

    function showToast(text, isError) {
      const existing = document.querySelector('.toast');
      if (existing) existing.remove();
      const toast = document.createElement('div');
      toast.className = 'toast';
      if (isError) toast.style.background = 'var(--color-error)';
      toast.textContent = text;
      document.body.appendChild(toast);
      setTimeout(() => toast.remove(), 3000);
    }

    function showMessage(text, type) {
      const msg = document.getElementById('message');
      msg.textContent = text;
      msg.className = 'message ' + type;
    }

    function hideMessage() { document.getElementById('message').className = 'message'; }

    function resetForm() {
      document.getElementById('frasco-form').reset();
      selectedFile = null;
      fileInput.value = '';
      previewImage.src = '';
      filePreview.style.display = 'none';
      fileUploadContent.style.display = 'flex';
      hideMessage();
    }

    document.getElementById('frasco-form').addEventListener('submit', async (e) => {
      e.preventDefault();
      hideMessage();
      const btnSubmit = document.getElementById('btn-submit');
      btnSubmit.disabled = true;
      btnSubmit.textContent = 'Guardando...';

      let rutaImagen = '';
      if (selectedFile) {
        try {
          const formData = new FormData();
          formData.append('image', selectedFile);
          const uploadResponse = await fetch('/api/frascos/upload-image', { method: 'POST', body: formData });
          let uploadData;
          try { uploadData = await uploadResponse.json(); } catch(e) {}
          if (!uploadResponse.ok) throw new Error((uploadData && uploadData.error) ? uploadData.error : 'Error interno al subir la imagen (Status: ' + uploadResponse.status + ')');
          if(uploadData && uploadData.error) throw new Error(uploadData.error);
          rutaImagen = uploadData.path || '';
        } catch (error) {
          showMessage('Error al subir la imagen: ' + error.message, 'error');
          btnSubmit.disabled = false;
          btnSubmit.textContent = 'Guardar Frasco';
          return;
        }
      }

      const payload = {
        nombre: document.getElementById('nombre').value.trim(),
        categoria: document.getElementById('categoria').value.trim(),
        capacidad_ml: document.getElementById('capacidad_ml').value ? Number(document.getElementById('capacidad_ml').value) : null,
        imagen: rutaImagen,
        descripcion: document.getElementById('descripcion').value.trim(),
        orden: document.getElementById('orden').value ? Number(document.getElementById('orden').value) : 0
      };

      try {
        const response = await fetch('/api/frascos', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
        const data = await response.json();
        if (data.ok) {
          showMessage('Frasco guardado correctamente · ID: ' + data.id, 'success');
          setTimeout(() => window.location.href = '/perfumes', 1200);
        } else {
          showMessage(data.error || 'Error al guardar el frasco', 'error');
          btnSubmit.disabled = false;
          btnSubmit.textContent = 'Guardar Frasco';
        }
      } catch (error) {
        showMessage('Error de conexión. Intenta nuevamente.', 'error');
        btnSubmit.disabled = false;
        btnSubmit.textContent = 'Guardar Frasco';
      }
    });
  </script>
</body>
</html>

