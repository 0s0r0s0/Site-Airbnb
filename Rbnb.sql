-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           8.0.16 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour rbnb
CREATE DATABASE IF NOT EXISTS `rbnb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `rbnb`;

-- Listage de la structure de la table rbnb. equipements_rooms
CREATE TABLE IF NOT EXISTS `equipements_rooms` (
  `equipements_id` int(11) NOT NULL AUTO_INCREMENT,
  `rooms_id` int(11) NOT NULL,
  PRIMARY KEY (`equipements_id`,`rooms_id`),
  KEY `FK_equipements_rooms_rooms` (`rooms_id`),
  CONSTRAINT `FK_equipements_rooms_equipements_type` FOREIGN KEY (`equipements_id`) REFERENCES `equipements_type` (`id`),
  CONSTRAINT `FK_equipements_rooms_rooms` FOREIGN KEY (`rooms_id`) REFERENCES `rooms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table rbnb.equipements_rooms : ~0 rows (environ)
/*!40000 ALTER TABLE `equipements_rooms` DISABLE KEYS */;
INSERT INTO `equipements_rooms` (`equipements_id`, `rooms_id`) VALUES
	(2, 3),
	(3, 3),
	(11, 3);
/*!40000 ALTER TABLE `equipements_rooms` ENABLE KEYS */;

-- Listage de la structure de la table rbnb. equipements_type
CREATE TABLE IF NOT EXISTS `equipements_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table rbnb.equipements_type : ~8 rows (environ)
/*!40000 ALTER TABLE `equipements_type` DISABLE KEYS */;
INSERT INTO `equipements_type` (`id`, `label`) VALUES
	(1, 'Frigo'),
	(2, 'Machine à laver'),
	(3, 'Baignoire'),
	(4, 'Seche-linge'),
	(5, 'Aquarium'),
	(6, 'Vibro-masseur'),
	(7, 'Chaise électrique'),
	(8, 'Corde'),
	(9, 'AK-47'),
	(10, 'Tv cassée'),
	(11, 'Fontaine de Lasko');
/*!40000 ALTER TABLE `equipements_type` ENABLE KEYS */;

-- Listage de la structure de la table rbnb. reservation
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_rent` date NOT NULL,
  `end_rent` date NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `room_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_reservation_rooms` (`room_id`),
  KEY `FK_reservation_users` (`user_id`),
  CONSTRAINT `FK_reservation_rooms` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  CONSTRAINT `FK_reservation_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table rbnb.reservation : ~0 rows (environ)
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;

-- Listage de la structure de la table rbnb. roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(155) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table rbnb.roles : ~2 rows (environ)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `label`) VALUES
	(1, 'USER'),
	(2, 'RENTER');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Listage de la structure de la table rbnb. rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(150) NOT NULL,
  `country` varchar(150) NOT NULL DEFAULT '',
  `price` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL DEFAULT '0',
  `size` int(11) NOT NULL DEFAULT '0',
  `description` varchar(250) NOT NULL DEFAULT '0',
  `beds` int(11) NOT NULL DEFAULT '0',
  `rooms_owner` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_rooms_room_type` (`type_id`),
  KEY `FK_rooms_users` (`rooms_owner`),
  CONSTRAINT `FK_rooms_room_type` FOREIGN KEY (`type_id`) REFERENCES `room_type` (`id`),
  CONSTRAINT `FK_rooms_users` FOREIGN KEY (`rooms_owner`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table rbnb.rooms : ~1 rows (environ)
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` (`id`, `city`, `country`, `price`, `type_id`, `size`, `description`, `beds`, `rooms_owner`) VALUES
	(3, 'Zagreb', 'Hrvstka', 38, 2, 25, 'Chambre en plein coeur de Zagreb avec vue sur la magnifique cathédrale.', 1, 2);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;

-- Listage de la structure de la table rbnb. room_type
CREATE TABLE IF NOT EXISTS `room_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table rbnb.room_type : ~3 rows (environ)
/*!40000 ALTER TABLE `room_type` DISABLE KEYS */;
INSERT INTO `room_type` (`id`, `label`) VALUES
	(1, 'Logement entier'),
	(2, 'Chambre privée'),
	(3, 'Chambre partagée');
/*!40000 ALTER TABLE `room_type` ENABLE KEYS */;

-- Listage de la structure de la table rbnb. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `FK_users_roles` (`role_id`),
  CONSTRAINT `FK_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table rbnb.users : ~3 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `role_id`, `email`, `username`, `password`) VALUES
	(2, 2, 'master@mail.fr', 'master', 'cc9d142ef431487f6f3e67bf040384f038fb48d11f2d48eb794f31711d1553be3c00d01d64c3742134e94f8d29641e0e2403ae22c726630cbe891659a9783f8f'),
	(16, 1, 'renter@mail.fr', 'renter', 'cc9d142ef431487f6f3e67bf040384f038fb48d11f2d48eb794f31711d1553be3c00d01d64c3742134e94f8d29641e0e2403ae22c726630cbe891659a9783f8f');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
