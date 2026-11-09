-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2026 a las 18:19:19
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ahk`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `usuario`, `password`) VALUES
(1, 'Agustin', 'ahkuruguay2026');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas_laborales`
--

CREATE TABLE `ofertas_laborales` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `empresa` varchar(150) DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `modalidad` varchar(50) DEFAULT NULL,
  `salario` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `requisitos` text DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ofertas_laborales`
--

INSERT INTO `ofertas_laborales` (`id`, `titulo`, `empresa`, `ubicacion`, `modalidad`, `salario`, `descripcion`, `requisitos`, `fecha_publicacion`) VALUES
(2, 'Muestreador', 'AHK', 'Nueva Palmira', 'Presencial', '$30.000', 'Muestreador de mineral de hierro', 'Mayor de edad\r\nCarnet de salud vigente\r\nBuena capacidad fisica', '2026-07-23'),
(3, 'Analisis de mineral', 'AHK', 'Nueva Palmira', 'Remoto', '$70.000', 'Analisis de humedad y demas', 'ninguno', '2026-09-18'),
(4, 'Programador', 'AHK', 'Nueva Palmira', 'Híbrido', '$80.000', 'Desarrollo y mantenimiento de pagina', 'PHP, HTML, CSS y conocimientos de bases de datos', '2026-10-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expira_en` datetime NOT NULL,
  `usado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `password_resets`
--

INSERT INTO `password_resets` (`id`, `usuario_id`, `token`, `expira_en`, `usado`) VALUES
(1, 12, '5d07cf18f265d4b6e86ddae076dc496587ddc3a2fd5ed79db334bb04b3866a68', '2026-08-12 22:31:47', 0),
(2, 12, '45c70a7b4d9199235258e178258442751a897edd1feddd9d13926ba1fd32bdd6', '2026-08-12 23:08:12', 0),
(3, 12, '9f325535bca42e90654b9b58dd3d6a1285993708ea7beabe423925ec11942d17', '2026-08-12 23:08:17', 0),
(4, 12, 'b291716aeaa2e64bb48d36d581f9ea48820ebb58b768d397aff056714a340acb', '2026-08-12 23:20:27', 1),
(5, 16, 'df81a031a200749486faa1d02b340a3f18ffd913f69a9228fac3d478f6263be6', '2026-08-12 23:24:52', 0),
(6, 12, 'b63f04f74f071becfc01d590eadb88ebe5cda259a2fca362f493822f891835a5', '2026-08-12 23:27:54', 1),
(7, 12, 'b6e66d826614e141c4a8cf0b992ec9dc66b939a561fac56cff99ad348f7d3437', '2026-08-19 21:12:37', 1),
(8, 12, '0c9d19ce4e2c47b6024d588617e37d22431fc89dd3bae422dda08b42df84d1ab', '2026-09-04 17:05:15', 1),
(9, 12, '5b169322ee32f17612e63901ae35a3f91fab939f29a77924f5d28f1f876f3a47', '2026-09-18 21:19:24', 1),
(10, 12, '1c527149e4d67040aa93d611f6ba585a2a7074ecd4abd7d3007710bdc78faaed', '2026-09-30 23:08:56', 1),
(11, 12, '693e38bb742c3cb1e9b16067db0862bc07b1c5e13d9eefc6530b194b9d029ccc', '2026-09-30 23:09:02', 0),
(12, 12, '118d5f5b68fea627f11b9b9d6708454bd72e3a03d296d0c4a48efac5a87efe21', '2026-10-01 00:16:15', 1),
(13, 12, '9779c6aa525bc3a847f9cf4d4f3eaf0864fea2b7526d854ddc9a5485d55e69ad', '2026-10-01 04:49:01', 1),
(14, 12, '53548fc3e55f434627bd366471c795b9b347063b951c47688cd722e29fbe0fed', '2026-10-05 19:15:41', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_usuario`
--

