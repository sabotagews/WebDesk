# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.5-10.5.8-MariaDB)
# Base de datos: WebDesk
# Tiempo de Generación: 2020-11-28 01:55:09 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla cuentas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cuentas`;

CREATE TABLE `cuentas` (
  `cuentaId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `bancoId` tinyint(3) unsigned DEFAULT NULL,
  `cuentaAlias` char(25) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `cuentaNumero` char(30) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`cuentaId`),
  KEY `proveedorCuentas_catalogoBancos` (`bancoId`),
  CONSTRAINT `cuentas_ibfk_1` FOREIGN KEY (`bancoId`) REFERENCES `catalogoBancos` (`bancoId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

LOCK TABLES `cuentas` WRITE;
/*!40000 ALTER TABLE `cuentas` DISABLE KEYS */;

INSERT INTO `cuentas` (`cuentaId`, `bancoId`, `cuentaAlias`, `cuentaNumero`)
VALUES
	(1,NULL,'BBVA DEBITO','13572468'),
	(2,NULL,'BX CHEQUES','24681357');

/*!40000 ALTER TABLE `cuentas` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
