-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 06 Nis 2017, 21:48:56
-- Sunucu sürümü: 5.7.17-0ubuntu0.16.04.1
-- PHP Sürümü: 5.6.30-7+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ism_0617`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ism_issue`
--

CREATE TABLE `ism_issue` (
  `issue_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `ism_issue`
--

INSERT INTO `ism_issue` (`issue_id`, `user_id`, `title`, `content`, `tags`, `created_at`, `updated_at`, `status`) VALUES
(2, 61, 'merhaba dünya', 'sdgasdg asfh', NULL, '2017-04-06 19:35:17', '2017-04-07 21:37:17', 0),
(3, 61, 'merhaba dünya', 'sdgasdg asfh', NULL, '2017-04-06 13:46:48', '2017-04-06 19:48:39', 0),
(4, 61, 'merhaba dünya', 'sdgasdg asfh', NULL, '2017-04-06 13:46:50', '2017-04-06 13:46:50', 0),
(5, 61, 'Merhaba Beyza', 'Lorema,so akjfaisdfgasdgşsdgd pkgsdgjs jğsg ı', NULL, '2017-04-06 13:47:25', '2017-04-06 13:47:25', 0),
(6, 61, 'Merhaba Murat61', 'Lorema,so akjfaisdfgasdgşsdgd pkgsdgjs jğsg ı', 'asfsa,asfas,qweq', '2017-04-06 17:12:22', '2017-04-06 17:12:22', 0),
(7, 61, 'asfas', 'gfdsds', NULL, '2017-04-06 15:11:06', '2017-04-06 15:11:06', 0),
(8, 61, 'asfas', 'gfdsds', NULL, '2017-04-06 15:12:56', '2017-04-06 15:12:56', 0),
(9, 61, 'asfas', 'gfdsds', NULL, '2017-04-06 15:16:54', '2017-04-06 19:09:28', 0),
(10, 61, 'yihuuuu', 'şalsf kasdjfakld j', 'fasf,asfas,qwrq', '2017-04-06 16:28:35', '2017-04-06 19:35:51', 0),
(11, 61, 'yihuuuu', 'şalsf kasdjfakld j', 'fasf,asfas,qwrq', '2017-04-06 16:28:49', '2017-04-06 16:28:49', 1),
(12, 61, 'yihuuuu', 'şalsf kasdjfakld j', 'fasf,asfas,qwrq', '2017-04-06 16:32:02', '2017-04-06 16:32:02', 0),
(13, 61, 'yihuuuu', 'şalsf kasdjfakld j', 'fasf,asfas,qwrq', '2017-04-06 16:32:06', '2017-04-06 16:32:06', 1),
(14, 61, 'yihuuuu', 'şalsf kasdjfakld j', 'fasf,asfas,qwrq', '2017-04-06 16:32:35', '2017-04-06 16:32:35', 1),
(15, 61, 'yihuuuu', 'şalsf kasdjfakld j', 'fasf,asfas,qwrq', '2017-04-06 16:32:49', '2017-04-06 16:32:49', 1),
(16, 61, 'yihuuuu', 'şalsf kasdjfakld j', 'fasf,asfas,qwrq', '2017-04-06 16:33:59', '2017-04-06 16:33:59', 1),
(17, 61, 'fasagag', 'hdfdfj', NULL, '2017-04-06 16:35:36', '2017-04-06 16:35:36', 1),
(18, 61, 'fasagag', 'hdfdfj', NULL, '2017-04-06 16:35:55', '2017-04-06 16:35:55', 0),
(19, 61, 'asg', 'gsasa', NULL, '2017-04-06 17:07:17', '2017-04-06 17:07:17', 0),
(20, 61, 'qrasfag', 'hsghjdfgjd', 'asf,fsas,qwe', '2017-04-06 19:41:30', '2017-04-06 19:43:07', 0),
(21, 61, 'Denemelik', 'sdgadsgaf sas qqqq', 'asf,asgas,qwqr', '2017-04-06 20:04:06', '2017-04-06 20:04:06', 0),
(22, 61, 'qqffaa', 'gasdgga', NULL, '2017-04-06 20:05:46', '2017-04-06 20:05:46', 0),
(23, 61, 'gasdgas gasdga', 'sdgasd', NULL, '2017-04-06 20:06:14', '2017-04-06 20:06:21', 0),
(24, 61, 'fasfa asas', 'gsdgsdg qqqq', NULL, '2017-04-06 20:07:28', '2017-04-06 20:07:28', 0),
(25, 61, 'gasas', 'asqwgdsgds', NULL, '2017-04-06 20:08:09', '2017-04-06 20:14:28', 0),
(26, 61, 'f fhgfj kgjkk', 'sdgsdag sasa', NULL, '2017-04-06 20:09:48', '2017-04-06 20:09:48', 0),
(27, 61, 'ggsfdgdfg sdfgsfd', 'df hsdfhsdf', NULL, '2017-04-06 20:10:33', '2017-04-06 20:10:33', 0),
(28, 61, 'f dgasdfgsfgfh', 'asdga ttt', 'dsdg,ds', '2017-04-06 20:13:19', '2017-04-06 20:13:19', 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ism_issue`
--
ALTER TABLE `ism_issue`
  ADD PRIMARY KEY (`issue_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ism_issue`
--
ALTER TABLE `ism_issue`
  MODIFY `issue_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
