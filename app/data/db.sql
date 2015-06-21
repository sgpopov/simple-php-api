# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.25)
# Database: simple_api
# Generation Time: 2015-06-21 18:43:50 +0000
# ************************************************************
# 
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `position` varchar(255) NOT NULL DEFAULT '',
  `description` tinytext NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;

INSERT INTO `jobs` (`id`, `position`, `description`, `created_on`)
VALUES
  (1,'position1','description1','2015-06-21 15:43:09'),
  (2,'position2','description2','2015-06-21 15:43:09'),
  (3,'position3','description3','2015-06-21 15:43:09'),
  (4,'position4','description4','2015-06-21 15:43:09'),
  (5,'position5','description5','2015-06-21 15:43:09'),
  (6,'position6','description6','2015-06-21 15:43:09'),
  (7,'position7','description7','2015-06-21 15:43:09');

/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `first_name` varchar(35) NOT NULL DEFAULT '',
  `last_name` varchar(35) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`)
VALUES
	(1,'et@aptent.com','Jonah','Atkins'),
	(2,'convallis.dolor@consectetuercursus.com','Chadwick','Guy'),
	(3,'arcu.imperdiet@velitduisemper.ca','Moses','Ramirez'),
	(4,'auctor.non@velitegestas.net','Wing','Workman'),
	(5,'sodales@ipsumac.com','Maisie','Vinson'),
	(6,'sociis.natoque.penatibus@lacusvariuset.org','Giacomo','Osborn'),
	(7,'ultrices.Duis@vitaerisus.com','Mikayla','Burris'),
	(8,'tristique@vestibulum.ca','Byron','Fuentes'),
	(9,'nunc@nequeSedeget.ca','Elton','Ware'),
	(10,'Donec.at.arcu@necquam.net','Danielle','Green');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table candidates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `candidates`;

CREATE TABLE `candidates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `job_id` int(11) unsigned NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `candidate_user` (`user_id`),
  KEY `candidate_job` (`job_id`),
  CONSTRAINT `candidate_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `candidate_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `candidates` WRITE;
/*!40000 ALTER TABLE `candidates` DISABLE KEYS */;

INSERT INTO `candidates` (`id`, `user_id`, `job_id`, `created_on`)
VALUES
  (1,4,6,'2015-06-21 15:48:04'),
  (2,8,3,'2015-06-21 15:48:04'),
  (3,6,2,'2015-06-21 15:48:04'),
  (6,1,6,'2015-06-21 15:48:04'),
  (7,6,5,'2015-06-21 15:48:04'),
  (8,4,4,'2015-06-21 15:48:04'),
  (9,9,1,'2015-06-21 15:48:04'),
  (10,7,1,'2015-06-21 15:48:04'),
  (11,1,1,'2015-06-21 15:48:04'),
  (13,5,7,'2015-06-21 15:48:04'),
  (14,10,2,'2015-06-21 15:48:04'),
  (17,3,6,'2015-06-21 15:48:04'),
  (19,2,6,'2015-06-21 15:48:04'),
  (20,5,3,'2015-06-21 15:48:04'),
  (21,1,4,'2015-06-21 15:48:04'),
  (22,4,5,'2015-06-21 15:48:04'),
  (24,10,1,'2015-06-21 15:48:04'),
  (25,4,3,'2015-06-21 15:48:04'),
  (27,2,3,'2015-06-21 15:48:04'),
  (28,8,6,'2015-06-21 15:48:04'),
  (29,8,1,'2015-06-21 15:48:04'),
  (30,3,7,'2015-06-21 15:48:04');

/*!40000 ALTER TABLE `candidates` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
