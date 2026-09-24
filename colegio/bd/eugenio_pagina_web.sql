-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-09-2026 a las 19:58:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eugenio_pagina_web`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id_asistencia` int(11) NOT NULL,
  `documento_asistencia` int(11) NOT NULL,
  `nombre_asistencia` varchar(100) NOT NULL,
  `grado_asistencia` varchar(5) NOT NULL,
  `jornada_asistencia` varchar(20) NOT NULL,
  `telefino_asistencia` bigint(14) NOT NULL,
  `fecha_asistencia` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`id_asistencia`, `documento_asistencia`, `nombre_asistencia`, `grado_asistencia`, `jornada_asistencia`, `telefino_asistencia`, `fecha_asistencia`) VALUES
(1, 1000000001, 'Sofia Aguilar Vargas', '601', 'Tarde', 3000080418, '2026-09-24 15:44:02'),
(2, 1000000002, 'David Diaz Rojas', '601', 'Mañana', 3009668209, '2026-09-24 15:44:02'),
(3, 1000000003, 'Sebastian Suarez Ortiz', '601', 'Mañana', 3005884361, '2026-09-24 15:44:02'),
(4, 1000000004, 'Daniela Herrera Lopez', '601', 'Tarde', 3003503716, '2026-09-24 15:44:02'),
(5, 1000000005, 'David Suarez Lopez', '601', 'Tarde', 3002653743, '2026-09-24 15:44:02'),
(6, 1000000006, 'Sofia Rojas Alvarez', '601', 'Tarde', 3007565336, '2026-09-24 15:44:02'),
(7, 1000000007, 'Camilo Torres Lopez', '601', 'Mañana', 3006936180, '2026-09-24 15:44:02'),
(8, 1000000008, 'Andres Cardenas Herrera', '601', 'Tarde', 3001738001, '2026-09-24 15:44:02'),
(9, 1000000009, 'Cristian Castro Garcia', '601', 'Tarde', 3004003400, '2026-09-24 15:44:02'),
(10, 1000000010, 'Luisa Guzman Martinez', '601', 'Mañana', 3005713108, '2026-09-24 15:44:02'),
(11, 1000000011, 'David Sanchez Rodriguez', '601', 'Tarde', 3005490684, '2026-09-24 15:44:02'),
(12, 1000000012, 'Carlos Herrera Martinez', '601', 'Mañana', 3006404003, '2026-09-24 15:44:02'),
(13, 1000000013, 'Felipe Suarez Rojas', '601', 'Tarde', 3007265521, '2026-09-24 15:44:02'),
(14, 1000000014, 'Julian Moreno Munoz', '601', 'Tarde', 3002405733, '2026-09-24 15:44:02'),
(15, 1000000015, 'Carolina Alvarez Nino', '601', 'Mañana', 3001043658, '2026-09-24 15:44:02'),
(16, 1000000016, 'Manuela Ramirez Munoz', '601', 'Mañana', 3002584105, '2026-09-24 15:44:02'),
(17, 1000000017, 'Valeria Martinez Mendoza', '601', 'Tarde', 3005681245, '2026-09-24 15:44:02'),
(18, 1000000018, 'Manuela Romero Lopez', '601', 'Mañana', 3004000004, '2026-09-24 15:44:02'),
(19, 1000000019, 'Laura Jimenez Flores', '601', 'Mañana', 3001290425, '2026-09-24 15:44:02'),
(20, 1000000020, 'Carolina Martinez Diaz', '601', 'Mañana', 3000226394, '2026-09-24 15:44:02'),
(21, 1000000021, 'Valeria Suarez Guzman', '602', 'Mañana', 3002557348, '2026-09-24 15:44:02'),
(22, 1000000022, 'Nicolas Vargas Munoz', '602', 'Tarde', 3007869958, '2026-09-24 15:44:02'),
(23, 1000000023, 'Maria Garcia Lopez', '602', 'Tarde', 3002664606, '2026-09-24 15:44:02'),
(24, 1000000024, 'Juan Moreno Diaz', '602', 'Tarde', 3006162756, '2026-09-24 15:44:02'),
(25, 1000000025, 'Andres Lopez Perez', '602', 'Tarde', 3002215252, '2026-09-24 15:44:02'),
(26, 1000000026, 'Isabella Suarez Perez', '602', 'Tarde', 3007991537, '2026-09-24 15:44:02'),
(27, 1000000027, 'Andres Perez Alvarez', '602', 'Tarde', 3001054981, '2026-09-24 15:44:02'),
(28, 1000000028, 'Manuela Alvarez Herrera', '602', 'Mañana', 3007078183, '2026-09-24 15:44:02'),
(29, 1000000029, 'Natalia Herrera Nino', '602', 'Mañana', 3000404393, '2026-09-24 15:44:02'),
(30, 1000000030, 'Valeria Munoz Cardenas', '602', 'Tarde', 3008594956, '2026-09-24 15:44:02'),
(31, 1000000031, 'Julian Alvarez Ortiz', '602', 'Mañana', 3005573384, '2026-09-24 15:44:02'),
(32, 1000000032, 'Miguel Torres Lopez', '602', 'Mañana', 3002868847, '2026-09-24 15:44:02'),
(33, 1000000033, 'Juliana Moreno Suarez', '602', 'Tarde', 3005251315, '2026-09-24 15:44:02'),
(34, 1000000034, 'Valeria Jimenez Herrera', '602', 'Mañana', 3006422880, '2026-09-24 15:44:02'),
(35, 1000000035, 'Daniel Gomez Moreno', '602', 'Tarde', 3008543914, '2026-09-24 15:44:02'),
(36, 1000000036, 'Santiago Garcia Diaz', '602', 'Mañana', 3005862790, '2026-09-24 15:44:02'),
(37, 1000000037, 'Alejandro Sanchez Aguilar', '602', 'Tarde', 3006007001, '2026-09-24 15:44:02'),
(38, 1000000038, 'Gabriela Perez Diaz', '602', 'Mañana', 3000834248, '2026-09-24 15:44:02'),
(39, 1000000039, 'Mateo Diaz Flores', '602', 'Tarde', 3005897253, '2026-09-24 15:44:02'),
(40, 1000000040, 'Manuela Rojas Torres', '602', 'Tarde', 3009230036, '2026-09-24 15:44:02'),
(41, 1000000041, 'Valentina Martinez Moreno', '603', 'Mañana', 3000661319, '2026-09-24 15:44:02'),
(42, 1000000042, 'Julian Mendoza Lopez', '603', 'Mañana', 3001821907, '2026-09-24 15:44:02'),
(43, 1000000043, 'Alejandro Ramirez Perez', '603', 'Tarde', 3000330539, '2026-09-24 15:44:02'),
(44, 1000000044, 'Laura Nino Sanchez', '603', 'Mañana', 3006409483, '2026-09-24 15:44:02'),
(45, 1000000045, 'Valeria Martinez Guzman', '603', 'Mañana', 3007837466, '2026-09-24 15:44:02'),
(46, 1000000046, 'Maria Cardenas Gomez', '603', 'Tarde', 3009215253, '2026-09-24 15:44:02'),
(47, 1000000047, 'Santiago Ortiz Mendoza', '603', 'Tarde', 3001232118, '2026-09-24 15:44:02'),
(48, 1000000048, 'Miguel Cardenas Alvarez', '603', 'Tarde', 3003429720, '2026-09-24 15:44:02'),
(49, 1000000049, 'David Perez Alvarez', '603', 'Tarde', 3006874130, '2026-09-24 15:44:02'),
(50, 1000000050, 'Valentina Perez Perez', '603', 'Tarde', 3008927950, '2026-09-24 15:44:02'),
(51, 1000000051, 'Sebastian Jimenez Castro', '603', 'Mañana', 3002002029, '2026-09-24 15:44:02'),
(52, 1000000052, 'Juan Flores Cardenas', '603', 'Tarde', 3007607068, '2026-09-24 15:44:02'),
(53, 1000000053, 'Felipe Flores Gomez', '603', 'Tarde', 3008981312, '2026-09-24 15:44:02'),
(54, 1000000054, 'Alejandro Mendoza Mendoza', '603', 'Tarde', 3008319261, '2026-09-24 15:44:02'),
(55, 1000000055, 'Laura Martinez Ruiz', '603', 'Mañana', 3001823718, '2026-09-24 15:44:02'),
(56, 1000000056, 'Camila Herrera Lopez', '603', 'Mañana', 3002345287, '2026-09-24 15:44:02'),
(57, 1000000057, 'Sofia Guzman Romero', '603', 'Tarde', 3007606067, '2026-09-24 15:44:02'),
(58, 1000000058, 'Juliana Castro Guzman', '603', 'Tarde', 3008535402, '2026-09-24 15:44:02'),
(59, 1000000059, 'Mateo Suarez Romero', '603', 'Tarde', 3006287998, '2026-09-24 15:44:02'),
(60, 1000000060, 'Daniela Lopez Nino', '603', 'Tarde', 3007638872, '2026-09-24 15:44:02'),
(61, 1000000061, 'Juan Rojas Ramirez', '701', 'Mañana', 3007149813, '2026-09-24 15:44:02'),
(62, 1000000062, 'Natalia Guzman Garcia', '701', 'Tarde', 3004473238, '2026-09-24 15:44:02'),
(63, 1000000063, 'Santiago Herrera Munoz', '701', 'Tarde', 3007468537, '2026-09-24 15:44:02'),
(64, 1000000064, 'Paula Guzman Rodriguez', '701', 'Mañana', 3000431042, '2026-09-24 15:44:02'),
(65, 1000000065, 'Andres Aguilar Ramirez', '701', 'Tarde', 3004975115, '2026-09-24 15:44:02'),
(66, 1000000066, 'Luisa Medina Rojas', '701', 'Mañana', 3000260310, '2026-09-24 15:44:02'),
(67, 1000000067, 'Cristian Ortiz Garcia', '701', 'Mañana', 3009866495, '2026-09-24 15:44:02'),
(68, 1000000068, 'Daniela Sanchez Ruiz', '701', 'Tarde', 3001668859, '2026-09-24 15:44:02'),
(69, 1000000069, 'Camila Diaz Rojas', '701', 'Mañana', 3000897536, '2026-09-24 15:44:02'),
(70, 1000000070, 'Daniel Medina Suarez', '701', 'Mañana', 3004142426, '2026-09-24 15:44:02'),
(71, 1000000071, 'Daniel Nino Aguilar', '701', 'Mañana', 3004957419, '2026-09-24 15:44:02'),
(72, 1000000072, 'Nicolas Torres Alvarez', '701', 'Mañana', 3003303981, '2026-09-24 15:44:02'),
(73, 1000000073, 'Manuela Torres Jimenez', '701', 'Mañana', 3005533994, '2026-09-24 15:44:02'),
(74, 1000000074, 'Carlos Garcia Suarez', '701', 'Tarde', 3007036896, '2026-09-24 15:44:02'),
(75, 1000000075, 'Natalia Guzman Romero', '701', 'Mañana', 3004904955, '2026-09-24 15:44:02'),
(76, 1000000076, 'Camila Aguilar Lopez', '701', 'Mañana', 3009088140, '2026-09-24 15:44:02'),
(77, 1000000077, 'Santiago Sanchez Alvarez', '701', 'Mañana', 3006953955, '2026-09-24 15:44:02'),
(78, 1000000078, 'Nicolas Torres Suarez', '701', 'Mañana', 3007374257, '2026-09-24 15:44:02'),
(79, 1000000079, 'Alejandro Herrera Vargas', '701', 'Mañana', 3009058237, '2026-09-24 15:44:02'),
(80, 1000000080, 'Camilo Ruiz Rojas', '701', 'Tarde', 3003047830, '2026-09-24 15:44:02'),
(81, 1000000081, 'Natalia Suarez Medina', '702', 'Tarde', 3007486520, '2026-09-24 15:44:02'),
(82, 1000000082, 'Sebastian Guzman Perez', '702', 'Tarde', 3002998747, '2026-09-24 15:44:02'),
(83, 1000000083, 'Daniela Perez Castro', '702', 'Mañana', 3008316815, '2026-09-24 15:44:02'),
(84, 1000000084, 'Camila Vargas Medina', '702', 'Tarde', 3004284661, '2026-09-24 15:44:02'),
(85, 1000000085, 'Paula Ruiz Rojas', '702', 'Tarde', 3008096421, '2026-09-24 15:44:02'),
(86, 1000000086, 'Sebastian Diaz Martinez', '702', 'Tarde', 3002500447, '2026-09-24 15:44:02'),
(87, 1000000087, 'Miguel Suarez Perez', '702', 'Mañana', 3002374929, '2026-09-24 15:44:02'),
(88, 1000000088, 'Juliana Rodriguez Cardenas', '702', 'Mañana', 3001429959, '2026-09-24 15:44:02'),
(89, 1000000089, 'Sofia Ruiz Cardenas', '702', 'Tarde', 3004261977, '2026-09-24 15:44:02'),
(90, 1000000090, 'Natalia Moreno Ramirez', '702', 'Mañana', 3004037484, '2026-09-24 15:44:02'),
(91, 1000000091, 'Alejandro Gomez Castro', '702', 'Tarde', 3009057711, '2026-09-24 15:44:02'),
(92, 1000000092, 'Daniel Rojas Mendoza', '702', 'Mañana', 3003831235, '2026-09-24 15:44:02'),
(93, 1000000093, 'Camilo Diaz Jimenez', '702', 'Tarde', 3003007310, '2026-09-24 15:44:02'),
(94, 1000000094, 'Carlos Garcia Suarez', '702', 'Tarde', 3008276425, '2026-09-24 15:44:02'),
(95, 1000000095, 'Nicolas Ruiz Martinez', '702', 'Tarde', 3002001773, '2026-09-24 15:44:02'),
(96, 1000000096, 'Andres Ruiz Alvarez', '702', 'Tarde', 3001936555, '2026-09-24 15:44:02'),
(97, 1000000097, 'Isabella Gomez Lopez', '702', 'Tarde', 3003219081, '2026-09-24 15:44:02'),
(98, 1000000098, 'Felipe Alvarez Nino', '702', 'Tarde', 3002052090, '2026-09-24 15:44:02'),
(99, 1000000099, 'Daniela Nino Suarez', '702', 'Mañana', 3006738716, '2026-09-24 15:44:02'),
(100, 1000000100, 'Juliana Garcia Romero', '702', 'Tarde', 3001985641, '2026-09-24 15:44:02'),
(101, 1000000101, 'Mariana Torres Suarez', '703', 'Tarde', 3001802182, '2026-09-24 15:44:02'),
(102, 1000000102, 'Julian Cardenas Martinez', '703', 'Tarde', 3007463985, '2026-09-24 15:44:02'),
(103, 1000000103, 'Nicolas Garcia Munoz', '703', 'Mañana', 3009552329, '2026-09-24 15:44:02'),
(104, 1000000104, 'Camila Romero Moreno', '703', 'Tarde', 3003132564, '2026-09-24 15:44:02'),
(105, 1000000105, 'Paula Rodriguez Gomez', '703', 'Mañana', 3005009386, '2026-09-24 15:44:02'),
(106, 1000000106, 'Manuela Guzman Rojas', '703', 'Mañana', 3003136593, '2026-09-24 15:44:02'),
(107, 1000000107, 'Esteban Herrera Mendoza', '703', 'Mañana', 3000215663, '2026-09-24 15:44:02'),
(108, 1000000108, 'Luisa Martinez Martinez', '703', 'Mañana', 3009038564, '2026-09-24 15:44:02'),
(109, 1000000109, 'Isabella Herrera Aguilar', '703', 'Tarde', 3002365135, '2026-09-24 15:44:02'),
(110, 1000000110, 'Manuela Rojas Suarez', '703', 'Mañana', 3007905490, '2026-09-24 15:44:02'),
(111, 1000000111, 'Mateo Rojas Munoz', '703', 'Tarde', 3000561324, '2026-09-24 15:44:02'),
(112, 1000000112, 'Camila Vargas Torres', '703', 'Mañana', 3003042661, '2026-09-24 15:44:02'),
(113, 1000000113, 'Mariana Lopez Flores', '703', 'Tarde', 3009373325, '2026-09-24 15:44:02'),
(114, 1000000114, 'Miguel Aguilar Sanchez', '703', 'Tarde', 3005651759, '2026-09-24 15:44:02'),
(115, 1000000115, 'Valentina Ramirez Sanchez', '703', 'Tarde', 3005658213, '2026-09-24 15:44:02'),
(116, 1000000116, 'Luisa Herrera Sanchez', '703', 'Mañana', 3000542943, '2026-09-24 15:44:02'),
(117, 1000000117, 'Camilo Guzman Mendoza', '703', 'Tarde', 3001585736, '2026-09-24 15:44:02'),
(118, 1000000118, 'Camilo Rojas Diaz', '703', 'Tarde', 3003068587, '2026-09-24 15:44:02'),
(119, 1000000119, 'Maria Cardenas Castro', '703', 'Mañana', 3001427883, '2026-09-24 15:44:02'),
(120, 1000000120, 'Juliana Ramirez Ramirez', '703', 'Tarde', 3002549660, '2026-09-24 15:44:02'),
(121, 1000000121, 'Valeria Castro Alvarez', '801', 'Tarde', 3002056119, '2026-09-24 15:44:02'),
(122, 1000000122, 'Cristian Aguilar Rojas', '801', 'Tarde', 3004319306, '2026-09-24 15:44:02'),
(123, 1000000123, 'Natalia Suarez Flores', '801', 'Tarde', 3000282392, '2026-09-24 15:44:02'),
(124, 1000000124, 'Paula Nino Ruiz', '801', 'Mañana', 3002012642, '2026-09-24 15:44:02'),
(125, 1000000125, 'Cristian Sanchez Jimenez', '801', 'Mañana', 3007329689, '2026-09-24 15:44:02'),
(126, 1000000126, 'Manuela Romero Romero', '801', 'Mañana', 3003613187, '2026-09-24 15:44:02'),
(127, 1000000127, 'Valeria Nino Perez', '801', 'Tarde', 3002231627, '2026-09-24 15:44:02'),
(128, 1000000128, 'Natalia Ruiz Flores', '801', 'Mañana', 3006775775, '2026-09-24 15:44:02'),
(129, 1000000129, 'Sebastian Jimenez Rojas', '801', 'Mañana', 3002351853, '2026-09-24 15:44:02'),
(130, 1000000130, 'Carlos Rojas Ramirez', '801', 'Tarde', 3008432048, '2026-09-24 15:44:02'),
(131, 1000000131, 'Sofia Aguilar Rojas', '801', 'Mañana', 3009008304, '2026-09-24 15:44:02'),
(132, 1000000132, 'Luisa Rojas Rodriguez', '801', 'Mañana', 3009547112, '2026-09-24 15:44:02'),
(133, 1000000133, 'Manuela Aguilar Flores', '801', 'Tarde', 3003097406, '2026-09-24 15:44:02'),
(134, 1000000134, 'Santiago Guzman Torres', '801', 'Tarde', 3006517524, '2026-09-24 15:44:02'),
(135, 1000000135, 'Andres Medina Ramirez', '801', 'Mañana', 3002858066, '2026-09-24 15:44:02'),
(136, 1000000136, 'Santiago Munoz Rojas', '801', 'Mañana', 3008478459, '2026-09-24 15:44:02'),
(137, 1000000137, 'Daniel Rojas Romero', '801', 'Tarde', 3003024469, '2026-09-24 15:44:02'),
(138, 1000000138, 'Miguel Romero Rodriguez', '801', 'Tarde', 3001098898, '2026-09-24 15:44:02'),
(139, 1000000139, 'Valentina Herrera Perez', '801', 'Tarde', 3008870416, '2026-09-24 15:44:02'),
(140, 1000000140, 'Maria Cardenas Ruiz', '801', 'Mañana', 3003090813, '2026-09-24 15:44:02'),
(141, 1000000141, 'Mariana Cardenas Guzman', '802', 'Tarde', 3006997099, '2026-09-24 15:44:02'),
(142, 1000000142, 'Carolina Perez Vargas', '802', 'Mañana', 3000279600, '2026-09-24 15:44:02'),
(143, 1000000143, 'Cristian Nino Munoz', '802', 'Tarde', 3004542444, '2026-09-24 15:44:02'),
(144, 1000000144, 'Paula Ramirez Lopez', '802', 'Mañana', 3002095268, '2026-09-24 15:44:02'),
(145, 1000000145, 'Juan Jimenez Gomez', '802', 'Tarde', 3001907248, '2026-09-24 15:44:03'),
(146, 1000000146, 'Paula Perez Rojas', '802', 'Tarde', 3007778203, '2026-09-24 15:44:03'),
(147, 1000000147, 'Carlos Gomez Perez', '802', 'Tarde', 3006509257, '2026-09-24 15:44:03'),
(148, 1000000148, 'Valentina Herrera Rojas', '802', 'Tarde', 3003302933, '2026-09-24 15:44:03'),
(149, 1000000149, 'Juan Nino Vargas', '802', 'Tarde', 3008904974, '2026-09-24 15:44:03'),
(150, 1000000150, 'Maria Vargas Suarez', '802', 'Tarde', 3006768704, '2026-09-24 15:44:03'),
(151, 1000000151, 'Luisa Ruiz Herrera', '802', 'Tarde', 3007960803, '2026-09-24 15:44:03'),
(152, 1000000152, 'Alejandro Mendoza Sanchez', '802', 'Tarde', 3000213954, '2026-09-24 15:44:03'),
(153, 1000000153, 'Paula Romero Ruiz', '802', 'Tarde', 3002607394, '2026-09-24 15:44:03'),
(154, 1000000154, 'Daniela Ramirez Lopez', '802', 'Tarde', 3003303225, '2026-09-24 15:44:03'),
(155, 1000000155, 'Paula Ramirez Perez', '802', 'Mañana', 3000323006, '2026-09-24 15:44:03'),
(156, 1000000156, 'Juan Gomez Vargas', '802', 'Tarde', 3008251432, '2026-09-24 15:44:03'),
(157, 1000000157, 'Manuela Nino Romero', '802', 'Mañana', 3009541125, '2026-09-24 15:44:03'),
(158, 1000000158, 'David Gomez Munoz', '802', 'Tarde', 3000036118, '2026-09-24 15:44:03'),
(159, 1000000159, 'Valeria Aguilar Garcia', '802', 'Tarde', 3002868138, '2026-09-24 15:44:03'),
(160, 1000000160, 'Valentina Sanchez Cardenas', '802', 'Mañana', 3005786152, '2026-09-24 15:44:03'),
(161, 1000000161, 'Valeria Rojas Mendoza', '803', 'Mañana', 3007800972, '2026-09-24 15:44:03'),
(162, 1000000162, 'Mateo Diaz Medina', '803', 'Tarde', 3005873677, '2026-09-24 15:44:03'),
(163, 1000000163, 'Paula Rojas Rojas', '803', 'Tarde', 3001663345, '2026-09-24 15:44:03'),
(164, 1000000164, 'Luisa Martinez Medina', '803', 'Mañana', 3006059239, '2026-09-24 15:44:03'),
(165, 1000000165, 'Juan Ramirez Martinez', '803', 'Mañana', 3009057829, '2026-09-24 15:44:03'),
(166, 1000000166, 'Daniel Ramirez Castro', '803', 'Mañana', 3008837193, '2026-09-24 15:44:03'),
(167, 1000000167, 'Carolina Rojas Nino', '803', 'Mañana', 3000832568, '2026-09-24 15:44:03'),
(168, 1000000168, 'Isabella Ruiz Vargas', '803', 'Tarde', 3008006818, '2026-09-24 15:44:03'),
(169, 1000000169, 'Esteban Vargas Vargas', '803', 'Tarde', 3001619190, '2026-09-24 15:44:03'),
(170, 1000000170, 'Daniela Sanchez Rojas', '803', 'Mañana', 3001006914, '2026-09-24 15:44:03'),
(171, 1000000171, 'Gabriela Martinez Lopez', '803', 'Tarde', 3001312001, '2026-09-24 15:44:03'),
(172, 1000000172, 'Laura Sanchez Guzman', '803', 'Mañana', 3004737034, '2026-09-24 15:44:03'),
(173, 1000000173, 'Juliana Nino Rodriguez', '803', 'Mañana', 3003289687, '2026-09-24 15:44:03'),
(174, 1000000174, 'Sebastian Ramirez Rodriguez', '803', 'Mañana', 3008603497, '2026-09-24 15:44:03'),
(175, 1000000175, 'Valentina Rodriguez Aguilar', '803', 'Mañana', 3000597188, '2026-09-24 15:44:03'),
(176, 1000000176, 'Mateo Gomez Perez', '803', 'Mañana', 3004733380, '2026-09-24 15:44:03'),
(177, 1000000177, 'Esteban Suarez Medina', '803', 'Mañana', 3002070315, '2026-09-24 15:44:03'),
(178, 1000000178, 'Felipe Ortiz Rojas', '803', 'Tarde', 3009950121, '2026-09-24 15:44:03'),
(179, 1000000179, 'Juliana Munoz Aguilar', '803', 'Tarde', 3004848459, '2026-09-24 15:44:03'),
(180, 1000000180, 'Alejandro Garcia Rojas', '803', 'Mañana', 3000308944, '2026-09-24 15:44:03'),
(181, 1000000181, 'Julian Aguilar Rojas', '901', 'Mañana', 3003437664, '2026-09-24 15:44:03'),
(182, 1000000182, 'Valeria Medina Castro', '901', 'Tarde', 3009198337, '2026-09-24 15:44:03'),
(183, 1000000183, 'Gabriela Ortiz Jimenez', '901', 'Tarde', 3008065280, '2026-09-24 15:44:03'),
(184, 1000000184, 'Miguel Diaz Mendoza', '901', 'Tarde', 3008279831, '2026-09-24 15:44:03'),
(185, 1000000185, 'Carlos Ortiz Sanchez', '901', 'Mañana', 3003278624, '2026-09-24 15:44:03'),
(186, 1000000186, 'Luisa Rodriguez Alvarez', '901', 'Mañana', 3000748383, '2026-09-24 15:44:03'),
(187, 1000000187, 'Luisa Lopez Ramirez', '901', 'Tarde', 3000817245, '2026-09-24 15:44:03'),
(188, 1000000188, 'Miguel Munoz Ruiz', '901', 'Mañana', 3000208093, '2026-09-24 15:44:03'),
(189, 1000000189, 'Maria Torres Moreno', '901', 'Mañana', 3001323284, '2026-09-24 15:44:03'),
(190, 1000000190, 'Camilo Suarez Suarez', '901', 'Mañana', 3009204265, '2026-09-24 15:44:03'),
(191, 1000000191, 'David Alvarez Rojas', '901', 'Mañana', 3006182303, '2026-09-24 15:44:03'),
(192, 1000000192, 'Felipe Moreno Sanchez', '901', 'Mañana', 3007026129, '2026-09-24 15:44:03'),
(193, 1000000193, 'Esteban Munoz Torres', '901', 'Tarde', 3008273678, '2026-09-24 15:44:03'),
(194, 1000000194, 'Isabella Garcia Cardenas', '901', 'Tarde', 3001957485, '2026-09-24 15:44:03'),
(195, 1000000195, 'Valeria Herrera Vargas', '901', 'Mañana', 3000963096, '2026-09-24 15:44:03'),
(196, 1000000196, 'Gabriela Mendoza Romero', '901', 'Mañana', 3005465625, '2026-09-24 15:44:03'),
(197, 1000000197, 'Santiago Romero Rojas', '901', 'Mañana', 3000975258, '2026-09-24 15:44:03'),
(198, 1000000198, 'Santiago Sanchez Perez', '901', 'Tarde', 3006991738, '2026-09-24 15:44:03'),
(199, 1000000199, 'Santiago Alvarez Castro', '901', 'Mañana', 3002947973, '2026-09-24 15:44:03'),
(200, 1000000200, 'Juan Martinez Mendoza', '901', 'Tarde', 3003517863, '2026-09-24 15:44:03'),
(201, 1000000201, 'Gabriela Ramirez Nino', '902', 'Tarde', 3004350983, '2026-09-24 15:44:03'),
(202, 1000000202, 'Alejandro Martinez Rojas', '902', 'Tarde', 3006726314, '2026-09-24 15:44:03'),
(203, 1000000203, 'Gabriela Diaz Garcia', '902', 'Tarde', 3007946920, '2026-09-24 15:44:03'),
(204, 1000000204, 'Daniela Mendoza Ruiz', '902', 'Mañana', 3003298942, '2026-09-24 15:44:03'),
(205, 1000000205, 'Valentina Rodriguez Moreno', '902', 'Mañana', 3005313168, '2026-09-24 15:44:03'),
(206, 1000000206, 'Esteban Munoz Suarez', '902', 'Tarde', 3002958571, '2026-09-24 15:44:03'),
(207, 1000000207, 'Alejandro Herrera Romero', '902', 'Mañana', 3002254092, '2026-09-24 15:44:03'),
(208, 1000000208, 'Laura Vargas Moreno', '902', 'Mañana', 3006675907, '2026-09-24 15:44:03'),
(209, 1000000209, 'Valeria Ramirez Lopez', '902', 'Mañana', 3002603479, '2026-09-24 15:44:03'),
(210, 1000000210, 'Camila Rojas Nino', '902', 'Mañana', 3005888106, '2026-09-24 15:44:03'),
(211, 1000000211, 'Gabriela Mendoza Medina', '902', 'Tarde', 3004313790, '2026-09-24 15:44:03'),
(212, 1000000212, 'Daniel Herrera Diaz', '902', 'Tarde', 3002987629, '2026-09-24 15:44:03'),
(213, 1000000213, 'Julian Suarez Perez', '902', 'Tarde', 3007397080, '2026-09-24 15:44:03'),
(214, 1000000214, 'Isabella Sanchez Guzman', '902', 'Tarde', 3000835787, '2026-09-24 15:44:03'),
(215, 1000000215, 'Valeria Garcia Flores', '902', 'Mañana', 3001715434, '2026-09-24 15:44:03'),
(216, 1000000216, 'Sofia Vargas Garcia', '902', 'Mañana', 3002936149, '2026-09-24 15:44:03'),
(217, 1000000217, 'Camilo Rodriguez Martinez', '902', 'Mañana', 3009198767, '2026-09-24 15:44:03'),
(218, 1000000218, 'Cristian Jimenez Aguilar', '902', 'Tarde', 3002096092, '2026-09-24 15:44:03'),
(219, 1000000219, 'Julian Herrera Aguilar', '902', 'Mañana', 3008565685, '2026-09-24 15:44:03'),
(220, 1000000220, 'Natalia Rojas Martinez', '902', 'Tarde', 3008915284, '2026-09-24 15:44:03'),
(221, 1000000221, 'David Rodriguez Ramirez', '903', 'Tarde', 3006562675, '2026-09-24 15:44:03'),
(222, 1000000222, 'Paula Perez Gomez', '903', 'Mañana', 3004348595, '2026-09-24 15:44:03'),
(223, 1000000223, 'Manuela Rojas Gomez', '903', 'Mañana', 3002679136, '2026-09-24 15:44:03'),
(224, 1000000224, 'Sofia Alvarez Martinez', '903', 'Mañana', 3004410551, '2026-09-24 15:44:03'),
(225, 1000000225, 'Natalia Ortiz Rodriguez', '903', 'Mañana', 3008897456, '2026-09-24 15:44:03'),
(226, 1000000226, 'Cristian Suarez Rojas', '903', 'Tarde', 3000979624, '2026-09-24 15:44:03'),
(227, 1000000227, 'Daniel Romero Ramirez', '903', 'Mañana', 3002384968, '2026-09-24 15:44:03'),
(228, 1000000228, 'Isabella Jimenez Ortiz', '903', 'Mañana', 3005617672, '2026-09-24 15:44:03'),
(229, 1000000229, 'Santiago Perez Cardenas', '903', 'Tarde', 3001956307, '2026-09-24 15:44:03'),
(230, 1000000230, 'Sofia Nino Munoz', '903', 'Mañana', 3006460867, '2026-09-24 15:44:03'),
(231, 1000000231, 'Paula Diaz Moreno', '903', 'Tarde', 3006680042, '2026-09-24 15:44:03'),
(232, 1000000232, 'Laura Diaz Romero', '903', 'Mañana', 3002702012, '2026-09-24 15:44:03'),
(233, 1000000233, 'Paula Ramirez Ruiz', '903', 'Tarde', 3001775149, '2026-09-24 15:44:03'),
(234, 1000000234, 'Camila Lopez Vargas', '903', 'Tarde', 3007009525, '2026-09-24 15:44:03'),
(235, 1000000235, 'Daniela Garcia Alvarez', '903', 'Tarde', 3001716496, '2026-09-24 15:44:03'),
(236, 1000000236, 'Felipe Martinez Herrera', '903', 'Tarde', 3004632136, '2026-09-24 15:44:03'),
(237, 1000000237, 'Julian Moreno Vargas', '903', 'Tarde', 3006382451, '2026-09-24 15:44:03'),
(238, 1000000238, 'Mateo Herrera Torres', '903', 'Tarde', 3006755019, '2026-09-24 15:44:03'),
(239, 1000000239, 'Juliana Moreno Suarez', '903', 'Mañana', 3004026811, '2026-09-24 15:44:03'),
(240, 1000000240, 'Daniela Mendoza Munoz', '903', 'Mañana', 3000521005, '2026-09-24 15:44:03'),
(241, 1000000241, 'Gabriela Rojas Lopez', '1001', 'Mañana', 3006588033, '2026-09-24 15:44:03'),
(242, 1000000242, 'Julian Gomez Cardenas', '1001', 'Tarde', 3003277291, '2026-09-24 15:44:03'),
(243, 1000000243, 'Valeria Mendoza Ortiz', '1001', 'Tarde', 3008790243, '2026-09-24 15:44:03'),
(244, 1000000244, 'Paula Perez Ortiz', '1001', 'Mañana', 3007810540, '2026-09-24 15:44:03'),
(245, 1000000245, 'Felipe Romero Rodriguez', '1001', 'Mañana', 3001690880, '2026-09-24 15:44:03'),
(246, 1000000246, 'Valentina Herrera Rojas', '1001', 'Mañana', 3004895863, '2026-09-24 15:44:03'),
(247, 1000000247, 'Alejandro Sanchez Herrera', '1001', 'Mañana', 3009555191, '2026-09-24 15:44:03'),
(248, 1000000248, 'Nicolas Rodriguez Vargas', '1001', 'Tarde', 3005518933, '2026-09-24 15:44:03'),
(249, 1000000249, 'Juan Torres Romero', '1001', 'Tarde', 3001168123, '2026-09-24 15:44:03'),
(250, 1000000250, 'Daniel Garcia Sanchez', '1001', 'Mañana', 3009169604, '2026-09-24 15:44:03'),
(251, 1000000251, 'Paula Flores Martinez', '1001', 'Mañana', 3008304001, '2026-09-24 15:44:03'),
(252, 1000000252, 'Andres Flores Ruiz', '1001', 'Tarde', 3005655804, '2026-09-24 15:44:03'),
(253, 1000000253, 'Cristian Rodriguez Suarez', '1001', 'Tarde', 3007672737, '2026-09-24 15:44:03'),
(254, 1000000254, 'Julian Garcia Vargas', '1001', 'Mañana', 3004602520, '2026-09-24 15:44:03'),
(255, 1000000255, 'Andres Munoz Medina', '1001', 'Tarde', 3003522406, '2026-09-24 15:44:03'),
(256, 1000000256, 'Daniel Moreno Alvarez', '1001', 'Mañana', 3003118265, '2026-09-24 15:44:03'),
(257, 1000000257, 'Sebastian Guzman Suarez', '1001', 'Tarde', 3002419749, '2026-09-24 15:44:03'),
(258, 1000000258, 'Juliana Ramirez Romero', '1001', 'Tarde', 3007487916, '2026-09-24 15:44:03'),
(259, 1000000259, 'Miguel Cardenas Sanchez', '1001', 'Mañana', 3005018440, '2026-09-24 15:44:03'),
(260, 1000000260, 'Sofia Mendoza Martinez', '1001', 'Tarde', 3003095173, '2026-09-24 15:44:03'),
(261, 1000000261, 'Valentina Rojas Rojas', '1002', 'Mañana', 3001432111, '2026-09-24 15:44:03'),
(262, 1000000262, 'Natalia Castro Rodriguez', '1002', 'Tarde', 3001163269, '2026-09-24 15:44:03'),
(263, 1000000263, 'Daniel Cardenas Flores', '1002', 'Mañana', 3008754282, '2026-09-24 15:44:03'),
(264, 1000000264, 'Natalia Rodriguez Nino', '1002', 'Mañana', 3000841247, '2026-09-24 15:44:03'),
(265, 1000000265, 'Alejandro Ortiz Ramirez', '1002', 'Mañana', 3007608564, '2026-09-24 15:44:03'),
(266, 1000000266, 'Valentina Castro Sanchez', '1002', 'Tarde', 3004024865, '2026-09-24 15:44:03'),
(267, 1000000267, 'Juliana Rodriguez Sanchez', '1002', 'Tarde', 3005211598, '2026-09-24 15:44:03'),
(268, 1000000268, 'Valeria Medina Diaz', '1002', 'Mañana', 3003954338, '2026-09-24 15:44:03'),
(269, 1000000269, 'Maria Suarez Ramirez', '1002', 'Tarde', 3004135449, '2026-09-24 15:44:03'),
(270, 1000000270, 'Luisa Rojas Alvarez', '1002', 'Tarde', 3008704464, '2026-09-24 15:44:03'),
(271, 1000000271, 'Santiago Guzman Suarez', '1002', 'Tarde', 3001156313, '2026-09-24 15:44:03'),
(272, 1000000272, 'Manuela Rojas Romero', '1002', 'Tarde', 3006135871, '2026-09-24 15:44:03'),
(273, 1000000273, 'Juan Moreno Gomez', '1002', 'Mañana', 3009314194, '2026-09-24 15:44:03'),
(274, 1000000274, 'Mariana Gomez Cardenas', '1002', 'Tarde', 3008752139, '2026-09-24 15:44:03'),
(275, 1000000275, 'Maria Ramirez Ruiz', '1002', 'Tarde', 3009441994, '2026-09-24 15:44:03'),
(276, 1000000276, 'Luisa Romero Cardenas', '1002', 'Mañana', 3001776720, '2026-09-24 15:44:03'),
(277, 1000000277, 'Sebastian Diaz Medina', '1002', 'Tarde', 3008091185, '2026-09-24 15:44:03'),
(278, 1000000278, 'Juliana Moreno Romero', '1002', 'Tarde', 3006766023, '2026-09-24 15:44:03'),
(279, 1000000279, 'Isabella Munoz Suarez', '1002', 'Tarde', 3004185154, '2026-09-24 15:44:03'),
(280, 1000000280, 'Santiago Aguilar Flores', '1002', 'Mañana', 3003603479, '2026-09-24 15:44:03'),
(281, 1000000281, 'Gabriela Castro Gomez', '1003', 'Mañana', 3005259306, '2026-09-24 15:44:03'),
(282, 1000000282, 'David Cardenas Rojas', '1003', 'Tarde', 3002634719, '2026-09-24 15:44:03'),
(283, 1000000283, 'Valeria Ortiz Alvarez', '1003', 'Tarde', 3006580836, '2026-09-24 15:44:03'),
(284, 1000000284, 'Alejandro Nino Ruiz', '1003', 'Tarde', 3008807695, '2026-09-24 15:44:03'),
(285, 1000000285, 'David Vargas Torres', '1003', 'Tarde', 3004464911, '2026-09-24 15:44:03'),
(286, 1000000286, 'Luisa Garcia Suarez', '1003', 'Tarde', 3008606980, '2026-09-24 15:44:03'),
(287, 1000000287, 'Felipe Rojas Nino', '1003', 'Mañana', 3009059966, '2026-09-24 15:44:03'),
(288, 1000000288, 'Carolina Aguilar Castro', '1003', 'Mañana', 3000972538, '2026-09-24 15:44:03'),
(289, 1000000289, 'Natalia Guzman Sanchez', '1003', 'Mañana', 3000375961, '2026-09-24 15:44:03'),
(290, 1000000290, 'Laura Nino Rodriguez', '1003', 'Tarde', 3004024674, '2026-09-24 15:44:03'),
(291, 1000000291, 'Mariana Diaz Jimenez', '1003', 'Tarde', 3002194841, '2026-09-24 15:44:03'),
(292, 1000000292, 'Manuela Ramirez Ortiz', '1003', 'Tarde', 3009133421, '2026-09-24 15:44:03'),
(293, 1000000293, 'Nicolas Medina Garcia', '1003', 'Tarde', 3004328513, '2026-09-24 15:44:03'),
(294, 1000000294, 'Natalia Rojas Torres', '1003', 'Mañana', 3008995636, '2026-09-24 15:44:03'),
(295, 1000000295, 'Maria Ruiz Torres', '1003', 'Tarde', 3003881509, '2026-09-24 15:44:03'),
(296, 1000000296, 'Valeria Flores Medina', '1003', 'Tarde', 3002101350, '2026-09-24 15:44:03'),
(297, 1000000297, 'Carlos Flores Flores', '1003', 'Mañana', 3008191478, '2026-09-24 15:44:03'),
(298, 1000000298, 'Miguel Mendoza Gomez', '1003', 'Tarde', 3007430904, '2026-09-24 15:44:03'),
(299, 1000000299, 'Daniela Ruiz Aguilar', '1003', 'Tarde', 3001469768, '2026-09-24 15:44:03'),
(300, 1000000300, 'Cristian Ramirez Moreno', '1003', 'Mañana', 3009840782, '2026-09-24 15:44:03'),
(301, 1000000301, 'Daniela Ortiz Lopez', '1101', 'Mañana', 3002020195, '2026-09-24 15:44:03'),
(302, 1000000302, 'Daniel Ortiz Guzman', '1101', 'Mañana', 3004824145, '2026-09-24 15:44:03'),
(303, 1000000303, 'Laura Nino Martinez', '1101', 'Mañana', 3008914656, '2026-09-24 15:44:03'),
(304, 1000000304, 'Laura Munoz Lopez', '1101', 'Tarde', 3001845050, '2026-09-24 15:44:03'),
(305, 1000000305, 'Camila Castro Rodriguez', '1101', 'Mañana', 3007493745, '2026-09-24 15:44:03'),
(306, 1000000306, 'Camilo Ramirez Sanchez', '1101', 'Mañana', 3007987117, '2026-09-24 15:44:03'),
(307, 1000000307, 'Carolina Rodriguez Ruiz', '1101', 'Tarde', 3006425840, '2026-09-24 15:44:03'),
(308, 1000000308, 'Juliana Medina Ortiz', '1101', 'Mañana', 3001283681, '2026-09-24 15:44:03'),
(309, 1000000309, 'Isabella Rodriguez Sanchez', '1101', 'Tarde', 3005408977, '2026-09-24 15:44:03'),
(310, 1000000310, 'Natalia Moreno Martinez', '1101', 'Mañana', 3004205388, '2026-09-24 15:44:03'),
(311, 1000000311, 'Carolina Romero Herrera', '1101', 'Tarde', 3008839800, '2026-09-24 15:44:03'),
(312, 1000000312, 'Natalia Suarez Aguilar', '1101', 'Mañana', 3004924246, '2026-09-24 15:44:03'),
(313, 1000000313, 'Valentina Herrera Rojas', '1101', 'Mañana', 3007345491, '2026-09-24 15:44:03'),
(314, 1000000314, 'Mariana Perez Rodriguez', '1101', 'Tarde', 3006603307, '2026-09-24 15:44:03'),
(315, 1000000315, 'Maria Rojas Herrera', '1101', 'Mañana', 3004843328, '2026-09-24 15:44:03'),
(316, 1000000316, 'Andres Cardenas Diaz', '1101', 'Tarde', 3000825473, '2026-09-24 15:44:03'),
(317, 1000000317, 'Daniel Jimenez Jimenez', '1101', 'Mañana', 3005794382, '2026-09-24 15:44:03'),
(318, 1000000318, 'Juan Garcia Medina', '1101', 'Mañana', 3003483438, '2026-09-24 15:44:03'),
(319, 1000000319, 'Felipe Torres Ruiz', '1101', 'Tarde', 3001482741, '2026-09-24 15:44:03'),
(320, 1000000320, 'Carlos Garcia Romero', '1101', 'Mañana', 3008829185, '2026-09-24 15:44:03'),
(321, 1000000321, 'Laura Sanchez Sanchez', '1102', 'Mañana', 3003009647, '2026-09-24 15:44:03'),
(322, 1000000322, 'Natalia Flores Vargas', '1102', 'Tarde', 3003023800, '2026-09-24 15:44:03'),
(323, 1000000323, 'Daniel Gomez Ruiz', '1102', 'Mañana', 3006123141, '2026-09-24 15:44:03'),
(324, 1000000324, 'Camila Torres Flores', '1102', 'Tarde', 3007156214, '2026-09-24 15:44:03'),
(325, 1000000325, 'Juan Castro Ruiz', '1102', 'Tarde', 3009725407, '2026-09-24 15:44:03'),
(326, 1000000326, 'Camilo Castro Nino', '1102', 'Mañana', 3001146400, '2026-09-24 15:44:03'),
(327, 1000000327, 'Valentina Alvarez Diaz', '1102', 'Mañana', 3004550109, '2026-09-24 15:44:03'),
(328, 1000000328, 'Julian Munoz Aguilar', '1102', 'Mañana', 3005182102, '2026-09-24 15:44:03'),
(329, 1000000329, 'Andres Jimenez Rojas', '1102', 'Tarde', 3002257227, '2026-09-24 15:44:03'),
(330, 1000000330, 'Camila Aguilar Moreno', '1102', 'Mañana', 3008168760, '2026-09-24 15:44:03'),
(331, 1000000331, 'Alejandro Diaz Torres', '1102', 'Tarde', 3005904807, '2026-09-24 15:44:03'),
(332, 1000000332, 'Mariana Nino Rodriguez', '1102', 'Tarde', 3000701663, '2026-09-24 15:44:03'),
(333, 1000000333, 'Miguel Martinez Perez', '1102', 'Mañana', 3007073500, '2026-09-24 15:44:03'),
(334, 1000000334, 'Daniela Vargas Aguilar', '1102', 'Tarde', 3001678661, '2026-09-24 15:44:03'),
(335, 1000000335, 'Esteban Rojas Martinez', '1102', 'Mañana', 3003101654, '2026-09-24 15:44:03'),
(336, 1000000336, 'Isabella Nino Rojas', '1102', 'Mañana', 3009359990, '2026-09-24 15:44:03'),
(337, 1000000337, 'Mariana Lopez Ortiz', '1102', 'Mañana', 3009678907, '2026-09-24 15:44:03'),
(338, 1000000338, 'Sofia Aguilar Garcia', '1102', 'Mañana', 3002256802, '2026-09-24 15:44:03'),
(339, 1000000339, 'Mariana Ruiz Ramirez', '1102', 'Tarde', 3007168659, '2026-09-24 15:44:03'),
(340, 1000000340, 'Natalia Munoz Cardenas', '1102', 'Mañana', 3004136640, '2026-09-24 15:44:03'),
(341, 1000000341, 'Valeria Rodriguez Jimenez', '1103', 'Tarde', 3005959761, '2026-09-24 15:44:03'),
(342, 1000000342, 'Manuela Flores Vargas', '1103', 'Mañana', 3006312343, '2026-09-24 15:44:03'),
(343, 1000000343, 'Mateo Medina Munoz', '1103', 'Tarde', 3001546163, '2026-09-24 15:44:03'),
(344, 1000000344, 'Andres Cardenas Perez', '1103', 'Tarde', 3003182971, '2026-09-24 15:44:03'),
(345, 1000000345, 'Daniela Herrera Mendoza', '1103', 'Tarde', 3000014094, '2026-09-24 15:44:03'),
(346, 1000000346, 'Juliana Garcia Medina', '1103', 'Tarde', 3006713767, '2026-09-24 15:44:03'),
(347, 1000000347, 'Sebastian Medina Martinez', '1103', 'Tarde', 3000915335, '2026-09-24 15:44:03'),
(348, 1000000348, 'Maria Jimenez Lopez', '1103', 'Tarde', 3009195380, '2026-09-24 15:44:03'),
(349, 1000000349, 'Carolina Castro Garcia', '1103', 'Tarde', 3002637563, '2026-09-24 15:44:03'),
(350, 1000000350, 'Nicolas Nino Vargas', '1103', 'Tarde', 3008014895, '2026-09-24 15:44:03'),
(351, 1000000351, 'Valeria Perez Ruiz', '1103', 'Tarde', 3000264230, '2026-09-24 15:44:03'),
(352, 1000000352, 'Luisa Ruiz Suarez', '1103', 'Mañana', 3006781165, '2026-09-24 15:44:03'),
(353, 1000000353, 'Daniel Ruiz Flores', '1103', 'Tarde', 3003240561, '2026-09-24 15:44:03'),
(354, 1000000354, 'Maria Diaz Ramirez', '1103', 'Mañana', 3008127989, '2026-09-24 15:44:03'),
(355, 1000000355, 'Mariana Moreno Suarez', '1103', 'Mañana', 3008657975, '2026-09-24 15:44:03'),
(356, 1000000356, 'Juliana Nino Munoz', '1103', 'Tarde', 3000282211, '2026-09-24 15:44:03'),
(357, 1000000357, 'Valeria Flores Rojas', '1103', 'Tarde', 3000889080, '2026-09-24 15:44:03'),
(358, 1000000358, 'Maria Vargas Alvarez', '1103', 'Mañana', 3001869568, '2026-09-24 15:44:03'),
(359, 1000000359, 'Carlos Diaz Romero', '1103', 'Tarde', 3001142818, '2026-09-24 15:44:03'),
(360, 1000000360, 'Mateo Jimenez Flores', '1103', 'Mañana', 3007180380, '2026-09-24 15:44:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` int(11) NOT NULL,
  `banner_contacto` varchar(150) NOT NULL,
  `titulo-1-contacto` varchar(100) NOT NULL,
  `map-url-contacto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id_contacto`, `banner_contacto`, `titulo-1-contacto`, `map-url-contacto`) VALUES
