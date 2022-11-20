-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2022 a las 03:24:40
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

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
  `uploadedBy` int(4) NOT NULL,
  `modifiedBy` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `categories`
--
DELIMITER $$
CREATE TRIGGER `categories_ad` AFTER DELETE ON `categories` FOR EACH ROW insert into logs (text, type) values (concat("BORRAR CATEGORÍA: ",old.name, ", por el usuario con ID ", old.modifiedBy),"category")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `categories_ai` AFTER INSERT ON `categories` FOR EACH ROW insert into logs (text, type) values (concat("NUEVA CATEGORÍA: ",new.name, ", por el usuario con ID ",new.uploadedBy),"category")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `categories_au` AFTER UPDATE ON `categories` FOR EACH ROW BEGIN
    declare str VARCHAR(255) default 'EDITAR CATEGORÍA: ';
    if old.friendly_url != new.friendly_url then
      set str = concat(str," (friendly_url)",concat(old.friendly_url, ' -> ', new.friendly_url));
    end if;
    if old.name != new.name then
      set str = concat(str,"(name)",concat(old.name, ' -> ', new.name));
    end if;
    if old.description != new.description then
      set str = concat(str," (description)",concat(old.description, ' -> ', new.description));
    end if;
    if old.image != new.image then
      set str = concat(str," (image)",concat(old.image, ' -> ', new.image));
    end if;
    set str = concat(str, ", por el usuario con ID ", new.modifiedBy);
    insert into logs (text, type) values (str,"category");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_info`
--

CREATE TABLE `company_info` (
  `key_info` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_info` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifiedBy` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `company_info`
--

INSERT INTO `company_info` (`key_info`, `value_info`, `modifiedBy`) VALUES
('phone', '+34 600 00 00 00', 0),
('location', 'Calle Prueba, 123, 29000 Málaga', 0),
('name', 'Mi Empresa', 0),
('email', 'contacto@miempresa.es', 0),
('social_media', '{\"instagram\":\"miempresaa\",\"facebook\":\"miempresaa\",\"whatsapp\":\"+34600000000\"}', 0),
('index-image', '16367490931.jpg', 0),
('index-slogan', 'Breve descripción de mi empresa.', 0),
('google-map-link', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1654425.3095923811!2d-4.408954431630243!3d35.91517012339416!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7134e9fd7091b5%3A0xd1256645b08b9d84!2sMar%20de%20Albor%C3%A1n!5e0!3m2!1ses!2ses!4v1652859736537!5m2!1ses!2ses', 0),
('opening-hours', '{\"Lunes\":\"7:00 - 15:00\",\"Martes\":\"7:00 - 15:00\",\"Miércoles\":\"7:00 - 15:00\",\"Jueves\":\"7:00 - 15:00\",\"Viernes\":\"7:00 - 13:30\",\"Sábado\":\"cerrado\",\"Domingo\":\"cerrado\"}', 0),
('about-us', '<p>Esta es la sección <font color=\"#000000\" style=\"--darkreader-inline-color:#e8e6e3; --darkreader-inline-bgcolor:#999900;\" data-darkreader-inline-color=\"\" data-darkreader-inline-bgcolor=\"\"><b style=\"\">sobre nosotros </b></font>de la página web...</p>', 0),
('index-brief-description', 'Esta es una <b><font color=\"#000000\" style=\"\">descripción extensa</font></b> de<i> </i>la empresa.', 0),
('maintenance', 'false', 0),
('gallery-desc', '<p>Esta es la <b>descripción general</b> de la galería...</p>', 0),
('seo_modified', 'true', 0),
('index-image-desc', 'sdfsffs', 0),
('software-version', '2.0.1', 0);

--
-- Disparadores `company_info`
--
DELIMITER $$
CREATE TRIGGER `company_info_au` AFTER UPDATE ON `company_info` FOR EACH ROW BEGIN
    declare str VARCHAR(255) default 'EDITAR AJUSTES: ';
    if old.value_info != new.value_info then
      set str = concat(str, old.key_info , ": ",concat(old.value_info, ' -> ', new.value_info));
    end if;
    set str = concat(str, ", por el usuario con ID ", new.modifiedBy);
    insert into logs (text, type) values (str,"site_settings");
END
$$
DELIMITER ;

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
  `uploadedBy` int(4) NOT NULL,
  `deletedBy` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `gallery`
--
DELIMITER $$
CREATE TRIGGER `gallery_ad` AFTER DELETE ON `gallery` FOR EACH ROW insert into logs (text, type) values (concat("BORRAR IMAGEN: ",old.filename, ", por el usuario con ID ", old.deletedBy),"gallery")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `gallery_ai` AFTER INSERT ON `gallery` FOR EACH ROW insert into logs (text, type) values (concat("NUEVA IMAGEN: ",new.filename, ", por el usuario con ID ", new.uploadedBy),"gallery")
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_register`
--

