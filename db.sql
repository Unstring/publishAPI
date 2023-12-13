-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2023 at 11:01 AM
-- Server version: 10.6.15-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u252053937_publishPapper`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `paper_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Connections`
--

CREATE TABLE `Connections` (
  `connection_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `connected_user_id` int(11) NOT NULL,
  `status` enum('requested','accepted','rejected') NOT NULL DEFAULT 'requested',
  `requested_at` timestamp NULL DEFAULT NULL,
  `accepted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Followers`
--

CREATE TABLE `Followers` (
  `follower_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `follower_user_id` int(11) NOT NULL,
  `followed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Papers`
--

CREATE TABLE `Papers` (
  `paper_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `media_url` varchar(250) NOT NULL,
  `abstract` text DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `publication_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Papers`
--

INSERT INTO `Papers` (`paper_id`, `title`, `content`, `media_url`, `abstract`, `author_id`, `publication_date`) VALUES
(1, 'post title', 'post content', 'this is media url', 'abstract of the papper', NULL, '2023-11-30'),
(2, '2nd title ', 'some content for the 2nd title', '', 'sdfsadf', NULL, NULL),
(3, 'sdfsdf', 'sadf', 'sdaf', 'sdf', NULL, NULL),
(4, 'asdfsadf', 'sdfsadfasdf', 'asdfsdfsdfsadf', NULL, NULL, NULL),
(5, '', 'sdfsdfsdf', '', NULL, NULL, NULL),
(6, 'sdf', 'sdfsadf', 'rety', 'rty', NULL, NULL),
(7, 'rety', 'retyerty', 'rtyrty', 'rtyrty', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Paper_Metadata`
--

CREATE TABLE `Paper_Metadata` (
  `metadata_id` int(11) NOT NULL,
  `paper_id` int(11) DEFAULT NULL,
  `metadata_key` varchar(150) DEFAULT NULL,
  `metadata_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Permissions`
--

CREATE TABLE `Permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  `permission_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Reactions`
--

CREATE TABLE `Reactions` (
  `reaction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `paper_id` int(11) DEFAULT NULL,
  `reaction_type` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Reactions`
--

INSERT INTO `Reactions` (`reaction_id`, `user_id`, `paper_id`, `reaction_type`, `timestamp`) VALUES
(1, 24, 1, '1', '2023-12-06 06:20:40'),
(2, 24, 2, '1', '2023-12-06 06:20:53'),
(3, 24, 3, '1', '2023-12-06 06:20:56'),
(4, 24, 4, '1', '2023-12-06 06:20:59'),
(5, 24, 5, '1', '2023-12-06 06:21:03'),
(6, 28, 6, '1', '2023-12-06 06:42:33'),
(7, 28, 7, '1', '2023-12-06 06:42:48'),
(8, 28, 1, '1', '2023-12-06 06:42:54'),
(9, 28, 2, '1', '2023-12-06 06:43:25'),
(10, 28, 3, '1', '2023-12-06 06:49:00'),
(11, 27, 2, '1', '2023-12-06 06:49:51'),
(12, 27, 3, '1', '2023-12-06 06:49:56'),
(13, 24, 7, '2', '2023-12-06 07:01:25'),
(14, 29, 1, '1', '2023-12-06 07:10:03'),
(15, 29, 7, '1', '2023-12-06 07:11:43'),
(16, 29, 2, '1', '2023-12-06 07:12:31'),
(17, 29, 3, '1', '2023-12-06 07:22:14'),
(18, 27, 5, '3', '2023-12-06 07:30:28'),
(19, 28, 4, '1', '2023-12-06 09:12:29'),
(20, 29, 4, '1', '2023-12-06 09:43:16'),
(21, 29, 5, '3', '2023-12-06 09:43:32'),
(22, 29, 6, '3', '2023-12-06 09:43:39'),
(23, 30, 1, '1', '2023-12-10 15:50:12'),
(24, 30, 2, '1', '2023-12-10 15:50:15'),
(25, 30, 3, '2', '2023-12-10 15:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE `Roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Role_Permissions`
--

CREATE TABLE `Role_Permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `avatar` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `signup_at` int(11) NOT NULL,
  `role` int(11) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `full_name`, `username`, `avatar`, `email`, `signup_at`, `role`, `password_hash`) VALUES
(1, 'Amit Anand', 'amit', 'ccbfde0ac5393d4e23d2_1702207901.jpg', 'zraa577@gmail.com', 1701028284, 0, '$2y$10$nUTYNZh4ojt2xR5mWTLHsuasAA2S09rohH0ZG3nap6AUlUMZVYVtm'),
(24, 'sdkjfhl', 'zraa576', '', 'zraa576@gmail.com', 1701661729, NULL, '$2y$10$b2/fMWJ6KnhNFnw4Lxz3k.AnTlZqsEO.sM87hUt9CoE51kckV6hGq'),
(25, 'Anjana', 'anjanar266', '', 'anjanar266@gmail.com', 1701745447, NULL, '$2y$10$COAc4M4aTiKfL.rdcqXlruz0CBJKKWTsGaStdE.2Yv0NDyevghFl2'),
(27, 'Ved Prakash Chaubey', 'vedeprakesh05', '', 'vedeprakesh05@gmail.com', 1701844109, NULL, '$2y$10$G6lwSUyyU6/XtRGeRaO8PeiaR7V/7BJrvbfWYDZtBLOEaluFkJyC6'),
(28, 'Amit Anand', 'dropmail.amit', '', 'dropmail.amit@gmail.com', 1701844933, NULL, '$2y$10$sJncf/aj9GDknGLiZO..sOZY8zC3qYi4bBuPSqCwR0OK.w0Bo02BG'),
(29, 'Amit Anand', 'zraa578', '', 'zraa578@gmail.com', 1701846251, NULL, '$2y$10$8ex.5A4ip7mN9RrfmKX8V.Ms3tPvvT5gElEKxEQyLUjR/2lMnuGTG'),
(30, 'Pundreekaksha Sharma ', 'pundreekaksha', '', 'pundreekaksha@gmail.com', 1702223292, NULL, '$2y$10$h2hKWjHur.rJhxWv7xAe3uB0G4YN.t1JqdnJfrEBUQI9UQdvjfcb.'),
(31, 'Amit', 'zraa579', '', 'zraa579@gmail.com', 1702443949, NULL, '$2y$10$xkMCL17GoqjurApcRH3eM.12o8vvxrUwb3wKqfEZtKcqW7Xhs0MzS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `paper_id` (`paper_id`);

--
-- Indexes for table `Connections`
--
ALTER TABLE `Connections`
  ADD PRIMARY KEY (`connection_id`),
  ADD UNIQUE KEY `unique_connection` (`user_id`,`connected_user_id`),
  ADD KEY `fk_connected_user_connection` (`connected_user_id`);

--
-- Indexes for table `Followers`
--
ALTER TABLE `Followers`
  ADD PRIMARY KEY (`follower_id`),
  ADD UNIQUE KEY `unique_follower` (`user_id`,`follower_user_id`),
  ADD KEY `fk_follower_user` (`follower_user_id`);

--
-- Indexes for table `Papers`
--
ALTER TABLE `Papers`
  ADD PRIMARY KEY (`paper_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `Paper_Metadata`
--
ALTER TABLE `Paper_Metadata`
  ADD PRIMARY KEY (`metadata_id`),
  ADD KEY `paper_id` (`paper_id`);

--
-- Indexes for table `Permissions`
--
ALTER TABLE `Permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `Reactions`
--
ALTER TABLE `Reactions`
  ADD PRIMARY KEY (`reaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `paper_id` (`paper_id`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `Role_Permissions`
--
ALTER TABLE `Role_Permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Connections`
--
ALTER TABLE `Connections`
  MODIFY `connection_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Followers`
--
ALTER TABLE `Followers`
  MODIFY `follower_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Papers`
--
ALTER TABLE `Papers`
  MODIFY `paper_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Paper_Metadata`
--
ALTER TABLE `Paper_Metadata`
  MODIFY `metadata_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Permissions`
--
ALTER TABLE `Permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Reactions`
--
ALTER TABLE `Reactions`
  MODIFY `reaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `Roles`
--
ALTER TABLE `Roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `Papers` (`paper_id`);

--
-- Constraints for table `Connections`
--
ALTER TABLE `Connections`
  ADD CONSTRAINT `fk_connected_user_connection` FOREIGN KEY (`connected_user_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `fk_user_connection` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Followers`
--
ALTER TABLE `Followers`
  ADD CONSTRAINT `fk_follower_user` FOREIGN KEY (`follower_user_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `fk_user_follower` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Papers`
--
ALTER TABLE `Papers`
  ADD CONSTRAINT `Papers_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Paper_Metadata`
--
ALTER TABLE `Paper_Metadata`
  ADD CONSTRAINT `Paper_Metadata_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `Papers` (`paper_id`);

--
-- Constraints for table `Reactions`
--
ALTER TABLE `Reactions`
  ADD CONSTRAINT `Reactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `Reactions_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `Papers` (`paper_id`);

--
-- Constraints for table `Role_Permissions`
--
ALTER TABLE `Role_Permissions`
  ADD CONSTRAINT `Role_Permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`role_id`),
  ADD CONSTRAINT `Role_Permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `Permissions` (`permission_id`);

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `Roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
