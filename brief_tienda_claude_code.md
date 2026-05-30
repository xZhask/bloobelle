# BlooBelle — Módulo "Tienda por ciudad" (ventas + stock de frascos)

Brief de implementación para Claude Code. Respeta la arquitectura actual:
PHP sin framework, autoload PSR-4 `App\`, `Router` de match exacto (GET/POST),
`Database` (PDO singleton MySQL), `Request::json()`, `Response::json()`.
No introducir composer deps ni frameworks. Mantener el lenguaje visual de las
vistas (Playfair Display + Jost, paleta beige/dorado del `index.php`).

## Idea central del negocio (leer primero)
- Lo que tiene stock es el **frasco vacío** (por tamaño). El perfume se vierte al
  momento de la venta; NO se inventaría "perfume embotellado".
- Por tanto el **stock se controla por frasco** (30/50/100 ml), por sucursal.
- La venta **registra qué perfume** se llenó (solo para el reporte de fragancias
  más vendidas) y **qué frasco** (eso fija el precio y descuenta stock).
- El **precio depende del frasco y de la sucursal** (puede variar por ciudad),
  nunca del perfume.
- Uso **100% móvil**: en las sucursales no hay computadoras. UI mobile-first.

---

## 0. Decisión: usar usuarios (login simple), NO rutas libres por perfil
- La app está en producción en dominio público: sin login, cualquiera con la URL
  registra/ve ventas y stock.
- Se necesita saber quién registró cada venta → `vendedor_id` por venta.
- Aunque haya **una sola vendedora por sucursal**, la credencial debe pertenecer
  a una *persona asignada a una sucursal*, no a la sucursal. Así, si cambia la
  vendedora, se desactiva su usuario y se crea otro sin perder historial ni
  compartir un secreto con quien se fue. Un usuario por sucursal es el caso normal.
- Login mínimo: sesión PHP nativa, `usuario` + contraseña (sin email), 2 roles.

Permisos por rol:
- `vendedor`: registrar venta, ver stock, ver reporte del día.
- `admin`: todo lo anterior + **registrar entradas de stock**, crear frascos,
  fijar/cambiar precios por sucursal, ajustes de stock, y gestionar el catálogo
  de perfumes. (Por ahora SOLO el admin registra el ingreso de frascos.)

---

## 1. Migración SQL
Ejecutar sobre la BD `bloobelle` (MySQL/InnoDB, utf8mb4). No altera las tablas
existentes salvo nuevas FKs hacia `perfumes`.

```sql
-- 1.1 Usuarios (login: usuario + contraseña; 1 por sucursal)
CREATE TABLE usuarios (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  nombre        VARCHAR(120) NOT NULL,
  usuario       VARCHAR(60)  NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol           ENUM('admin','vendedor') NOT NULL DEFAULT 'vendedor',
  sucursal_id   INT NULL,
  activo        TINYINT(1) NOT NULL DEFAULT 1,
  creado_en     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 1.2 Sucursales / ciudades (catálogo de perfumes es global; stock/ventas son por sucursal)
CREATE TABLE sucursales (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  ciudad VARCHAR(80) NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE usuarios
  ADD CONSTRAINT fk_usuarios_sucursal FOREIGN KEY (sucursal_id) REFERENCES sucursales(id);

-- 1.3 Frascos = catálogo de envases (la unidad que se inventaría). SIN precio aquí.
-- Hay 10+ tipos: genéricos y de diseño (Corazón, París, Cámara…), cada uno con
-- su imagen, descripción y precio propio. Ya NO se identifican por tamaño.
CREATE TABLE frascos (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  nombre       VARCHAR(80) NOT NULL,                 -- "Genérico 50 ml", "Corazón", "París"
  categoria    ENUM('generico','diseno') NOT NULL DEFAULT 'generico',
  capacidad_ml INT NULL,                             -- opcional (no todo diseño tiene ml estándar)
  imagen       VARCHAR(255) NULL,                    -- /assets/images/frascos/...
  descripcion  VARCHAR(255) NULL,
  orden        INT NOT NULL DEFAULT 0,               -- orden manual dentro de la categoría
  activo       TINYINT(1) NOT NULL DEFAULT 1,
  KEY idx_frasco_cat (categoria, orden)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- Orden de listado: genéricos primero, luego diseño:
--   ORDER BY (categoria='diseno') ASC, orden ASC, nombre ASC

-- 1.4 Precio por frasco y sucursal (puede variar por ciudad)
CREATE TABLE precios (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  sucursal_id INT NOT NULL,
  frasco_id   INT NOT NULL,
  precio      DECIMAL(10,2) NOT NULL,
  UNIQUE KEY uq_precio (sucursal_id, frasco_id),
  CONSTRAINT fk_precio_sucursal FOREIGN KEY (sucursal_id) REFERENCES sucursales(id),
  CONSTRAINT fk_precio_frasco   FOREIGN KEY (frasco_id)   REFERENCES frascos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 1.5 Stock de frascos vacíos por sucursal
CREATE TABLE stock (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  sucursal_id INT NOT NULL,
  frasco_id   INT NOT NULL,
  cantidad    INT NOT NULL DEFAULT 0,
  umbral_bajo INT NOT NULL DEFAULT 5,
  UNIQUE KEY uq_stock (sucursal_id, frasco_id),
  CONSTRAINT fk_stock_sucursal FOREIGN KEY (sucursal_id) REFERENCES sucursales(id),
  CONSTRAINT fk_stock_frasco   FOREIGN KEY (frasco_id)   REFERENCES frascos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 1.6 Ventas (cabecera) + ítems (varios frascos por venta)
CREATE TABLE ventas (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  sucursal_id INT NOT NULL,
  vendedor_id INT NOT NULL,
  fecha       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  total       DECIMAL(10,2) NOT NULL DEFAULT 0,
  metodo_pago ENUM('efectivo','yape_plin','tarjeta','otro') NOT NULL DEFAULT 'efectivo',
  nota        VARCHAR(255) NULL,
  KEY idx_ventas_fecha (fecha),
  KEY idx_ventas_suc_fecha (sucursal_id, fecha),
  CONSTRAINT fk_ventas_sucursal FOREIGN KEY (sucursal_id) REFERENCES sucursales(id),
  CONSTRAINT fk_ventas_vendedor FOREIGN KEY (vendedor_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- perfume_id = qué fragancia se llenó (informativo, para reporte).
-- frasco_id  = fija precio y descuenta stock.
CREATE TABLE venta_items (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  venta_id        INT NOT NULL,
  perfume_id      INT NOT NULL,
  frasco_id       INT NOT NULL,
  cantidad        INT NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,   -- copia del precio vigente al vender
  subtotal        DECIMAL(10,2) NOT NULL,
  CONSTRAINT fk_items_venta   FOREIGN KEY (venta_id)   REFERENCES ventas(id) ON DELETE CASCADE,
  CONSTRAINT fk_items_perfume FOREIGN KEY (perfume_id) REFERENCES perfumes(id),
  CONSTRAINT fk_items_frasco  FOREIGN KEY (frasco_id)  REFERENCES frascos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 1.7 Movimientos de stock (bitácora). 'devolucion' queda reservado para el futuro,
--     NO se implementa el flujo todavía (solo dejar el valor en el ENUM).
CREATE TABLE movimientos_stock (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  sucursal_id INT NOT NULL,
  frasco_id   INT NOT NULL,
  tipo        ENUM('entrada','ajuste','venta','devolucion') NOT NULL,
  cantidad    INT NOT NULL,   -- + entrada/devolución, − venta/ajuste a la baja
  motivo      VARCHAR(160) NULL,
  usuario_id  INT NULL,
  venta_id    INT NULL,
  fecha       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_mov_fecha (fecha),
  CONSTRAINT fk_mov_sucursal FOREIGN KEY (sucursal_id) REFERENCES sucursales(id),
  CONSTRAINT fk_mov_frasco   FOREIGN KEY (frasco_id)   REFERENCES frascos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 1.8 Semilla mínima
INSERT INTO sucursales (nombre, ciudad) VALUES ('Tienda Arequipa', 'Arequipa');
INSERT INTO frascos (nombre, categoria, capacidad_ml, descripcion, orden) VALUES
  ('Genérico 30 ml','generico',30,'Frasco atomizador estándar',1),
  ('Genérico 50 ml','generico',50,'Frasco atomizador estándar',2),
  ('Genérico 100 ml','generico',100,'Frasco atomizador estándar',3),
  ('Corazón','diseno',50,'Frasco decorativo en forma de corazón',1),
  ('París','diseno',75,'Frasco edición París, estilo torre',2),
  ('Cámara','diseno',60,'Frasco con diseño tipo cámara',3);
-- precio por (sucursal, frasco): los de diseño cuestan más que los genéricos
INSERT INTO precios (sucursal_id, frasco_id, precio) VALUES
  (1,1,45.00),(1,2,69.00),(1,3,110.00),(1,4,95.00),(1,5,120.00),(1,6,105.00);
INSERT INTO stock (sucursal_id, frasco_id, cantidad) VALUES
  (1,1,0),(1,2,0),(1,3,0),(1,4,0),(1,5,0),(1,6,0);
-- Usuarios con hash real generado por PHP (ver nota abajo):
-- INSERT INTO usuarios (nombre,usuario,password_hash,rol,sucursal_id) VALUES ('Admin','admin','<HASH>','admin',NULL);
-- INSERT INTO usuarios (nombre,usuario,password_hash,rol,sucursal_id) VALUES ('Lucía','arequipa','<HASH>','vendedor',1);
```
> Nunca insertar contraseñas en texto plano. Generar el hash con
> `password_hash('clave', PASSWORD_DEFAULT)` en un script PHP de una sola vez.

---

## 2. Autenticación (sesión nativa)
`app/core/Auth.php` (nuevo): `login(array $u)`, `user()`, `check()`,
`requireLogin()` (redirige a `/login` en páginas, 401 JSON en API),
`requireRole(string ...$roles)` (403 si no coincide), `logout()`.
En `public/index.php`: agregar `session_start();` antes del router.
Guardia al inicio de cada acción protegida (el Router es de match exacto, sin
middleware): `Auth::requireLogin();` o `Auth::requireRole('admin');`.

---

## 3. Rutas nuevas
`routes/web.php` (GET; el Router ya limpia prefijos `/public` y `/bloobelle`):
```php
$router->get('/login',          [AuthController::class,'showLogin']);
$router->get('/logout',         [AuthController::class,'logout']);
$router->get('/tienda',         [TiendaController::class,'dashboard']);   // POS móvil
$router->get('/tienda/stock',   [StockController::class,'page']);
$router->get('/tienda/reporte', [VentaController::class,'reportePage']);
```
`routes/api.php` (POST JSON):
```php
$router->post('/api/auth/login',      [AuthController::class,'login']);
$router->post('/api/frascos',         [FrascoController::class,'store']);          // admin
$router->post('/api/frascos/upload-image',[FrascoController::class,'uploadImage']); // admin (igual que perfumes)
$router->post('/api/precios',         [FrascoController::class,'fijarPrecio']);    // admin: (sucursal,frasco,precio)
$router->post('/api/perfumes/buscar', [VentaController::class,'buscarPerfume']);   // buscador del POS
$router->post('/api/stock',           [StockController::class,'listar']);          // por sucursal
$router->post('/api/stock/entrada',   [StockController::class,'entrada']);         // SOLO admin
$router->post('/api/stock/ajuste',    [StockController::class,'ajuste']);          // admin
$router->post('/api/ventas',          [VentaController::class,'store']);
$router->post('/api/ventas/reporte',  [VentaController::class,'reporte']);
```
Registrar las nuevas clases en `$coreFiles` de `public/index.php` (o ampliar el
autoload para que tome controllers/repositories solos).

---

## 4. Controladores y repositorios (espejando PerfumeController/Repository)
- `AuthController`: `login({usuario,password})` valida con `password_verify`.
- `FrascoController` + `FrascoRepository` (admin):
  - `store({nombre,categoria,capacidad_ml,imagen,descripcion,orden})` alta de envase.
    `categoria` ∈ {`generico`,`diseno`}.
  - `uploadImage()` idéntico al de perfumes pero guardando en
    `/public/assets/images/frascos`; devuelve la ruta para el campo `imagen`.
  - `fijarPrecio({sucursal_id,frasco_id,precio})` UPSERT en `precios`. Afecta
    ventas futuras; las pasadas conservan su `precio_unitario`.
- `StockController` + `StockRepository`:
  - `listar({sucursal_id})` → por frasco: `nombre`, `categoria`, `imagen`,
    `descripcion`, `capacidad_ml`, `cantidad`, `umbral_bajo`, `precio` (JOIN
    `precios`), flag `bajo = cantidad <= umbral_bajo`. **Orden: genéricos primero,
    luego diseño** → `ORDER BY (categoria='diseno') ASC, orden ASC, nombre ASC`.
    (LEFT JOIN a `stock` para que un frasco sin movimientos aparezca con cantidad 0.)
    Este mismo endpoint alimenta el selector de frascos del POS.
  - `entrada({sucursal_id,frasco_id,cantidad,motivo})` (SOLO admin): suma a `stock`
    (UPSERT por `uq_stock`) + `movimientos_stock` tipo `entrada`. El admin indica
    la sucursal (no tiene sucursal fija).
  - `ajuste({frasco_id,cantidad,motivo})` (admin): corrige cantidad + movimiento `ajuste`.
- `VentaController` + `VentaRepository`:
  - `buscarPerfume({q})` → perfumes del catálogo que matchean (referencia/código/marca).
  - `store({metodo_pago,nota,items:[{perfume_id,frasco_id,cantidad}]})`, **en una
    transacción**:
    1. `vendedor_id` y `sucursal_id` desde la sesión, no del cliente.
    2. por ítem: `SELECT ... FOR UPDATE` sobre `stock` (sucursal,frasco); validar
       `cantidad <= disponible` (si no → rollback + error claro); leer precio de
       `precios` (sucursal,frasco); `subtotal = cantidad * precio`.
    3. insertar `ventas` (con `total`) y `venta_items` (guardando `precio_unitario`).
    4. descontar `stock.cantidad` del frasco + `movimientos_stock` tipo `venta`
       (negativo, con `venta_id`).
    5. commit → `{ok:true, venta_id, total}`.
  - `reporte({sucursal_id?, desde?, hasta?})` (por defecto hoy; `sucursal_id` de
    la sesión si es vendedor): nº de ventas, frascos vendidos `SUM(venta_items.cantidad)`,
    ingresos `SUM(ventas.total)`, top por frasco (`GROUP BY frasco_id`) y top por
    perfume (`GROUP BY perfume_id`), lista de ventas del día.

---

## 5. Vistas — RESPONSIVAS (móvil para vendedora, escritorio para admin)
Una sola base de código responsiva. Mobile-first (la vendedora trabaja desde el
celular, sin computadora en sucursal), pero con un layout de escritorio para que
el **admin verifique stock y ventas desde una computadora**.
Mockups: `mockup_tienda_movil.html` (vendedora) y `mockup_admin_escritorio.html` (admin).

Comportamiento por breakpoint (sugerido: corte en ~860px):
- **Móvil (< 860px):** una columna; objetivos táctiles grandes (≥44px); navegación
  por pestañas Venta · Stock · Reporte; barra de Total fija abajo en el POS.
- **Escritorio (≥ 860px):** layout ancho de panel; el admin ve en una sola pantalla
  el resumen del día, la tabla de stock por frasco (con precio y badge "Bajo") y el
  reporte (rankings + ventas recientes), con selector de sucursal arriba.

Vistas:
- `app/views/auth/login.php`: login sobrio, campos grandes, marca BlooBelle.
- `app/views/tienda/dashboard.php` (POS, foco móvil): buscar perfume → elegir
  **frasco** (tarjetas con imagen, nombre, precio y "quedan N"; agrupadas
  **Genéricos primero, luego Diseño**) → al seleccionar, mostrar un espacio con la
  imagen ampliada del frasco y su descripción → stepper de cantidad → "Agregar" →
  lista de la venta → barra fija con Total + "Registrar venta".
- `app/views/tienda/stock.php`: lista/tabla de frascos con miniatura, nombre,
  descripción, categoría, cantidad y badge "Bajo" (mismo orden: genéricos→diseño);
  el admin además ve "Registrar entrada de frascos", "Fijar precio" y el alta de
  frascos (con subida de imagen).
- `app/views/tienda/reporte.php`: selector de fecha (y de sucursal si es admin);
  tarjetas (frascos / ventas / ingresos) y rankings de frascos y perfumes.
- Botones de admin (entrada de stock, precios, ajustes) se ocultan para `vendedor`
  en la vista; igual la API los protege con `Auth::requireRole('admin')`.
- JS: vanilla + `fetch` a `/api/...` como hoy. Sin frameworks. CSS responsivo con
  media queries (o flex/grid que colapse), reusando las variables `:root` actuales.
- `<meta name="viewport" content="width=device-width, initial-scale=1">` y, opcional,
  `<link rel="manifest">` para instalar el POS como acceso directo en el celular (PWA).

---

## 6. Reglas de negocio / validaciones
- El precio del ítem sale de `precios(sucursal,frasco)` en el servidor, nunca del cliente.
- No vender más frascos de los disponibles (validado dentro de la transacción).
- En ventas, `sucursal_id` y `vendedor_id` salen de la sesión (lo hace la vendedora).
- En consultas/gestión (stock, reporte, entrada, ajuste): si el usuario es
  `vendedor`, `sucursal_id` sale de su sesión; si es `admin` (sin sucursal fija),
  `sucursal_id` viene en el payload, para poder verificar/gestionar cualquier ciudad.
- Reporte "del día" = `DATE(fecha) = CURDATE()`; permitir rango opcional.
- Stock bajo: `cantidad <= umbral_bajo` (configurable por fila).
- Devoluciones: NO implementar el flujo ahora; el valor `devolucion` ya existe en
  el ENUM para sumarlo después sin migrar.

---

## 7. Orden de trabajo sugerido
1. Migración SQL (sección 1) + crear usuarios con hash real.
2. `Auth` + `session_start()` + `AuthController` + login. Probar login/logout.
3. `FrascoController` (tamaños + precios por sucursal) + `StockController` (entrada)
   → cargar stock inicial de frascos.
4. `VentaController::store` transaccional + vista POS móvil.
5. `VentaController::reporte` + vista reporte.
6. Aplicar guardias de rol en cada acción.
