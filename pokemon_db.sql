-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2024 a las 06:30:41
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
-- Base de datos: `pokemon_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moves`
--

CREATE TABLE `moves` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `damage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pokemons`
--

CREATE TABLE `pokemons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `moves` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pokemons`
--

INSERT INTO `pokemons` (`id`, `name`, `image`, `type`, `moves`) VALUES
(1, 'Raro', 'https://example.com/raro.png', '', ''),
(3, 'Bulbasaur', 'https://example.com/bulbasaur.png', '', ''),
(4, 'Bulbasaur', 'https://example.com/bulbasaur.png', '', ''),
(5, 'Bulbasaur', 'https://example.com/bulbasaur.png', '', ''),
(6, 'Bulbasaur', 'https://example.com/bulbasaur.png', '', ''),
(7, 'Bulbasaur', 'https://example.com/bulbasaur.png', '', ''),
(8, 'Bulbasaur', 'https://example.com/bulbasaur.png', '', ''),
(10, 'Pikachu', 'pikachu.png', 'electric', 'Thunder Shock, Quick Attack, Iron Tail, Electro Ball'),
(11, 'Pikachu', 'pikachu.png', 'electric', 'Thunder Shock, Quick Attack, Iron Tail, Electro Ball'),
(12, 'Pikachu', 'pikachu.png', 'electric', 'Thunder Shock, Quick Attack, Iron Tail, Electro Ball'),
(13, 'Charmander', 'Charmander.png', 'Fire', 'Thunder Shock, Quick Attack, Iron Tail, Electro Ball');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pokemon_moves`
--

CREATE TABLE `pokemon_moves` (
  `id` int(11) NOT NULL,
  `pokemon_id` int(11) DEFAULT NULL,
  `move_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pokemon_types`
--

CREATE TABLE `pokemon_types` (
  `id` int(11) NOT NULL,
  `pokemon_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trainers`
--

CREATE TABLE `trainers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `region` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trainers`
--

INSERT INTO `trainers` (`id`, `name`, `age`, `region`) VALUES
(1, 'Oliver Attomic', 20, 'Colombia'),
(3, 'Camilo ORtega', 20, 'Colombia'),
(4, 'Camilo ORtega', 20, 'Colombia'),
(5, 'Camilo Pallares', 20, 'Colombia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trainer_pokemons`
--

CREATE TABLE `trainer_pokemons` (
  `id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `pokemon_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trainer_pokemons`
--

INSERT INTO `trainer_pokemons` (`id`, `trainer_id`, `pokemon_id`) VALUES
(4, 3, 12),
(5, 3, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `moves`
--
ALTER TABLE `moves`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pokemons`
--
ALTER TABLE `pokemons`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pokemon_moves`
--
ALTER TABLE `pokemon_moves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pokemon_id` (`pokemon_id`),
  ADD KEY `move_id` (`move_id`);

--
-- Indices de la tabla `pokemon_types`
--
ALTER TABLE `pokemon_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pokemon_id` (`pokemon_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indices de la tabla `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trainer_pokemons`
--
ALTER TABLE `trainer_pokemons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`),
  ADD KEY `pokemon_id` (`pokemon_id`);

--
-- Indices de la tabla `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `moves`
--
ALTER TABLE `moves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pokemons`
--
ALTER TABLE `pokemons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `pokemon_moves`
--
ALTER TABLE `pokemon_moves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pokemon_types`
--
ALTER TABLE `pokemon_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `trainer_pokemons`
--
ALTER TABLE `trainer_pokemons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pokemon_moves`
--
ALTER TABLE `pokemon_moves`
  ADD CONSTRAINT `pokemon_moves_ibfk_1` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemons` (`id`),
  ADD CONSTRAINT `pokemon_moves_ibfk_2` FOREIGN KEY (`move_id`) REFERENCES `moves` (`id`);

--
-- Filtros para la tabla `pokemon_types`
--
ALTER TABLE `pokemon_types`
  ADD CONSTRAINT `pokemon_types_ibfk_1` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemons` (`id`),
  ADD CONSTRAINT `pokemon_types_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);

--
-- Filtros para la tabla `trainer_pokemons`
--
ALTER TABLE `trainer_pokemons`
  ADD CONSTRAINT `trainer_pokemons_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`),
  ADD CONSTRAINT `trainer_pokemons_ibfk_2` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemons` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
