SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `oMoney`;
CREATE DATABASE `oMoney` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `oMoney`;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE `expenses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du journal de dépenses',
  `balance` float(10,2) NOT NULL COMMENT 'Solde de l''utilisateur',
  `daily` float(10,2) unsigned DEFAULT NULL COMMENT 'Dépenses du jour',
  `yesterday` float(10,2) unsigned DEFAULT NULL COMMENT 'Dépenses de la veille',
  `weekly` float(10,2) unsigned DEFAULT NULL COMMENT 'Dépenses de la semaine',
  `monthly` float(10,2) unsigned DEFAULT NULL COMMENT 'Dépenses du mois',
  `user_id` int(10) unsigned NOT NULL COMMENT 'identifiant de l''utilisateur',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id de l''utilisateur',
  `name` varchar(20) NOT NULL COMMENT 'Nom de l''utilisateur',
  `email` varchar(150) NOT NULL COMMENT 'Email de l''utilisateur',
  `password` varchar(150) NOT NULL COMMENT 'Mot de passe de l''utilisateur',
  `picture` varchar(255) DEFAULT NULL COMMENT 'Avatar de l''utilisateur',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2020-04-11 22:19:56