(1, './img-contacto/contacto-6ab0424b74deb.png', 'Ubicación IE Eugenio Ferro Falla Yorman', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.5855776901626!2d-75.29627532689985!3d2.934764354436984!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b7461c302e831%3A0x82cb3770b6b767a9!2sInstituci%C3%B3n%20Educativa%20T%C3%A9cnico%20Superior!5e0!3m2!1ses-419!2sco!4v1790078362843!5m2!1ses-419!2sco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_eventos` int(11) NOT NULL,
  `banner_eventos` varchar(150) NOT NULL,
  `titulo-1` varchar(100) NOT NULL,
  `titulo-2` varchar(100) NOT NULL,
  `texto-1` text NOT NULL,
  `img-url-1` varchar(100) NOT NULL,
  `modal-1-titulo-1` varchar(100) NOT NULL,
  `modal-1-titulo-2` varchar(100) NOT NULL,
  `modal-1-text-1` text NOT NULL,
  `modal-2-titulo-1` varchar(100) NOT NULL,
  `modal-2-titulo-2` varchar(100) NOT NULL,
  `modal-2-text-2` text NOT NULL,
  `modal-3-titulo-1` varchar(100) NOT NULL,
  `modal-3-titulo-2` varchar(100) NOT NULL,
  `modal-3-text-3` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_eventos`, `banner_eventos`, `titulo-1`, `titulo-2`, `texto-1`, `img-url-1`, `modal-1-titulo-1`, `modal-1-titulo-2`, `modal-1-text-1`, `modal-2-titulo-1`, `modal-2-titulo-2`, `modal-2-text-2`, `modal-3-titulo-1`, `modal-3-titulo-2`, `modal-3-text-3`) VALUES