CREATE TABLE `ip_register` (
  `address` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `login_success` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `ip_register`
--
DELIMITER $$
CREATE TRIGGER `ip_register_ai` AFTER INSERT ON `ip_register` FOR EACH ROW insert into logs (text, type) values (concat("LOGIN: ",new.address, ", código ",new.login_success),"login")
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(6) NOT NULL,
  `text` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages`
--

CREATE TABLE `pages` (
  `id` int(4) NOT NULL,
  `page` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_id` int(4) DEFAULT NULL,
  `createdBy` int(4) NOT NULL,
  `modifiedBy` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pages`
--

INSERT INTO `pages` (`id`, `page`, `cat_id`, `createdBy`, `modifiedBy`) VALUES
(5, 'index', NULL, 0, NULL),
(6, 'galeria', NULL, 0, NULL),
(7, 'sobre-nosotros', NULL, 0, NULL),
(8, 'contacto', NULL, 0, NULL);

--
-- Disparadores `pages`
--
DELIMITER $$
CREATE TRIGGER `page_ai` AFTER INSERT ON `pages` FOR EACH ROW insert into logs (text, type) values (concat("NUEVA PÁGINA: ",new.id,":",new.page, ", por el usuario con ID ",new.createdBy),"pages")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pages_ad` AFTER DELETE ON `pages` FOR EACH ROW insert into logs (text, type) values (concat("BORRAR PÁGINA:  ",old.id, ":", old.page, ", por el usuario con ID ",old.modifiedBy),"pages")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pages_au` AFTER UPDATE ON `pages` FOR EACH ROW BEGIN
    declare str VARCHAR(255) default concat('EDITAR PÁGINA: ID', old.id);
    if old.page != new.page then
      set str = concat(str," (page)",concat(old.page, ' -> ', new.page));
    end if;
    set str = concat(str, ", por el usuario con ID ", new.modifiedBy);
    insert into logs (text, type) values (str,"pages");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages_metadata`
--

CREATE TABLE `pages_metadata` (
  `id` int(4) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_page` int(4) NOT NULL,
  `createdBy` int(4) NOT NULL,
  `modifiedBy` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pages_metadata`
--

INSERT INTO `pages_metadata` (`id`, `title`, `description`, `id_page`, `createdBy`, `modifiedBy`) VALUES
(5, 'Contacta con nosotros', 'Contacta con nosotros, aquí te dejamos nuetros datos de contacto....', 8, 0, 0),
(6, 'Galería', 'Esta es la página principal de nuestra galería, donde podrás ver una exposición de todos nuestros trabajo. ¡Te invitamos a que le eches un vistazo!', 6, 0, 0),
(7, 'Artesanía con madera antigua', 'Pura artesanía', 5, 0, 0),
(8, 'Sobre nosotros', 'Esta es la descripción de la página', 7, 0, 0);

--
-- Disparadores `pages_metadata`
--
DELIMITER $$
CREATE TRIGGER `pages_metadata_ad` AFTER DELETE ON `pages_metadata` FOR EACH ROW insert into logs (text, type) values (concat("BORRAR METADATOS PÁGINA:  ",old.id, ":", old.title, ", por el usuario con ID ",old.modifiedBy),"pages_metadata")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pages_metadata_ai` AFTER INSERT ON `pages_metadata` FOR EACH ROW insert into logs (text, type) values (concat("NUEVOS METADATOS PÁGINA: ",new.id,":",new.title, ", por el usuario con ID ",new.createdBy),"pages_metadata")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pages_metadata_au` AFTER UPDATE ON `pages_metadata` FOR EACH ROW BEGIN
    declare str VARCHAR(255) default concat('EDITAR METADATOS PÁGINA: ID', old.id);
    if old.title != new.title then
      set str = concat(str," (title)",concat(old.title, ' -> ', new.title));
    end if;
    if old.description != new.description then
      set str = concat(str," (description)",concat(old.description, ' -> ', new.description));
    end if;
    set str = concat(str, ", por el usuario con ID ", new.modifiedBy);
    insert into logs (text, type) values (str,"pages_metadata");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(4) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userid` int(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(4) NOT NULL
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
  `image_desc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdBy` int(4) NOT NULL,
  `modifiedBy` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `services`
--
DELIMITER $$
CREATE TRIGGER `services_ad` AFTER DELETE ON `services` FOR EACH ROW insert into logs (text, type) values (concat("BORRAR SERVICIO:  ",old.id, ":", old.title, ", por el usuario con ID ",old.modifiedBy),"service")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `services_ai` AFTER INSERT ON `services` FOR EACH ROW insert into logs (text, type) values (concat("NUEVO SERVICIO: ",new.id,":",new.title, ", por el usuario con ID ",new.createdBy),"service")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `services_au` AFTER UPDATE ON `services` FOR EACH ROW BEGIN
    declare str VARCHAR(255) default concat('EDITAR SERVICIO: ', old.id);
    if old.title != new.title then
      set str = concat(str," (title)",concat(old.title, ' -> ', new.title));
    end if;
    if old.description != new.description then
      set str = concat(str," (description)",concat(old.description, ' -> ', new.description));
    end if;
    if old.image != new.image then
      set str = concat(str," (image)",concat(old.image, ' -> ', new.image));
    end if;
    set str = concat(str, ", por el usuario con ID ", new.modifiedBy);
    insert into logs (text, type) values (str,"service");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `passwd` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `account_type` int(4) NOT NULL,
  `createdBy` int(4) DEFAULT NULL,
  `modifiedBy` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwd`, `account_type`, `createdBy`, `modifiedBy`) VALUES
(0, 'admin', 'test@mydomain.com', '$2y$10$75Z8hzflktTgwejtrykgwO6sgJQkHMRZx3A72vq5czDLk0WxM1A62', 1, 0, 0);

--
-- Disparadores `users`
--
DELIMITER $$
CREATE TRIGGER `users_ad` AFTER DELETE ON `users` FOR EACH ROW insert into logs (text, type) values (concat("BORRAR USUARIO: ID ",old.id, ", username: ", old.username, ", por el usuario ID ",old.modifiedBy),"user")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `users_ai` AFTER INSERT ON `users` FOR EACH ROW insert into logs (text, type) values (concat("NUEVO USUARIO: ID ",new.id, ", username: ", new.username, ", por el usuario ID ",new.createdBy),"user")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `users_au` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    declare str VARCHAR(255) default 'EDITAR USUARIO: ';
    if old.passwd != new.passwd then
      set str = concat(str," contraseña user ID ", old.id," modificada");
    end if;
    if old.email != new.email then
      set str = concat(str," email (user ID ", old.id,") modificado");
     end if;
    if old.account_type != new.account_type then
      set str = concat(str," tipo de cuenta (usuario ID ", old.id," ) modificada: ", old.account_type, "->", new.account_type);
    end if;
    if new.modifiedBy is null then 
    	set str = concat(str, " vía SSPR");
    else  
    	set str = concat(str, " por el usuario ID ", new.modifiedBy);
    end if;
    insert into logs (text, type) values (str,"user");
END
$$
DELIMITER ;

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
  ADD KEY `uploadedBy` (`uploadedBy`),
  ADD KEY `modifiedBy` (`modifiedBy`);

--
-- Indices de la tabla `company_info`
--
ALTER TABLE `company_info`
  ADD KEY `modifiedBy` (`modifiedBy`);

--
-- Indices de la tabla `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`),
  ADD KEY `gallery_ibfk_1` (`uploadedBy`),
  ADD KEY `deletedBy` (`deletedBy`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `createdBy` (`createdBy`),
  ADD KEY `modifiedBy` (`modifiedBy`);

--
-- Indices de la tabla `pages_metadata`
--
ALTER TABLE `pages_metadata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_page` (`id_page`),
  ADD KEY `createdBy` (`createdBy`),
  ADD KEY `modifiedBy` (`modifiedBy`);

--
-- Indices de la tabla `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `createdBy` (`createdBy`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `createdBy` (`createdBy`),
  ADD KEY `modifiedBy` (`modifiedBy`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_type` (`account_type`),
  ADD KEY `createdBy` (`createdBy`),
  ADD KEY `modifiedBy` (`modifiedBy`);

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
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `pages_metadata`
--
ALTER TABLE `pages_metadata`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`uploadedBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`modifiedBy`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `company_info`
--
ALTER TABLE `company_info`
  ADD CONSTRAINT `company_info_ibfk_1` FOREIGN KEY (`modifiedBy`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`uploadedBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `gallery_ibfk_2` FOREIGN KEY (`deletedBy`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pages_ibfk_2` FOREIGN KEY (`modifiedBy`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `pages_metadata`
--
ALTER TABLE `pages_metadata`
  ADD CONSTRAINT `pages_metadata_ibfk_1` FOREIGN KEY (`id_page`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pages_metadata_ibfk_2` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pages_metadata_ibfk_3` FOREIGN KEY (`modifiedBy`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `password_reset_ibfk_2` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `services_ibfk_2` FOREIGN KEY (`modifiedBy`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`account_type`) REFERENCES `user_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
