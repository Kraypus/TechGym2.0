-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2023 at 06:31 PM
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
-- Table structure for table `trainer_table`
--

CREATE TABLE `trainer_table` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `row_id` int(11) NOT NULL,
  `content1` varchar(64) NOT NULL,
  `content2` varchar(64) NOT NULL,
  `content3` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainer_table`
--

INSERT INTO `trainer_table` (`id`, `form_id`, `row_id`, `content1`, `content2`, `content3`, `user_id`) VALUES
(32, 3, -1, 'Lorem', 'Lorem', '', 59),
(33, 3, 0, 'test', '', '', 59),
(34, 3, 1, 'updated', 'Lorem', 'Lorem', 59),
(35, 3, 2, 'test', 'information', '', 59),
(36, 3, 3, 'Lorem', '', '', 59),
(37, 3, 4, 'Lorem', '', '', 59),
(38, 3, -1, 'Time', 'Meal', 'Foods', 79),
(39, 3, 0, '8:00 - 9:00AM', 'Breakfast', 'Chicken + rice', 79),
(40, 3, 1, '11:00 - 12:00PM', 'Mid morning', 'Chicken + rice', 79),
(41, 3, 2, '2:00 - 3:00PM', 'Lunch', 'Chicken + rice', 79),
(42, 3, 3, '5:00 - 6:00PM', 'Evening snacks', 'Chicken + rice', 79),
(43, 3, 4, '8:00 - 9:00PM', 'Dinner', 'Chicken + rice', 79),
(44, 3, -1, 'Time', 'Exercise', '', 83),
(45, 3, 0, 'Morning', 'Squats', '', 83),
(46, 3, 1, 'Midday', 'Bench press', '', 83),
(47, 3, 2, 'Afternoon', 'Squats', '', 83),
(48, 3, 3, '', '', '', 83),
(49, 3, 4, '', '', '', 83),
(50, 3, -1, 'Workouts', 'Foods', '', 86),
(51, 3, 0, 'Squats', 'Chicken + rice', 'Lorem', 86),
(52, 3, 1, 'Squats', 'Chicken + rice', '', 86),
(53, 3, 2, 'Squats', '', '', 86),
(54, 3, 3, '', '', '', 86),
(55, 3, 4, '', '', '', 86),
(56, 3, -1, '', '', '', 75),
(57, 3, 0, 'yes', '', '', 75),
(58, 3, 1, '', '', '', 75),
(59, 3, 2, '', '', '', 75),
(60, 3, 3, '', '', '', 75),
(61, 3, 4, '', '', '', 75);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `trainer_table`
--
ALTER TABLE `trainer_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trainer_table`
--
ALTER TABLE `trainer_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
