-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- Generation Time: Mar 02, 2021 at 12:58 PM
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
-- Table structure for table `wc_categories`
--

CREATE TABLE `wc_categories` (
                                 `idx` int(10) UNSIGNED NOT NULL,
                                 `id` varchar(32) NOT NULL,
                                 `title` varchar(255) NOT NULL DEFAULT '',
                                 `description` text NOT NULL DEFAULT '',
                                 `createdAt` int(10) UNSIGNED NOT NULL,
                                 `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wc_files`
--

CREATE TABLE `wc_files` (
                            `idx` int(10) UNSIGNED NOT NULL,
                            `userIdx` int(10) UNSIGNED NOT NULL,
                            `path` varbinary(255) NOT NULL,
                            `name` varchar(255) NOT NULL,
                            `type` varchar(32) NOT NULL,
                            `size` int(10) UNSIGNED NOT NULL,
                            `createdAt` int(10) UNSIGNED NOT NULL,
                            `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Table structure for table `wc_posts`
--

CREATE TABLE `wc_posts` (
                            `idx` int(10) UNSIGNED NOT NULL,
                            `rootIdx` int(10) UNSIGNED NOT NULL DEFAULT 0,
                            `parentIdx` int(10) UNSIGNED NOT NULL DEFAULT 0,
                            `categoryIdx` int(10) UNSIGNED NOT NULL,
                            `userIdx` int(10) UNSIGNED NOT NULL,
                            `subcategory` varchar(64) NOT NULL DEFAULT '',
                            `title` varchar(255) NOT NULL DEFAULT '',
                            `path` varchar(255) NOT NULL DEFAULT '',
                            `content` longtext NOT NULL DEFAULT '',
                            `files` text NOT NULL DEFAULT '',
                            `createdAt` int(10) UNSIGNED NOT NULL,
                            `updatedAt` int(10) UNSIGNED NOT NULL,
                            `deletedAt` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wc_push_notification_tokens`
--

CREATE TABLE `wc_push_notification_tokens` (
                                               `idx` int(10) UNSIGNED NOT NULL,
                                               `userIdx` int(10) UNSIGNED NOT NULL,
                                               `token` varchar(255) NOT NULL,
                                               `domain` varchar(64) NOT NULL,
                                               `createdAt` int(10) UNSIGNED NOT NULL,
                                               `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for table `wc_categories`
--
ALTER TABLE `wc_categories`
    ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `wc_files`
--
ALTER TABLE `wc_files`
    ADD PRIMARY KEY (`idx`),
  ADD KEY `userIdx` (`userIdx`);

--
-- Indexes for table `wc_metas`
--
ALTER TABLE `wc_metas`
    ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `taxonomy_entity_code` (`taxonomy`,`entity`,`code`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `wc_posts`
--
ALTER TABLE `wc_posts`
    ADD PRIMARY KEY (`idx`),
  ADD KEY `createdAt` (`createdAt`),
  ADD KEY `updatedAt` (`updatedAt`),
  ADD KEY `userIdx` (`userIdx`),
  ADD KEY `categoryIdx` (`categoryIdx`),
  ADD KEY `subcategory` (`subcategory`),
  ADD KEY `deletedAt` (`deletedAt`),
  ADD KEY `parentIdx` (`parentIdx`),
  ADD KEY `rootIdx` (`rootIdx`),
  ADD KEY `path` (`path`);

--
-- Indexes for table `wc_push_notification_tokens`
--
ALTER TABLE `wc_push_notification_tokens`
    ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `domain` (`domain`);

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
-- AUTO_INCREMENT for table `wc_categories`
--
ALTER TABLE `wc_categories`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wc_files`
--
ALTER TABLE `wc_files`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wc_metas`
--
ALTER TABLE `wc_metas`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wc_posts`
--
ALTER TABLE `wc_posts`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wc_push_notification_tokens`
--
ALTER TABLE `wc_push_notification_tokens`
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
