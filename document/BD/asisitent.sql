-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2019 a las 15:48:35
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asisitent`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabras`
--

CREATE TABLE `palabras` (
  `id` int(11) NOT NULL,
  `palabras` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `palabras`
--

INSERT INTO `palabras` (`id`, `palabras`) VALUES
(1, 'HOLA'),
(2, 'ESTAS'),
(3, 'COMO'),
(4, 'QUÃ‰'),
(5, 'ESTABAS'),
(6, 'AYER'),
(9, 'STAS'),
(12, 'CUANTOS'),
(13, 'AÃ‘OS'),
(14, 'TIENES'),
(16, 'CUENTOS'),
(17, 'TINES'),
(18, 'ADIOS'),
(19, 'ADIÃ“S'),
(23, 'CÃ“MO'),
(24, 'ESTÃS'),
(25, 'Ã‰STAS'),
(26, 'GENIAL'),
(27, 'CORRIGIENDO'),
(28, 'ERROR'),
(29, 'EL'),
(30, 'PRUEBA'),
(31, 'JUGANDO'),
(32, 'TÃš'),
(33, 'HACES'),
(34, 'Y'),
(35, 'ESO'),
(36, 'PORQUE'),
(37, 'TRABAJAR'),
(38, 'DIME'),
(39, 'POR'),
(40, 'ESTABA'),
(41, 'LO'),
(42, 'HACIENDO'),
(43, 'BUENO'),
(44, 'DE'),
(45, 'SIEMPRE'),
(46, 'HACIÃ‰NDOLO'),
(47, 'LA'),
(48, 'INTELIGENCIA'),
(49, 'ARTIFICIAL'),
(50, 'Ã‰L'),
(51, 'ESTÃ'),
(52, 'HABLANDO'),
(53, 'TELÃ‰FONO'),
(54, 'VOY'),
(55, 'TOY'),
(56, 'YO'),
(57, 'NO'),
(58, 'ESTOY'),
(59, 'INTENTANDO'),
(60, 'ALGO'),
(61, 'HACER'),
(62, 'SEGURO'),
(64, 'CAMBIAR'),
(65, 'OK'),
(66, 'LOCO'),
(67, 'ENVIAR'),
(68, 'DÃ‰JALA'),
(69, 'BAILE'),
(70, 'QUE'),
(71, 'PRINCIPIOS'),
(72, 'TRAVÃ‰S'),
(76, 'HOL'),
(77, 'SALIR'),
(78, 'HABLAS'),
(79, 'INGLES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `dato` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `valor` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id`, `dato`, `valor`) VALUES
(1, 'NOMBRE', 'Alis'),
(2, 'CREADORES', '@JORGEDIPRA & @Kratos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `pregunta` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `pregunta`) VALUES
(1, 'HABLAS INGLES'),
(2, 'COMO ESTAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `respuesta` varchar(100) COLLATE utf8_bin NOT NULL,
  `V_emocional` int(11) NOT NULL,
  `experiencia` int(11) NOT NULL,
  `importancia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `respuesta`, `V_emocional`, `experiencia`, `importancia`) VALUES
(1, 'BIEN, APRENDIENDO', 0, 0, 0),
(2, 'BIEN,GRACIAS', 0, 0, 0),
(3, 'APRENDIENDO DE TI', 0, 0, 0),
(4, 'NO', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_respuesta_peso`
--

CREATE TABLE `tipo_respuesta_peso` (
  `id` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `respuesta` int(11) NOT NULL,
  `peso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `tipo_respuesta_peso`
--

INSERT INTO `tipo_respuesta_peso` (`id`, `id_pregunta`, `respuesta`, `peso`) VALUES
(1, 2, 1, 34),
(2, 2, 2, 30),
(3, 2, 3, 36),
(4, 1, 4, 100);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `palabras`
--
ALTER TABLE `palabras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_respuesta_peso`
--
ALTER TABLE `tipo_respuesta_peso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pregunta` (`id_pregunta`) USING BTREE,
  ADD KEY `respuesta` (`respuesta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `palabras`
--
ALTER TABLE `palabras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_respuesta_peso`
--
ALTER TABLE `tipo_respuesta_peso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tipo_respuesta_peso`
--
ALTER TABLE `tipo_respuesta_peso`
  ADD CONSTRAINT `tipo_respuesta_peso_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id`),
  ADD CONSTRAINT `tipo_respuesta_peso_ibfk_2` FOREIGN KEY (`respuesta`) REFERENCES `respuestas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
