-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2019 a las 02:39:53
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
(79, 'INGLES'),
(80, 'ESPAÃ‘OL'),
(81, 'PORTUGUÃ‰S'),
(82, 'SABES'),
(83, 'HABLA'),
(84, 'APRENDER:'),
(85, 'APRENDIENDO:'),
(86, 'ESTA'),
(87, 'PASA'),
(88, 'SI'),
(89, 'AQUÃ'),
(90, 'A'),
(91, 'QQQ'),
(92, 'MEJORAR'),
(93, 'JORGE'),
(94, 'EN'),
(95, 'PUEDO'),
(96, 'TE'),
(97, 'AYUDAR'),
(98, '1234'),
(99, '123'),
(100, '4'),
(101, 'Z'),
(102, 'K'),
(103, 'UN'),
(104, 'TRES'),
(105, 'DOS'),
(106, 'ESCUCHAR'),
(107, 'ALICE'),
(108, 'NOSE'),
(109, 'SÃ'),
(110, 'TU'),
(111, 'Q'),
(112, 'EDAD'),
(113, '1'),
(114, 'CUANTO'),
(115, 'ES'),
(116, 'D1'),
(117, 'D2'),
(118, '5555555'),
(119, '5'),
(120, '11'),
(121, '5/3'),
(122, '1/3'),
(123, 'E'),
(124, '2'),
(125, '3'),
(126, '50'),
(127, '6'),
(128, '9'),
(129, '8'),
(130, '5/5'),
(131, '5/2'),
(132, '15'),
(133, '18'),
(134, '10'),
(135, '/4'),
(136, 'LLAMAS'),
(137, 'DIVIDIDO'),
(138, 'SUMA'),
(139, 'HAN'),
(140, 'PREGUNTADO'),
(141, 'TAN'),
(142, 'PREGUNTARON');

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
  `pregunta` varchar(100) COLLATE utf8_bin NOT NULL,
  `pregunta_original` varchar(100) COLLATE utf8_bin NOT NULL,
  `equivalente` int(11) NOT NULL DEFAULT '0',
  `Nrespuestas` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `pregunta`, `pregunta_original`, `equivalente`, `Nrespuestas`) VALUES
(1, 'HABLAS INGLES', 'Hablas ingles', 0, 1),
(2, 'COMO ESTAS', 'Como estas', 0, 3),
(5, 'HABLAS PORTUGUES', 'Hablas portugues', 0, 1),
(7, 'SABES ALGO DE INGLES', 'Sabes algo de ingles', 1, 1),
(8, 'HABLA INGLES', 'Habla ingles', 1, 1),
(9, 'COMO ESTA', 'Como esta', 2, 1),
(19, 'COMO TE LLAMAS', 'Como te llamas', 0, 1),
(24, 'CUANTOS ANOS TIENES', 'cuantos aÃ±os tienes', 0, 0),
(25, 'QUE TE PREGUNTARON', 'que te preguntaron', 0, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `respuesta` varchar(100) COLLATE utf8_bin NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `V_emocional` int(11) NOT NULL DEFAULT '0',
  `experiencia` int(11) NOT NULL DEFAULT '0',
  `importancia` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `respuesta`, `id_pregunta`, `V_emocional`, `experiencia`, `importancia`) VALUES
(1, 'BIEN, APRENDIENDO', 2, 0, 0, 0),
(2, 'BIEN,GRACIAS', 2, 0, 0, 0),
(3, 'APRENDIENDO DE TI', 2, 0, 0, 0),
(4, 'NO', 1, 0, 0, 0),
(14, 'ALIS', 19, 0, 0, 0),
(15, 'MUCHAS COSAS', 25, 0, 0, 0);

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
(4, 1, 4, 100),
(9, 19, 14, 0),
(10, 25, 15, 0);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pregunta` (`id_pregunta`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipo_respuesta_peso`
--
ALTER TABLE `tipo_respuesta_peso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id`);

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
