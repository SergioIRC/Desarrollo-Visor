-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-03-2026 a las 19:21:43
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
-- Base de datos: `demovisor`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_d_usuario_01` (IN `xusu_id` INT)   BEGIN

	UPDATE tm_usuario 

	SET 

		est='0',

		fech_elim = now() 

	where usu_id=xusu_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_usuario_01` ()   BEGIN
	SELECT * FROM tm_usuario where est='1';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_usuario_02` (IN `xusu_id` INT)   BEGIN
	SELECT * FROM tm_usuario where usu_id=xusu_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_log_visor`
--

CREATE TABLE `tm_log_visor` (
  `log_id` int(11) NOT NULL,
  `usu_id` int(11) NOT NULL,
  `usu_nombre` varchar(150) NOT NULL,
  `detalle_busqueda` text DEFAULT NULL,
  `pdf_nombre` varchar(255) DEFAULT NULL,
  `pdf_ruta` text DEFAULT NULL,
  `accion` enum('busqueda','consulta','impresion') NOT NULL DEFAULT 'consulta',
  `fech_evento` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_municipios_visor`
--

CREATE TABLE `tm_municipios_visor` (
  `mun_id` int(11) NOT NULL,
  `mun_nombre` varchar(100) NOT NULL,
  `mun_codigo` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tm_municipios_visor`
--

INSERT INTO `tm_municipios_visor` (`mun_id`, `mun_nombre`, `mun_codigo`, `activo`) VALUES
(1, 'Allende', 13, 1),
(2, 'General Teran', 34, 1),
(3, 'Montemorelos', 45, 1),
(4, 'Marin', 46, 1),
(5, 'Rayones', 53, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_usuario`
--

CREATE TABLE `tm_usuario` (
  `usu_id` int(11) NOT NULL,
  `usu_nom` varchar(150) DEFAULT NULL,
  `usu_ape` varchar(150) DEFAULT NULL,
  `usu_correo` varchar(150) NOT NULL,
  `usu_pass` varchar(150) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `usu_telf` varchar(12) NOT NULL,
  `fech_crea` datetime DEFAULT NULL,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla Mantenedor de Usuarios';

--
-- Volcado de datos para la tabla `tm_usuario`
--

INSERT INTO `tm_usuario` (`usu_id`, `usu_nom`, `usu_ape`, `usu_correo`, `usu_pass`, `rol_id`, `usu_telf`, `fech_crea`, `fech_modi`, `fech_elim`, `est`) VALUES
(1, 'Usuario', 'ROL1', 'demo_87@hotmail.com', '3KLS4SbnBWTIgkUw4FqoF4THhtK48O3NnNbkePfFaaI=', 1, '+51981233834', '2020-12-14 19:46:22', NULL, NULL, 1),
(2, 'Usuario', 'ROL2', 'demomail@gmail.com', '3KLS4SbnBWTIgkUw4FqoF4THhtK48O3NnNbkePfFaaI=', 2, '+51981233834', '2020-12-14 19:46:22', NULL, NULL, 1),
(3, 'Sergio', 'Ortiz', 'demo12@gmail.com', '3KLS4SbnBWTIgkUw4FqoF4THhtK48O3NnNbkePfFaaI=', 2, '+51981233834', '2020-12-14 19:46:22', NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tm_log_visor`
--
ALTER TABLE `tm_log_visor`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_log_usuario` (`usu_id`),
  ADD KEY `idx_log_accion` (`accion`),
  ADD KEY `idx_log_fecha` (`fech_evento`);

--
-- Indices de la tabla `tm_municipios_visor`
--
ALTER TABLE `tm_municipios_visor`
  ADD PRIMARY KEY (`mun_id`);

--
-- Indices de la tabla `tm_usuario`
--
ALTER TABLE `tm_usuario`
  ADD PRIMARY KEY (`usu_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tm_log_visor`
--
ALTER TABLE `tm_log_visor`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_municipios_visor`
--
ALTER TABLE `tm_municipios_visor`
  MODIFY `mun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tm_usuario`
--
ALTER TABLE `tm_usuario`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tm_log_visor`
--
ALTER TABLE `tm_log_visor`
  ADD CONSTRAINT `fk_log_usuario` FOREIGN KEY (`usu_id`) REFERENCES `tm_usuario` (`usu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
