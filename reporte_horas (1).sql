-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-01-2025 a las 20:59:32
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
-- Base de datos: `reporte_horas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL,
  `nombre_proyecto` varchar(255) NOT NULL,
  `codigo_proyecto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `nombre_proyecto`, `codigo_proyecto`) VALUES
(2, 'proyecto pablito ga de', 'PPGDD'),
(3, 'proyecto alfin j z g', 'PAJZG'),
(4, 'La ptmr causa ga', 'fa'),
(5, 'Nuevo Proyecto ', 'PROC712S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id` int(11) NOT NULL,
  `nombre_proyecto` varchar(255) NOT NULL,
  `codigo_proyecto` varchar(50) NOT NULL,
  `horas_efectivas` decimal(10,2) NOT NULL DEFAULT 0.00,
  `porcentaje_100` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `porcentaje` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mes` varchar(2) NOT NULL,
  `anio` varchar(4) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_sesion` varchar(255) NOT NULL,
  `codigo_usuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`id`, `nombre_proyecto`, `codigo_proyecto`, `horas_efectivas`, `porcentaje_100`, `porcentaje`, `mes`, `anio`, `imagen`, `fecha_creacion`, `usuario_sesion`, `codigo_usuario`) VALUES
(22, 'La ptmr causa ga', 'LPCG', 120.00, 0.5634, 56.00, '01', '2025', '1737768469_Captura de pantalla 2025-01-24 184822.png', '2025-01-25 01:27:49', 'smith', 'SZT'),
(23, 'proyecto alfin j z g', 'PAJZG', 68.00, 0.3192, 31.00, '01', '2025', '1737768469_Captura de pantalla 2025-01-24 184822.png', '2025-01-25 01:27:49', 'smith', 'SZT'),
(24, 'proyecto pablito ga de', 'PPGD', 25.00, 0.1174, 11.00, '01', '2025', '1737768469_Captura de pantalla 2025-01-24 184822.png', '2025-01-25 01:27:49', 'smith', 'SZT'),
(25, 'La ptmr causa ga', 'LPCG', 120.00, 0.5634, 56.00, '01', '2024', '1737768728_Captura de pantalla 2025-01-24 184822.png', '2025-01-25 01:32:08', 'smith', 'SZT'),
(26, 'proyecto alfin j z g', 'PAJZG', 68.00, 0.3192, 31.00, '01', '2024', '1737768728_Captura de pantalla 2025-01-24 184822.png', '2025-01-25 01:32:08', 'smith', 'SZT'),
(27, 'proyecto pablito ga de', 'PPGD', 25.00, 0.1174, 11.00, '01', '2024', '1737768728_Captura de pantalla 2025-01-24 184822.png', '2025-01-25 01:32:08', 'smith', 'SZT'),
(28, 'proyecto pablito ga de', 'PPGDD', 2.00, 1.0000, 100.00, '01', '2024', '1738005689_tabla.png', '2025-01-27 19:21:29', 'Jhonatan', 'JTB'),
(29, 'Nuevo Proyecto ', 'PROC712S', 16.00, 0.0821, 8.00, '08', '2024', '1738005830_tabla.png', '2025-01-27 19:23:50', 'smith', 'SZT'),
(30, 'La ptmr causa ga', 'LPCG', 127.00, 0.6513, 65.00, '08', '2024', '1738005830_tabla.png', '2025-01-27 19:23:50', 'smith', 'SZT'),
(31, 'proyecto alfin j z g', 'PAJZG', 52.00, 0.2667, 26.00, '08', '2024', '1738005830_tabla.png', '2025-01-27 19:23:50', 'smith', 'SZT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_usuario`
--

CREATE TABLE `reporte_usuario` (
  `id` int(11) NOT NULL,
  `proyecto_id` int(11) NOT NULL,
  `codigo_proyecto` varchar(50) NOT NULL,
  `dia_1` varchar(255) DEFAULT NULL,
  `dia_2` varchar(255) DEFAULT NULL,
  `dia_3` varchar(255) DEFAULT NULL,
  `dia_4` varchar(255) DEFAULT NULL,
  `dia_5` varchar(255) DEFAULT NULL,
  `dia_6` varchar(255) DEFAULT NULL,
  `dia_7` varchar(255) DEFAULT NULL,
  `dia_8` varchar(255) DEFAULT NULL,
  `dia_9` varchar(255) DEFAULT NULL,
  `dia_10` varchar(255) DEFAULT NULL,
  `dia_11` varchar(255) DEFAULT NULL,
  `dia_12` varchar(255) DEFAULT NULL,
  `dia_13` varchar(255) DEFAULT NULL,
  `dia_14` varchar(255) DEFAULT NULL,
  `dia_15` varchar(255) DEFAULT NULL,
  `dia_16` varchar(255) DEFAULT NULL,
  `dia_17` varchar(255) DEFAULT NULL,
  `dia_18` varchar(255) DEFAULT NULL,
  `dia_19` varchar(255) DEFAULT NULL,
  `dia_20` varchar(255) DEFAULT NULL,
  `dia_21` varchar(255) DEFAULT NULL,
  `dia_22` varchar(255) DEFAULT NULL,
  `dia_23` varchar(255) DEFAULT NULL,
  `dia_24` varchar(255) DEFAULT NULL,
  `dia_25` varchar(255) DEFAULT NULL,
  `dia_26` varchar(255) DEFAULT NULL,
  `dia_27` varchar(255) DEFAULT NULL,
  `dia_28` varchar(255) DEFAULT NULL,
  `dia_29` varchar(255) DEFAULT NULL,
  `dia_30` varchar(255) DEFAULT NULL,
  `dia_31` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `usuario` varchar(100) NOT NULL,
  `codigo_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reporte_usuario`
--

INSERT INTO `reporte_usuario` (`id`, `proyecto_id`, `codigo_proyecto`, `dia_1`, `dia_2`, `dia_3`, `dia_4`, `dia_5`, `dia_6`, `dia_7`, `dia_8`, `dia_9`, `dia_10`, `dia_11`, `dia_12`, `dia_13`, `dia_14`, `dia_15`, `dia_16`, `dia_17`, `dia_18`, `dia_19`, `dia_20`, `dia_21`, `dia_22`, `dia_23`, `dia_24`, `dia_25`, `dia_26`, `dia_27`, `dia_28`, `dia_29`, `dia_30`, `dia_31`, `fecha_creacion`, `usuario`, `codigo_usuario`) VALUES
(70, 4, 'LPCG', 'G', '1', '3', '24', '24', '24', '20', '20', '2', 'V', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2025-01-27 16:22:35', 'smith', 'SZT'),
(80, 3, 'PAJZG', 'C', '11', '1', '8', '4', '4', '6', '8', '', '2', '8', 'Z', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2025-01-27 16:22:35', 'smith', 'SZT'),
(81, 2, 'PPGDD', '1', '', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2025-01-27 16:20:59', 'Jhonatan', 'JTB'),
(82, 5, 'PROC712S', '', 'G', '', '', 'V', 'V', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2025-01-27 16:22:35', 'smith', 'SZT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `empresa` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `codigo`, `rol`, `empresa`, `password`) VALUES
(1, 'Admin', 'Ticona Bastidas', 'ATB', 'administrador', 'Hualca', '$2y$10$QH6ZBXJuQiDJ3gI1oflUCOaJoNkhZQVx.BnYbMJQGRgEK.rJMJIHi'),
(4, 'Smith', 'Ticona Bastidas', 'STB', 'administrador', 'Hualca', '$2y$10$Q7R3n9baUdy4zA1m1YUASeAEIn08BAMxcZL/oCNAnBsu//agWmF3G'),
(5, 'Jhonatan', 'Ticona Bastidas', 'JTB', 'usuario', 'Hualca', '$2y$10$PwODTet9kBt3nqKpVA2y7.T71CD8FXJepSdCgPnjOza6asAzyk2U.'),
(6, 'smith', 'zarzosa toribio', 'SZT', 'usuario', 'Hualca', '$2y$10$nmQ65Y91QyntIMNhqPJfXu0BGb4Sw2wE9e9XhyEXCYM67rZxwma5i'),
(7, 'admin', 'admin', 'AA', 'administrador', 'Hualca', '$2y$10$63v3muwS1dBjY0X0ScgZoOXDLbVxf5EI/pXC1MgLE04WT9CSU0aXy'),
(9, 'usuario', 'usuario', 'UU', 'usuario', 'HTOP', '$2y$10$TsiOCoxLD3D6Ig3xq8V5AOfP3OETirL0Fn3ZRYucqcFFWu4TB55Xq'),
(10, 'mrd', 'mrd', 'MM', 'usuario', 'Hualca', '$2y$10$TFgvtbOBXLF6mStlG.HAsu84u6osz4mMt2dEdrcGkb0apOzGvyiLS'),
(11, 'ff', 'f', 'FF', 'usuario', 'HTOP', '$2y$10$2GwTbgOuqcDvhV89rDtarulpcdtx6o2jyJ4e8tQZwHMuumrlgIDe6'),
(13, 'tmr', 'imu', 'TI', 'usuario', 'Hualca', '$2y$10$2z9jjWQThy/z7AsKrEzpRe1mHc46Cs1ye8Guk0In.ZWcbGG6fUNhC'),
(15, 'hola', 'bueas', 'HB', 'usuario', 'Hualca', '$2y$10$2Y5utdybuUmy4Z2hPjq.5ec7XnoeFvxtwlAm77b7y9h6KQlfwlFCS'),
(17, 'mafer', 'villarreal', 'MV', 'usuario', 'Hualca', '$2y$10$DA9SsEW0Kyh8fSLUi/aRDeuysw4baer3Svqp5S3oVOrsdLE3aTg2a');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reporte_usuario`
--
ALTER TABLE `reporte_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proyecto_id` (`proyecto_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `reporte_usuario`
--
ALTER TABLE `reporte_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reporte_usuario`
--
ALTER TABLE `reporte_usuario`
  ADD CONSTRAINT `reporte_usuario_ibfk_1` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
