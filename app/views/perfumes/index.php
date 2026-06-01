<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BlooBelle · Catálogo de Perfumes</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="/assets/images/marca/favicon-2.png">
  <link rel="stylesheet" href="/assets/css/theme.css">
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
      --transition-spring: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
      
      --transition-spring: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-body);
      background: var(--color-bg);
      color: var(--color-text-primary);
      line-height: 1.6;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* Header */
    .header {
      background: var(--color-surface);
      border-bottom: 1px solid var(--color-border);
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 100;
      backdrop-filter: blur(10px);
      background: var(--color-surface);
    }

    .header-content {
      max-width: 1800px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 80px;
    }

    .logo {
      font-family: var(--font-display);
      font-size: 28px;
      font-weight: 500;
      letter-spacing: 1px;
      color: var(--color-text-primary);
      text-decoration: none;
      transition: var(--transition-smooth);
    }

    .logo:hover {
      color: var(--color-accent);
    }

    .nav-link {
      font-size: 14px;
      font-weight: 500;
      color: var(--color-text-secondary);
      text-decoration: none;
      transition: var(--transition-smooth);
      letter-spacing: 0.5px;
    }

    .nav-link:hover {
      color: var(--color-accent);
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .header-actions .actions {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-filters-mobile {
      display: none;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1.2rem;
      background: var(--color-text-primary);
      color: var(--color-surface);
      border: none;
      border-radius: 8px;
      font-family: var(--font-body);
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition-smooth);
      letter-spacing: 0.5px;
    }

    .btn-filters-mobile:hover {
      background: var(--color-accent);
      transform: translateY(-2px);
    }

    .btn-new {
      padding: 0.75rem 1.5rem;
      background: var(--color-accent);
      color: var(--color-surface);
      border: none;
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

    .btn-new:hover {
      background: var(--color-accent-hover);
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }

    /* Main Layout */
    .main-layout {
      max-width: 1800px;
      margin: 0 auto;
      display: flex;
      min-height: calc(100vh - 80px);
    }

    /* Sidebar */
    .sidebar {
      width: 380px;
      background: var(--color-surface);
      border-right: 1px solid var(--color-border);
      padding: 2.5rem 2rem;
      overflow-y: auto;
      position: sticky;
      top: 80px;
      height: calc(100vh - 80px);
      transition: var(--transition-smooth);
    }

    .sidebar-header {
      margin-bottom: 2.5rem;
      padding-bottom: 2rem;
      border-bottom: 1px solid var(--color-border);
    }

    .sidebar-title {
      font-family: var(--font-display);
      font-size: 32px;
      font-weight: 500;
      margin-bottom: 0.5rem;
      letter-spacing: 0.5px;
    }

    .sidebar-subtitle {
      font-size: 14px;
      color: var(--color-text-secondary);
      font-weight: 300;
      letter-spacing: 0.5px;
    }

    /* Search Box */
    .search-wrapper {
      margin-bottom: 2rem;
      position: relative;
    }

    .search-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--color-text-secondary);
      pointer-events: none;
    }

    .search-input {
      width: 100%;
      padding: 0.875rem 1rem 0.875rem 3rem;
      border: 1.5px solid var(--color-border);
      border-radius: 10px;
      font-family: var(--font-body);
      font-size: 15px;
      background: var(--color-bg);
      transition: var(--transition-smooth);
      color: var(--color-text-primary);
    }

    .search-input:focus {
      outline: none;
      border-color: var(--color-accent);
      background: var(--color-surface);
      box-shadow: 0 0 0 4px rgba(184, 142, 93, 0.1);
    }

    .search-input::placeholder {
      color: var(--color-text-secondary);
      font-weight: 300;
    }

    /* Filter Section */
    .filter-section {
      margin-bottom: 2rem;
      opacity: 0;
      animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .filter-section:nth-child(2) { animation-delay: 0.1s; }
    .filter-section:nth-child(3) { animation-delay: 0.2s; }
    .filter-section:nth-child(4) { animation-delay: 0.3s; }
    .filter-section:nth-child(5) { animation-delay: 0.4s; }
    .filter-section:nth-child(6) { animation-delay: 0.5s; }

    .filter-label {
      display: block;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--color-text-secondary);
      margin-bottom: 1rem;
      font-weight: 600;
    }

    .filter-options {
      display: flex;
      flex-direction: row;
      gap: 0.75rem;
      max-height: 240px;
      overflow-y: auto;
      padding-right: 0.5rem;
    }

    .filter-options::-webkit-scrollbar {
      width: 4px;
    }

    .filter-options::-webkit-scrollbar-thumb {
      background: var(--color-border);
      border-radius: 2px;
    }

    .filter-option {
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: var(--transition-smooth);
      padding: 0.25rem 0;
      position: relative;
    }

    .filter-option::before {
      content: '';
      position: absolute;
      left: -1rem;
      width: 2px;
      height: 0;
      background: var(--color-accent);
      transition: var(--transition-smooth);
    }

    .filter-option:hover::before {
      height: 100%;
    }

    .filter-option:hover {
      transform: translateX(6px);
    }

    .filter-option input[type="checkbox"] {
      display: none;
    }

    .checkbox-custom {
      width: 18px;
      height: 18px;
      border: 1.5px solid var(--color-border);
      border-radius: 4px;
      margin-right: 0.875rem;
      position: relative;
      transition: var(--transition-smooth);
      flex-shrink: 0;
      background: var(--color-surface);
    }

    .filter-option:hover .checkbox-custom {
      border-color: var(--color-accent);
    }

    .filter-option input[type="checkbox"]:checked + .checkbox-custom {
      background: var(--color-accent);
      border-color: var(--color-accent);
    }

    .filter-option input[type="checkbox"]:checked + .checkbox-custom::after {
      content: '✓';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-size: 11px;
      font-weight: 600;
    }

    .filter-option-text {
      font-size: 15px;
      color: var(--color-text-primary);
      font-weight: 400;
      letter-spacing: 0.3px;
    }

    /* Filter Actions */
    .filter-actions {
      display: flex;
      flex-direction: row;
      gap: 0.75rem;
      margin-top: 2rem;
      padding-top: 2rem;
      border-top: 1px solid var(--color-border);
    }

    .btn-apply, .btn-clear {
      width: 100%;
      padding: 0.875rem;
      border-radius: 8px;
      font-family: var(--font-body);
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition-smooth);
      letter-spacing: 0.5px;
      border: none;
    }

    .btn-apply {
      background: var(--color-text-primary);
      color: var(--color-surface);
    }

    .btn-apply:hover {
      background: var(--color-accent);
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }

    .btn-clear {
      background: transparent;
      color: var(--color-text-primary);
      border: 1.5px solid var(--color-border);
    }

    .btn-clear:hover {
      background: var(--color-bg);
      border-color: var(--color-text-primary);
    }

    /* Main Content */
    .main-content {
      flex: 1;
      padding: 2.5rem 2rem;
    }

    .content-header {
      margin-bottom: 2.5rem;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      gap: 1.5rem;
    }

    .content-info h1 {
      font-family: var(--font-display);
      font-size: 42px;
      font-weight: 500;
      margin-bottom: 0.5rem;
      letter-spacing: 0.5px;
      line-height: 1.2;
    }

    .results-meta {
      display: flex;
      align-items: center;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .results-count {
      font-size: 15px;
      color: var(--color-text-secondary);
      font-weight: 400;
      letter-spacing: 0.3px;
    }

    .results-count strong {
      color: var(--color-text-primary);
      font-weight: 600;
    }

    .filter-badges {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .filter-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.375rem 0.875rem;
      background: var(--color-accent);
      color: var(--color-surface);
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
      letter-spacing: 0.5px;
      animation: slideIn 0.3s ease-out;
    }

    /* Products Grid */
    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 2rem;
      transition: var(--transition-smooth);
    }

    /* Product Card - Layout Horizontal */
    .product-card {
      background: var(--color-surface);
      border-radius: 16px;
      overflow: hidden;
      cursor: pointer;
      border: 1px solid var(--color-border);
      display: flex;
      flex-direction: row;
      height: 100%;
      min-height: 180px;
      transition: var(--transition-smooth);
    }

    .product-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
      border-color: var(--color-accent);
    }

    .card-image {
      width: 140px;
      min-width: 140px;
      background: linear-gradient(135deg, #f5f3f0 0%, #e8e3dc 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .card-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .card-image-placeholder {
      font-size: 48px;
      opacity: 0.3;
    }

    .product-badge {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: var(--color-accent);
      padding: 0.4rem 0.875rem;
      border-radius: 8px;
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      font-weight: 600;
      color: var(--color-surface);
      z-index: 10;
    }

    .product-info {
      flex: 1;
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .product-designer {
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--color-accent);
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .product-name {
      font-family: var(--font-display);
      font-size: 20px;
      font-weight: 500;
      margin-bottom: 0.5rem;
      color: var(--color-text-primary);
      line-height: 1.3;
    }

    .product-description {
      font-size: 13px;
      color: var(--color-text-secondary);
      line-height: 1.5;
      margin-bottom: 0.75rem;
      display: -webkit-box;
      line-clamp: 2;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      flex: 1;
    }

    .product-code {
      font-size: 12px;
      color: var(--color-text-secondary);
      font-family: 'Courier New', monospace;
      padding-top: 0.75rem;
      border-top: 1px solid var(--color-border);
      opacity: 0.7;
    }

        /* Loading State */
    .loading-container {
      display: none;
      justify-content: center;
      align-items: center;
      padding: 4rem;
      grid-column: 1 / -1;
    }

    .loading-container.active {
      display: flex;
    }

    .loading-spinner {
      width: 50px;
      height: 50px;
      border: 3px solid var(--color-border);
      border-top-color: var(--color-accent);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    /* Empty State */
    .empty-state {
      grid-column: 1 / -1;
      text-align: center;
      padding: 6rem 2rem;
    }

    .empty-state-icon {
      font-size: 64px;
      margin-bottom: 1.5rem;
      opacity: 0.5;
    }

    .empty-state h3 {
      font-family: var(--font-display);
      font-size: 28px;
      font-weight: 500;
      margin-bottom: 0.75rem;
      color: var(--color-text-primary);
    }

    .empty-state p {
      font-size: 16px;
      color: var(--color-text-secondary);
      margin-bottom: 2rem;
    }

    /* Error State */
    .error-state {
      grid-column: 1 / -1;
      text-align: center;
      padding: 4rem 2rem;
    }

    .error-state-icon {
      font-size: 64px;
      margin-bottom: 1.5rem;
    }

    /* Overlay */
    .overlay {
      display: none;
      position: fixed;
      top: 70px;
      left: 0;
      right: 0;
      bottom: 0;
      background: var(--color-overlay);
      z-index: 90;
      backdrop-filter: blur(4px);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .overlay.active {
      display: block;
      opacity: 1;
    }

    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-10px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }
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

    /* Modal de Perfume (Prefijo pm-) */
    #pm-overlay {
      position: fixed; inset: 0; background: rgba(26,22,20,.5); backdrop-filter: blur(4px);
      display: flex; align-items: center; justify-content: center; padding: 1.2rem;
      opacity: 0; pointer-events: none; transition: opacity .22s; z-index: 1000;
    }
    #pm-overlay.open { opacity: 1; pointer-events: auto; }
    .pm-modal {
      background: var(--color-surface); border-radius: 22px; width: min(840px, 100%); max-height: 88vh;
      overflow: hidden; display: grid; grid-template-columns: 42% 1fr;
      transform: translateY(12px) scale(.985); transition: .24s; box-shadow: 0 30px 80px rgba(0,0,0,.28);
    }
    #pm-overlay.open .pm-modal { transform: none; }
    .pm-img {
      background: var(--color-bg); display: flex; align-items: center; justify-content: center; position: relative;
    }
    .pm-img .flower { font-size: 5rem; opacity: .5; }
    .pm-img img { width: 100%; height: 100%; object-fit: cover; }
    .pm-content { padding: 2rem 2rem 2.2rem; overflow-y: auto; position: relative; }
    .pm-close {
      position: absolute; top: 1rem; right: 1rem; width: 38px; height: 38px; border: none; border-radius: 50%;
      background: var(--color-bg); color: var(--color-text-primary); font-size: 1.3rem; cursor: pointer;
      display: grid; place-items: center; transition: .2s;
    }
    .pm-close:hover { background: var(--color-border); }
    .pm-top { display: flex; align-items: center; gap: .7rem; margin-bottom: .9rem; }
    .pm-badge {
      background: var(--color-accent); color: var(--color-on-accent); font-size: .64rem; letter-spacing: .12em; text-transform: uppercase;
      padding: .3rem .7rem; border-radius: 999px; font-weight: 500;
    }
    .pm-code {
      font-size: .74rem; letter-spacing: .08em; color: var(--color-text-secondary); background: var(--color-bg);
      padding: .25rem .6rem; border-radius: 6px;
    }
    .pm-marca { font-size: .78rem; letter-spacing: .16em; text-transform: uppercase; color: var(--color-accent); margin-bottom: .2rem; }
    .pm-name { font-family: var(--font-display); font-size: 2rem; font-weight: 500; line-height: 1.1; color: var(--color-text-primary); }
    .pm-div { height: 1px; background: var(--color-border); margin: 1.3rem 0; }
    .pm-section { margin-bottom: 1.3rem; }
    .pm-label { font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; color: var(--color-text-secondary); margin-bottom: .55rem; }
    .pm-desc { color: var(--color-text-primary); font-size: .96rem; line-height: 1.65; }
    .pm-chips { display: flex; flex-wrap: wrap; gap: .5rem; }
    .pm-chip { font-size: .82rem; padding: .4rem .8rem; border-radius: 999px; border: 1px solid var(--color-border); }
    .pm-chip.pm-aroma { background: #fbf6ef; border-color: #ecdcc4; color: #9a703f; }
    .pm-chip.pm-comp { background: var(--color-surface); color: var(--color-text-primary); }
    .pm-skeleton { background: #eee; border-color: #eee; width: 60px; height: 28px; animation: pm-pulse 1.5s infinite ease-in-out; }
    @keyframes pm-pulse { 0% { opacity: 0.5; } 50% { opacity: 1; } 100% { opacity: 0.5; } }
    .pm-footer { margin-top: .4rem; }
    .pm-edit {
      font-family: var(--font-body); font-size: .85rem; border: 1px solid var(--color-border);
      background: var(--color-surface); color: var(--color-text-primary); padding: .55rem 1rem; border-radius: 10px; cursor: pointer;
    }
    .pm-edit:hover { border-color: var(--color-accent); color: var(--color-accent); }
    @media(max-width:680px){
      .pm-modal { grid-template-columns: 1fr; max-height: 92vh; }
      .pm-img { min-height: 200px; }
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar {
        width: 320px;
      }

      .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
      }
    }

    @media (max-width: 768px) {
.logo {
        font-size: 22px;
      }

.btn-new,
      .nav-link,
      .user-chip,
      .btn-logout {
        display: none;
      }

      .sidebar {
        position: fixed;
        top: 70px;
        left: 0;
        height: calc(100vh - 70px);
        width: 85%;
        max-width: 360px;
        z-index: 100;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }

      .sidebar.active {
        transform: translateX(0);
      }


      .main-content {
        padding: 1.5rem 1rem;
      }

      .content-info h1 {
        font-size: 32px;
      }

      .products-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      
    }

    @media (max-width: 480px) {
      .content-info h1 {
        font-size: 28px;
color: var(--color-text-secondary);
      margin-bottom: 2rem;
    }

    /* Error State */
    .error-state {
      grid-column: 1 / -1;
      text-align: center;
      padding: 4rem 2rem;
    }

    .error-state-icon {
      font-size: 64px;
      margin-bottom: 1.5rem;
    }

    /* Overlay */
    .overlay {
      display: none;
      position: fixed;
      top: 70px;
      left: 0;
      right: 0;
      bottom: 0;
      background: var(--color-overlay);
      z-index: 90;
      backdrop-filter: blur(4px);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .overlay.active {
      display: block;
      opacity: 1;
    }

    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-10px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }
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

    /* Modal de Perfume (Prefijo pm-) */
    #pm-overlay {
      position: fixed; inset: 0; background: rgba(26,22,20,.5); backdrop-filter: blur(4px);
      display: flex; align-items: center; justify-content: center; padding: 1.2rem;
      opacity: 0; pointer-events: none; transition: opacity .22s; z-index: 1000;
    }
    #pm-overlay.open { opacity: 1; pointer-events: auto; }
    .pm-modal {
      background: var(--color-surface); border-radius: 22px; width: min(840px, 100%); max-height: 88vh;
      overflow: hidden; display: grid; grid-template-columns: 42% 1fr;
      transform: translateY(12px) scale(.985); transition: .24s; box-shadow: 0 30px 80px rgba(0,0,0,.28);
    }
    #pm-overlay.open .pm-modal { transform: none; }
    .pm-img {
      background: var(--color-bg); display: flex; align-items: center; justify-content: center; position: relative;
    }
    .pm-img .flower { font-size: 5rem; opacity: .5; }
    .pm-img img { width: 100%; height: 100%; object-fit: cover; }
    .pm-content { padding: 2rem 2rem 2.2rem; overflow-y: auto; position: relative; }
    .pm-close {
      position: absolute; top: 1rem; right: 1rem; width: 38px; height: 38px; border: none; border-radius: 50%;
      background: var(--color-bg); color: var(--color-text-primary); font-size: 1.3rem; cursor: pointer;
      display: grid; place-items: center; transition: .2s;
    }
    .pm-close:hover { background: var(--color-border); }
    .pm-top { display: flex; align-items: center; gap: .7rem; margin-bottom: .9rem; }
    .pm-badge {
      background: var(--color-accent); color: var(--color-on-accent); font-size: .64rem; letter-spacing: .12em; text-transform: uppercase;
      padding: .3rem .7rem; border-radius: 999px; font-weight: 500;
    }
    .pm-code {
      font-size: .74rem; letter-spacing: .08em; color: var(--color-text-secondary); background: var(--color-bg);
      padding: .25rem .6rem; border-radius: 6px;
    }
    .pm-marca { font-size: .78rem; letter-spacing: .16em; text-transform: uppercase; color: var(--color-accent); margin-bottom: .2rem; }
    .pm-name { font-family: var(--font-display); font-size: 2rem; font-weight: 500; line-height: 1.1; color: var(--color-text-primary); }
    .pm-div { height: 1px; background: var(--color-border); margin: 1.3rem 0; }
    .pm-section { margin-bottom: 1.3rem; }
    .pm-label { font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; color: var(--color-text-secondary); margin-bottom: .55rem; }
    .pm-desc { color: var(--color-text-primary); font-size: .96rem; line-height: 1.65; }
    .pm-chips { display: flex; flex-wrap: wrap; gap: .5rem; }
    .pm-chip { font-size: .82rem; padding: .4rem .8rem; border-radius: 999px; border: 1px solid var(--color-border); }
    .pm-chip.pm-aroma { background: #fbf6ef; border-color: #ecdcc4; color: #9a703f; }
    .pm-chip.pm-comp { background: var(--color-surface); color: var(--color-text-primary); }
    .pm-skeleton { background: #eee; border-color: #eee; width: 60px; height: 28px; animation: pm-pulse 1.5s infinite ease-in-out; }
    @keyframes pm-pulse { 0% { opacity: 0.5; } 50% { opacity: 1; } 100% { opacity: 0.5; } }
    .pm-footer { margin-top: .4rem; }
    .pm-edit {
      font-family: var(--font-body); font-size: .85rem; border: 1px solid var(--color-border);
      background: var(--color-surface); color: var(--color-text-primary); padding: .55rem 1rem; border-radius: 10px; cursor: pointer;
    }
    .pm-edit:hover { border-color: var(--color-accent); color: var(--color-accent); }
    @media(max-width:680px){
      .pm-modal { grid-template-columns: 1fr; max-height: 92vh; }
      .pm-img { min-height: 200px; }
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar {
        width: 320px;
      }

      .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
      }
    }

    @media (max-width: 768px) {
.logo {
        font-size: 22px;
      }

.btn-new,
      .nav-link,
      .user-chip,
      .btn-logout {
        display: none;
      }

      .sidebar {
        position: fixed;
        top: 70px;
        left: 0;
        height: calc(100vh - 70px);
        width: 85%;
        max-width: 360px;
        z-index: 100;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }

      .sidebar.active {
        transform: translateX(0);
      }


      .main-content {
        padding: 1.5rem 1rem;
      }

      .content-info h1 {
        font-size: 32px;
      }

      .products-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      
    }

    @media (max-width: 480px) {
      .content-info h1 {
        font-size: 28px;
      }

      .sidebar {
        width: 90%;
      }
    }
  </style>
</head>
<body>

  <?php $showFilters = true; $hideStoreSwitcher = true; include __DIR__ . '/../partials/app_header.php'; ?>

  <div class="main-layout">
    <!-- Sidebar Filters -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <h2 class="sidebar-title">Catálogo de Perfumes</h2>
        <p class="sidebar-subtitle">Explora nuestra colección</p>
      </div>

      <div class="search-wrapper">
        <span class="search-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
        </span>
        <input type="text" id="search-input" class="search-input" placeholder="Buscar por nombre, marca…">
      </div>

      <div class="filter-section">
        <label class="filter-label">Género</label>
        <div class="filter-options">
          <label class="filter-option">
            <input type="checkbox" name="genero[]" value="Mujer">
            <span class="checkbox-custom"></span>
            <span class="filter-option-text">Mujer</span>
          </label>
          <label class="filter-option">
            <input type="checkbox" name="genero[]" value="Hombre">
            <span class="checkbox-custom"></span>
            <span class="filter-option-text">Hombre</span>
          </label>
          <label class="filter-option">
            <input type="checkbox" name="genero[]" value="Unisex">
            <span class="checkbox-custom"></span>
            <span class="filter-option-text">Unisex</span>
          </label>
        </div>
      </div>

      <div class="filter-actions">
        <button class="btn-apply" id="btn-apply">Aplicar</button>
        <button class="btn-clear" id="btn-clear">Limpiar</button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <div class="content-header">
        <div class="content-info">
          <h1>Catálogo de Perfumes</h1>
          <div class="results-meta">
            <p class="results-count">
              Mostrando <strong id="results-number"><?= count($productos) ?></strong> perfumes
            </p>
            <div class="filter-badges" id="filter-badges"></div>
          </div>
        </div>
      </div>

      <div class="products-grid" id="products-grid">
        <!-- Loading State -->
        <div class="loading-container" id="loading">
          <div class="loading-spinner"></div>
        </div>

        <!-- Products (Initial Load) -->
        <?php foreach ($productos as $p): ?>
          <div class="product-card" data-id="<?= $p['id'] ?>" tabindex="0" role="button" aria-label="Ver detalle de <?= htmlspecialchars($p['referencia']) ?>">
            <div class="card-image">
              <?php if (!empty($p['ruta_img'])): ?>
                <img src="<?= htmlspecialchars($p['ruta_img']) ?>" alt="<?= htmlspecialchars($p['referencia']) ?>" />
              <?php else: ?>
                <span class="card-image-placeholder"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="32" height="32" style="opacity:0.5"><path d="M9 2h6v3l1 2v12a2 2 0 01-2 2H10a2 2 0 01-2-2V7l1-2V2z"/><path d="M9 11h6"/></svg></span>
              <?php endif; ?>
            </div>
            <div class="product-info">
              <span class="product-badge"><?= htmlspecialchars($p['genero']) ?></span>
              <div class="product-designer"><?= htmlspecialchars($p['marca']) ?></div>
              <h3 class="product-name"><?= htmlspecialchars($p['referencia']) ?></h3>
              <?php if (!empty($p['descripcion'])): ?>
                <p class="product-description"><?= htmlspecialchars($p['descripcion']) ?></p>
              <?php endif; ?>
              <p class="product-code"><?= htmlspecialchars($p['codigo']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </main>
  </div><!-- /.main-layout -->

  <script>
    window.__perfumes = {};
    <?php foreach ($productos as $p): ?>
      window.__perfumes[<?= $p['id'] ?>] = <?= json_encode($p) ?>;
    <?php endforeach; ?>

    class CatalogManager {
      constructor() {
        this.init();
      }

      init() {
        this.setupEventListeners();
        this.loadFiltersFromURL();
      }

      setupEventListeners() {
        // Shared panels logic
        const overlay = document.getElementById('overlay');
        const sidebar = document.getElementById('sidebar');
        const navDrawer = document.getElementById('nav-drawer');

        const closePanels = () => {
          sidebar?.classList.remove('active');
          navDrawer?.classList.remove('open');
          navDrawer?.setAttribute('aria-hidden', 'true');
          overlay?.classList.remove('active');
          document.body.style.overflow = '';
        };

        // Sidebar (Filters)
        document.getElementById('btn-toggle-filters')?.addEventListener('click', () => {
          closePanels();
          sidebar?.classList.add('active');
          overlay?.classList.add('active');
          document.body.style.overflow = 'hidden';
        });

        // Nav Drawer (Menu)
        document.getElementById('btn-menu')?.addEventListener('click', () => {
          closePanels();
          navDrawer?.classList.add('open');
          navDrawer?.setAttribute('aria-hidden', 'false');
          overlay?.classList.add('active');
          document.body.style.overflow = 'hidden';
          document.getElementById('btn-menu-close')?.focus();
        });

        document.getElementById('btn-menu-close')?.addEventListener('click', closePanels);
        overlay?.addEventListener('click', closePanels);
        document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape') closePanels();
        });

        const grid = document.getElementById('products-grid');
        if (grid) {
          grid.addEventListener('click', (e) => {
            const card = e.target.closest('.product-card');
            if (card && card.dataset.id) openModalPerfume(card.dataset.id, card);
          });
          grid.addEventListener('keydown', (e) => {
            const card = e.target.closest('.product-card');
            if (card && card.dataset.id && (e.key === 'Enter' || e.key === ' ')) {
              e.preventDefault();
              openModalPerfume(card.dataset.id, card);
            }
          });
        }

        // Apply filters
        document.getElementById('btn-apply')?.addEventListener('click', async () => {
          await this.applyFilters();
          closePanels();
        });

        // Clear filters
        document.getElementById('btn-clear')?.addEventListener('click', () => {
          this.clearFilters();
        });

        // Search with debounce
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
          searchInput.addEventListener('input', this.debounce(() => {
            this.applyFilters();
          }, 500));
        }

        // Auto-apply on checkbox change
        document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(cb => {
          cb.addEventListener('change', () => {
            this.updateFilterBadges();
          });
        });
      }


      async applyFilters() {
        this.showLoading(true);

        const payload = {
          genero: this.getCheckedValues('genero[]'),
          search: document.getElementById('search-input')?.value.trim() || ''
        };

        try {
          const response = await fetch('/api/perfumes/filter', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
          });

          if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
          }

          const data = await response.json();
          
          this.renderProducts(data);
          this.updateResultsCount(data.length);
          this.updateFilterBadges();
          this.updateURL(payload);

        } catch (error) {
          console.error('Error al filtrar:', error);
          this.showError('No se pudieron cargar los productos. Por favor, intenta nuevamente.');
        } finally {
          this.showLoading(false);
        }
      }

      renderProducts(productos) {
        const grid = document.getElementById('products-grid');
        const loading = document.getElementById('loading');

        // Clear except loading
        Array.from(grid.children).forEach(child => {
          if (child !== loading) {
            child.remove();
          }
        });

        if (!productos.length) {
          grid.insertAdjacentHTML('beforeend', `
            <div class="empty-state">
              <div class="empty-state-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="64" height="64"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg></div>
              <h3>No encontramos perfumes</h3>
              <p>Intenta ajustar los filtros o la búsqueda</p>
              <button onclick="catalogManager.clearFilters()" class="btn-new">
                Limpiar Filtros
              </button>
            </div>
          `);
          return;
        }

        // Add products with staggered animation
        productos.forEach((p, index) => {
          window.__perfumes[p.id] = p;
          const card = this.createProductCard(p);
          card.style.animationDelay = `${index * 0.05}s`;
          grid.appendChild(card);
        });
      }

      createProductCard(p) {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.setAttribute('data-id', p.id);
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'button');
        card.setAttribute('aria-label', `Ver detalle de ${this.escapeHtml(p.referencia)}`);
        
        const imagen = p.ruta_img 
          ? `<img src="${this.escapeHtml(p.ruta_img)}" alt="${this.escapeHtml(p.referencia)}" />`
          : `<span class="card-image-placeholder"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="32" height="32" style="opacity:0.5"><path d="M9 2h6v3l1 2v12a2 2 0 01-2 2H10a2 2 0 01-2-2V7l1-2V2z"/><path d="M9 11h6"/></svg></span>`;
        
        const descripcion = p.descripcion 
          ? `<p class="product-description">${this.escapeHtml(p.descripcion)}</p>`
          : '';
        
        card.innerHTML = `
          <div class="card-image">
            ${imagen}
          </div>
          <div class="product-info">
            <span class="product-badge">${this.escapeHtml(p.genero)}</span>
            <div class="product-designer">${this.escapeHtml(p.marca)}</div>
            <h3 class="product-name">${this.escapeHtml(p.referencia)}</h3>
            ${descripcion}
            <p class="product-code">${this.escapeHtml(p.codigo)}</p>
          </div>
        `;
        return card;
      }

      showLoading(show) {
        const loading = document.getElementById('loading');
        const grid = document.getElementById('products-grid');

        if (show) {
          loading.classList.add('active');
          grid.style.opacity = '0.5';
        } else {
          loading.classList.remove('active');
          grid.style.opacity = '1';
        }
      }

      showError(message) {
        const grid = document.getElementById('products-grid');
        const loading = document.getElementById('loading');

        Array.from(grid.children).forEach(child => {
          if (child !== loading) {
            child.remove();
          }
        });

        grid.insertAdjacentHTML('beforeend', `
          <div class="error-state">
            <div class="error-state-icon">⚠️</div>
            <h3 style="font-family: var(--font-display); font-size: 24px; margin-bottom: 0.5rem;">Error</h3>
            <p style="color: var(--color-text-secondary);">${message}</p>
          </div>
        `);
      }

      updateResultsCount(count) {
        const counter = document.getElementById('results-number');
        if (counter) {
          counter.textContent = count;
        }
      }

      updateFilterBadges() {
        const container = document.getElementById('filter-badges');
        const activeFilters = document.querySelectorAll('.filter-option input[type="checkbox"]:checked');
        
        container.innerHTML = '';
        
        if (activeFilters.length > 0) {
          const badge = document.createElement('div');
          badge.className = 'filter-badge';
          badge.textContent = `${activeFilters.length} filtro${activeFilters.length > 1 ? 's' : ''} activo${activeFilters.length > 1 ? 's' : ''}`;
          container.appendChild(badge);
        }
      }

      clearFilters() {
        document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(cb => {
          cb.checked = false;
        });
        
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
          searchInput.value = '';
        }

        this.applyFilters();
        window.history.replaceState({}, '', window.location.pathname);
      }

      updateURL(filters) {
        const params = new URLSearchParams();
        
        if (filters.genero.length) params.set('genero', filters.genero.join(','));
        if (filters.search) params.set('q', filters.search);

        const newURL = params.toString() ? `?${params.toString()}` : window.location.pathname;
        window.history.replaceState({}, '', newURL);
      }

      loadFiltersFromURL() {
        const params = new URLSearchParams(window.location.search);
        
        const genero = params.get('genero')?.split(',').filter(Boolean) || [];
        genero.forEach(val => {
          const cb = document.querySelector(`input[name="genero[]"][value="${val}"]`);
          if (cb) cb.checked = true;
        });

        const search = params.get('q') || '';
        const searchInput = document.getElementById('search-input');
        if (searchInput && search) {
          searchInput.value = search;
        }

        if (genero.length || search) {
          this.applyFilters();
        } else {
          this.updateFilterBadges();
        }
      }

      // Utilities
      getCheckedValues(name) {
        return Array.from(document.querySelectorAll(`input[name="${name}"]:checked`))
          .map(el => el.value);
      }

      escapeHtml(str) {
        return String(str)
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/'/g, '&#039;');
      }

      debounce(func, wait) {
        let timeout;
        return function(...args) {
          clearTimeout(timeout);
          timeout = setTimeout(() => func.apply(this, args), wait);
        };
      }
    }

    // Initialize
    let catalogManager;
    document.addEventListener('DOMContentLoaded', () => {
      catalogManager = new CatalogManager();
    });
  </script>


