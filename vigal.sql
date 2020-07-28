-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-07-2020 a las 21:50:43
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.7

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
  `name` varchar(255) NOT NULL,
  `cat_enabled` char(3) DEFAULT 'YES',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `cat_enabled`, `image`) VALUES
(19, 'Mobiliario', 'YES', '1595955122.jpeg'),
(20, 'Decoración', 'YES', '1595955134.jpeg'),
(21, 'Puertas viejas', 'YES', '1595964058.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_info`
--

CREATE TABLE `company_info` (
  `key_info` varchar(255) NOT NULL,
  `value_info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `company_info`
--

INSERT INTO `company_info` (`key_info`, `value_info`) VALUES
('phone', '+34 602 03 68 30'),
('address', 'Ctra. N-340, KM 268, Casa Las Yucas. 29749 Vélez-Málaga.'),
('email', 'test@example.com'),
('name', 'ViGal Artesanos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_confirmation`
--

CREATE TABLE `email_confirmation` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset`
--

CREATE TABLE `password_reset` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` int(3) NOT NULL,
  `author` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `images` text DEFAULT NULL,
  `published` char(3) DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `passwd` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `secondname` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `account_type` varchar(50) DEFAULT NULL,
  `account_enabled` char(10) DEFAULT 'YES',
  `passwd_reset` char(10) DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwd`, `firstname`, `secondname`, `surname`, `account_type`, `account_enabled`, `passwd_reset`) VALUES
(3, 'admin', 'afgalvezdiaz@gmail.com', 'SFB1eTNNZEczdUVlRVJJMUk4OWM5UT09Ojqj2VaTkgd1J/zLnHRjd7TR', 'Qlk5ekRHcFdqSzdUaC9tV09VRzQ5dz09Ojr02QIaX4gCuCz07wFGW4ki', NULL, 'bXM2bnh5alpDTGF0R0cxYmVzMzFhQT09OjptvXsWOBMacTp9B3CzmyXP', 'superuser', 'YES', 'NO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `email_confirmation`
--
ALTER TABLE `email_confirmation`
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `password_reset`
--
ALTER TABLE `password_reset`
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
