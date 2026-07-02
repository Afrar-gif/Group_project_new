-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2026 at 06:12 PM
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
(1, 'Afrar', 'afrarmohamedcan@gmail.com', '789568A', '5874', '123456789'),
(6, 'Rukaimy', 'rukaimyahamed01@gmail.com', '78964525', '587963', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `transformer` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `district`, `city`, `area`, `transformer`) VALUES
(1, 'Ampara', 'Sammanthurai', 'Sammanthurai 01', '457896S1'),
(2, 'Colombo', 'Dehiwala', 'Dehiwala 01', '754789D1'),
(3, 'Ampara', 'Sammanthurai', 'Malayadi 02', '568794M2'),
(6, 'Ampara', 'Sammanthurai', 'Sennal Kiramam', '4789657SK'),
(7, 'ampara ', 'Sammanthurai', 'malayadi 03', 'ma0312'),
(8, 'ampara ', 'Sammanthurai', 'sennal 2', 'se5464');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `name`, `email`, `area`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'Rukaimy Ahamed', 'rukaimyahamed01@gmail.com', 'malayadi 03', 'tranformer issue', ' my area transformer is not working ', 'Pending', '2026-05-26 10:29:10');

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
(6, 'sennal 2', '2026-06-17', '8AM  10Am', 'Pending', '2026-06-02 08:38:02');

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
(12, 'jr ahamed ', 'rukaimyahamed01@gmail.com', 'sennal 2', '987456123', '123456');

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `power_alerts`
--
ALTER TABLE `power_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
