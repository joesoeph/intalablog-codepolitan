/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

DROP DATABASE IF EXISTS `intalablog_db`;
CREATE DATABASE IF NOT EXISTS `intalablog_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `intalablog_db`;

DROP TABLE IF EXISTS `awards`;
CREATE TABLE IF NOT EXISTS `awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

DELETE FROM `awards`;
/*!40000 ALTER TABLE `awards` DISABLE KEYS */;
INSERT INTO `awards` (`id`, `name`, `description`) VALUES
	(1, 'PHP Programming Language', 'Complete learning programming at Codepolitan'),
	(4, 'Codeigniter Framework', 'Complete learning Codeigniter Framwork at Codepolitan');
/*!40000 ALTER TABLE `awards` ENABLE KEYS */;

DROP TABLE IF EXISTS `educations`;
CREATE TABLE IF NOT EXISTS `educations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `place` varchar(150) NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

DELETE FROM `educations`;
/*!40000 ALTER TABLE `educations` DISABLE KEYS */;
INSERT INTO `educations` (`id`, `name`, `place`, `date_start`, `date_end`, `description`) VALUES
	(1, 'Web Development', 'Codepolitan', '2020-09-20', '2020-10-20', NULL);
/*!40000 ALTER TABLE `educations` ENABLE KEYS */;

DROP TABLE IF EXISTS `experiences`;
CREATE TABLE IF NOT EXISTS `experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `place` varchar(150) NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

DELETE FROM `experiences`;
/*!40000 ALTER TABLE `experiences` DISABLE KEYS */;
INSERT INTO `experiences` (`id`, `name`, `place`, `date_start`, `date_end`, `description`) VALUES
	(2, 'Mentor', 'Codepolitan', '2012-06-06', '2012-06-06', 'Mentor / Instructor Codepolitan'),
	(7, 'Web Programmer', 'Codepolitan', '2020-12-13', '2020-12-15', 'Web Programmer Codepolitan');
/*!40000 ALTER TABLE `experiences` ENABLE KEYS */;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `picture` varchar(150) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `published_at` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

DELETE FROM `posts`;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `title`, `picture`, `content`, `user_id`, `published_at`) VALUES
	(2, 'How to write better code', '1600625165.Cover_1.png', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', 1, NULL),
	(14, 'Explain in Codepolitan is easy to understand!', NULL, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', 1, '2020-09-21');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

DELETE FROM `skills`;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` (`id`, `name`, `description`) VALUES
	(1, 'PHP', 'Advanced PHP concept like OOP and using framework'),
	(3, 'CSS', 'Styling web page with CSS'),
	(4, 'HTML 5', 'Create many website using standard HTML 5'),
	(5, 'Codeigniter ', 'Build better website with easy maintenance using Codeigniter PHP Framework');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `fullname` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `linkedin_url` varchar(150) DEFAULT NULL,
  `facebook_url` varchar(150) DEFAULT NULL,
  `github_url` varchar(150) DEFAULT NULL,
  `picture` varchar(150) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `interest` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `address`, `email`, `phone`, `linkedin_url`, `facebook_url`, `github_url`, `picture`, `about`, `interest`) VALUES
	(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Yusuf Fazeri', 'Belly Street - Cijantung, East Jakarta', 'me@yusufdevcode.com', '081287026771', '', '', '', '1600645985.0.jpg', 'Saya berpengalaman dan profesional dalam membuat aplikasi berbasis web.', 'Selain suka ngoding dan belajar di codepolitan, saya sangat suka traveling, dan bersepeda');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
