-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 18, 2024 at 09:48 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fdc-genesis`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `receiver`, `content`, `date`) VALUES
(7, 3, 5, 'fadfasdf', '2024-04-14 14:24:58'),
(47, 3, 4, 'wraFWa', '2024-04-15 13:50:00'),
(48, 3, 4, 'qDqda', '2024-04-15 13:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `hobby` varchar(255) DEFAULT NULL,
  `img_name` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `joined_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `gender`, `birthdate`, `hobby`, `img_name`, `last_login`, `joined_date`) VALUES
(3, 'Eirazen Troy', 'asterdaeira@gmail.com', '1dad2ebaaf68468105b6af9ab7ad15033a33a462', 'm', '1996-11-21', 'Aaweaew', '320240413165247.jpg', '2024-04-15 13:09:48', '2024-04-12 19:43:18'),
(4, 'Throy Towercamp', 'tgenesistroy@gmail.com', '1dad2ebaaf68468105b6af9ab7ad15033a33a462', 'm', '1996-11-21', 'Haefafasfasf', '420240413165857.jpg', '2024-04-15 09:09:05', '2024-04-13 16:57:57'),
(5, 'Troy Tower', 'troytower112196@gmail.com', '1dad2ebaaf68468105b6af9ab7ad15033a33a462', NULL, NULL, NULL, NULL, '2024-04-14 15:38:47', '2024-04-14 07:38:44'),
(6, 'Monique Erezo', 'genesistroy.fdc@gmail.com', '1dad2ebaaf68468105b6af9ab7ad15033a33a462', NULL, NULL, NULL, NULL, '2024-04-18 14:09:56', '2024-04-18 14:09:49'),
(7, 'Throy Eira', 'asterda@gmail.com', '1dad2ebaaf68468105b6af9ab7ad15033a33a462', 'm', '1996-11-21', 'Monique', '7/20240418154212.jpg', '2024-04-18 14:15:10', '2024-04-18 14:15:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
