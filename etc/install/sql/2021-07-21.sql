-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- 생성 시간: 21-07-21 09:57
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
  `verifiedUserCreatePost` char(1) NOT NULL DEFAULT '',
  `verifiedUserCreateComment` char(1) NOT NULL DEFAULT '',
  `verifiedUserView` char(1) NOT NULL DEFAULT '',
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
  `koreanName` varchar(64) NOT NULL,
  `englishName` varchar(64) NOT NULL,
  `officialName` varchar(64) NOT NULL,
  `alpha2` char(2) NOT NULL,
  `alpha3` char(3) NOT NULL,
  `currencyCode` char(3) NOT NULL,
  `currencyKoreanName` varchar(16) NOT NULL,
  `currencySymbol` varchar(16) NOT NULL,
  `numericCode` smallint(6) UNSIGNED ZEROFILL NOT NULL,
  `latitude` varchar(16) NOT NULL DEFAULT '',
  `longitude` varchar(16) NOT NULL DEFAULT '',
  `createdAt` int(11) NOT NULL,
  `updatedAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `wc_countries`
--

INSERT INTO `wc_countries` (`idx`, `koreanName`, `englishName`, `officialName`, `alpha2`, `alpha3`, `currencyCode`, `currencyKoreanName`, `currencySymbol`, `numericCode`, `latitude`, `longitude`, `createdAt`, `updatedAt`) VALUES
(1, '아프가니스탄', 'Afghanistan', 'افغانستان', 'AF', 'AFG', 'AFN', '', '', 000004, '33.93911', '67.709953', 1617533769, 1617533769),
(2, '알바니아', 'Albania', 'Shqipëria', 'AL', 'ALB', 'ALL', '렉', 'L', 000008, '41.153332', '20.168331', 1617533769, 1617533769),
(3, '남극', 'Antarctica', 'Antarctica', 'AQ', 'ATA', '', '', '', 000010, '-75.250973', '-0.071389', 1617533769, 1617533769),
(4, '알제리', 'Algeria', 'الجزائر', 'DZ', 'DZA', 'DZD', '디나르', 'دج', 000012, '28.033886', '1.659626', 1617533769, 1617533769),
(5, '아메리칸사모아', 'American Samoa', 'American Samoa', 'AS', 'ASM', '', '', '', 000016, '-14.270972', '-170.132217', 1617533769, 1617533769),
(6, '안도라', 'Andorra', 'Andorra', 'AD', 'AND', 'EUR', '유로', '€', 000020, '42.546245', '1.601554', 1617533769, 1617533769),
(7, '앙골라', 'Angola', 'Angola', 'AO', 'AGO', 'AOA', '', '', 000024, '-11.202692', '17.873887', 1617533769, 1617533769),
(8, '앤티가 바부다', 'Antigua and Barbuda', 'Antigua and Barbuda', 'AG', 'ATG', 'XCD', '달러', 'EC$', 000028, '17.060816', '-61.796428', 1617533769, 1617533769),
(9, '아제르바이잔', 'Azerbaijan', 'Azərbaycan', 'AZ', 'AZE', 'AZN', '', '', 000031, '40.143105', '47.576927', 1617533769, 1617533769),
(10, '아르헨티나', 'Argentina', 'Argentina', 'AR', 'ARG', 'ARS', '페소', '$', 000032, '-38.416097', '-63.616672', 1617533769, 1617533769),
(11, '오스트레일리아', 'Australia', 'Australia', 'AU', 'AUS', 'AUD', '달러', '$', 000036, '-25.274398', '133.775136', 1617533769, 1617533769),
(12, '오스트리아', 'Austria', 'Österreich', 'AT', 'AUT', 'EUR', '유로', '€', 000040, '47.516231', '14.550072', 1617533769, 1617533769),
(13, '바하마', 'Bahamas', 'Bahamas', 'BS', 'BHS', 'BSD', '달러', 'B$', 000044, '25.03428', '-77.39628', 1617533769, 1617533769),
(14, '바레인', 'Bahrain', 'البحرين', 'BH', 'BHR', 'BHD', '디나르', '.د.ب', 000048, '25.930414', '50.637772', 1617533769, 1617533769),
(15, '방글라데시', 'Bangladesh', 'বাংলাদেশ', 'BD', 'BGD', 'BDT', '타카', 'Tk', 000050, '23.684994', '90.356331', 1617533769, 1617533769),
(16, '아르메니아', 'Armenia', 'Հայաստան', 'AM', 'ARM', 'AMD', '', '', 000051, '40.069099', '45.038189', 1617533769, 1617533769),
(17, '바베이도스', 'Barbados', 'Barbados', 'BB', 'BRB', 'BBD', '달러', 'BBD', 000052, '13.193887', '-59.543198', 1617533769, 1617533769),
(18, '벨기에', 'Belgium', 'België', 'BE', 'BEL', 'EUR', '유로', '€', 000056, '50.503887', '4.469936', 1617533769, 1617533769),
(19, '버뮤다', 'Bermuda', 'Bermuda', 'BM', 'BMU', '', '', '', 000060, '32.321384', '-64.75737', 1617533769, 1617533769),
(20, '부탄', 'Bhutan', 'འབྲུག་ཡུལ', 'BT', 'BTN', 'BTN', '눌트럼', 'Nu.', 000064, '27.514162', '90.433601', 1617533769, 1617533769),
(21, '볼리비아', 'Bolivia', 'Bolivia', 'BO', 'BOL', 'BOB', '볼리비아노', 'Bs', 000068, '-16.290154', '-63.588653', 1617533769, 1617533769),
(22, '보스니아 헤르체고비나', 'Bosnia and Herzegovina', 'Bosna i Hercegovina', 'BA', 'BIH', 'BAM', '', '', 000070, '43.915886', '17.679076', 1617533769, 1617533769),
(23, '보츠와나', 'Botswana', 'Botswana', 'BW', 'BWA', 'BWP', '풀라', 'P', 000072, '-22.328474', '24.684866', 1617533769, 1617533769),
(24, '부베 섬', 'Bouvet Island', 'Bouvet Island', 'BV', 'BVT', '', '', '', 000074, '-54.423199', '3.413194', 1617533769, 1617533769),
(25, '브라질', 'Brazil', 'Brasil', 'BR', 'BRA', 'BRL', '레알', 'R$', 000076, '-14.235004', '-51.92528', 1617533769, 1617533769),
(26, '벨리즈', 'Belize', 'Belize', 'BZ', 'BLZ', 'BZD', '달러', 'BZ$', 000084, '17.189877', '-88.49765', 1617533769, 1617533769),
(27, '영국령 인도양 지역', 'British Indian Ocean Territory', 'British Indian Ocean Territory', 'IO', 'IOT', '', '', '', 000086, '-6.343194', '71.876519', 1617533769, 1617533769),
(28, '솔로몬 제도', 'Solomon Islands', 'Solomon Islands', 'SB', 'SLB', 'SBD', '달러', 'SI$', 000090, '-9.64571', '160.156194', 1617533769, 1617533769),
(29, '영국령 버진아일랜드', 'British Virgin Islands', 'Virgin Islands, British', 'VG', 'VGB', '', '', '', 000092, '18.420695', '-64.639968', 1617533769, 1617533769),
(30, '브루나이', 'Brunei', 'Brunei Darussalam', 'BN', 'BRN', 'BND', '달러', 'B$', 000096, '4.535277', '114.727669', 1617533769, 1617533769),
(31, '불가리아', 'Bulgaria', 'България', 'BG', 'BGR', 'BGN', '레프', 'лв', 000100, '42.733883', '25.48583', 1617533769, 1617533769),
(32, '미얀마', 'Myanmar [Burma]', 'Myanmar(Burma)', 'MM', 'MMR', 'MMK', '차트', 'K', 000104, '21.913965', '95.956223', 1617533769, 1617533769),
(33, '부룬디', 'Burundi', 'Uburundi', 'BI', 'BDI', 'BIF', '프랑', 'FBu', 000108, '-3.373056', '29.918886', 1617533769, 1617533769),
(34, '벨라루스', 'Belarus', 'Белару́сь', 'BY', 'BLR', 'BYN', '', '', 000112, '53.709807', '27.953389', 1617533769, 1617533769),
(35, '캄보디아', 'Cambodia', 'Kampuchea', 'KH', 'KHM', 'KHR', '리엘', 'KHR', 000116, '12.565679', '104.990963', 1617533769, 1617533769),
(36, '카메룬', 'Cameroon', 'Cameroun', 'CM', 'CMR', 'XAF', '(BEAC)', 'BEAC', 000120, '7.369722', '12.354722', 1617533769, 1617533769),
(37, '캐나다', 'Canada', 'Canada', 'CA', 'CAN', 'CAD', '달러', 'C$', 000124, '56.130366', '-106.346771', 1617533769, 1617533769),
(38, '카보베르데', 'Cape Verde', 'Cabo Verde', 'CV', 'CPV', '', '', '', 000132, '16.002082', '-24.013197', 1617533769, 1617533769),
(39, '케이맨 제도', 'Cayman Islands', 'Cayman Islands', 'KY', 'CYM', 'KYD', '달러', '$', 000136, '19.513469', '-80.566956', 1617533769, 1617533769),
(40, '중앙아프리카 공화국', 'Central African Republic', 'République Centrafricaine', 'CF', 'CAF', 'XAF', '(BEAC)', 'BEAC', 000140, '6.611111', '20.939444', 1617533769, 1617533769),
(41, '스리랑카', 'Sri Lanka', 'Sri Lanka', 'LK', 'LKA', 'LKR', '루피', 'ரூ', 000144, '7.873054', '80.771797', 1617533769, 1617533769),
(42, '차드', 'Chad', 'Tchad', 'TD', 'TCD', 'XAF', '(BEAC)', 'BEAC', 000148, '15.454166', '18.732207', 1617533769, 1617533769),
(43, '칠레', 'Chile', 'Chile', 'CL', 'CHL', 'CLP', '페소', '$', 000152, '-35.675147', '-71.542969', 1617533769, 1617533769),
(44, '중화인민공화국', 'China', '中国', 'CN', 'CHN', 'CNY', '위안', '¥', 000156, '35.86166', '104.195397', 1617533769, 1617533769),
(45, '중화민국', 'Taiwan', '台灣', 'TW', 'TWN', 'TWD', '달러', 'NT$', 000158, '23.69781', '120.960515', 1617533769, 1617533769),
(46, '크리스마스 섬', 'Christmas Island', 'Christmas Island', 'CX', 'CXR', '', '', '', 000162, '-10.447525', '105.690449', 1617533769, 1617533769),
(47, '코코스 제도', 'Cocos [Keeling] Islands', 'Cocos Islands', 'CC', 'CCK', '', '', '', 000166, '-12.164165', '96.870956', 1617533769, 1617533769),
(48, '콜롬비아', 'Colombia', 'Colombia', 'CO', 'COL', 'COP', '페소', '$', 000170, '4.570868', '-74.297333', 1617533769, 1617533769),
(49, '코모로', 'Comoros', 'Comores', 'KM', 'COM', 'KMF', '프랑', 'KMF', 000174, '-11.875001', '43.872219', 1617533769, 1617533769),
(50, '마요트', 'Mayotte', 'Mayotte', 'YT', 'MYT', '', '', '', 000175, '-12.8275', '45.166244', 1617533769, 1617533769),
(51, '콩고 공화국', 'Congo [Republic]', 'Congo', 'CG', 'COG', 'XAF', '(BEAC)', 'BEAC', 000178, '-0.228021', '15.827659', 1617533769, 1617533769),
(52, '콩고 민주 공화국', 'Congo [DRC]', 'Congo, Democratic Republic of the', 'CD', 'COD', 'CDF', '', '', 000180, '-4.038333', '21.758664', 1617533769, 1617533769),
(53, '쿡 제도', 'Cook Islands', 'Cook Islands', 'CK', 'COK', '', '', '', 000184, '-21.236736', '-159.777671', 1617533769, 1617533769),
(54, '코스타리카', 'Costa Rica', 'Costa Rica', 'CR', 'CRI', 'CRC', '콜론', '₡', 000188, '9.748917', '-83.753428', 1617533769, 1617533769),
(55, '크로아티아', 'Croatia', 'Hrvatska', 'HR', 'HRV', 'HRK', '쿠나', 'kn', 000191, '45.1', '15.2', 1617533769, 1617533769),
(56, '쿠바', 'Cuba', 'Cuba', 'CU', 'CUB', 'CUP', '페소', '$MN', 000192, '21.521757', '-77.781167', 1617533769, 1617533769),
(57, '키프로스', 'Cyprus', 'Κυπρος', 'CY', 'CYP', 'EUR', '유로', '€', 000196, '35.126413', '33.429859', 1617533769, 1617533769),
(58, '체코', 'Czech Republic', 'Česko', 'CZ', 'CZE', 'CZK', '코루나', 'Kč', 000203, '49.817492', '15.472962', 1617533769, 1617533769),
(59, '베냉', 'Benin', 'Bénin', 'BJ', 'BEN', 'XOF', '(BCEAO)', 'BCEAO', 000204, '9.30769', '2.315834', 1617533769, 1617533769),
(60, '덴마크', 'Denmark', 'Danmark', 'DK', 'DNK', 'DKK', '크로네', 'kr', 000208, '56.26392', '9.501785', 1617533769, 1617533769),
(61, '도미니카 연방', 'Dominica', 'Dominica', 'DM', 'DMA', 'XCD', '달러', 'EC$', 000212, '15.414999', '-61.370976', 1617533769, 1617533769),
(62, '도미니카 공화국', 'Dominican Republic', 'Dominican Republic', 'DO', 'DOM', 'DOP', '페소', 'RD$', 000214, '18.735693', '-70.162651', 1617533769, 1617533769),
(63, '에콰도르', 'Ecuador', 'Ecuador', 'EC', 'ECU', 'USD', '달러', '$', 000218, '-1.831239', '-78.183406', 1617533769, 1617533769),
(64, '엘살바도르', 'El Salvador', 'El Salvador', 'SV', 'SLV', 'USD', '달러', '$', 000222, '13.794185', '-88.89653', 1617533769, 1617533769),
(65, '적도 기니', 'Equatorial Guinea', 'Guinea Ecuatorial', 'GQ', 'GNQ', '', '', '', 000226, '1.650801', '10.267895', 1617533769, 1617533769),
(66, '에티오피아', 'Ethiopia', 'Ityop\'iya', 'ET', 'ETH', 'ETB', '비르', 'Br', 000231, '9.145', '40.489673', 1617533769, 1617533769),
(67, '에리트레아', 'Eritrea', 'Ertra', 'ER', 'ERI', 'ERN', '', '', 000232, '15.179384', '39.782334', 1617533769, 1617533769),
(68, '에스토니아', 'Estonia', 'Eesti', 'EE', 'EST', 'EUR', '유로', '€', 000233, '58.595272', '25.013607', 1617533769, 1617533769),
(69, '페로 제도', 'Faroe Islands', 'Faroe Islands', 'FO', 'FRO', '', '', '', 000234, '61.892635', '-6.911806', 1617533769, 1617533769),
(70, '포클랜드 제도', 'Falkland Islands [Islas Malvinas]', 'Falkland Islands', 'FK', 'FLK', '', '', '', 000238, '-51.796253', '-59.523613', 1617533769, 1617533769),
(71, '사우스조지아 사우스샌드위치 제도', 'South Georgia and the South Sandwich Islands', 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', '', '', '', 000239, '-54.429579', '-36.587909', 1617533769, 1617533769),
(72, '피지', 'Fiji', 'Fiji', 'FJ', 'FJI', 'FJD', '달러', 'FJ$', 000242, '-16.578193', '179.414413', 1617533769, 1617533769),
(73, '핀란드', 'Finland', 'Suomi', 'FI', 'FIN', 'EUR', '유로', '€', 000246, '61.92411', '25.748151', 1617533769, 1617533769),
(74, '올란드 제도', 'ALAND ISLANDS', 'Aland Islands', 'AX', 'ALA', '', '', '', 000248, '', '', 1617533769, 1617533769),
(75, '프랑스', 'France', 'France', 'FR', 'FRA', 'EUR', '유로', '€', 000250, '46.227638', '2.213749', 1617533769, 1617533769),
(76, '프랑스령 기아나', 'French Guiana', 'French Guiana', 'GF', 'GUF', '', '', '', 000254, '3.933889', '-53.125782', 1617533769, 1617533769),
(77, '프랑스령 폴리네시아', 'French Polynesia', 'French Polynesia', 'PF', 'PYF', 'XPF', '프랑', 'F', 000258, '-17.679742', '-149.406843', 1617533769, 1617533769),
(78, '프랑스령 남부와 남극 지역', 'French Southern Territories', 'French Southern Territories', 'TF', 'ATF', '', '', '', 000260, '-49.280366', '69.348557', 1617533769, 1617533769),
(79, '지부티', 'Djibouti', 'Djibouti', 'DJ', 'DJI', 'DJF', '프랑', 'Fdj', 000262, '11.825138', '42.590275', 1617533769, 1617533769),
(80, '가봉', 'Gabon', 'Gabon', 'GA', 'GAB', 'XAF', '(BEAC)', 'BEAC', 000266, '-0.803689', '11.609444', 1617533769, 1617533769),
(81, '조지아', 'Georgia', 'საქართველო', 'GE', 'GEO', 'GEL', '', '', 000268, '42.315407', '43.356892', 1617533769, 1617533769),
(82, '감비아', 'Gambia', 'Gambia', 'GM', 'GMB', 'GMD', '달라시', 'D', 000270, '13.443182', '-15.310139', 1617533769, 1617533769),
(83, '팔레스타인', 'Palestinian Territories', 'Palestinian Territories', 'PS', 'PSE', '', '', '', 000275, '31.952162', '35.233154', 1617533769, 1617533769),
(84, '독일', 'Germany', 'Deutschland', 'DE', 'DEU', 'EUR', '유로', '€', 000276, '51.165691', '10.451526', 1617533769, 1617533769),
(85, '가나', 'Ghana', 'Ghana', 'GH', 'GHA', 'GHS', '세디', 'GHS', 000288, '7.946527', '-1.023194', 1617533769, 1617533769),
(86, '지브롤터', 'Gibraltar', 'Gibraltar', 'GI', 'GIB', 'GIP', '', '', 000292, '36.137741', '-5.345374', 1617533769, 1617533769),
(87, '키리바시', 'Kiribati', 'Kiribati', 'KI', 'KIR', 'AUD', '달러', '$', 000296, '-3.370417', '-168.734039', 1617533769, 1617533769),
(88, '그리스', 'Greece', 'Ελλάς', 'GR', 'GRC', 'EUR', '유로', '€', 000300, '39.074208', '21.824312', 1617533769, 1617533769),
(89, '그린란드', 'Greenland', 'Greenland', 'GL', 'GRL', '', '', '', 000304, '71.706936', '-42.604303', 1617533769, 1617533769),
(90, '그레나다', 'Grenada', 'Grenada', 'GD', 'GRD', 'XCD', '달러', 'EC$', 000308, '12.262776', '-61.604171', 1617533769, 1617533769),
(91, '과들루프', 'Guadeloupe', 'Guadeloupe', 'GP', 'GLP', '', '', '', 000312, '16.995971', '-62.067641', 1617533769, 1617533769),
(92, '괌', 'Guam', 'Guam', 'GU', 'GUM', '', '', '', 000316, '13.444304', '144.793731', 1617533769, 1617533769),
(93, '과테말라', 'Guatemala', 'Guatemala', 'GT', 'GTM', 'GTQ', '퀘찰', 'Q', 000320, '15.783471', '-90.230759', 1617533769, 1617533769),
(94, '기니', 'Guinea', 'Guinée', 'GN', 'GIN', 'GNF', '프랑', 'FG', 000324, '9.945587', '-9.696645', 1617533769, 1617533769),
(95, '가이아나', 'Guyana', 'Guyana', 'GY', 'GUY', 'GYD', '달러', 'GY$', 000328, '4.860416', '-58.93018', 1617533769, 1617533769),
(96, '아이티', 'Haiti', 'Haïti', 'HT', 'HTI', 'HTG', '구르드', '', 000332, '18.971187', '-72.285215', 1617533769, 1617533769),
(97, '허드 맥도널드 제도', 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', 'HM', 'HMD', '', '', '', 000334, '-53.08181', '73.504158', 1617533769, 1617533769),
(98, '바티칸 시국', 'Vatican City', 'Città del Vaticano', 'VA', 'VAT', '', '', '', 000336, '41.902916', '12.453389', 1617533769, 1617533769),
(99, '온두라스', 'Honduras', 'Honduras', 'HN', 'HND', 'HNL', '렘피라', 'L', 000340, '15.199999', '-86.241905', 1617533769, 1617533769),
(100, '홍콩', 'Hong Kong', 'Hong Kong', 'HK', 'HKG', 'HKD', '달러', 'HK$', 000344, '22.396428', '114.109497', 1617533769, 1617533769),
(101, '헝가리', 'Hungary', 'Magyarország', 'HU', 'HUN', 'HUF', '포린트', 'Ft', 000348, '47.162494', '19.503304', 1617533769, 1617533769),
(102, '아이슬란드', 'Iceland', 'Ísland', 'IS', 'ISL', 'ISK', '크로네', 'kr', 000352, '64.963051', '-19.020835', 1617533769, 1617533769),
(103, '인도', 'India', 'India', 'IN', 'IND', 'INR', '루피', 'Rs.', 000356, '20.593684', '78.96288', 1617533769, 1617533769),
(104, '인도네시아', 'Indonesia', 'Indonesia', 'ID', 'IDN', 'IDR', '루피아', 'Rp', 000360, '-0.789275', '113.921327', 1617533769, 1617533769),
(105, '이란', 'Iran', 'ایران', 'IR', 'IRN', 'IRR', '리알', '', 000364, '32.427908', '53.688046', 1617533769, 1617533769),
(106, '이라크', 'Iraq', 'العراق', 'IQ', 'IRQ', 'IQD', '디나르', 'ع.د', 000368, '33.223191', '43.679291', 1617533769, 1617533769),
(107, '아일랜드', 'Ireland', 'Ireland', 'IE', 'IRL', 'EUR', '유로', '€', 000372, '53.41291', '-8.24389', 1617533769, 1617533769),
(108, '이스라엘', 'Israel', 'ישראל', 'IL', 'ISR', 'ILS', '셰켈', '₪', 000376, '31.046051', '34.851612', 1617533769, 1617533769),
(109, '이탈리아', 'Italy', 'Italia', 'IT', 'ITA', 'EUR', '유로', '€', 000380, '41.87194', '12.56738', 1617533769, 1617533769),
(110, '코트디부아르', 'Côte d\'Ivoire', 'Côte d\'Ivoire', 'CI', 'CIV', 'XOF', '(BCEAO)', 'BCEAO', 000384, '7.539989', '-5.54708', 1617533769, 1617533769),
(111, '자메이카', 'Jamaica', 'Jamaica', 'JM', 'JAM', 'JMD', '', '', 000388, '18.109581', '-77.297508', 1617533769, 1617533769),
(112, '일본', 'Japan', '日本', 'JP', 'JPN', 'JPY', '엔', '¥', 000392, '36.204824', '138.252924', 1617533769, 1617533769),
(113, '카자흐스탄', 'Kazakhstan', 'Қазақстан', 'KZ', 'KAZ', 'KZT', '텡게', 'KZT', 000398, '48.019573', '66.923684', 1617533769, 1617533769),
(114, '요르단', 'Jordan', 'الاردن', 'JO', 'JOR', 'JOD', '디나르', 'JOD', 000400, '30.585164', '36.238414', 1617533769, 1617533769),
(115, '케냐', 'Kenya', 'Kenya', 'KE', 'KEN', 'KES', '실링', 'KSh', 000404, '-0.023559', '37.906193', 1617533769, 1617533769),
(116, '조선민주주의인민공화국', 'North Korea', '조선', 'KP', 'PRK', 'KPW', '원', '₩', 000408, '40.339852', '127.510093', 1617533769, 1617533769),
(117, '대한민국', 'South Korea', '한국', 'KR', 'KOR', 'KRW', '원', '₩', 000410, '35.907757', '127.766922', 1617533769, 1617533769),
(118, '쿠웨이트', 'Kuwait', 'الكويت', 'KW', 'KWT', 'KWD', '디나르', 'د.ك', 000414, '29.31166', '47.481766', 1617533769, 1617533769),
(119, '키르기스스탄', 'Kyrgyzstan', 'Кыргызстан', 'KG', 'KGZ', 'KGS', '솜', 'KGS', 000417, '41.20438', '74.766098', 1617533769, 1617533769),
(120, '라오스', 'Laos', 'ນລາວ', 'LA', 'LAO', 'LAK', '', '', 000418, '19.85627', '102.495496', 1617533769, 1617533769),
(121, '레바논', 'Lebanon', 'لبنان', 'LB', 'LBN', 'LBP', '', '', 000422, '33.854721', '35.862285', 1617533769, 1617533769),
(122, '레소토', 'Lesotho', 'Lesotho', 'LS', 'LSO', 'LSL', '', '', 000426, '-29.609988', '28.233608', 1617533769, 1617533769),
(123, '라트비아', 'Latvia', 'Latvija', 'LV', 'LVA', 'LVL', '', '', 000428, '56.879635', '24.603189', 1617533769, 1617533769),
(124, '라이베리아', 'Liberia', 'Liberia', 'LR', 'LBR', 'LRD', '', '', 000430, '6.428055', '-9.429499', 1617533769, 1617533769),
(125, '리비아', 'Libya', 'ليبيا', 'LY', 'LBY', 'LYD', '', '', 000434, '26.3351', '17.228331', 1617533769, 1617533769),
(126, '리히텐슈타인', 'Liechtenstein', 'Liechtenstein', 'LI', 'LIE', 'CHF', '프랑', 'CHF', 000438, '47.166', '9.555373', 1617533769, 1617533769),
(127, '리투아니아', 'Lithuania', 'Lietuva', 'LT', 'LTU', 'EUR', '유로', '€', 000440, '55.169438', '23.881275', 1617533769, 1617533769),
(128, '룩셈부르크', 'Luxembourg', 'Lëtzebuerg', 'LU', 'LUX', 'EUR', '유로', '€', 000442, '49.815273', '6.129583', 1617533769, 1617533769),
(129, '마카오', 'Macau', 'Macao', 'MO', 'MAC', 'MOP', '파타카', '$', 000446, '22.198745', '113.543873', 1617533769, 1617533769),
(130, '마다가스카르', 'Madagascar', 'Madagasikara', 'MG', 'MDG', 'MGA', '', '', 000450, '-18.766947', '46.869107', 1617533769, 1617533769),
(131, '말라위', 'Malawi', 'Malawi', 'MW', 'MWI', 'MWK', '콰차', 'MK', 000454, '-13.254308', '34.301525', 1617533769, 1617533769),
(132, '말레이시아', 'Malaysia', 'Malaysia', 'MY', 'MYS', 'MYR', '링깃', 'RM', 000458, '4.210484', '101.975766', 1617533769, 1617533769),
(133, '몰디브', 'Maldives', 'ގުޖޭއްރާ ޔާއްރިހޫމްޖ', 'MV', 'MDV', 'MVR', '루피야', 'Rf', 000462, '3.202778', '73.22068', 1617533769, 1617533769),
(134, '말리', 'Mali', 'Mali', 'ML', 'MLI', 'XOF', '(BCEAO)', 'BCEAO', 000466, '17.570692', '-3.996166', 1617533769, 1617533769),
(135, '몰타', 'Malta', 'Malta', 'MT', 'MLT', 'EUR', '유로', '€', 000470, '35.937496', '14.375416', 1617533769, 1617533769),
(136, '마르티니크', 'Martinique', 'Martinique', 'MQ', 'MTQ', '', '', '', 000474, '14.641528', '-61.024174', 1617533769, 1617533769),
(137, '모리타니', 'Mauritania', 'موريتانيا', 'MR', 'MRT', 'MRO', '우기야', 'UM', 000478, '21.00789', '-10.940835', 1617533769, 1617533769),
(138, '모리셔스', 'Mauritius', 'Mauritius', 'MU', 'MUS', 'MUR', '루피', '₨', 000480, '-20.348404', '57.552152', 1617533769, 1617533769),
(139, '멕시코', 'Mexico', 'México', 'MX', 'MEX', 'MXN', '페소', '$', 000484, '23.634501', '-102.552784', 1617533769, 1617533769),
(140, '모나코', 'Monaco', 'Monaco', 'MC', 'MCO', 'EUR', '유로', '€', 000492, '43.750298', '7.412841', 1617533770, 1617533770),
(141, '몽골', 'Mongolia', 'Монгол Улс', 'MN', 'MNG', 'MNT', '투그릭', '₮', 000496, '46.862496', '103.846656', 1617533770, 1617533770),
(142, '몰도바', 'Moldova', 'Moldova', 'MD', 'MDA', 'MDL', '레우', 'MDL', 000498, '47.411631', '28.369885', 1617533770, 1617533770),
(143, '몬테네그로', 'Montenegro', 'Црна Гора', 'ME', 'MNE', 'EUR', '유로', '€', 000499, '42.708678', '19.37439', 1617533770, 1617533770),
(144, '몬트세랫', 'Montserrat', 'Montserrat', 'MS', 'MSR', 'XCD', '달러', 'EC$', 000500, '16.742498', '-62.187366', 1617533770, 1617533770),
(145, '모로코', 'Morocco', 'المغرب', 'MA', 'MAR', 'MAD', '디르함', 'د.م.', 000504, '31.791702', '-7.09262', 1617533770, 1617533770),
(146, '모잠비크', 'Mozambique', 'Moçambique', 'MZ', 'MOZ', 'MZN', '', '', 000508, '-18.665695', '35.529562', 1617533770, 1617533770),
(147, '오만', 'Oman', 'عمان', 'OM', 'OMN', 'OMR', '리알', 'ر.ع.', 000512, '21.512583', '55.923255', 1617533770, 1617533770),
(148, '나미비아', 'Namibia', 'Namibia', 'NA', 'NAM', 'NAD', '달러', 'N$', 000516, '-22.95764', '18.49041', 1617533770, 1617533770),
(149, '나우루', 'Nauru', 'Naoero', 'NR', 'NRU', 'AUD', '달러', '$', 000520, '-0.522778', '166.931503', 1617533770, 1617533770),
(150, '네팔', 'Nepal', 'नेपाल', 'NP', 'NPL', 'NPR', '루피', '₨', 000524, '28.394857', '84.124008', 1617533770, 1617533770),
(151, '네덜란드', 'Netherlands', 'Nederland', 'NL', 'NLD', 'EUR', '유로', '€', 000528, '52.132633', '5.291266', 1617533770, 1617533770),
(152, '네덜란드령 안틸레스', 'Netherlands Antilles', 'Netherlands Antilles', 'AN', 'ANT', '', '', '', 000530, '12.226079', '-69.060087', 1617533770, 1617533770),
(153, '아루바', 'Aruba', 'Aruba', 'AW', 'ABW', 'AWG', '플로린', 'ƒ', 000533, '12.52111', '-69.968338', 1617533770, 1617533770),
(154, '누벨칼레도니', 'New Caledonia', 'New Caledonia', 'NC', 'NCL', 'XPF', '프랑', 'F', 000540, '-20.904305', '165.618042', 1617533770, 1617533770),
(155, '바누아투', 'Vanuatu', 'Vanuatu', 'VU', 'VUT', 'VUV', '바투', 'Vt', 000548, '-15.376706', '166.959158', 1617533770, 1617533770),
(156, '뉴질랜드', 'New Zealand', 'New Zealand', 'NZ', 'NZL', 'NZD', '달러', '$', 000554, '-40.900557', '174.885971', 1617533770, 1617533770),
(157, '니카라과', 'Nicaragua', 'Nicaragua', 'NI', 'NIC', 'NIO', '코르도바', 'C$', 000558, '12.865416', '-85.207229', 1617533770, 1617533770),
(158, '니제르', 'Niger', 'Niger', 'NE', 'NER', 'XOF', '(BCEAO)', 'BCEAO', 000562, '17.607789', '8.081666', 1617533770, 1617533770),
(159, '나이지리아', 'Nigeria', 'Nigeria', 'NG', 'NGA', 'NGN', '나이라', '₦', 000566, '9.081999', '8.675277', 1617533770, 1617533770),
(160, '니우에', 'Niue', 'Niue', 'NU', 'NIU', '', '', '', 000570, '-19.054445', '-169.867233', 1617533770, 1617533770),
(161, '노퍽 섬', 'Norfolk Island', 'Norfolk Island', 'NF', 'NFK', '', '', '', 000574, '-29.040835', '167.954712', 1617533770, 1617533770),
(162, '노르웨이', 'Norway', 'Norge', 'NO', 'NOR', 'NOK', '크로네', 'kr', 000578, '60.472024', '8.468946', 1617533770, 1617533770),
(163, '북마리아나 제도', 'Northern Mariana Islands', 'Northern Mariana Islands', 'MP', 'MNP', '', '', '', 000580, '17.33083', '145.38469', 1617533770, 1617533770),
(164, '미국령 군소 제도', 'U.S. Minor Outlying Islands', 'United States minor outlying islands', 'UM', 'UMI', '', '', '', 000581, '', '', 1617533770, 1617533770),
(165, '미크로네시아 연방', 'Micronesia', 'Micronesia', 'FM', 'FSM', 'USD', '달러', '$', 000583, '7.425554', '150.550812', 1617533770, 1617533770),
(166, '마셜 제도', 'Marshall Islands', 'Marshall Islands', 'MH', 'MHL', '', '', '', 000584, '7.131474', '171.184478', 1617533770, 1617533770),
(167, '팔라우', 'Palau', 'Belau', 'PW', 'PLW', 'USD', '달러', '$', 000585, '7.51498', '134.58252', 1617533770, 1617533770),
(168, '파키스탄', 'Pakistan', 'پاکستان', 'PK', 'PAK', 'PKR', '루피', 'Rs.', 000586, '30.375321', '69.345116', 1617533770, 1617533770),
(169, '파나마', 'Panama', 'Panamá', 'PA', 'PAN', 'PAB', '발보아', 'B', 000591, '8.537981', '-80.782127', 1617533770, 1617533770),
(170, '파푸아 뉴기니', 'Papua New Guinea', 'Papua New Guinea', 'PG', 'PNG', 'PGK', '키나', 'K', 000598, '-6.314993', '143.95555', 1617533770, 1617533770),
(171, '파라과이', 'Paraguay', 'Paraguay', 'PY', 'PRY', 'PYG', '과라니', '', 000600, '-23.442503', '-58.443832', 1617533770, 1617533770),
(172, '페루', 'Peru', 'Perú', 'PE', 'PER', 'PEN', '누에보솔', 'S/.', 000604, '-9.189967', '-75.015152', 1617533770, 1617533770),
(173, '필리핀', 'Philippines', 'Pilipinas', 'PH', 'PHL', 'PHP', '페소', '₱', 000608, '12.879721', '121.774017', 1617533770, 1617533770),
(174, '핏케언 제도', 'Pitcairn Islands', 'Pitcairn', 'PN', 'PCN', '', '', '', 000612, '-24.703615', '-127.439308', 1617533770, 1617533770),
(175, '폴란드', 'Poland', 'Polska', 'PL', 'POL', 'PLN', '즈워티', 'zł', 000616, '51.919438', '19.145136', 1617533770, 1617533770),
(176, '포르투갈', 'Portugal', 'Portugal', 'PT', 'PRT', 'EUR', '유로', '€', 000620, '39.399872', '-8.224454', 1617533770, 1617533770),
(177, '기니비사우', 'Guinea-Bissau', 'Guiné-Bissau', 'GW', 'GNB', 'XOF', '(BCEAO)', 'BCEAO', 000624, '11.803749', '-15.180413', 1617533770, 1617533770),
(178, '동티모르', 'Timor-Leste', 'Timor-Leste', 'TL', 'TLS', '', '', '', 000626, '-8.874217', '125.727539', 1617533770, 1617533770),
(179, '푸에르토리코', 'Puerto Rico', 'Puerto Rico', 'PR', 'PRI', 'USD', '달러', '$', 000630, '18.220833', '-66.590149', 1617533770, 1617533770),
(180, '카타르', 'Qatar', 'قطر', 'QA', 'QAT', 'QAR', '리알', 'ر.ق', 000634, '25.354826', '51.183884', 1617533770, 1617533770),
(181, '레위니옹', 'Réunion', 'Reunion', 'RE', 'REU', '', '', '', 000638, '-21.115141', '55.536384', 1617533770, 1617533770),
(182, '루마니아', 'Romania', 'România', 'RO', 'ROU', 'RON', '레우', 'L', 000642, '45.943161', '24.96676', 1617533770, 1617533770),
(183, '러시아', 'Russia', 'Россия', 'RU', 'RUS', 'RUB', '루블', 'руб', 000643, '61.52401', '105.318756', 1617533770, 1617533770),
(184, '르완다', 'Rwanda', 'Rwanda', 'RW', 'RWA', 'RWF', '프랑', 'RF', 000646, '-1.940278', '29.873888', 1617533770, 1617533770),
(185, '세인트헬레나', 'Saint Helena', 'Saint Helena', 'SH', 'SHN', 'SHP', '파운드', '£', 000654, '-24.143474', '-10.030696', 1617533770, 1617533770),
(186, '세인트키츠 네비스', 'Saint Kitts and Nevis', 'Saint Kitts and Nevis', 'KN', 'KNA', 'XCD', '달러', 'EC$', 000659, '17.357822', '-62.782998', 1617533770, 1617533770),
(187, '앵귈라', 'Anguilla', 'Anguilla', 'AI', 'AIA', 'XCD', '달러', 'EC$', 000660, '18.220554', '-63.068615', 1617533770, 1617533770),
(188, '세인트루시아', 'Saint Lucia', 'Saint Lucia', 'LC', 'LCA', 'XCD', '달러', 'EC$', 000662, '13.909444', '-60.978893', 1617533770, 1617533770),
(189, '생피에르 미클롱', 'Saint Pierre and Miquelon', 'Saint Pierre and Miquelon', 'PM', 'SPM', '', '', '', 000666, '46.941936', '-56.27111', 1617533770, 1617533770),
(190, '세인트빈센트 그레나딘', 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 'VC', 'VCT', 'XCD', '달러', 'EC$', 000670, '12.984305', '-61.287228', 1617533770, 1617533770),
(191, '산마리노', 'San Marino', 'San Marino', 'SM', 'SMR', 'EUR', '유로', '€', 000674, '43.94236', '12.457777', 1617533770, 1617533770),
(192, '상투메 프린시페', 'São Tomé and Príncipe', 'São Tomé and Príncipe', 'ST', 'STP', 'STD', '도브라', 'Db', 000678, '0.18636', '6.613081', 1617533770, 1617533770),
(193, '사우디아라비아', 'Saudi Arabia', 'المملكة العربية السعودية', 'SA', 'SAU', 'SAR', '리얄', 'ر.س', 000682, '23.885942', '45.079162', 1617533770, 1617533770),
(194, '세네갈', 'Senegal', 'Sénégal', 'SN', 'SEN', 'XOF', '(BCEAO)', 'BCEAO', 000686, '14.497401', '-14.452362', 1617533770, 1617533770),
(195, '세르비아', 'Serbia', 'Србија', 'RS', 'SRB', 'RSD', '', '', 000688, '44.016521', '21.005859', 1617533770, 1617533770),
(196, '세이셸', 'Seychelles', 'Seychelles', 'SC', 'SYC', 'SCR', '루피', 'SR', 000690, '-4.679574', '55.491977', 1617533770, 1617533770),
(197, '시에라리온', 'Sierra Leone', 'Sierra Leone', 'SL', 'SLE', 'SLL', '레온', 'Le', 000694, '8.460555', '-11.779889', 1617533770, 1617533770),
(198, '싱가포르', 'Singapore', 'Singapura', 'SG', 'SGP', 'SGD', '달러', 'S$', 000702, '1.352083', '103.819836', 1617533770, 1617533770),
(199, '슬로바키아', 'Slovakia', 'Slovensko', 'SK', 'SVK', 'EUR', '유로', '€', 000703, '48.669026', '19.699024', 1617533770, 1617533770),
(200, '베트남', 'Vietnam', 'Việt Nam', 'VN', 'VNM', 'VND', '동', '₫', 000704, '14.058324', '108.277199', 1617533770, 1617533770),
(201, '슬로베니아', 'Slovenia', 'Slovenija', 'SI', 'SVN', 'EUR', '유로', '€', 000705, '46.151241', '14.995463', 1617533770, 1617533770),
(202, '소말리아', 'Somalia', 'Soomaaliya', 'SO', 'SOM', 'SOS', '실링', 'So.', 000706, '5.152149', '46.199616', 1617533770, 1617533770),
(203, '남아프리카 공화국', 'South Africa', 'South Africa', 'ZA', 'ZAF', 'ZAR', '랜드', 'R', 000710, '-30.559482', '22.937506', 1617533770, 1617533770),
(204, '짐바브웨', 'Zimbabwe', 'Zimbabwe', 'ZW', 'ZWE', '', '', '', 000716, '-19.015438', '29.154857', 1617533770, 1617533770),
(205, '스페인', 'Spain', 'España', 'ES', 'ESP', 'EUR', '유로', '€', 000724, '40.463667', '-3.74922', 1617533770, 1617533770),
(206, '남수단', 'REPUBLIC OF SOUTH SUDAN', 'South Sudan', 'SS', 'SSD', 'SDG', '파운드', 'SDG', 000728, '', '', 1617533770, 1617533770),
(207, '서사하라', 'Western Sahara', 'الصحراء الغربية', 'EH', 'ESH', '', '', '', 000732, '24.215527', '-12.885834', 1617533770, 1617533770),
(208, '수단', 'Sudan', 'السودان', 'SD', 'SDN', 'SDG', '파운드', 'SDG', 000736, '12.862807', '30.217636', 1617533770, 1617533770),
(209, '수리남', 'Suriname', 'Suriname', 'SR', 'SUR', 'SRD', '', '', 000740, '3.919305', '-56.027783', 1617533770, 1617533770),
(210, '스발바르 얀마옌', 'Svalbard and Jan Mayen', 'Svalbard and Jan Mayen', 'SJ', 'SJM', '', '', '', 000744, '77.553604', '23.670272', 1617533770, 1617533770),
(211, '스와질란드', 'Swaziland', 'Swaziland', 'SZ', 'SWZ', 'SZL', '릴랑게니', 'SZL', 000748, '-26.522503', '31.465866', 1617533770, 1617533770),
(212, '스웨덴', 'Sweden', 'Sverige', 'SE', 'SWE', 'SEK', '크로나', 'kr', 000752, '60.128161', '18.643501', 1617533770, 1617533770),
(213, '스위스', 'Switzerland', 'Schweiz', 'CH', 'CHE', 'CHF', '프랑', 'CHF', 000756, '46.818188', '8.227512', 1617533770, 1617533770),
(214, '시리아', 'Syria', 'سوريا', 'SY', 'SYR', 'SYP', '파운드', 'SYP', 000760, '34.802075', '38.996815', 1617533770, 1617533770),
(215, '타지키스탄', 'Tajikistan', 'Тоҷикистон', 'TJ', 'TJK', 'TJS', '', '', 000762, '38.861034', '71.276093', 1617533770, 1617533770),
(216, '타이', 'Thailand', 'ราชอาณาจักรไทย', 'TH', 'THA', 'THB', '바트', '฿', 000764, '15.870032', '100.992541', 1617533770, 1617533770),
(217, '토고', 'Togo', 'Togo', 'TG', 'TGO', 'XOF', '(BCEAO)', 'BCEAO', 000768, '8.619543', '0.824782', 1617533770, 1617533770),
(218, '토켈라우', 'Tokelau', 'Tokelau', 'TK', 'TKL', '', '', '', 000772, '-8.967363', '-171.855881', 1617533770, 1617533770),
(219, '통가', 'Tonga', 'Tonga', 'TO', 'TON', 'TOP', '팡가', 'T$', 000776, '-21.178986', '-175.198242', 1617533770, 1617533770),
(220, '트리니다드 토바고', 'Trinidad and Tobago', 'Trinidad and Tobago', 'TT', 'TTO', 'TTD', '달러', 'TTD', 000780, '10.691803', '-61.222503', 1617533770, 1617533770),
(221, '아랍에미리트', 'United Arab Emirates', 'الإمارات العربيّة المتّحدة', 'AE', 'ARE', 'AED', '디르함', 'د.إ', 000784, '23.424076', '53.847818', 1617533770, 1617533770),
(222, '튀니지', 'Tunisia', 'تونس', 'TN', 'TUN', 'TND', '디나르', 'د.ت', 000788, '33.886917', '9.537499', 1617533770, 1617533770),
(223, '터키', 'Turkey', 'Türkiye', 'TR', 'TUR', 'TRY', '리라', 'YTL', 000792, '38.963745', '35.243322', 1617533770, 1617533770),
(224, '투르크메니스탄', 'Turkmenistan', 'Türkmenistan', 'TM', 'TKM', 'TMT', '', '', 000795, '38.969719', '59.556278', 1617533770, 1617533770),
(225, '터크스 케이커스 제도', 'Turks and Caicos Islands', 'Turks and Caicos Islands', 'TC', 'TCA', '', '', '', 000796, '21.694025', '-71.797928', 1617533770, 1617533770),
(226, '투발루', 'Tuvalu', 'Tuvalu', 'TV', 'TUV', 'AUD', '달러', '$', 000798, '-7.109535', '177.64933', 1617533770, 1617533770),
(227, '우간다', 'Uganda', 'Uganda', 'UG', 'UGA', 'UGX', '실링', 'USh', 000800, '1.373333', '32.290275', 1617533770, 1617533770),
(228, '우크라이나', 'Ukraine', 'Україна', 'UA', 'UKR', 'UAH', '흐리브냐', '', 000804, '48.379433', '31.16558', 1617533770, 1617533770),
(229, '마케도니아 공화국', 'Macedonia [FYROM]', 'Македонија', 'MK', 'MKD', 'MKD', '디나르', 'MKD', 000807, '41.608635', '21.745275', 1617533770, 1617533770),
(230, '이집트', 'Egypt', 'مصر', 'EG', 'EGY', 'EGP', '파운드', 'ج.م', 000818, '26.820553', '30.802498', 1617533770, 1617533770),
(231, '영국', 'United Kingdom', 'United Kingdom', 'GB', 'GBR', 'GBP', '파운드', '£', 000826, '55.378051', '-3.435973', 1617533770, 1617533770),
(232, '건지 섬', 'Guernsey', 'Guernsey', 'GG', 'GGY', '', '', '', 000831, '49.465691', '-2.585278', 1617533770, 1617533770),
(233, '저지 섬', 'Jersey', 'Jersey', 'JE', 'JEY', '', '', '', 000832, '49.214439', '-2.13125', 1617533770, 1617533770),
(234, '맨 섬', 'Isle of Man', 'Isle of Man', 'IM', 'IMN', '', '', '', 000833, '54.236107', '-4.548056', 1617533770, 1617533770),
(235, '탄자니아', 'Tanzania', 'Tanzania', 'TZ', 'TZA', 'TZS', '실링', 'x', 000834, '-6.369028', '34.888822', 1617533770, 1617533770),
(236, '미국', 'United States', 'United States', 'US', 'USA', 'USD', '달러', '$', 000840, '37.09024', '-95.712891', 1617533770, 1617533770),
(237, '미국령 버진아일랜드', 'U.S. Virgin Islands', 'Virgin Islands, U.S.', 'VI', 'VIR', '', '', '', 000850, '18.335765', '-64.896335', 1617533770, 1617533770),
(238, '부르키나파소', 'Burkina Faso', 'Burkina Faso', 'BF', 'BFA', 'XOF', '(BCEAO)', 'BCEAO', 000854, '12.238333', '-1.561593', 1617533770, 1617533770),
(239, '우루과이', 'Uruguay', 'Uruguay', 'UY', 'URY', 'UYU', '페소', 'UYU', 000858, '-32.522779', '-55.765835', 1617533770, 1617533770),
(240, '우즈베키스탄', 'Uzbekistan', 'O\'zbekiston', 'UZ', 'UZB', 'UZS', '솜', 'UZS', 000860, '41.377491', '64.585262', 1617533770, 1617533770),
(241, '베네수엘라', 'Venezuela', 'Venezuela', 'VE', 'VEN', 'VEF', '후에르떼', 'VEF', 000862, '6.42375', '-66.58973', 1617533770, 1617533770),
(242, '왈리스 퓌튀나', 'Wallis and Futuna', 'Wallis and Futuna', 'WF', 'WLF', 'XPF', '프랑', 'F', 000876, '-13.768752', '-177.156097', 1617533770, 1617533770),
(243, '사모아', 'Samoa', 'Samoa', 'WS', 'WSM', 'WST', '탈라', 'WS$', 000882, '-13.759029', '-172.104629', 1617533770, 1617533770),
(244, '예멘', 'Yemen', 'اليمن', 'YE', 'YEM', 'YER', '리알', 'YER', 000887, '15.552727', '48.516388', 1617533770, 1617533770),
(245, '잠비아', 'Zambia', 'Zambia', 'ZM', 'ZMB', 'ZMW', '', '', 000894, '-13.133897', '27.849332', 1617533770, 1617533770);

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
  `fileIdxes` text DEFAULT '',
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
  `userAgent` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `lastViewClientIp` varchar(15) NOT NULL DEFAULT '',
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
  ADD UNIQUE KEY `alpha2` (`alpha2`),
  ADD UNIQUE KEY `alpha3` (`alpha3`),
  ADD UNIQUE KEY `numericCode` (`numericCode`);

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
  ADD KEY `code` (`code`),
  ADD KEY `taxonomy_code` (`taxonomy`,`code`);

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
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
