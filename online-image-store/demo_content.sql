-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2016 at 07:21 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `w208`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `profile_id` int(11) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `user_id` (`user_id`) USING BTREE,
  UNIQUE KEY `profile_id` (`profile_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `user_id`, `profile_id`, `balance`) VALUES
(2, 7, 4, 122),
(3, 9, 5, 10),
(4, 10, 6, 9);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `photo_id` (`photo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `photo_id`) VALUES
(1, 7, 243),
(2, 7, 243),
(3, 7, 250),
(4, 7, 245),
(5, 10, 248);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `watermarked_url` varchar(120) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `title` varchar(120) DEFAULT NULL,
  `tags` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`photo_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`photo_id`, `user_id`, `watermarked_url`, `photo_url`, `title`, `tags`) VALUES
(241, 7, 'uploads/watermarked/1466661919noneill/photo-1428790067070-0ebf4418d9d8.jpg', 'uploads/vault/1466661919noneill/photo-1428790067070-0ebf4418d9d8.jpg', 'Dancer', 'dance, shoes, street, urban, buildings, run, runner'),
(242, 7, 'uploads/watermarked/1466661922noneill/photo-1440557653082-e8e186733eeb.jpg', 'uploads/vault/1466661922noneill/photo-1440557653082-e8e186733eeb.jpg', 'The Great Bush', 'Trees, sunrise, sun, forest, mountains, sky, blue sky'),
(243, 7, 'uploads/watermarked/1466661931noneill/photo-1442606440995-d0be22c5f90f.jpg', 'uploads/vault/1466661931noneill/photo-1442606440995-d0be22c5f90f.jpg', 'Mountain Range', 'sky, clouds, mountains, mountain range, mist, blue sky'),
(245, 7, 'uploads/watermarked/1466661939noneill/photo-1450101215322-bf5cd27642fc.jpg', 'uploads/vault/1466661939noneill/photo-1450101215322-bf5cd27642fc.jpg', 'Cloudy Mountains', 'mountains, cloudy, dark clouds, green, green mountains'),
(246, 7, 'uploads/watermarked/1466661942noneill/photo-1451186859696-371d9477be93.jpg', 'uploads/vault/1466661942noneill/photo-1451186859696-371d9477be93.jpg', 'Ocean From Above', 'ocean, Arial, blue, above '),
(247, 7, 'uploads/watermarked/1466661947noneill/photo-1452716726610-30ed68426a6b.jpg', 'uploads/vault/1466661947noneill/photo-1452716726610-30ed68426a6b.jpg', 'Grey Mist', 'forest, mist, trees, grey, black, white, fog'),
(248, 7, 'uploads/watermarked/1466661948noneill/photo-1452800185063-6db5e12b8e2e.jpg', 'uploads/vault/1466661948noneill/photo-1452800185063-6db5e12b8e2e.jpg', 'Aurora Green', 'green, aurora, lights, tree, night'),
(249, 7, 'uploads/watermarked/1466661959noneill/photo-1454982523318-4b6396f39d3a.jpg', 'uploads/vault/1466661959noneill/photo-1454982523318-4b6396f39d3a.jpg', 'Grand Mountains', 'mountains, trees, river, dirt, sky, green, blue'),
(250, 7, 'uploads/watermarked/1467001813noneill/photo-1449057528837-7ca097b3520c.jpg', 'uploads/vault/1467001813noneill/photo-1449057528837-7ca097b3520c.jpg', 'Irish Country', 'lake, mountains, sky, rocky, clouds'),
(255, 7, 'uploads/watermarked/1467437072noneill/de4f1975.jpg', 'uploads/vault/1467437072noneill/de4f1975.jpg', 'Grand Canyon', 'rocks, rocky, mountains, sky, desert, canyon'),
(256, 7, 'uploads/watermarked/1467437076noneill/photo-1431576901776-e539bd916ba2.jpg', 'uploads/vault/1467437076noneill/photo-1431576901776-e539bd916ba2.jpg', 'Commercial Sky', 'buildings, orange, glass, glass buildings, buildings'),
(258, 7, 'uploads/watermarked/1467437086noneill/photo-1445998559126-132150395033.jpg', 'uploads/vault/1467437086noneill/photo-1445998559126-132150395033.jpg', 'Autumn ', 'leaves, river, trees, autumn, forest'),
(259, 7, 'uploads/watermarked/1467437091noneill/photo-1447998126397-d613189e9768.jpg', 'uploads/vault/1467437091noneill/photo-1447998126397-d613189e9768.jpg', 'Country Side', 'country, blue sky, clouds, river, mountains, blue, green'),
(260, 7, 'uploads/watermarked/1467437108noneill/photo-1449034446853-66c86144b0ad.jpg', 'uploads/vault/1467437108noneill/photo-1449034446853-66c86144b0ad.jpg', 'San Francisco Bridge', 'bridge, water, san francisco, blue, sky, clouds'),
(261, 9, 'uploads/watermarked/1467642229admin/photo-1448318440207-ef1893eb8ac0.jpg', 'uploads/vault/1467642229admin/photo-1448318440207-ef1893eb8ac0.jpg', NULL, NULL),
(262, 9, 'uploads/watermarked/1467642238admin/photo-1455741221562-726825b9cb2b.jpg', 'uploads/vault/1467642238admin/photo-1455741221562-726825b9cb2b.jpg', NULL, NULL),
(263, 10, 'uploads/watermarked/1467687195demo/photo-1428976365951-b70e0fa5c551.jpg', 'uploads/vault/1467687195demo/photo-1428976365951-b70e0fa5c551.jpg', 'Building', 'building, sky, brick, art'),
(264, 10, 'uploads/watermarked/1467687203demo/photo-1452709552142-2dec6eb01a9e.jpg', 'uploads/vault/1467687203demo/photo-1452709552142-2dec6eb01a9e.jpg', 'Lady in the Woods', 'lady, woods, snow, trees, forest, hat, hair');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(70) DEFAULT NULL,
  `details` varchar(70) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`profile_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `user_id`, `username`, `details`, `description`) VALUES
(4, 7, 'noneill', 'Web Developer', 'I am skilled in HTML5, CSS3, PHP, JavaScript, jQuery, MySQL & Photoshop while ever learning new technology!'),
(5, 9, 'admin', 'The Demo Admin', 'Sharp, cool, calm & collective!'),
(6, 10, 'demo', 'Demo Guy', 'Im the demo guy!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `useremail` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  `session_id` varchar(60) DEFAULT NULL,
  `user_role` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `useremail`, `password`, `session_id`, `user_role`) VALUES
(7, 'noneill', 'nick@maximizedpotential.co.nz', '$2y$10$kh2RdBdk.w1G9aHPWOE1tezsekR9pLhsf7UJe7E/X7NLMVe05djeW', NULL, 99),
(9, 'admin', 'demoadmin@gmail.com', '$2y$10$QN/RJP5e.D2OxSS.JqOkb.qbRt5q9w.WTUcsfSvnZusWk8ORfQp6S', NULL, 0),
(10, 'demo', 'demo@gmail.com', '$2y$10$7I9bmTylFZaaKb5DDQnRh.50IRGY/PC2jwbc4UaVr85ya.scSnkoO', NULL, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `account_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`photo_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
