-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2023 at 06:33 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `role` varchar(11) NOT NULL,
  `routine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `username`, `email`, `password_hash`, `image`, `role`, `routine`) VALUES
(59, 'Chad', 'Giga', 'Gigachad', 'Gigachad@chadmail.com', '$2y$10$U8uXCI.XwTP/9n5aEbpbx.B/2YAf08Zp9r2kEkKjosgNQc16TExMq', 'Gigachad@chadmail.com_12-06-2023_21-41-49.jpg', 'admin', 79),
(75, ' ', ' ', 'Chadgiga', 'Chadgiga@chadmail.com', '$2y$10$1v4I/p20lx61dild1O9dcOTczw5bbtkQ7/tFaEQKMmGGgx/GG8hui', 'Chadgiga@chadmail.com_12-06-2023_19-32-12.jpg', 'admin', 75),
(79, 'test', 'test2', 'Trainer', 'Trainer1@chadmail.com', '$2y$10$ozvDgx0wfL5Acy0A.pJlKe7sF3b.k8yrG76zQ17vUvqdqWn88NYJi', 'Trainer1@chadmail.com_12-06-2023_21-36-49.jpg', 'trainer', 59),
(83, '', '', 'Trainer 2', 'trainer2@chadmail.com', '$2y$10$DslDDnREbEojoMrWqDm7TeSvy7QhLcXDJVhd/DEhF.tMxjmx3vWuy', 'test34334@gmail.com_12-06-2023_07-17-55.jpg', 'trainer', 83),
(86, '', '', 'User 1', 'Usertest2@chadmail.com', '$2y$10$KLBbWfTEeoJz6LoyQ1DbT.lcB6nDDrb0fUpe8/4Cel/nxV5ra.XkC', 'Usertest2@chadmail.com_12-06-2023_21-35-55.jpg', 'user', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
