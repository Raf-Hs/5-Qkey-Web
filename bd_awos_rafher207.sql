-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-06-2023 a las 13:35:15
-- Versión del servidor: 5.7.42-0ubuntu0.18.04.1
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_awos_rafher207`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`rafher207`@`localhost` PROCEDURE `ObtenerAlumnosPorGrupo` (IN `nombreGrupo` VARCHAR(255))  BEGIN
    SELECT u.*, a.matricula
    FROM usuarios u
    JOIN alumnos a ON u.id = a.id_usu
    JOIN grupo g ON a.id_gr = g.id
    WHERE u.tipo = 3 AND g.nombre = nombreGrupo;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(255) NOT NULL,
  `matricula` varchar(255) NOT NULL,
  `id_usu` int(255) NOT NULL,
  `id_gr` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `matricula`, `id_usu`, `id_gr`) VALUES
(1, '2022171029', 3, 1),
(8, '20236', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `id` int(255) NOT NULL,
  `id_ma` int(255) NOT NULL,
  `id_gr` int(255) NOT NULL,
  `materia` varchar(255) NOT NULL,
  `laboratorio` varchar(255) NOT NULL,
  `horaE` datetime NOT NULL,
  `horaS` datetime NOT NULL,
  `codigo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`id`, `id_ma`, `id_gr`, `materia`, `laboratorio`, `horaE`, `horaS`, `codigo`) VALUES
