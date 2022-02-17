-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-07-2021 a las 02:41:03
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Millchat`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentarios` int(8) NOT NULL,
  `id_posteo` int(8) NOT NULL,
  `id_usuario` int(8) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentarios`, `id_posteo`, `id_usuario`, `fecha`, `comentario`) VALUES
(1, 17, 1, '2021-07-07 14:26:45', 'Es una cancion'),
(2, 17, 17, '2021-07-07 14:26:45', 'Es una cancion steampunk'),
(4, 18, 18, '2021-07-08 14:50:36', 'otro comentario'),
(5, 18, 18, '2021-07-08 14:51:04', 'otro comentario msa'),
(6, 3, 18, '2021-07-08 14:51:40', 'y este es un comentario'),
(9, 3, 18, '2021-07-08 16:10:24', 'comentario'),
(14, 19, 18, '2021-07-08 16:21:11', 'asasda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id_like` int(8) NOT NULL,
  `id_posteo` int(8) NOT NULL,
  `id_usuario` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id_pais` int(11) NOT NULL,
  `nombre_pais` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id_pais`, `nombre_pais`) VALUES
(1, 'Afganistán'),
(2, 'Albania'),
(3, 'Alemania'),
(4, 'Andorra'),
(5, 'Angola'),
(6, 'Antigua y Barbuda'),
(7, 'Arabia Saudita'),
(8, 'Argelia'),
(9, 'Argentina'),
(10, 'Armenia'),
(11, 'Australia'),
(12, 'Austria'),
(13, 'Azerbaiyán'),
(14, 'Bahamas'),
(15, 'Bangladés'),
(16, 'Barbados'),
(17, 'Baréin'),
(18, 'Bélgica'),
(19, 'Belice'),
(20, 'Benín'),
(21, 'Bielorrusia'),
(22, 'Birmania'),
(23, 'Bolivia'),
(24, 'Bosnia y Herzegovina'),
(25, 'Botsuana'),
(26, 'Brasil'),
(27, 'Brunéi'),
(28, 'Bulgaria'),
(29, 'Burkina Faso'),
(30, 'Burundi'),
(31, 'Bután'),
(32, 'Cabo Verde'),
(33, 'Camboya'),
(34, 'Camerún'),
(35, 'Canadá'),
(36, 'Catar'),
(37, 'Chad'),
(38, 'Chile'),
(39, 'China'),
(40, 'Chipre'),
(41, 'Ciudad del Vaticano'),
(42, 'Colombia'),
(43, 'Comoras'),
(44, 'Corea del Norte'),
(45, 'Corea del Sur'),
(46, 'Costa de Marfil'),
(47, 'Costa Rica'),
(48, 'Croacia'),
(49, 'Cuba'),
(50, 'Dinamarca'),
(51, 'Dominica'),
(52, 'Ecuador'),
(53, 'Egipto'),
(54, 'El Salvador'),
(55, 'Emiratos Árabes Unidos'),
(56, 'Eritrea'),
(57, 'Eslovaquia'),
(58, 'Eslovenia'),
(59, 'España'),
(60, 'Estados Unidos'),
(61, 'Estonia'),
(62, 'Etiopía'),
(63, 'Filipinas'),
(64, 'Finlandia'),
(65, 'Fiyi'),
(66, 'Francia'),
(67, 'Gabón'),
(68, 'Gambia'),
(69, 'Georgia'),
(70, 'Ghana'),
(71, 'Granada'),
(72, 'Grecia'),
(73, 'Guatemala'),
(74, 'Guinea ecuatorial'),
(75, 'Guinea'),
(76, 'Guinea-Bisáu'),
(77, 'Guyana'),
(78, 'Haití'),
(79, 'Honduras'),
(80, 'Hungría'),
(81, 'India'),
(82, 'Indonesia'),
(83, 'Irak'),
(84, 'Irán'),
(85, 'Irlanda'),
(86, 'Islandia'),
(87, 'Islas Marshall'),
(88, 'Islas Salomón'),
(89, 'Israel'),
(90, 'Italia'),
(91, 'Jamaica'),
(92, 'Japón'),
(93, 'Jordania'),
(94, 'Kazajistán'),
(95, 'Kenia'),
(96, 'Kirguistán'),
(97, 'Kiribati'),
(98, 'Kuwait'),
(99, 'Laos'),
(100, 'Lesoto'),
(101, 'Letonia'),
(102, 'Líbano'),
(103, 'Liberia'),
(104, 'Libia'),
(105, 'Liechtenstein'),
(106, 'Lituania'),
(107, 'Luxemburgo'),
(108, 'Madagascar'),
(109, 'Malasia'),
(110, 'Malaui'),
(111, 'Maldivas'),
(112, 'Malí'),
(113, 'Malta'),
(114, 'Marruecos'),
(115, 'Mauricio'),
(116, 'Mauritania'),
(117, 'México'),
(118, 'Micronesia'),
(119, 'Moldavia'),
(120, 'Mónaco'),
(121, 'Mongolia'),
(122, 'Montenegro'),
(123, 'Mozambique'),
(124, 'Namibia'),
(125, 'Nauru'),
(126, 'Nepal'),
(127, 'Nicaragua'),
(128, 'Níger'),
(129, 'Nigeria'),
(130, 'Noruega'),
(131, 'Nueva Zelanda'),
(132, 'Omán'),
(133, 'Países Bajos'),
(134, 'Pakistán'),
(135, 'Palaos'),
(136, 'Panamá'),
(137, 'Papúa Nueva Guinea'),
(138, 'Paraguay'),
(139, 'Perú'),
(140, 'Polonia'),
(141, 'Portugal'),
(142, 'Reino Unido'),
(143, 'República Centroafricana'),
(144, 'República Checa'),
(145, 'República de Macedonia'),
(146, 'República del Congo'),
(147, 'República Democrática del Congo'),
(148, 'República Dominicana'),
(149, 'República Sudafricana'),
(150, 'Ruanda'),
(151, 'Rumanía'),
(152, 'Rusia'),
(153, 'Samoa'),
(154, 'San Cristóbal y Nieves'),
(155, 'San Marino'),
(156, 'San Vicente y las Granadinas'),
(157, 'Santa Lucía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_usuario`
--

CREATE TABLE `perfil_usuario` (
  `id_usuario` int(8) NOT NULL,
  `nombre_usuario` text DEFAULT NULL,
  `apellido_usuario` text DEFAULT NULL,
  `pais_usuario` int(11) DEFAULT NULL,
  `edad_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfil_usuario`
--

INSERT INTO `perfil_usuario` (`id_usuario`, `nombre_usuario`, `apellido_usuario`, `pais_usuario`, `edad_usuario`) VALUES
(1, '', '', 9, 0),
(3, 'Juan Manuel', 'Zullo', 9, 24),
(17, NULL, NULL, 1, NULL),
(18, 'Clark', 'Kent', 120, 139),
(19, 'manuel', 'rodriguez', 18, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posteo`
--

CREATE TABLE `posteo` (
  `id_posteo` int(8) NOT NULL,
  `id_usuario_posteo` int(8) NOT NULL,
  `titulo_posteo` text NOT NULL,
  `texto_posteo` text NOT NULL,
  `imagen_posteo` text DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `contador_likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `posteo`
--

INSERT INTO `posteo` (`id_posteo`, `id_usuario_posteo`, `titulo_posteo`, `texto_posteo`, `imagen_posteo`, `fecha`, `contador_likes`) VALUES
(1, 18, 'Esto es todo titulo', 'y aca hay mucho texto', '', '2021-06-25 12:18:02', 0),
(2, 18, 'El segundo post', 'con mas cosas', '', '2021-06-25 13:54:19', 0),
(3, 18, 'este es el titulo', 'El veloz murciélago hindú comía feliz cardillo y kiwi. La cigüeña tocaba el saxofón detrás del palenque de paja. ', NULL, '2021-07-01 00:00:00', 0),
(13, 18, 'Pangrama 1', 'Whisky bueno: ¡excitad mi frágil pequeña vejez!', NULL, '2021-07-02 11:55:48', 0),
(14, 18, 'Pangrama 2', 'Jovencillo emponzoñado de whisky: ¡qué figurota exhibe!', NULL, '2021-07-02 12:08:06', 0),
(16, 18, 'The House of the Rising Sun', 'There is a house in Sin City\nThey call the Rising Sun\nAnd it\'s been the ruin of many a poor boy\nAnd God, I know I\'m one\nMy mother was a tailor\nShe sewed my new blue jeans\nMy father was a gamblin\' man\nDown in Sin City\nNow the only thing a gambler needs\nIs a suitcase and a trunk\nAnd the only time he\'s satisfied\nIs when he\'s on a drunk\nWell I\'ve got one foot on the platform\nThe other\'s on the train\nI\'m goin\' back to Sin City\nTo wear that ball and chain\nWell others tell your children\nNever do what I have done\nSpend your lives in sin and misery\nIn the House of the Rising Sun\nIn the House of the Rising Sun\nWell there is a house in Sin City\nThey call the Rising Sun\nAnd it\'s been the ruin of many a poor boy\nAnd God knows that I am one', NULL, '2021-07-06 23:21:36', 0),
(17, 18, 'Steampunk Revolution by Abney Park', 'We\'ve got a steampunk revolution\nWe\'re tired of all your so-called evolution\nWe\'ve darted back to 1886\nDon\'t ask us why; that\'s how we get our kicks\nOut with the new\nIn with the old\nOut with the new\nIn with the old\nOur underworld isn\'t filled with fear\nJust brass and copper, leather scrap, and rusty gear\nYou can keep your hip-hop techno-pop-rock schleppin-dub\nI\'m on my way to a coal-powered underground vintage pub\nWe\'ve got a steampunk revolution\nWe\'re tired of all your so-called evolution\nWe\'ve darted back to 1886\nDon\'t ask us why; that\'s how we get our kicks\nOut with the new\nIn with the old\nOut with the new\nIn with the old\nYour subculture shops at the mall\nWe build ours with blowtorch, needle, thread, and leather awl\nWith our antique clock parts we\'ve taken all arts, fine art to fashion\nAnd now we\'re spreading worldwide to circle the globe with a furious passion\nWe\'ve got a steampunk revolution\nWe\'re tired of all your so-called evolution\nWe\'ve darted back to 1886\nDon\'t ask us why; that\'s how we get our kicks\nWe\'ve got a steampunk revolution\nWe\'re tired of all your so-called evolution\nWe\'ve darted back to 1886\nDon\'t ask us why; that\'s how we get our kicks\nOut with the new\nIn with the old\n', NULL, '2021-07-07 00:02:16', 0),
(18, 18, 'este es el titulo', 'hola estoy haciendo intento', NULL, '2021-07-07 17:10:10', 0),
(19, 18, 'Hola buenas tardes', 'Hola buenas tardes', NULL, '2021-07-08 16:16:37', 0),
(20, 18, 'este es el titulo', 'hola un nuevo intento ', NULL, '2021-07-09 14:30:41', 0),
(21, 3, 'mi posteo', 'posteo hecho el 9 de julio', NULL, '2021-07-09 22:02:18', 0),
(22, 3, '9 de julio', 'Feliz 9 de julio ', NULL, '2021-07-09 22:04:01', 0),
(24, 3, 'mi posteo 8 de julio', 'jnhfgbnzcggvnczb', NULL, '2021-07-10 00:08:43', 0),
(25, 19, 'posteo', 'hola esto es un posteo nuevo', NULL, '2021-07-10 00:32:48', 0),
(26, 3, 'starwars', 'esto es un posteo de starwars', NULL, '2021-07-10 00:36:20', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(8) NOT NULL,
  `nombre_usuario` varchar(20) NOT NULL,
  `email_usuario` text NOT NULL,
  `password_usuario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `email_usuario`, `password_usuario`) VALUES
(1, 'pepino', 'pepino@gmail.com', '$2y$10$BCneQM9iHOMRk2OdDERy6uIZh3fHAMg6OOSnG2mgZrmzjyIJxIJkG'),
(3, 'juan.zullo', 'juan.zullo@gmail.com', '$2y$10$BCneQM9iHOMRk2OdDERy6uIZh3fHAMg6OOSnG2mgZrmzjyIJxIJkG'),
(17, 'mailo', 'mailo@mailo', '$2y$10$BCneQM9iHOMRk2OdDERy6uIZh3fHAMg6OOSnG2mgZrmzjyIJxIJkG'),
(18, 'Superman', 'Superman@gmail', '$2y$10$BCneQM9iHOMRk2OdDERy6uIZh3fHAMg6OOSnG2mgZrmzjyIJxIJkG'),
(19, 'manu', 'manu@hotmail.com', '$2y$10$wdYZshocshsL1Th1mK.LwOIig06eIw6KEDtnxjQN/6D8roIGQGVSG');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentarios`),
  ADD KEY `fkcomentario_posteo` (`id_posteo`),
  ADD KEY `fkcomentario_usuario` (`id_usuario`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `fklikes_posteo` (`id_posteo`),
  ADD KEY `fklikes_usuario` (`id_usuario`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id_pais`);

--
-- Indices de la tabla `perfil_usuario`
--
ALTER TABLE `perfil_usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `posteo`
--
ALTER TABLE `posteo`
  ADD PRIMARY KEY (`id_posteo`),
  ADD KEY `fkusuario` (`id_usuario_posteo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentarios` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id_like` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id_pais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT de la tabla `posteo`
--
ALTER TABLE `posteo`
  MODIFY `id_posteo` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fkcomentario_posteo` FOREIGN KEY (`id_posteo`) REFERENCES `posteo` (`id_posteo`),
  ADD CONSTRAINT `fkcomentario_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fklikes_posteo` FOREIGN KEY (`id_posteo`) REFERENCES `posteo` (`id_posteo`),
  ADD CONSTRAINT `fklikes_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `posteo`
--
ALTER TABLE `posteo`
  ADD CONSTRAINT `fkusuario` FOREIGN KEY (`id_usuario_posteo`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
