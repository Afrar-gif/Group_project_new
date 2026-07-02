-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2026 at 07:58 PM
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
-- Database: `edl`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_number` varchar(100) DEFAULT NULL,
  `secret_key` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `id_number`, `secret_key`, `password`) VALUES
(1, 'Afrar', 'afrarmohamedcan@gmail.com', '7895683', '5874', '123456789'),
(6, 'Rukaimy', 'rukaimyahamed01@gmail.com', '78964525', '587963', '123456789'),
(11, 'karthik ', 'karthik@gmail.com', '789568l', '', ''),
(12, 'hello', 'hello@gmail.com', '20262025', '2026', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `transformer` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT 7.29060000,
  `longitude` decimal(11,8) DEFAULT 80.63370000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `district`, `city`, `area`, `transformer`, `latitude`, `longitude`) VALUES
(1, 'Ampara', 'Sammanthurai', 'Sammanthurai 01', '457896S1', 7.29060000, 80.63370000),
(2, 'Colombo', 'Dehiwala', 'Dehiwala 01', '754789D1', 7.29060000, 80.63370000),
(3, 'Ampara', 'Sammanthurai', 'Malayadi 02', '568794M2', 7.29060000, 80.63370000),
(6, 'Ampara', 'Sammanthurai', 'Sennal Kiramam', '4789657SK', 7.29060000, 80.63370000),
(7, 'ampara ', 'Sammanthurai', 'malayadi 03', 'ma0312', 7.29060000, 80.63370000),
(8, 'ampara ', 'Sammanthurai', 'sennal 2', 'se5464', 7.29060000, 80.63370000),
(9, 'ampara ', 'Sammanthurai', 'malayadi-03', 'ma0312', 7.29060000, 80.63370000);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `name`, `email`, `area`, `subject`, `message`, `status`, `created_at`, `admin_reply`) VALUES
(1, 'Rukaimy Ahamed', 'rukaimyahamed01@gmail.com', 'malayadi 03', 'tranformer issue', ' my area transformer is not working ', 'In Progress', '2026-05-26 10:29:10', ''),
(2, 'Critical Hazard Client', 'emergency_system@edl.lk', 'Sammanthurai 01', '[EMERGENCY EXTREME] - Live Wire Snapped on Road', 'bbuyfrd6hgthgfkyjhs', 'Pending', '2026-06-09 16:31:43', NULL),
(3, 'Critical Hazard Client', 'emergency_system@edl.lk', 'Sammanthurai 01', '[EMERGENCY EXTREME] - Live Wire Snapped on Road', 'infront of fod city \r\n', 'Pending', '2026-06-09 18:28:35', NULL),
(4, 'Critical Hazard Client', 'emergency_system@edl.lk', 'Sammanthurai 01', '[EMERGENCY EXTREME] - Live Wire Snapped on Road', 'in front of sammanturai foodcity', 'Pending', '2026-06-09 18:34:50', NULL),
(5, 'Rukaimy Ahamed', 'rukaimyahamed01@gmail.com', 'malayadi 03', 'tranformer issue', 'jjghu', 'Pending', '2026-06-12 06:24:18', NULL),
(6, 'Rukaimy Ahamed', 'rukaimyahamed01@gmail.com', 'malayadi 03', 'tranformer issue', 'this so problwem ', 'Pending', '2026-06-24 09:40:09', NULL),
(7, 'Critical Hazard Client', 'emergency_system@edl.lk', 'Malayadi 02', '[EMERGENCY EXTREME] - Transformer Sparking / Fire Explosion', 'ggkuydqwkydq', 'Pending', '2026-06-24 09:48:54', NULL),
(8, 'Critical Hazard Client', 'emergency_system@edl.lk', 'Sennal Kiramam', '[EMERGENCY EXTREME] - Live Wire Snapped on Road', 'ssssssssssss', 'Pending', '2026-06-24 09:51:00', NULL),
(9, 'Critical Hazard Client', 'emergency_system@edl.lk', 'Sammanthurai 01', '[EMERGENCY EXTREME] - Transformer Sparking / Fire Explosion', 'asdfghjkl', 'Pending', '2026-06-26 16:59:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `power_alerts`
--

CREATE TABLE `power_alerts` (
  `id` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `power_alerts`
--

INSERT INTO `power_alerts` (`id`, `area`, `date`, `time`, `status`, `created_at`) VALUES
(4, 'malayadi 03', '2026-05-14', '8AM  10Am', 'Pending', '2026-05-21 05:13:52'),
(6, 'sennal 2', '2026-06-17', '8AM  10Am', 'Pending', '2026-06-02 08:38:02'),
(9, 'sennal 2', '2026-07-01', '21:57', 'Pending', '2026-06-15 10:06:18'),
(10, 'malayadi-03', '2026-06-22', '00:00 - 02:00', 'Pending', '2026-06-19 15:11:40'),
(12, 'malayadi 03', '2026-07-01', '01:09 - 04:14', 'Pending', '2026-06-30 17:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `system_stats`
--

CREATE TABLE `system_stats` (
  `id` int(11) NOT NULL,
  `total_consumers` varchar(50) NOT NULL DEFAULT '1,250',
  `alerts_sent` varchar(50) NOT NULL DEFAULT '450',
  `reports_filed` varchar(50) NOT NULL DEFAULT '180',
  `tracked_regions` varchar(50) NOT NULL DEFAULT '6'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_stats`
--

INSERT INTO `system_stats` (`id`, `total_consumers`, `alerts_sent`, `reports_filed`, `tracked_regions`) VALUES
(1, '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `area`, `account_number`, `password`) VALUES
(10, 'Rukaimy', 'rukaimyahamed01@gmail.com', 'Malaydi', '78964525', '123456789'),
(11, 'Rukaimy Ahamed', 'rukaimy01@gmail.com', 'malayadi 03', '987456123', 'rukaimy01'),
(12, 'jr ahamed ', 'rukaimyahamed01@gmail.com', 'sennal 2', '987456123', '123456'),
(13, 'HAKKAM', 'hakkam@gmail.com', 'sammathurai', '758407', '123456'),
(14, 'Rukaimy Ahamed', 'rukaimyahamed01@gmail.com', 'malayadi 03', '123654789', '595959'),
(15, 'Rukaimy Ahamed', 'rukaimyahamed01@gmail.com', 'malaiyadi-03', '984854125', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `user_reviews`
--

CREATE TABLE `user_reviews` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `review_text` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_reviews`
--

INSERT INTO `user_reviews` (`id`, `user_name`, `review_text`, `location`, `created_at`) VALUES
(1, 'Ahmed R.', 'Ever since I started using this site, I no longer worry about unannounced power outages. The email updates are perfectly synchronized!', 'Ampara', '2026-06-13 15:57:19'),
(2, 'Mohamed S.', 'The ability to instantly report emergency breakdowns or wire sparks directly to the dashboard is incredibly helpful. Brilliant engineering!', 'Batticaloa', '2026-06-13 15:57:19'),
(3, 'Fathima A.', 'The UI layout looks very responsive, neat, and tracking current live analytics across grids is fast and effortless.', 'Colombo', '2026-06-13 15:57:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `power_alerts`
--
ALTER TABLE `power_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_stats`
--
ALTER TABLE `system_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `power_alerts`
--
ALTER TABLE `power_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `system_stats`
--
ALTER TABLE `system_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_reviews`
--
ALTER TABLE `user_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
