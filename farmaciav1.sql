-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-02-2025 a las 01:31:41
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `farmaciav1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad` date NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sexo_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int NOT NULL,
  `det_cantidad` int NOT NULL,
  `det_vencimiento` date NOT NULL,
  `id_det_lote` int NOT NULL,
  `id_det_prod` int NOT NULL,
  `lote_id_prov` int NOT NULL,
  `id_det_venta` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratorios`
--

CREATE TABLE `laboratorios` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Activo',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `laboratorios`
--

INSERT INTO `laboratorios` (`id`, `nombre`, `foto`, `estado`, `updated_at`, `created_at`) VALUES
(1, 'Laboratorio Ramos', NULL, 'Inactivo', '2024-11-02 16:41:18', '2024-11-02 22:29:02'),
(2, 'Laboratorio Solka', NULL, 'Inactivo', '2024-11-02 16:40:00', '2024-11-02 22:29:02'),
(3, 'Laboratorios Suizos', NULL, 'Inactivo', '2024-11-02 16:43:05', '2024-11-02 22:29:02'),
(4, 'Laboratorios Lannacher', NULL, 'Inactivo', '2024-11-02 16:43:12', '2024-11-02 22:29:02'),
(5, 'Laboratorio La Sante', NULL, 'Inactivo', '2024-11-02 16:56:25', '2024-11-02 22:29:02'),
(6, 'Laboratorios López', 'laboratorios/w1KvpFt1qgowHu80sLCAYH5BhkA56ezPdFZJTJZA.png', 'Activo', '2024-11-03 14:54:59', '2024-11-02 22:29:02'),
(7, 'Laboratorios Ramos S.A.', 'laboratorios/T6NWa7WyIOTWELWy2kI7w6OoHxspv7UfYOJnQJhR.webp', 'Activo', '2024-11-03 14:55:08', '2024-11-02 22:29:02'),
(8, 'Laboratorios Panter', 'laboratorios/br24Z2vLvXMi2QBxUlSlVHfeg0vUnpGhELr7fcfW.png', 'Activo', '2024-11-03 14:53:45', '2024-11-02 22:29:02'),
(9, 'Laboratorios Mejía', NULL, 'Inactivo', '2024-11-02 16:56:31', '2024-11-02 22:29:02'),
(10, 'Laboratorio Kielsa', NULL, 'Inactivo', '2024-11-02 16:40:36', '2024-11-02 22:29:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `id` int NOT NULL,
  `stock` int NOT NULL,
  `vencimiento` date NOT NULL,
  `id_prod` int NOT NULL,
  `id_prov` int NOT NULL,
  `estado` varchar(255) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_02_05_185816_create_clientes_table', 1),
(2, '2025_02_05_190252_create_sexos_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE `presentaciones` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Activo',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id`, `nombre`, `estado`, `updated_at`, `created_at`) VALUES
(1, 'Tabletas', 'Activo', '2024-11-03 16:22:19', '2024-11-03 16:22:19'),
(2, 'Ampollas', 'Activo', '2024-11-03 16:22:37', '2024-11-03 16:22:37'),
(3, 'Sobres', 'Activo', '2024-11-03 16:27:30', '2024-11-03 16:27:30'),
(4, 'Frasco', 'Inactivo', '2024-11-03 16:40:39', '2024-11-03 16:27:38'),
(5, 'Frasco', 'Activo', '2024-11-03 16:40:50', '2024-11-03 16:40:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `concentracion` varchar(255) DEFAULT NULL,
  `adicional` varchar(255) DEFAULT NULL,
  `precio` float NOT NULL,
  `id_lab` int NOT NULL,
  `id_tip_prod` int NOT NULL,
  `id_present` int NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Activo',
  `avatar` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `concentracion`, `adicional`, `precio`, `id_lab`, `id_tip_prod`, `id_present`, `estado`, `avatar`, `updated_at`, `created_at`) VALUES
(10, 'prueba', 'Et explicabo Deleni', 'Id ullam assumenda p', 14, 9, 2, 2, 'Activo', '1735765896.jpg', '2025-01-01 15:11:36', '2024-12-30 18:49:29'),
(11, 'Perspiciatis quod d', 'Et explicabo Deleni', 'Id ullam assumenda p', 14, 6, 2, 2, 'Activo', '1735766990.jpeg', '2025-01-01 15:29:50', '2024-12-30 18:49:42'),
(12, 'Acetominofen', '500mg', 'Fiebre', 30, 7, 2, 2, 'Activo', '1735782527.jpg', '2025-01-02 17:37:23', '2024-12-31 16:35:32'),
(13, 'Acetominofen', '500mg', 'Para la fiebre', 30, 3, 2, 1, 'Activo', '1735782547.jpeg', '2025-01-01 19:49:07', '2024-12-31 16:36:07'),
(14, 'Necessitatibus saepe', 'Aut qui sit archite', 'Id reprehenderit p', 45, 5, 1, 4, 'Activo', NULL, '2025-01-01 19:50:10', '2025-01-01 19:50:10'),
(15, 'Necessitatibus saepe', 'Aut qui sit archite', 'Id reprehenderit p', 45, 4, 1, 4, 'Activo', NULL, '2025-01-01 19:50:37', '2025-01-01 19:50:37'),
(16, 'Animi a voluptatem', 'Voluptatem dolor ips', 'Aute omnis est dolo', 81, 9, 2, 3, 'Inactivo', NULL, '2025-01-02 17:38:02', '2025-01-02 17:38:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` int NOT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) NOT NULL,
  `estado` varchar(100) NOT NULL DEFAULT 'Activo',
  `avatar` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `telefono`, `correo`, `direccion`, `estado`, `avatar`, `updated_at`, `created_at`) VALUES
