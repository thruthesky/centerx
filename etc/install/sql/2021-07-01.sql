-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- 생성 시간: 21-07-01 13:02
-- 서버 버전: 10.5.10-MariaDB-1:10.5.10+maria~focal
-- PHP 버전: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `itsuda`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_user_recommends`
--

CREATE TABLE `wc_user_recommends` (
                                      `idx` int(10) UNSIGNED NOT NULL,
                                      `userIdx` int(10) UNSIGNED NOT NULL,
                                      `otherUserIdx` int(10) UNSIGNED NOT NULL,
                                      `createdAt` int(10) UNSIGNED NOT NULL,
                                      `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `wc_user_recommends`
--
ALTER TABLE `wc_user_recommends`
    ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `userIdx_otherUserIdx` (`userIdx`,`otherUserIdx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `wc_user_recommends`
--
ALTER TABLE `wc_user_recommends`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
