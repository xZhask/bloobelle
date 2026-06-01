-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 01-06-2026 a las 03:31:22
-- Versión del servidor: 11.8.2-MariaDB
-- Versión de PHP: 8.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bloobelle`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes`
--

CREATE TABLE `componentes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `componentes`
--

INSERT INTO `componentes` (`id`, `nombre`) VALUES
(5, 'ABSENTA'),
(82, 'ACEITE DE CIPRES'),
(57, 'ALDEHIDOS'),
(142, 'ALGODON DE AZUCAR'),
(132, 'ALMENDRA'),
(169, 'ALMENDRA AMARGA'),
(4, 'ALMIZCLE'),
(93, 'AMADERADO'),
(39, 'AMBAR'),
(34, 'AMBERWOOD'),
(7, 'ANIS'),
(21, 'ANIS ESTRELLADO'),
(127, 'ATALCADO'),
(72, 'AVELLANA'),
(73, 'AZAFRAN'),
(177, 'AZAHAR'),
(37, 'AZUCAR'),
(94, 'AZUCENA'),
(166, 'BAYAS'),
(163, 'BAYAS ROJAS'),
(164, 'BAYAS SILVESTRES'),
(2, 'BERGAMOTA'),
(33, 'CACAO'),
(183, 'CAFE'),
(162, 'CALIPSONE (NOTAS MARINAS)'),
(9, 'CANABIS'),
(31, 'CANELA'),
(41, 'CARAMELO'),
(184, 'CARDAMOMO'),
(90, 'CARDAMOMO GUATEMALTECO'),
(155, 'CASHMERAN'),
(152, 'CASSIS'),
(78, 'CASTAÑA'),
(70, 'CEDRO'),
(105, 'CERA DE ABEJA'),
(167, 'CEREZA'),
(150, 'CEREZA ACIDA'),
(100, 'CHABACANO'),
(95, 'CHAMPAÑA'),
(88, 'CIDRA'),
(58, 'CIPRES'),
(16, 'CIPRES HINOKI'),
(71, 'CIRUELA'),
(80, 'CIRUELA MIRABEL'),
(43, 'CITRICOS'),
(65, 'COCO'),
(161, 'CORAZON DE ROSA DAMASCENA'),
(128, 'CREMA BATIDA'),
(20, 'CUERO'),
(185, 'CURCUMA'),
(126, 'DULCES'),
(110, 'DURAZNO'),
(91, 'ENEBRO'),
(69, 'ESPECIAS'),
(83, 'EXTRACTO DE ROBLE'),
(112, 'FLOR DE AZAHAR'),
(46, 'FLOR DE AZAHAR DEL NARANJO'),
(156, 'FLOR DE CEREZO'),
(97, 'FLOR DE DURAZNERO'),
(81, 'FLOR DE JAZMIN SAMBAC'),
(19, 'FLOR DE OLIVO'),
(118, 'FLORES'),
(135, 'FLORES BLANCAS'),
(125, 'FRAMBUESA'),
(119, 'FRAMBUESA NEGRA'),
(149, 'FRESA'),
(131, 'FRUTA CONFITADA'),
(101, 'FRUTAS TROPICALES'),
(56, 'GAMUZA'),
(111, 'GARDENIA'),
(92, 'GERANIO'),
(168, 'GOLOSINAS'),
(130, 'GOMA DE MASCAR'),
(134, 'GRANADA'),
(62, 'GROSELLA NEGRA'),
(124, 'GROSELLA ROJA'),
(160, 'GUISANTE DE OLOR'),
(32, 'HABA TONKA'),
(148, 'HELIOTROPO'),
(178, 'HIERBA VERDE'),
(123, 'HIERBAS'),
(137, 'HIGO'),
(186, 'HOJAS DE VIOLETA'),
(117, 'HOJAS MANZANO'),
(79, 'HOJAS VERDES'),
(29, 'INCIENSO'),
(153, 'JASMINUM'),
(13, 'JAZMIN'),
(114, 'JAZMIN DE AGUA'),
(3, 'JENGIBRE'),
(44, 'LAUREL'),
(22, 'LAVANDA'),
(147, 'LECHE DE COCO'),
(50, 'LICHI'),
(181, 'LICOR'),
(103, 'LIMA ACIDA'),
(12, 'LIMON'),
(27, 'LIMON DE AMALFI'),
(145, 'LIMON ITALIANO'),
(157, 'LIRIO DE LOS VALLES'),
(102, 'LIRIS'),
(143, 'MACARRONES DULCES'),
(136, 'MADERA'),
(25, 'MADERA DE OUD'),
(84, 'MADERA DE PAPIRO'),
(121, 'MAGNOLIA'),
(144, 'MALVAVISCO'),
(40, 'MANDARINA'),
(48, 'MANGO'),
(30, 'MANZANA'),
(141, 'MANZANA ROJA'),
(179, 'MANZANILLA'),
(109, 'MARACUYA'),
(15, 'MARIHUANA'),
(55, 'MELON'),
(28, 'MENTA'),
(140, 'MERENGUE'),
(67, 'MIEL'),
(187, 'MORA'),
(75, 'MUSGO'),
(87, 'MUSGO DE ROBLE'),
(53, 'NARANJA'),
(89, 'NARANJA SICILIANA'),
(108, 'NARDO'),
(99, 'NARDO DE LA INDIA'),
(98, 'NECTARINA'),
(85, 'NEROLI'),
(26, 'NOTAS ACUATICAS'),
(120, 'NOTAS AMADERADAS'),
(104, 'NOTAS ATALCADAS'),
(182, 'NOTAS DE IRIS'),
(96, 'NOTAS FRUTADAS'),
(11, 'NOTAS MARINAS'),
(35, 'NOTAS VERDES'),
(66, 'NUEZ MOSCADA'),
(133, 'ORQUIDEA'),
(51, 'OSMANTO'),
(18, 'PACHULI'),
(115, 'PALOMITAS DE MAIZ'),
(14, 'PAPAYA'),
(122, 'PEONIA'),
(171, 'PEONIA CEREZA'),
(54, 'PEPINO'),
(8, 'PERA'),
(74, 'PIMIENTA'),
(68, 'PIMIENTA NEGRA'),
(47, 'PIMIENTA ROSA'),
(61, 'PIÑA'),
(170, 'PITAHAYA'),
(129, 'PRALINE'),
(38, 'REGALIZ'),
(17, 'ROMERO'),
(24, 'RON'),
(64, 'ROSA'),
(107, 'ROSA DE BULGARIA'),
(60, 'ROSA DE DAMASCO'),
(174, 'ROSA DE MAYO'),
(139, 'ROSE MILK'),
(173, 'ROSELLA NEGRA'),
(175, 'RUIBARBO'),
(180, 'SABILA'),
(113, 'SAL'),
(10, 'SALVIA'),
(154, 'SAMBAC'),
(52, 'SANDALO'),
(86, 'TABACO'),
(49, 'TE'),
(138, 'TE VERDE LAPSANG SOUCHONG'),
(1, 'TORONJA'),
(176, 'TUBEROSA'),
(63, 'UN CORAZON DE ABEDUL'),
(59, 'VAINA DE VAINILLA'),
(6, 'VAINILLA'),
(76, 'VAINILLA BOURBON'),
(158, 'VAINILLA BOURBON AHUMADA'),
(159, 'VAINILLA CREMOSA'),
(146, 'VAINILLA DE MADAGASCAR'),
(172, 'VAINILLA SOLAR'),
(36, 'VERGAMOTA'),
(42, 'VETIVER'),
(77, 'VETIVER AHUMADO'),
(106, 'VIOLETA'),
(45, 'WHISKY'),
(116, 'YLANG-YLANG'),
(151, 'ZARZAMORA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `designers`
--

CREATE TABLE `designers` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `designers`
--

INSERT INTO `designers` (`id`, `nombre`) VALUES
(21, 'AFNAN'),
(6, 'ANTONIO BANDERAS'),
(42, 'ARIANA GRANDE'),
(19, 'ARMAF'),
(3, 'AZZARO'),
(51, 'BATH & BODY WORKS'),
(28, 'BHARARA'),
(56, 'BOND NO. 9'),
(46, 'BURBERRY'),
(5, 'BVLGARY'),
(9, 'CALVIN KLEIN'),
(1, 'CAROLINA HERRERA'),
(7, 'CHANEL'),
(27, 'CREED'),
(23, 'CRISTIANO RONALDO'),
(10, 'DIESEL'),
(17, 'DIOR'),
(14, 'DOLCE & GABANNA'),
(2, 'GIORGIO ARMANI'),
(40, 'GIVENCHY'),
(25, 'HARAMAIN'),
(8, 'HUGO BOSS'),
(11, 'JEAN PAUL GAULTIER'),
(36, 'KATTY PERRY'),
(44, 'KAYALI'),
(32, 'KENZO'),
(13, 'LACOSTE'),
(33, 'LADY GAGA'),
(34, 'LANCOME'),
(20, 'LATTAFA'),
(29, 'LOUIS VUITTON'),
(53, 'MAISON FRANCIS KURKDIJAN'),
(43, 'MOSCHINO'),
(24, 'NAUTICA'),
(49, 'NINA RICCI'),
(12, 'PACO RABANNE'),
(37, 'PALOMA PICASSO'),
(55, 'PARFUMS DE MARLY'),
(30, 'PARIS HILTON'),
(31, 'PRADA'),
(15, 'RALPH LAUREN'),
(41, 'RP PARFUMS'),
(45, 'SABRINA CARPENTER'),
(38, 'SHAKIRA'),
(39, 'SOFIA VERGARA'),
(47, 'THIERRY MUGLER'),
(52, 'TIZIANA TERRENZI'),
(26, 'TOM FORD'),
(18, 'TOMMY HILFIGER'),
(22, 'VALENTINO'),
(4, 'VERSACE'),
(48, 'VICTORIA\'S SECRET'),
(16, 'VICTORINOX'),
(50, 'VIKTOR & ROLF'),
(54, 'XERJOFF'),
(35, 'YVES SAINT LAURENT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frascos`
--

