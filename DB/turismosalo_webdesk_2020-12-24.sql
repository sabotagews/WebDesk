# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: turismosalomon.com.mx (MySQL 5.5.5-10.3.27-MariaDB)
# Database: turismosalo_webdesk
# Generation Time: 2020-12-24 16:26:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table usuarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `usuarioId` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `sucursalId` smallint(5) unsigned NOT NULL,
  `usuarioNombre` char(255) DEFAULT NULL,
  `usuarioApellido` char(255) DEFAULT NULL,
  `usuarioUsername` char(255) DEFAULT NULL,
  `usuarioPassword` char(10) DEFAULT NULL,
  `usuarioEmail` char(255) DEFAULT NULL,
  `usuarioMovil` char(255) DEFAULT NULL,
  `usuarioStatus` tinyint(1) DEFAULT NULL,
  `usuarioRol` char(1) DEFAULT NULL,
  PRIMARY KEY (`usuarioId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;

INSERT INTO `usuarios` (`usuarioId`, `sucursalId`, `usuarioNombre`, `usuarioApellido`, `usuarioUsername`, `usuarioPassword`, `usuarioEmail`, `usuarioMovil`, `usuarioStatus`, `usuarioRol`)
VALUES
	(1,1,'MANUEL','BALLEZA','AIRWALK','MEXICO','test@quattro.ws','4774049649',1,NULL),
	(2,1,'SABO','BALLEZA','SABOBALLEZA','180810','sabo@sabotage.ws','4775777372',1,'A'),
	(3,1,'ELIZABETH','SALOMON','ELISALO','1234567890','elizabeth@turismosalomon.com.mx','4611085646',1,'A');

/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
