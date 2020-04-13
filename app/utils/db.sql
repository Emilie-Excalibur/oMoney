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
(1,	'Admin',	'adminUser@gmail.com',	'$2y$10$hPLTKXOCoZiIy1CEpDA50uJBF.6pmHgKATSFlSzHEmLt1iCuI56aO',	'',	'2020-04-13 08:45:05'),
(2,	'testUser',	'testUser@gmail.com',	'$2y$10$fiYjcTcYenufcWjMpJpQ7u02Klgc1Izyo.xUwE/5aCbWUGVjyEbp2',	'',	'2020-04-01 08:45:24'),
(3,	'Emilie',	'emiliemaniglier@gmail.com',	'$2y$10$6tZct5jGiQCV2LAv9GQHQ.GiXDH7qk9c7JeA1vNyFvyjVgA3nhl9O',	'',	'2020-04-13 08:45:38'),
(4,	'Perceval',	'perceval@kaamelott.fr',	'$2y$10$BXtKRCmqCSnvEmo31Wa.XesuCi1JYNDUYWMO5Dhts8ivsqnefvQWK',	'',	'2020-04-02 08:46:12'),
(5,	'Perceval',	'provencallegallois@gmail.com',	'$2y$10$ruISctZ1SlURYfweDBX33OMtM50j3J1fPfNBYsrqM0AtgO8/rFyhm',	'',	'2020-04-02 08:46:31'),
(6,	'Arthur',	'arthur@kaamelott.fr',	'$2y$10$kiuLg5Ok2NXW7XVZwxOvTe3eti9YhsNra3L7lTS7niBSz290f4qpG',	'',	'2020-04-03 08:46:49'),
(7,	'Lancelot',	'lancelot@kaamelott.gmail',	'$2y$10$8.UPob/siFj6HKFykUvZtOdxBLyKZuj0SyNP9/zrZbTOXeTrh0i4K',	'',	'2020-04-03 08:47:07'),
(8,	'La panthère rose',	'lavieenrose@gmail.com',	'$2y$10$xnXxrVjKmWfO2mAEJ6VCVeP6ft4BvgxiSfwrYBbOPWERVksjh12m2',	'',	'2020-04-03 08:48:05');

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

-- 2020-04-13 08:48:30