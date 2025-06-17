-- phpMyAdmin SQL Dump
-- version 5.2.2deb1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-06-2025 a las 18:41:22
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albums`
--

CREATE TABLE `albums` (
  `id_album` int(11) NOT NULL,
  `nom_album` varchar(50) NOT NULL,
  `nombre_directorio` varchar(255) DEFAULT NULL,
  `año` year(4) NOT NULL,
  `id_artista` int(11) NOT NULL,
  `portada_album` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `albums`
--

INSERT INTO `albums` (`id_album`, `nom_album`, `nombre_directorio`, `año`, `id_artista`, `portada_album`) VALUES
(1111, 'PRIMER DIA DE CLASES', 'pddc', '2021', 1001, 'pddc.png'),
(1112, 'INTERSHIBUYA (FERXXO EDITION)', 'intyershibuya', '2021', 1002, 'intershibuya.jpeg'),
(1113, 'MICRODOSIS', 'microdosis', '2022', 1001, 'microdosis.jpeg'),
(1114, 'ESTRELLA', 'estrella', '2023', 1001, 'estrella.jpeg'),
(1115, 'PARAISO', 'paraiso', '2022', 1001, 'paraiso.jpeg'),
(1117, 'FERXXO  (VOL1:M.O.R)', 'vol1', '2020', 1002, 'ferxxo_vol_1.jpeg'),
(1119, 'MOR, NO LE TEMAS A LA OSCURIDAD', 'no_le_temas', '2023', 1002, 'MOR.jpeg'),
(1141, 'MAÑANA SERÁ BONITO', 'msb', '2023', 1018, 'msb.jpeg'),
(1142, 'KG0516', NULL, '2021', 1018, 'kg506.jpeg'),
(1143, 'UNSTOPPABLE', 'unstoppable', '2017', 1018, 'unstoppable.jpeg'),
(1144, 'OCEAN', NULL, '2019', 1018, 'ocean.jpeg'),
(1145, 'MAÑANA SERÁ BONITO (BICHOTA SEASON)', 'bichota_season', '2023', 1018, 'msbd.jpeg'),
(1146, 'DEBÍ TIRAR MÁS FOTOS', 'dtmf', '2025', 1017, 'dtmf.jpeg'),
(1147, 'UN VERANO SIN TI ', 'uvst', '2022', 1017, 'uvst.jpeg'),
(1148, 'YHLQMDLG', 'yhlqmdlg', '2020', 1017, 'yhlqmdlg.jpeg'),
(1149, 'X100PRE', 'x100pre', '2018', 1017, 'x100pre.jpeg'),
(1150, 'SATURNO', 'saturno', '2023', 1019, 'saturno.jpeg'),
(1151, 'VICE VERSA', 'viceversa', '2021', 1019, 'viceversa.jpeg'),
(1152, 'AFRODISIACO', 'afrodisiaco', '2020', 1019, 'afrodisiaco.jpeg'),
(1153, 'DON KBRN', 'don_kbrn', '2025', 1020, 'donkbrn.jpeg'),
(1154, 'SAUCE BOYZ', 'sauce_boyz', '2020', 1020, 'sbz.jpeg'),
(1155, 'SAUCE BOYZ 2', 'sauce_boyz_2', '2021', 1020, 'sbz2.jpeg'),
(1156, 'MONARCA', 'monarca', '2021', 1020, 'monarca.jpeg'),
(1157, 'ALPHA', 'alpha', '2023', 1021, 'alpha.jpeg'),
(1158, '11 RAZONES', '11_razones', '2020', 1021, '11_razones.jpeg'),
(1159, 'CUARTO AZUL', 'cuarto_azul', '2025', 1021, 'cuarto_azul.jpeg'),
(1160, 'DONDE QUIERO ESTAR', 'donde_quiero_estar', '2023', 1022, 'dqe.jpeg'),
(1161, 'BUENAS NOCHES', 'buenas_noches', '2024', 1022, 'bn.jpeg'),
(1162, 'SOUR', 'sour', '2021', 1023, 'sour.jpeg'),
(1163, 'GUTS', 'guts', '2023', 1023, 'guts.mp3'),
(1164, 'ETERNAL SUNSHINE', 'eternal_sunshine', '2024', 1024, 'eternal.jpeg'),
(1165, 'POSITIONS', 'positions', '2020', 1024, 'positions.jpeg'),
(1166, 'SWEETENER', 'sweetener', '2018', 1024, 'sweetener.jpeg'),
(1167, 'PLANET HER', 'planet_her', '2021', 1025, 'planet.jpeg'),
(1168, 'HOT PINK', 'hot_pink', '2019', 1025, 'pink.jpeg'),
(1169, 'RADICAL OPTIMISM', 'radical_optimism', '2024', 1026, 'radical.jpeg'),
(1170, 'FUTURE NOSTALGIA', 'future_nostalgia', '2020', 1026, 'future.jpeg'),
(1171, '21', '21', '2011', 1027, '21.jpeg'),
(1172, '30', '30', '2021', 1027, '30.jpeg'),
(1173, '25', '25', '2015', 1027, '25.jpeg'),
(1174, 'ANTI', 'anti', '2016', 1028, 'anti.jpeg'),
(1175, 'LOUD', 'loud', '2010', 1028, 'loud.mp3'),
(1176, 'TALK THAT TALK', 'talk_that_talk', '2011', 1028, 'talk.mp3'),
(1177, 'HIT ME HARD AND SOFT', 'hit_me_hard_and_soft', '2024', 1029, 'hmhas.jpeg'),
(1178, 'HAPPIER THAN EVER', 'happier_than_ever', '2021', 1029, 'hte.jpeg'),
(1179, 'WHEN WE ALL FALL ASLEEP, WHERE DO WE GO?', 'when_we_all_asleep_where_do_we_go', '2019', 1029, 'when_we.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artistas`
--

