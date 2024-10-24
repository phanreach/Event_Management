-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 10:07 AM
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
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `participant_number` int NOT NULL,
  `registration` int NOT NULL,
  `available_slot` int NOT NULL,
  `price` int NOT NULL,
  `event_banner` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_name`, `start_date`, `end_date`, `start_time`, `end_time`, `location`, `description`, `participant_number`, `registration`, `available_slot`, `price`, `event_banner`, `created_at`) VALUES
(1, 'Tech Conference', '2024-11-01', '2024-11-03', '09:00:00', '17:00:00', 'Convention Center', 'A 3-day tech conference on AI and blockchain.', 500, 5, 495, 150, NULL, '2024-10-24 07:08:15'),
(2, 'Music Festival', '2024-12-15', '2024-12-17', '12:00:00', '22:00:00', 'City Park', 'A 3-day outdoor music festival with various artists.', 1000, 7, 4993, 100, NULL, '2024-10-24 07:08:15'),
(3, 'Art Exhibition', '2024-11-20', '2024-11-25', '10:00:00', '18:00:00', 'Art Gallery', 'An exhibition showcasing contemporary art.', 200, 0, 0, 20, NULL, '2024-10-24 07:08:15'),
(4, 'Startup Pitch Night', '2024-10-30', '2024-10-30', '18:00:00', '21:00:00', 'Innovation Hub', 'Pitching event for new startups.', 100, 2, 98, 0, NULL, '2024-10-24 07:08:15'),
(5, 'Charity Run', '2024-12-05', '2024-12-05', '07:00:00', '11:00:00', 'City Stadium', 'A charity 10K run event to raise funds for education.', 300, 10, 290, 50, NULL, '2024-10-24 07:08:15'),
(6, 'Food Truck Festival', '2024-11-12', '2024-11-13', '11:00:00', '20:00:00', 'Downtown Plaza', 'A gathering of the city\'s best food trucks.', 600, 0, 0, 15, NULL, '2024-10-24 07:08:15'),
(7, 'Career Fair', '2024-12-01', '2024-12-01', '09:00:00', '16:00:00', 'University Hall', 'A fair for job seekers to connect with companies.', 800, 0, 0, 0, NULL, '2024-10-24 07:08:15'),
(8, 'Yoga Retreat', '2024-11-10', '2024-11-12', '06:00:00', '19:00:00', 'Mountain Resort', 'A weekend retreat focused on yoga and mindfulness.', 50, 0, 0, 300, NULL, '2024-10-24 07:08:15'),
(9, 'Comedy Night', '2024-10-29', '2024-10-29', '19:00:00', '22:00:00', 'Comedy Club', 'An evening of live stand-up comedy.', 100, 0, 0, 25, NULL, '2024-10-24 07:08:15'),
(10, 'Hackathon', '2024-11-17', '2024-11-18', '08:00:00', '18:00:00', 'Tech Hub', 'A 2-day hackathon for developers.', 150, 0, 0, 10, NULL, '2024-10-24 07:08:15'),
(11, 'Study Abroad', '2024-10-24', '2024-10-26', '03:25:00', '01:29:00', 'my house', 'hello world', 123, 0, 0, 10, NULL, '2024-10-24 07:08:15'),
(12, 'khnom3.0', '2024-10-24', '2024-10-25', '06:15:00', '17:17:00', 'Aeon mall sen sok', 'Khnom3.0 is event talk about childhood traumatize', 100, 0, 0, 2, NULL, '2024-10-24 07:08:15'),
(13, 'night party', '2024-10-25', '2024-10-25', '19:15:00', '21:15:00', 'the water', 'celebrate birthday', 2, 2, 0, 20, '7732020.jpg', '2024-10-24 02:17:09');

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
  `role` enum('user','admin') DEFAULT 'user',
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `reset_token`, `reset_expires`, `role`, `profile_picture`) VALUES
(2, 'user', 'user@gmail.com', '$2y$10$4moAqoRrWIu5/YF.OzQ.Yee04Fp4PwS6StdF.KpQpAhsVq0vTq6s.', 'b9e0b45fa1ade52c2f250c0c3f5ba0e3dd8dc3aea570528021e9bb1d0cd2c813309e2d3350160a360aa97443aeb11cbfe2c8', '2024-10-22 06:38:07', 'user', 'neymar.png'),
(4, 'christ', 'christ@gmail.com', '$2y$10$jQAcJk9t0zIb1r1t3XZfUOEaTfbIw7T0ure5a0738RHT34VLZ/k8W', NULL, NULL, 'admin', 'christheria.png'),
(5, 'test', 'test@gmail.com', '$2y$10$bo88paEOS7g3NXfh5APhmOIcBLoPYd1VAtWpOPU7JSMrAoL84l50y', NULL, NULL, 'admin', ''),
(7, 'messi', 'messi@gmail.com', '$2y$10$PfE709k62n5f8mGtXMb6yujB/W16w1jL589IjaJ8YQ6QPLFUKdYHW', NULL, NULL, 'admin', ''),
(8, 'reach', 'reach@gmail.com', '$2y$10$RIuzSgwK0uVGzI5Vv0AZgOMSA1HN4wn7162Bf.gQWMjzqiEx2d0w2', NULL, NULL, 'user', 'reach.png'),
(9, 'user1', 'user1@gmail.com', '$2y$10$0jMnAVKUs.9uQyemjPYfc.ttG6Wrj55Jvwro4kygQA6JXbVX6MDNC', NULL, NULL, 'user', NULL),
(10, 'Cristiano Ronaldo', 'ronaldo123@gmail.com', '$2y$10$9ICxhJ.uM0BdCXOm757elO4AmXsvAkHErqDrWC/taXLt7oZMqK98.', NULL, NULL, 'user', 'cristiano.png'),
(11, 'new', 'new@gmail.com', '$2y$10$RvQrHKPEPV7NAaow2FSvreSqvp5cDD98cjgLWxYq6MxVuhp5Z91A2', NULL, NULL, 'user', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_event`
--

CREATE TABLE `user_event` (
  `user_event_id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_event`
--

INSERT INTO `user_event` (`user_event_id`, `user_id`, `event_id`) VALUES
(1, 8, 1),
(2, 8, 2),
(3, 8, 2),
(4, 8, 2),
(5, 8, 2),
(6, 8, 2),
(7, 8, 2),
(8, 8, 2),
(9, 8, 5),
(11, 8, 5),
(12, 8, 5),
(14, 8, 5),
(15, 8, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_event`
--
ALTER TABLE `user_event`
  ADD PRIMARY KEY (`user_event_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_event`
--
ALTER TABLE `user_event`
  MODIFY `user_event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_event`
--
ALTER TABLE `user_event`
  ADD CONSTRAINT `user_event_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_event_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
