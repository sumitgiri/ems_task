-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2025 at 05:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `stop_time` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `start_time`, `stop_time`, `notes`, `description`, `created_at`) VALUES
(1, 2, '2025-01-31 10:26:00', '2025-01-31 19:26:00', 'Completed', 'DONE', '2025-01-31 18:26:56'),
(2, 2, '2025-01-31 18:37:00', '2025-01-31 18:39:00', 'Done', 'Done', '2025-01-31 18:38:06'),
(3, 2, '2025-02-01 04:10:00', '2025-02-01 04:10:00', 'fffh', 'hghh', '2025-02-01 04:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_password_change` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `last_login`, `last_password_change`, `role`, `created_at`) VALUES
(1, 'SUMIT', 'GIRI', 'sumitgiri02@gmail.com', '8709798213', '$2y$10$eWB/Y3PT1DeR139t1LhYHuwX8L.xI8IXe21OgmnofwJGuB8yjHLU2', '2025-02-01 04:08:39', NULL, 'admin', '2025-01-31 18:15:27'),
(2, 'MANOJ', 'SINGH', 'manoj@gmail.com', '87963325245', '$2y$10$8nnWB4U0pICAvZOzzDF7x.FfqOY5Orzlixt2aUz7dNlQuTXtMJ72C', '2025-02-01 04:10:05', '2025-01-31 18:24:44', 'user', '2025-01-31 18:19:57'),
(3, 'MUKESH ', 'KUMAR', 'mukesh@gmail.com', '8574854585', '$2y$10$Y2Fp3uKRqQxscUAttvcQp.FVJYFI3yiMW1.AGiOub3R7zDR4mGEiO', NULL, NULL, 'user', '2025-02-01 03:59:52'),
(4, 'SANJAY', 'KUMAR', 'sanjay@gmail.com', '8745129632', '$2y$10$K2eW8CWzEVT4rT87L11HVeqanuu18.SIXIFTbV5zgPkmBMkRMQAu2', NULL, NULL, 'user', '2025-02-01 04:02:27'),
(5, 'test', 'k', 'h@gmail.com', '9685741235', '$2y$10$hCg5iObqqtehT7hIdqLkIuXz9GdE40nfbdp7LlmzwVTgplc53GP2a', NULL, NULL, 'user', '2025-02-01 04:03:54'),
(6, 'test G', 'k', 'jhh@gmail.com', '9685741235', '$2y$10$dYKo4wpUksl0isAPgHBUjuQiXauIx38qP/znB8km.WpAf7qOQ9qte', NULL, NULL, 'user', '2025-02-01 04:05:02'),
(7, 'naresh', 'singh', 'naresh@gmail.com', '8574125485', '$2y$10$3YNqPzwcgUAXT3kulpRGHuoIbdYZcBtMITdkraoizE4U6FnqD5TEC', NULL, NULL, 'user', '2025-02-01 04:06:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