CREATE TABLE `artistas` (
  `id_artista` int(11) NOT NULL,
  `nom_artista` varchar(50) NOT NULL,
  `nacionalidad` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `foto_artista` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `artistas`
--

INSERT INTO `artistas` (`id_artista`, `nom_artista`, `nacionalidad`, `descripcion`, `foto_artista`) VALUES
(1001, 'Mora', 'Puerto Rico', 'Gabriel Armando Mora Quintero, puertorriqueño', 'mora.jpeg'),
(1002, 'Feid', 'Colombia', 'Salomón Villada Hoyos', 'feid.jpeg'),
(1017, 'Bad Bunny', 'Puerto Rico', 'Benito Antonio Martínez Ocasio.', 'badbo.jpg'),
(1018, 'Karol G', 'Colombia', 'Carolina Giraldo Navarro.', 'karolg.jpeg'),
(1019, 'Rauw Alejandro', 'Puerto Rico', 'Raúl Alejandro Ocasio Ruiz.', 'rauw.jpeg'),
(1020, 'Eladio Carrión', 'Puerto Rico', 'Eladio Carrión Morales.', 'eladio.jpeg'),
(1021, 'Aitana', 'España', 'Aitana Ocaña Morales.', 'aitana.jpeg'),
(1022, 'Quevedo', 'España', 'Pedro Luis Domínguez Quevedo.', 'quevedo.jpeg'),
(1023, 'Olivia Rodrigo', 'EE.UU', 'Olivia Isabel Rodrigo.', 'olivia.jpeg'),
(1024, 'Ariana Grande', 'EE.UU', 'Ariana Grande-Buter.', 'ari.jpeg'),
(1025, 'Doja Cat', 'EE.UU', 'Amala Ratna Zandile Dlamini.', 'doja.jpeg'),
(1026, 'Dua Lipa', 'Reino Unido', 'Dua Lipa.', 'dua.jpeg'),
(1027, 'Adele', 'Reino Unido', 'Adele Laurie Blue Adkins.', 'adele.jpeg'),
(1028, 'Rihanna', 'Barbados', 'Robyn Rihanna Fenty.', 'rihanna.jpeg'),
(1029, 'Billie Eillish', 'EE.UU', 'Billie Eilish Pirate Baird O\'Connell.', 'billie.jpeg'),
(1030, 'Michael Jackson', 'EE.UU', 'Michael Joseph Jackson.', 'jackson.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

CREATE TABLE `canciones` (
  `id_cancion` int(11) NOT NULL,
  `nom_cancion` varchar(50) NOT NULL,
  `nom_artista` varchar(50) NOT NULL,
  `ruta_audio` varchar(100) NOT NULL,
  `duracion` time NOT NULL,
  `id_album` int(11) NOT NULL,
  `reproducciones` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`id_cancion`, `nom_cancion`, `nom_artista`, `ruta_audio`, `duracion`, `id_album`, `reproducciones`) VALUES
(1010, 'Tuyo', 'Mora', '', '04:29:00', 1111, 0),
(1011, '512', 'Mora', '', '03:10:00', 1111, 0),
(1013, 'Primer Dia de Clases', 'Mora', '', '02:26:00', 1111, 0),
(1017, 'Te Conoci Perriando', 'Mora', '', '03:10:00', 1111, 0),
(1020, 'Badtrip :(', 'Mora', 'badtrip.mp3', '03:11:00', 1113, 1),
(1022, 'Memorias', 'Mora', 'memorias.mp3', '02:48:00', 1113, 0),
(1025, 'Playa Privada', 'Mora, Elena Rose', 'playa_privada.mp3', '02:37:00', 1113, 0),
(1026, 'Lejos de Ti', 'Mora', 'lejos_de_ti.mp3', '02:08:00', 1113, 0),
(1028, 'Ojos Colorau', 'Mora', 'ojos_colorau.mp3', '03:41:00', 1113, 0),
(1030, 'Apa', 'Mora, Quevedo', 'apa.mp3', '03:19:00', 1115, 0),
(1031, 'Calenton', 'Mora', 'calenton.mp3', '03:22:00', 1115, 0),
(1034, 'Modelito', 'Mora, Yovngchimi', 'modelito.mp3', '03:10:00', 1115, 0),
(1035, 'Casualidad', 'Mora', 'casualidad.mp3', '03:03:00', 1115, 0),
(1038, 'Que Habilidad', 'Mora', 'que_habilidad.mp3', '03:53:00', 1115, 0),
(1039, 'Pasajero', 'Mora', 'pasajero.mp3', '02:28:00', 1114, 0),
(1040, 'Polvora', 'Mora, Yandel', 'polvora.mp3', '03:05:00', 1114, 1),
(1041, 'Donde se Aprende a Querer', 'Mora', 'donde_se_aprende_a_querer.mp3', '02:23:00', 1114, 0),
(1046, 'Fantasias', 'Mora', 'fantasias.mp3', '03:11:00', 1114, 4),
(1048, 'Laguna', 'Mora, Arcangel', 'laguna.mp3', '04:06:00', 1114, 1),
(1049, 'Lokita', 'Mora', 'lokita.mp3', '02:34:00', 1114, 0),
(1060, 'Chimbita', 'Feid', 'chimbita.mp3', '02:36:00', 1112, 0),
(1062, 'Fumeteo', 'Feid', 'fumeteo.mp3', '02:14:00', 1112, 0),
(1065, 'El Padrino', 'Feid', 'el_padrino.mp3', '02:48:00', 1112, 4),
(1084, 'Vente Conmigo', 'Feid', 'vente_conmigo.mp3', '03:05:00', 1119, 0),
(1087, 'Luces De Tecno', 'Feid', 'luces_de_tecno.mp3', '02:44:00', 1119, 1),
(1088, 'Ey Chory', 'Feid', 'ey_chory.mp3', '02:38:00', 1119, 4),
(1094, 'Porfa', 'Feid', 'porfa.mp3', '03:52:00', 1117, 2),
(1095, 'Borraxxa', 'Feid', 'borraxxa.mp3', '03:43:00', 1117, 0),
(1099, 'Lo Sabe Dios', 'Karol G', 'lo_sabe_dios.mp3', '03:05:00', 1143, 0),
(1100, 'Ganas De Ti', 'Karol G', 'ganas_de_ti.mp3', '03:15:00', 1143, 0),
(1101, 'Hello ', 'Karol G', 'hello.mp3', '02:41:00', 1143, 0),
(1102, 'Lo Sabe Dios', 'Karol G', 'lo_sabe_dios.mp3', '02:31:00', 1143, 0),
(1103, 'Carolina', 'Karol G', 'carolina.mp3', '02:38:00', 1141, 0),
(1104, 'Mercurio', 'Karol G', 'mercurio.mp3', '02:57:00', 1141, 0),
(1105, 'Pero Tú', 'Karol G', 'pero_tu.mp3', '02:25:00', 1141, 0),
(1106, 'Tus Gafitas', 'Karol  G', 'tus_gafitas.mp3', '02:51:00', 1141, 0),
(1107, 'Bichota G', 'Karol G', 'bichotag.mp3', '02:05:00', 1145, 0),
(1108, 'Gatita Gangster', 'Karol G', 'gatita_gangster.mp3', '03:05:00', 1145, 0),
(1109, 'Oki Doki', 'Karol G', 'oki_doki.mp3', '03:10:00', 1145, 0),
(1110, 'Qlona', 'Karol G', 'qlona.mp3', '03:25:00', 1145, 0),
(1111, 'Algo Mágico', 'Rauw Alejandro', 'algo_magico.mp3', '03:10:00', 1152, 0),
(1112, 'Dile A Él', 'Rauw Alejandro', 'dile_a_el.mp3', '03:15:00', 1152, 0),
(1113, 'Mood', 'Rauw Alejandro', 'mood.mp3', '02:05:00', 1152, 0),
(1114, 'Pensándote', 'Rauw Alejandro', 'pensandote.mp3', '03:10:00', 1152, 1),
(1115, 'Corazón Despeinado', 'Rauw Alejandro', 'corazon_despeinado.mp3', '02:30:00', 1150, 1),
(1116, 'Dejau', 'Rauw Alejandro', 'dejau.mp3', '03:10:00', 1150, 0),
(1117, 'Lejos Del Cielo ', 'Rauw Alejandro', 'lejos_de_cielo.mp3', '02:10:00', 1150, 0),
(1118, 'Punto 40', 'Rauw Alejandro', 'punto_40.mp3', '03:05:00', 1150, 0),
(1119, 'Cosa Guapa ', 'Rauw Alejandro', 'cosa_guapa.mp3', '03:25:00', 1151, 0),
(1120, 'Desenfocao', 'Rauw Alejandro', 'desenfocao.mp3', '02:55:00', 1151, 3),
(1121, 'La Old Skul', 'Rauw Alejandro', 'la_old_skul.mp3', '03:15:00', 1151, 1),
(1122, 'Sexo Virtual.mp3', 'Rauw Alejandro', 'sexo_virtual.mp3', '03:10:00', 1151, 0),
(1123, 'Cuando Te Fuiste', 'Aitana', 'cuando_te_fuiste.mp3', '03:00:00', 1158, 0),
(1124, '- +', 'Aitana', 'menos_mas.mp3', '03:00:00', 1158, 0),
(1125, 'No Te Has Ido Y Ya Te Extraño', 'Aitana', 'no_te_has_ido_y_ya_te_extraño.mp3', '03:00:00', 1158, 0),
(1126, 'Si No Vas A Volver', 'Aitana', 'si_no_vas_volver.mp3', '03:00:00', 1158, 0),
(1127, '24 Rosas', 'Aitana', '24_rosas.mp3', '03:00:00', 1157, 0),
(1128, 'Los Angeles', 'Aitana', 'los_angeles.mp3', '03:00:00', 1157, 0),
(1129, 'Luna', 'Aitana', 'luna.mp3', '03:00:00', 1157, 0),
(1130, 'MiAmor', 'Aitana', 'miamor.mp3', '03:00:00', 1157, 0),
(1131, 'Cuando Hables Con Él', 'Aitana', 'cuando_hables_con_el.mp3', '03:00:00', 1159, 0),
(1132, 'Duele Un Montón Despedirme De Ti', 'Aitana', 'duele_un_monton_despedirme_de_ti.mp3', '03:00:00', 1159, 0),
(1133, 'Lia', 'Aitana', 'lia.mp3', '03:00:00', 1159, 1),
(1134, 'Trankis', 'Aitana', 'trankis.mp3', '03:00:00', 1159, 0),
(1135, 'Ignorantes', 'Bad Bunny', 'ignorantes.mp3', '03:00:00', 1148, 0),
(1136, 'La Santa', 'Bad Bunny', 'la_santa.mp3', '03:00:00', 1148, 0),
(1137, 'Que Malo', 'Bad Bunny', 'que_malo.mp3', '03:00:00', 1148, 0),
(1138, 'Vete', 'Bad Bunny', 'vete.mp3', '03:00:00', 1148, 0),
(1139, 'Caro', 'Bad Bunny', 'caro.mp3', '03:00:00', 1149, 0),
(1140, 'Otra Noche En Miami', 'Bad Bunny', 'otra_noche_en_miami', '03:00:00', 1149, 0),
(1141, 'Si Estuviesemos Juntos', 'Bad Bunny', 'si_estuviesemos_juntos.mp3', '03:00:00', 1149, 0),
(1142, 'Como Antes', 'Bad Bunny', 'como_antes.mp3', '03:00:00', 1149, 0),
(1143, 'Andrea', 'Bad Bunny', 'andrea.mp3', '03:00:00', 1147, 0),
(1144, 'Efecto', 'Bad Bunny', 'efecto.mp3', '03:00:00', 1147, 0),
(1145, 'Moscow Mule', 'Bad Bunny', 'moscow_mule.mp3', '03:00:00', 1147, 0),
(1146, 'Ojitos Lindos', 'Bad Bunny', 'ojitos_lindos.mp3', '03:00:00', 1147, 0),
(1147, 'Baile Inolvidable', 'Bad Bunny', 'baile_inolvidable.mp3', '03:00:00', 1146, 0),
(1148, 'Eoo', 'Bad Bunny', 'eoo.mp3', '03:00:00', 1146, 0),
(1149, 'Kloufrens', 'Bad Bunny', 'kloufrens.mp3', '03:00:00', 1146, 0),
(1150, 'Nueva Yol', 'Bad Bunny', 'nuevayol.mp3', '03:00:00', 1146, 0),
(1151, 'Adios', 'Eladio Carrión', 'adios.mp3', '03:00:00', 1156, 0),
(1152, 'Discoteca', 'Eladio Carrión', 'discoteca.mp3', '03:00:00', 1156, 0),
(1153, 'Tata', 'Eladio Carrión', 'tata.mp3', '03:00:00', 1156, 0),
(1154, 'Todo O Nada', 'Eladio Carrión', 'todo_o_nada.mp3', '03:00:00', 1156, 0),
(1155, 'Cuenta A 10', 'Eladio Carrión', 'cuenta_a_10.mp3', '03:00:00', 1153, 0),
(1156, 'El Reggaeton Del Disco', 'Eladio Carrión ', 'el_reggaeton_del_disco.mp3', '03:00:00', 1153, 0),
(1157, 'Tiffany', 'Eladio Carrión', 'tiffany.mp3', '03:00:00', 1153, 0),
(1158, 'Vetements', 'Eladio Carrión', 'vetements.mp3', '03:00:00', 1153, 0),
(1159, '3 AM', 'Eladio Carrión', '3_am.mp3', '03:00:00', 1154, 0),
(1160, 'Actriz', 'Eladio Carrión ', 'actriz.mp3', '03:00:00', 1154, 0),
(1161, 'Mala Mía', 'Eladio Carrión', 'mala_mia.mp3', '03:00:00', 1154, 0),
(1162, 'Mi Error', 'Eladio Carrión', 'mi_error.mp3', '03:00:00', 1154, 0),
(1163, 'Alejarme De Ti', 'Eladio Carrión ', 'alejarme_de_ti', '03:00:00', 1155, 0),
(1164, 'Flores En Anónimo', 'Eladio Carrión', 'flores_en_anonimo.mp3', '03:00:00', 1155, 0),
(1165, 'No Te Deseo El Mal', 'Eladio Carrión ', 'no_te_deseo_el_mal.mp3', '03:00:00', 1155, 0),
(1166, 'Me Gustas Natural', 'Eladio Carrión', 'me_gustas_natural.mp3', '03:00:00', 1155, 0),
(1167, 'Dame', 'Quevedo', 'dame.mp3', '03:00:00', 1160, 0),
(1168, 'Sin Señal', 'Quevedop', 'sin_señal.mp3', '03:00:00', 1160, 0),
(1169, 'Vista Al Mar', 'Quevedo', 'vista_al_mar.mp3', '03:00:00', 1160, 0),
(1170, 'Wanda', 'Quevedo', 'wanda.mp3', '03:00:00', 1160, 0),
(1171, 'Gran Vía', 'Quevedo', 'gran_via.mp3', '03:00:00', 1161, 0),
(1172, 'Mr Moondial', 'Quevedo', 'mr_moondial.mp3', '03:00:00', 1161, 0),
(1173, 'Noemú', 'Quevedo', 'noemu.mp3', '03:00:00', 1161, 0),
(1174, 'Te Fallé', 'Quevedo', 'te_falle.mp3', '03:00:00', 1161, 0),
(1175, 'Don\'t You Remember', 'Adele', 'dont_you_remember.mp3', '03:00:00', 1171, 0),
(1176, 'He Won\'t Go', 'Adele', 'he_wont_go.mp3', '03:00:00', 1171, 0),
(1177, 'Lovesong', 'Adele', 'lovesong.mp3', '03:00:00', 1171, 0),
(1178, 'Hello', 'Adele', 'hello.mp3', '03:00:00', 1173, 0),
(1179, 'I Miss You', 'Adele', 'i_miss_you.mp3', '03:00:00', 1173, 0),
(1180, 'Remedy', 'Adele', 'remedy.mp3', '03:00:00', 1173, 0),
(1181, 'River Lea', 'Adele', 'river_lea.mp3', '03:00:00', 1173, 0),
(1182, 'Can I Get It', 'Adele', 'can_i_get_it.mp3', '03:00:00', 1172, 0),
(1183, 'Easy On Me ', 'Adele ', 'easy_on_me.mp3', '03:00:00', 1172, 0),
(1184, 'Hold On', 'Adele', 'hold_on.mp3', '03:00:00', 1172, 0),
(1185, 'Oh My God', 'Adele', 'oh_my_god.mp3', '03:00:00', 1172, 0),
(1186, 'Consideration', 'Rihanna', 'consideration.mp3', '03:00:00', 1174, 0),
(1187, 'Needed Me', 'Rihanna', 'needed_me.mp3', '03:00:00', 1174, 0),
(1188, 'Woo', 'Rihanna', 'woo.mp3', '03:00:00', 1174, 0),
(1189, 'Work', 'Rihanna', 'work.mp3', '03:00:00', 1174, 0),
(1190, 'Drunk On Love', 'Rihanna', 'drunk_on_love.mp3', '03:00:00', 1176, 1),
(1191, 'Fool In Love', 'Rihanna', 'fool_in_love.mp3', '03:00:00', 1176, 0),
(1192, 'We Found Love', 'Rihanna', 'we_found_love.mp3', '03:00:00', 1176, 1),
(1193, 'You Da One', 'Rihanna', 'you_da_one.mp3', '03:00:00', 1176, 0),
(1194, 'Only Girl ', 'Loud', 'only_girl.mp3', '03:00:00', 1175, 0),
(1195, 'S&M', 'Rihamma', 's_and_m.mp3', '03:00:00', 1175, 0),
(1196, 'Skin', 'Rihanna', 'skin.mp3', '03:00:00', 1175, 0),
(1197, 'What\'s My Name?', 'Rihanna', 'whats_my_name.mp3', '03:00:00', 1175, 0),
(1198, 'Bye', 'Ariana Grande ', 'bye.mp3', '03:00:00', 1164, 0),
(1199, 'Don\'t Wanna Break Up Again', 'Ariana Grande', 'dont_wanna_break_up_again.mp3', '03:00:00', 1164, 0),
(1200, 'True Story', 'Ariana Grande', 'true_story.mp3', '03:00:00', 1164, 0),
(1201, 'Yes And?', 'Ariana Grande', 'yes_and.mp3', '03:00:00', 1164, 0),
(1202, 'Motive', 'Ariana Grande', 'motive.mp3', '03:00:00', 1165, 0),
(1203, 'My Hair', 'Ariana Grande ', 'my_hair.mp3', '03:00:00', 1165, 0),
(1204, 'Nasty', 'Ariana Grande', 'nasty.mp3', '03:00:00', 1165, 0),
(1205, 'Shut Up', 'Ariana Grande', 'shut_up.mp3', '03:00:00', 1165, 0),
(1206, 'Blazed', 'Ariana Grande', 'blazed.mp3', '03:00:00', 1166, 0),
(1207, 'Everytime', 'Ariana Grande', 'everytime.mp3', '03:00:00', 1166, 0),
(1208, 'Successful', 'Ariana Grande', 'successful.mp3', '03:00:00', 1166, 0),
(1209, 'Sweetener', 'Ariana Grande', 'sweetener.mp3', '03:00:00', 1166, 0),
(1210, 'Don´t Satart Now', 'Dua Lipa', 'dont_start_now.mp3', '03:00:00', 1170, 0),
(1211, 'Levitating', 'Dua Lipa', 'levitating.mp3', '03:00:00', 1170, 0),
(1212, 'Love Again', 'Dua Lipa', 'love_again.mp3', '03:00:00', 1170, 0),
(1213, 'Physical', 'Dua Lipa', 'physical.mp3', '03:00:00', 1170, 0),
(1214, 'Anything For Love', 'Dua Lipa', 'anything_for_love.mp3', '03:00:00', 1169, 0),
(1215, 'Houdini', 'Dua Lipa', 'houdini.mp3', '03:00:00', 1169, 0),
(1216, 'Illusion', 'Dua Lipa', 'illusion.mp3', '03:00:00', 1169, 0),
(1217, 'Training Season', 'Dua Lipa', 'training_season.mp3', '03:00:00', 1169, 0),
(1218, 'Lacy', 'Olivia Rodrigo', 'lacy.mp3', '03:00:00', 1163, 0),
(1219, 'Logical', 'Olivia Rodrigo', 'logical.mp3', '03:00:00', 1163, 0),
(1220, 'Obsessed', 'Olivia Rodrigo', 'obsessed.mp3', '03:00:00', 1163, 0),
(1221, 'Vampire', 'Olivia Rodrigo', 'vampire.mp3', '03:00:00', 1163, 0),
(1222, 'Brutal', 'Olivia Rodrigo', 'brutal.mp3', '03:00:00', 1162, 0),
(1223, 'Happier', 'Olivia Rodrigo', 'happier.mp3', '03:00:00', 1162, 0),
(1224, 'Hope Ur Ok', 'Olivia Rodrigo', 'hope_ur_ok.mp3', '03:00:00', 1162, 0),
(1225, 'Traitor', 'Olivia Rodrigo', 'traitor.mp3', '03:00:00', 1162, 0),
(1226, 'Happier Than Ever', 'Billie Eillish', 'happier_than_ever.mp3', '03:00:00', 1178, 0),
(1227, 'Lost_Cause', 'Billie Eillish', 'lost_cause.mp3', '03:00:00', 1178, 0),
(1228, 'NDA', 'Billie Eillish', 'nda.mp3', '03:00:00', 1178, 0),
(1229, 'Oxytocin', 'Billie Eillish', 'oxytocin.mp3', '03:00:00', 1178, 0),
(1230, 'Birds Of A Feather', 'Billie Eillish', 'birds_of_a_feather.mp3', '03:00:00', 1177, 1),
(1231, 'L\'amour De Ma Vie', 'Billie Eillish', 'lamour_de_ma_vie.mp3', '03:00:00', 1177, 0),
(1232, 'The Greatest', 'Billie Eillish', 'the_greatest.mp3', '03:00:00', 1177, 1),
(1233, 'Wildflower', 'Billie Eillish', 'wildflower.mp3', '03:00:00', 1177, 0),
(1234, 'Bad Guy', 'Billie Eillish', 'bad_guy.mp3', '03:00:00', 1179, 0),
(1235, 'I Love You', 'Billie Eillish', 'i_love_you.mp3', '03:00:00', 1179, 0),
(1236, 'Listen Before I Go', 'Billie Eillish', 'listen_before_i_go.mp3', '03:00:00', 1179, 0),
(1237, 'Wish You Were Gay', 'Billie Eillish', 'wish_you_were_gay.mp3', '03:00:00', 1179, 0),
(1238, 'Better Than Me ', 'Doja Cat', 'better_than_me.mp3', '03:00:00', 1168, 0),
(1239, 'Rules', 'Doja Cat', 'rules.mp3', '03:00:00', 1168, 0),
(1240, 'Say So', 'Doja cat', 'say_so.mp3', '03:00:00', 1168, 0),
(1241, 'Streets', 'Doja Cat', 'streets.mp3', '03:00:00', 1168, 0),
(1242, 'Ain\'t Shit', 'Doja Cat', 'aint_shit.mp3', '03:00:00', 1167, 0),
(1243, 'Get INto It (YUH)', 'Doja Cat', 'get_into_it_yuh.mp3', '03:00:00', 1167, 1),
(1244, 'Need To Know', 'Doja Cat', 'need_to_know.mp3', '03:00:00', 1167, 1),
(1245, 'Woman', 'Doja Cat', 'woman.mp3', '03:00:00', 1167, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones_playlists`
--

CREATE TABLE `canciones_playlists` (
  `id_playlist` int(11) NOT NULL,
  `id_cancion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

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
(2, 1020),
(2, 1024),
(2, 1025),
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
(2, 1091),
(2, 1094),
(2, 1120),
(3, 1114),
(3, 1115),
(3, 1116);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `id_cuenta` int(11) NOT NULL,
  `tipo_cuenta` varchar(50) NOT NULL,
  `precio` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `playlists`
--

INSERT INTO `playlists` (`id_playlist`, `nom_playlist`, `id_usu`, `f_creacion`) VALUES
(1, 'Bellakeo', 1, '2025-06-04 20:51:18'),
(2, 'Otro rollo', 2, '2025-06-04 21:03:10'),
(3, 'Pop', 2, '2025-06-16 12:31:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reproducciones`
--

CREATE TABLE `reproducciones` (
  `id_reproduccion` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `id_cancion` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usu`, `nom_usu`, `correo`, `contraseña`, `f_registro`, `id_cuenta`) VALUES
(1, 'Frank', 'frankbun10@gmail.com', 'asir', '2025-06-04 20:49:55', 1),
(2, 'Fabri', 'fpozoiguamba@gmail.com', 'asir1', '2025-06-04 21:02:41', 2),
(3, 'Pepe', 'pepe@gmail.com', 'asir2', '0000-00-00 00:00:00', 1),
(4, 'Ana', 'ana@gmail.com', 'asir3', '2025-06-06 17:11:05', 1),
(5, 'Juan', 'juan@gmail.com', 'asir4', '2025-06-06 19:49:17', 2),
(6, 'Pepito', 'pepito@gmail.com', 'asir6', '2025-06-06 22:16:48', 2),
(7, 'jose', 'jose@gmail.com', 'asir7', '2025-06-09 16:23:57', 1),
(8, 'Isa', 'isa@gmail.com', 'kali', '2025-06-09 17:00:07', 2),
(9, 'geison', 'geison@gmail.com', 'kali2', '2025-06-09 17:10:22', 1),
(10, 'diego', 'diego@gmail.com', 'kali3', '2025-06-09 17:12:23', 2),
(11, 'yolanda', 'yolanda@gmail.com', 'asir9', '2025-06-16 11:30:20', 1);

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
  MODIFY `id_album` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1180;

--
-- AUTO_INCREMENT de la tabla `artistas`
--
ALTER TABLE `artistas`
  MODIFY `id_artista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1031;

--
-- AUTO_INCREMENT de la tabla `canciones`
--
ALTER TABLE `canciones`
  MODIFY `id_cancion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1246;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id_playlist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reproducciones`
--
ALTER TABLE `reproducciones`
  MODIFY `id_reproduccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
