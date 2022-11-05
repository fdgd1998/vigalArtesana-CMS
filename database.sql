-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2022 a las 22:31:20
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.0.19

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(3) NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_enabled` char(3) COLLATE utf8mb4_unicode_ci DEFAULT 'YES',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploadedBy` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_info`
--

CREATE TABLE `company_info` (
  `key_info` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_info` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `company_info`
--

INSERT INTO `company_info` (`key_info`, `value_info`) VALUES
('phone', '+34 600 00 00 00'),
('location', 'Calle Prueba, 123, 29000 Málaga'),
('name', 'Mi Empresa'),
('email', 'contacto@miempresa.es'),
('social_media', '{\"instagram\":\"miempresaa\",\"facebook\":\"miempresaa\",\"whatsapp\":\"+34600000000\"}'),
('index-image', '16359609031.jpg'),
('index-slogan', 'Breve descripción de mi empresa.'),
('google-map-link', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1654425.3095923811!2d-4.408954431630243!3d35.91517012339416!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7134e9fd7091b5%3A0xd1256645b08b9d84!2sMar%20de%20Albor%C3%A1n!5e0!3m2!1ses!2ses!4v1652859736537!5m2!1ses!2ses'),
('opening-hours', '{\"Lunes\":\"7:00 - 15:00\",\"Martes\":\"7:00 - 15:00\",\"Miércoles\":\"7:00 - 15:00\",\"Jueves\":\"7:00 - 15:00\",\"Viernes\":\"7:00 - 13:30\",\"Sábado\":\"cerrado\",\"Domingo\":\"cerrado\"}'),
('about-us', '<p>Esta es la sección <font color=\"#000000\" style=\"--darkreader-inline-color:#e8e6e3; --darkreader-inline-bgcolor:#999900;\" data-darkreader-inline-color=\"\" data-darkreader-inline-bgcolor=\"\"><b style=\"\">sobre nosotros </b></font>de la página web.</p>'),
('index-brief-description', 'Esta es una <b><font color=\"#000000\" style=\"\">descripción extensa</font></b> de<i> </i>la empresa.'),
('maintenance', 'false'),
('gallery-desc', '<p>Esta es la <b>descripción general</b> de la galería...</p>'),
('seo_modified', 'true'),
('index-image-desc', 'fghfgh');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery`
--

CREATE TABLE `gallery` (
  `id` int(5) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` int(3) NOT NULL,
  `altText` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploadedBy` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_register`
--

CREATE TABLE `ip_register` (
  `address` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `login_success` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages`
--

CREATE TABLE `pages` (
  `id` int(4) NOT NULL,
  `page` varchar(255) CHARACTER SET utf8 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_id` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pages`
--

INSERT INTO `pages` (`id`, `page`, `cat_id`) VALUES
(5, 'index', NULL),
(6, 'galeria', NULL),
(7, 'sobre-nosotros', NULL),
(8, 'contacto', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages_metadata`
--

CREATE TABLE `pages_metadata` (
  `id` int(4) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_page` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pages_metadata`
--

INSERT INTO `pages_metadata` (`id`, `title`, `description`, `id_page`) VALUES
(5, 'Contacta con nosotros', 'Contacta con nosotros, aquí te dejamos nuetros datos de contacto.', 8),
(6, 'Galería', 'Esta es la página principal de nuestra galería, donde podrás ver una exposición de todos nuestros trabajo. ¡Te invitamos a que le eches un vistazo!', 6),
(7, 'Artesanía con madera antigua', 'Pura artesanía', 5),
(8, 'Sobre nosotros', 'Esta es la descripción de la página', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(4) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userid` int(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `id` int(1) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_desc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `account_type` int(4) DEFAULT NULL,
  `account_enabled` tinyint(1) DEFAULT 1,
  `passwd_reset` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwd`, `firstname`, `surname`, `account_type`, `account_enabled`, `passwd_reset`) VALUES
(0, 'admin', 'fran_gd_1998@outlook.es', '$2y$10$dWgU4P0hAkT3TljAx/TxY.x.GYwU2h5eas1MGeIPQIACcPlTzG3Hy', NULL, NULL, 1, 1, 0),
(26, 'fgalvez', 'asdas@asdasd.es', '$2y$10$AqAb4snaXdSXuAewgfd3auDtvywNPKq5etyHc7GfQHYk2lOxRcxXG', NULL, NULL, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(4) NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` bit(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_roles`
--

INSERT INTO `user_roles` (`id`, `role`, `permissions`) VALUES
(1, 'superuser', b'11111111'),
(2, 'administrator', b'01110111'),
(3, 'collaborator', b'01000001');

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
-- Indices de la tabla `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indices de la tabla `pages_metadata`
--
ALTER TABLE `pages_metadata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_page` (`id_page`);

--
-- Indices de la tabla `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `pages_metadata`
--
ALTER TABLE `pages_metadata`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
-- Filtros para la tabla `pages_metadata`
--
ALTER TABLE `pages_metadata`
  ADD CONSTRAINT `pages_metadata_ibfk_1` FOREIGN KEY (`id_page`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`account_type`) REFERENCES `user_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
