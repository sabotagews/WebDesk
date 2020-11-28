# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.5.8-MariaDB)
# Database: turismosalo_webdesk
# Generation Time: 2020-11-28 03:18:26 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table catalogoBancos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `catalogoBancos`;

CREATE TABLE `catalogoBancos` (
  `bancoId` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `bancoClave` char(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `bancoNombre` char(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`bancoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

LOCK TABLES `catalogoBancos` WRITE;
/*!40000 ALTER TABLE `catalogoBancos` DISABLE KEYS */;

INSERT INTO `catalogoBancos` (`bancoId`, `bancoClave`, `bancoNombre`)
VALUES
	(1,'BBVA','Bancomer'),
	(2,'BX','Banamex'),
	(3,'BTE','Banorte');

/*!40000 ALTER TABLE `catalogoBancos` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table clientes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `clienteId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `clienteNombre` char(100) DEFAULT '',
  `clienteApellido` char(100) DEFAULT NULL,
  `clienteEmail` char(100) DEFAULT NULL,
  `clienteMovil` char(100) DEFAULT NULL,
  `clienteDomicilio` char(255) DEFAULT NULL,
  `clienteFechaNacimiento` date DEFAULT NULL,
  PRIMARY KEY (`clienteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;

INSERT INTO `clientes` (`clienteId`, `clienteNombre`, `clienteApellido`, `clienteEmail`, `clienteMovil`, `clienteDomicilio`, `clienteFechaNacimiento`)
VALUES
	(1,'CARLOS','RODRIGUEZ','carlos@hotmail.com','4773636390',NULL,NULL),
	(2,'ANGELICA','ROMAN','angelica@gmail.com','4773609289','PASEO DE LOS COLIBRIES','2020-11-01'),
	(3,'ERNESTO','MOLINA','ernesto@yahoo.com','4772989098',NULL,NULL);

/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cuentas
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


# Dump of table proveedorCuentas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `proveedorCuentas`;

CREATE TABLE `proveedorCuentas` (
  `proveedorCuentaId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `proveedorId` smallint(5) unsigned NOT NULL,
  `bancoId` tinyint(3) unsigned DEFAULT NULL,
  `proveedorCuentaAlias` char(25) COLLATE utf8_spanish_ci NOT NULL,
  `proveedorCuentaNumero` char(30) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`proveedorCuentaId`),
  KEY `proveedorCuentas_catalogoBancos` (`bancoId`),
  KEY `proveedorCuentas_proveedores` (`proveedorId`),
  CONSTRAINT `proveedorCuentas_catalogoBancos` FOREIGN KEY (`bancoId`) REFERENCES `catalogoBancos` (`bancoId`) ON UPDATE CASCADE,
  CONSTRAINT `proveedorCuentas_proveedores` FOREIGN KEY (`proveedorId`) REFERENCES `proveedores` (`proveedorId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

LOCK TABLES `proveedorCuentas` WRITE;
/*!40000 ALTER TABLE `proveedorCuentas` DISABLE KEYS */;

INSERT INTO `proveedorCuentas` (`proveedorCuentaId`, `proveedorId`, `bancoId`, `proveedorCuentaAlias`, `proveedorCuentaNumero`)
VALUES
	(1,1,NULL,'BBVA DEBITO','13572468'),
	(2,1,NULL,'BX CHEQUES','24681357');

/*!40000 ALTER TABLE `proveedorCuentas` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table proveedores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `proveedores`;

CREATE TABLE `proveedores` (
  `proveedorId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `proveedorRazonSocial` char(150) NOT NULL DEFAULT '',
  `proveedorAlias` char(50) NOT NULL DEFAULT '',
  `proveedorDomicilio` char(150) NOT NULL DEFAULT '',
  `proveedorEmail` char(50) NOT NULL DEFAULT '',
  `proveedorTelefono` char(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`proveedorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;

INSERT INTO `proveedores` (`proveedorId`, `proveedorRazonSocial`, `proveedorAlias`, `proveedorDomicilio`, `proveedorEmail`, `proveedorTelefono`)
VALUES
	(1,'NATURLEON S.A. DE C.V.','NATURLEON','VALLE DE OAXACA 211, VALLE DEL CAMPESTRE','ayuda@naturleon.com','4776373250'),
	(2,'RECORD VACATION','RECORD','PASEO DE LOS COLIBRIES','record@hotmail.com','4777234521');

/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table reservaciones
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


# Dump of table sucursales
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sucursales`;

CREATE TABLE `sucursales` (
  `sucursalId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sucursalNombre` char(255) NOT NULL DEFAULT '',
  `sucursalDomicilio` char(255) NOT NULL DEFAULT '',
  `sucursalTelefono` char(255) NOT NULL DEFAULT '',
  `sucursalEmail` char(255) NOT NULL DEFAULT '',
  `sucursalStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`sucursalId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `sucursales` WRITE;
/*!40000 ALTER TABLE `sucursales` DISABLE KEYS */;

INSERT INTO `sucursales` (`sucursalId`, `sucursalNombre`, `sucursalDomicilio`, `sucursalTelefono`, `sucursalEmail`, `sucursalStatus`)
VALUES
	(1,'AGUASCALIENTES','EL DOMICILIO','4776373250','manuel@sucursal.com',1),
	(3,'LEON','MI DOMICILIO','4776373251','manuel@sucursal.com.mx',0);

/*!40000 ALTER TABLE `sucursales` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table usuarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `usuarioId` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `usuarioNombre` char(255) DEFAULT NULL,
  `usuarioApellido` char(255) DEFAULT NULL,
  `usuarioUsername` char(255) DEFAULT NULL,
  `usuarioPassword` char(6) DEFAULT NULL,
  `usuarioEmail` char(255) DEFAULT NULL,
  `usuarioMovil` char(255) DEFAULT NULL,
  `usuarioStatus` tinyint(1) DEFAULT NULL,
  `usuarioRol` char(1) DEFAULT NULL,
  PRIMARY KEY (`usuarioId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;

INSERT INTO `usuarios` (`usuarioId`, `usuarioNombre`, `usuarioApellido`, `usuarioUsername`, `usuarioPassword`, `usuarioEmail`, `usuarioMovil`, `usuarioStatus`, `usuarioRol`)
VALUES
	(1,'MANUEL','BALLEZA','AIRWALK','MEXICO','test@quattro.ws','4774049649',1,'A'),
	(2,'SABO','BALLEZA','SABOBALLEZA','180810','sabo@sabotage.ws','4775777372',1,'A');

/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
