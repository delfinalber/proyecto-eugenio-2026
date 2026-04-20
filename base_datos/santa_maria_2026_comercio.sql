-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-04-2026 a las 20:49:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `santa_maria_2026_comercio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `documento_cliente` int(11) DEFAULT NULL,
  `nombre_cliente` varchar(100) DEFAULT NULL,
  `direccion_cliente` varchar(100) DEFAULT NULL,
  `pais_cliente` varchar(100) DEFAULT NULL,
  `telefono_cliente` varchar(100) DEFAULT NULL,
  `fecha_pedido_cliente` date DEFAULT NULL,
  `vendedor_cliente` varchar(100) DEFAULT NULL,
  `region_cliente` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `documento_cliente`, `nombre_cliente`, `direccion_cliente`, `pais_cliente`, `telefono_cliente`, `fecha_pedido_cliente`, `vendedor_cliente`, `region_cliente`) VALUES
(1, 101001, 'Anan Torres', 'Calle 10 # 12-34', 'Colombia', '3001112233', '2026-04-10', 'Carlos Mendez', 'Andina'),
(2, 101002, 'Santiago Sandino', 'Calle 50 # 13-16', 'Venezuela', '3012345685', '2026-04-10', 'Juan Daniel Cruz', 'Caribe'),
(3, 101003, 'Pepito perez', 'Carrera 49 # 32-60', 'Colombia', '3103345188', '2026-03-12', 'Julio Ortiz', 'Amazonica'),
(4, 101004, 'Laura Gomez', 'Calle 23 # 15-20', 'Colombia', '3204456677', '2026-03-15', 'Carlos Mendez', 'Andina'),
(5, 101005, 'Mateo Rojas', 'Avenida 7 # 45-12', 'Ecuador', '3115567788', '2026-03-16', 'Juan Daniel Cruz', 'Pacifica'),
(6, 101006, 'Camila Diaz', 'Calle 80 # 10-33', 'Colombia', '3126678899', '2026-03-18', 'Julio Ortiz', 'Caribe'),
(7, 101007, 'Daniel Ruiz', 'Carrera 14 # 8-19', 'Peru', '3137789900', '2026-03-20', 'Carlos Mendez', 'Andina'),
(8, 101008, 'Valentina Mora', 'Calle 9 # 22-11', 'Colombia', '3148890011', '2026-03-22', 'Juan Daniel Cruz', 'Amazonica'),
(9, 101009, 'Andres Castro', 'Avenida 30 # 44-18', 'Chile', '3159901122', '2026-03-24', 'Julio Ortiz', 'Pacifica'),
(10, 101010, 'Sofia Lara', 'Calle 66 # 19-08', 'Colombia', '3161012233', '2026-03-25', 'Carlos Mendez', 'Caribe'),
(11, 101011, 'Nicolas Parra', 'Carrera 3 # 70-55', 'Colombia', '3172123344', '2026-03-27', 'Juan Daniel Cruz', 'Andina'),
(12, 101012, 'Mariana Vega', 'Calle 18 # 5-41', 'Panama', '3183234455', '2026-03-29', 'Julio Ortiz', 'Pacifica'),
(13, 101013, 'Felipe Naranjo', 'Avenida 12 # 60-31', 'Colombia', '3194345566', '2026-04-01', 'Carlos Mendez', 'Amazonica'),
(14, 101014, 'Daniela Cifuentes', 'Calle 27 # 13-07', 'Colombia', '3005456677', '2026-04-04', 'Juan Daniel Cruz', 'Caribe'),
(15, 101015, 'Jorge Salinas', 'Carrera 21 # 17-40', 'Bolivia', '3016567788', '2026-04-06', 'Julio Ortiz', 'Andina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos_linea`
--

CREATE TABLE `elementos_linea` (
  `id_elementos_linea` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio_unidad_elementos_linea` int(10) DEFAULT NULL,
  `cantidad_elemnetos_linea` int(3) DEFAULT NULL,
  `precio_ampliado_elementos_linea` int(10) DEFAULT NULL,
  `nombre_producto_elemnetos_linea` varchar(100) DEFAULT NULL,
  `total_elementos_linea` int(10) DEFAULT NULL,
  `cantidad_existencia_elemnetos_linea` int(3) DEFAULT NULL,
  `fecha_pedido_elementos_linea` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `elementos_linea`
--

INSERT INTO `elementos_linea` (`id_elementos_linea`, `id_factura`, `id_producto`, `precio_unidad_elementos_linea`, `cantidad_elemnetos_linea`, `precio_ampliado_elementos_linea`, `nombre_producto_elemnetos_linea`, `total_elementos_linea`, `cantidad_existencia_elemnetos_linea`, `fecha_pedido_elementos_linea`) VALUES
(1, 1, 1, 25000, 2, 50000, 'Arroz Premium 1kg', 50000, 118, '2026-04-10'),
(2, 2, 2, 3800, 10, 38000, 'Leche Entera 1L', 38000, 170, '2026-04-10'),
(3, 3, 3, 6200, 4, 24800, 'Cafe Molido 500g', 24800, 126, '2026-03-12'),
(4, 4, 4, 12000, 3, 36000, 'Aceite Vegetal 1L', 36000, 107, '2026-03-15'),
(5, 5, 5, 4500, 6, 27000, 'Azucar Blanca 1kg', 27000, 194, '2026-03-16'),
(6, 6, 6, 9000, 2, 18000, 'Pasta Spaghetti 500g', 18000, 148, '2026-03-18'),
(7, 7, 7, 5200, 5, 26000, 'Atun Enlatado 170g', 26000, 135, '2026-03-20'),
(8, 8, 8, 7600, 3, 22800, 'Galletas Integrales', 22800, 117, '2026-03-22'),
(9, 9, 9, 10500, 2, 21000, 'Queso Campesino 400g', 21000, 88, '2026-03-24'),
(10, 10, 10, 6800, 4, 27200, 'Yogur Natural 1L', 27200, 156, '2026-03-25'),
(11, 11, 11, 4200, 7, 29400, 'Pan Tajado Integral', 29400, 143, '2026-03-27'),
(12, 12, 12, 8300, 3, 24900, 'Jabon Liquido 1L', 24900, 112, '2026-03-29'),
(13, 13, 13, 15000, 2, 30000, 'Detergente 2kg', 30000, 98, '2026-04-01'),
(14, 14, 14, 5400, 6, 32400, 'Huevos Docena', 32400, 214, '2026-04-04'),
(15, 15, 15, 7200, 5, 36000, 'Harina de Trigo 1kg', 36000, 160, '2026-04-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_pedido_factura` date DEFAULT NULL,
  `subtotal_factura` int(6) DEFAULT NULL,
  `descuento_factura` int(6) DEFAULT NULL,
  `region_factura` varchar(100) DEFAULT NULL,
  `vendedor_factura` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `id_cliente`, `fecha_pedido_factura`, `subtotal_factura`, `descuento_factura`, `region_factura`, `vendedor_factura`) VALUES
