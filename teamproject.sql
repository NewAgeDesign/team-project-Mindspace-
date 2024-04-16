-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 16, 2024 at 01:03 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teamproject`
--

DROP DATABASE IF EXISTS `teamproject`;
CREATE DATABASE IF NOT EXISTS `teamproject`;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `senderid` int DEFAULT NULL,
  `receiverid` int DEFAULT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=unread , 1= read',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `senderid`, `receiverid`, `message`, `status`, `date_created`) VALUES
(76, 6, 7, 'Hey Timothy, how\\\'s it going?', 0, '2024-04-14 17:05:01'),
(77, 6, 7, 'Hey Timothy, how\\\'s it going?', 0, '2024-04-14 17:06:21'),
(78, 7, 6, 'You\\\'re Timothy, I\\\'m James', 0, '2024-04-14 17:08:09'),
(79, 6, 7, 'hmm', 0, '2024-04-14 18:35:58'),
(80, 6, 7, 'ey', 0, '2024-04-14 19:03:28'),
(81, 6, 7, 'So it was basically useless', 0, '2024-04-14 19:03:54'),
(82, 6, 6, 'Hey', 0, '2024-04-14 23:57:26'),
(83, 6, 6, 'Test two, second message', 0, '2024-04-14 23:57:43'),
(84, 6, 6, 'Test two, second message', 0, '2024-04-14 23:57:57'),
(85, 8, 6, 'Hey Tim', 0, '2024-04-15 09:57:58'),
(86, 7, 8, 'Lets try my end', 0, '2024-04-15 09:58:44'),
(87, 8, 7, 'Oy', 0, '2024-04-15 10:42:24'),
(88, 8, 7, 'Oy', 0, '2024-04-15 15:56:24'),
(89, 8, 7, 'Oy', 0, '2024-04-15 15:59:29'),
(90, 8, 7, 'Oy', 0, '2024-04-15 15:59:57'),
(91, 8, 7, 'Oy', 0, '2024-04-15 16:09:41'),
(92, 8, 7, 'Hey James, This is my first message', 0, '2024-04-15 16:09:47');

-- --------------------------------------------------------

--
-- Table structure for table `pswreset`
--

DROP TABLE IF EXISTS `pswreset`;
CREATE TABLE IF NOT EXISTS `pswreset` (
  `rid` int NOT NULL AUTO_INCREMENT,
  `remail` text NOT NULL,
  `rselector` text NOT NULL,
  `rtoken` longtext NOT NULL,
  `rexpire` text NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

DROP TABLE IF EXISTS `thread`;
CREATE TABLE IF NOT EXISTS `thread` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_ids` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `fname` text,
  `username` varchar(200) NOT NULL,
  `psw` text,
  `role` varchar(255) NOT NULL DEFAULT 'client',
  `avatar` varchar(255) NOT NULL DEFAULT 'default.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `fname`, `username`, `psw`, `role`, `avatar`) VALUES
(6, 'tawinia6@gmail.com', 'Timothy Christopher Awinia ', 'MasterT', '$2y$10$e2OkS6l94c5g.MF6/o4MDuUpv4RxuJDE9nRHc3Ru9/Xer.rjOQaOm', 'client', 'profile/mindspace-MasterT-2024-04-15-06-00-05.jpg'),
(7, 'tawinia@kabarak.ac.ke', 'James Blunt', 'JamesBlunt', '$2y$10$cmpz1x492v3gAnooQtSC6.D3AN5xhzPQu4FoR.4DlZtW2DR7kpZXi', 'client', 'profile/mindspace-JamesBlunt-2024-04-15-06-01-22.jpg'),
(8, 'sigeilinda3@gmail.com', 'Linda Sigei', 'lsigei', '$2y$10$C5iDqy6SjnyxVB6cYk8lGOvn5CMwWDOzDwLwHi.pNHSwQ9lV77Dnm', 'client', 'profile/mindspace-lsigei-2024-04-15-06-57-14.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