(1, 'elvis pavon zeas', 285415, 'lejune@mailinator.com', 'Soluta qui velit ex', 'Activo', 'storage/proveedor/wW1izAB0ixEQGrE6rr3kxARvmQau2ftypR7hi4OM.jpg', '2025-02-05 18:27:10', '2025-01-03 18:55:37'),
(2, 'prueba', 32, 'zeaselvis7@gmail.com', 'Carazo', 'Activo', 'storage/proveedor/9BfE3F6qbjLOs5wH3wBU1rgpva3JzxHz098ztc6O.png', '2025-02-05 18:38:00', '2025-01-03 18:55:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexos`
--

CREATE TABLE `sexos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sexos`
--

INSERT INTO `sexos` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Masculino', NULL, NULL),
(2, 'Femenino', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int NOT NULL,
  `nombre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `nombre`) VALUES
(1, 'Root'),
(2, 'Administrador'),
(3, 'Supervisor'),
(4, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_productos`
--

CREATE TABLE `tipos_productos` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Activo',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tipos_productos`
--

INSERT INTO `tipos_productos` (`id`, `nombre`, `estado`, `updated_at`, `created_at`) VALUES
(1, 'Comercial', 'Activo', '2024-11-03 15:27:09', '2024-11-03 15:27:09'),
(2, 'Generico', 'Activo', '2024-11-03 15:58:15', '2024-11-03 15:32:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tipo` int NOT NULL,
  `estado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `avatar`, `email`, `email_verified_at`, `password`, `id_tipo`, `estado`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Grethel del carmen Treminio Gonzalez', '', 'docente@gmail.com', NULL, '$2y$10$oBa/EpxJw.0Zfpu74by2Iu/NHkR/YwQNaf3EnLxlvFhBXYZRnrbsm', 2, 'Inactivo', NULL, '2024-06-28 13:27:26', '2024-10-14 23:48:29'),
(3, 'Manuel Maglevi Borge Rubios', '', 'ucmejb19@gmail.com', NULL, '$2y$10$bOCEiGzffReQAWE6lb4a2Oa6CnI6Z7Hu9C.WqeQbJtt1Y.swibQAm', 3, 'Inactivo', NULL, '2024-06-28 13:27:57', '2024-10-14 23:48:26'),
(7, 'Elvis José Pavón Zeas', '1728947793.jpg', 'zeaselvis7@gmail.com', NULL, '$2y$10$/8kxVLn93oKE5yx8vHmG/.pxZFlMP.JEHvKzgXTtdg6o0Cg6cCP/i', 1, 'Activo', NULL, '2024-10-08 00:50:41', '2024-10-14 23:16:33'),
(8, 'prueba', '1728949791.png', 'prueba@gmail.com', NULL, '$2y$10$dVLZfCKrCVOyE8io6t6V0OfQjLvvQ5cxqJqGtSHTrU048ynI4I4Vu', 2, 'Activo', NULL, '2024-10-14 23:44:28', '2024-10-14 23:49:51'),
(9, 'Ut in aut vitae haru', NULL, 'zatogaqav@mailinator.com', NULL, '$2y$10$5MyMI9o66rckVd336SLHhe64BKa05hYe68tGSFEJBAETJSVoZf4Ku', 4, 'Activo', NULL, '2024-11-02 20:41:39', '2024-11-02 20:41:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `cliente` varchar(45) DEFAULT NULL,
  `dni` int DEFAULT NULL,
  `total` float DEFAULT NULL,
  `vendedor` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_producto`
--

CREATE TABLE `venta_producto` (
  `id` int NOT NULL,
  `cantidad` int NOT NULL,
  `subtotal` float NOT NULL,
  `id_producto` int NOT NULL,
  `id_venta` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_dni_unique` (`dni`),
  ADD KEY `sexo_id` (`sexo_id`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_det_venta` (`id_det_venta`);

--
-- Indices de la tabla `laboratorios`
--
ALTER TABLE `laboratorios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prod` (`id_prod`,`id_prov`),
  ADD KEY `id_prov` (`id_prov`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lab` (`id_lab`,`id_tip_prod`,`id_present`),
  ADD KEY `id_present` (`id_present`),
  ADD KEY `id_tip_prod` (`id_tip_prod`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sexos`
--
ALTER TABLE `sexos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_productos`
--
ALTER TABLE `tipos_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendedor` (`vendedor`);

--
-- Indices de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`,`id_venta`),
  ADD KEY `id_venta` (`id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `laboratorios`
--
ALTER TABLE `laboratorios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sexos`
--
ALTER TABLE `sexos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipos_productos`
--
ALTER TABLE `tipos_productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`sexo_id`) REFERENCES `sexos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_det_venta`) REFERENCES `venta` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT `lote_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `productos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lote_ibfk_2` FOREIGN KEY (`id_prov`) REFERENCES `proveedores` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_present`) REFERENCES `presentaciones` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_lab`) REFERENCES `laboratorios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`id_tip_prod`) REFERENCES `tipos_productos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`vendedor`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD CONSTRAINT `venta_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `venta_producto_ibfk_2` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