CREATE TABLE `perfil_usuario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nombre_completo` varchar(150) DEFAULT NULL,
  `profesion` varchar(100) DEFAULT NULL,
  `presentacion` text DEFAULT NULL,
  `experiencia` text DEFAULT NULL,
  `estudios` text DEFAULT NULL,
  `habilidades` text DEFAULT NULL,
  `ubicacion` text DEFAULT NULL,
  `idiomas` text DEFAULT NULL,
  `contacto` text DEFAULT NULL,
  `curriculum` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil_usuario`
--

INSERT INTO `perfil_usuario` (`id`, `id_usuario`, `foto`, `nombre_completo`, `profesion`, `presentacion`, `experiencia`, `estudios`, `habilidades`, `ubicacion`, `idiomas`, `contacto`, `curriculum`) VALUES
(2, 12, 'uploads/fotos/1790259557_IMG_20260515_235728_137.webp', 'David Mendoza', 'desarrollador web', 'Tengo 21 años, busco aprender y mejorar \r\n\r\n', 'Pasante administrativo\r\npalero', 'UTU', 'PHP, HTML, CSS y conocimientos de bases de datos', 'Nueva Palmira', 'Ingles basico', '091813712\r\nmendozapanamadavid@gmail.com', 'uploads/curriculum/1790617372_David Mendoza.pdf'),
(3, 19, '', '', '', '', '', '', '', '', '', '', 'uploads/curriculum/1790618179_David Mendoza.pdf'),
(4, 20, '', 'Claudia Alicia Panama Sayas', 'Empleada', 'Soy una persona responsable, capaz, puntual, con buena capacidad de aprendizaje y buen trabajo en equipo', 'Securitas, N. Palmira. Guardia de seguridad.\r\nCencista, N. Palmira. Censo en la zona.\r\n', 'Bachillerato completo', 'Puntual.\r\nTrabajo en equipo.\r\nCapacidad de adaptacion ante presion', 'Nueva Palmira', 'Español.', '+598 098 734 590\r\npanamaclaudia6@gmail.com', ''),
(5, 21, 'uploads/fotos/1792008163_index.png', 'Leandro Arrivillaga', 'desarollador junior', 'soy un estudiante de programacion y trabajo bien en equipo', 'ninguno', 'bachillerato tecnologia de la informacion', 'HTML, CSS, PHP,  base de datos y Java Script', 'Nueva Palmira', 'Español y ingles B2', 'hola', 'uploads/curriculum/1792008042_David Mendoza.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones`
--

CREATE TABLE `postulaciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_oferta` int(11) NOT NULL,
  `fecha_postulacion` datetime DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `postulaciones`
--

INSERT INTO `postulaciones` (`id`, `id_usuario`, `id_oferta`, `fecha_postulacion`, `estado`) VALUES
(3, 12, 3, '2026-08-09 21:33:52', 'Pendiente'),
(4, 18, 3, '2026-09-04 11:32:52', 'Pendiente'),
(5, 20, 3, '2026-09-30 23:17:42', 'Pendiente'),
(6, 12, 4, '2026-10-09 11:32:43', 'Pendiente'),
(7, 12, 2, '2026-10-09 11:32:57', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `telefono`, `correo`, `contrasena`) VALUES
(12, 'David', 'Mendoza', '091813712', 'mendozapanamadavid@gmail.com', '$2y$10$JRYnccFqa9QcWgQrl.dxVevVl29c6AvkyNnNXelMLn6cXEYEey3j6'),
(16, 'Alex', 'Gonzalez', '098888888', 'melugon80@gmail.com', '$2y$10$SQVJfsjdgTFRQ2A7I7Px1.ZxUroVNUfuyl//bSaBgjVCJnkbouuN6'),
(17, 'Alan', 'Arriola', '098999999', 'alan@gmail.com', '$2y$10$FhUaOD3lN9Gu4LSK/i0Yue2MOqsjZ1Ee001kcvYGR2/0Omz4gPJGC'),
(18, 'Victor', 'Mendoza', '098111111', 'victormendoza@gmail.com', '$2y$10$IqIkNZDMD7Ba4EJpIE4Rw.O4/gSfNXqD9MJel9AmF0qPgHlkyBjay'),
(19, 'vale', 'fernandez', '092673675', 'fernandezvalee335@gmail.com', '$2y$10$hjYhTMA5QNnC9YBhBaxddec53x4bETeUyf8Al/t2YmmisuLgvcODG'),
(20, 'Claudia', 'Panama', '098734590', 'panamaclaudia6@gmail.com', '$2y$10$I21fHIABVy9DxQecpgpDtexXrygKbhIXQMdTAOePgz3N98BUVqGu6'),
(21, 'leandro', 'arrivillaga', '099227283', 'sdjdjsjj@gmail.com', '$2y$10$7FDV0PiXOw6PXmLZ8GZ2auF/HXI086at0NjE2.xJLAaCwBDqbk1fO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `ofertas_laborales`
--
ALTER TABLE `ofertas_laborales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `perfil_usuario`
--
ALTER TABLE `perfil_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_oferta` (`id_oferta`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `telefono` (`telefono`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ofertas_laborales`
--
ALTER TABLE `ofertas_laborales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `perfil_usuario`
--
ALTER TABLE `perfil_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `perfil_usuario`
--
ALTER TABLE `perfil_usuario`
  ADD CONSTRAINT `perfil_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD CONSTRAINT `postulaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `postulaciones_ibfk_2` FOREIGN KEY (`id_oferta`) REFERENCES `ofertas_laborales` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