<div class="overlay" id="pm-overlay" role="dialog" aria-modal="true" aria-labelledby="pm-name">
  <div class="pm-modal">
    <div class="pm-img" id="pm-img"></div>
    <div class="pm-content">
      <button class="pm-close" id="pm-close" aria-label="Cerrar">✕</button>
      <div class="pm-top">
        <span class="pm-badge" id="pm-badge"></span>
        <span class="pm-code" id="pm-code"></span>
      </div>
      <div class="pm-marca" id="pm-marca"></div>
      <h2 class="pm-name" id="pm-name"></h2>
      <div class="pm-div"></div>
      <div class="pm-section">
        <div class="pm-label">Descripción</div>
        <p class="pm-desc" id="pm-desc"></p>
      </div>
      <div class="pm-section" id="pm-aromas-sec">
        <div class="pm-label">Tipo de fragancia</div>
        <div class="pm-chips" id="pm-aromas"></div>
      </div>
      <div class="pm-section" id="pm-comps-sec">
        <div class="pm-label">Componentes / notas</div>
        <div class="pm-chips" id="pm-comps"></div>
      </div>
      <?php if ($user !== null && $user['rol'] === 'admin'): ?>
      <div class="pm-footer">
        <button class="pm-edit" id="pm-edit">✎ Editar perfume</button>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
