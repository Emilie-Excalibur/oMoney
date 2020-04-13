-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `oMoney`;
CREATE DATABASE `oMoney` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `oMoney`;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du journal de dépenses',
  `user_id` int(10) unsigned NOT NULL COMMENT 'identifiant de l''utilisateur',
  `balance` float(10,2) NOT NULL COMMENT 'Solde de l''utilisateur',
  `date` date DEFAULT NULL COMMENT 'Date du retrait d''argent',
  `title` varchar(255) DEFAULT NULL COMMENT 'Intitulé du retrait',
  `sum` float(10,2) NOT NULL COMMENT 'Somme dépensée',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `account` (`id`, `user_id`, `balance`, `date`, `title`, `sum`) VALUES
(1,	9,	890.12,	'2020-02-14',	'Fleur pour Guenièvre',	35.80),
(2,	4,	1350.00,	'2020-03-07',	'Sangliers de Cornouailles',	75.99),
(3,	4,	1274.01,	'2020-04-07',	'Herbes de provence',	4.50),
(4,	4,	1269.51,	'2020-04-07',	'Fromages à raclette',	21.70),
(5,	4,	1247.81,	'2020-04-12',	'Appareil à raclette',	43.99),
(6,	4,	1203.82,	'2020-04-13',	'Epée bien affûtée',	142.80),
(7,	7,	15642.00,	'2019-12-25',	'Cadeaux noël pour tout le monde',	345.12),
(8,	7,	15296.88,	'2020-04-12',	'Nouvelle cape',	17.99),
(9,	2,	1650.00,	'2020-04-03',	'Casque Logitech',	69.99),
(10,	8,	8760.00,	'2020-03-02',	'Viande grasse',	27.60),
(11,	8,	8732.40,	'2020-03-15',	'remise d\"aujourdhui',	6.40),
(12,	6,	4512.00,	'2020-03-26',	'choux-fleur',	3.50),
(13,	6,	4508.50,	'2020-03-06',	'Livre c\'est la vie',	25.99);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id de l''utilisateur',
  `name` varchar(20) NOT NULL COMMENT 'Nom de l''utilisateur',
  `email` varchar(150) NOT NULL COMMENT 'Email de l''utilisateur',
  `password` varchar(150) NOT NULL COMMENT 'Mot de passe de l''utilisateur',
  `picture` varchar(255) DEFAULT NULL COMMENT 'Avatar de l''utilisateur',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de création du compte',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `picture`, `created_at`) VALUES
(1,	'Admin',	'adminUser@gmail.com',	'$2y$10$MRA3M8KJR.LltD/gBwFyAeBdFxbFkBAKjm6Gftl3/tcp5aBoGjR4e',	'',	'2020-04-13 13:23:40'),
(2,	'testUser',	'testUser@gmail.com',	'$2y$10$ctsebLcaaIDyK.jgubjjxegl8YvRnjEser0Zc88O9ajnYftfZblra',	'',	'2020-04-13 13:36:57'),
(3,	'Emilie',	'emiliemaniglier@gmail.com',	'$2y$10$zYc7oo27hjkCEXudRJ1J1uPlLkD/cH1cq8t.R38KXPAnD40hfKgmG',	'',	'2020-04-13 13:37:14'),
(4,	'Perceval',	'perceval@kaamelott.fr',	'$2y$10$i4.HepFKCBNpYxV43XgYheSZY/0dQGPn3yJC6VPZmakPAKizHU9ne',	'',	'2020-04-13 13:37:41'),
(6,	'Perceval',	'provencalLeGallois@kaamelott.fr',	'$2y$10$eb2Q7Js.hcqq73HbBPRGnehbNmPpzsyjWrJlAcLGDUATvr/fD7Qti',	'',	'2020-04-13 13:38:50'),
(7,	'Arthur',	'arthur@kaamelott.fr',	'$2y$10$H8vwmnq2rZUhvCmhdxWWWuC98h61G/hgbAl6RkTkwiqmhKhtYj86a',	'',	'2020-04-13 13:39:07'),
(8,	'Karadoc',	'karadoc@kaamelott.fr',	'$2y$10$FKNziRmjFEhBXvUGCO8gIeGECGxTO1RUORossaJzOlrjtHD6wFypy',	'',	'2020-04-13 13:39:41'),
(9,	'Lancelot',	'lancelot@kaamelott.gmail',	'$2y$10$K9xVB1.5R5/TpIIxbbj89eGuSudIGGoVcxJ2AH8rp6xkV9TuzjMYW',	'',	'2020-04-13 13:40:17'),
(10,	'Merlin',	'magicien@kaamelott.fr',	'$2y$10$pc8Scr9Ojb3iOA1UnRLQdeZ8iyN1yODgHAMejvKww4RrJBJ3UlP7W',	'',	'2020-04-13 14:28:51');

