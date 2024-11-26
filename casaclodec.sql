-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2024 a las 14:08:40
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
-- Base de datos: `casaclodec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritocompras`
--

CREATE TABLE `carritocompras` (
  `IDcarrito` int(11) NOT NULL,
  `IDusuario` int(11) NOT NULL,
  `IDproducto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `IDcategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`IDcategoria`, `nombre`) VALUES
(1, 'pendientes'),
(2, 'anillos'),
(3, 'cadenas'),
(4, 'dijes'),
(5, 'pulseras'),
(6, 'juegos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `IDcompras` int(11) NOT NULL,
  `IDusuario` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalCompra` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`IDcompras`, `IDusuario`, `fecha`, `totalCompra`) VALUES
(1, 17, '2024-11-25 08:24:03', 680.00),
(2, 9, '2024-11-25 08:30:49', 1120.00),
(3, 9, '2024-11-25 10:00:38', 680.00),
(4, 9, '2024-11-25 10:06:02', 1000.00),
(5, 17, '2024-11-25 10:13:11', 2100.00),
(6, 17, '2024-11-26 01:22:22', 400.00),
(7, 17, '2024-11-26 01:22:44', 400.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_compra`
--

CREATE TABLE `detalles_compra` (
  `IDdetalle` int(11) NOT NULL,
  `IDcompra` int(11) NOT NULL,
  `IDproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_compra`
--

INSERT INTO `detalles_compra` (`IDdetalle`, `IDcompra`, `IDproducto`, `cantidad`, `precio`) VALUES
(1, 1, 9, 1, 280.00),
(2, 1, 36, 1, 400.00),
(3, 2, 26, 1, 520.00),
(4, 2, 38, 1, 600.00),
(5, 3, 19, 1, 680.00),
(6, 4, 2, 1, 500.00),
(7, 4, 8, 2, 250.00),
(8, 5, 12, 2, 650.00),
(9, 5, 11, 2, 400.00),
(10, 6, 11, 1, 400.00),
(11, 7, 11, 1, 400.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `IDproducto` int(11) NOT NULL,
  `IDcategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `fotoURL` varchar(255) NOT NULL,
  `precio` int(11) NOT NULL,
  `cantidadAlmacen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`IDproducto`, `IDcategoria`, `nombre`, `descripcion`, `fotoURL`, `precio`, `cantidadAlmacen`) VALUES
(1, 2, 'Anillo Obsidiana', 'Anillo con piedra marcasita incrustada y obsidiana negra.', 'assets/anillo1.jpeg', 500, 5),
(2, 2, 'Anillo Espiral', 'Anillo en forma de espiral con plata martillada pavonada.', 'assets/anillo2.jpeg', 500, 1),
(3, 2, 'Anillo Figura Asimétrica', 'Anillo en forma de figura asimétrica con esferas.', 'assets/anillo3.jpeg', 500, 1),
(4, 2, 'Anillo Moños', 'Anillo grueso de moños.', 'assets/anillo4.jpeg', 500, 1),
(5, 2, 'Anillo Serpiente ', 'Anillo en forma de serpiente con un toque de color gracias a su piedra zirconia roja.', 'assets/anillo5.jpeg', 500, 1),
(6, 2, 'Anillo Flor Pavonada', 'Anillo en forma de flor con detalles de piedra marcasita en cada pétalo y una piedra zirconia blanca en el medio.', 'assets/anillo6.jpeg', 500, 1),
(7, 3, 'Cadena Balí', 'Cadena balí planchada de 50 centímetros.', 'assets/cadena1.jpeg', 1600, 3),
(8, 3, 'Cadena Círculos Pequeños', 'Cadena delgada de círculos de 50 centímetros.', 'assets/cadena2.jpeg', 250, 2),
(9, 3, 'Cadena Óvalos', 'Cadenaovalada delgada de 50 centímetros.', 'assets/cadena3.jpeg', 280, 4),
(11, 3, 'Cadena Barbada', 'Cadena barbada de 60 centímetros.', 'assets/cadena4.jpeg', 400, 3),
(12, 3, 'Cadena Estilo Cartier', 'Cadena estilo cartier de 70 centímetros.', 'assets/cadena5.jpeg', 650, 3),
(13, 4, 'Dije Colibrí Grande', 'Dije grande de colibrí.', 'assets/dije1.jpeg', 600, 1),
(14, 4, 'Dije Nudo de Bruja Blanco', 'Dije nudo de bruja con zirconia blanca.', 'assets/dije2.jpeg', 300, 2),
(15, 4, 'Dije Rostro de Mujer', 'Dije con forma de rostro de mujer.', 'assets/dije3.jpeg', 600, 1),
(16, 4, 'Dije Nudo de Bruja Negro', 'Dije de nudo de bruja con piedra marcasita', 'assets/dije4.jpeg', 380, 3),
(17, 4, 'Dije Corazón', 'Dije llama ángel en forma de corazón.', 'assets/dije5.jpeg', 550, 1),
(18, 4, 'Dije Colibrí Azul', 'Dije pequeño de colibrí con piedra zirconia azul marino.', 'assets/dije6.jpeg', 280, 1),
(19, 6, 'Juego Mariposal Azulada', 'Juego pintado a mano de mariposas azules con negro.', 'assets/juego1.jpeg', 680, 1),
(20, 6, 'Juego Rosas', 'Juego de rosas con su tallo.', 'assets/juego2.jpeg', 500, 1),
(21, 6, 'Juegos Negro con Perlas', 'Juego con perlas naturales incrustadas en un trabajo de plata pavonado.', 'assets/juego3.jpeg', 900, 1),
(23, 6, 'Juego Círculos', 'Juego de círculos en un trabajo martillado. La cadena viene armada junto con el dije.', 'assets/juego5.jpeg', 1000, 1),
(24, 6, 'Juego Principito', 'Juego inspirado en la historia del principito.', 'assets/juego6.jpeg', 500, 1),
(25, 6, 'Juego Cruces', 'Juego de cruces dentro de círculos con piedra zirconia blanca.', 'assets/juego4.jpeg', 600, 1),
(26, 1, 'Pendiente Flor 6 Pétalos', 'Arete de mariposa en forma de una flor de 6 pétalos.', 'assets/pendientes1.jpeg', 520, 1),
(27, 1, 'Pendientes Flor 5 Pétalos', 'Pendientes de flor con 5 pétalos.', 'assets/pendientes2.jpeg', 350, 1),
(28, 1, 'Pendientes Estrellas Cartonadas', 'Pendientes en forma de estrellas cartonadas.', 'assets/pendientes3.jpeg', 300, 1),
(29, 1, 'Pendientes Hadas', 'Pendientes de hadas con ambar en dos colores: amarillo y verde.', 'assets/pendientes4.jpeg', 600, 1),
(30, 1, 'Pendientes Ramas Pavonadas', 'Pendientes largos con ramas en un trabajo pavonado.', 'assets/pendientes5.jpeg', 280, 1),
(31, 1, 'Pendientes Corazón Frida Kahlo', 'Pendientes con mariposa de corazones estilo Frida Kahlo.', 'assets/pendientes6.jpeg', 280, 1),
(32, 5, 'Pulsera Rectangular', 'Pulsera con eslabones rectangulares.', 'assets/pulsera1.jpeg', 550, 2),
(33, 5, 'Pulsera Corazón', 'Pulsera con corazón y piedras zirconias blancas.', 'assets/pulsera2.jpeg', 500, 1),
(34, 5, 'Pulsera Ópalo', 'Pulsera ópalo con diferentes formas.', 'assets/pulsera3.jpeg', 980, 1),
(35, 5, 'Pulsera Cuadrada', 'Pulcera con eslabones cúbicos.', 'assets/pulsera4.jpeg', 500, 2),
(36, 5, 'Pulsera Corazones', 'Pulsera con eslabones en forma de corazón.', 'assets/pulsera5.jpeg', 400, 5),
(37, 5, 'Pulsera Infinito', 'Pulsera con infinito y un pequeño corazón con piedras zirconia blancas.', 'assets/pulsera6.jpeg', 700, 1),
(38, 2, 'Anillo Quetzalcóatl', 'Anillo de Quetzalcóatl (serpiente emplumada) con un toque de color gracias a su piedra zirconia roja.', 'assets/anillo7.jpeg', 600, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IDusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `numeroTarjeta` varchar(50) NOT NULL,
  `direccion` text NOT NULL,
  `rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IDusuario`, `nombre`, `email`, `password`, `fechaNacimiento`, `numeroTarjeta`, `direccion`, `rol`) VALUES
(9, 'Shelly Flores', 'shelly@hotmail.com', 'test', '2001-09-17', '3546789098987645', 'Prueba123', 'usuario'),
(16, 'test', 'test@correo.com', '123', '2024-11-06', '1234567891234567', 'ryhtegrfedw', 'usuario'),
(17, 'test', 'test@test.com', '123', '2024-11-18', '1234567891011121', 'Calle Manzanita 34 Colonia jardines del predregal', 'usuario'),
(18, 'test2', 'test2@test.com', '123', '2024-11-11', '1234567891011121', 'hgfd', 'usuario'),
(19, 'Admin', 'admin@example.com', 'admin', '2001-09-17', '', '', 'admin'),
(20, 'test Registro Usuario', 'prueba@prueba.com', '123', '2024-11-05', '3546789098987645', 'Prueba', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carritocompras`
--
ALTER TABLE `carritocompras`
  ADD PRIMARY KEY (`IDcarrito`),
  ADD KEY `IDproducto` (`IDproducto`),
  ADD KEY `IDusuario` (`IDusuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`IDcategoria`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`IDcompras`),
  ADD KEY `IDusuario` (`IDusuario`);

--
-- Indices de la tabla `detalles_compra`
--
ALTER TABLE `detalles_compra`
  ADD PRIMARY KEY (`IDdetalle`),
  ADD KEY `IDcompra` (`IDcompra`),
  ADD KEY `IDproducto` (`IDproducto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`IDproducto`),
  ADD KEY `IDcategoria` (`IDcategoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IDusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carritocompras`
--
ALTER TABLE `carritocompras`
  MODIFY `IDcarrito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `IDcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `IDcompras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalles_compra`
--
ALTER TABLE `detalles_compra`
  MODIFY `IDdetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `IDproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IDusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carritocompras`
--
ALTER TABLE `carritocompras`
  ADD CONSTRAINT `carritocompras_ibfk_1` FOREIGN KEY (`IDproducto`) REFERENCES `productos` (`IDproducto`),
  ADD CONSTRAINT `carritocompras_ibfk_2` FOREIGN KEY (`IDusuario`) REFERENCES `usuarios` (`IDusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`IDusuario`) REFERENCES `usuarios` (`IDusuario`);

--
-- Filtros para la tabla `detalles_compra`
--
ALTER TABLE `detalles_compra`
  ADD CONSTRAINT `detalles_compra_ibfk_1` FOREIGN KEY (`IDcompra`) REFERENCES `compras` (`IDcompras`),
  ADD CONSTRAINT `detalles_compra_ibfk_2` FOREIGN KEY (`IDproducto`) REFERENCES `productos` (`IDproducto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`IDcategoria`) REFERENCES `categorias` (`IDcategoria`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
