# Sequel Pro dump
# Version 654
# http://code.google.com/p/sequel-pro
#
# Host: localhost (MySQL 5.0.15-standard)
# Database: asistencia
# Generation Time: 2009-08-16 02:17:24 -0500
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table area
# ------------------------------------------------------------

DROP TABLE IF EXISTS `area`;

CREATE TABLE `area` (
  `idArea` int(10) NOT NULL auto_increment,
  `Area` varchar(30) NOT NULL,
  PRIMARY KEY  (`idArea`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table asistenciaprofesores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `asistenciaprofesores`;

CREATE TABLE `asistenciaprofesores` (
  `idAsistencia` int(10) NOT NULL auto_increment,
  `idSalon` int(10) NOT NULL,
  `idRondin` int(10) NOT NULL,
  `idStatus` tinyint(3) NOT NULL,
  `FechaHora` datetime default NULL,
  `idJustificacion` int(10) NOT NULL default '0',
  `idObservacion` int(10) NOT NULL default '0',
  `Capturado` tinyint(3) NOT NULL default '0',
  `idProfesor` int(10) NOT NULL default '0',
  `idProfesorSalon` int(10) NOT NULL default '0',
  PRIMARY KEY  (`idAsistencia`),
  KEY `IDX_PS` (`idProfesorSalon`),
  KEY `IDX_RD` (`idRondin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table cicloescolar
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cicloescolar`;

CREATE TABLE `cicloescolar` (
  `idCicloEscolar` int(10) unsigned NOT NULL auto_increment,
  `Ciclo` varchar(10) character set utf8 NOT NULL,
  `inicio` date default NULL,
  `fin` date default NULL,
  PRIMARY KEY  (`idCicloEscolar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table dia
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dia`;

CREATE TABLE `dia` (
  `idDia` int(10) NOT NULL,
  `Dia` varchar(50) NOT NULL,
  PRIMARY KEY  (`idDia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table edificiosalon
# ------------------------------------------------------------

DROP TABLE IF EXISTS `edificiosalon`;

CREATE TABLE `edificiosalon` (
  `idSalon` int(10) unsigned NOT NULL auto_increment,
  `Edificio` varchar(50) NOT NULL,
  `Salon` varchar(50) NOT NULL,
  PRIMARY KEY  (`idSalon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table faltasjustificadas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `faltasjustificadas`;

CREATE TABLE `faltasjustificadas` (
  `idFaltasJustificadas` int(11) unsigned NOT NULL auto_increment,
  `idJustificante` int(11) unsigned NOT NULL,
  `idProfesorSalon` int(11) unsigned NOT NULL,
  `Fecha` date NOT NULL,
  PRIMARY KEY  (`idFaltasJustificadas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table hora
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hora`;

CREATE TABLE `hora` (
  `idHora` smallint(5) NOT NULL auto_increment,
  `Hora` varchar(2) NOT NULL,
  PRIMARY KEY  (`idHora`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table horario
# ------------------------------------------------------------

DROP TABLE IF EXISTS `horario`;

CREATE TABLE `horario` (
  `idHorario` int(10) NOT NULL auto_increment,
  `Horario` varchar(5) character set utf8 NOT NULL,
  PRIMARY KEY  (`idHorario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table justificacion
# ------------------------------------------------------------

DROP TABLE IF EXISTS `justificacion`;

CREATE TABLE `justificacion` (
  `idJustificacion` int(10) NOT NULL auto_increment,
  `Justificacion` varchar(255) NOT NULL,
  PRIMARY KEY  (`idJustificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table justificante
# ------------------------------------------------------------

DROP TABLE IF EXISTS `justificante`;

CREATE TABLE `justificante` (
  `idJustificante` int(11) unsigned NOT NULL auto_increment,
  `idProfesor` int(11) unsigned NOT NULL,
  `idCicloEscolar` int(10) unsigned NOT NULL,
  `FechaAlta` datetime NOT NULL default '2009-02-01 00:00:00',
  `idJustificacion` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`idJustificante`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table materia
# ------------------------------------------------------------

DROP TABLE IF EXISTS `materia`;

CREATE TABLE `materia` (
  `idMateria` int(10) NOT NULL,
  `Materia` varchar(50) NOT NULL default 'NC',
  `idArea` int(10) NOT NULL default '0',
  PRIMARY KEY  (`idMateria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table observacion
# ------------------------------------------------------------

DROP TABLE IF EXISTS `observacion`;

CREATE TABLE `observacion` (
  `idObservacion` int(10) NOT NULL auto_increment,
  `Observacion` varchar(40) NOT NULL,
  PRIMARY KEY  (`idObservacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table profesor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `profesor`;

CREATE TABLE `profesor` (
  `idProfesor` int(10) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table profesorsalon
# ------------------------------------------------------------

DROP TABLE IF EXISTS `profesorsalon`;

CREATE TABLE `profesorsalon` (
  `idProfesorSalon` int(10) unsigned NOT NULL auto_increment,
  `idSalon` int(10) NOT NULL,
  `idProfesor` int(10) unsigned NOT NULL default '0',
  `idCicloEscolar` int(10) NOT NULL,
  `idHorario` int(10) NOT NULL,
  `idDia` int(10) NOT NULL,
  `idMateria` int(10) NOT NULL default '0',
  PRIMARY KEY  (`idProfesorSalon`),
  KEY `IDX_CE_Prof` (`idCicloEscolar`,`idProfesor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) NOT NULL auto_increment,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table rondin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rondin`;

CREATE TABLE `rondin` (
  `idRondin` int(10) NOT NULL auto_increment,
  `idEncargado` int(10) NOT NULL,
  `FechaHora` datetime NOT NULL,
  `status` char(1) NOT NULL default 'N',
  `idCicloEscolar` int(10) NOT NULL default '3',
  PRIMARY KEY  (`idRondin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table statusclase
# ------------------------------------------------------------

DROP TABLE IF EXISTS `statusclase`;

CREATE TABLE `statusclase` (
  `idStatus` int(10) NOT NULL auto_increment,
  `Status` varchar(15) NOT NULL,
  PRIMARY KEY  (`idStatus`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table usuarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL auto_increment,
  `username` varchar(16) NOT NULL,
  `password` varbinary(64) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `role` int(10) NOT NULL,
  `activo` tinyint(3) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