DROP TABLE IF EXISTS `user_picture_color`;
CREATE TABLE `user_picture_color` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `color_name` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_picture_color` (`id`, `color_name`) VALUES
(1,	'aliceblue'),
(2,	'antiquewhite'),
(3,	'aqua'),
(4,	'aquamarine'),
(5,	'azure'),
(6,	'beige'),
(7,	'bisque'),
(8,	'blanchedalmond'),
(9,	'blue'),
(10,	'blueviolet'),
(11,	'brown'),
(12,	'coral'),
(13,	'cornflowerblue'),
(14,	'cornsilk'),
(15,	'crimson'),
(16,	'cyan'),
(17,	'darkblue'),
(18,	'darkcyan'),
(19,	'darkgoldenrod'),
(20,	'darkgray'),
(21,	'darkgreen'),
(22,	'darkmagenta'),
(23,	'darkorange'),
(24,	'darkorchid'),
(25,	'darkred'),
(26,	'darksalmon'),
(27,	'darkseagreen'),
(28,	'darkslateblue'),
(29,	'darkslategray'),
(30,	'darkslategrey'),
(31,	'darkturquoise'),
(32,	'darkviolet'),
(33,	'deeppink'),
(34,	'deepskyblue'),
(35,	'dodgerblue'),
(36,	'firebrick'),
(37,	'floralwhite'),
(38,	'forestgreen'),
(39,	'fuchsia'),
(40,	'gainsboro'),
(41,	'ghostwhite'),
(42,	'gold'),
(43,	'goldenrod'),
(44,	'green'),
(45,	'greenyellow'),
(46,	'hotpink'),
(47,	'indianred'),
(48,	'indigo'),
(49,	'lavender'),
(50,	'lavenderblush'),
(51,	'lemonchiffon'),
(52,	'lightblue'),
(53,	'lightcoral'),
(54,	'lightcyan'),
(55,	'lightgreen'),
(56,	'lightpink'),
(57,	'lightsalmon'),
(58,	'lightskyblue'),
(59,	'lightsteelblue'),
(60,	'linen'),
(61,	'mediumorchid'),
(62,	'mediumpurple'),
(63,	'mediumseagreen'),
(64,	'mediumslateblue'),
(65,	'mediumspringgreen'),
(66,	'mediumturquoise'),
(67,	'mediumvioletred'),
(68,	'midnightblue'),
(69,	'mintcream'),
(70,	'mistyrose'),
(71,	'moccasin'),
(72,	'navy'),
(73,	'orange'),
(74,	'orchid'),
(75,	'palevioletred'),
(76,	'peachpuff'),
(77,	'peru'),
(78,	'plum'),
(79,	'powderblue'),
(80,	'purple'),
(81,	'rosybrown'),
(82,	'royalblue'),
(83,	'salmon'),
(84,	'seagreen'),
(85,	'silver'),
(86,	'skyblue'),
(87,	'slateblue'),
(88,	'slategray'),
(89,	'steelblue'),
(90,	'teal'),
(91,	'thistle'),
(92,	'tomato'),
(93,	'yellowgreen');

-- 2020-04-13 14:34:55