let pmLastFocus = null;
const pmOverlay = document.getElementById('pm-overlay');

async function openModalPerfume(id, card) {
  const p = window.__perfumes[id];
  if(!p) return;
  
  pmLastFocus = card || document.activeElement;
  
  document.getElementById('pm-badge').textContent = p.genero;
  document.getElementById('pm-code').textContent = p.codigo;
  document.getElementById('pm-marca').textContent = p.marca;
  document.getElementById('pm-name').textContent = p.referencia;
  document.getElementById('pm-desc').textContent = p.descripcion || 'Sin descripción disponible.';
  
  const imgContainer = document.getElementById('pm-img');
  if (p.ruta_img) {
      imgContainer.innerHTML = `<img src="${p.ruta_img}" alt="${p.referencia}">`;
  } else {
      imgContainer.innerHTML = `<span class="flower">🌸</span>`;
  }
  
  // Skeleton
  const skeletonHTML = '<span class="pm-chip pm-skeleton" style="width:70px"></span><span class="pm-chip pm-skeleton" style="width:90px"></span><span class="pm-chip pm-skeleton" style="width:60px"></span>';
  document.getElementById('pm-aromas').innerHTML = skeletonHTML;
  document.getElementById('pm-comps').innerHTML = skeletonHTML;
  document.getElementById('pm-aromas-sec').style.display = 'block';
  document.getElementById('pm-comps-sec').style.display = 'block';
  
  pmOverlay.classList.add('open');
  document.body.style.overflow = 'hidden';
  document.getElementById('pm-close').focus();
  
  const btnEdit = document.getElementById('pm-edit');
  if (btnEdit) {
      btnEdit.onclick = () => window.location.href = `/catalogo/perfumes/editar?id=${id}`;
  }
  
  try {
      const res = await fetch('/api/perfumes/detalle', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: id })
      });
      const data = await res.json();
      if(res.ok && !data.error) {
          const aromas = data.tipos_aroma || [];
          const comps = data.componentes || [];
          
          if(aromas.length > 0) {
              document.getElementById('pm-aromas').innerHTML = aromas.map(a => `<span class="pm-chip pm-aroma">${a.nombre}</span>`).join('');
          } else {
              document.getElementById('pm-aromas-sec').style.display = 'none';
          }
          
          if(comps.length > 0) {
              document.getElementById('pm-comps').innerHTML = comps.map(c => `<span class="pm-chip pm-comp">${c.nombre}</span>`).join('');
          } else {
              document.getElementById('pm-comps-sec').style.display = 'none';
          }
      } else {
          throw new Error(data.error);
      }
  } catch (e) {
      document.getElementById('pm-aromas').innerHTML = '<span style="font-size:0.8rem; color:var(--color-error)">No se pudo cargar.</span>';
      document.getElementById('pm-comps').innerHTML = '<span style="font-size:0.8rem; color:var(--color-error)">No se pudo cargar.</span>';
  }
}

function closeModalPerfume() {
    pmOverlay.classList.remove('open');
    document.body.style.overflow = '';
    if(pmLastFocus) pmLastFocus.focus();
}

document.getElementById('pm-close')?.addEventListener('click', closeModalPerfume);
pmOverlay?.addEventListener('click', e => { if (e.target === pmOverlay) closeModalPerfume(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape' && pmOverlay?.classList.contains('open')) closeModalPerfume(); });
</script>


</body>
</html>
