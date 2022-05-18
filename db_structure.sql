-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 18-05-2022 a las 07:40:29
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
  `uploadedBy` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

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
('location', 'Calle Pruea, 123, 29000 Málaga'),
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
  `uploadedBy` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `id` int(1) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

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
  `account_type` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `account_enabled` char(10) CHARACTER SET utf8mb4 DEFAULT 'YES',
  `passwd_reset` char(10) CHARACTER SET utf8mb4 DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwd`, `firstname`, `surname`, `account_type`, `account_enabled`, `passwd_reset`) VALUES
(0, 'admin', 'test@miempresa.es', '$2y$10$Y8hcDbCBELzbvAVA5u3xK.7P5WA0V3GtDsL6mAD1Qi6Svdpl2fwym', NULL, NULL, 'superuser', 'YES', 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` int(4) NOT NULL,
  `categories` tinyint(1) DEFAULT 0,
  `gallery_new` tinyint(1) DEFAULT 0,
  `manage_gallery` tinyint(1) DEFAULT 0,
  `get_friendly_url` tinyint(1) DEFAULT 0,
  `change_category_status` tinyint(1) DEFAULT 0,
  `check_category_name` tinyint(1) DEFAULT 0,
  `create_category` tinyint(1) DEFAULT 0,
  `create_gallery_items` tinyint(1) DEFAULT 0,
  `delete_category` tinyint(1) DEFAULT 0,
  `delete_images` tinyint(1) DEFAULT 0,
  `edit_category` tinyint(1) DEFAULT 0,
  `get_categories` tinyint(1) DEFAULT 0,
  `retrieve_cetegory_image` tinyint(1) DEFAULT 0,
  `about_us` tinyint(1) DEFAULT 0,
  `advanced` tinyint(1) DEFAULT 0,
  `contact` tinyint(1) DEFAULT 0,
  `edit_service` tinyint(1) DEFAULT 0,
  `general` tinyint(1) DEFAULT 0,
  `new_service` tinyint(1) DEFAULT 0,
  `services` tinyint(1) DEFAULT 0,
  `create_service` tinyint(1) DEFAULT 0,
  `delete_service` tinyint(1) DEFAULT 0,
  `update_about_us` tinyint(1) DEFAULT 0,
  `update_contact_phone_email` tinyint(1) DEFAULT 0,
  `update_index_brief_description` tinyint(1) DEFAULT 0,
  `update_index_image` tinyint(1) DEFAULT 0,
  `update_index_image_description` tinyint(1) DEFAULT 0,
  `update_maintenance_mode` tinyint(1) DEFAULT 0,
  `update_map_link` tinyint(1) DEFAULT 0,
  `update_opening_hours` tinyint(1) DEFAULT 0,
  `update_service` tinyint(1) DEFAULT 0,
  `update_social_media` tinyint(1) DEFAULT 0,
  `create_user` tinyint(1) NOT NULL DEFAULT 0,
  `manage_users` tinyint(1) NOT NULL DEFAULT 0,
  `delete_user` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `categories`, `gallery_new`, `manage_gallery`, `get_friendly_url`, `change_category_status`, `check_category_name`, `create_category`, `create_gallery_items`, `delete_category`, `delete_images`, `edit_category`, `get_categories`, `retrieve_cetegory_image`, `about_us`, `advanced`, `contact`, `edit_service`, `general`, `new_service`, `services`, `create_service`, `delete_service`, `update_about_us`, `update_contact_phone_email`, `update_index_brief_description`, `update_index_image`, `update_index_image_description`, `update_maintenance_mode`, `update_map_link`, `update_opening_hours`, `update_service`, `update_social_media`, `create_user`, `manage_users`, `delete_user`) VALUES
(0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
