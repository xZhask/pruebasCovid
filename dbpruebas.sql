-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 30-09-2022 a las 15:21:17
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbpruebas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepruebas`
--

CREATE TABLE `detallepruebas` (
  `idreporte` int DEFAULT NULL,
  `tipo_beneficiario` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `c_pcr` int DEFAULT '0',
  `c_ant` int DEFAULT '0',
  `c_ser` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallepruebas`
--

INSERT INTO `detallepruebas` (`idreporte`, `tipo_beneficiario`, `c_pcr`, `c_ant`, `c_ser`) VALUES
(15, 'T', 3, 0, 1),
(15, 'F', 0, 1, 0),
(16, 'T', 0, 1, 3),
(16, 'F', 0, 2, 0),
(17, 'T', 2, 0, 2),
(17, 'F', 1, 0, 2),
(18, 'F', 1, 0, 1),
(19, 'F', 1, 0, 2),
(20, 'F', 0, 2, 0),
(21, 'F', 1, 2, 0),
(23, 'TA', 2, 2, 0),
(23, 'TD', 1, 1, 1),
(23, 'TR', 0, 0, 1),
(23, 'F', 0, 0, 2),
(25, 'TA', 2, 0, 0),
(25, 'TD', 1, 0, 0),
(25, 'TR', 0, 0, 0),
(25, 'F', 1, 0, 0),
(26, 'TA', 2, 1, 0),
(26, 'TD', 1, 0, 1),
(26, 'TR', 1, 0, 1),
(26, 'F', 0, 2, 0),
(27, 'TA', 3, 0, 0),
(27, 'TD', 2, 0, 0),
(27, 'TR', 1, 0, 0),
(27, 'F', 0, 0, 0),
(29, 'TA', 3, 0, 0),
(29, 'TD', 2, 0, 0),
(29, 'TR', 1, 0, 0),
(29, 'F', 0, 0, 0),
(30, 'TA', 0, 0, 0),
(30, 'TD', 1, 0, 0),
(30, 'TR', 0, 0, 0),
(30, 'F', 2, 0, 0),
(31, 'TA', 3, 2, 1),
(31, 'TD', 0, 2, 1),
(31, 'TR', 0, 1, 0),
(31, 'F', 0, 0, 0),
(32, 'TA', 0, 2, 1),
(32, 'TD', 1, 0, 1),
(32, 'TR', 0, 1, 0),
(32, 'F', 1, 0, 0),
(33, 'TA', 2, 0, 0),
(33, 'TD', 1, 0, 0),
(33, 'TR', 0, 0, 0),
(33, 'F', 1, 0, 0),
(35, 'TA', 1, 2, 0),
(35, 'TD', 1, 0, 1),
(35, 'TR', 0, 1, 0),
(35, 'F', 1, 0, 1),
(36, 'TA', 0, 1, 0),
(36, 'TD', 1, 1, 0),
(36, 'TR', 1, 0, 1),
(36, 'F', 0, 1, 1),
(37, 'TA', 1, 0, 1),
(37, 'TD', 0, 1, 0),
(37, 'TR', 1, 1, 0),
(37, 'F', 1, 0, 1),
(40, 'TA', 1, 0, 0),
(40, 'TD', 0, 0, 0),
(40, 'TR', 2, 0, 0),
(40, 'F', 1, 0, 0),
(38, 'TA', 2, 0, 1),
(38, 'TD', 0, 1, 0),
(38, 'TR', 1, 0, 1),
(38, 'F', 2, 1, 1),
(43, 'TA', 1, 0, 0),
(43, 'TD', 0, 0, 0),
(43, 'TR', 0, 0, 0),
(43, 'F', 2, 0, 0),
(47, 'TA', 8, 0, 0),
(47, 'TD', 8, 0, 0),
(47, 'TR', 8, 0, 0),
(47, 'F', 8, 0, 0),
(51, 'TA', 1, 0, 0),
(56, 'TA', 2, 0, 0),
(56, 'TD', 0, 0, 0),
(56, 'TR', 0, 0, 0),
(56, 'F', 4, 0, 0),
(55, 'TA', 2, 0, 0),
(55, 'TD', 0, 0, 0),
(55, 'TR', 0, 0, 0),
(55, 'F', 1, 0, 0),
(53, 'TA', 3, 0, 0),
(53, 'TD', 0, 0, 0),
(53, 'TR', 0, 0, 0),
(53, 'F', 0, 2, 0),
(54, 'TA', 0, 0, 0),
(54, 'TD', 0, 0, 0),
(54, 'TR', 0, 0, 0),
(54, 'F', 0, 0, 2),
(58, 'TR', 3, 0, 0),
(59, 'TR', 1, 0, 0),
(60, 'TA', 0, 0, 0),
(60, 'TD', 3, 0, 0),
(60, 'TR', 0, 0, 0),
(60, 'F', 0, 0, 0),
(63, 'TR', 2, 0, 0),
(62, 'TA', 0, 0, 0),
(62, 'TD', 0, 0, 0),
(62, 'TR', 0, 0, 0),
(62, 'F', 4, 0, 0),
(64, 'TA', 1, 0, 0),
(64, 'TD', 3, 0, 0),
(64, 'TR', 0, 4, 0),
(64, 'F', 0, 2, 0),
(66, 'TR', 2, 0, 0),
(65, 'TD', 3, 0, 0),
(65, 'F', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipress`
--

CREATE TABLE `ipress` (
  `codigoipress` char(8) COLLATE utf8mb4_general_ci NOT NULL,
  `ipress` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idregion` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ipress`
--

INSERT INTO `ipress` (`codigoipress`, `ipress`, `idregion`) VALUES
('00008036', 'POL. POL. ABANCAY', 13),
('00009296', 'POL. POL. CAJAMARCA', 8),
('00009320', 'POL. POL. MADRE DE DIOS', 21),
('00009476', 'PMP. HUANCAVELICA', 12),
('00010148', 'POL POL PUCALLPA', 19),
('00010153', 'PMP. PAMPAS', 12),
('00010205', 'POL.POL.HUARAZ', 18),
('00010235', 'POL. POL. PUNO', 16),
('00010236', 'POL. POL. JULIACA', 16),
('00010451', 'PMP. VIPOL', 5),
('00010557', 'POL POL .CALLAO', 5),
('00010573', 'PMP. VENTANILLA', 5),
('00010610', 'PMP. DIRAVPOL', 5),
('00010679', 'POL. POL. \"AMG\" PIURA', 7),
('00010680', 'PS. POL. HUANCABAMBA', 7),
('00010688', 'PMP. SULLANA', 7),
('00010710', 'POL POL HUANCAYO', 12),
('00010834', 'PMP. HUACHO', 3),
('00010900', 'POL. POL. ICA', 14),
('00010929', 'PMP. CHOTA', 8),
('00011154', 'POL POL TRUJILLO ', 9),
('00011187', 'POL POL ZARATE', 4),
('00011227', 'PMP. CHACLACAYO', 4),
('00011369', 'POL.POL IQUITOS', 10),
('00011398', 'POL. POL. CHINCHA', 14),
('00011399', 'PMP. NAZCA', 14),
('00011400', 'PMP. PISCO', 14),
('00011421', 'POL POL . HUANUCO', 11),
('00011426', 'POL. POL. AYACUCHO', 14),
('00011437', 'PMP. HUANTA', 14),
('00011485', 'PMP. SATIPO', 12),
('00011528', 'POL. POL. TACNA ', 20),
('00011661', 'PMP. CAMANA', 15),
('00011664', 'PMP. SAN MARTIN DE PORRES', 15),
('00011743', 'POL. POL. CUSCO \"SANTA ROSA\"', 13),
('00011744', 'PMP. LA CONVENCION QUILLABAMBA', 13),
('00011747', 'PMP. PUCUTO.', 13),
('00011773', 'PMP. PASCO', 11),
('00011794', 'HOS.REG.POL. AREQUIPA', 15),
('00011833', 'HOSP. REG. POLICIAL CHICLAYO', 8),
('00011874', 'PMP. JAUJA', 12),
('00011876', 'POL POL SMP', 3),
('00011892', 'PMP ANDAHUAYLAS', 13),
('00011894', 'PMP CHINCHEROS', 13),
('00011913', 'PMP. LA MERCED', 12),
('00012088', 'POL. POL. \"LA CRUZ\" TUMBES', 7),
('00012275', 'POL POL DINOES', 4),
('00012454', 'PMP. MAZAMARI', 12),
('00012664', 'PMP. CARABAYLLO', 3),
('00012739', 'POL POL SAN DIEGO', 3),
('00012740', 'POL POL MININTER', 2),
('00012741', 'PMP. INDEPENDENCIA', 3),
('00012885', 'POL.POL.WRL', 6),
('00012954', 'PMP. BAGUA', 17),
('00013591', 'CHP LNS', 1),
('00014718', 'HGP SAN JOSE', 1),
('00015236', 'POL. POL. MOQUEGUA ', 20),
('00015771', 'PMP. TINGO MARIA', 11),
('00016094', 'HOSPITAL PNP \"AUGUSTO B. LEGUIA\"', 1),
('00017336', 'PMP. ISLAY', 15),
('00017391', 'POL POL COIP', 6),
('00017690', 'POL.POL.CHIMBOTE', 18),
('00017849', 'POL POL CAÑETE', 2),
('00018077', 'POL. POL. MOYOBAMBA', 17),
('00018106', 'POL. POL. BAGUA GRANDE', 17),
('00018660', 'POL POL SEDE EO', 2),
('00018950', 'POL. POL. JAEN', 8),
('00019390', 'POL POL SAN BARTOLO', 2),
('00020382', 'POL POL CHORRILLOS', 2),
('00020827', 'POL. POL. TARAPOTO', 17),
('00024663', 'PMP. SICUANI.', 13),
('00025272', 'PSP. SANTA LUCIA', 17),
('00025776', 'PMP. EESTP PNP HYO', 12),
('00025870', 'PMP. ILO', 20),
('00026723', 'POL. POL. CHACHAPOYAS', 17),
('00027203', 'PSP. PALMAPAMPA', 14),
('00027230', 'PMP. PICHARI', 14),
('00027415', 'PSP. EESTP PNP AYACUCHO', 14),
('00028466', 'PMP. PTE PIEDRA', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `region`
--

CREATE TABLE `region` (
  `idregion` int NOT NULL,
  `region` varchar(80) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `region`
--

INSERT INTO `region` (`idregion`, `region`) VALUES
(1, 'HOSPITALES'),
(2, 'DIVRISSP LIMA SUR'),
(3, 'DIVRISSP LIMA NORTE'),
(4, 'DIVRISSP LIMA ESTE'),
(5, 'DIVRISSP LIMA OESTE'),
(6, 'DIVRISSP LIMA CENTRO'),
(7, 'I MRSP - PIURA'),
(8, 'II MRSP - LAMBAYEQUE'),
(9, 'III MRSP - LA LIBERTAD'),
(10, 'IV MRSP - LORETO'),
(11, 'V MRSP - HUANUCO'),
(12, 'VI MRSP - JUNIN'),
(13, 'VII MRSP - CUSCO'),
(14, 'VIII MRSP - AYACUCHO'),
(15, 'IX MRSP - AREQUIPA'),
(16, 'X MRSP - PUNO'),
(17, 'XI MRSP - SAN MARTIN'),
(18, 'XII MRSP - ANCASH'),
(19, 'XIII MRSP - UCAYALI'),
(20, 'XIV MRSP - TACNA'),
(21, 'XV MRSP - MADRE DE DIOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportediario`
--

CREATE TABLE `reportediario` (
  `idreporte` int NOT NULL,
  `codigoipress` char(8) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `comentario` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idusuario` char(8) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecharegistro` datetime DEFAULT NULL,
  `virus` char(1) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reportediario`
--

INSERT INTO `reportediario` (`idreporte`, `codigoipress`, `fecha`, `comentario`, `idusuario`, `fecharegistro`, `virus`) VALUES
(1, '00011833', '2022-05-05', '', '09665639', NULL, 'C'),
(3, '00011894', '2022-05-05', '', '09665639', NULL, 'C'),
(4, '00008036', '2022-05-05', '', '09665639', NULL, 'C'),
(5, '00011833', '2022-05-09', '', '09665639', NULL, 'C'),
(6, '00011833', '2022-05-16', '', '09665639', NULL, 'C'),
(7, '00008036', '2022-05-16', '', '09665639', NULL, 'C'),
(8, '00010929', '2022-05-16', '', '48193845', NULL, 'C'),
(9, '00011833', '2022-05-17', '', '09665639', NULL, 'C'),
(10, '00010929', '2022-05-17', '', '48193845', NULL, 'C'),
(11, '00018950', '2022-05-17', '', '48193845', NULL, 'C'),
(12, '00009296', '2022-05-17', '', '48193845', NULL, 'C'),
(13, '00011833', '2022-05-30', '', '09665639', '2022-05-30 16:39:32', 'C'),
(14, '00009476', '2022-06-07', '', '09665639', '2022-06-07 15:17:17', 'C'),
(15, '00009296', '2022-08-03', '', '48193845', '2022-08-03 14:45:26', 'C'),
(16, '00010929', '2022-08-03', '', '48193845', '2022-08-03 16:27:33', 'C'),
(17, '00009296', '2022-08-11', '', '09665639', '2022-08-11 08:39:35', 'C'),
(18, '00011833', '2022-08-23', '', '09665639', '2022-08-23 16:17:38', 'C'),
(19, '00011894', '2022-08-23', '', '09665639', '2022-08-23 16:37:54', 'C'),
(20, '00011154', '2022-08-23', '', '09665639', '2022-08-23 16:43:29', 'C'),
(21, '00009296', '2022-08-23', '', '09665639', '2022-08-23 16:48:42', 'C'),
(23, '00011833', '2022-08-24', '', '09665639', '2022-08-24 10:23:17', 'C'),
(25, '00011833', '2022-09-02', '', '09665639', '2022-09-02 14:28:30', 'M'),
(26, '00011833', '2022-09-02', '', '09665639', '2022-09-02 14:44:50', 'C'),
(27, '00011833', '2022-09-05', '', '09665639', '2022-09-05 10:44:22', 'M'),
(28, '00013591', '2022-09-02', '', '09665639', '2022-09-05 10:46:53', 'C'),
(29, '00013591', '2022-09-05', '', '09665639', '2022-09-05 10:52:27', 'M'),
(30, '00013591', '2022-09-04', '', '09665639', '2022-09-05 10:55:25', 'M'),
(31, '00011833', '2022-09-06', '', '09665639', '2022-09-06 10:26:27', 'C'),
(32, '00009296', '2022-09-05', '', '09665639', '2022-09-06 10:28:10', 'C'),
(33, '00009296', '2022-09-06', '', '09665639', '2022-09-06 10:39:35', 'M'),
(35, '00010688', '2022-09-06', '', '09665639', '2022-09-06 10:58:32', 'C'),
(36, '00010557', '2022-09-06', '', '09665639', '2022-09-06 11:01:58', 'C'),
(37, '00010680', '2022-09-06', '', '09665639', '2022-09-06 11:05:58', 'C'),
(38, '00011400', '2022-09-06', '', '09665639', '2022-09-06 11:06:19', 'C'),
(40, '00013591', '2022-09-06', '', '09665639', '2022-09-06 11:46:27', 'M'),
(43, '00009320', '2022-09-06', '', '09665639', '2022-09-06 15:45:00', 'M'),
(44, '00010148', '2022-09-06', '', '09665639', '2022-09-06 15:47:35', 'M'),
(45, '00012088', '2022-09-06', '', '09665639', '2022-09-06 15:47:45', 'M'),
(46, '00011833', '2022-09-06', '', '09665639', '2022-09-06 15:49:06', 'M'),
(47, '00011400', '2022-09-06', '', '09665639', '2022-09-06 15:51:03', 'M'),
(48, '00010929', '2022-09-06', '', '09665639', '2022-09-06 15:51:11', 'M'),
(49, '00011399', '2022-09-06', '', '09665639', '2022-09-06 15:53:45', 'M'),
(50, '00014718', '2022-09-06', '', '09665639', '2022-09-06 16:23:49', 'M'),
(51, '00011833', '2022-09-07', '', '09665639', '2022-09-07 08:53:13', 'C'),
(53, '00009296', '2022-09-07', '', '09665639', '2022-09-07 09:32:28', 'C'),
(54, '00012454', '2022-09-07', '', '09665639', '2022-09-07 09:34:18', 'C'),
(55, '00011227', '2022-09-07', '', '09665639', '2022-09-07 09:38:04', 'M'),
(56, '00011833', '2022-09-07', '', '09665639', '2022-09-07 09:38:38', 'M'),
(57, '00011187', '2022-09-07', '', '09665639', '2022-09-07 11:04:58', 'C'),
(58, '00009296', '2022-09-07', '', '09665639', '2022-09-07 11:52:31', 'M'),
(59, '00018950', '2022-09-07', '', '09665639', '2022-09-07 11:53:04', 'M'),
(60, '00011894', '2022-09-07', '', '09665639', '2022-09-07 11:55:39', 'C'),
(61, '00010148', '2022-09-07', '', '09665639', '2022-09-07 11:59:27', 'M'),
(62, '00010710', '2022-09-07', '', '09665639', '2022-09-07 12:02:20', 'M'),
(63, '00010680', '2022-09-07', '', '09665639', '2022-09-07 12:03:37', 'M'),
(64, '00011398', '2022-09-07', '', '09665639', '2022-09-07 12:04:55', 'C'),
(65, '00016094', '2022-09-07', '', '09665639', '2022-09-07 12:07:48', 'C'),
(66, '00016094', '2022-09-07', '', '09665639', '2022-09-07 12:08:16', 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario` char(8) COLLATE utf8mb4_general_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipousuario` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `idregion` int DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario`, `pass`, `nombre`, `tipousuario`, `idregion`, `estado`) VALUES
('09665639', '21232f297a57a5a743894a0e4a801fc3', 'VICTOR ESPEJO', 'ADMINISTRADOR', NULL, 'A'),
('12345678', '21232f297a57a5a743894a0e4a801fc3', 'USUARIO 1', 'RESPONSABLE', 1, 'A'),
('16456828', '21232f297a57a5a743894a0e4a801fc3', 'SILVA SANCHEZ, CESAR AUGUSTO', 'RESPONSABLE', 8, 'A'),
('48193845', '21232f297a57a5a743894a0e4a801fc3', 'JOSUÉ SILVA A.', 'ADMINISTRADOR', 8, 'A'),
('77332033', '21232f297a57a5a743894a0e4a801fc3', 'BAUTISTA SANCHEZ, KERLY ZULEYDY', 'RESPONSABLE', 4, 'A');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detallepruebas`
--
ALTER TABLE `detallepruebas`
  ADD KEY `idreporte` (`idreporte`);

--
-- Indices de la tabla `ipress`
--
ALTER TABLE `ipress`
  ADD PRIMARY KEY (`codigoipress`),
  ADD KEY `idregion` (`idregion`);

--
-- Indices de la tabla `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`idregion`);

--
-- Indices de la tabla `reportediario`
--
ALTER TABLE `reportediario`
  ADD PRIMARY KEY (`idreporte`),
  ADD KEY `codigoipress` (`codigoipress`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario`),
  ADD KEY `idregion` (`idregion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `region`
--
ALTER TABLE `region`
  MODIFY `idregion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `reportediario`
--
ALTER TABLE `reportediario`
  MODIFY `idreporte` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallepruebas`
--
ALTER TABLE `detallepruebas`
  ADD CONSTRAINT `detallepruebas_ibfk_1` FOREIGN KEY (`idreporte`) REFERENCES `reportediario` (`idreporte`);

--
-- Filtros para la tabla `ipress`
--
ALTER TABLE `ipress`
  ADD CONSTRAINT `ipress_ibfk_1` FOREIGN KEY (`idregion`) REFERENCES `region` (`idregion`);

--
-- Filtros para la tabla `reportediario`
--
ALTER TABLE `reportediario`
  ADD CONSTRAINT `reportediario_ibfk_1` FOREIGN KEY (`codigoipress`) REFERENCES `ipress` (`codigoipress`),
  ADD CONSTRAINT `reportediario_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idregion`) REFERENCES `region` (`idregion`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
