-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-04-2026 a las 17:23:11
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
-- Base de datos: `eugenio_2026_comercio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nom_cliente` varchar(100) DEFAULT NULL,
  `direccion_cliente` varchar(100) DEFAULT NULL,
  `pais_cliente` varchar(100) DEFAULT NULL,
  `telefono` bigint(12) DEFAULT NULL,
  `fecha_pedido_cliente` date DEFAULT NULL,
  `vendedor_cliente` varchar(100) DEFAULT NULL,
  `region_cliente` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nom_cliente`, `direccion_cliente`, `pais_cliente`, `telefono`, `fecha_pedido_cliente`, `vendedor_cliente`, `region_cliente`) VALUES
(1, 'Luz Adriana Basques', 'Calle 12 # 14-31', 'Colombia', 3001112233, '2026-03-22', 'Carlos Mendez', 'Caribe'),
(2, 'Oscar Muñoz', 'Carrera 45 # 12-45', 'Venezuela', 3103345176, '2026-02-23', 'Jose Gutierrez', 'Andina'),
(3, 'Jose Celestino Mutis', 'Calle 54 # 18-26', 'Venezuela', 3001544789, '2026-01-23', 'Hugo Rodallega', 'Caribe'),
(4, 'María Elena Torres', 'Av. Principal # 23-45', 'Colombia', 3152223344, '2026-01-15', 'Carlos Mendez', 'Andina'),
(5, 'Andrés Felipe Gómez', 'Calle 78 # 45-12', 'Argentina', 3004456789, '2026-02-10', 'Hugo Rodallega', 'Sur'),
(6, 'Valentina Ramírez', 'Carrera 12 # 34-56', 'Chile', 3176667788, '2026-03-05', 'Jose Gutierrez', 'Pacífico'),
(7, 'Carlos Alberto Ruiz', 'Calle 23 # 67-89', 'México', 3018889900, '2026-01-20', 'Carlos Mendez', 'Norte'),
(8, 'Luisa Fernanda Mora', 'Av. Las Américas # 12-34', 'Perú', 3209990011, '2026-02-28', 'Hugo Rodallega', 'Andina'),
(9, 'Sebastián López', 'Carrera 56 # 78-90', 'Ecuador', 3001112244, '2026-03-15', 'Jose Gutierrez', 'Caribe'),
(10, 'Ana Milena Vargas', 'Calle 89 # 23-45', 'Bolivia', 3153334455, '2026-01-25', 'Carlos Mendez', 'Sur'),
(11, 'Daniel Alejandro Castro', 'Av. Central # 45-67', 'Paraguay', 3005556677, '2026-02-14', 'Hugo Rodallega', 'Sur'),
(12, 'Paola Andrea Herrera', 'Carrera 34 # 56-78', 'Uruguay', 3177778899, '2026-03-01', 'Jose Gutierrez', 'Sur'),
(13, 'Juan Camilo Pérez', 'Calle 45 # 89-01', 'Panamá', 3019990012, '2026-01-30', 'Carlos Mendez', 'Norte'),
(14, 'Sandra Milena Jiménez', 'Av. del Parque # 23-56', 'Cuba', 3211112233, '2026-02-20', 'Hugo Rodallega', 'Caribe'),
(15, 'Ricardo Esteban Blanco', 'Carrera 67 # 12-34', 'Colombia', 3003334455, '2026-03-10', 'Jose Gutierrez', 'Pacífico');

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
(1, 1, 2, 85000, 3, 255000, 'Mouse Inalámbrico', 255000, 50, '2026-03-22'),
(2, 2, 8, 350000, 1, 350000, 'Teléfono IP', 350000, 25, '2026-02-23'),
(3, 3, 3, 320000, 1, 320000, 'Teclado Mecánico', 320000, 30, '2026-01-23'),
(4, 4, 4, 780000, 1, 780000, 'Monitor 24\"', 780000, 15, '2026-01-15'),
(5, 5, 5, 650000, 1, 650000, 'Silla Ergonómica', 650000, 10, '2026-02-10'),
(6, 6, 10, 180000, 1, 180000, 'Audífonos Bluetooth', 180000, 40, '2026-03-05'),
(7, 7, 7, 450000, 1, 450000, 'Impresora Láser', 450000, 12, '2026-01-20'),
(8, 8, 9, 750000, 1, 750000, 'Tablet Samsung 10\"', 750000, 18, '2026-02-28'),
(9, 9, 11, 150000, 1, 150000, 'Cámara Web HD', 150000, 35, '2026-03-15'),
(10, 10, 12, 280000, 1, 280000, 'Disco Duro Externo 1TB', 280000, 22, '2026-01-25'),
(11, 11, 13, 220000, 1, 220000, 'Router WiFi 6', 220000, 16, '2026-02-14'),
(12, 12, 15, 380000, 1, 380000, 'UPS 1200VA', 380000, 14, '2026-03-01'),
(13, 13, 6, 850000, 1, 850000, 'Escritorio Ejecutivo', 850000, 8, '2026-01-30'),
(14, 14, 14, 990000, 1, 990000, 'Proyector HD', 990000, 6, '2026-02-20'),
(15, 15, 1, 990000, 1, 990000, 'Laptop HP 15\"', 990000, 20, '2026-03-10');

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
(1, 1, '2026-03-22', 255000, 12750, 'Caribe', 'Carlos Mendez'),
(2, 2, '2026-02-23', 350000, 17500, 'Andina', 'Jose Gutierrez'),
(3, 3, '2026-01-23', 320000, 16000, 'Caribe', 'Hugo Rodallega'),
(4, 4, '2026-01-15', 780000, 39000, 'Andina', 'Carlos Mendez'),
(5, 5, '2026-02-10', 650000, 32500, 'Sur', 'Hugo Rodallega'),
(6, 6, '2026-03-05', 180000, 9000, 'Pacífico', 'Jose Gutierrez'),
(7, 7, '2026-01-20', 450000, 22500, 'Norte', 'Carlos Mendez'),
(8, 8, '2026-02-28', 750000, 37500, 'Andina', 'Hugo Rodallega'),
(9, 9, '2026-03-15', 150000, 7500, 'Caribe', 'Jose Gutierrez'),
(10, 10, '2026-01-25', 280000, 14000, 'Sur', 'Carlos Mendez'),
(11, 11, '2026-02-14', 220000, 11000, 'Sur', 'Hugo Rodallega'),
(12, 12, '2026-03-01', 380000, 19000, 'Sur', 'Jose Gutierrez'),
(13, 13, '2026-01-30', 850000, 42500, 'Norte', 'Carlos Mendez'),
(14, 14, '2026-02-20', 990000, 49500, 'Caribe', 'Hugo Rodallega'),
(15, 15, '2026-03-10', 990000, 49500, 'Pacífico', 'Jose Gutierrez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nom_producto` varchar(100) DEFAULT NULL,
  `precio_unidad_producto` int(6) DEFAULT NULL,
  `existencia_producto` int(3) DEFAULT NULL,
  `categoria_producto` varchar(50) DEFAULT NULL,
  `descuento_producto` int(6) DEFAULT NULL,
  `cantidad_existencia_producto` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nom_producto`, `precio_unidad_producto`, `existencia_producto`, `categoria_producto`, `descuento_producto`, `cantidad_existencia_producto`) VALUES
(1, 'Laptop HP 15\"', 2500000, 20, 'Electrónica', 50000, 20),
(2, 'Mouse Inalámbrico', 85000, 50, 'Electrónica', 3000, 50),
(3, 'Teclado Mecánico', 320000, 30, 'Electrónica', 10000, 30),
(4, 'Monitor 24\"', 780000, 15, 'Electrónica', 25000, 15),
(5, 'Silla Ergonómica', 650000, 10, 'Muebles', 20000, 10),
(6, 'Escritorio Ejecutivo', 850000, 8, 'Muebles', 30000, 8),
(7, 'Impresora Láser', 450000, 12, 'Electrónica', 15000, 12),
(8, 'Teléfono IP', 350000, 25, 'Telecomunicaciones', 12000, 25),
(9, 'Tablet Samsung 10\"', 750000, 18, 'Electrónica', 25000, 18),
(10, 'Audífonos Bluetooth', 180000, 40, 'Electrónica', 6000, 40),
(11, 'Cámara Web HD', 150000, 35, 'Electrónica', 5000, 35),
(12, 'Disco Duro Externo 1TB', 280000, 22, 'Electrónica', 9000, 22),
(13, 'Router WiFi 6', 220000, 16, 'Redes', 7000, 16),
(14, 'Proyector HD', 990000, 6, 'Electrónica', 35000, 6),
(15, 'UPS 1200VA', 380000, 14, 'Electrónica', 12000, 14);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

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
