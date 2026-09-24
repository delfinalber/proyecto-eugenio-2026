-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-09-2026 a las 17:10:00
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
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_asistencia` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `inicio`
--
ALTER TABLE `inicio`
  MODIFY `id_inicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
