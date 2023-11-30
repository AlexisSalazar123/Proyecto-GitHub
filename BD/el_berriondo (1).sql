-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2023 a las 20:19:08
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `el_berriondo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `fecha_ingreso` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `correo`, `telefono`, `direccion`, `fecha_ingreso`) VALUES
(1, 'Roberto de jesus', 'alex@gmail.com', 312734559, 'Barrio la teneria', '2023-11-30 17:07:49'),
(2, 'Ángel David Salazar', 'angelDavid23@l.com', 3245786756, 'Barrio Nogal', '2023-11-30 17:12:01'),
(3, 'Santiago Gómez', 'santiagoBM@gmail.com', 3128743767, 'Barrio Mira flores', '2023-11-30 17:19:15'),
(4, 'Sebastian Cardona', 'CardonaSebas@gmail.com', 3208643755, 'Vereda Primavera', '2023-11-30 17:18:58'),
(8, 'Sara Valentina Salzar', 'ValenGY@gmail.com', 3145678940, 'Barrio Simón Bolívar', '2023-11-30 17:13:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

CREATE TABLE `forma_pago` (
  `id_forma_pago` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `forma_pago`
--

INSERT INTO `forma_pago` (`id_forma_pago`, `nombre`) VALUES
(1, 'Efectivo'),
(2, 'Tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `nombre_ingrediente` varchar(250) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `unidad_medida` int(11) NOT NULL,
  `cantidad_minima` decimal(10,2) NOT NULL,
  `nombre_proveedor` int(11) NOT NULL,
  `imagen` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `nombre_ingrediente`, `cantidad`, `unidad_medida`, `cantidad_minima`, `nombre_proveedor`, `imagen`) VALUES
(1, 'Harina', 429.56, 1, 17.00, 1, 'harinaM.png'),
(2, 'queso mozarella', 857.75, 1, 10.00, 3, 'queso2.png'),
(3, 'queso fresco', 374.60, 1, 10.00, 3, 'queso.png'),
(4, 'azucar', 484.03, 2, 10.00, 4, 'azucar.png'),
(5, 'sal', 1584.32, 2, 222.00, 5, 'sal.png'),
(6, 'mantequilla', 204.14, 2, 10.00, 6, 'mantequilla.png'),
(7, 'agua', 332.82, 3, 19.00, 7, 'agua.png'),
(8, 'leche', 191.20, 3, 10.00, 6, 'leche.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

CREATE TABLE `produccion` (
  `id_produccion` int(11) NOT NULL,
  `codigo_produccion` int(11) NOT NULL,
  `nombre_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `produccion`
--

