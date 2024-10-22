-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 11:03 AM
-- Server version: 9.0.1
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `reset_token`, `reset_expires`, `role`) VALUES
(1, 'reach', 'reach@gmail.com', '$2y$10$QCtWKO0vng1DQlK6/VdIbeYJSua8QS9iNL1qo0zhPnWHUvzMEv0na', NULL, NULL, 'user'),
(2, 'user', 'user@gmail.com', '$2y$10$4moAqoRrWIu5/YF.OzQ.Yee04Fp4PwS6StdF.KpQpAhsVq0vTq6s.', 'b9e0b45fa1ade52c2f250c0c3f5ba0e3dd8dc3aea570528021e9bb1d0cd2c813309e2d3350160a360aa97443aeb11cbfe2c8', '2024-10-22 06:38:07', 'user'),
(4, 'christ', 'christ@gmail.com', '$2y$10$jQAcJk9t0zIb1r1t3XZfUOEaTfbIw7T0ure5a0738RHT34VLZ/k8W', NULL, NULL, 'admin'),
(5, 'test', 'test@gmail.com', '$2y$10$bo88paEOS7g3NXfh5APhmOIcBLoPYd1VAtWpOPU7JSMrAoL84l50y', NULL, NULL, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
