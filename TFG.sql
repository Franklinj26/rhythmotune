-- phpMyAdmin SQL Dump
-- version 5.2.2deb1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-06-2025 a las 18:07:50
-- Versión del servidor: 11.4.3-MariaDB-1
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `TFG`
--
CREATE DATABASE TFG;

USE TFG;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albums`
--

CREATE TABLE `albums` (
  `id_album` int(11) NOT NULL,
  `nom_album` varchar(50) NOT NULL,
  `año` year(4) NOT NULL,
  `id_artista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `albums`
--

INSERT INTO `albums` (`id_album`, `nom_album`, `año`, `id_artista`) VALUES
(1111, 'PRIMER DIA DE CLASES', '2021', 1001),
(1112, 'INTERSHIBUYA (FERXXO EDITION)', '2021', 1002),
(1113, 'MICRODOSIS', '2022', 1001),
(1114, 'ESTRELLA', '2023', 1001),
(1115, 'PARAISO', '2022', 1001),
(1116, 'LO MISMO DE SIEMPRE', '2025', 1001),
(1117, 'FERXXO  (VOL1:M.O.R)', '2020', 1002),
(1118, 'FELIZ CUMPLEAÑOS FERXXO TE PIRATEAMOS EL ALBUM', '2022', 1002),
(1119, 'MOR, NO LE TEMAS A LA OSCURIDAD', '2023', 1002);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artistas`
--

CREATE TABLE `artistas` (
  `id_artista` int(11) NOT NULL,
  `nom_artista` varchar(50) NOT NULL,
  `nacionalidad` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `artistas`
--

INSERT INTO `artistas` (`id_artista`, `nom_artista`, `nacionalidad`, `descripcion`) VALUES
(1001, 'Mora', 'Puerto Rico', 'Gabriel Armando Mora Quintero, puertorriqueño'),
(1002, 'Feid', 'Colombia', 'Salomón Villada Hoyos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

CREATE TABLE `canciones` (
  `id_cancion` int(11) NOT NULL,
  `nom_cancion` varchar(50) NOT NULL,
  `nom_artista` varchar(50) NOT NULL,
  `duracion` time NOT NULL,
  `id_album` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`id_cancion`, `nom_cancion`, `nom_artista`, `duracion`, `id_album`) VALUES
(1010, 'Tuyo', 'Mora', '04:29:00', 1111),
(1011, '512', 'Mora', '03:10:00', 1111),
(1012, 'Volando', 'Mora', '03:05:00', 1111),
(1013, 'Primer Dia de Clases', 'Mora', '02:26:00', 1111),
(1014, 'Fin del Mundo', 'Mora', '03:40:00', 1111),
(1015, 'La Carita', 'Mora', '03:12:00', 1111),
(1016, 'Cuando Sera', 'Mora', '02:56:00', 1111),
(1017, 'Te Conoci Perriando', 'Mora', '03:10:00', 1111),
(1018, 'Desaparecer', 'Mora', '02:45:00', 1111),
(1019, 'Vacio', 'Mora', '03:28:00', 1111),
(1020, 'Badtrip :(', 'Mora', '03:11:00', 1113),
(1021, '2010', 'Mora', '02:52:00', 1113),
(1022, 'Memorias', 'Mora', '02:48:00', 1113),
(1023, 'Tus Lagrimas', 'Mora', '02:54:00', 1113),
(1024, 'Escalofrios', 'Mora', '02:18:00', 1113),
(1025, 'Playa Privada', 'Mora, Elena Rose', '02:37:00', 1113),
(1026, 'Lejos de Ti', 'Mora', '02:08:00', 1113),
(1027, 'La Inocente', 'Mora, Feid', '03:22:00', 1113),
(1028, 'Ojos Colorau', 'Mora', '03:41:00', 1113),
(1029, 'Domingo de Bote', 'Mora', '03:10:00', 1115),
(1030, 'Apa', 'Mora, Quevedo', '03:19:00', 1115),
(1031, 'Calenton', 'Mora', '03:22:00', 1115),
(1032, 'Cositas', 'Mora, Paopao', '03:15:00', 1115),
(1033, 'En la Orilla', 'Mora', '03:54:00', 1115),
(1034, 'Modelito', 'Mora, Yovngchimi', '03:10:00', 1115),
(1035, 'Casualidad', 'Mora', '03:03:00', 1115),
(1036, 'Airbnb', 'Mora, De La Ghetto', '03:05:00', 1115),
(1037, 'Malafama', 'Mora', '02:48:00', 1115),
(1038, 'Que Habilidad', 'Mora', '03:53:00', 1115),
(1039, 'Pasajero', 'Mora', '02:28:00', 1114),
(1040, 'Polvora', 'Mora, Yandel', '03:05:00', 1114),
(1041, 'Donde se Aprende a Querer', 'Mora', '02:23:00', 1114),
(1042, 'Reina', 'Mora, Saiko', '03:31:00', 1114),
(1046, 'Fantasias', 'Mora', '03:11:00', 1114),
(1047, 'El Chacal', 'Mora', '03:17:00', 1114),
(1048, 'Laguna', 'Mora, Arcangel', '04:06:00', 1114),
(1049, 'Lokita', 'Mora', '02:34:00', 1114),
(1050, 'Pide', 'Mora, RaiNao', '03:27:00', 1114),
(1051, 'Un Deseo', 'Mora, Rainao', '03:38:00', 1114),
(1052, 'Corcega', 'Mora, Alvaro Diaz', '03:09:00', 1114),
(1053, 'Bandida', 'Mora', '03:59:00', 1116),
(1054, 'De Paquete', 'Mora, Jory Boy', '02:44:00', 1116),
(1055, 'Droga', 'Mora, C.Tangana', '03:42:00', 1116),
(1056, 'Aurora', 'Mora, De La Rose', '03:12:00', 1116),
(1057, 'Mil Vidas', 'Mora, Ryan Castro', '04:29:00', 1116),
(1058, 'Otra Noche Sin Dormir', 'Mora', '02:57:00', 1116),
(1059, 'Detras de tu Alma', 'Mora', '03:57:00', 1116),
(1060, 'Chimbita', 'Feid', '02:36:00', 1112),
(1061, 'Tengo Fe', 'Feid', '02:26:00', 1112),
(1062, 'Fumeteo', 'Feid', '02:14:00', 1112),
(1063, 'Purrito Apa', 'Feid', '02:31:00', 1112),
(1064, 'Hectol', 'Feid', '02:40:00', 1112),
(1065, 'El Padrino', 'Feid', '02:48:00', 1112),
(1066, 'Friki', 'Feid, Karol G', '02:25:00', 1112),
(1067, 'Comment', 'Feid', '02:50:00', 1112),
(1076, 'Castigo', 'Feid', '02:57:00', 1118),
(1077, 'Feliz Cumpleaños Ferxxo', 'Feid', '02:35:00', 1118),
(1078, 'Nieve', 'Feid', '02:20:00', 1118),
(1079, 'Ferxxo 100', 'Feid', '02:47:00', 1118),
(1080, 'Prhibidox', 'Feid', '02:46:00', 1118),
(1081, 'Lady Mi Amor', 'Feid', '02:27:00', 1118),
(1082, 'Aguante', 'Feid', '02:44:00', 1118),
(1083, 'Normal', 'Feid', '02:51:00', 1118),
(1084, 'Vente Conmigo', 'Feid', '03:05:00', 1119),
(1085, 'Ferxxo 151', 'Feid', '03:15:00', 1119),
(1086, 'Ferxxo Edition', 'Feid', '02:41:00', 1119),
(1087, 'Luces De Tecno', 'Feid', '02:44:00', 1119),
(1088, 'Ey Chory', 'Feid', '02:38:00', 1119),
(1089, 'Velocidad Crucero', 'Feid', '02:15:00', 1119),
(1090, 'Romanticos de Lunes', 'Feid', '04:02:00', 1119),
(1091, 'El Unico Tema Del Ferxxo', 'Feid', '03:02:00', 1119),
(1092, 'XX', 'Feid', '01:53:00', 1117),
(1093, 'Ateo', 'Feid', '02:18:00', 1117),
(1094, 'Porfa', 'Feid', '03:52:00', 1117),
(1095, 'Borraxxa', 'Feid', '03:43:00', 1117),
(1096, 'X19X', 'Feid', '02:41:00', 1117),
(1097, 'Relxjxte', 'Feid', '03:05:00', 1117),
(1098, 'Perreoxoxo', 'Feid', '01:31:00', 1117);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones_playlists`
--

