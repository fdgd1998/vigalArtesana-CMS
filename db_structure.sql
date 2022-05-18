-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 18-05-2022 a las 23:01:54
-- Versión del servidor: 10.5.12-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vigal`
--
CREATE DATABASE IF NOT EXISTS `vigal` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `vigal`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(3) NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `cat_enabled` char(3) CHARACTER SET utf8mb4 DEFAULT 'YES',
  `image` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `uploadedBy` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Estructura de tabla para la tabla `company_info`
--

CREATE TABLE `company_info` (
  `key_info` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `value_info` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `company_info`
--

INSERT INTO `company_info` (`key_info`, `value_info`) VALUES
('phone', '+34 600 00 00 00'),
('location', 'Calle Prueba, 123, 29000 Málaga'),
('name', 'Mi Empresa'),
('email', 'contacto@miempresa.es'),
('social_media', '{\"instagram\":\"miempresa\",\"facebook\":\"miempresa\",\"whatsapp\":\"+34600000000\"}'),
('index-image', 'index.jpg'),
('index-image-description', 'Descripción de mi empresa.'),
('google-map-link', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1654425.3095923811!2d-4.408954431630243!3d35.91517012339416!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7134e9fd7091b5%3A0xd1256645b08b9d84!2sMar%20de%20Albor%C3%A1n!5e0!3m2!1ses!2ses!4v1652859736537!5m2!1ses!2ses'),
('opening-hours', '{\"Lunes\":\"7:00 - 15:00\",\"Martes\":\"7:00 - 15:00\",\"Miércoles\":\"7:00 - 15:00\",\"Jueves\":\"7:00 - 15:00\",\"Viernes\":\"7:00 - 13:30\",\"Sábado\":\"cerrado\",\"Domingo\":\"cerrado\"}'),
('about-us', 'Esta es la sección sobre nosotros de la página web.'),
('index-brief-description', 'Esta es una breve descripción de la página web.'),
('maintenance', 'false');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery`
--

CREATE TABLE `gallery` (
  `id` int(5) NOT NULL,
  `filename` varchar(50) CHARACTER SET latin1 NOT NULL,
  `category` int(3) NOT NULL,
  `uploadedBy` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `id` int(1) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `passwd` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `account_type` int(4) DEFAULT NULL,
  `account_enabled` tinyint(1) DEFAULT 1,
  `passwd_reset` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwd`, `firstname`, `surname`, `account_type`, `account_enabled`, `passwd_reset`) VALUES
(0, 'admin', 'test@miempresa.es', '$2y$10$Y8hcDbCBELzbvAVA5u3xK.7P5WA0V3GtDsL6mAD1Qi6Svdpl2fwym', NULL, NULL, 'superuser', 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(4) NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` bit(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_roles`
--

INSERT INTO `user_roles` (`id`, `role`, `permissions`) VALUES
(1, 'superuser', b'0000000011111111'),
(2, 'administrator', b'0000000011111110'),
(3, 'gallery_collaborator', b'0000000011111000');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploadedBy` (`uploadedBy`);

--
-- Indices de la tabla `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`),
  ADD KEY `gallery_ibfk_1` (`uploadedBy`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_type` (`account_type`);

--
-- Indices de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`uploadedBy`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`uploadedBy`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`account_type`) REFERENCES `user_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
