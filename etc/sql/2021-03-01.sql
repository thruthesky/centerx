-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- Generation Time: Mar 01, 2021 at 03:42 AM
-- Server version: 10.5.9-MariaDB-1:10.5.9+maria~focal
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `wc_metas`
--

CREATE TABLE `wc_metas` (
                            `idx` int(10) UNSIGNED NOT NULL,
                            `taxonomy` varchar(32) NOT NULL,
                            `entity` int(11) NOT NULL,
                            `code` varchar(32) NOT NULL,
                            `data` longtext NOT NULL,
                            `createdAt` int(10) UNSIGNED NOT NULL,
                            `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wc_users`
--

CREATE TABLE `wc_users` (
                            `idx` int(10) UNSIGNED NOT NULL,
                            `email` varchar(32) NOT NULL,
                            `password` varchar(255) NOT NULL,
                            `name` varchar(32) NOT NULL DEFAULT '',
                            `phoneNo` varchar(32) NOT NULL DEFAULT '',
                            `gender` char(1) NOT NULL DEFAULT '',
                            `address` varchar(255) NOT NULL DEFAULT '',
                            `zipcode` varchar(32) NOT NULL DEFAULT '',
                            `createdAt` int(10) UNSIGNED NOT NULL,
                            `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wc_metas`
--
ALTER TABLE `wc_metas`
    ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `taxonomy_entity_code` (`taxonomy`,`entity`,`code`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `wc_users`
--
ALTER TABLE `wc_users`
    ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wc_metas`
--
ALTER TABLE `wc_metas`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wc_users`
--
ALTER TABLE `wc_users`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