CREATE TABLE `canciones_playlists` (
  `id_playlist` int(11) NOT NULL,
  `id_cancion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `canciones_playlists`
--

INSERT INTO `canciones_playlists` (`id_playlist`, `id_cancion`) VALUES
(1, 1010),
(1, 1011),
(1, 1020),
(1, 1021),
(1, 1030),
(1, 1031),
(1, 1035),
(1, 1036),
(1, 1053),
(1, 1056),
(1, 1060),
(1, 1067),
(1, 1076),
(1, 1082),
(1, 1093),
(1, 1095),
(2, 1016),
(2, 1018),
(2, 1024),
(2, 1029),
(2, 1032),
(2, 1033),
(2, 1046),
(2, 1047),
(2, 1052),
(2, 1054),
(2, 1055),
(2, 1059),
(2, 1065),
(2, 1088),
(2, 1091);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `id_cuenta` int(11) NOT NULL,
  `tipo_cuenta` varchar(50) NOT NULL,
  `precio` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`id_cuenta`, `tipo_cuenta`, `precio`) VALUES
(1, 'Premium', 10.00),
(2, 'Free', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlists`
--

CREATE TABLE `playlists` (
  `id_playlist` int(11) NOT NULL,
  `nom_playlist` varchar(50) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `f_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `playlists`
--

INSERT INTO `playlists` (`id_playlist`, `nom_playlist`, `id_usu`, `f_creacion`) VALUES
(1, 'Bellakeo', 1, '2025-06-04 20:51:18'),
(2, 'Otro rollo', 2, '2025-06-04 21:03:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reproducciones`
--

CREATE TABLE `reproducciones` (
  `id_reproduccion` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `id_cancion` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `reproducciones`
--

INSERT INTO `reproducciones` (`id_reproduccion`, `id_usu`, `id_cancion`, `fecha`) VALUES
(1, 1, 1010, '2025-06-04 21:00:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usu` int(11) NOT NULL,
  `nom_usu` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `f_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `id_cuenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usu`, `nom_usu`, `correo`, `contraseña`, `f_registro`, `id_cuenta`) VALUES
(1, 'Frank', 'frankbun10@gmail.com', 'asir', '2025-06-04 20:49:55', 1),
(2, 'Fabri', 'fpozoiguamba@gmail.com', 'asir1', '2025-06-04 21:02:41', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id_album`),
  ADD KEY `id_artista` (`id_artista`);

--
-- Indices de la tabla `artistas`
--
ALTER TABLE `artistas`
  ADD PRIMARY KEY (`id_artista`);

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD PRIMARY KEY (`id_cancion`),
  ADD KEY `id_album` (`id_album`);

--
-- Indices de la tabla `canciones_playlists`
--
ALTER TABLE `canciones_playlists`
  ADD PRIMARY KEY (`id_playlist`,`id_cancion`),
  ADD KEY `id_playlist` (`id_playlist`),
  ADD KEY `id_cancion` (`id_cancion`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id_cuenta`);

--
-- Indices de la tabla `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id_playlist`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `reproducciones`
--
ALTER TABLE `reproducciones`
  ADD PRIMARY KEY (`id_reproduccion`),
  ADD KEY `id_usu` (`id_usu`),
  ADD KEY `id_cancion` (`id_cancion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usu`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_cuenta` (`id_cuenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `albums`
--
ALTER TABLE `albums`
  MODIFY `id_album` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1120;

--
-- AUTO_INCREMENT de la tabla `artistas`
--
ALTER TABLE `artistas`
  MODIFY `id_artista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT de la tabla `canciones`
--
ALTER TABLE `canciones`
  MODIFY `id_cancion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1099;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id_playlist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reproducciones`
--
ALTER TABLE `reproducciones`
  MODIFY `id_reproduccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`id_artista`) REFERENCES `artistas` (`id_artista`);

--
-- Filtros para la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD CONSTRAINT `canciones_ibfk_1` FOREIGN KEY (`id_album`) REFERENCES `albums` (`id_album`);

--
-- Filtros para la tabla `canciones_playlists`
--
ALTER TABLE `canciones_playlists`
  ADD CONSTRAINT `canciones_playlists_ibfk_1` FOREIGN KEY (`id_playlist`) REFERENCES `playlists` (`id_playlist`),
  ADD CONSTRAINT `canciones_playlists_ibfk_2` FOREIGN KEY (`id_cancion`) REFERENCES `canciones` (`id_cancion`);

--
-- Filtros para la tabla `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`);

--
-- Filtros para la tabla `reproducciones`
--
ALTER TABLE `reproducciones`
  ADD CONSTRAINT `reproducciones_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`),
  ADD CONSTRAINT `reproducciones_ibfk_2` FOREIGN KEY (`id_cancion`) REFERENCES `canciones` (`id_cancion`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_cuenta`) REFERENCES `cuenta` (`id_cuenta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
