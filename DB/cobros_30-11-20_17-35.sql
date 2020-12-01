# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.5-10.5.8-MariaDB)
# Base de datos: WebDesk
# Tiempo de Generación: 2020-11-30 23:35:56 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla cobros
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cobros`;

CREATE TABLE `cobros` (
  `cobroId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `reservacionId` smallint(5) unsigned NOT NULL,
  `cobroConsecutivo` tinyint(4) unsigned NOT NULL,
  `cobroTipo` char(3) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `cobroMonto` decimal(12,2) NOT NULL,
  `cobroDetalle` char(255) CHARACTER SET latin1 DEFAULT NULL,
  `acumulado` decimal(12,2) NOT NULL,
  `saldoInicial` decimal(12,2) NOT NULL,
  `saldoFinal` decimal(12,2) NOT NULL,
  PRIMARY KEY (`cobroId`),
  UNIQUE KEY `UNICO` (`reservacionId`,`cobroConsecutivo`),
  CONSTRAINT `cobros_reservaciones` FOREIGN KEY (`reservacionId`) REFERENCES `reservaciones` (`reservacionId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

LOCK TABLES `cobros` WRITE;
/*!40000 ALTER TABLE `cobros` DISABLE KEYS */;

INSERT INTO `cobros` (`cobroId`, `reservacionId`, `cobroConsecutivo`, `cobroTipo`, `cobroMonto`, `cobroDetalle`, `acumulado`, `saldoInicial`, `saldoFinal`)
VALUES
	(1,3,1,'E',500.00,NULL,500.00,27000.00,26500.00),
	(2,3,2,'E',500.00,NULL,1000.00,26500.00,26000.00),
	(3,3,3,'TC',800.00,NULL,1800.00,26000.00,25200.00);

/*!40000 ALTER TABLE `cobros` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
