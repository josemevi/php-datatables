-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.14-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para proyectran
CREATE DATABASE IF NOT EXISTS `proyectran` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `proyectran`;

-- Volcando estructura para tabla proyectran.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `id_tcliente` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_clientes_id` (`id_tcliente`),
  CONSTRAINT `fk_clientes_id` FOREIGN KEY (`id_tcliente`) REFERENCES `tipo_clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;


-- Volcando estructura para tabla proyectran.tipo_clientes
CREATE TABLE IF NOT EXISTS `tipo_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tnombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla proyectran.tipo_clientes: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `tipo_clientes` DISABLE KEYS */;
INSERT INTO `tipo_clientes` (`id`, `tnombre`, `descripcion`) VALUES
	(1, 'Fijo', 'Cliente habitual'),
	(2, 'Invitado', 'Cliente de paso, normalmente no vuelve'),
	(3, 'VIP', 'Cliente con suscripcion');
/*!40000 ALTER TABLE `tipo_clientes` ENABLE KEYS */;

-- Volcando datos para la tabla proyectran.clientes: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `Nombre`, `Apellido`, `Direccion`, `id_tcliente`) VALUES
	(1, 'Jose David', 'Melian', 'Calle Sanson y Barrios', 2),
	(2, 'John', 'Water', 'Calle el fotografo', 3),
	(3, 'Airi', 'Satou', 'Calle Tokyo', 3),
	(4, 'sin nombre', 'ni apellido', 'sin calle', 3),
	(5, 'Yoo', 'Mira', 'Calle Seul', 1),
	(18, 'Brandon', 'Heaft', 'Beyong the Grave', 3);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
