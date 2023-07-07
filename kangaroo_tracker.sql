-- Adminer 4.8.1 MySQL 8.0.33-0ubuntu0.22.04.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `kangaroo_tracker` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `kangaroo_tracker`;

DROP TABLE IF EXISTS `kangaroos`;
CREATE TABLE `kangaroos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `weight` double NOT NULL,
  `height` double NOT NULL,
  `gender` text NOT NULL,
  `color` text,
  `friendliness` text,
  `birthday` date NOT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `kangaroos` (`id`, `name`, `nickname`, `weight`, `height`, `gender`, `color`, `friendliness`, `birthday`, `created_at`, `updated_at`) VALUES
(1,	'Kangaroo1',	'kang1',	34.59,	5.5,	'Male',	'White',	'Not Friendly',	'2019-09-09',	'2023-07-07 22:50:04',	'2023-07-07 14:50:04'),
(2,	'Kangaroo2',	'kan2',	12.3,	12,	'Female',	'Black',	NULL,	'2023-06-25',	'2023-07-07 21:53:07',	'2023-07-07 13:53:07'),
(3,	'Kangaroo3',	NULL,	2,	0.31,	'Male',	NULL,	'Friendly',	'2023-07-06',	'2023-07-07 21:53:17',	'2023-07-07 13:53:17'),
(4,	'Kangaroo4',	NULL,	1.2,	0.2,	'Female',	'Grey',	NULL,	'2023-07-11',	'2023-07-07 21:53:28',	'2023-07-07 13:53:28'),
(5,	'Kangaroo5',	NULL,	0.5,	0.34,	'Female',	'White',	'Friendly',	'2023-06-25',	'2023-07-07 21:53:36',	'2023-07-07 13:53:36'),
(6,	'Kangaroo6',	'kang6',	10.19,	34,	'Female',	'Black',	'Not Friendly',	'2023-07-03',	'2023-07-07 21:53:44',	'2023-07-07 13:53:44'),
(7,	'Kangaroo7',	'kang7',	0.69,	65,	'Male',	'Blonde',	'Not Friendly',	'2023-06-26',	'2023-07-07 21:53:54',	'2023-07-07 13:53:54'),
(8,	'Kangaroo8',	'kang8',	0.67,	78,	'Female',	NULL,	'Friendly',	'2023-05-28',	'2023-07-07 21:54:06',	'2023-07-07 13:54:06'),
(9,	'Kangaroo9',	'kang9',	1.5,	78,	'Male',	'Black',	'Friendly',	'2023-06-25',	'2023-07-07 05:07:01',	'2023-07-07 05:07:01'),
(10,	'Kangaroo10',	'kang10',	2,	98,	'Female',	NULL,	'Not Friendly',	'2023-06-14',	'2023-07-07 20:11:46',	'2023-07-07 12:11:46'),
(11,	'Charlie',	NULL,	2.29,	45,	'Female',	'Grey',	'Not Friendly',	'2023-07-18',	'2023-07-07 21:54:13',	'2023-07-07 13:54:13'),
(12,	'Kangaroo12',	NULL,	0.6,	23,	'Female',	NULL,	'Friendly',	'2023-06-29',	'2023-07-07 21:54:20',	'2023-07-07 13:54:20'),
(13,	'Chumps',	'Hopper',	1.53,	87,	'Male',	'Black',	'Friendly',	'2023-07-06',	'2023-07-07 21:54:27',	'2023-07-07 13:54:27'),
(14,	'Kangaroo15',	'kang15',	0.89,	34,	'Female',	NULL,	NULL,	'2023-07-04',	'2023-07-07 21:54:34',	'2023-07-07 13:54:34'),
(15,	'Kangaroo16',	'kang16',	0.8,	30,	'Male',	NULL,	NULL,	'2023-07-04',	'2023-07-07 21:54:41',	'2023-07-07 13:54:41'),
(16,	'Kangaroo17',	'Kang17',	0.6,	65,	'Female',	'Grey',	'Friendly',	'2023-07-06',	'2023-07-07 21:54:51',	'2023-07-07 13:54:51'),
(17,	'Kangaroo18',	'Kang18',	1.29,	45,	'Male',	NULL,	NULL,	'2023-07-03',	'2023-07-07 21:55:01',	'2023-07-07 13:55:01'),
(18,	'Kangaroo19',	'Kang19',	1.2,	47,	'Male',	'Bleach',	'Friendly',	'2023-07-04',	'2023-07-07 21:55:10',	'2023-07-07 13:55:10'),
(19,	'Kangaroo20',	'kang20',	2.5,	89,	'Female',	NULL,	NULL,	'2023-07-11',	'2023-07-07 14:21:35',	'2023-07-07 14:21:35'),
(20,	'Red',	'Crimson',	78,	90,	'Male',	'Reddish',	'Not Friendly',	'2020-02-14',	'2023-07-07 14:38:47',	'2023-07-07 14:38:47'),
(21,	'Moonlight',	NULL,	50,	78,	'Female',	'Grey',	'Friendly',	'2022-10-19',	'2023-07-07 14:40:00',	'2023-07-07 14:40:00');

-- 2023-07-07 15:31:44