CREATE TABLE `frascos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `categoria` enum('generico','diseno') NOT NULL DEFAULT 'generico',
  `capacidad_ml` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `controla_stock` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `frascos`
--

INSERT INTO `frascos` (`id`, `nombre`, `categoria`, `capacidad_ml`, `imagen`, `descripcion`, `orden`, `activo`, `controla_stock`) VALUES
(1, 'Frasco liso 30 ml', 'generico', 30, '/assets/images/frascos/frasco_6a1b8f3aa1c30.png', 'Frasco atomizador estándar', 1, 1, 1),
(2, 'Frasco liso 50 ml', 'generico', 50, '/assets/images/frascos/frasco_6a1b8f4dc1e9d.png', 'Frasco atomizador estándar', 2, 1, 1),
(3, 'Frasco Liso 100 ml', 'generico', 100, '/assets/images/frascos/frasco_6a1b8f64edb91.png', 'Frasco atomizador estándar', 3, 1, 1),
(4, 'Corazón', 'diseno', 50, '/assets/images/frascos/frasco_6a1b9038431dc.png', 'Frasco decorativo en forma de corazón', 1, 1, 1),
(5, 'París', 'diseno', 50, '/assets/images/frascos/frasco_6a1b907b93a55.png', 'Frasco edición París, estilo torre Eiffel', 2, 1, 1),
(6, 'Taquito negro', 'diseno', 30, '/assets/images/frascos/frasco_6a1b90aa983ca.png', 'Frasco con diseño tipo Zapato mujer', 3, 1, 1),
(7, 'Frasco tornillo 30 ml', 'generico', 30, '/assets/images/frascos/frasco_6a1b8f9fe8b9f.png', 'Frasco atomizador estándar', 4, 1, 1),
(8, 'Tipo Chanel', 'diseno', 50, '/assets/images/frascos/frasco_6a1b90f9b9ab7.png', 'Frasco con diseño tipo Chanel', 4, 1, 1),
(9, 'Osito', 'diseno', 50, '/assets/images/frascos/frasco_6a1b921e8643c.jpg', 'Frasco con diseño de Osito', 5, 1, 1),
(10, 'Gato', 'diseno', 75, '/assets/images/frascos/frasco_6a1b92b2cdd62.png', 'Frasco con diseño de Gato', 6, 1, 1),
(11, 'Scandal', 'diseno', 50, '/assets/images/frascos/frasco_6a1b92f3e20e7.png', 'Frasco con diseño de frasco Scandal', 7, 1, 1),
(12, 'Con listón', 'diseno', 50, '/assets/images/frascos/frasco_6a1b9338bf130.png', 'Frasco con listón negro', 8, 1, 1),
(13, 'Invictus 30 ml', 'diseno', 30, '/assets/images/frascos/frasco_6a1b936c53700.png', 'Frasco fragancia Invictus 30 ml', 9, 1, 1),
(14, 'Invictus 50 ml', 'diseno', 50, '/assets/images/frascos/frasco_6a1b938402abd.png', 'Frasco fragancia Invictus 50 ml', 10, 1, 1),
(15, 'Cuadrado Negro 30 ml', 'diseno', 30, '/assets/images/frascos/frasco_6a1b93c1b2d3a.png', 'Frasco cuadrado negro 30 ml', 11, 1, 1),
(16, 'Cuadrado Negro 50 ml', 'diseno', 50, '/assets/images/frascos/frasco_6a1b944875edd.png', 'Frasco cuadrado negro 50 ml', 12, 1, 1),
(17, 'Sin frasco', 'generico', NULL, NULL, NULL, 99, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `nombre`) VALUES
(1, 'HOMBRE'),
(2, 'MUJER'),
(3, 'UNISEX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_stock`
--

