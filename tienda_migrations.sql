-- 1.1 Usuarios (login: usuario + contraseña; 1 por sucursal)
CREATE TABLE IF NOT EXISTS usuarios (
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
CREATE TABLE IF NOT EXISTS sucursales (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  ciudad VARCHAR(80) NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Solo agregamos la FK si no existe (simplificado omitiendo check previo o ejecutando directamente)
-- Como es la primera ejecución, lo ejecutamos tal cual.
ALTER TABLE usuarios
  ADD CONSTRAINT fk_usuarios_sucursal FOREIGN KEY (sucursal_id) REFERENCES sucursales(id);

-- 1.3 Frascos = catálogo de envases
CREATE TABLE IF NOT EXISTS frascos (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  nombre       VARCHAR(80) NOT NULL,
  categoria    ENUM('generico','diseno') NOT NULL DEFAULT 'generico',
  capacidad_ml INT NULL,
  imagen       VARCHAR(255) NULL,
  descripcion  VARCHAR(255) NULL,
  orden        INT NOT NULL DEFAULT 0,
  activo       TINYINT(1) NOT NULL DEFAULT 1,
  KEY idx_frasco_cat (categoria, orden)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 1.4 Precio por frasco y sucursal
CREATE TABLE IF NOT EXISTS precios (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  sucursal_id INT NOT NULL,
  frasco_id   INT NOT NULL,
  precio      DECIMAL(10,2) NOT NULL,
  UNIQUE KEY uq_precio (sucursal_id, frasco_id),
  CONSTRAINT fk_precio_sucursal FOREIGN KEY (sucursal_id) REFERENCES sucursales(id),
  CONSTRAINT fk_precio_frasco   FOREIGN KEY (frasco_id)   REFERENCES frascos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 1.5 Stock de frascos vacíos por sucursal
CREATE TABLE IF NOT EXISTS stock (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  sucursal_id INT NOT NULL,
  frasco_id   INT NOT NULL,
  cantidad    INT NOT NULL DEFAULT 0,
  umbral_bajo INT NOT NULL DEFAULT 5,
  UNIQUE KEY uq_stock (sucursal_id, frasco_id),
  CONSTRAINT fk_stock_sucursal FOREIGN KEY (sucursal_id) REFERENCES sucursales(id),
  CONSTRAINT fk_stock_frasco   FOREIGN KEY (frasco_id)   REFERENCES frascos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 1.6 Ventas (cabecera) + ítems
CREATE TABLE IF NOT EXISTS ventas (
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

CREATE TABLE IF NOT EXISTS venta_items (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  venta_id        INT NOT NULL,
  perfume_id      INT NOT NULL,
  frasco_id       INT NOT NULL,
  cantidad        INT NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  subtotal        DECIMAL(10,2) NOT NULL,
  CONSTRAINT fk_items_venta   FOREIGN KEY (venta_id)   REFERENCES ventas(id) ON DELETE CASCADE,
  CONSTRAINT fk_items_perfume FOREIGN KEY (perfume_id) REFERENCES perfumes(id),
  CONSTRAINT fk_items_frasco  FOREIGN KEY (frasco_id)  REFERENCES frascos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 1.7 Movimientos de stock
CREATE TABLE IF NOT EXISTS movimientos_stock (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  sucursal_id INT NOT NULL,
  frasco_id   INT NOT NULL,
  tipo        ENUM('entrada','ajuste','venta','devolucion') NOT NULL,
  cantidad    INT NOT NULL,
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

INSERT INTO precios (sucursal_id, frasco_id, precio) VALUES
  (1,1,45.00),(1,2,69.00),(1,3,110.00),(1,4,95.00),(1,5,120.00),(1,6,105.00);

INSERT INTO stock (sucursal_id, frasco_id, cantidad) VALUES
  (1,1,0),(1,2,0),(1,3,0),(1,4,0),(1,5,0),(1,6,0);

-- Usuarios generados
INSERT INTO usuarios (nombre,usuario,password_hash,rol,sucursal_id) VALUES ('Admin','admin','$2y$12$JcDadm8TWuOURQu1g1QPs.uMKvdK8RGSjPIlQYu4DhGcwoihig5y2','admin',NULL);
INSERT INTO usuarios (nombre,usuario,password_hash,rol,sucursal_id) VALUES ('Lucía','arequipa','$2y$12$aVEFjUFtZGNg0DXy14oNc.GuSmlLKGgaq.s17oXjxU448ffHxZbOm','vendedor',1);
