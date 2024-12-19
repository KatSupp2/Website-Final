-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 12:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `members_paras`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL,
  `user_level` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `registration_date`, `user_level`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', '$2y$10$seB5aOIXv1QjJqPHUMaemOvJ1dQxGoa7yOj6BW267izGX8Hm8I816', '2024-12-18 07:46:56', 1),
(2, 'John', 'Doe', 'testemail@gmail.com', '$2y$10$EiWIOKK2TSaCWYutDJDBUOVZ/LJkLDeNCGJa7NSi//EIxCugAWf/K', '2024-10-20 16:51:11', 0),
(4, 'tobe', 'edited2', 'tobeedited@gmail.com', '$2y$10$wUyC.ILaPfzL31F9Hw27FeUvjF3mcIw5bfQai/h31t7yihqqNV6lS', '2024-11-10 08:43:20', 0),
(19, 'John', 'Doe', 'JohnDoe@random.com', '$2y$10$.Ecun4xXrMDrMhTeLvloJO/O5wT1MwCcA3iDqjrb6KioTqIwltl.a', '2024-12-11 06:17:08', 0),
(23, 'first', 'last', 'firstlast@gmail.com', '$2y$10$n3oT7pisuG3net.R2l3QVehl6q/56p4qnBICk/2Eq6AymFYDOD4RC', '2024-12-11 14:22:48', 0),
(25, 'uno', 'dos', 'unodos@yahoo.com', '$2y$10$c/D4efwz5Qnk6F2oYieenOZChuERkOFl6Ik2XMrMeDhm78O86rjie', '2024-12-11 14:28:31', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
