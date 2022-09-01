-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 01-09-2022 a las 08:41:56
-- Versión del servidor: 5.7.34
-- Versión de PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `snowtricks`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `figure_category` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `figure_category`) VALUES
(1, 'Mc Twist'),
(2, 'Jib'),
(3, 'Grabs'),
(4, 'Lipslide'),
(5, 'Air to Fakie');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `figure_id_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `figure_id_id`, `created_at`, `content`) VALUES
(6, 2, 4, '2022-09-01 08:38:44', 'Tres interesant'),
(7, 2, 5, '2022-09-01 08:39:00', 'J\'adore'),
(8, 2, 7, '2022-09-01 08:39:17', 'Impresionant vraiment'),
(9, 1, 4, '2022-09-01 08:40:35', 'Waw j\'ai apris beaucoup');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220831084942', '2022-08-31 08:49:46', 332);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `figure`
--

CREATE TABLE `figure` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `figure`
--

INSERT INTO `figure` (`id`, `category_id`, `user_id`, `title`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 'Figure 1', 'figure-1-0', 'Fides fides documentorum inde nunc explanare quae explanare ut nobilem causam fama praecipitem est exitium nunc Aginatium ut ad documentorum praecipitem pertinacior Aginatium maioribus est maioribus exitium fama Aginatium est inpulit arbitror fides hoc locuta nobilem ad ad ad iam nec ulla est iam iam ut arbitror super inde inde est causam inpulit inde inpulit ut explanare nobilem ad Aginatium nobilem maioribus inpulit est iam locuta documentorum ut est enim super arbitror explanare exitium locuta est quae priscis ut iam enim enim causam ut enim Aginatium documentorum Aginatium nunc super est super exitium ut a est explanare est maioribus priscis locuta est iam exitium ulla nec quae enim explanare praecipitem pertinacior est priscis iam locuta ut rata arbitror a nunc inpulit pertinacior pertinacior rata Aginatium fides ut exitium ulla ut super Aginatium est explanare nobilem est nobilem nunc ut praecipitem fides documentorum praecipitem ut priscis documentorum maioribus locuta est fama.', '2022-09-01 08:29:47', '2022-09-01 08:30:42'),
(5, 2, 1, 'Figure 2', 'figure-2', 'Fides fides documentorum inde nunc explanare quae explanare ut nobilem causam fama praecipitem est exitium nunc Aginatium ut ad documentorum praecipitem pertinacior Aginatium maioribus est maioribus exitium fama Aginatium est inpulit arbitror fides hoc locuta nobilem ad ad ad iam nec ulla est iam iam ut arbitror super inde inde est causam inpulit inde inpulit ut explanare nobilem ad Aginatium nobilem maioribus inpulit est iam locuta documentorum ut est enim super arbitror explanare exitium locuta est quae priscis ut iam enim enim causam ut enim Aginatium documentorum Aginatium nunc super est super exitium ut a est explanare est maioribus priscis locuta est iam exitium ulla nec quae enim explanare praecipitem pertinacior est priscis iam locuta ut rata arbitror a nunc inpulit pertinacior pertinacior rata Aginatium fides ut exitium ulla ut super Aginatium est explanare nobilem est nobilem nunc ut praecipitem fides documentorum praecipitem ut priscis documentorum maioribus locuta est fama.', '2022-09-01 08:31:31', NULL),
(6, 3, 1, 'Figure 3', 'figure-3', 'Fides fides documentorum inde nunc explanare quae explanare ut nobilem causam fama praecipitem est exitium nunc Aginatium ut ad documentorum praecipitem pertinacior Aginatium maioribus est maioribus exitium fama Aginatium est inpulit arbitror fides hoc locuta nobilem ad ad ad iam nec ulla est iam iam ut arbitror super inde inde est causam inpulit inde inpulit ut explanare nobilem ad Aginatium nobilem maioribus inpulit est iam locuta documentorum ut est enim super arbitror explanare exitium locuta est quae priscis ut iam enim enim causam ut enim Aginatium documentorum Aginatium nunc super est super exitium ut a est explanare est maioribus priscis locuta est iam exitium ulla nec quae enim explanare praecipitem pertinacior est priscis iam locuta ut rata arbitror a nunc inpulit pertinacior pertinacior rata Aginatium fides ut exitium ulla ut super Aginatium est explanare nobilem est nobilem nunc ut praecipitem fides documentorum praecipitem ut priscis documentorum maioribus locuta est fama.', '2022-09-01 08:32:13', NULL),
(7, 4, 1, 'Figure 4', 'figure-4', 'Fides fides documentorum inde nunc explanare quae explanare ut nobilem causam fama praecipitem est exitium nunc Aginatium ut ad documentorum praecipitem pertinacior Aginatium maioribus est maioribus exitium fama Aginatium est inpulit arbitror fides hoc locuta nobilem ad ad ad iam nec ulla est iam iam ut arbitror super inde inde est causam inpulit inde inpulit ut explanare nobilem ad Aginatium nobilem maioribus inpulit est iam locuta documentorum ut est enim super arbitror explanare exitium locuta est quae priscis ut iam enim enim causam ut enim Aginatium documentorum Aginatium nunc super est super exitium ut a est explanare est maioribus priscis locuta est iam exitium ulla nec quae enim explanare praecipitem pertinacior est priscis iam locuta ut rata arbitror a nunc inpulit pertinacior pertinacior rata Aginatium fides ut exitium ulla ut super Aginatium est explanare nobilem est nobilem nunc ut praecipitem fides documentorum praecipitem ut priscis documentorum maioribus locuta est fama.', '2022-09-01 08:34:30', NULL),
(8, 4, 1, 'Figure 5', 'figure-5', 'Fides fides documentorum inde nunc explanare quae explanare ut nobilem causam fama praecipitem est exitium nunc Aginatium ut ad documentorum praecipitem pertinacior Aginatium maioribus est maioribus exitium fama Aginatium est inpulit arbitror fides hoc locuta nobilem ad ad ad iam nec ulla est iam iam ut arbitror super inde inde est causam inpulit inde inpulit ut explanare nobilem ad Aginatium nobilem maioribus inpulit est iam locuta documentorum ut est enim super arbitror explanare exitium locuta est quae priscis ut iam enim enim causam ut enim Aginatium documentorum Aginatium nunc super est super exitium ut a est explanare est maioribus priscis locuta est iam exitium ulla nec quae enim explanare praecipitem pertinacior est priscis iam locuta ut rata arbitror a nunc inpulit pertinacior pertinacior rata Aginatium fides ut exitium ulla ut super Aginatium est explanare nobilem est nobilem nunc ut praecipitem fides documentorum praecipitem ut priscis documentorum maioribus locuta est fama.', '2022-09-01 08:35:22', NULL),
(9, 5, 2, 'Figure 6', 'figure-6', 'Fides fides documentorum inde nunc explanare quae explanare ut nobilem causam fama praecipitem est exitium nunc Aginatium ut ad documentorum praecipitem pertinacior Aginatium maioribus est maioribus exitium fama Aginatium est inpulit arbitror fides hoc locuta nobilem ad ad ad iam nec ulla est iam iam ut arbitror super inde inde est causam inpulit inde inpulit ut explanare nobilem ad Aginatium nobilem maioribus inpulit est iam locuta documentorum ut est enim super arbitror explanare exitium locuta est quae priscis ut iam enim enim causam ut enim Aginatium documentorum Aginatium nunc super est super exitium ut a est explanare est maioribus priscis locuta est iam exitium ulla nec quae enim explanare praecipitem pertinacior est priscis iam locuta ut rata arbitror a nunc inpulit pertinacior pertinacior rata Aginatium fides ut exitium ulla ut super Aginatium est explanare nobilem est nobilem nunc ut praecipitem fides documentorum praecipitem ut priscis documentorum maioribus locuta est fama.', '2022-09-01 08:36:20', NULL),
(10, 1, 2, 'Figure 7', 'figure-7', 'Fides fides documentorum inde nunc explanare quae explanare ut nobilem causam fama praecipitem est exitium nunc Aginatium ut ad documentorum praecipitem pertinacior Aginatium maioribus est maioribus exitium fama Aginatium est inpulit arbitror fides hoc locuta nobilem ad ad ad iam nec ulla est iam iam ut arbitror super inde inde est causam inpulit inde inpulit ut explanare nobilem ad Aginatium nobilem maioribus inpulit est iam locuta documentorum ut est enim super arbitror explanare exitium locuta est quae priscis ut iam enim enim causam ut enim Aginatium documentorum Aginatium nunc super est super exitium ut a est explanare est maioribus priscis locuta est iam exitium ulla nec quae enim explanare praecipitem pertinacior est priscis iam locuta ut rata arbitror a nunc inpulit pertinacior pertinacior rata Aginatium fides ut exitium ulla ut super Aginatium est explanare nobilem est nobilem nunc ut praecipitem fides documentorum praecipitem ut priscis documentorum maioribus locuta est fama.', '2022-09-01 08:36:29', NULL),
(11, 1, 2, 'Figure 8', 'figure-8', 'Fides fides documentorum inde nunc explanare quae explanare ut nobilem causam fama praecipitem est exitium nunc Aginatium ut ad documentorum praecipitem pertinacior Aginatium maioribus est maioribus exitium fama Aginatium est inpulit arbitror fides hoc locuta nobilem ad ad ad iam nec ulla est iam iam ut arbitror super inde inde est causam inpulit inde inpulit ut explanare nobilem ad Aginatium nobilem maioribus inpulit est iam locuta documentorum ut est enim super arbitror explanare exitium locuta est quae priscis ut iam enim enim causam ut enim Aginatium documentorum Aginatium nunc super est super exitium ut a est explanare est maioribus priscis locuta est iam exitium ulla nec quae enim explanare praecipitem pertinacior est priscis iam locuta ut rata arbitror a nunc inpulit pertinacior pertinacior rata Aginatium fides ut exitium ulla ut super Aginatium est explanare nobilem est nobilem nunc ut praecipitem fides documentorum praecipitem ut priscis documentorum maioribus locuta est fama.', '2022-09-01 08:36:36', NULL),
(12, 3, 2, 'Figure 9', 'figure-9', 'Fides fides documentorum inde nunc explanare quae explanare ut nobilem causam fama praecipitem est exitium nunc Aginatium ut ad documentorum praecipitem pertinacior Aginatium maioribus est maioribus exitium fama Aginatium est inpulit arbitror fides hoc locuta nobilem ad ad ad iam nec ulla est iam iam ut arbitror super inde inde est causam inpulit inde inpulit ut explanare nobilem ad Aginatium nobilem maioribus inpulit est iam locuta documentorum ut est enim super arbitror explanare exitium locuta est quae priscis ut iam enim enim causam ut enim Aginatium documentorum Aginatium nunc super est super exitium ut a est explanare est maioribus priscis locuta est iam exitium ulla nec quae enim explanare praecipitem pertinacior est priscis iam locuta ut rata arbitror a nunc inpulit pertinacior pertinacior rata Aginatium fides ut exitium ulla ut super Aginatium est explanare nobilem est nobilem nunc ut praecipitem fides documentorum praecipitem ut priscis documentorum maioribus locuta est fama.', '2022-09-01 08:37:25', NULL),
(13, 3, 2, 'Figure 10', 'figure-10', 'Fides fides documentorum inde nunc explanare quae explanare ut nobilem causam fama praecipitem est exitium nunc Aginatium ut ad documentorum praecipitem pertinacior Aginatium maioribus est maioribus exitium fama Aginatium est inpulit arbitror fides hoc locuta nobilem ad ad ad iam nec ulla est iam iam ut arbitror super inde inde est causam inpulit inde inpulit ut explanare nobilem ad Aginatium nobilem maioribus inpulit est iam locuta documentorum ut est enim super arbitror explanare exitium locuta est quae priscis ut iam enim enim causam ut enim Aginatium documentorum Aginatium nunc super est super exitium ut a est explanare est maioribus priscis locuta est iam exitium ulla nec quae enim explanare praecipitem pertinacior est priscis iam locuta ut rata arbitror a nunc inpulit pertinacior pertinacior rata Aginatium fides ut exitium ulla ut super Aginatium est explanare nobilem est nobilem nunc ut praecipitem fides documentorum praecipitem ut priscis documentorum maioribus locuta est fama.', '2022-09-01 08:37:38', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `figure_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main` tinyint(1) NOT NULL,
  `image` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `media`
--

INSERT INTO `media` (`id`, `figure_id`, `url`, `main`, `image`) VALUES
(7, 4, '5b46a36c37f62ca65c3a1269e915d058.webp', 1, 1),
(8, 4, '_mHThcsHkOM', 0, 0),
(9, 5, 'ca602659fe6254b9346c55eeee4abd60.jpg', 1, 1),
(10, 5, '_mHThcsHkOM', 0, 0),
(11, 5, '8694e7dd0e55e4e938c1302f5045bcbe.jpg', 0, 1),
(12, 6, '007ca94c5be437ce29853fcc1a81eea0.webp', 1, 1),
(13, 6, '_mHThcsHkOM', 0, 0),
(14, 7, 'fbe4b8d0396e335d74d2aebda2ee3b8a.jpg', 1, 1),
(15, 7, '039fd339204a48e4b654388da0633aae.jpg', 0, 1),
(16, 7, '_mHThcsHkOM', 0, 0),
(17, 8, '1cc511a9556818aac6ffa82443093fcb.jpg', 1, 1),
(18, 8, '_mHThcsHkOM', 0, 0),
(19, 8, '4t3fNkGwRWo', 0, 0),
(20, 11, '0174710f8b5fbac341f0406fe804eac2.webp', 1, 1),
(21, 11, '9f74c867912fc2babcfb6c33040de260.webp', 0, 1),
(23, 11, '_mHThcsHkOM', 0, 0),
(24, 11, '4t3fNkGwRWo', 0, 0),
(25, 13, '148e6c2976e3ee893a6eb224a5d59c98.jpg', 1, 1),
(26, 13, '_mHThcsHkOM', 0, 0),
(27, 4, '7f28f15ea16a36d3a68f396ded52793e.jpg', 0, 1),
(28, 4, '02e9cd81a68fa24a23e79eda3f31f87b.jpg', 0, 1),
(29, 4, '03975d27a5aaa109f3f75b40dee7bb89.jpg', 0, 1),
(30, 4, 'a9bc80076e020f89613bf0c18e96027e.jpg', 0, 1),
(31, 4, '4t3fNkGwRWo', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `user_name`, `roles`, `password`, `token`, `activated`) VALUES
(1, 'mikyfiestas@gmail.com', 'Miguel', '[]', '$2y$13$mRrZVn0k/ARsLPe3p9403ucawl.UsrgIRWVLBSTaaVUfXU8Tl6eQ2', NULL, 1),
(2, 'miguelsj.pro@gmail.com', 'Pepe', '[]', '$2y$13$cDjRA37qWeLk8HObImUT8uM9KTofURflLfPTy6726O8.7oTZqmV6K', NULL, 1),
(3, 'contact@gmail.com', 'Contact', '[]', '$2y$13$.GCflThqJ8CnBFDTBKI5jOgKyQdECEPlrTUFqJiyvRRQ06keYqBvu', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`),
  ADD KEY `IDX_9474526C6D69186E` (`figure_id_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `figure`
--
ALTER TABLE `figure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2F57B37A12469DE2` (`category_id`),
  ADD KEY `IDX_2F57B37AA76ED395` (`user_id`);

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6A2CA10C5C011B5` (`figure_id`);

--
-- Indices de la tabla `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `figure`
--
ALTER TABLE `figure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C6D69186E` FOREIGN KEY (`figure_id_id`) REFERENCES `figure` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `figure`
--
ALTER TABLE `figure`
  ADD CONSTRAINT `FK_2F57B37A12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_2F57B37AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_6A2CA10C5C011B5` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
