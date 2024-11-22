-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2024 a las 22:49:43
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `obrasocial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afiliados`
--

CREATE TABLE `afiliados` (
  `id_afiliado` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `plan_cobertura_id` int(11) DEFAULT NULL,
  `estado_cuenta` enum('activo','inactivo','moroso') DEFAULT 'activo',
  `fecha_afiliacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `afiliados`
--

INSERT INTO `afiliados` (`id_afiliado`, `id_usuario`, `nombre`, `apellido`, `direccion`, `telefono`, `email`, `fecha_nacimiento`, `plan_cobertura_id`, `estado_cuenta`, `fecha_afiliacion`) VALUES
(6, 16, 'Joel', 'Puntano', 'Espora 646', '112233445566', 'joelpuntano@gmail.com', '2006-02-21', 3, 'activo', '2024-11-12 21:07:47'),
(7, 19, 'Esther', 'Puntano', 'Espora 647', '112233445566', 'estherpuntano@gmail.com', '1983-01-13', 1, 'activo', '2024-11-12 21:32:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `id_afiliado` int(11) NOT NULL,
  `fecha_emision` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_vencimiento` date DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','pagada','vencida') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `id_afiliado`, `fecha_emision`, `fecha_vencimiento`, `monto`, `estado`) VALUES
(3, 6, '2024-11-12 21:07:47', '2024-12-12', '4000.00', 'pendiente'),
(4, 7, '2024-11-12 21:32:00', '2024-12-12', '1500.00', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_servicios`
--

CREATE TABLE `historial_servicios` (
  `id_historial` int(11) NOT NULL,
  `id_afiliado` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `fecha_uso` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `id_plan` int(11) NOT NULL,
  `nombre_plan` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`id_plan`, `nombre_plan`, `descripcion`, `costo`) VALUES
(1, 'Básico', 'Cobertura básica con servicios limitados.', '1500.00'),
(2, 'Intermedio', 'Cobertura intermedia con algunos beneficios adicionales.', '2500.00'),
(3, 'Premium', 'Cobertura completa con todos los beneficios.', '4000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL,
  `fecha_generacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_afiliados` int(11) DEFAULT NULL,
  `afiliados_activos` int(11) DEFAULT NULL,
  `afiliados_inactivos` int(11) DEFAULT NULL,
  `morosos` int(11) DEFAULT NULL,
  `plan_mas_popular` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `nombre_servicio` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `descuento` int(3) NOT NULL DEFAULT 0,
  `cantidad_gratuita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `id_plan`, `nombre_servicio`, `descripcion`, `descuento`, `cantidad_gratuita`) VALUES
(1, 1, 'Chequeo', 'Chequeo médico anual', 0, 1),
(2, 1, 'Psicología', 'Servicio de Psicología', 20, NULL),
(3, 1, 'Traumatólogo', 'Servicio de Traumatología', 20, NULL),
(4, 2, 'Chequeo', 'Chequeo médico semestral', 0, 2),
(5, 2, 'Psicología', 'Servicio de Psicología', 50, NULL),
(6, 2, 'Traumatólogo', 'Servicio de Traumatología', 50, NULL),
(7, 3, 'Chequeo', 'Chequeo médico ilimitado', 0, NULL),
(8, 3, 'Psicología', 'Servicio de Psicología', 70, NULL),
(9, 3, 'Traumatólogo', 'Servicio de Traumatología', 70, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` enum('afiliado','proveedor','administrador') NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `clave`, `rol`, `fecha_creacion`) VALUES
(16, 'joel1', '$2y$10$STetbIbpjiDnYJPTWibqDueuj5NX0CMuVGy95BJm/yPpc/ezDI50e', 'afiliado', '2024-11-12 21:07:47'),
(17, 'admin2', '$2y$10$P6ngiYQSgms/E0E627PmS.CSdZM29Yt1TqFN0hrJh9ASQF.aij8LC', 'administrador', '2024-11-12 21:14:14'),
(18, 'admin', '$2y$10$34B.tqYV0wnJtNOypPhdnuK.JaFwjBCrIE0ZfXpO0IfsdRIYttmhi', 'administrador', '2024-11-12 21:29:25'),
(19, 'esther1', '$2y$10$qFlytWb5HHtS1Ws3qxmXbObjtPKjUvSk3J/NvyQoMThUQVnepEjUW', 'afiliado', '2024-11-12 21:32:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `afiliados`
--
ALTER TABLE `afiliados`
  ADD PRIMARY KEY (`id_afiliado`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `plan_cobertura_id` (`plan_cobertura_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_afiliado` (`id_afiliado`);

--
-- Indices de la tabla `historial_servicios`
--
ALTER TABLE `historial_servicios`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_afiliado` (`id_afiliado`),
  ADD KEY `id_servicio` (`id_servicio`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id_plan`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `plan_mas_popular` (`plan_mas_popular`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `id_plan` (`id_plan`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `afiliados`
--
ALTER TABLE `afiliados`
  MODIFY `id_afiliado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historial_servicios`
--
ALTER TABLE `historial_servicios`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `afiliados`
--
ALTER TABLE `afiliados`
  ADD CONSTRAINT `afiliados_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `afiliados_ibfk_2` FOREIGN KEY (`plan_cobertura_id`) REFERENCES `planes` (`id_plan`) ON DELETE SET NULL;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`id_afiliado`) REFERENCES `afiliados` (`id_afiliado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_servicios`
--
ALTER TABLE `historial_servicios`
  ADD CONSTRAINT `historial_servicios_ibfk_1` FOREIGN KEY (`id_afiliado`) REFERENCES `afiliados` (`id_afiliado`) ON DELETE CASCADE,
  ADD CONSTRAINT `historial_servicios_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`plan_mas_popular`) REFERENCES `planes` (`id_plan`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`id_plan`) REFERENCES `planes` (`id_plan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
