# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.5-10.5.8-MariaDB)
# Base de datos: WebDesk
# Tiempo de Generación: 2020-11-28 02:56:33 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla reservaciones
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reservaciones`;

CREATE TABLE `reservaciones` (
  `reservacionId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `proveedorId` smallint(5) unsigned DEFAULT NULL,
  `clienteId` smallint(5) unsigned NOT NULL,
  `reservacionServicio` char(3) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `reservacionDestino` char(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `reservacionHotel` char(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `reservacionPlan` char(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `reservacionCheckIn` date NOT NULL,
  `reservacionCheckOut` date NOT NULL,
  `reservacionHabitaciones` char(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `reservacionDetalle` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `reservacionCoste` decimal(6,2) unsigned DEFAULT NULL,
  `reservacionPrecio` decimal(6,2) unsigned DEFAULT NULL,
  `reservacionStatus` char(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`reservacionId`),
  KEY `reservaciones_clientes` (`clienteId`),
  KEY `reservaciones_proeveedores` (`proveedorId`),
  CONSTRAINT `reservaciones_clientes` FOREIGN KEY (`clienteId`) REFERENCES `clientes` (`clienteId`) ON UPDATE CASCADE,
  CONSTRAINT `reservaciones_proeveedores` FOREIGN KEY (`proveedorId`) REFERENCES `proveedores` (`proveedorId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

LOCK TABLES `reservaciones` WRITE;
/*!40000 ALTER TABLE `reservaciones` DISABLE KEYS */;

INSERT INTO `reservaciones` (`reservacionId`, `proveedorId`, `clienteId`, `reservacionServicio`, `reservacionDestino`, `reservacionHotel`, `reservacionPlan`, `reservacionCheckIn`, `reservacionCheckOut`, `reservacionHabitaciones`, `reservacionDetalle`, `reservacionCoste`, `reservacionPrecio`, `reservacionStatus`)
VALUES
	(2,1,1,'BUS','ACAPULCO','IBEROSTAR','EP','2020-12-18','2020-11-10','2','DETALLE TEST',100.00,200.00,'2'),
	(3,2,3,'PQ','ACAPULCO','IBEROSTAR','CD','2020-11-28','2020-11-30','2','TEST',400.00,500.00,'3');

/*!40000 ALTER TABLE `reservaciones` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
