-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- 생성 시간: 21-03-04 11:43
-- 서버 버전: 10.5.9-MariaDB-1:10.5.9+maria~focal
-- PHP 버전: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `mydatabase`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_categories`
--

CREATE TABLE `wc_categories` (
                                 `idx` int(10) UNSIGNED NOT NULL,
                                 `id` varchar(32) NOT NULL,
                                 `title` varchar(255) NOT NULL DEFAULT '',
                                 `description` text NOT NULL DEFAULT '',
                                 `POINT_POST_CREATE` int(11) NOT NULL DEFAULT 0,
                                 `POINT_POST_DELETE` int(11) NOT NULL DEFAULT 0,
                                 `POINT_COMMENT_CREATE` int(11) NOT NULL DEFAULT 0,
                                 `POINT_COMMENT_DELETE` int(11) NOT NULL DEFAULT 0,
                                 `BAN_ON_LIMIT` char(1) NOT NULL DEFAULT 'N',
                                 `POINT_HOUR_LIMIT` smallint(5) UNSIGNED NOT NULL,
                                 `POINT_HOUR_LIMIT_COUNT` smallint(5) UNSIGNED NOT NULL,
                                 `POINT_DAILY_LIMIT_COUNT` smallint(5) UNSIGNED NOT NULL,
                                 `createdAt` int(10) UNSIGNED NOT NULL,
                                 `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_files`
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
-- 테이블 구조 `wc_in_app_purchase_histories`
--

CREATE TABLE `wc_in_app_purchase_histories` (
                                                `ID` int(10) UNSIGNED NOT NULL,
                                                `user_ID` int(10) UNSIGNED NOT NULL,
                                                `stamp` int(10) UNSIGNED NOT NULL,
                                                `status` varchar(8) NOT NULL DEFAULT '',
                                                `platform` varchar(7) NOT NULL,
                                                `productID` varchar(32) NOT NULL,
                                                `purchaseID` varchar(128) NOT NULL,
                                                `price` varchar(32) NOT NULL,
                                                `title` varchar(255) NOT NULL,
                                                `description` text NOT NULL,
                                                `applicationUsername` varchar(255) NOT NULL,
                                                `transactionDate` bigint(20) UNSIGNED NOT NULL,
                                                `productIdentifier` varchar(32) NOT NULL,
                                                `quantity` smallint(5) UNSIGNED NOT NULL,
                                                `transactionIdentifier` bigint(20) UNSIGNED NOT NULL,
                                                `transactionTimeStamp` double UNSIGNED NOT NULL,
                                                `localVerificationData` mediumtext NOT NULL,
                                                `serverVerificationData` mediumtext NOT NULL,
                                                `localVerificationData_packageName` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_metas`
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
-- 테이블 구조 `wc_point_histories`
--

