-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2023 at 06:34 PM
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
-- Table structure for table `routine`
--

CREATE TABLE `routine` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `display` varchar(8) NOT NULL,
  `subscribers` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routine`
--

INSERT INTO `routine` (`id`, `form_id`, `display`, `subscribers`, `user_id`) VALUES
(3, 3, 'no', 1, 59),
(5, 3, 'yes', 1, 75),
(10, 3, 'yes', 1, 79),
(11, 3, 'no', 1, 83);

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

-- --------------------------------------------------------

--
-- Table structure for table `user_hide_form`
--

CREATE TABLE `user_hide_form` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `hidden` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `form_id`, `title`, `content`, `user_id`) VALUES
(1, 1, 'Lorem ipsum dolor.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 59),
(2, 2, '', '', 59),
(5, 1, 'Title 1', 'Description 1, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 75),
(6, 2, 'Title 2', 'Description 2, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 75),
(9, 3, 'titletest', 'Lorem', 59),
(10, 3, 'Beginner nutrition plan!', 'This is my beginner nutrition plan!', 79),
(11, 2, 'Lorem ipsum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 79),
(12, 1, 'Lorem ipsum dolor sit.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 79),
(13, 1, 'Title 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 83),
(14, 3, 'Friendly for beginners', 'The best exercise routine!', 83),
(15, 1, 'Test 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 85),
(16, 2, 'Test 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 85),
(17, 1, 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 86),
(18, 3, 'My favourite stuff', '', 86),
(19, 3, 'routine1', '', 75);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `routine`
--
ALTER TABLE `routine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainer_table`
--
ALTER TABLE `trainer_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_hide_form`
--
ALTER TABLE `user_hide_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `routine`
--
ALTER TABLE `routine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `trainer_table`
--
ALTER TABLE `trainer_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `user_hide_form`
--
ALTER TABLE `user_hide_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
