-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-09-2026 a las 14:39:33
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
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` int(11) NOT NULL,
  `banner_contacto` varchar(150) NOT NULL,
  `titulo-1-contacto` varchar(100) NOT NULL,
  `map-url-contacto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario_contacto`
--

CREATE TABLE `formulario_contacto` (
  `id_formulario` int(11) NOT NULL,
  `correo_formulario` varchar(200) NOT NULL,
  `nombre_formulario` varchar(200) NOT NULL,
  `telefono_formulario` int(11) NOT NULL,
  `mensaje_formulario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `formulario_contacto`
--

INSERT INTO `formulario_contacto` (`id_formulario`, `correo_formulario`, `nombre_formulario`, `telefono_formulario`, `mensaje_formulario`) VALUES
(2, 'delfin.alber@gmail.com', 'ALBER DELFIN PEÑA ORTIGOZA', 2147483647, 'Hola como estan.'),
(3, 'delfin.alber@gmail.com', 'ALBER DELFIN PEÑA ORTIGOZA', 2147483647, 'Hola como estan.'),
(4, 'breidy4282@gmail.com', 'Breidy Sanchez', 2147483647, 'Estamos programando con el Sena en el Eugenio Ferro Falla.'),
(5, 'dipayaco_0306@hotmail.com', 'DIANA PAOLA YAGUE CORTES', 2147483647, 'Hola india como está.'),
(6, 'delfin.alber@gmail.com', 'ALBER DELFIN PEÑA', 2147483647, 'Hola soy Delfin.'),
(7, 'santiagocruz@gmail.com', 'Santiago Peña Yague', 2147483647, 'Hola hijo como vamos'),
(8, 'delfin.alber@gmail.com', 'Rosa Isabel Peña', 323456789, 'Hola hija'),
(9, 'delfin.alber@gmail.com', 'Alber Delfin Peña Ortigoza', 2147483647, 'Ya esta sirviendo el formulario, carga a la base de datos y envia de una al correo de gmail.'),
(10, 'ronaljosuefernandezm@gmail.com', 'Ronal Josue Fernandez', 2147483647, 'Hola, estamos en Santa Maria Huila, desarrollando Software.'),
(11, 'rubielasanchez504@gmail.com', 'David Santiago Giron Vera', 2147483647, 'Un saludo David, estamos en el Eugenio Ferro Falla Programando con PHP y PHPMailer.'),
(12, 'cadenaolmoscristianmatias@gmail.com', 'CRISTIAN MATIAS CADENA OLMO', 2147483647, 'Un saludo, estamos en el Ricardo Borrero, programando en JavaScript');

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
-- Índices para tablas volcadas
--

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
-- Indices de la tabla `inicio`
--
ALTER TABLE `inicio`
  ADD PRIMARY KEY (`id_inicio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_eventos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formulario_contacto`
--
ALTER TABLE `formulario_contacto`
  MODIFY `id_formulario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `inicio`
--
ALTER TABLE `inicio`
  MODIFY `id_inicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