CREATE TABLE `wc_point_histories` (
                                      `idx` int(10) UNSIGNED NOT NULL,
                                      `fromUserIdx` int(10) UNSIGNED NOT NULL,
                                      `toUserIdx` int(10) UNSIGNED NOT NULL,
                                      `reason` varchar(32) NOT NULL,
                                      `taxonomy` varchar(32) NOT NULL,
                                      `entity` int(10) UNSIGNED NOT NULL DEFAULT 0,
                                      `categoryIdx` int(10) UNSIGNED NOT NULL,
                                      `fromUserPointApply` int(11) NOT NULL,
                                      `fromUserPointAfter` int(11) NOT NULL,
                                      `toUserPointApply` int(11) NOT NULL,
                                      `toUserPointAfter` int(11) NOT NULL,
                                      `createdAt` int(10) UNSIGNED NOT NULL,
                                      `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_posts`
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
                            `Y` int(10) UNSIGNED NOT NULL DEFAULT 0,
                            `N` int(10) UNSIGNED NOT NULL DEFAULT 0,
                            `createdAt` int(10) UNSIGNED NOT NULL,
                            `updatedAt` int(10) UNSIGNED NOT NULL,
                            `deletedAt` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_post_vote_histories`
--

CREATE TABLE `wc_post_vote_histories` (
                                          `idx` int(11) UNSIGNED NOT NULL,
                                          `userIdx` int(10) UNSIGNED NOT NULL,
                                          `taxonomy` varchar(32) NOT NULL,
                                          `entity` int(10) UNSIGNED NOT NULL,
                                          `choice` char(1) NOT NULL,
                                          `createdAt` int(10) UNSIGNED NOT NULL,
                                          `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_push_notification_tokens`
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
-- 테이블 구조 `wc_shopping_mall_order_histories`
--

CREATE TABLE `wc_shopping_mall_order_histories` (
                                                    `ID` int(11) NOT NULL,
                                                    `user_ID` int(10) UNSIGNED NOT NULL,
                                                    `info` text NOT NULL,
                                                    `stamp` int(10) UNSIGNED NOT NULL,
                                                    `confirmed` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_translations`
--

CREATE TABLE `wc_translations` (
                                   `language` varchar(16) NOT NULL,
                                   `code` varchar(255) NOT NULL,
                                   `value` longtext NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_users`
--

CREATE TABLE `wc_users` (
                            `idx` int(10) UNSIGNED NOT NULL,
                            `email` varchar(32) NOT NULL,
                            `password` varchar(255) NOT NULL,
                            `name` varchar(32) NOT NULL DEFAULT '',
                            `point` int(10) UNSIGNED NOT NULL DEFAULT 0,
                            `phoneNo` varchar(32) NOT NULL DEFAULT '',
                            `gender` char(1) NOT NULL DEFAULT '',
                            `countryCode` char(2) NOT NULL DEFAULT '',
                            `province` varchar(32) NOT NULL DEFAULT '',
                            `city` varchar(32) NOT NULL DEFAULT '',
                            `address1` varchar(255) NOT NULL DEFAULT '',
                            `address2` varchar(255) NOT NULL DEFAULT '',
                            `zipcode` varchar(32) NOT NULL DEFAULT '',
                            `createdAt` int(10) UNSIGNED NOT NULL,
                            `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `wc_categories`
--
ALTER TABLE `wc_categories`
    ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `id` (`id`);

--
-- 테이블의 인덱스 `wc_files`
--
ALTER TABLE `wc_files`
    ADD PRIMARY KEY (`idx`),
  ADD KEY `userIdx` (`userIdx`);

--
-- 테이블의 인덱스 `wc_in_app_purchase_histories`
--
ALTER TABLE `wc_in_app_purchase_histories`
    ADD PRIMARY KEY (`ID`);

--
-- 테이블의 인덱스 `wc_metas`
--
ALTER TABLE `wc_metas`
    ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `taxonomy_entity_code` (`taxonomy`,`entity`,`code`),
  ADD KEY `code` (`code`);

--
-- 테이블의 인덱스 `wc_point_histories`
--
ALTER TABLE `wc_point_histories`
    ADD PRIMARY KEY (`idx`),
  ADD KEY `createdAt` (`createdAt`),
  ADD KEY `createdAt_fromUserIdx_reason` (`idx`,`fromUserIdx`,`toUserIdx`) USING BTREE,
  ADD KEY `fromUserIdx_toUserIdx_reason` (`fromUserIdx`,`toUserIdx`,`reason`) USING BTREE;

--
-- 테이블의 인덱스 `wc_posts`
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
-- 테이블의 인덱스 `wc_post_vote_histories`
--
ALTER TABLE `wc_post_vote_histories`
    ADD PRIMARY KEY (`idx`),
  ADD KEY `userIdx_taxonomy_entity` (`userIdx`,`taxonomy`,`entity`),
  ADD KEY `taxonomy_entity_choice` (`taxonomy`,`entity`,`choice`);

--
-- 테이블의 인덱스 `wc_push_notification_tokens`
--
ALTER TABLE `wc_push_notification_tokens`
    ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `domain` (`domain`);

--
-- 테이블의 인덱스 `wc_shopping_mall_order_histories`
--
ALTER TABLE `wc_shopping_mall_order_histories`
    ADD PRIMARY KEY (`ID`),
  ADD KEY `confirmed` (`confirmed`);

--
-- 테이블의 인덱스 `wc_translations`
--
ALTER TABLE `wc_translations`
    ADD UNIQUE KEY `language_code` (`language`,`code`);

--
-- 테이블의 인덱스 `wc_users`
--
ALTER TABLE `wc_users`
    ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `point` (`point`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `wc_categories`
--
ALTER TABLE `wc_categories`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_files`
--
ALTER TABLE `wc_files`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_in_app_purchase_histories`
--
ALTER TABLE `wc_in_app_purchase_histories`
    MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_metas`
--
ALTER TABLE `wc_metas`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_point_histories`
--
ALTER TABLE `wc_point_histories`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_posts`
--
ALTER TABLE `wc_posts`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_post_vote_histories`
--
ALTER TABLE `wc_post_vote_histories`
    MODIFY `idx` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_push_notification_tokens`
--
ALTER TABLE `wc_push_notification_tokens`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_shopping_mall_order_histories`
--
ALTER TABLE `wc_shopping_mall_order_histories`
    MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_users`
--
ALTER TABLE `wc_users`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
