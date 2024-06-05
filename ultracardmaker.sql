-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2024 at 10:11 PM
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
-- Database: `ultracardmaker`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_cards`
--

CREATE TABLE `all_cards` (
  `card_id` int(255) NOT NULL,
  `card_title` varchar(255) DEFAULT NULL,
  `card_data` varchar(255) DEFAULT NULL,
  `card_img` varchar(255) DEFAULT NULL,
  `card_author` varchar(255) NOT NULL,
  `card_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `card_published` tinyint(1) NOT NULL DEFAULT 0,
  `card_likes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_cards`
--

INSERT INTO `all_cards` (`card_id`, `card_title`, `card_data`, `card_img`, `card_author`, `card_created_at`, `card_published`, `card_likes`) VALUES
(1, 'Mokey Mokey', 'json_cards/test_card1.json', NULL, 'Adio', '2024-06-05 19:38:22', 0, 0),
(2, 'Mokey Mokey 2', 'json_cards/test_card2.json', NULL, 'Adio', '2024-06-05 19:41:21', 0, 0),
(3, 'MOJ MOKI MOKI', 'json_cards/test_card3.json', NULL, 'Dario123', '2024-06-05 19:45:17', 0, 0),
(4, 'Blue Eyes Ultimate Dragon?', 'json_cards/test_card4.json', NULL, 'Dario123', '2024-06-05 19:47:33', 0, 0),
(5, 'MOJ MOKI MOKI', 'json_cards/test_card5.json', NULL, 'Dario123', '2024-06-05 19:49:43', 0, 0),
(6, 'Gost Moki', 'json_cards/test_card6.json', NULL, 'Guest User', '2024-06-05 19:55:25', 0, 0),
(7, 'Moki Gost 2', 'json_cards/test_card7.json', NULL, 'Guest User', '2024-06-05 19:55:52', 0, 0),
(8, 'LOL', 'json_cards/test_card8.json', NULL, 'lol', '2024-06-05 19:56:28', 0, 0),
(9, 'Zadnji zapis', 'json_cards/test_card9.json', NULL, 'Guest User', '2024-06-05 19:57:12', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `account_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `pass`, `email`, `account_created`) VALUES
(1, 'lol', '$2y$10$0Dxv67YEdQ0asTIAoW0CsOWwrNM/ZqTARPgx8uFI8Y.IXrsm4Ranm', 'lol@gmail.com', '2024-06-05 18:44:02'),
(2, 'Adio', '$2y$10$fYEGUv7V/kBaWH664/wzcewUSewFMU7280xkxyteArzKqSXlJ8S8a', 'adio@gmail.com', '2024-06-05 19:37:42'),
(3, 'Dario123', '$2y$10$W3HDJrc6Y9.OZHtnrgHCUOl7WhGaEczA3/.8YwhAicZ2caTPoo4hS', 'ddrame@tvz.hr', '2024-06-05 19:44:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_cards`
--
ALTER TABLE `all_cards`
  ADD PRIMARY KEY (`card_id`),
  ADD KEY `card_created_at` (`card_created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `USERNAME` (`username`),
  ADD UNIQUE KEY `EMAIL` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_cards`
--
ALTER TABLE `all_cards`
  MODIFY `card_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
