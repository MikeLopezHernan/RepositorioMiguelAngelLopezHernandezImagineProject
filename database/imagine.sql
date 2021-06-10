-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2021 a las 00:39:02
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `imagine`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) DEFAULT NULL,
  `noti_type` varchar(200) DEFAULT NULL,
  `noti_type_id` int(255) DEFAULT NULL,
  `is_readed` varchar(3) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `misscellaneous` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_alerts_users_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interesting_people`
--

CREATE TABLE IF NOT EXISTS `interesting_people` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) DEFAULT NULL,
  `followed` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_interesting_people_user` (`user_id`),
  KEY `fk_followed` (`followed`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `synergy`
--

CREATE TABLE IF NOT EXISTS `synergy` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) DEFAULT NULL,
  `thought_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_synergy_users` (`user_id`),
  KEY `FK_122B0F1A8DE60B34` (`thought_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=239 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `thought`
--

CREATE TABLE IF NOT EXISTS `thought` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) DEFAULT NULL,
  `text` varchar(250) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `attachment` varchar(120) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `videoYT` varchar(100) DEFAULT NULL,
  `thoughtPadre` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_thought_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `userNick` varchar(25) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(150) DEFAULT NULL,
  `mailDir` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `userImage` varchar(255) DEFAULT NULL,
  `biography` varchar(220) DEFAULT NULL,
  `role` varchar(15) DEFAULT NULL,
  `userStatus` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_uniques_fields` (`userNick`,`mailDir`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `whisper`
--

CREATE TABLE IF NOT EXISTS `whisper` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `content` longtext,
  `sender` int(255) DEFAULT NULL,
  `receiver` int(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `attachment` varchar(220) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `readed` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sender` (`sender`),
  KEY `fk_receiver` (`receiver`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `fk_alerts_users_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `interesting_people`
--
ALTER TABLE `interesting_people`
  ADD CONSTRAINT `fk_followed` FOREIGN KEY (`followed`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_interesting_people_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `synergy`
--
ALTER TABLE `synergy`
  ADD CONSTRAINT `FK_122B0F1A8DE60B34` FOREIGN KEY (`thought_id`) REFERENCES `thought` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_synergy_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `thought`
--
ALTER TABLE `thought`
  ADD CONSTRAINT `fk_thought_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `whisper`
--
ALTER TABLE `whisper`
  ADD CONSTRAINT `fk_receiver` FOREIGN KEY (`receiver`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_sender` FOREIGN KEY (`sender`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
