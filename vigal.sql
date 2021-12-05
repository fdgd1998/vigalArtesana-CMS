-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 05-12-2021 a las 01:17:55
-- Versión del servidor: 10.5.12-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `image` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL
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
('location', 'Calle, 0, 00000 Población, Ciudad'),
('name', 'ViGal Artesana'),
('email', 'test@example.es'),
('social_media', '{\"instagram\":\"example\",\"facebook\":\"example\",\"whatsapp\":\"+34600000000\"}'),
('index-image', 'index.jpg'),
('index-image-description', 'Descripción de portada.'),
('google-map-link', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1130.5455780830325!2d-4.1215623848120835!3d36.73058733416122!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5e8cd95cc99abae6!2sVigal%20Artesana!5e0!3m2!1ses!2ses!4v1634843687218!5m2!1ses!2se'),
('opening-hours', '{\"Lunes\":\"9:00 - 13:30 | 16:30 - 18:30\",\"Martes\":\"9:00 - 16:30\",\"Miércoles\":\"9:00 - 13:30 | 16:30 - 18:30\",\"Jueves\":\"9:00 - 16:30\",\"Viernes\":\"9:00 - 13:30 | 16:30 - 18:30\",\"Sábado\":\"con cita previa\",\"Domingo\":\"cerrado\"}'),
('about-us', '<p><b>Esta</b> es la sección sobre nosotros</p>'),
('index-brief-description', 'Una breve descripción en la página principal'),
('maintenance', 'false');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery`
--

CREATE TABLE `gallery` (
  `id` int(5) NOT NULL,
  `filename` varchar(50) CHARACTER SET latin1 NOT NULL,
  `category` int(3) NOT NULL
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
(1, 'admin', 'UnRxS0RBSWxJSTcyVnJwa094YVhobDVTdi9RRFlJMmRRckxZcWIzd3E0WT06OqMGfsQTERx8ilZlJcrlTSo=', 'OEEyY3RJZEJpUkxMOVh5QjRWWVFDQT09Ojrjdut8/EOQSEAdY1BgRU7a', '', '', 'superuser', 'YES', 'NO');

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