(1, 1, 1, 'BD', '11', '2023-06-27 07:00:00', '2023-06-27 09:00:00', '123'),
(2, 6, 2, 'Mate', '12', '2023-06-27 10:00:00', '2023-06-27 11:00:00', '123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id`, `nombre`) VALUES
(1, 'indefinido'),
(2, 't207'),
(3, 't208');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestros`
--

CREATE TABLE `maestros` (
  `id` int(255) NOT NULL,
  `Cempleado` varchar(255) NOT NULL,
  `id_usu` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `maestros`
--

INSERT INTO `maestros` (`id`, `Cempleado`, `id_usu`) VALUES
(1, 'ana123', 2),
(6, 'maestro_5', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `tipo` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `contrasenia`, `tipo`, `nombre`, `direccion`, `telefono`, `token`) VALUES
(1, 'admin@gmail.com', '123', 1, 'admin', 'uteq', '4427477664', '123'),
(2, 'ana@gmail.com', '123', 2, 'ana', 'jose', '4427477664', '123'),
(3, 'rafa@gmail.com', '123', 3, 'rafa', 'villas', '4427477664', '123'),
(5, 'tono@gmail.com', '123', 3, 'tono', 'elektra', '4427456634', '123'),
(6, 'paulo@gmail.com', '123', 3, 'paulo', 'elektra', '4427456634', '123');

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `CrearAlumno` AFTER INSERT ON `usuarios` FOR EACH ROW BEGIN
    IF NEW.tipo = 3 THEN
        INSERT INTO alumnos ( matricula, id_usu, id_gr) VALUES (CONCAT('2023_', NEW.id), NEW.id, 1);
    END IF;
    
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `CrearMaestro` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    IF NEW.tipo = 2 AND OLD.tipo <> 2 THEN
        INSERT INTO maestros ( Cempleado, id_usu) VALUES ( CONCAT('maestro_', NEW.id), NEW.id);
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usu` (`id_usu`),
  ADD KEY `id_gr` (`id_gr`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ma` (`id_ma`),
  ADD KEY `id_gr` (`id_gr`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `maestros`
--
ALTER TABLE `maestros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `maestros`
--
ALTER TABLE `maestros`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `usuario_ifk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `usuario_ifk_3` FOREIGN KEY (`id_gr`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `clase`
--
ALTER TABLE `clase`
  ADD CONSTRAINT `clase_ifk_1` FOREIGN KEY (`id_ma`) REFERENCES `maestros` (`id`),
  ADD CONSTRAINT `clase_ifk_2` FOREIGN KEY (`id_gr`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `maestros`
--
ALTER TABLE `maestros`
  ADD CONSTRAINT `usuario_ifk_2` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



/*Todos los horarios*/
SELECT c.id, u.nombre AS maestro, g.nombre AS grupo, c.materia, c.laboratorio, c.horaE, c.horaS, c.codigo
FROM clase c
JOIN maestros m ON m.id = c.id_ma
JOIN usuarios u ON u.id = m.id_usu
JOIN grupo g ON g.id = c.id_gr;


/*Clases de hoy*/
SELECT c.id, u.nombre AS maestro, g.nombre AS grupo, c.materia, c.laboratorio, c.horaE, c.horaS, c.codigo
FROM clase c
JOIN maestros m ON m.id = c.id_ma
JOIN usuarios u ON u.id = m.id_usu
JOIN grupo g ON g.id = c.id_gr
WHERE DATE(c.horaE) = CURDATE();





/*Cuantas horas de Clases*/
SELECT id, materia, TIME_TO_SEC(TIMEDIFF(horaS, horaE)) / 60 AS duracion_minutos
FROM clase;




/*Todos los usuarios maestros con su codigo de empleado*/
SELECT u.*, m.Cempleado
FROM usuarios u
INNER JOIN maestros m ON u.id = m.id_usu
WHERE u.tipo = 2
ORDER BY u.nombre ASC;



/*Todos los usuarios alumnos con su codigo de empleado y grupo*/

SELECT u.*, a.matricula, g.nombre AS grupo
FROM usuarios u
INNER JOIN alumnos a ON u.id = a.id_usu
INNER JOIN grupo g ON a.id_gr = g.id
WHERE u.tipo = 3;


/*Consulta que obtiene la cantidad de alumnos por grupo y filtra aquellos grupos con menos de 30 alumnos:*/
SELECT grupo.nombre AS grupo, COUNT(alumnos.id) AS cantidad_alumnos
FROM grupo
INNER JOIN alumnos ON grupo.id = alumnos.id_gr
GROUP BY grupo.nombre
HAVING COUNT(alumnos.id) < 30;


/*Cantidad de alumnos por grupo*/

SELECT g.nombre AS grupo, (SELECT COUNT(*) FROM alumnos WHERE id_gr = g.id) AS cantidad_alumnos
FROM grupo g;



/*Trigger*/

/*Se crea un usuario, se crea un alumno*/

DELIMITER //
CREATE TRIGGER CrearAlumno AFTER INSERT ON usuarios
FOR EACH ROW
BEGIN
    IF NEW.tipo = 3 THEN
        INSERT INTO alumnos ( matricula, id_usu, id_gr) VALUES (CONCAT('2023_', NEW.id), NEW.id, 1);
    END IF;
    
END //
DELIMITER ;



/*Se cambia el tipo de usuario a 2 se crea un maestro*/

DELIMITER //
CREATE TRIGGER CrearMaestro AFTER UPDATE ON usuarios
FOR EACH ROW
BEGIN
    IF NEW.tipo = 2 AND OLD.tipo <> 2 THEN
        INSERT INTO maestros ( Cempleado, id_usu) VALUES ( CONCAT('maestro_', NEW.id), NEW.id);
    END IF;
END //
DELIMITER ;



/*Cifrado*/

DELIMITER $$
CREATE TRIGGER identificador after INSERT ON `usuarios` FOR EACH ROW begin
set new.contrasenia = md5(new.contrasenia);
end
$$
DELIMITER ;



/*STORE*/

/*Procedure para alumnos por grupo*/

DELIMITER //
CREATE PROCEDURE ObtenerAlumnosPorGrupo(IN nombreGrupo VARCHAR(255))
BEGIN
    SELECT u.*, a.matricula
    FROM usuarios u
    JOIN alumnos a ON u.id = a.id_usu
    JOIN grupo g ON a.id_gr = g.id
    WHERE u.tipo = 3 AND g.nombre = nombreGrupo;
END //
DELIMITER ;

CALL ObtenerAlumnosPorGrupo('grupo');



/*Procedure para valdiar la puerta*/

DELIMITER //

CREATE PROCEDURE ValidarClase(IN maestro_id INT, IN lab VARCHAR(255), IN hora_inicio DATETIME)
BEGIN
    SELECT *
    FROM clase
    WHERE id_ma = maestro_id
      AND laboratorio = lab
      AND horaE = hora_inicio;
END //

DELIMITER ;

CALL ValidarClase(1, '11', '2023-06-27 07:00:00');

/*Matricula mayor a tal fecha*/

SELECT *
FROM alumnos
WHERE CAST(matricula AS DATE) > (
  SELECT DATE_FORMAT(AVG(CAST(matricula AS DATE)), '%Y%m%d')
  FROM alumnos
);





/*Transacción para borrar todo menos al usuario y los grupos*/


START TRANSACTION;
-- Guardar el estado actual de los registros en caso de que sea necesario deshacer los cambios
SAVEPOINT before_delete;

-- Eliminar registros de la tabla 'clase'
DELETE FROM clase;

-- Eliminar registros de la tabla 'alumnos'
DELETE FROM alumnos;

-- Eliminar registros de la tabla 'maestros'
DELETE FROM maestros;

-- Eliminar registros de la tabla 'usuarios', excepto el usuario admin
DELETE FROM usuarios WHERE tipo != 1;

-- Eliminar registros de la tabla 'grupo'
DELETE FROM grupo;

-- Comprobar si se produjo algún error
IF (SELECT ROW_COUNT()) = 0 THEN
    -- Si no se eliminó ningún registro, deshacer todos los cambios
    ROLLBACK TO before_delete;
ELSE
    -- Si se eliminaron registros, confirmar los cambios
    COMMIT;
END IF;

-- Reiniciar el autoincremento de las tablas
ALTER TABLE alumnos AUTO_INCREMENT = 1;
ALTER TABLE clase AUTO_INCREMENT = 1;
ALTER TABLE maestros AUTO_INCREMENT = 1;
ALTER TABLE usuarios AUTO_INCREMENT = 1;
ALTER TABLE grupo AUTO_INCREMENT = 1;