CREATE TABLE `movimientos_stock` (
  `id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  `frasco_id` int(11) NOT NULL,
  `tipo` enum('entrada','ajuste','venta','devolucion') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `motivo` varchar(160) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfumes`
--

CREATE TABLE `perfumes` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `referencia` varchar(200) NOT NULL,
  `ruta_img` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `genero_id` int(11) NOT NULL,
  `designer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfumes`
--

INSERT INTO `perfumes` (`id`, `codigo`, `referencia`, `ruta_img`, `descripcion`, `genero_id`, `designer_id`) VALUES
(1, 'CC001', '212 MEN', NULL, 'Una fragancia fresca y urbana con notas verdes, cítricas y un fondo de almizcle, ideal para el dinamismo diario.', 1, 1),
(2, 'CC004', '212 VIP MEN', NULL, 'Aroma nocturno y fiestero con toques de lima, caviar y pimienta, acentuado por una nota distintiva de vodka.', 1, 1),
(3, 'CC007', '212 HEROES FOREVER YOUNG', NULL, 'Fragancia juvenil y vibrante que celebra la libertad con notas de pera, jengibre y un fondo de cuero.', 1, 1),
(4, 'CC008', 'ACQUA DI GIO MEN', NULL, 'Un clásico acuático y cítrico inspirado en el mar, que combina bergamota, jazmín y romero.', 1, 2),
(5, 'CC011', 'AZZARO MEN', NULL, 'Aroma fougère clásico y elegante, caracterizado por su fuerte presencia de anís, lavanda y maderas nobles.', 1, 3),
(6, 'CC016', 'AQCUA DI GIO PROFONDO', NULL, 'Una interpretación profunda y marina del clásico, con notas salinas, mandarina y esencias minerales.', 1, 2),
(7, 'CC017', 'ARMANI CODE', NULL, 'Fragancia oriental y seductora que destaca por la flor de olivo, el haba tonka y el toque masculino del cuero.', 1, 2),
(8, 'CC019', 'BLUE JEANS MEN', NULL, 'Un perfume juvenil y versátil que mezcla cítricos, lavanda y vainilla en una composición clásica de los 90.', 1, 4),
(9, 'CC022', 'MAN IN BLACK', NULL, 'Una esencia intensa y carismática con notas de ron, especias y cuero, ideal para el hombre sofisticado.', 1, 5),
(10, 'CC023', 'BLUE SEDUCTION', NULL, 'Aroma fresco y transparente con una mezcla de bergamota, menta y capuchino, perfecto para uso casual.', 1, 6),
(11, 'CC024', 'BLEU', NULL, 'Fragancia amaderada aromática de Chanel que une la frescura de los cítricos con el vigor del incienso.', 1, 7),
(12, 'CC025', 'BOSS', NULL, 'Perfume equilibrado y masculino que combina manzana, canela y maderas sensuales, un pilar de la elegancia diaria.', 1, 8),
(13, 'CC026', 'BAD BOY', NULL, 'Una fragancia atrevida con contrastes de pimienta blanca, cacao y haba tonka, encerrada en un frasco icónico.', 1, 1),
(14, 'CC029', 'CK ONE', NULL, 'El icónico perfume unisex que define la frescura con notas de té verde, papaya y bergamota en armonía.', 1, 9),
(15, 'CC033', 'CH MEN', NULL, 'Un aroma sofisticado que evoca el cuero y el azúcar, equilibrado con notas frescas de hierba y violeta.', 1, 1),
(16, 'CC035', 'DIESEL FUEL FOR LIFE', NULL, 'Fragancia energética y especiada con anís estrellado y frambuesa sobre un fondo amaderado seco.', 1, 10),
(17, 'CC041', 'EMPORIO', NULL, 'Una esencia magnética con notas de salvia, cardamomo y maderas preciosas que proyecta confianza moderna.', 1, 2),
(18, 'CC047', 'EROS', NULL, 'Perfume vibrante de Versace que destaca por su menta fresca, manzana verde y una envolvente vainilla de Madagascar.', 1, 4),
(19, 'CC049', 'SCANDAL MEN', NULL, 'Una fragancia ambarina con notas de caramelo, salvia y vetiver, diseñada para el hombre audaz.', 1, 11),
(20, 'CC055', 'PHANTOM', NULL, 'Aroma futurista que combina lavanda cremosa, limón energético y vainilla amaderada en una mezcla audaz.', 1, 12),
(21, 'CC069', 'HUGO ELEMENT', NULL, 'Fragancia acuática diseñada para el entorno urbano, con notas de jengibre, cilantro y maderas frescas.', 1, 8),
(22, 'CC073', 'INVICTUS MEN', NULL, 'Un aroma victorioso que fusiona la frescura de la toronja y notas marinas con la calidez del laurel.', 1, 12),
(23, 'CC074', 'INVICTUS INTENSE', NULL, 'Una versión más profunda y ambarina del original, con notas de pimienta negra y maderas vibrantes.', 1, 12),
(24, 'CC075', 'INVICTUS VICTORY', NULL, 'Perfume nocturno extremo que destaca por su potente mezcla de limón, incienso y vainilla dulce.', 1, 12),
(25, 'CC076', 'LE MALE', NULL, 'El clásico de Jean Paul Gaultier que reinventa la lavanda con un toque de menta fresca y vainilla sensual.', 1, 11),
(26, 'CC085', 'LACOSTE RED MEN', NULL, 'Fragancia dinámica con notas de manzana roja, pino y pachuli, ideal para un estilo de vida activo.', 1, 13),
(27, 'CC087', 'LIGHT BLUE MEN', NULL, 'Un viaje al Mediterráneo con notas de mandarina siciliana, enebro y la frescura del romero.', 1, 14),
(28, 'CC103', 'POLO BLACK MEN T', NULL, 'Aroma moderno y atrevido que destaca por el mango helado, la salvia y el pachuli negro.', 1, 15),
(29, 'CC104', 'POLO BLUE MEN', NULL, 'Fragancia acuática refrescante con notas de melón, pepino y mandarina sobre un fondo suave de gamuza.', 1, 15),
(30, 'CC106', 'POLO SPORT MEN', NULL, 'Un perfume energizante y limpio que combina notas marinas, menta y cítricos para el deportista.', 1, 15),
(31, 'CC115', 'SWISS ARMY MEN', NULL, 'Aroma fresco y funcional inspirado en los Alpes, con notas de menta, bergamota y maderas claras.', 1, 16),
(32, 'CC116', 'SAUVAGE', NULL, 'Fragancia cruda y noble que destaca por la bergamota de Calabria y el vigor amaderado del ambroxan.', 1, 17),
(33, 'CC119', 'TOMMY MEN', NULL, 'El espíritu americano capturado en notas de manzana, arándanos y menta sobre un fondo de algodón.', 1, 18),
(34, 'CC122', 'ULTRAMALE', NULL, 'Una interpretación intensa y dulce de Le Male, con pera, lavanda negra y una base potente de vainilla.', 1, 11),
(35, 'CC126', 'ONE MILLON ELIXIR', NULL, 'La versión más rica y profunda de One Million, con notas de manzana, rosa damascena y vainilla negra.', 1, 12),
(36, 'CC138', 'CLUB DE NUIT', NULL, 'Un aroma icónico y potente con notas cítricas intensas que evolucionan hacia un ahumado amaderado.', 1, 19),
(37, 'CC139', 'LE BEAU', NULL, 'Fragancia tropical y sensual construida alrededor del coco, la bergamota y el haba tonka.', 1, 11),
(38, 'CC140', 'SAUVAGE ELIXIR', NULL, 'Una concentración extrema de Sauvage con especias ricas, lavanda licorosa y maderas ambarinas.', 1, 17),
(39, 'CC144', 'LE MALE ELIXIR', NULL, 'Aroma ardiente y adictivo que mezcla lavanda fresca con la calidez del benjuí y la miel.', 1, 11),
(40, 'CC145', 'EROS FLAME', NULL, 'Fragancia ardiente de contrastes, con cítricos italianos, pimienta negra y maderas cálidas.', 1, 4),
(41, 'CC146', 'ASAD', NULL, 'Perfume árabe intenso con notas de pimienta negra, tabaco y vainilla, conocido por su gran estela.', 1, 20),
(42, 'CC149', '9PM', NULL, 'Aroma nocturno dulce y afrutado con manzana, canela y lavanda, ideal para salidas de noche.', 1, 21),
(43, 'CC153', 'ONE MILLION GOLD', NULL, 'Fragancia opulenta con notas florales blancas, mandarina y un fondo amaderado dorado.', 1, 12),
(44, 'CC154', 'ONE MILLON LUCKY', NULL, 'Aroma vibrante y optimista que combina avellana, ciruela y notas amaderadas de cedro.', 1, 12),
(45, 'CC157', 'BORN IN ROMA INTENSE', NULL, 'Una versión potente con vainilla, lavanda y vetiver que rinde homenaje a la noche romana.', 1, 22),
(46, 'CC158', 'ODYSSEY MANDARIN SKY', NULL, 'Fragancia cítrica y dulce con mandarina, caramelo y azafrán, que evoca un cielo atardecido.', 1, 19),
(47, 'CC162', 'EROS ENERGY', NULL, 'Una explosión de frescura cítrica y vitalidad, con limón italiano y notas amaderadas solares.', 1, 4),
(48, 'CC163', 'BORN IN ROMA UOMO', NULL, 'Aroma moderno que mezcla jengibre especiado, sales minerales y el toque clásico del vetiver.', 1, 22),
(49, 'CC165', 'STRONGER WITH YOU', NULL, 'Fragancia cálida y magnética con notas de cardamomo, pimienta rosa y castaña glaseada.', 1, 2),
(50, 'CC900', 'CR7', NULL, 'El perfume de Cristiano Ronaldo que ofrece frescura con bergamota, lavanda y un fondo de maderas clásicas.', 1, 23),
(51, 'CC901', 'NAUTICA VOYAGE', NULL, 'Aroma acuático icónico con notas de manzana verde, loto y un fondo sereno de cedro y ámbar.', 1, 24),
(52, 'CC902', 'ASAD BOURBON', NULL, 'Versión sofisticada de Asad con notas de ron, especias cálidas y un fondo amaderado ahumado.', 1, 20),
(53, 'CC903', 'AMBER OUD', NULL, 'Fragancia lujosa que destaca por su ámbar rico, maderas de oud y un toque sutil de especias.', 1, 25),
(54, 'CC905', 'OMBRE LEATHER', NULL, 'Aroma de cuero crudo y elegante con notas de jazmín sambac, ámbar y musgo blanco.', 1, 26),
(55, 'CC906', 'FAHRENHEIT', NULL, 'Un clásico vanguardista de Dior que combina violeta, cuero y notas de mandarina en una mezcla única.', 1, 17),
(56, 'CC907', 'STRONGER WITH YOU ABSOLUTELY', NULL, 'La versión más intensa de la línea, con ron, lavanda y castaña sobre un fondo de vainilla.', 1, 2),
(57, 'CC909', 'COSTA AZZURRA', NULL, 'Fragancia marina y amaderada que captura la esencia del Mediterráneo con notas de ciprés y limón.', 1, 26),
(58, 'CC910', 'DYLAN BLUE', NULL, 'Aroma masculino moderno con notas acuáticas, bergamota, higo y un fondo de incienso y pimienta.', 1, 4),
(59, 'CC912', 'VERSACE POUR HOMME', NULL, 'Perfume mediterráneo esencial con notas de limón, neroli y cedro, ideal para la oficina.', 1, 4),
(60, 'CC913', 'PACO RABANNE POUR HOMME', NULL, 'El clásico aromático por excelencia con notas de romero, salvia y lavanda en un fondo de musgo.', 1, 12),
(61, 'CC914', 'AVENTUS', NULL, 'Fragancia de culto que abre con piña y bergamota, evolucionando hacia un corazón ahumado de abedul.', 1, 27),
(62, 'CC915', 'ONIX', NULL, 'Aroma misterioso e intenso con maderas oscuras, especias y un toque de ámbar mineral.', 1, 28),
(63, 'CC916', 'IMAGINATION', NULL, 'Perfume cítrico luminoso que utiliza té negro, neroli y jengibre para una sensación de frescura eterna.', 1, 29),
(64, 'CC918', 'WANTED', NULL, 'Fragancia audaz y picante con notas de limón, jengibre y haba tonka, encerrada en un frasco único.', 1, 3),
(65, 'UU005', 'TOBACCO VANILLE', NULL, 'Aroma opulento que fusiona el tabaco cremoso con la dulzura de la vainilla y especias aromáticas.', 1, 26),
(66, 'DD001', '212 NYC', NULL, 'Un perfume floral y urbano con notas de azahar, camelia y gardenia sobre un fondo de sándalo.', 2, 1),
(67, 'DD006', '212 VIP ROSE', NULL, 'Fragancia festiva y glamurosa con champaña rosada, notas frutales y un corazón de flor de durazno.', 2, 1),
(68, 'DD007', 'ACQUA DI GIOIA', NULL, 'Aroma alegre y acuático que combina limón de Amalfi, menta fresca y jazmín de agua.', 2, 2),
(69, 'DD029', 'CAN CAN', NULL, 'Perfume juguetón y dulce de Paris Hilton con notas de nectarina, flor de azahar y ámbar.', 2, 30),
(70, 'DD030', 'CAROLINA HERRERA', NULL, 'La fragancia clásica de la diseñadora, un bouquet floral elegante con nardos y jazmín.', 2, 1),
(71, 'DD031', 'CH', NULL, 'Aroma sofisticado que mezcla cítricos con notas dulces de praliné y un fondo de maderas y cuero.', 2, 1),
(72, 'DD033', 'CHANEL NO 5', NULL, 'El perfume más famoso del mundo, un bouquet de aldehídos, rosa y jazmín que define la elegancia.', 2, 7),
(73, 'DD037', 'CHANCE', NULL, 'Fragancia floral e impredecible con notas de pimienta rosa, jazmín y pachuli ambarino.', 2, 7),
(74, 'DD040', 'COCO MADEMOISELLE', NULL, 'Esencia femenina moderna con naranja vibrante, rosa clara y pachuli refinado de Chanel.', 2, 7),
(75, 'DD044', 'CANDY', NULL, 'Aroma gourmet centrado en el caramelo, el almizcle y el benjuí para una dulzura sofisticada.', 2, 31),
(76, 'DD057', 'SCANDAL WOMAN', NULL, 'Fragancia chipre floral con miel fresca, gardenia y pachuli, diseñada para romper esquemas.', 2, 11),
(77, 'DD059', 'FLOWER', NULL, 'Aroma poético de Kenzo con notas de amapola, violeta y vainilla sobre un fondo atalcado.', 2, 32),
(78, 'DD065', 'GOOD GIRL', NULL, 'El icónico zapato que contiene una mezcla de nardo, jazmín, cacao y haba tonka.', 2, 1),
(79, 'DD075', 'HEIRESS', NULL, 'Perfume frutal y floral muy femenino con notas de maracuyá, granadina y madreselva.', 2, 30),
(80, 'DD081', 'J\' ADORE', NULL, 'Un tributo a las flores con esencia de ylang-ylang, rosa damascena y jazmín sambac de Dior.', 2, 17),
(81, 'DD089', 'LIGHT BLUE', NULL, 'Fragancia fresca y mediterránea con manzana Granny Smith, limón siciliano y cedro.', 2, 14),
(82, 'DD092', 'LADY MILLION', NULL, 'Aroma deslumbrante con notas de frambuesa, neroli y jazmín sobre un fondo de miel y pachuli.', 2, 12),
(83, 'DD093', 'LADY GAGA', NULL, 'Fragancia audaz y oscura con notas de incienso, belladona, miel y azafrán.', 2, 33),
(84, 'DD094', 'LA VIDA ES BELLA', NULL, 'Una declaración de felicidad basada en el iris, el pachuli y la dulzura del praliné.', 2, 34),
(85, 'DD096', 'LIBRE', NULL, 'El perfume de la libertad con lavanda de Francia, flor de azahar de Marruecos y almizcle.', 2, 35),
(86, 'DD100', 'MEOW', NULL, 'Fragancia dulce de Katy Perry con notas de pera, mandarina, gardenia y un fondo de vainilla.', 2, 36),
(87, 'DD101', 'MY WAY', NULL, 'Aroma floral contemporáneo con bergamota, azahar, nardos y un fondo amaderado de cedro.', 2, 2),
(88, 'DD104', 'MISS DIOR (2012)', NULL, 'Un chipre floral elegante con mandarina italiana, rosa de Grasse y pachuli indonesio.', 2, 17),
(89, 'DD110', 'OLYMPEA', NULL, 'Fragancia de una diosa moderna con vainilla salada, jazmín de agua y mandarina verde.', 2, 12),
(90, 'DD112', 'PALOMA PICASSO', NULL, 'Un aroma artístico y clásico con notas de cilantro, clavel y pachuli sobre musgo de roble.', 2, 37),
(91, 'DD115', 'POISON', NULL, 'Esencia enigmática y audaz de Dior con notas de cilantro, bayas silvestres y miel de azahar.', 2, 17),
(92, 'DD118', 'PURE XS', NULL, 'Fragancia provocativa con ylang-ylang, palomitas de maíz y vainilla caliente.', 2, 12),
(93, 'DD119', 'RALPH', NULL, 'Aroma fresco y juvenil con manzana verde, mandarina italiana y magnolia blanca.', 2, 15),
(94, 'DD128', 'SHAKIRA S', NULL, 'Fragancia oriental floral con notas de jazmín, sándalo y un fondo cálido de vainilla y resina.', 2, 38),
(95, 'DD129', 'SOFIA VERGARA', NULL, 'Perfume glamuroso con moras, ciruela y orquídea colombiana sobre un fondo de vainilla.', 2, 39),
(96, 'DD130', 'TOMMY GIRL', NULL, 'Aroma refrescante que evoca flores silvestres, camelias y notas cítricas de mandarina.', 2, 18),
(97, 'DD133', 'TRESOR WOMAN', NULL, 'Un clásico romántico con notas de durazno, rosa, ámbar y sándalo envolvente.', 2, 34),
(98, 'DD141', 'VERY IRRESISTIBLE', NULL, 'Fragancia centrada en la rosa, combinada con anís estrellado y verbena para un toque moderno.', 2, 40),
(99, 'DD143', 'VERY GOOD GIRL', NULL, 'Una interpretación afrutada con grosella roja, lichi y la elegancia de la rosa.', 2, 1),
(100, 'DD144', '212 HEROES FOREVER YOUNG', NULL, 'Aroma floral frutal juvenil con frambuesa, jazmín y sándalo para la mujer activa.', 2, 1),
(101, 'DD145', 'FAME', NULL, 'Perfume vanguardista de Paco Rabanne con mango jugoso, jazmín puro e incienso cremoso.', 2, 12),
(102, 'DD146', 'SUCRE NOIR', NULL, 'Esencia gourmet intensa centrada en el azúcar moreno, la vainilla y el toque de orquídea.', 2, 41),
(103, 'DD148', 'SWEET LIKE CANDY', NULL, 'Aroma dulce de Ariana Grande con moras, malvavisco y crema batida.', 2, 42),
(104, 'DD159', 'CLOUD', NULL, 'Fragancia soñadora que mezcla lavanda, pera, coco y praliné sobre un fondo amaderado.', 2, 42),
(105, 'DD160', 'TOY 2 BUBBLE GUM', NULL, 'Aroma divertido que abre con goma de mascar y cítricos, evolucionando hacia la rosa y el durazno.', 2, 43),
(106, 'DD161', 'GOOD GIRL BLUSH', NULL, 'Versión romántica con notas de peonía, agua de rosas y un fondo de vainilla sostenible.', 2, 1),
(107, 'DD163', 'YARA', NULL, 'Perfume árabe viral con notas dulces de orquídea, mandarina y un fondo cremoso de vainilla.', 2, 20),
(108, 'DD174', 'EROS POUR FEMME', NULL, 'Fragancia de seducción con limón siciliano, bergamota de Calabria y jazmín sambac.', 2, 4),
(109, 'DD175', 'YARA CANDY', NULL, 'Una explosión de dulzura con notas de caramelos, frutas tropicales y vainilla cremosa.', 2, 20),
(110, 'DD177', 'SCANDAL', NULL, 'El aroma original con miel, gardenia y pachuli que proyecta una feminidad poderosa.', 2, 11),
(111, 'DD178', 'BORN IN ROMA GREEN', NULL, 'Fragancia fresca y floral con té lapsang souchong, jazmín y extracto de vainilla.', 2, 22),
(112, 'DD179', 'BADE\'E AL OUD (NOBLE BLUSH)', NULL, 'Aroma lujoso con nardos, jazmín y un fondo amaderado de oud refinado.', 2, 20),
(113, 'DD181', 'ECLAIRE', NULL, 'Perfume gourmet que evoca pastelería fina con notas de caramelo, leche y vainilla.', 2, 20),
(114, 'DD182', 'POUR ELLE SPARKLING', NULL, 'Fragancia alegre con macarrón dulce, algodón de azúcar y notas frutales.', 2, 13),
(115, 'DD187', 'YUM BOUJEE MARSHMALLOW', NULL, 'Aroma ultra-dulce con malvavisco, vainilla y un toque frutal de fresa.', 2, 44),
(116, 'DD900', 'SWEET TOOTH', NULL, 'Fragancia inspirada en golosinas con chocolate blanco, malvavisco y crema de vainilla.', 2, 45),
(117, 'DD901', 'YARA TOUS', NULL, 'Versión tropical de Yara con mango jugoso, coco y flor de azahar.', 2, 20),
(118, 'DD902', 'BURBERRY HER', NULL, 'Aroma urbano de Londres con frutos rojos, jazmín y notas amaderadas de ámbar.', 2, 46),
(119, 'DD903', 'ALIEN', NULL, 'Fragancia solar y misteriosa con jazmín sambac, notas amaderadas y ámbar blanco.', 2, 47),
(120, 'DD904', 'BORN IN ROMA EXTRADOSE', NULL, 'Versión intensificada con notas florales potentes y un fondo de maderas preciosas.', 2, 22),
(121, 'DD905', 'AQUA KISS', NULL, 'Aroma fresco y marino de Victoria\'s Secret con notas de freesia y margarita bajo la lluvia.', 2, 48),
(122, 'DD906', 'LOVE SPELL', NULL, 'Fragancia icónica frutal con flor de cerezo y durazno, un clásico de frescura diaria.', 2, 48),
(123, 'DD907', 'ARI', NULL, 'El primer perfume de Ariana Grande, dulce con pera, malvavisco y maderas claras.', 2, 42),
(124, 'DD908', 'BORN IN ROMA INTENSE', NULL, 'Fragancia floral ambarina con jazmín y vainilla bourbon para una noche inolvidable.', 2, 22),
(125, 'DD909', 'VANILLA LACE', NULL, 'Aroma clásico de vainilla pura y orquídea, cálido y reconfortante.', 2, 48),
(126, 'DD911', 'DAZZLE', NULL, 'Perfume brillante de Paris Hilton con cereza ácida, manzana roja y orquídea.', 2, 30),
(127, 'DD912', 'MISS DIOR BLOOMING', NULL, 'Bouquet floral delicado con peonía, rosa damascena y almizcle blanco.', 2, 17),
(128, 'DD913', 'DIVINE', NULL, 'Fragancia floral marina de Jean Paul Gaultier con notas solares y lirio blanco.', 2, 11),
(129, 'DD914', 'ISLAND BLISS', NULL, 'Aroma tropical que evoca vacaciones con coco, frutas exóticas y flores blancas.', 2, 19),
(130, 'DD916', 'YUM YUM', NULL, 'Fragancia divertida y golosa con notas de frutas dulces y un fondo de vainilla.', 2, 19),
(131, 'DD917', 'HYPNOTIC POISON', NULL, 'Esencia magnética de Dior con almendra amarga, jazmín sambac y vainilla.', 2, 17),
(132, 'DD918', 'THANK U NEXT', NULL, 'Perfume audaz con pera blanca, frambuesa silvestre y coco cremoso.', 2, 42),
(133, 'DD919', 'LA BOMBA', NULL, 'Aroma explosivo y floral con notas de jazmín, rosa y un fondo dulce amaderado.', 2, 1),
(134, 'DD920', 'SI', NULL, 'Fragancia elegante de Giorgio Armani con néctar de grosella negra y maderas claras.', 2, 2),
(135, 'DD921', 'RICCI RICCI', NULL, 'Aroma chic con notas de ruibarbo, bergamota y flor de dondiego de noche.', 2, 49),
(136, 'DD922', 'SCANDAL BY NIGHT', NULL, 'Una versión más profunda y amielada del original, con nardos y haba tonka.', 2, 11),
(137, 'DD923', 'BONBON', '/assets/images/perfumes/perfume_6a1cf68c88192.webp', 'Perfume gourmet de lujo centrado en el caramelo crujiente, mandarina y azahar.', 2, 50),
(138, 'XS001', 'PURE SEDUCTION', NULL, 'Fragancia frutal clásica de Victoria\'s Secret con ciruela roja y freesia.', 2, 48),
(139, 'XS003', 'COCONUT PASSION', '/assets/images/perfumes/perfume_6a1bd1e5aa758.png', 'Aroma cálido y tropical que mezcla coco, vainilla y lirio de los valles.', 2, 48),
(140, 'XS009', 'WILD MADAGASCAR', '/assets/images/perfumes/perfume_6a1bcf788b961.png', 'Fragancia exótica con notas de vainilla de Madagascar, pera y flores blancas.', 2, 51),
(141, 'CC908', 'CHERRY (LOST CHERRY)', '/assets/images/perfumes/perfume_6a1bcae349800.png', 'Viaje prohibido por los sentidos con cereza exótica, licor y almendra amarga.', 3, 26),
(142, 'CC911', 'MILLESIME IMPERIAL', '/assets/images/perfumes/perfume_6a1bc7532171c.png', 'Fragancia real que evoca jardines cítricos y paisajes costeros con notas salinas.', 3, 27),
(143, 'CC917', 'KHAMRAH QHAWA', '/assets/images/perfumes/perfume_6a1bc6c1e2597.png', 'Versión de Khamrah con una nota intensa de café arábica, canela y dátiles dulces.', 3, 20),
(144, 'DD915', 'KIRKE', '/assets/images/perfumes/kirke.png', 'Extracto de perfume mágico con maracuyá, durazno y un fondo de almizcle blanco.', 3, 52),
(145, 'UU003', 'BACCARAT ROUGE 540', '/assets/images/perfumes/perfume_6a1bc61a6a69f.png', 'Alquimia poética de jazmín, azafrán, ámbar gris y resina de abeto.', 3, 53),
(146, 'UU012', 'KHAMRAH', '/assets/images/perfumes/perfume_6a1bc4e316761.png', 'Aroma opulento con dátiles, canela, vainilla y notas amaderadas de sándalo.', 3, 20),
(147, 'UU019', 'ERBA PURA', '/assets/images/perfumes/erba_pura.webp', 'Una cesta de frutas cítricas sicilianas y mediterráneas con un fondo de ámbar y almizcle.', 3, 54),
(148, 'UU022', 'HONOR & GLORY', '/assets/images/perfumes/perfume_6a1bc584a6ee5.png', 'Fragancia prestigiosa con piña, especias orientales y un fondo de maderas ricas.', 3, 20),
(149, 'UU023', 'SUBLIME', '/assets/images/perfumes/perfume_6a1bb45873521.png', 'Aroma sofisticado que mezcla notas florales y frutales con una elegancia atemporal.', 3, 20),
(150, 'CC919', 'PEGASUS', '/assets/images/perfumes/pegasus.png', 'Fragancia oriental elegante con almendra, vainilla y sándalo; cremosa, sofisticada y de alta duración.', 1, 55),
(151, 'UU020', 'BLEECKER STREET', '/assets/images/perfumes/bleecker.png', 'Aroma fresco amaderado con notas verdes, arándanos y pachulí; moderno y distintivo.', 3, 56),
(152, 'CC137', 'TOY BOY', '/assets/images/perfumes/TOYBOY.png', 'Perfume especiado y floral con rosa, pimienta y vetiver; masculino, moderno y atrevido.', 1, 43),
(153, 'DD147', 'DELINA', '/assets/images/perfumes/DELINA.png', 'Fragancia floral frutal con rosa turca, lichi y vainilla; femenina, elegante y envolvente.', 2, 55),
(154, 'DD925', 'MALLOW MADNESS', '/assets/images/perfumes/mallow.png', 'Aroma gourmand dulce con malvavisco, vainilla y notas cremosas; cálido y adictivo.', 2, 20),
(155, 'DD926', 'MOD VANILLA', '/assets/images/perfumes/MOD.png', 'Perfume suave y moderno con vainilla, cacao y almizcle; dulce, limpio y reconfortante.', 2, 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfume_componentes`
--

CREATE TABLE `perfume_componentes` (
  `perfume_id` int(11) NOT NULL,
  `componente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfume_componentes`
--

INSERT INTO `perfume_componentes` (`perfume_id`, `componente_id`) VALUES
(1, 1),
(11, 1),
(22, 1),
(33, 1),
(44, 1),
(1, 2),
(6, 2),
(13, 2),
(32, 2),
(37, 2),
(47, 2),
(50, 2),
(59, 2),
(61, 2),
(63, 2),
(87, 2),
(106, 2),
(127, 2),
(142, 2),
(153, 2),
(1, 3),
(11, 3),
(21, 3),
(63, 3),
(64, 3),
(143, 3),
(1, 4),
(3, 4),
(27, 4),
(60, 4),
(62, 4),
(66, 4),
(75, 4),
(114, 4),
(125, 4),
(128, 4),
(129, 4),
(147, 4),
(154, 4),
(2, 5),
(2, 6),
(8, 6),
(12, 6),
(15, 6),
(18, 6),
(20, 6),
(24, 6),
(25, 6),
(35, 6),
(39, 6),
(40, 6),
(41, 6),
(42, 6),
(45, 6),
(49, 6),
(53, 6),
(56, 6),
(62, 6),
(65, 6),
(77, 6),
(84, 6),
(85, 6),
(86, 6),
(89, 6),
(92, 6),
(94, 6),
(97, 6),
(99, 6),
(101, 6),
(102, 6),
(103, 6),
(106, 6),
(107, 6),
(109, 6),
(111, 6),
(112, 6),
(120, 6),
(123, 6),
(129, 6),
(130, 6),
(131, 6),
(134, 6),
(139, 6),
(141, 6),
(143, 6),
(144, 6),
(146, 6),
(147, 6),
(148, 6),
(149, 6),
(150, 6),
(154, 6),
(155, 6),
(2, 7),
(98, 7),
(3, 8),
(34, 8),
(80, 8),
(86, 8),
(132, 8),
(140, 8),
(144, 8),
(152, 8),
(3, 9),
(3, 10),
(4, 11),
(22, 11),
(4, 12),
(14, 12),
(16, 12),
(20, 12),
(24, 12),
(36, 12),
(47, 12),
(55, 12),
(59, 12),
(64, 12),
(73, 12),
(80, 12),
(81, 12),
(96, 12),
(108, 12),
(118, 12),
(4, 13),
(16, 13),
(36, 13),
(68, 13),
(70, 13),
(73, 13),
(78, 13),
(80, 13),
(90, 13),
(94, 13),
(100, 13),
(101, 13),
(111, 13),
(116, 13),
(117, 13),
(119, 13),
(124, 13),
(131, 13),
(137, 13),
(145, 13),
(151, 13),
(5, 14),
(5, 15),
(5, 16),
(6, 17),
(60, 17),
(6, 18),
(38, 18),
(41, 18),
(44, 18),
(71, 18),
(74, 18),
(76, 18),
(84, 18),
(88, 18),
(128, 18),
(135, 18),
(144, 18),
(7, 19),
(7, 20),
(9, 20),
(15, 20),
(7, 21),
(8, 22),
(20, 22),
(24, 22),
(25, 22),
(30, 22),
(31, 22),
(38, 22),
(39, 22),
(45, 22),
(48, 22),
(49, 22),
(50, 22),
(52, 22),
(55, 22),
(56, 22),
(60, 22),
(64, 22),
(85, 22),
(150, 22),
(9, 24),
(120, 24),
(9, 25),
(62, 25),
(10, 26),
(21, 26),
(10, 27),
(68, 27),
(10, 28),
(18, 28),
(25, 28),
(30, 28),
(31, 28),
(33, 28),
(68, 28),
(11, 29),
(32, 29),
(58, 29),
(83, 29),
(91, 29),
(153, 29),
(12, 30),
(20, 30),
(33, 30),
(35, 30),
(42, 30),
(51, 30),
(64, 30),
(81, 30),
(115, 30),
(149, 30),
(12, 31),
(34, 31),
(38, 31),
(42, 31),
(63, 31),
(143, 31),
(146, 31),
(148, 31),
(13, 32),
(18, 32),
(37, 32),
(136, 32),
(141, 32),
(13, 33),
(17, 33),
(65, 33),
(78, 33),
(155, 33),
(13, 34),
(145, 34),
(14, 35),
(14, 36),
(17, 36),
(15, 37),
(16, 38),
(17, 39),
(23, 39),
(47, 39),
(54, 39),
(60, 39),
(62, 39),
(69, 39),
(86, 39),
(109, 39),
(111, 39),
(119, 39),
(121, 39),
(137, 39),
(19, 40),
(26, 40),
(40, 40),
(43, 40),
(46, 40),
(47, 40),
(55, 40),
(85, 40),
(88, 40),
(93, 40),
(100, 40),
(118, 40),
(137, 40),
(142, 40),
(19, 41),
(46, 41),
(75, 41),
(76, 41),
(113, 41),
(115, 41),
(19, 42),
(45, 42),
(8, 43),
(21, 43),
(22, 44),
(23, 45),
(23, 46),
(66, 46),
(126, 46),
(24, 47),
(52, 47),
(26, 48),
(28, 48),
(101, 48),
(26, 49),
(27, 50),
(99, 50),
(27, 51),
(28, 52),
(32, 52),
(40, 52),
(43, 52),
(91, 52),
(94, 52),
(110, 52),
(135, 52),
(136, 52),
(140, 52),
(144, 52),
(148, 52),
(150, 52),
(28, 53),
(74, 53),
(86, 53),
(147, 53),
(29, 54),
(29, 55),
(53, 55),
(29, 56),
(71, 56),
(30, 57),
(72, 57),
(31, 58),
(34, 59),
(35, 60),
(36, 61),
(53, 61),
(61, 61),
(148, 61),
(36, 62),
(61, 62),
(69, 62),
(84, 62),
(118, 62),
(124, 62),
(36, 63),
(36, 64),
(40, 64),
(72, 64),
(73, 64),
(74, 64),
(88, 64),
(90, 64),
(96, 64),
(97, 64),
(98, 64),
(99, 64),
(105, 64),
(123, 64),
(149, 64),
(152, 64),
(153, 64),
(37, 65),
(74, 65),
(92, 65),
(104, 65),
(129, 65),
(131, 65),
(139, 65),
(38, 66),
(119, 66),
(146, 66),
(39, 67),
(44, 67),
(60, 67),
(76, 67),
(82, 67),
(83, 67),
(113, 67),
(119, 67),
(136, 67),
(41, 68),
(58, 68),
(43, 69),
(43, 70),
(61, 70),
(81, 70),
(100, 70),
(142, 70),
(151, 70),
(44, 71),
(91, 71),
(95, 71),
(149, 71),
(44, 72),
(46, 73),
(145, 73),
(47, 74),
(152, 74),
(47, 75),
(54, 75),
(151, 75),
(48, 76),
(52, 76),
(48, 77),
(49, 78),
(56, 78),
(51, 79),
(52, 80),
(54, 81),
(57, 82),
(57, 83),
(58, 84),
(59, 85),
(63, 85),
(82, 85),
(60, 86),
(65, 86),
(60, 87),
(61, 87),
(90, 87),
(63, 88),
(63, 89),
(64, 90),
(64, 91),
(64, 92),
(65, 93),
(66, 94),
(67, 95),
(79, 95),
(121, 95),
(67, 96),
(67, 97),
(121, 97),
(69, 98),
(115, 98),
(70, 99),
(70, 100),
(83, 100),
(119, 100),
(71, 101),
(107, 101),
(72, 102),
(73, 103),
(75, 104),
(76, 105),
(77, 106),
(126, 106),
(77, 107),
(78, 108),
(87, 108),
(110, 108),
(131, 108),
(136, 108),
(79, 109),
(144, 109),
(79, 110),
(97, 110),
(122, 110),
(137, 110),
(144, 110),
(82, 111),
(109, 111),
(87, 112),
(117, 112),
(129, 112),
(89, 113),
(89, 114),
(92, 115),
(92, 116),
(93, 117),
(93, 118),
(96, 118),
(95, 119),
(103, 119),
(95, 120),
(96, 121),
(98, 122),
(106, 122),
(127, 122),
(98, 123),
(99, 124),
(100, 125),
(114, 125),
(118, 125),
(132, 125),
(144, 125),
(154, 125),
(102, 126),
(109, 126),
(102, 127),
(103, 128),
(104, 128),
(154, 128),
(104, 129),
(143, 129),
(155, 129),
(105, 130),
(105, 131),
(143, 131),
(106, 132),
(112, 132),
(150, 132),
(107, 133),
(126, 133),
(108, 134),
(108, 135),
(113, 135),
(108, 136),
(110, 137),
(111, 138),
(112, 139),
(112, 140),
(128, 140),
(114, 141),
(122, 141),
(114, 142),
(114, 143),
(132, 143),
(115, 144),
(115, 145),
(116, 146),
(140, 146),
(116, 147),
(117, 148),
(144, 148),
(118, 149),
(134, 149),
(154, 149),
(118, 150),
(141, 150),
(118, 151),
(119, 151),
(120, 152),
(120, 153),
(120, 154),
(120, 155),
(122, 156),
(123, 157),
(139, 157),
(124, 158),
(125, 159),
(127, 160),
(127, 161),
(128, 162),
(128, 163),
(129, 164),
(130, 166),
(130, 167),
(130, 168),
(131, 169),
(141, 169),
(133, 170),
(133, 171),
(133, 172),
(134, 173),
(134, 174),
(135, 175),
(135, 176),
(137, 177),
(138, 178),
(139, 179),
(139, 180),
(141, 181),
(142, 182),
(143, 183),
(143, 184),
(148, 185),
(151, 186),
(151, 187);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfume_tipos_aroma`
--

CREATE TABLE `perfume_tipos_aroma` (
  `perfume_id` int(11) NOT NULL,
  `tipo_aroma_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfume_tipos_aroma`
--

INSERT INTO `perfume_tipos_aroma` (`perfume_id`, `tipo_aroma_id`) VALUES
(1, 1),
(4, 1),
(6, 1),
(7, 1),
(10, 1),
(11, 1),
(14, 1),
(16, 1),
(20, 1),
(21, 1),
(22, 1),
(30, 1),
(32, 1),
(33, 1),
(40, 1),
(43, 1),
(46, 1),
(47, 1),
(58, 1),
(59, 1),
(66, 1),
(68, 1),
(71, 1),
(73, 1),
(74, 1),
(81, 1),
(85, 1),
(87, 1),
(88, 1),
(90, 1),
(93, 1),
(96, 1),
(100, 1),
(106, 1),
(108, 1),
(109, 1),
(123, 1),
(127, 1),
(147, 1),
(1, 2),
(5, 2),
(10, 2),
(14, 2),
(18, 2),
(31, 2),
(33, 2),
(63, 2),
(68, 2),
(81, 2),
(151, 2),
(1, 3),
(2, 4),
(16, 4),
(2, 5),
(12, 5),
(18, 5),
(19, 5),
(20, 5),
(24, 5),
(25, 5),
(34, 5),
(35, 5),
(39, 5),
(40, 5),
(41, 5),
(42, 5),
(45, 5),
(48, 5),
(65, 5),
(84, 5),
(86, 5),
(89, 5),
(92, 5),
(94, 5),
(99, 5),
(101, 5),
(102, 5),
(106, 5),
(107, 5),
(109, 5),
(112, 5),
(120, 5),
(123, 5),
(131, 5),
(146, 5),
(149, 5),
(150, 5),
(155, 5),
(2, 6),
(4, 6),
(7, 6),
(8, 6),
(18, 6),
(19, 6),
(22, 6),
(24, 6),
(25, 6),
(30, 6),
(31, 6),
(36, 6),
(37, 6),
(45, 6),
(63, 6),
(64, 6),
(151, 6),
(2, 7),
(14, 7),
(17, 7),
(24, 7),
(26, 7),
(27, 7),
(29, 7),
(33, 7),
(48, 7),
(63, 7),
(75, 7),
(104, 7),
(106, 7),
(114, 7),
(118, 7),
(134, 7),
(138, 7),
(140, 7),
(145, 7),
(153, 7),
(155, 7),
(2, 8),
(9, 8),
(15, 8),
(18, 8),
(20, 8),
(23, 8),
(25, 8),
(28, 8),
(32, 8),
(34, 8),
(36, 8),
(41, 8),
(42, 8),
(43, 8),
(45, 8),
(46, 8),
(49, 8),
(61, 8),
(68, 8),
(71, 8),
(72, 8),
(80, 8),
(82, 8),
(89, 8),
(91, 8),
(92, 8),
(97, 8),
(118, 8),
(120, 8),
(122, 8),
(124, 8),
(128, 8),
(136, 8),
(145, 8),
(153, 8),
(3, 9),
(15, 9),
(16, 9),
(19, 9),
(24, 9),
(28, 9),
(34, 9),
(39, 9),
(44, 9),
(46, 9),
(49, 9),
(56, 9),
(65, 9),
(68, 9),
(69, 9),
(71, 9),
(73, 9),
(75, 9),
(78, 9),
(79, 9),
(83, 9),
(84, 9),
(86, 9),
(91, 9),
(95, 9),
(100, 9),
(104, 9),
(107, 9),
(112, 9),
(113, 9),
(114, 9),
(115, 9),
(117, 9),
(123, 9),
(124, 9),
(125, 9),
(126, 9),
(130, 9),
(131, 9),
(135, 9),
(136, 9),
(137, 9),
(139, 9),
(140, 9),
(143, 9),
(146, 9),
(147, 9),
(148, 9),
(150, 9),
(155, 9),
(3, 10),
(12, 10),
(26, 10),
(27, 10),
(28, 10),
(34, 10),
(35, 10),
(53, 10),
(61, 10),
(65, 10),
(67, 10),
(69, 10),
(73, 10),
(79, 10),
(80, 10),
(84, 10),
(91, 10),
(93, 10),
(95, 10),
(97, 10),
(99, 10),
(100, 10),
(101, 10),
(103, 10),
(104, 10),
(105, 10),
(109, 10),
(110, 10),
(116, 10),
(117, 10),
(118, 10),
(122, 10),
(126, 10),
(129, 10),
(130, 10),
(132, 10),
(133, 10),
(134, 10),
(135, 10),
(136, 10),
(137, 10),
(138, 10),
(139, 10),
(140, 10),
(142, 10),
(144, 10),
(147, 10),
(148, 10),
(149, 10),
(151, 10),
(154, 10),
(3, 11),
(3, 12),
(4, 12),
(8, 12),
(18, 12),
(24, 12),
(37, 12),
(45, 12),
(46, 12),
(69, 12),
(73, 12),
(78, 12),
(79, 12),
(86, 12),
(100, 12),
(104, 12),
(106, 12),
(123, 12),
(126, 12),
(127, 12),
(143, 12),
(146, 12),
(147, 12),
(151, 12),
(152, 12),
(3, 13),
(4, 13),
(6, 13),
(10, 13),
(21, 13),
(29, 13),
(38, 13),
(40, 13),
(46, 13),
(47, 13),
(51, 13),
(57, 13),
(58, 13),
(60, 13),
(64, 13),
(68, 13),
(73, 13),
(77, 13),
(81, 13),
(85, 13),
(100, 13),
(106, 13),
(108, 13),
(118, 13),
(121, 13),
(128, 13),
(129, 13),
(147, 13),
(149, 13),
(150, 13),
(4, 14),
(10, 14),
(21, 14),
(22, 14),
(51, 14),
(58, 14),
(128, 14),
(129, 14),
(142, 14),
(5, 15),
(6, 15),
(8, 15),
(12, 15),
(14, 15),
(15, 15),
(17, 15),
(32, 15),
(36, 15),
(37, 15),
(38, 15),
(40, 15),
(43, 15),
(44, 15),
(45, 15),
(48, 15),
(50, 15),
(51, 15),
(52, 15),
(53, 15),
(55, 15),
(60, 15),
(61, 15),
(62, 15),
(64, 15),
(67, 15),
(71, 15),
(72, 15),
(73, 15),
(81, 15),
(89, 15),
(90, 15),
(92, 15),
(95, 15),
(100, 15),
(108, 15),
(110, 15),
(111, 15),
(119, 15),
(148, 15),
(151, 15),
(152, 15),
(5, 16),
(26, 16),
(28, 16),
(101, 16),
(117, 16),
(139, 16),
(149, 16),
(5, 17),
(9, 17),
(15, 17),
(19, 17),
(20, 17),
(23, 17),
(28, 17),
(34, 17),
(36, 17),
(41, 17),
(42, 17),
(50, 17),
(53, 17),
(54, 17),
(58, 17),
(60, 17),
(61, 17),
(62, 17),
(65, 17),
(70, 17),
(72, 17),
(76, 17),
(82, 17),
(89, 17),
(91, 17),
(92, 17),
(110, 17),
(128, 17),
(129, 17),
(132, 17),
(136, 17),
(141, 17),
(146, 17),
(152, 17),
(154, 17),
(7, 18),
(9, 18),
(15, 18),
(8, 19),
(11, 19),
(13, 19),
(23, 19),
(25, 19),
(26, 19),
(30, 19),
(31, 19),
(33, 19),
(41, 19),
(52, 19),
(59, 19),
(63, 19),
(9, 20),
(9, 21),
(17, 21),
(38, 21),
(42, 21),
(43, 21),
(50, 21),
(78, 21),
(146, 21),
(148, 21),
(9, 22),
(20, 22),
(31, 22),
(32, 22),
(34, 22),
(36, 22),
(54, 22),
(60, 22),
(11, 23),
(94, 23),
(17, 25),
(19, 26),
(46, 26),
(75, 26),
(114, 26),
(20, 27),
(45, 27),
(23, 28),
(24, 28),
(41, 28),
(42, 28),
(48, 28),
(54, 28),
(62, 28),
(69, 28),
(91, 28),
(102, 28),
(145, 28),
(23, 29),
(27, 30),
(66, 30),
(75, 30),
(127, 30),
(27, 31),
(55, 31),
(66, 31),
(67, 31),
(68, 31),
(70, 31),
(72, 31),
(77, 31),
(78, 31),
(79, 31),
(80, 31),
(82, 31),
(83, 31),
(85, 31),
(86, 31),
(92, 31),
(93, 31),
(97, 31),
(98, 31),
(100, 31),
(103, 31),
(104, 31),
(105, 31),
(106, 31),
(108, 31),
(110, 31),
(111, 31),
(116, 31),
(118, 31),
(119, 31),
(120, 31),
(121, 31),
(122, 31),
(123, 31),
(124, 31),
(126, 31),
(127, 31),
(128, 31),
(129, 31),
(132, 31),
(133, 31),
(134, 31),
(135, 31),
(136, 31),
(137, 31),
(138, 31),
(139, 31),
(141, 31),
(145, 31),
(153, 31),
(154, 31),
(29, 32),
(29, 33),
(121, 33),
(29, 34),
(49, 34),
(56, 34),
(65, 34),
(98, 34),
(143, 34),
(152, 34),
(35, 35),
(74, 35),
(88, 35),
(98, 35),
(99, 35),
(39, 36),
(82, 36),
(83, 36),
(41, 37),
(42, 37),
(46, 37),
(52, 37),
(53, 37),
(107, 37),
(109, 37),
(112, 37),
(113, 37),
(115, 37),
(117, 37),
(130, 37),
(143, 37),
(145, 37),
(146, 37),
(154, 37),
(44, 38),
(50, 39),
(72, 39),
(77, 39),
(94, 39),
(97, 39),
(107, 39),
(109, 39),
(111, 39),
(112, 39),
(130, 39),
(131, 39),
(54, 40),
(54, 41),
(73, 41),
(74, 41),
(88, 41),
(54, 42),
(54, 43),
(57, 44),
(58, 45),
(65, 46),
(70, 47),
(76, 48),
(85, 49),
(87, 50),
(96, 50),
(90, 51),
(113, 52),
(115, 52),
(125, 52),
(155, 52),
(115, 53),
(141, 54);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  `frasco_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `umbral_bajo` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `ciudad` varchar(80) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `nombre`, `ciudad`, `activo`) VALUES
(1, 'Tienda Chiclayo', 'Chiclayo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_aroma`
--

CREATE TABLE `tipos_aroma` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL COMMENT 'aroma | etiqueta | sensacion | perfil'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_aroma`
--

INSERT INTO `tipos_aroma` (`id`, `nombre`, `categoria`) VALUES
(1, 'CITRICO', 'perfil'),
(2, 'VERDE', 'perfil'),
(3, 'CALIDO', 'perfil'),
(4, 'ESPECIADO SUAVE', 'perfil'),
(5, 'AVAINILLADO', 'perfil'),
(6, 'AROMATICO', 'perfil'),
(7, 'SUAVE', 'perfil'),
(8, 'NOCTURNO', 'perfil'),
(9, 'DULCE', 'perfil'),
(10, 'FRUTAL', 'perfil'),
(11, 'HERBAL', 'perfil'),
(12, 'JUVENIL', 'perfil'),
(13, 'FRESCO', 'perfil'),
(14, 'MARINO', 'perfil'),
(15, 'AMADERADO', 'perfil'),
(16, 'TROPICAL', 'perfil'),
(17, 'FUERTE', 'perfil'),
(18, 'CUERO', 'perfil'),
(19, 'FRESCO ESPECIADO', 'perfil'),
(20, 'OUD', 'perfil'),
(21, 'CALIDO ESPECIADO', 'perfil'),
(22, 'ULTRAMACHO', 'perfil'),
(23, 'BALSAMICO', 'perfil'),
(25, 'CACAO', 'perfil'),
(26, 'CARAMELO', 'perfil'),
(27, 'LAVANDA', 'perfil'),
(28, 'AMBAR', 'perfil'),
(29, 'WHISKY', 'perfil'),
(30, 'ALMIZCLADO', 'perfil'),
(31, 'FLORAL', 'perfil'),
(32, 'OZONICO', 'perfil'),
(33, 'ACUATICO', 'perfil'),
(34, 'ESPECIADO', 'perfil'),
(35, 'ROSAS', 'perfil'),
(36, 'AMIELADO', 'perfil'),
(37, 'ARABE', 'perfil'),
(38, 'NUECES', 'perfil'),
(39, 'ATALCADO', 'perfil'),
(40, 'CUERO NEGRO', 'perfil'),
(41, 'PACHULI', 'perfil'),
(42, 'VETIVER', 'perfil'),
(43, 'MUSGO', 'perfil'),
(44, 'CITRICO DE ITALIA', 'perfil'),
(45, 'TERROSO', 'perfil'),
(46, 'TABACO', 'perfil'),
(47, 'ELEGANTE', 'perfil'),
(48, 'AMIELADO DULCE', 'perfil'),
(49, 'LAVANDER', 'perfil'),
(50, 'FLORAL BLANCO', 'perfil'),
(51, 'FLOR BLANCO', 'perfil'),
(52, 'CREMOSO', 'perfil'),
(53, 'MALVAVISCO', 'perfil'),
(54, 'ORIENTAL', 'perfil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `usuario` varchar(60) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `rol` enum('admin','vendedor') NOT NULL DEFAULT 'vendedor',
  `sucursal_id` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password_hash`, `rol`, `sucursal_id`, `activo`, `creado_en`) VALUES
(1, 'Admin', 'admin', '$2y$12$JcDadm8TWuOURQu1g1QPs.uMKvdK8RGSjPIlQYu4DhGcwoihig5y2', 'admin', NULL, 1, '2026-05-29 23:07:10'),
(2, 'Yanella', 'chiclayo', '$2y$12$JcDadm8TWuOURQu1g1QPs.uMKvdK8RGSjPIlQYu4DhGcwoihig5y2', 'vendedor', 1, 1, '2026-05-29 23:07:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  `vendedor_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `metodo_pago` enum('efectivo','yape_plin','tarjeta','otro') NOT NULL DEFAULT 'efectivo',
  `nota` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_items`
--

CREATE TABLE `venta_items` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `perfume_id` int(11) NOT NULL,
  `frasco_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `idx_componentes_nombre` (`nombre`);

--
-- Indices de la tabla `designers`
--
ALTER TABLE `designers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `frascos`
--
ALTER TABLE `frascos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_frasco_cat` (`categoria`,`orden`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `movimientos_stock`
--
ALTER TABLE `movimientos_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mov_fecha` (`fecha`),
  ADD KEY `fk_mov_sucursal` (`sucursal_id`),
  ADD KEY `fk_mov_frasco` (`frasco_id`);

--
-- Indices de la tabla `perfumes`
--
ALTER TABLE `perfumes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `genero_id` (`genero_id`),
  ADD KEY `designer_id` (`designer_id`),
  ADD KEY `idx_perfumes_codigo` (`codigo`),
  ADD KEY `idx_perfumes_referencia` (`referencia`);

--
-- Indices de la tabla `perfume_componentes`
--
ALTER TABLE `perfume_componentes`
  ADD PRIMARY KEY (`perfume_id`,`componente_id`),
  ADD KEY `componente_id` (`componente_id`),
  ADD KEY `idx_pc_perfume` (`perfume_id`),
  ADD KEY `idx_pc_componente` (`componente_id`);

--
-- Indices de la tabla `perfume_tipos_aroma`
--
ALTER TABLE `perfume_tipos_aroma`
  ADD PRIMARY KEY (`perfume_id`,`tipo_aroma_id`),
  ADD KEY `tipo_aroma_id` (`tipo_aroma_id`),
  ADD KEY `idx_pta_perfume` (`perfume_id`),
  ADD KEY `idx_pta_tipo` (`tipo_aroma_id`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_stock` (`sucursal_id`,`frasco_id`),
  ADD KEY `fk_stock_frasco` (`frasco_id`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_aroma`
--
ALTER TABLE `tipos_aroma`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `nombre_2` (`nombre`),
  ADD KEY `idx_tipos_aroma_nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `fk_usuarios_sucursal` (`sucursal_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ventas_fecha` (`fecha`),
  ADD KEY `idx_ventas_suc_fecha` (`sucursal_id`,`fecha`),
  ADD KEY `fk_ventas_vendedor` (`vendedor_id`);

--
-- Indices de la tabla `venta_items`
--
ALTER TABLE `venta_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_venta` (`venta_id`),
  ADD KEY `fk_items_perfume` (`perfume_id`),
  ADD KEY `fk_items_frasco` (`frasco_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `componentes`
--
ALTER TABLE `componentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `designers`
--
ALTER TABLE `designers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `frascos`
--
ALTER TABLE `frascos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `movimientos_stock`
--
ALTER TABLE `movimientos_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfumes`
--
ALTER TABLE `perfumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipos_aroma`
--
ALTER TABLE `tipos_aroma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta_items`
--
ALTER TABLE `venta_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `movimientos_stock`
--
ALTER TABLE `movimientos_stock`
  ADD CONSTRAINT `fk_mov_frasco` FOREIGN KEY (`frasco_id`) REFERENCES `frascos` (`id`),
  ADD CONSTRAINT `fk_mov_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`);

--
-- Filtros para la tabla `perfumes`
--
ALTER TABLE `perfumes`
  ADD CONSTRAINT `perfumes_ibfk_1` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`),
  ADD CONSTRAINT `perfumes_ibfk_2` FOREIGN KEY (`designer_id`) REFERENCES `designers` (`id`);

--
-- Filtros para la tabla `perfume_componentes`
--
ALTER TABLE `perfume_componentes`
  ADD CONSTRAINT `perfume_componentes_ibfk_1` FOREIGN KEY (`perfume_id`) REFERENCES `perfumes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `perfume_componentes_ibfk_2` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `perfume_tipos_aroma`
--
ALTER TABLE `perfume_tipos_aroma`
  ADD CONSTRAINT `perfume_tipos_aroma_ibfk_1` FOREIGN KEY (`perfume_id`) REFERENCES `perfumes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `perfume_tipos_aroma_ibfk_2` FOREIGN KEY (`tipo_aroma_id`) REFERENCES `tipos_aroma` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_stock_frasco` FOREIGN KEY (`frasco_id`) REFERENCES `frascos` (`id`),
  ADD CONSTRAINT `fk_stock_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`),
  ADD CONSTRAINT `fk_ventas_vendedor` FOREIGN KEY (`vendedor_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `venta_items`
--
ALTER TABLE `venta_items`
  ADD CONSTRAINT `fk_items_frasco` FOREIGN KEY (`frasco_id`) REFERENCES `frascos` (`id`),
  ADD CONSTRAINT `fk_items_perfume` FOREIGN KEY (`perfume_id`) REFERENCES `perfumes` (`id`),
  ADD CONSTRAINT `fk_items_venta` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
