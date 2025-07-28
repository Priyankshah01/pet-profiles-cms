-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2025 at 12:16 AM
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
-- Database: `pet_profiles_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$9hnbG2dcRzwJshp6STvc7u758936A395RHv0JCWSir4BHJnqhNHWe', '2025-07-27 16:46:21');

-- --------------------------------------------------------

--
-- Table structure for table `breeds`
--

CREATE TABLE `breeds` (
  `id` int(11) NOT NULL,
  `breed_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `breeds`
--

INSERT INTO `breeds` (`id`, `breed_name`, `created_at`) VALUES
(1, 'Golden Retriever', '2025-07-27 16:46:21'),
(2, 'Siamese Cat', '2025-07-27 16:46:21'),
(3, 'Bulldog', '2025-07-27 16:46:21'),
(5, 'Labrador', '2025-07-27 16:46:21'),
(6, 'Persian Cat', '2025-07-27 16:46:21'),
(7, 'German Shepherd', '2025-07-27 16:46:21'),
(8, 'Poodle', '2025-07-27 16:46:21'),
(9, 'Husky', '2025-07-27 16:46:21'),
(10, 'Maine Coon', '2025-07-27 16:46:21');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `breed` varchar(100) NOT NULL,
  `story` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`id`, `name`, `breed`, `story`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Buddy', 'Golden Retriever', 'A loyal and playful friend who loves fetch and long walks in the park. Buddy is great with kids and other pets.', 'buddy.jpg', '2025-07-27 16:46:22', '2025-07-27 20:22:43'),
(2, 'Luna', 'Siamese Cat', 'Mysterious and elegant with piercing blue eyes and a gentle purr. Luna loves sunny windowsills.', 'luna.jpg', '2025-07-27 16:46:22', '2025-07-27 20:23:44'),
(3, 'Max', 'Bulldog', 'Loves naps and belly rubs. A gentle giant with a heart of gold who enjoys short walks and lots of cuddles.', 'max.jpg', '2025-07-27 16:46:22', '2025-07-27 16:46:22'),
(4, 'Daisy', 'Beagle', 'Always sniffing around the garden, curious about everything around her. Daisy is energetic and loves outdoor adventures.', 'daisy.jpg', '2025-07-27 16:46:22', '2025-07-27 16:46:22'),
(5, 'Charlie', 'Labrador', 'Friendly and outgoing, Charlie loves swimming and playing fetch. Perfect family companion with endless energy.', 'charlie.jpg', '2025-07-27 16:46:22', '2025-07-27 16:46:22'),
(6, 'Whiskers', 'Persian Cat', 'Fluffy and regal, Whiskers enjoys quiet moments and gentle brushing. A calm and loving indoor companion.', 'whiskers.jpg', '2025-07-27 16:46:22', '2025-07-27 16:46:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `breeds`
--
ALTER TABLE `breeds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `breed_name` (`breed_name`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `breeds`
--
ALTER TABLE `breeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