(1, 1, '2026-04-10', 50000, 2500, 'Andina', 'Carlos Mendez'),
(2, 2, '2026-04-10', 38000, 1900, 'Caribe', 'Juan Daniel Cruz'),
(3, 3, '2026-03-12', 24800, 0, 'Amazonica', 'Julio Ortiz'),
(4, 4, '2026-03-15', 36000, 1800, 'Andina', 'Carlos Mendez'),
(5, 5, '2026-03-16', 27000, 1350, 'Pacifica', 'Juan Daniel Cruz'),
(6, 6, '2026-03-18', 18000, 0, 'Caribe', 'Julio Ortiz'),
(7, 7, '2026-03-20', 26000, 1300, 'Andina', 'Carlos Mendez'),
(8, 8, '2026-03-22', 22800, 1140, 'Amazonica', 'Juan Daniel Cruz'),
(9, 9, '2026-03-24', 21000, 0, 'Pacifica', 'Julio Ortiz'),
(10, 10, '2026-03-25', 27200, 1360, 'Caribe', 'Carlos Mendez'),
(11, 11, '2026-03-27', 29400, 1470, 'Andina', 'Juan Daniel Cruz'),
(12, 12, '2026-03-29', 24900, 0, 'Pacifica', 'Julio Ortiz'),
(13, 13, '2026-04-01', 30000, 1500, 'Amazonica', 'Carlos Mendez'),
(14, 14, '2026-04-04', 32400, 1620, 'Caribe', 'Juan Daniel Cruz'),
(15, 15, '2026-04-06', 36000, 1800, 'Andina', 'Julio Ortiz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) DEFAULT NULL,
  `precio_unidad_producto` int(6) DEFAULT NULL,
  `numero_existencia_producto` int(4) DEFAULT NULL,
  `categoria_producto` varchar(100) DEFAULT NULL,
  `descuento_producto` int(6) DEFAULT NULL,
  `cantidad_total_existencia_producto` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `precio_unidad_producto`, `numero_existencia_producto`, `categoria_producto`, `descuento_producto`, `cantidad_total_existencia_producto`) VALUES
(1, 'Arroz Premium 1kg', 25000, 120, 'Granos', 5, 120),
(2, 'Leche Entera 1L', 3800, 180, 'Lacteos', 3, 180),
(3, 'Cafe Molido 500g', 6200, 130, 'Bebidas', 0, 130),
(4, 'Aceite Vegetal 1L', 12000, 110, 'Despensa', 5, 110),
(5, 'Azucar Blanca 1kg', 4500, 200, 'Despensa', 2, 200),
(6, 'Pasta Spaghetti 500g', 9000, 150, 'Despensa', 0, 150),
(7, 'Atun Enlatado 170g', 5200, 140, 'Enlatados', 4, 140),
(8, 'Galletas Integrales', 7600, 120, 'Snacks', 3, 120),
(9, 'Queso Campesino 400g', 10500, 90, 'Lacteos', 0, 90),
(10, 'Yogur Natural 1L', 6800, 160, 'Lacteos', 2, 160),
(11, 'Pan Tajado Integral', 4200, 150, 'Panaderia', 1, 150),
(12, 'Jabon Liquido 1L', 8300, 115, 'Aseo', 3, 115),
(13, 'Detergente 2kg', 15000, 100, 'Aseo', 5, 100),
(14, 'Huevos Docena', 5400, 220, 'Canasta Familiar', 2, 220),
(15, 'Harina de Trigo 1kg', 7200, 165, 'Despensa', 4, 165);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `documento_cliente` (`documento_cliente`);

--
-- Indices de la tabla `elementos_linea`
--
ALTER TABLE `elementos_linea`
  ADD PRIMARY KEY (`id_elementos_linea`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `elementos_linea`
--
ALTER TABLE `elementos_linea`
  ADD CONSTRAINT `elementos_linea_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`),
  ADD CONSTRAINT `elementos_linea_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