INSERT INTO `produccion` (`id_produccion`, `codigo_produccion`, `nombre_producto`, `cantidad`, `fecha`) VALUES
(24, 6, 1, 358, '2023-05-24 13:54:55'),
(25, 7, 2, 703, '2023-06-24 13:55:19'),
(27, 56, 1, 99, '2023-07-24 13:56:58'),
(28, 12, 1, 34, '2023-08-24 13:57:09'),
(29, 567, 1, 8, '2023-09-25 15:11:32'),
(30, 123, 1, 258, '2023-11-30 16:53:28'),
(31, 823, 1, 4, '2023-11-25 17:25:30'),
(32, 823, 1, 4, '2023-10-25 17:25:30'),
(33, 9864, 1, 2, '2023-10-25 17:32:13'),
(34, 8534, 2, 4, '2023-10-25 17:33:32'),
(35, 7644, 1, 238, '2023-11-30 16:53:20'),
(36, 7644, 2, 8, '2023-10-25 17:34:15'),
(38, 654, 1, 9, '2023-10-25 17:42:25'),
(52, 78, 2, 20, '2023-09-07 04:58:17'),
(53, 78, 1, 20, '2023-09-07 04:58:40'),
(54, 78, 1, 250, '2023-11-30 16:55:01'),
(55, 78, 1, 20, '2023-09-07 05:09:55'),
(56, 78, 1, 20, '2023-11-07 05:10:26'),
(61, 45, 2, 5, '2023-11-13 00:48:17'),
(63, 9191, 1, 34, '2023-09-18 05:04:01'),
(64, 345, 1, 45, '2023-05-20 04:48:09'),
(65, 789, 1, 434, '2023-11-30 16:51:10'),
(66, 41, 1, 8, '2023-10-20 05:09:29'),
(68, 451, 3, 413, '2023-10-30 16:52:26'),
(69, 780, 3, 358, '2023-01-23 20:48:01'),
(70, 65, 32, 987, '2023-04-23 20:48:34'),
(71, 2398, 2, 5, '2023-10-28 02:14:19'),
(72, 890, 2, 40, '2023-11-30 16:57:18'),
(73, 75, 3, 3, '2023-07-28 02:17:14'),
(74, 61, 34, 6, '2023-07-28 02:18:32'),
(75, 902, 32, 690, '2023-08-28 16:28:37'),
(76, 671, 34, 786, '2023-10-28 16:35:04'),
(77, 913, 2, 258, '2023-01-03 16:58:43'),
(78, 904, 34, 278, '2023-02-08 16:59:46'),
(79, 112, 2, 700, '2023-05-09 17:01:07'),
(80, 663, 34, 1200, '2023-07-30 17:02:53'),
(81, 669, 3, 1400, '2023-11-30 17:05:31'),
(82, 667, 32, 1400, '2023-09-22 17:03:43'),
(83, 199, 35, 2, '2023-11-30 17:31:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_productos` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `precio` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_productos`, `nombre`, `foto`, `precio`, `fecha`) VALUES
(1, 'Arepa la garra', 'Garra.jpeg', 10000, '2023-11-30 17:16:12'),
(2, 'Arepa el morao', 'morado.jpeg', 11000, '2023-11-30 17:16:23'),
(3, 'Arepa el Rolo', 'rolo2.jpg', 10500, '2023-11-30 17:16:37'),
(32, 'Arepa Caramela', 'morada.jpg', 9000, '2023-11-30 17:16:56'),
(34, 'Arepa la Yazuri', 'La yuri.png', 12000, '2023-11-30 17:17:10'),
(35, 'Arepa la Amelia', 'Amelia.jpeg', 12000, '2023-11-30 17:23:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `foto` varchar(250) NOT NULL,
  `razon_social` varchar(500) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `fecha_ingreso` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre`, `foto`, `razon_social`, `direccion`, `telefono`, `correo`, `fecha_ingreso`) VALUES
(1, 'Harina P.A.N', 'harinera.jpeg', 'Company P.A.N', 'Facatativá, Cundinamarca', 312734559, 'HarineraPAN@gmail.com', '2023-11-30 16:22:43'),
(3, 'Loma Bonita', 'queseria.jpeg', 'Loma Bonita SA', 'Rionegro, Antioquia', 2147483647, 'LBqueseria@gmail.com', '2023-11-30 16:15:21'),
(4, 'INCAUCA', 'INCAUCA.jpg', 'INCAUCA SA', 'Bolivar, Cauca', 2147483647, 'AzucarINCAUCA@gmail.com', '2023-11-30 16:22:19'),
(5, 'REFISAL', 'refisal.jpeg', 'Group REFISAL', 'Zipaquirá, Cundinamarca', 2147483647, 'GroupREFISAL@gmail.com', '2023-11-30 16:25:58'),
(6, 'Auralac', 'Auralac.jpg', 'Lacteos Auralac', 'Laja, Rionegro', 2147483647, 'LacteosAuralac@gmail.com', '2023-11-30 16:29:08'),
(7, 'Cristal', 'cristal.jpeg', 'Postobon SA', 'Rionegro, Antioquia', 2147483647, 'AguaCristal@gmail.com', '2023-11-30 16:32:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id_roles` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_roles`
--

INSERT INTO `tbl_roles` (`id_roles`, `nombre`) VALUES
(1, 'Admin'),
(2, 'hola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_unidad_medida`
--

CREATE TABLE `tbl_unidad_medida` (
  `id_unidad_medida` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_unidad_medida`
--

INSERT INTO `tbl_unidad_medida` (`id_unidad_medida`, `nombre`) VALUES
(0, 'jjjjjjjj'),
(1, 'Kilos'),
(2, 'Libras'),
(3, 'litros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `usuario` varchar(250) NOT NULL,
  `rol` int(11) NOT NULL,
  `contraseña` varchar(250) NOT NULL,
  `foto` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `usuario`, `rol`, `contraseña`, `foto`, `email`) VALUES
(1, 'Berriondo De Jesús', 'El Berriondo', 1, '784577', 'Berriondo.jpeg', 'DonBerriondo@gmail.com'),
(3, 'Darwin Mateo Gil Valencia', 'Darwin', 1, '671234', 'Captura de pantalla 2023-09-22 115246.png', 'darwingil936@gmail.com'),
(4, 'Jaime Alejandro Zuluaga Gómez', 'Alejo', 1, '458756', 'Captura de pantalla 2023-09-22 115310.png', 'alejandrozuluaga@gmail.com'),
(14, 'Sebastian Alexis Jiménez Duque', 'Sebas', 1, '6781259', 'sebas.jpg', 'sebastianjimenez584@gmail.com'),
(15, 'Camila Giraldo Bonilla', 'Camila', 1, '783451', 'La yuri.png', 'camilagiraldobonilla@gmail.com'),
(16, 'Nelson Alexis Salazar Zuluaga', 'Alexis', 1, '981457', 'yo.jpg', 'alexissalazar123g@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_ventas` int(11) NOT NULL,
  `codigo_venta` int(11) NOT NULL,
  `nombre_cliente` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `nombre_producto` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `forma_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_ventas`, `codigo_venta`, `nombre_cliente`, `cantidad`, `nombre_producto`, `total`, `fecha`, `forma_pago`) VALUES
(11, 890, 1, 358, 32, 3222000, '2023-11-30 17:21:31', 1),
(12, 577, 2, 239, 1, 2390000, '2023-11-30 17:22:28', 2),
(13, 678, 3, 425, 35, 5100000, '2023-11-30 17:23:00', 1),
(14, 334, 4, 398, 34, 4776000, '2023-11-30 17:24:12', 2),
(15, 721, 8, 245, 2, 2695000, '2023-11-30 17:24:40', 1),
(16, 649, 2, 234, 3, 2457000, '2023-11-30 17:25:59', 2),
(17, 90, 4, 92, 3, 966000, '2023-11-30 17:27:16', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  ADD PRIMARY KEY (`id_forma_pago`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `unidad_medida` (`unidad_medida`),
  ADD KEY `proveedor` (`nombre_proveedor`);

--
-- Indices de la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD PRIMARY KEY (`id_produccion`),
  ADD KEY `nombre_producto` (`nombre_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_productos`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id_roles`);

--
-- Indices de la tabla `tbl_unidad_medida`
--
ALTER TABLE `tbl_unidad_medida`
  ADD PRIMARY KEY (`id_unidad_medida`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `rol` (`rol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_ventas`),
  ADD KEY `nombre_vendedor` (`nombre_producto`),
  ADD KEY `ventas_ibfk_1` (`nombre_cliente`),
  ADD KEY `forma_pago` (`forma_pago`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  MODIFY `id_forma_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `produccion`
--
ALTER TABLE `produccion`
  MODIFY `id_produccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_productos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id_roles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_ventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`unidad_medida`) REFERENCES `tbl_unidad_medida` (`id_unidad_medida`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`nombre_proveedor`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD CONSTRAINT `produccion_ibfk_1` FOREIGN KEY (`nombre_producto`) REFERENCES `productos` (`id_productos`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `tbl_roles` (`id_roles`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`nombre_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`nombre_producto`) REFERENCES `productos` (`id_productos`),
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`forma_pago`) REFERENCES `forma_pago` (`id_forma_pago`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