(2, './img-eventos/banner.png', 'El perfil de nuestros estudiantes del Eugenio Ferro Falla', 'El estudiante del Colegio Eugenio Ferro Falla de Campoalegre Huila deberá:', 'Ser partícipe de su quehacer educativo para construir su propio proyecto de vida con éxito.\r\nSer activamente creador, responsable, comprometido para liderar y producir cambios de excelencia en su vida familiar y comunitaria.\r\nSer una persona con capacidad crítica, reflexiva, analítica.\r\nSer consciente de su individualidad, su identidad y su libertad con responsabilidad.\r\nSer una persona que aprecie, promueva y viva en los valores familiares, sociales, culturales, cívicos, éticos, estéticos y ecológicos.\r\nFormarse en el respeto por los derechos humanos, la paz, los principios democráticos, los acuerdos de convivencia, el pluralismo, la justicia y la tolerancia.\r\nSer un futuro ciudadano que puedan participar en el funcionamiento y desarrollo de las estructuras sociales económicas y políticas de Colombia con honestidad y compromiso.\r\nSer una persona dispuesta a propender por una formación integral.', './img-eventos/perfil.jpeg', 'Voleibol', 'Voleibol', 'Edad de 7 a 11 años Martes y jueves: 4:30 p.m. a 5:30 p. m', 'Música', 'Música', 'Técnica Vocal de 8 años en adelante Lunes y miércoles: 4:30 p.m. a 5:30 p. m.\r\nInstrumentos musicales de 6 años en adelante Martes y jueves: 4:30 p.m. a 5:30 p. m.', 'Fútbol', 'Fútbol', 'Categoría Babies (masculino) de 4 a 6 años Lunes y miércoles: 4:30 p.m. a 5:30 p. m.\r\nCategoría Infantil (masculino) de 7 años en adelante Martes y jueves: 4:30 p.m. a 5:30 p. m.\r\nCategoría Femenino de 9 años en adelante Martes y jueves: 4:30 p.m. a 5:30 p. m.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario_contacto`
--

CREATE TABLE `formulario_contacto` (
  `id_formulario` int(11) NOT NULL,
  `correo_formulario` varchar(200) NOT NULL,
  `nombre_formulario` varchar(200) NOT NULL,
  `telefono_formulario` varchar(20) NOT NULL,
  `mensaje_formulario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `formulario_contacto`
--

INSERT INTO `formulario_contacto` (`id_formulario`, `correo_formulario`, `nombre_formulario`, `telefono_formulario`, `mensaje_formulario`) VALUES
(2, 'delfin.alber@gmail.com', 'ALBER DELFIN PEÑA ORTIGOZA', '2147483647', 'Hola como estan.'),
(3, 'delfin.alber@gmail.com', 'ALBER DELFIN PEÑA ORTIGOZA', '2147483647', 'Hola como estan.'),
(4, 'breidy4282@gmail.com', 'Breidy Sanchez', '2147483647', 'Estamos programando con el Sena en el Eugenio Ferro Falla.'),
(5, 'dipayaco_0306@hotmail.com', 'DIANA PAOLA YAGUE CORTES', '2147483647', 'Hola india como está.'),
(6, 'delfin.alber@gmail.com', 'ALBER DELFIN PEÑA', '2147483647', 'Hola soy Delfin.'),
(7, 'santiagocruz@gmail.com', 'Santiago Peña Yague', '2147483647', 'Hola hijo como vamos'),
(8, 'delfin.alber@gmail.com', 'Rosa Isabel Peña', '323456789', 'Hola hija'),
(9, 'delfin.alber@gmail.com', 'Alber Delfin Peña Ortigoza', '2147483647', 'Ya esta sirviendo el formulario, carga a la base de datos y envia de una al correo de gmail.'),
(10, 'ronaljosuefernandezm@gmail.com', 'Ronal Josue Fernandez', '2147483647', 'Hola, estamos en Santa Maria Huila, desarrollando Software.'),
(11, 'rubielasanchez504@gmail.com', 'David Santiago Giron Vera', '2147483647', 'Un saludo David, estamos en el Eugenio Ferro Falla Programando con PHP y PHPMailer.'),
(12, 'cadenaolmoscristianmatias@gmail.com', 'CRISTIAN MATIAS CADENA OLMO', '2147483647', 'Un saludo, estamos en el Ricardo Borrero, programando en JavaScript'),
(13, 'yormancollocardenas@gmail.com', 'Yorman Collo Cardenas', '3114593374', 'Hola Yorman estamos en Campoalegre Huila con el Sena, programando en PHP.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inasistencia`
--

CREATE TABLE `inasistencia` (
  `id_inasistencia` int(11) NOT NULL,
  `documento_inasistencia` int(11) NOT NULL,
  `nombre_inasistencia` varchar(100) NOT NULL,
  `telefono_inasistencia` bigint(13) NOT NULL,
  `grado_inasistencia` varchar(20) NOT NULL,
  `jornada_inasistencia` varchar(20) NOT NULL,
  `fecha_inasistencia` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `inasistencia`
--

INSERT INTO `inasistencia` (`id_inasistencia`, `documento_inasistencia`, `nombre_inasistencia`, `telefono_inasistencia`, `grado_inasistencia`, `jornada_inasistencia`, `fecha_inasistencia`) VALUES
(1, 1000000040, 'Manuela Rojas Torres', 3009230036, '602', 'Tarde', '2026-09-24 21:05:00'),
(2, 1000000047, 'Santiago Ortiz Mendoza', 3001232118, '603', 'Tarde', '2026-09-24 18:19:46'),
(3, 1000000271, 'Santiago Guzman Suarez', 3001156313, '1002', 'Tarde', '2026-09-24 17:23:49'),
(4, 1000000018, 'Manuela Romero Lopez', 3004000004, '601', 'Mañana', '2026-09-24 14:07:35'),
(5, 1000000111, 'Mateo Rojas Munoz', 3000561324, '703', 'Tarde', '2026-09-24 20:59:49'),
(6, 1000000102, 'Julian Cardenas Martinez', 3007463985, '703', 'Tarde', '2026-09-24 17:47:37'),
(7, 1000000330, 'Camila Aguilar Moreno', 3008168760, '1102', 'Mañana', '2026-09-24 14:36:18'),
(8, 1000000117, 'Camilo Guzman Mendoza', 3001585736, '703', 'Tarde', '2026-09-24 20:58:37'),
(9, 1000000218, 'Cristian Jimenez Aguilar', 3002096092, '902', 'Tarde', '2026-09-24 22:30:16'),
(10, 1000000239, 'Juliana Moreno Suarez', 3004026811, '903', 'Mañana', '2026-09-24 14:08:44'),
(11, 1000000124, 'Paula Nino Ruiz', 3002012642, '801', 'Mañana', '2026-09-24 15:24:47'),
(12, 1000000302, 'Daniel Ortiz Guzman', 3004824145, '1101', 'Mañana', '2026-09-24 13:07:42'),
(13, 1000000258, 'Juliana Ramirez Romero', 3007487916, '1001', 'Tarde', '2026-09-24 20:35:31'),
(14, 1000000014, 'Julian Moreno Munoz', 3002405733, '601', 'Tarde', '2026-09-24 18:26:48'),
(15, 1000000225, 'Natalia Ortiz Rodriguez', 3008897456, '903', 'Mañana', '2026-09-24 12:54:12'),
(16, 1000000094, 'Carlos Garcia Suarez', 3008276425, '702', 'Tarde', '2026-09-24 19:27:27'),
(17, 1000000140, 'Maria Cardenas Ruiz', 3003090813, '801', 'Mañana', '2026-09-24 13:37:52'),
(18, 1000000127, 'Valeria Nino Perez', 3002231627, '801', 'Tarde', '2026-09-24 18:56:50'),
(19, 1000000235, 'Daniela Garcia Alvarez', 3001716496, '903', 'Tarde', '2026-09-24 19:21:50'),
(20, 1000000285, 'David Vargas Torres', 3004464911, '1003', 'Tarde', '2026-09-24 22:58:39'),
(21, 1000000267, 'Juliana Rodriguez Sanchez', 3005211598, '1002', 'Tarde', '2026-09-24 21:47:47'),
(22, 1000000123, 'Natalia Suarez Flores', 3000282392, '801', 'Tarde', '2026-09-24 17:02:59'),
(23, 1000000190, 'Camilo Suarez Suarez', 3009204265, '901', 'Mañana', '2026-09-24 12:56:46'),
(24, 1000000176, 'Mateo Gomez Perez', 3004733380, '803', 'Mañana', '2026-09-24 12:20:15'),
(25, 1000000274, 'Mariana Gomez Cardenas', 3008752139, '1002', 'Tarde', '2026-09-24 20:51:33'),
(26, 1000000154, 'Daniela Ramirez Lopez', 3003303225, '802', 'Tarde', '2026-09-24 18:08:47'),
(27, 1000000304, 'Laura Munoz Lopez', 3001845050, '1101', 'Tarde', '2026-09-24 17:09:19'),
(28, 1000000013, 'Felipe Suarez Rojas', 3007265521, '601', 'Tarde', '2026-09-24 20:20:12'),
(29, 1000000316, 'Andres Cardenas Diaz', 3000825473, '1101', 'Tarde', '2026-09-24 21:13:05'),
(30, 1000000236, 'Felipe Martinez Herrera', 3004632136, '903', 'Tarde', '2026-09-24 22:04:49'),
(33, 1000000252, 'Andres Flores Ruiz', 3005655804, '1001', 'Tarde', '2026-09-24 17:44:51'),
(36, 1881265147, 'Isabella Vargas Sanchez', 3004877376, '601', 'Mañana', '2026-09-10 16:20:59'),
(37, 1825429087, 'Valentina Mendoza Gomez', 3001690941, '601', 'Mañana', '2026-08-31 13:14:08'),
(38, 1833901664, 'Laura Martinez Moreno', 3000602415, '601', 'Mañana', '2026-09-30 15:37:46'),
(39, 1806119397, 'Miguel Torres Romero', 3000287455, '601', 'Mañana', '2026-08-28 11:56:27'),
(40, 1836705964, 'Natalia Jimenez Vargas', 3008972310, '601', 'Mañana', '2026-09-28 16:18:56'),
(41, 1832851093, 'Mariana Mendoza Mendoza', 3008247073, '601', 'Tarde', '2026-09-03 17:29:46'),
(42, 1865021817, 'Camila Sanchez Sanchez', 3009902716, '601', 'Tarde', '2026-09-29 17:14:21'),
(43, 1851441089, 'Gabriela Martinez Jimenez', 3001285857, '601', 'Tarde', '2026-08-05 22:42:26'),
(44, 1870464679, 'Carlos Jimenez Perez', 3007027811, '601', 'Tarde', '2026-08-26 20:49:09'),
(45, 1871154902, 'Julian Garcia Guzman', 3006928373, '601', 'Tarde', '2026-09-29 18:58:25'),
(46, 1860791814, 'Esteban Aguilar Alvarez', 3002685376, '602', 'Mañana', '2026-09-04 14:15:19'),
(47, 1870337007, 'Gabriela Ruiz Moreno', 3001339878, '602', 'Mañana', '2026-08-20 15:49:47'),
(48, 1881303628, 'Camila Sanchez Ramirez', 3004252560, '602', 'Mañana', '2026-08-26 14:52:59'),
(49, 1830725732, 'Miguel Mendoza Suarez', 3008676357, '602', 'Mañana', '2026-08-25 15:25:34'),
(50, 1804058384, 'Maria Mendoza Flores', 3005289371, '602', 'Mañana', '2026-08-14 15:58:55'),
(51, 1862476781, 'Andres Ruiz Torres', 3000133884, '602', 'Tarde', '2026-09-28 21:24:41'),
(52, 1869912689, 'Paula Martinez Rodriguez', 3009978336, '602', 'Tarde', '2026-09-01 21:08:10'),
(53, 1845999005, 'Julian Rodriguez Martinez', 3005800764, '602', 'Tarde', '2026-09-17 18:26:46'),
(54, 1822604705, 'Gabriela Munoz Herrera', 3000906178, '602', 'Tarde', '2026-09-29 17:49:22'),
(55, 1884882118, 'Camilo Garcia Cardenas', 3004800114, '602', 'Tarde', '2026-09-01 22:46:33'),
(56, 1851808724, 'Daniela Lopez Medina', 3001522406, '603', 'Mañana', '2026-09-30 12:07:51'),
(57, 1853735436, 'Juan Suarez Medina', 3009648670, '603', 'Mañana', '2026-08-06 16:12:31'),
(58, 1858008339, 'Daniel Garcia Medina', 3007499799, '603', 'Mañana', '2026-08-31 13:09:04'),
(59, 1827462452, 'Mateo Garcia Ruiz', 3000424075, '603', 'Mañana', '2026-09-22 15:37:49'),
(60, 1887978514, 'Sofia Suarez Ruiz', 3001462379, '603', 'Mañana', '2026-08-25 12:11:52'),
(61, 1820095917, 'Juliana Castro Garcia', 3000337619, '603', 'Tarde', '2026-09-25 19:24:40'),
(62, 1817941866, 'Mateo Rojas Castro', 3005758741, '603', 'Tarde', '2026-09-04 17:43:41'),
(63, 1899258522, 'Gabriela Martinez Herrera', 3009495491, '603', 'Tarde', '2026-09-16 19:24:26'),
(64, 1854121945, 'Juan Castro Flores', 3007767104, '603', 'Tarde', '2026-08-05 20:51:08'),
(65, 1823818137, 'Laura Castro Alvarez', 3005311593, '603', 'Tarde', '2026-08-18 17:02:22'),
(66, 1884631492, 'Alejandro Suarez Garcia', 3002485782, '701', 'Mañana', '2026-09-14 12:35:52'),
(67, 1852902587, 'Alejandro Martinez Suarez', 3004050343, '701', 'Mañana', '2026-08-05 14:53:46'),
(68, 1867326653, 'Valentina Flores Sanchez', 3005060018, '701', 'Mañana', '2026-09-04 15:11:13'),
(69, 1811255319, 'Julian Castro Cardenas', 3005671606, '701', 'Mañana', '2026-09-03 14:44:48'),
(70, 1893691319, 'Juan Rojas Ramirez', 3007161474, '701', 'Mañana', '2026-09-22 11:40:22'),
(71, 1846923503, 'Esteban Rojas Garcia', 3005000309, '701', 'Tarde', '2026-09-21 17:38:27'),
(72, 1804523685, 'Juan Aguilar Perez', 3008483213, '701', 'Tarde', '2026-08-14 20:05:07'),
(73, 1861976481, 'Natalia Garcia Rojas', 3004675504, '701', 'Tarde', '2026-08-05 18:30:16'),
(74, 1884726166, 'Felipe Aguilar Medina', 3007777739, '701', 'Tarde', '2026-09-30 21:16:01'),
(75, 1850299160, 'Natalia Sanchez Jimenez', 3002514606, '701', 'Tarde', '2026-09-08 21:49:16'),
(76, 1806138777, 'Esteban Guzman Rojas', 3006267365, '702', 'Mañana', '2026-08-03 12:37:26'),
(77, 1885877423, 'Maria Medina Moreno', 3005995335, '702', 'Mañana', '2026-09-23 11:36:04'),
(78, 1801394957, 'Sebastian Herrera Rodriguez', 3001244996, '702', 'Mañana', '2026-08-03 13:38:01'),
(79, 1814342564, 'Isabella Munoz Rodriguez', 3002201954, '702', 'Mañana', '2026-09-15 11:51:55'),
(80, 1820316697, 'Miguel Medina Cardenas', 3005939443, '702', 'Mañana', '2026-09-25 11:55:31'),
(81, 1878099720, 'Juan Diaz Mendoza', 3007353041, '702', 'Tarde', '2026-08-20 22:18:16'),
(82, 1841543835, 'Sebastian Rodriguez Guzman', 3006587994, '702', 'Tarde', '2026-08-20 17:03:34'),
(83, 1812380408, 'Valentina Herrera Lopez', 3008661457, '702', 'Tarde', '2026-08-26 19:23:01'),
(84, 1850889290, 'Felipe Rodriguez Ramirez', 3000119264, '702', 'Tarde', '2026-08-28 22:44:25'),
(85, 1803530552, 'Daniel Rodriguez Munoz', 3003024839, '702', 'Tarde', '2026-09-30 20:33:01'),
(86, 1895865134, 'Camilo Ortiz Rojas', 3000096405, '703', 'Mañana', '2026-08-26 12:31:53'),
(87, 1823367456, 'Cristian Ortiz Gomez', 3008978230, '703', 'Mañana', '2026-08-12 15:22:53'),
(88, 1890732788, 'Camila Sanchez Romero', 3009141786, '703', 'Mañana', '2026-09-09 12:48:46'),
(89, 1801040289, 'Carolina Torres Nino', 3005660220, '703', 'Mañana', '2026-08-25 16:25:11'),
(90, 1813044541, 'Santiago Sanchez Mendoza', 3003936331, '703', 'Mañana', '2026-08-10 12:09:38'),
(91, 1835833759, 'Manuela Aguilar Rodriguez', 3002063272, '703', 'Tarde', '2026-09-29 17:31:53'),
(92, 1882924386, 'Andres Flores Medina', 3004371697, '703', 'Tarde', '2026-08-13 21:00:20'),
(93, 1814046917, 'Miguel Sanchez Gomez', 3003632168, '703', 'Tarde', '2026-08-18 17:26:02'),
(94, 1809370925, 'Sebastian Lopez Torres', 3000013844, '703', 'Tarde', '2026-08-31 19:09:11'),
(95, 1824206816, 'Mariana Alvarez Moreno', 3009138141, '703', 'Tarde', '2026-09-15 20:27:50'),
(96, 1809642095, 'Cristian Rojas Rodriguez', 3003810810, '801', 'Mañana', '2026-09-08 15:02:38'),
(97, 1832217079, 'Daniel Perez Diaz', 3009032665, '801', 'Mañana', '2026-08-06 12:14:18'),
(98, 1873581957, 'Mateo Diaz Munoz', 3006486364, '801', 'Mañana', '2026-09-10 14:33:35'),
(99, 1827155733, 'Nicolas Torres Diaz', 3003096410, '801', 'Mañana', '2026-09-08 14:35:03'),
(100, 1850032990, 'Julian Cardenas Castro', 3005940723, '801', 'Mañana', '2026-09-01 12:44:30'),
(101, 1823722709, 'Cristian Jimenez Cardenas', 3002889401, '801', 'Tarde', '2026-08-13 21:51:39'),
(102, 1832467295, 'Felipe Guzman Medina', 3007978948, '801', 'Tarde', '2026-09-15 18:54:44'),
(103, 1844707100, 'Luisa Aguilar Martinez', 3001110314, '801', 'Tarde', '2026-08-12 17:58:42'),
(104, 1841741029, 'Andres Diaz Flores', 3007964516, '801', 'Tarde', '2026-08-12 22:09:19'),
(105, 1804252686, 'Daniela Sanchez Mendoza', 3009232707, '801', 'Tarde', '2026-09-03 21:50:29'),
(106, 1826343784, 'Carolina Medina Alvarez', 3004582648, '802', 'Mañana', '2026-09-16 13:27:21'),
(107, 1880152561, 'Daniela Aguilar Vargas', 3005851934, '802', 'Mañana', '2026-09-11 12:33:15'),
(108, 1863949592, 'Daniel Suarez Mendoza', 3006086516, '802', 'Mañana', '2026-09-08 15:54:14'),
(109, 1857963953, 'Maria Gomez Moreno', 3003165530, '802', 'Mañana', '2026-09-07 15:21:26'),
(110, 1862133427, 'Luisa Vargas Garcia', 3009645662, '802', 'Mañana', '2026-08-11 12:34:29'),
(111, 1842253599, 'Valeria Rojas Cardenas', 3007427907, '802', 'Tarde', '2026-09-09 19:44:28'),
(112, 1804482135, 'Carolina Romero Sanchez', 3001867286, '802', 'Tarde', '2026-09-16 22:10:56'),
(113, 1862821192, 'Sofia Cardenas Aguilar', 3004931363, '802', 'Tarde', '2026-09-18 22:41:17'),
(114, 1836928971, 'Miguel Rodriguez Torres', 3009270947, '802', 'Tarde', '2026-09-30 17:53:36'),
(115, 1865348895, 'Maria Aguilar Romero', 3004351230, '802', 'Tarde', '2026-08-14 22:24:11'),
(116, 1822636441, 'Daniela Nino Guzman', 3002664390, '803', 'Mañana', '2026-09-21 15:18:07'),
(117, 1897878374, 'Nicolas Flores Herrera', 3000769072, '803', 'Mañana', '2026-08-12 12:17:09'),
(118, 1809259224, 'Andres Diaz Sanchez', 3007361898, '803', 'Mañana', '2026-08-14 14:01:24'),
(119, 1851104292, 'Miguel Nino Aguilar', 3001582654, '803', 'Mañana', '2026-09-24 11:45:32'),
(120, 1814125582, 'Nicolas Aguilar Medina', 3003145798, '803', 'Mañana', '2026-08-10 15:13:28'),
(121, 1835377944, 'Felipe Diaz Gomez', 3005397912, '803', 'Tarde', '2026-08-26 17:20:08'),
(122, 1868158771, 'Andres Ramirez Flores', 3007583435, '803', 'Tarde', '2026-09-10 20:28:07'),
(123, 1852678159, 'Camilo Diaz Vargas', 3006392983, '803', 'Tarde', '2026-09-25 21:20:12'),
(124, 1888060057, 'Isabella Moreno Sanchez', 3001788005, '803', 'Tarde', '2026-09-07 22:16:37'),
(125, 1845595962, 'Maria Cardenas Herrera', 3005832973, '803', 'Tarde', '2026-09-28 18:22:33'),
(126, 1803043010, 'Paula Vargas Rodriguez', 3000773743, '901', 'Mañana', '2026-09-17 14:20:47'),
(127, 1808153337, 'Daniel Rojas Ruiz', 3007345456, '901', 'Mañana', '2026-08-18 14:33:31'),
(128, 1848235178, 'David Aguilar Ortiz', 3008468181, '901', 'Mañana', '2026-09-10 13:15:13'),
(129, 1875329627, 'Isabella Cardenas Mendoza', 3005212683, '901', 'Mañana', '2026-09-08 16:05:32'),
(130, 1863976225, 'Juan Romero Garcia', 3007013384, '901', 'Mañana', '2026-08-04 14:12:01'),
(131, 1843980913, 'Felipe Herrera Flores', 3000144605, '901', 'Tarde', '2026-08-12 20:02:52'),
(132, 1863992132, 'David Munoz Lopez', 3007450085, '901', 'Tarde', '2026-08-11 22:06:41'),
(133, 1857352895, 'Maria Guzman Perez', 3002081582, '901', 'Tarde', '2026-09-09 21:24:51'),
(134, 1834249194, 'Andres Diaz Castro', 3008287159, '901', 'Tarde', '2026-09-10 17:44:14'),
(135, 1831537740, 'Natalia Romero Rojas', 3002062121, '901', 'Tarde', '2026-08-31 19:26:35'),
(136, 1839913511, 'Camila Castro Cardenas', 3009865856, '902', 'Mañana', '2026-09-08 16:13:31'),
(137, 1865347468, 'Carolina Herrera Nino', 3000062995, '902', 'Mañana', '2026-08-11 12:01:33'),
(138, 1810883512, 'Valeria Gomez Nino', 3003227368, '902', 'Mañana', '2026-08-19 14:57:13'),
(139, 1854889798, 'Santiago Ortiz Ruiz', 3009903131, '902', 'Mañana', '2026-08-20 12:11:24'),
(140, 1874015277, 'Juliana Aguilar Garcia', 3003717585, '902', 'Mañana', '2026-08-12 14:35:24'),
(141, 1802049626, 'Isabella Alvarez Vargas', 3004313932, '902', 'Tarde', '2026-09-22 21:00:15'),
(142, 1844909565, 'Isabella Ortiz Jimenez', 3009196931, '902', 'Tarde', '2026-09-24 17:41:32'),
(143, 1835357612, 'Andres Mendoza Ortiz', 3000442343, '902', 'Tarde', '2026-08-10 20:26:53'),
(144, 1827734460, 'Mariana Herrera Sanchez', 3008921688, '902', 'Tarde', '2026-09-23 20:09:49'),
(145, 1872029298, 'Gabriela Gomez Diaz', 3002621545, '902', 'Tarde', '2026-08-03 22:28:25'),
(146, 1858176818, 'Mariana Lopez Suarez', 3006766616, '903', 'Mañana', '2026-09-02 14:52:48'),
(147, 1858847492, 'David Suarez Vargas', 3009315621, '903', 'Mañana', '2026-09-04 14:07:48'),
(148, 1862544635, 'David Ruiz Cardenas', 3008069531, '903', 'Mañana', '2026-08-03 14:30:37'),
(149, 1893964142, 'Daniela Ramirez Mendoza', 3008504326, '903', 'Mañana', '2026-09-25 13:39:43'),
(150, 1857015704, 'Mateo Ortiz Gomez', 3001412974, '903', 'Mañana', '2026-09-24 13:16:44'),
(151, 1870974635, 'Manuela Rodriguez Romero', 3006088372, '903', 'Tarde', '2026-09-14 22:52:41'),
(152, 1884828438, 'Alejandro Mendoza Vargas', 3002937619, '903', 'Tarde', '2026-08-18 17:58:11'),
(153, 1824510678, 'Cristian Rodriguez Rojas', 3002488641, '903', 'Tarde', '2026-09-04 22:12:51'),
(154, 1802662910, 'Valentina Moreno Gomez', 3008486955, '903', 'Tarde', '2026-08-14 22:09:43'),
(155, 1896314335, 'Daniel Lopez Ortiz', 3002551563, '903', 'Tarde', '2026-08-24 21:10:03'),
(156, 1840276600, 'Juliana Aguilar Guzman', 3004753945, '1001', 'Mañana', '2026-09-22 13:54:32'),
(157, 1826662434, 'Julian Medina Romero', 3004230255, '1001', 'Mañana', '2026-08-19 13:12:27'),
(158, 1855991396, 'Santiago Ramirez Ortiz', 3007818871, '1001', 'Mañana', '2026-08-04 12:48:38'),
(159, 1852069525, 'Laura Ortiz Nino', 3005223169, '1001', 'Mañana', '2026-08-24 12:55:51'),
(160, 1886138657, 'Camila Alvarez Garcia', 3004324093, '1001', 'Mañana', '2026-09-23 14:43:20'),
(161, 1801179236, 'Sofia Diaz Gomez', 3005736113, '1001', 'Tarde', '2026-09-18 22:21:07'),
(162, 1828974894, 'Camila Rojas Medina', 3002786034, '1001', 'Tarde', '2026-08-04 19:15:25'),
(163, 1830751580, 'Juliana Guzman Garcia', 3007810694, '1001', 'Tarde', '2026-09-07 18:13:46'),
(164, 1861326122, 'Cristian Sanchez Romero', 3004619895, '1001', 'Tarde', '2026-08-12 22:22:36'),
(165, 1872031960, 'Maria Diaz Diaz', 3008472218, '1001', 'Tarde', '2026-08-21 22:11:42'),
(166, 1811881065, 'Julian Lopez Garcia', 3007768043, '1002', 'Mañana', '2026-08-12 13:19:08'),
(167, 1850741517, 'Cristian Herrera Diaz', 3008279477, '1002', 'Mañana', '2026-09-02 15:55:43'),
(168, 1831179900, 'Gabriela Martinez Aguilar', 3009828498, '1002', 'Mañana', '2026-09-23 13:11:10'),
(169, 1810277109, 'Nicolas Moreno Munoz', 3005614471, '1002', 'Mañana', '2026-09-03 11:38:41'),
(170, 1804828798, 'Paula Garcia Garcia', 3005149727, '1002', 'Mañana', '2026-09-18 12:09:58'),
(171, 1869035783, 'Paula Martinez Jimenez', 3000783789, '1002', 'Tarde', '2026-09-03 20:50:43'),
(172, 1840628218, 'Maria Guzman Flores', 3003512136, '1002', 'Tarde', '2026-09-10 20:38:31'),
(173, 1837181337, 'Mateo Romero Castro', 3001179651, '1002', 'Tarde', '2026-08-31 17:40:23'),
(174, 1888865514, 'Daniel Guzman Perez', 3005362071, '1002', 'Tarde', '2026-09-01 21:26:24'),
(175, 1890497537, 'Isabella Rojas Alvarez', 3006847032, '1002', 'Tarde', '2026-09-14 19:10:51'),
(176, 1865268623, 'Andres Jimenez Sanchez', 3004795627, '1003', 'Mañana', '2026-08-24 14:23:45'),
(177, 1852219524, 'Juliana Alvarez Guzman', 3009718586, '1003', 'Mañana', '2026-09-09 13:58:52'),
(178, 1825257317, 'Felipe Jimenez Lopez', 3007927068, '1003', 'Mañana', '2026-08-25 15:13:07'),
(179, 1810079264, 'Sebastian Rojas Ruiz', 3001579847, '1003', 'Mañana', '2026-09-10 12:39:00'),
(180, 1862274270, 'Julian Ortiz Lopez', 3002641658, '1003', 'Mañana', '2026-09-08 16:05:40'),
(181, 1823092883, 'Sebastian Lopez Ramirez', 3004614821, '1003', 'Tarde', '2026-08-12 20:35:04'),
(182, 1880660961, 'Mateo Flores Ruiz', 3000336495, '1003', 'Tarde', '2026-09-17 22:22:48'),
(183, 1835862199, 'Gabriela Aguilar Suarez', 3007609002, '1003', 'Tarde', '2026-09-23 21:08:47'),
(184, 1837560273, 'Mateo Aguilar Mendoza', 3007004457, '1003', 'Tarde', '2026-09-18 21:35:31'),
(185, 1843147319, 'Natalia Lopez Lopez', 3001868804, '1003', 'Tarde', '2026-09-24 21:31:14'),
(186, 1802366361, 'Julian Rojas Ruiz', 3004428868, '1101', 'Mañana', '2026-08-24 16:01:19'),
(187, 1845746336, 'Carolina Aguilar Ramirez', 3003587113, '1101', 'Mañana', '2026-09-24 15:19:38'),
(188, 1889070295, 'Camilo Jimenez Garcia', 3002715227, '1101', 'Mañana', '2026-09-24 12:04:10'),
(189, 1897872428, 'Julian Sanchez Mendoza', 3009116886, '1101', 'Mañana', '2026-09-18 12:51:59'),
(190, 1885153825, 'Sebastian Jimenez Sanchez', 3004536979, '1101', 'Mañana', '2026-09-16 11:37:23'),
(191, 1844681592, 'Nicolas Alvarez Diaz', 3006849570, '1101', 'Tarde', '2026-09-03 19:49:37'),
(192, 1812003350, 'Andres Suarez Vargas', 3002182808, '1101', 'Tarde', '2026-08-13 17:34:25'),
(193, 1829112442, 'Felipe Munoz Torres', 3001540912, '1101', 'Tarde', '2026-08-11 17:23:13'),
(194, 1890378078, 'Cristian Flores Alvarez', 3007151485, '1101', 'Tarde', '2026-08-12 17:12:50'),
(195, 1885451955, 'Valentina Torres Jimenez', 3009341805, '1101', 'Tarde', '2026-09-04 22:54:33'),
(196, 1817237306, 'Camila Jimenez Flores', 3001503954, '1102', 'Mañana', '2026-09-08 13:01:01'),
(197, 1846208513, 'Felipe Moreno Ramirez', 3009551235, '1102', 'Mañana', '2026-09-14 13:42:54'),
(198, 1851521467, 'Alejandro Ramirez Rodriguez', 3004776600, '1102', 'Mañana', '2026-09-29 13:01:28'),
(199, 1843491328, 'Esteban Flores Ruiz', 3001799830, '1102', 'Mañana', '2026-08-04 12:28:40'),
(200, 1817942952, 'Felipe Cardenas Munoz', 3009504593, '1102', 'Mañana', '2026-09-15 11:48:55'),
(201, 1827390369, 'Nicolas Ruiz Martinez', 3003948368, '1102', 'Tarde', '2026-09-30 21:54:14'),
(202, 1856717529, 'Juliana Gomez Castro', 3001475430, '1102', 'Tarde', '2026-08-19 17:47:33'),
(203, 1828688849, 'Manuela Perez Vargas', 3009586866, '1102', 'Tarde', '2026-09-07 18:15:04'),
(204, 1872195959, 'Valentina Castro Garcia', 3005071939, '1102', 'Tarde', '2026-09-25 20:52:39'),
(205, 1870355913, 'Isabella Medina Sanchez', 3000643163, '1102', 'Tarde', '2026-09-10 20:38:04'),
(206, 1839137314, 'Isabella Ramirez Nino', 3006593121, '1103', 'Mañana', '2026-08-18 15:08:38'),
(207, 1882318107, 'Miguel Vargas Guzman', 3000242784, '1103', 'Mañana', '2026-09-04 13:46:22'),
(208, 1878453952, 'Laura Sanchez Lopez', 3005228005, '1103', 'Mañana', '2026-09-11 11:55:58'),
(209, 1820440657, 'Daniela Suarez Garcia', 3009619908, '1103', 'Mañana', '2026-09-28 11:50:45'),
(210, 1824252949, 'Isabella Castro Jimenez', 3009950095, '1103', 'Mañana', '2026-09-29 11:55:50'),
(211, 1872854990, 'Julian Sanchez Moreno', 3009788580, '1103', 'Tarde', '2026-08-25 17:32:24'),
(212, 1830993960, 'Juliana Ruiz Mendoza', 3008248447, '1103', 'Tarde', '2026-09-01 20:47:48'),
(213, 1872148370, 'Esteban Suarez Sanchez', 3001608176, '1103', 'Tarde', '2026-08-24 22:21:49'),
(214, 1806351534, 'Luisa Torres Aguilar', 3007552688, '1103', 'Tarde', '2026-08-25 20:25:40'),
(215, 1838768311, 'Daniela Mendoza Ruiz', 3005927926, '1103', 'Tarde', '2026-09-30 18:02:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio`
--

CREATE TABLE `inicio` (
  `id_inicio` int(11) NOT NULL,
  `banner_inicio` varchar(150) NOT NULL,
  `carru_img_1_inicio` varchar(150) NOT NULL,
  `carru_img_2_inicio` varchar(150) NOT NULL,
  `carru_img_3_inicio` varchar(150) NOT NULL,
  `url_video_inicio` varchar(150) NOT NULL,
  `titulo-acordeon-1` varchar(100) NOT NULL,
  `texto-acordeon-1` text NOT NULL,
  `titulo-acordeon-2` varchar(100) NOT NULL,
  `texto-acordeon-2` text NOT NULL,
  `titulo-acordeon-3` varchar(100) NOT NULL,
  `texto-acordeon-3` text NOT NULL,
  `button-colarsar-titulo-1` varchar(100) NOT NULL,
  `button-colarsar-texto-1` text NOT NULL,
  `button-colarsar-titulo-2` varchar(100) NOT NULL,
  `button-colarsar-texto-2` text NOT NULL,
  `button-colarsar-titulo-3` varchar(100) NOT NULL,
  `button-colarsar-texto-3` text NOT NULL,
  `numero_whatsapp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `inicio`
--

INSERT INTO `inicio` (`id_inicio`, `banner_inicio`, `carru_img_1_inicio`, `carru_img_2_inicio`, `carru_img_3_inicio`, `url_video_inicio`, `titulo-acordeon-1`, `texto-acordeon-1`, `titulo-acordeon-2`, `texto-acordeon-2`, `titulo-acordeon-3`, `texto-acordeon-3`, `button-colarsar-titulo-1`, `button-colarsar-texto-1`, `button-colarsar-titulo-2`, `button-colarsar-texto-2`, `button-colarsar-titulo-3`, `button-colarsar-texto-3`, `numero_whatsapp`) VALUES
(1, './img-ini/inicio-6a96d8ed4f0ab.png', './img-ini/inicio-6a96d8ed501d5.jpeg', './img-ini/inicio-6a96d8ed5048c.jpeg', './img-ini/inicio-6a96d8ed50822.jpeg', 'https://youtu.be/G4B3WRvLX30?si=ix61wfLnyRp1gK1R', 'Técnica en Programación de Software', 'Programación de Software con el Sena-CIES con PHP-MOISES. El desarrollo de software hace referencia a un conjunto de actividades informáticas dedicadas al proceso de creación, diseño, implementación y soporte de software. El software propiamente dicho es el conjunto de instrucciones o programas que indican a un ordenador lo que debe hacer. Es independiente del hardware y hace que los ordenadores sean programables. El objetivo del desarrollo de software es crear un producto que satisfaga las necesidades de los usuarios y los objetivos empresariales de forma eficaz, repetible y segura. Los desarrolladores de software, programadores e ingenieros de software desarrollan software a través de una serie de pasos denominados ciclo de vida de desarrollo de software (SDLC). Las herramientas con inteligencia artificial e IA generativa se utilizan cada vez más para ayudar a los equipos de desarrollo de software a producir y probar el código.', 'Técnica en Matenimiento de Automatismos Industriales', 'La automatización industrial con el Sena CIES de Neiva Huila. Cuando hablamos de automatización industrial, nos referimos a sistemas que usan ordenadores, autómatas programables, robots y tecnologías digitales para controlar máquinas y procesos en las fábricas. Su objetivo es reducir al máximo el trabajo manual y evitar tareas peligrosas al reemplazarlas por acciones automáticas y seguras. La automatización industrial es la evolución natural de la mecanización. Mientras la mecanización usa máquinas básicas para ayudar al trabajador, la automatización emplea equipos inteligentes y programados para controlar los procesos de manera más precisa, rápida y eficiente. Actualmente, los rápidos avances tecnológicos han dado lugar a la llamada Industria 4.0 o cuarta revolución industrial. En esta nueva etapa, las empresas usan sistemas inteligentes que permiten controlar y optimizar tola la producción con mayor precisión, calidad y rendimiento. Esto convierte a la automatización industrial en una pieza clave para compañías fabricantes y prestadoras de servicios industriales. En este artículo, vamos a explicar claramente los componentes principales que forman parte de los sistemas de automatización. También veremos cuáles son los tipos más usados en la industria y analizaremos su importancia para técnicos y empresas de servicios o manufactura.', 'Técnico en Integración de Contenidos Digitales', 'El programa de Multimedia del SENA (formalmente conocido como Tecnología en Desarrollo Multimedia y Web o Técnico en Producción de Contenidos Digitales) Producir materiales audiovisuales para web, con finalidad comunicativa, aplicando técnicas de guionización, grabación, edición y optimización digital, para lograr contenidos adecuados en formato, narrativa y calidad técnica, según estándares de publicación en plataformas digitales.', 'Tecnología', 'La tecnología llegó para revolucionar nuestra vida a través de múltiples herramientas, dispositivos, software y plataformas, que nos permiten ser más eficientes, productivos y tener una mejor calidad de vida. Nos ha cambiado la forma en la que hacemos las actividades cotidianas, la manera en que nos comunicamos, el cómo trabajamos y hasta la forma de enseñar y aprender.\r\nSanta María Huila', 'Pedagogía', 'La tecnología llegó para revolucionar nuestra vida a través de múltiples herramientas, dispositivos, software y plataformas, que nos permiten ser más eficientes, productivos y tener una mejor calidad de vida. Nos ha cambiado la forma en la que hacemos las actividades cotidianas, la manera en que nos comunicamos, el cómo trabajamos y hasta la forma de enseñar y aprender.', 'Convivencia Escolar', 'La convivencia escolar es un espacio en el cual se promueve acciones y acuerdos diarios que garantizan un ambiente de respeto, empatía y resolución pacífica de conflictos dentro de la comunidad educativa. Fomentan una cultura de buen trato que impacta positivamente el aprendizaje Angel.', '3132345685');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `super_usuario`
--

CREATE TABLE `super_usuario` (
  `id_super_usuario` int(11) NOT NULL,
  `usuario` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `super_usuario`
--

INSERT INTO `super_usuario` (`id_super_usuario`, `usuario`, `password`) VALUES
(1, 'tata', 'tata12345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_users` int(11) NOT NULL,
  `usuario_users` varchar(150) NOT NULL,
  `contrasena_users` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_users`, `usuario_users`, `contrasena_users`) VALUES
(1, 'alberdelfin', '$2y$10$ebNgFh1.uFg7oWmFoGkqD.N39ZILmkM577l/y8YSIWP0Xj8UCx8/O');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id_asistencia`),
  ADD UNIQUE KEY `documento_estudiante` (`documento_asistencia`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id_contacto`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_eventos`);

--
-- Indices de la tabla `formulario_contacto`
--
ALTER TABLE `formulario_contacto`
  ADD PRIMARY KEY (`id_formulario`);

--
-- Indices de la tabla `inasistencia`
--
ALTER TABLE `inasistencia`
  ADD PRIMARY KEY (`id_inasistencia`),
  ADD UNIQUE KEY `estudiante_inasistencia` (`documento_inasistencia`);

--
-- Indices de la tabla `inicio`
--
ALTER TABLE `inicio`
  ADD PRIMARY KEY (`id_inicio`);

--
-- Indices de la tabla `super_usuario`
--
ALTER TABLE `super_usuario`
  ADD PRIMARY KEY (`id_super_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=362;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_eventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `formulario_contacto`
--
ALTER TABLE `formulario_contacto`
  MODIFY `id_formulario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `inasistencia`
--
ALTER TABLE `inasistencia`
  MODIFY `id_inasistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT de la tabla `inicio`
--
ALTER TABLE `inicio`
  MODIFY `id_inicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `super_usuario`
--
ALTER TABLE `super_usuario`
  MODIFY `id_super_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
