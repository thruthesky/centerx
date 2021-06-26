-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- 생성 시간: 21-06-25 11:06
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
-- 데이터베이스: `centerx`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_advertisement_point_settings`
--

CREATE TABLE `wc_advertisement_point_settings` (
  `idx` int(10) UNSIGNED NOT NULL,
  `countryCode` char(2) NOT NULL,
  `top` int(10) UNSIGNED NOT NULL,
  `sidebar` int(10) UNSIGNED NOT NULL,
  `square` int(10) UNSIGNED NOT NULL,
  `line` int(10) UNSIGNED NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_cache`
--

CREATE TABLE `wc_cache` (
  `idx` int(10) UNSIGNED NOT NULL,
  `code` varchar(32) NOT NULL,
  `data` longtext NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_categories`
--

CREATE TABLE `wc_categories` (
  `idx` int(10) UNSIGNED NOT NULL,
  `userIdx` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `id` varchar(32) NOT NULL,
  `domain` varchar(32) NOT NULL DEFAULT '',
  `countryCode` char(2) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `subcategories` text NOT NULL DEFAULT '',
  `postCreateLimit` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `commentCreateLimit` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `readLimit` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `banCreateOnLimit` char(1) NOT NULL DEFAULT '',
  `createPost` mediumint(8) NOT NULL DEFAULT 0,
  `deletePost` mediumint(8) NOT NULL DEFAULT 0,
  `createComment` mediumint(8) NOT NULL DEFAULT 0,
  `deleteComment` mediumint(8) NOT NULL DEFAULT 0,
  `createHourLimit` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `createHourLimitCount` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `createDailyLimitCount` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `listOnView` char(1) NOT NULL DEFAULT 'Y',
  `noOfPostsPerPage` smallint(5) UNSIGNED NOT NULL DEFAULT 20,
  `postEditWidget` varchar(64) NOT NULL DEFAULT '',
  `postViewWidget` varchar(64) NOT NULL DEFAULT '',
  `postListHeaderWidget` varchar(64) NOT NULL DEFAULT '',
  `postListWidget` varchar(64) NOT NULL DEFAULT '',
  `paginationWidget` varchar(64) NOT NULL DEFAULT '',
  `noOfPagesOnNav` tinyint(64) UNSIGNED NOT NULL DEFAULT 10,
  `returnToAfterPostEdit` char(1) NOT NULL DEFAULT '',
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_countries`
--

CREATE TABLE `wc_countries` (
  `idx` int(10) UNSIGNED NOT NULL,
  `CountryNameKR` varchar(64) NOT NULL,
  `CountryNameEN` varchar(64) NOT NULL,
  `CountryNameOriginal` varchar(64) NOT NULL,
  `2digitCode` char(2) NOT NULL,
  `3digitCode` char(3) NOT NULL,
  `currencyCode` char(3) NOT NULL,
  `currencyKoreanName` varchar(16) NOT NULL,
  `currencySymbol` varchar(16) NOT NULL,
  `ISONumbericCode` smallint(6) UNSIGNED ZEROFILL NOT NULL,
  `latitude` varchar(16) NOT NULL DEFAULT '',
  `longitude` varchar(16) NOT NULL DEFAULT '',
  `createdAt` int(11) NOT NULL,
  `updatedAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_files`
--

CREATE TABLE `wc_files` (
  `idx` int(10) UNSIGNED NOT NULL,
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `entity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `userIdx` int(10) UNSIGNED NOT NULL,
  `code` varchar(64) NOT NULL DEFAULT '',
  `path` varbinary(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(32) NOT NULL,
  `size` int(10) UNSIGNED NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_friends`
--

CREATE TABLE `wc_friends` (
  `idx` int(10) UNSIGNED NOT NULL,
  `myIdx` int(10) UNSIGNED NOT NULL,
  `otherIdx` int(10) UNSIGNED NOT NULL,
  `block` char(1) NOT NULL DEFAULT '',
  `reason` text NOT NULL DEFAULT '',
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_in_app_purchase`
--

CREATE TABLE `wc_in_app_purchase` (
  `idx` int(10) UNSIGNED NOT NULL,
  `userIdx` int(10) UNSIGNED NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT '',
  `platform` varchar(7) NOT NULL,
  `productID` varchar(32) NOT NULL,
  `purchaseID` varchar(128) NOT NULL,
  `price` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `applicationUsername` varchar(255) NOT NULL DEFAULT '',
  `transactionDate` varchar(255) NOT NULL DEFAULT '',
  `productIdentifier` varchar(32) NOT NULL DEFAULT '',
  `quantity` varchar(255) NOT NULL DEFAULT '',
  `transactionIdentifier` varchar(255) NOT NULL DEFAULT '',
  `transactionTimeStamp` varchar(255) NOT NULL DEFAULT '',
  `localVerificationData` mediumtext NOT NULL,
  `serverVerificationData` mediumtext NOT NULL,
  `localVerificationData_packageName` varchar(64) NOT NULL DEFAULT '',
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_metas`
--

CREATE TABLE `wc_metas` (
  `idx` int(10) UNSIGNED NOT NULL,
  `taxonomy` varchar(32) NOT NULL,
  `entity` int(11) NOT NULL,
  `code` varchar(255) NOT NULL DEFAULT '',
  `data` longtext NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_posts`
--

CREATE TABLE `wc_posts` (
  `idx` int(10) UNSIGNED NOT NULL,
  `rootIdx` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `parentIdx` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `categoryIdx` int(10) UNSIGNED NOT NULL,
  `relationIdx` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `userIdx` int(10) UNSIGNED NOT NULL,
  `otherUserIdx` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `subcategory` varchar(64) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(255) NOT NULL DEFAULT '',
  `content` longtext DEFAULT '',
  `private` char(1) NOT NULL DEFAULT '',
  `privateTitle` varchar(255) NOT NULL DEFAULT '',
  `privateContent` longtext DEFAULT '',
  `noOfComments` int(11) NOT NULL DEFAULT 0,
  `noOfViews` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `reminder` char(1) NOT NULL DEFAULT '',
  `listOrder` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `files` text DEFAULT '',
  `Y` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `N` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `report` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `code` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `companyName` varchar(255) NOT NULL DEFAULT '',
  `phoneNo` varchar(255) NOT NULL DEFAULT '',
  `countryCode` char(2) NOT NULL DEFAULT '',
  `province` varchar(64) NOT NULL DEFAULT '',
  `city` varchar(64) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `zipcode` varchar(16) NOT NULL DEFAULT '',
  `Ymd` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `readAt` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `updatedAt` int(10) UNSIGNED NOT NULL,
  `deletedAt` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `beginAt` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `endAt` int(10) UNSIGNED NOT NULL DEFAULT 0
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
  `topic` varchar(64) NOT NULL DEFAULT '',
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_search_keys`
--

CREATE TABLE `wc_search_keys` (
  `idx` int(10) UNSIGNED NOT NULL,
  `searchKey` varchar(64) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_shopping_mall_orders`
--

CREATE TABLE `wc_shopping_mall_orders` (
  `idx` int(11) UNSIGNED NOT NULL,
  `userIdx` int(10) UNSIGNED NOT NULL,
  `confirmedAt` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `info` text NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_translations`
--

CREATE TABLE `wc_translations` (
  `idx` int(10) UNSIGNED NOT NULL,
  `language` varchar(16) NOT NULL,
  `code` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_users`
--

CREATE TABLE `wc_users` (
  `idx` int(10) UNSIGNED NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firebaseUid` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(32) NOT NULL DEFAULT '',
  `nickname` varchar(32) NOT NULL DEFAULT '',
  `photoUrl` varchar(255) NOT NULL DEFAULT '',
  `point` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `block` char(1) NOT NULL DEFAULT '',
  `phoneNo` varchar(32) NOT NULL DEFAULT '',
  `gender` char(1) NOT NULL DEFAULT '',
  `birthdate` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `domain` varchar(64) NOT NULL DEFAULT '',
  `countryCode` char(2) NOT NULL DEFAULT '',
  `province` varchar(32) NOT NULL DEFAULT '',
  `city` varchar(32) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `zipcode` varchar(32) NOT NULL DEFAULT '',
  `provider` varchar(16) NOT NULL DEFAULT '',
  `verifier` varchar(12) NOT NULL DEFAULT '',
  `createdAt` int(10) UNSIGNED NOT NULL,
  `updatedAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `wc_user_activities`
--

CREATE TABLE `wc_user_activities` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fromUserIdx` int(10) UNSIGNED NOT NULL,
  `toUserIdx` int(10) UNSIGNED NOT NULL,
  `action` varchar(32) NOT NULL,
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
-- 테이블 구조 `x.for.del.wc_point_histories`
--

CREATE TABLE `x.for.del.wc_point_histories` (
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

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `wc_advertisement_point_settings`
--
ALTER TABLE `wc_advertisement_point_settings`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `countryCode` (`countryCode`);

--
-- 테이블의 인덱스 `wc_cache`
--
ALTER TABLE `wc_cache`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `wc_categories`
--
ALTER TABLE `wc_categories`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `domain` (`domain`),
  ADD KEY `countryCode` (`countryCode`),
  ADD KEY `userIdx` (`userIdx`);

--
-- 테이블의 인덱스 `wc_countries`
--
ALTER TABLE `wc_countries`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `countryCode2` (`2digitCode`),
  ADD UNIQUE KEY `countryCode3` (`3digitCode`),
  ADD UNIQUE KEY `isoCode` (`ISONumbericCode`);

--
-- 테이블의 인덱스 `wc_files`
--
ALTER TABLE `wc_files`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `userIdx` (`userIdx`),
  ADD KEY `taxonomy_entity` (`taxonomy`,`entity`),
  ADD KEY `code` (`code`);

--
-- 테이블의 인덱스 `wc_friends`
--
ALTER TABLE `wc_friends`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `myIdx_otherIdx_block` (`myIdx`,`otherIdx`,`block`),
  ADD KEY `updatedAt` (`updatedAt`);

--
-- 테이블의 인덱스 `wc_in_app_purchase`
--
ALTER TABLE `wc_in_app_purchase`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `status` (`status`),
  ADD KEY `userIdx` (`userIdx`),
  ADD KEY `productID` (`productID`);

--
-- 테이블의 인덱스 `wc_metas`
--
ALTER TABLE `wc_metas`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `taxonomy_entity_code` (`taxonomy`,`entity`,`code`),
  ADD KEY `code` (`code`);

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
  ADD KEY `path` (`path`),
  ADD KEY `relationIdx` (`relationIdx`),
  ADD KEY `Ymd` (`Ymd`),
  ADD KEY `code` (`code`),
  ADD KEY `report` (`report`),
  ADD KEY `noOfComments` (`noOfComments`),
  ADD KEY `otherUserIdx` (`otherUserIdx`),
  ADD KEY `noOfViews` (`noOfViews`),
  ADD KEY `listOrder` (`listOrder`),
  ADD KEY `reminder` (`reminder`);
ALTER TABLE `wc_posts` ADD FULLTEXT KEY `title` (`title`);
ALTER TABLE `wc_posts` ADD FULLTEXT KEY `content` (`content`);

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
  ADD UNIQUE KEY ` token_topic` (`token`,`topic`) USING BTREE,
  ADD KEY `topic` (`topic`);

--
-- 테이블의 인덱스 `wc_search_keys`
--
ALTER TABLE `wc_search_keys`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `searchKey` (`searchKey`),
  ADD KEY `createdAt` (`createdAt`);

--
-- 테이블의 인덱스 `wc_shopping_mall_orders`
--
ALTER TABLE `wc_shopping_mall_orders`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `confirmed` (`confirmedAt`);

--
-- 테이블의 인덱스 `wc_translations`
--
ALTER TABLE `wc_translations`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `language_code` (`language`,`code`),
  ADD KEY `code` (`code`);

--
-- 테이블의 인덱스 `wc_users`
--
ALTER TABLE `wc_users`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `point` (`point`),
  ADD KEY `birthdate` (`birthdate`),
  ADD KEY `name` (`name`),
  ADD KEY `phoneNo` (`phoneNo`),
  ADD KEY `countryCode` (`countryCode`),
  ADD KEY `firebaseUid` (`firebaseUid`),
  ADD KEY `block` (`block`);

--
-- 테이블의 인덱스 `wc_user_activities`
--
ALTER TABLE `wc_user_activities`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `createdAt` (`createdAt`),
  ADD KEY `createdAt_fromUserIdx_reason` (`idx`,`fromUserIdx`,`toUserIdx`) USING BTREE,
  ADD KEY `fromUserIdx_toUserIdx_action` (`fromUserIdx`,`toUserIdx`,`action`) USING BTREE,
  ADD KEY `taxonomy_entity_action` (`taxonomy`,`entity`,`action`) USING BTREE;

--
-- 테이블의 인덱스 `x.for.del.wc_point_histories`
--
ALTER TABLE `x.for.del.wc_point_histories`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `createdAt` (`createdAt`),
  ADD KEY `createdAt_fromUserIdx_reason` (`idx`,`fromUserIdx`,`toUserIdx`) USING BTREE,
  ADD KEY `fromUserIdx_toUserIdx_reason` (`fromUserIdx`,`toUserIdx`,`reason`) USING BTREE;

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `wc_advertisement_point_settings`
--
ALTER TABLE `wc_advertisement_point_settings`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_cache`
--
ALTER TABLE `wc_cache`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_categories`
--
ALTER TABLE `wc_categories`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_countries`
--
ALTER TABLE `wc_countries`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_files`
--
ALTER TABLE `wc_files`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_friends`
--
ALTER TABLE `wc_friends`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_in_app_purchase`
--
ALTER TABLE `wc_in_app_purchase`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_metas`
--
ALTER TABLE `wc_metas`
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
-- 테이블의 AUTO_INCREMENT `wc_search_keys`
--
ALTER TABLE `wc_search_keys`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_shopping_mall_orders`
--
ALTER TABLE `wc_shopping_mall_orders`
  MODIFY `idx` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_translations`
--
ALTER TABLE `wc_translations`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_users`
--
ALTER TABLE `wc_users`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `wc_user_activities`
--
ALTER TABLE `wc_user_activities`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `x.for.del.wc_point_histories`
--
ALTER TABLE `x.for.del.wc_point_histories`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
