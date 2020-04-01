/*CREATE TABLE `usuarios` (
  `usuario` varchar(25) NOT NULL,
  `pass` varchar(25) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  PRIMARY KEY  (`usuario`)
) TYPE=MyISAM;

--
-- Volcar la base de datos para la tabla `admin_panels`
--
INSERT INTO `usuarios` (`usuario`, `pass`, `nombre`) VALUES
(1, 'andrew', 'hola','Andres Arroyo'),
(2, 'amilcar', 'hola1', 'Amilcar Martinez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `usuarios_log` (
  `id` int(11) NOT NULL,
  `usuario` varchar(25) NOT NULL default '',
  `fecha_login` date NOT NULL,
  `fecha_logout` date NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=0;

*/
CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `fecha_descarga` datetime NOT NULl,
  `fecha_entrega` datetime NOT NULL,
  `comentarios` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=0;

/*
--
-- Volcar la base de datos para la tabla `asignaturas`
-- 

INSERT INTO `asignaturas` (`id`, `nombre`, `codigo`, `descripcion`) VALUES 
(1, 'prueba', 'P01', 'Asignatura de prueba'),
(3, 'pruasig', 'PA2', 'Asignatura de prueba 2'),
(4, 'victor', '', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `modulos`
-- 

CREATE TABLE `modulos` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `icon` varchar(25) NOT NULL,
  `controller` varchar(25) NOT NULL,
  `perms` varchar(25) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `modulos`
-- 

INSERT INTO `modulos` (`id`, `name`, `icon`, `controller`, `perms`) VALUES 
(1, 'Alumnos', 'alumnos.png', 'alumnos', 'users'),
(2, 'Asignaturas', 'asignaturas.png', 'asignaturas', 'users'),
(4, 'Usuarios', '', 'usuarios', 'hide'),
(3, 'Profesores', 'profesores.png', 'profesores', 'users');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `profesores`
-- 

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL default '',
  `apellido1` varchar(25) NOT NULL default '',
  `apellido2` varchar(25) default NULL,
  `sexo` enum('V','M') NOT NULL default 'V',
  `tipo_doc` varchar(10) NOT NULL default '0',
  `num_doc` varchar(9) NOT NULL default '0',
  `nuss` varchar(15) NOT NULL default '0',
  `direccion` varchar(25) NOT NULL default '',
  `localidad` varchar(25) NOT NULL default '0',
  `cpostal` int(5) NOT NULL default '0',
  `provincia` varchar(25) NOT NULL default '0',
  `telf1` int(9) default '0',
  `email` varchar(25) default '*',
  `fecha_nacimiento` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `profesores`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `group` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `users`
-- 

INSERT INTO `users` (`id`, `username`, `group`, `password`, `nombre`, `apellido`) VALUES 
(1, 'admin', 'admins', 'ca3168abab097cc79fab663d82a1cd7f', 'Administrador', '');*/