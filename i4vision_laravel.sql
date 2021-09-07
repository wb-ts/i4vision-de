-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 04. Sep 2021 um 11:04
-- Server-Version: 10.3.31-MariaDB-0ubuntu0.20.04.1
-- PHP-Version: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `i4vision_laravel`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `supervisor_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `clients`
--

INSERT INTO `clients` (`id`, `name`, `description`, `address`, `status`, `supervisor_email`, `created_at`, `updated_at`) VALUES
(1, 'Demo', 'Demo Client', 'Alter Unteröwisheimer Weg 19, 76646 Bruchsal', 1, NULL, NULL, '2021-07-20 12:38:34'),
(2, '2', '2', '2', 1, NULL, '2021-07-19 07:23:15', '2021-07-19 07:23:34'),
(6, 'sebru', 'se bruchsal', 'bruchsal', 1, NULL, '2021-07-26 06:24:11', '2021-07-26 06:24:11'),
(8, 'test5', '5', '5', 1, NULL, '2021-07-27 06:07:03', '2021-07-27 06:07:03'),
(9, 'create 5b', '5b', '5b', 1, NULL, '2021-07-27 06:08:35', '2021-07-27 06:08:35'),
(10, 'SH', 'SH TEST', 'Bruchsal', 1, NULL, '2021-09-01 06:02:32', '2021-09-01 06:02:32');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `device`
--

CREATE TABLE `device` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `timestamp_registered` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eMail_of_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `configuration` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_up_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_down_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_heartbeat_minutes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp_last_accessed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp_last_register` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timestamp_last_setup` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip_address_of_last_access` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `show_at_frontend` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frontend_refer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frontend_layout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `force_restart_enabled` tinyint(1) DEFAULT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL,
  `supervisor_warning` tinyint(1) NOT NULL DEFAULT 0,
  `ix` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `device`
--

INSERT INTO `device` (`id`, `device_code`, `client_id`, `enabled`, `timestamp_registered`, `eMail_of_admin`, `configuration`, `device_up_time`, `device_down_time`, `device_heartbeat_minutes`, `timestamp_last_accessed`, `timestamp_last_register`, `timestamp_last_setup`, `ip_address_of_last_access`, `created_at`, `updated_at`, `show_at_frontend`, `frontend_refer`, `frontend_layout`, `force_restart_enabled`, `description`, `supervisor_warning`, `ix`) VALUES
(1, 'api_test_device_code', 1, 1, '2021-07-16 16:38:03', NULL, 'IP=172.168.129.111, Port=50, Server=our server, SenderAdress=hugo@sappp.com', '08:00', '22:00', '5', '2021-09-02 14:40:43', '2021-09-03 15:12:23', '0000-00-00 00:00:00', '188.43.136.32', '2021-07-16 14:38:03', '2021-09-02 12:40:43', 'App\\Gallery', 'Komm1Jul930', NULL, NULL, NULL, 0, 1),
(3, 'api_test_device_code2', 2, 1, '2021-07-20 15:41:39', NULL, 'Device setup description test', '1', '2', '3', NULL, '2021-09-01 08:39:32', '0000-00-00 00:00:00', '5.10.178.170', '2021-07-20 13:41:39', '2021-07-21 17:00:45', NULL, NULL, NULL, NULL, NULL, 0, 0),
(4, 'api_test_device_code3', 2, 1, '2021-07-21 07:58:42', NULL, 'sdfwefwefwefwefxxxxx', '1', '2', '3', '4', '2021-09-03 09:16:09', '0000-00-00 00:00:00', '188.43.136.32', '2021-07-21 05:58:42', '2021-09-03 07:16:09', NULL, NULL, NULL, NULL, NULL, 0, 0),
(5, 'api_test_device_code5', 1, NULL, '2021-07-21 11:18:13', NULL, '-config-', NULL, NULL, NULL, '2021-07-21 11:18:13', '2021-09-03 15:13:37', '0000-00-00 00:00:00', '5.10.178.170', '2021-07-21 09:18:13', '2021-09-01 17:38:34', 'App\\Image', 'test', NULL, NULL, NULL, 0, 2),
(10, 'B-VMWARE-56 4D E7 B2 5A 3A 73 E0-AF E5 C4 6A CF F5 21 B5-9940E5AB', 1, 1, '2021-07-30 09:05:06', NULL, 'UpdateServer=se-stvinzenz.i4vision.de, UpdatePort=443, UpdatePath=kalipso/Versions/DEV, UpdateMode:HTTP, Flow=https://i4vision.de/?clientname=Demo&google=Komm1Jul930&title=on, OfflineRetrieveServer=https://se-stvinzenz.i4vision.de, OfflineRetrievePath=kalipso, CycleSleepTime=1, FlagLogging=1', '08:00', '22:00', '5', '2021-07-30 10:14:02', '2021-09-03 15:10:45', '0000-00-00 00:00:00', '5.10.178.170', '2021-07-30 07:05:06', '2021-09-01 17:39:12', 'App\\Flow', 'Demo01', NULL, NULL, 'yyyy', 0, 3),
(12, 'B-R90JV78WR9N0B621800F-B21CA41E', 1, 1, '2021-08-12 11:52:44', NULL, 'UpdateServer=se-stvinzenz.i4vision.de, UpdatePort=443, UpdatePath=kalipso/Versions/DEV, UpdateMode:HTTP, Flow=i4vision.de/?clientname=Demo&flow=Demo01&design=flow, OfflineRetrieveServer=https://se-stvinzenz.i4vision.de, OfflineRetrievePath=kalipso, CycleSleepTime=1, FlagLogging=1', NULL, NULL, '5', '2021-09-02 14:41:01', '2021-09-04 08:36:20', '0000-00-00 00:00:00', '5.10.178.170', '2021-08-12 09:52:44', '2021-09-02 12:41:01', 'App\\Schedule', 'Block4', 'blue', NULL, 'Test AG', 0, 5),
(13, 'B-VMWARE-42 14 1A E6 48 23 16 E6-99 30 F0 E5 BB F3 4A F6-501E8002', NULL, 0, '2021-08-16 10:58:58', NULL, NULL, NULL, NULL, NULL, '2021-08-16 10:58:58', '2021-09-01 08:39:32', '0000-00-00 00:00:00', '5.10.178.170', '2021-08-16 08:58:58', '2021-08-16 08:58:58', NULL, NULL, NULL, NULL, NULL, 0, 0),
(14, 'B-L3N0CV09N549137-EA765AE9', 10, 1, '2021-08-18 13:27:18', NULL, 'UpdateServer=se-stvinzenz.i4vision.de, UpdatePort=443, UpdatePath=kalipso/Versions/DEV, UpdateMode:HTTP, OfflineRetrieveServer=https://se-stvinzenz.i4vision.de, OfflineRetrievePath=kalipso, CycleSleepTime=1, FlagLogging=1,\r\nBackgroundImageName=background.png', NULL, NULL, '5', '2021-09-03 13:36:00', '2021-09-03 11:36:00', '2021-09-03 11:30:55', '46.223.163.183', '2021-08-18 11:27:18', '2021-09-03 11:36:00', 'App\\Site', 'wetter', NULL, 0, 'SH Laptop', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `flows`
--

CREATE TABLE `flows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ix` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `flows`
--

INSERT INTO `flows` (`id`, `client_id`, `name`, `description`, `layout`, `user_id`, `created_at`, `updated_at`, `ix`) VALUES
(1, 1, 'test', 'test', 'test', 2, '2021-07-19 07:34:38', '2021-07-19 07:34:38', 0),
(2, 1, 'test2', 'test2', NULL, 2, '2021-07-20 12:48:56', '2021-07-20 12:48:56', 0),
(4, 1, 'Demo01', 'Demo Flow', 'blue? no function currently...', 2, '2021-08-03 08:07:09', '2021-08-16 10:19:14', 1),
(5, 1, 'Demoiframe', 'Demo Flow', NULL, 2, '2021-09-03 03:59:50', '2021-09-03 04:00:14', 13),
(6, 6, 'newaeg', '....', NULL, 14, '2021-09-03 11:57:55', '2021-09-03 11:57:55', 0);

--
-- Trigger `flows`
--
DELIMITER $$
CREATE TRIGGER `flows_after_update` AFTER UPDATE ON `flows` FOR EACH ROW update device 
set ix = ix + 1
where show_at_frontend="App\Flow" and frontend_refer = new.name
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `flow_entries`
--

CREATE TABLE `flow_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flow_id` bigint(20) UNSIGNED DEFAULT NULL,
  `flow_entriable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flow_entriable_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int(11) DEFAULT NULL,
  `sequence` int(11) NOT NULL DEFAULT 0,
  `run_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `run_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dates` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ix` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `flow_entries`
--

INSERT INTO `flow_entries` (`id`, `flow_id`, `flow_entriable_type`, `flow_entriable_id`, `time`, `sequence`, `run_from`, `run_to`, `dates`, `user_id`, `created_at`, `updated_at`, `ix`) VALUES
(2, 1, 'App\\Image', '2', 1, 1, '2021-07-19', '2021-07-20', '2021-07-19,2021-07-20', 2, '2021-07-19 08:04:19', '2021-07-19 08:04:19', 0),
(3, 1, 'App\\Device', '1', 1, 12, '2021-07-19', '2021-07-20', '2021-07-19,2021-07-20', 2, '2021-07-19 08:04:57', '2021-07-19 08:04:57', 0),
(4, 1, 'App\\Schedule', 'test', 1, 1234, '2021-07-19', '2021-07-20', '2021-07-19,2021-07-20', 2, '2021-07-19 08:05:57', '2021-07-19 08:05:57', 0),
(6, 1, 'App\\Gallery', '2', 12, 1212, '2021-07-19', '2021-07-20', '2021-07-19,2021-07-20', 2, '2021-07-19 08:15:23', '2021-07-19 08:15:23', 0),
(7, 1, 'App\\Site', '2', 1, 12312312, '2021-07-19', '2021-07-20', '2021-07-19,2021-07-20', 2, '2021-07-19 08:16:38', '2021-07-19 08:16:38', 0),
(9, 4, 'App\\Gallery', '3', NULL, 10, '01.08.2021', '03.09.2021', NULL, 2, '2021-08-03 08:08:29', '2021-08-31 21:49:09', 0),
(10, 4, 'App\\Site', '3', 5, 20, NULL, '02.09.2021', NULL, 2, '2021-08-03 08:09:34', '2021-08-31 09:55:44', 0),
(12, 4, 'App\\Schedule', 'Block4', 5, 50, NULL, '02.09.2021', '03.08.2021,04.08.2021,17.08.2021,18.08.2021', 2, '2021-08-03 09:32:25', '2021-08-31 09:55:54', 0),
(13, 4, 'App\\Gallery', '5', NULL, 30, NULL, '10.08.2021', NULL, 2, '2021-08-16 17:46:50', '2021-08-17 15:49:51', 0),
(14, 4, 'App\\Image', '2', 5, 40, '31.08.2021', '08.09.2021', NULL, 2, '2021-08-31 20:48:20', '2021-08-31 21:49:49', 0),
(15, 4, 'App\\Site', '6', 2, 31, NULL, NULL, NULL, 2, '2021-09-02 17:17:05', '2021-09-02 17:17:05', 0),
(20, 5, 'App\\Image', '2', 5, 40, '31.08.2021', '08.09.2021', NULL, 2, '2021-09-03 03:59:50', '2021-09-03 03:59:50', 0),
(21, 5, 'App\\Site', '8', 5, 32, NULL, NULL, NULL, 2, '2021-09-03 03:59:50', '2021-09-03 11:27:40', 0),
(22, 5, 'App\\Site', '6', 5, 33, NULL, NULL, NULL, 2, '2021-09-03 11:38:29', '2021-09-03 11:40:49', 0);

--
-- Trigger `flow_entries`
--
DELIMITER $$
CREATE TRIGGER `flow_entries_after_insert` AFTER INSERT ON `flow_entries` FOR EACH ROW update flows 
set ix = ix + 1
where flows.id = new.flow_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `flow_entries_after_update` AFTER UPDATE ON `flow_entries` FOR EACH ROW update flows 
set ix = ix + 1
where flows.id = new.flow_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `galleries`
--

INSERT INTO `galleries` (`id`, `client_id`, `name`, `google_link`, `description`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 1, 'test', 'test', 'test', 2, '2021-07-19 08:14:45', '2021-07-19 08:14:45'),
(3, 1, 'Wunschaktion', 'vAdy2s6aaPPUXYu89', 'Bilder der Wunschaktion 4711', 2, '2021-07-21 09:49:21', '2021-07-31 07:07:08'),
(4, 1, 'test1', 'uYJ4zY1ULHwS3x2aA', 'tes 1', 2, '2021-07-25 01:31:55', '2021-07-25 01:32:28'),
(5, 1, 'Komm1Jul930', 'tG2hPM8jTAKENMn26', 'Erstkommunion am 04.Juli 9:30 Uhr', 2, '2021-07-25 13:36:05', '2021-07-25 13:36:05'),
(8, 6, 'Erko_0407_14Uhr', 'kofqkE1VT3bowSuB7', 'Kommunion So 04.07., 14 Uhr in St. Paul', 14, '2021-09-02 07:36:16', '2021-09-02 11:28:24');

--
-- Trigger `galleries`
--
DELIMITER $$
CREATE TRIGGER `galleries_after_update` AFTER UPDATE ON `galleries` FOR EACH ROW update device 
set ix = ix + 1
where show_at_frontend="App\Gallery" and frontend_refer = new.name
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `images`
--

INSERT INTO `images` (`id`, `name`, `description`, `url`, `user_id`, `client_id`, `created_at`, `updated_at`) VALUES
(2, 'test', 'test desc', 'images/FyADjUOuvRW3zmpeIqbmjmKdc47nJg2DWX6zwff9.jpg', 2, 1, '2021-07-19 07:30:49', '2021-09-02 17:05:37'),
(6, 'Vinzentiushaus', NULL, 'images/nd4gDEXvFNcdKyKf4O8ECYAccGWjKYP2if1FiYEP.png', 14, 6, '2021-09-02 11:26:14', '2021-09-02 11:27:50'),
(7, 'Test2', NULL, 'images/JkXflHxgJu5j2C4RGyRvsF0Pi8DwLhzMx9AoWR4f.png', 2, 1, '2021-09-02 17:04:57', '2021-09-02 17:04:57'),
(9, 'testsascha', '1234', 'images/Uw2wGFEMMTlFIke47bOpBB1I95xlVLtdc5SW4hCs.png', 20, 10, '2021-09-03 11:49:08', '2021-09-03 11:49:08'),
(11, 'Schulanfang', NULL, 'images/1z2isVyb5z6htkTP5ryKYRIc99gsfC9iKTvtPChz.jpg', 14, 6, '2021-09-03 11:52:14', '2021-09-03 11:52:14');

--
-- Trigger `images`
--
DELIMITER $$
CREATE TRIGGER `images_after_update` AFTER UPDATE ON `images` FOR EACH ROW update device 
set ix = ix + 1
where show_at_frontend="App\Image" and frontend_refer = new.name
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_07_07_174153_create_images_table', 1),
(5, '2021_07_08_145751_create_flows_table', 1),
(6, '2021_07_08_154929_create_galleries_table', 1),
(7, '2021_07_08_161057_create_sites_table', 1),
(8, '2021_07_08_161158_create_schedules_table', 1),
(9, '2021_07_08_183320_create_flow_entries_table', 1),
(10, '2021_07_09_113759_create_device_table', 1),
(11, '2021_07_16_084007_create_clients_table', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `layout` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ix` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `schedules`
--

INSERT INTO `schedules` (`id`, `name`, `description`, `layout`, `user_id`, `client_id`, `created_at`, `updated_at`, `ix`) VALUES
(1, 'Block4', 'Demo implement schedule entries', 'blue? no function currently', 2, 1, '2021-08-01 16:32:19', '2021-08-16 16:32:19', 6),
(2, 'Second', 'This is second', 'none', 2, 1, '2021-08-21 01:02:17', '2021-08-21 01:02:17', 0),
(6, 'Third', '3rd sample', NULL, 2, 1, '2021-09-01 17:03:23', '2021-09-01 17:03:23', 0),
(7, 'Mix', 'gemischte Termine', NULL, 14, 6, '2021-09-02 11:19:22', '2021-09-02 11:20:58', 3);

--
-- Trigger `schedules`
--
DELIMITER $$
CREATE TRIGGER `schedules_after_update` AFTER UPDATE ON `schedules` FOR EACH ROW update device 
set ix = ix + 1
where show_at_frontend="App\Schedule" and frontend_refer = new.name
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schedules_old`
--

CREATE TABLE `schedules_old` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('kids','adults','general') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `schedules_old`
--

INSERT INTO `schedules_old` (`id`, `date`, `time`, `name`, `type`, `line1`, `line2`, `line3`, `image_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '01.07.2021', 'test', 'test', 'kids', 'test', 'test', 'test', 2, 2, '2021-07-19 07:34:02', '2021-07-22 14:40:25'),
(2, '03.11.2021', '20:00', 'Block4', 'kids', 'Text für Zeile 1', 'Text für Zeile 2', 'Text für Zeile 3', 2, 2, '2021-07-21 15:23:28', '2021-07-22 14:40:11'),
(5, '01.08.2021', '17:00', 'Block4', 'adults', 'Zeile 1', 'Zeile 2', 'Zeile 3', 2, 2, '2021-07-31 05:44:42', '2021-07-31 05:44:42'),
(6, '02.08.2021', '18:00', 'Block4', 'adults', 'Zeile 1', 'Zeile 2', 'Zeile 3', 2, 2, '2021-07-31 05:45:38', '2021-07-31 05:45:38'),
(7, '15.08.2021', '20:21', 'Block4', 'kids', 'Nur eine Zeile', NULL, NULL, 2, 2, '2021-08-01 16:31:46', '2021-08-02 01:51:27'),
(8, '16.08.2021', '21:00', 'Block4', 'kids', 'Test 5', '5/Line2', '5/Line3', 2, 2, '2021-08-01 16:32:19', '2021-08-16 12:02:25');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schedule_entries`
--

CREATE TABLE `schedule_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) UNSIGNED DEFAULT NULL,
  `schedule_entriable_id` enum('kids','general','adults') DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `run_from` varchar(255) DEFAULT NULL,
  `run_to` varchar(255) DEFAULT NULL,
  `dates` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `line1` varchar(255) DEFAULT NULL,
  `line2` varchar(255) DEFAULT NULL,
  `line3` varchar(255) DEFAULT NULL,
  `image_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(255) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `schedule_entries`
--

INSERT INTO `schedule_entries` (`id`, `schedule_id`, `schedule_entriable_id`, `date`, `run_from`, `run_to`, `dates`, `time`, `line1`, `line2`, `line3`, `image_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'adults', '03.09.2021', '31.08.2021', '04.09.2021', '01.09.2021,02.09.2021', '20:00', 'Text für Zeile 1a', 'Text für Zeile 2', 'Text für Zeile 3', 2, 2, '2021-09-01 19:10:18', '2021-09-01 07:17:12'),
(2, 2, 'general', '03.11.2021', '', '', '', '12:00', 'test1', 'test2', 'test3', 2, 2, '2021-08-20 18:09:43', '2021-08-21 01:09:43'),
(3, 1, 'general', '03.10.2021', '', '', '', '20:00', 'test1', 'test2', 'test3', 2, 2, '2021-08-21 05:08:21', '2021-08-21 05:08:21'),
(4, 1, 'general', '14.07.2021', '30.08.2021', '04.09.2021', '01.09.2021,02.09.2021', '20:00', 'test1_1', 'test2_1', 'test3_1', 2, 2, '2021-09-01 09:12:07', '2021-09-01 07:12:07'),
(5, 1, 'adults', '25.08.2021', '', '', '', '8:00', 'test1_2', 'test2_2', 'test3_2', 2, 2, '2021-08-21 06:10:41', '2021-08-21 13:10:41'),
(9, 1, 'general', '14.07.2021', NULL, NULL, NULL, '20:00', 'test1_1', 'test2_1', 'test3_1', 2, 2, '2021-09-01 17:18:28', '2021-09-01 17:18:28'),
(10, 1, 'general', '14.07.2021', NULL, NULL, NULL, '20:00', 'test1_1', 'test2_1', 'test3_1', 2, 2, '2021-09-02 08:48:16', '2021-09-02 08:48:16'),
(11, 7, 'adults', '11.10.2021', '12.09.2021', NULL, NULL, '19 - 21 Uhr', '\"Ich dachte es sei für immer!\"', 'Krise als Chance', 'Vinzentiushaus', NULL, 14, '2021-09-02 11:24:12', '2021-09-02 11:24:12'),
(12, 1, 'kids', '09.09.2021', NULL, NULL, NULL, '17:00', 'Zeile 1', NULL, NULL, 2, 2, '2021-09-03 11:46:32', '2021-09-03 11:46:32'),
(13, 1, 'kids', '07.09.2021', NULL, NULL, NULL, '09.00', 'Zeile 2', NULL, NULL, NULL, 2, '2021-09-03 11:47:45', '2021-09-03 11:47:45'),
(16, 1, 'kids', '31.08.2021', NULL, NULL, NULL, '08-09', NULL, NULL, NULL, NULL, 2, '2021-09-04 06:36:20', '2021-09-04 06:36:20');

--
-- Trigger `schedule_entries`
--
DELIMITER $$
CREATE TRIGGER `schedule_entries_after_insert` AFTER INSERT ON `schedule_entries` FOR EACH ROW update schedules 
set ix = ix + 1
where schedules.id = new.schedule_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `schedule_entries_after_update` AFTER UPDATE ON `schedule_entries` FOR EACH ROW update schedules 
set ix = ix + 1
where schedules.id = new.schedule_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sites`
--

CREATE TABLE `sites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `sites`
--

INSERT INTO `sites` (`id`, `name`, `url`, `description`, `user_id`, `client_id`, `created_at`, `updated_at`) VALUES
(2, 'example', 'https://example.org/', 'example', 2, 1, '2021-07-19 08:16:12', '2021-09-03 11:16:30'),
(3, 'Pfiffig_Bruchsal', 'https://pfarrei.info/pfiffig/pages/pfarrblatt.do?g=br&xsl=6&d=2', 'Termine Bruchsal', 2, 1, '2021-07-21 09:50:20', '2021-07-27 14:58:40'),
(5, 'wetter', 'https://wetter.de', 'Wetter', 20, 10, '2021-09-01 06:24:39', '2021-09-01 06:24:39'),
(6, 'Houdek', 'http://goering.rzkh.de:8099/', 'Houdek Sample', 2, 1, '2021-09-02 17:16:12', '2021-09-02 17:16:12'),
(7, 'Houdek_local', 'http://localhost/houdek', 'Houdek Sample lokal (Andi)', 2, 1, '2021-09-03 05:32:34', '2021-09-03 05:32:58'),
(8, 'Presto', 'http://goering.rzkh.de/presto/presto', 'Presto HTTP', 2, 1, '2021-09-03 08:07:17', '2021-09-03 08:07:46');

--
-- Trigger `sites`
--
DELIMITER $$
CREATE TRIGGER `sites_after_update` AFTER UPDATE ON `sites` FOR EACH ROW update device 
set ix = ix + 1
where show_at_frontend="AppSite" and frontend_refer = new.name
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sync_google_images`
--

CREATE TABLE `sync_google_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gallery_id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `sync_google_images`
--

INSERT INTO `sync_google_images` (`id`, `gallery_id`, `url`, `created_at`, `updated_at`, `title`) VALUES
(1, 4, 'https://lh3.googleusercontent.com/Zpvf5XztinmCLfCxxY_soZAozrF_zaRyPksZWN7r_9UG5hy8PZeP8ukjpTFHGefoP_Wdyyo0Nb17o3S_nzoKVWt8RsnBUIAyRiyYt-HqPsPayaTUTZdQr4_Tno9dzEjfNNoi408WeqA=w1920-h1080-no', '2021-07-25 01:32:32', '2021-07-25 01:32:32', NULL),
(2, 4, 'https://lh3.googleusercontent.com/LklUnCQMU_4a_plsDBYWvLYMLK_-lVoz6bLbkwLwNUB205gVCcozQZn2B8St8Z5hoRAzaelaTX-NWfAkY7yxWh6OGWVmZh1Pv5XnGCLf6AG8t_MtG_YTTuRnNBAPOcDL4S-SW8keo_c=w1920-h1080-no', '2021-07-25 01:32:32', '2021-07-25 01:32:32', NULL),
(3, 4, 'https://lh3.googleusercontent.com/Jlds2VDIsyU8oglXYd-I2cBmoona1uxbAbYAS_DS08-IHaGdSaiykgNEheJcfQ8HEeMw4usnshN4wiNmwJJdWLeJZbKs3tO4jtSBoplZPQcmQ3KE3oXeAQyVxaVcBDykvjDVJRKxsA4=w1920-h1080-no', '2021-07-25 01:32:32', '2021-07-25 01:32:32', NULL),
(4, 4, 'https://lh3.googleusercontent.com/qa6K90m9KrzlKKFh_wsQOUpSKTeYQlKXDCXOEuplI2IYpnWTBUs19fp7QIJNVt81zhzi0t5FCi2ArRDGjFrPm5wYu6OF0hijBGE5-uCPAzvUO7JhAyyUNc-0ISne5g4BE_5L9fICCAA=w1920-h1080-no', '2021-07-25 01:32:32', '2021-07-25 01:32:32', NULL),
(12, 5, 'https://lh3.googleusercontent.com/XnCDxBuJ1csYyo7t2GgIhEDyd0WWbRqGrIxXpJafc1Qm3I06weB8TFvdK8vugZc8RAmkOCYw3-rNnN35DttjOYzPt1b9EgKu4eKNxsu3xYrMNrSJIDjpObGTTdPKfJiY0sllqPOMjNw=w1920-h1080-no', '2021-07-25 13:36:12', '2021-07-25 13:36:12', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(13, 5, 'https://lh3.googleusercontent.com/I-mzCYUe4JpAlgysg1i58o3W91wZv_AfNcf2mkAumDFPgjcDadOxF-SM3goSfG8BZN0nkgAYD6zKRGI2yL2GBbh0_qB_D7X9E5xJBH3Ssc_ER81y1Rdt6lXzTOidoQqs-_BKBp7xWHI=w1920-h1080-no', '2021-07-25 13:36:12', '2021-07-25 13:36:12', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(14, 5, 'https://lh3.googleusercontent.com/gNwHDUxDxSFlGSqe3T8VooAI_qjYghfvRAgD3DUWzCNpMIlZz0h7y-Jh92EPRT0ziQxCCh6fnPunsvmgB-L7bS0EY2GH0bPIz4EW4Db6qIsJXfZ4vDQGmpJrtUtNbK34ZoD1xGY4YcM=w1920-h1080-no', '2021-07-25 13:36:12', '2021-07-25 13:36:12', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(15, 5, 'https://lh3.googleusercontent.com/VzQ8QLdEoPdGyAcOq5vt6pDkVORfLedXMeonJwCKxHx94VXHWXKqxpb8021fToqCXfqn5Nmbo6b3bwz5MvxqWqIk7YI4pZazG8RNB2KjOt-rueaLIwECn5OMVy8n81ibLOqllqTyW9E=w1920-h1080-no', '2021-07-25 13:36:12', '2021-07-25 13:36:12', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(16, 5, 'https://lh3.googleusercontent.com/Jgr6Gm-gF0xXGeL7oucND1SzHWpfB--gTX2CHEgqpAi7BO49lhnu2KWuCKrTxmxO7g8pruT5dkXFis1C_tkRf0cM6UBDvlvLUBuXP9vQ6yxX4gf7f68hQHQxLJXg8CMpusIzPCcWigY=w1920-h1080-no', '2021-07-25 13:36:12', '2021-07-25 13:36:12', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(17, 5, 'https://lh3.googleusercontent.com/r2k9BnPVernyQSezGnhh_B_t_TQYHNSv0gsg7wowjJ1H_hroXGd_9GlLq9X7XnSNGdTwfg6HxyxbCeVMgLHUTLrNWaIf1rV1i-F4TQIZwmKSD6CT-W3JMjdP1P_pgx0hwridx2GY4XA=w1920-h1080-no', '2021-07-25 13:36:12', '2021-07-25 13:36:12', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(18, 5, 'https://lh3.googleusercontent.com/8ftsUGaYzd2SA1_Kvc5RP7CmWbp6T0vT8OjVTxFvFOGKGjdBbybYFo8-XBsCwzfRugINvsCGWmdbKBpErtJ6ALpl_2SjX83wdns7u0_ytjCrFuaDSIvsbSXtLEP1NA6yhMmM44mL6Lc=w1920-h1080-no', '2021-07-25 13:36:12', '2021-07-25 13:36:12', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(19, 5, 'https://lh3.googleusercontent.com/h29wW0fnZrlxnCEbkXxFaR09jShqcPHTGDKEngNbZx-qawFVIETMWKXd9F1c8FilIvmoNeiq3BQpTNdV4NSk1N9r6cVteY9Um31teBp0smT9r3pjWBfB9oNF81JVRkd6gEZEDdqZxys=w1920-h1080-no', '2021-07-25 13:36:12', '2021-07-25 13:36:12', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(20, 5, 'https://lh3.googleusercontent.com/nZnKAtcKpAcy05cDIytdaUoH9vZ9yPb9vsN1GTfc5xM7h5NtvwV00AazLkRygwKq791uvzrXeRVd_IW8JtfPl9jFM40JswgrgNlh3Ylur5HbSfGhuT2aeySsfgaH6AkyObnuwcLGzhw=w1920-h1080-no', '2021-07-25 13:36:12', '2021-07-25 13:36:12', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(21, 5, 'https://lh3.googleusercontent.com/AEa8OUk0SjhHNvt5ieGkSOf9oaDA9tVqXRT2cwYtZ3MvU2ZLjDWMo7iCGcwfFRUukIUWCKG1cnaEh-AnctkbaxMxsAY81YBDz_YAJQzSnfK5VH88ctt8YHOqSatfjcTyRxd_lzQE19E=w1920-h1080-no', '2021-07-25 13:36:13', '2021-07-25 13:36:13', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(22, 5, 'https://lh3.googleusercontent.com/2N6OKcCsmvMKrJep7UvMy67OZ8MNJoA-2JAWeRGNC9h7aQNWOdR8ZldITJQZOhqXPjavl9z21F0olulFklPrSIL1ihiTEPahtaDDAkGu-aMoxQLph6kwpe80ix0xrfUp6b0Ii_OaPwY=w1920-h1080-no', '2021-07-25 13:36:13', '2021-07-25 13:36:13', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(23, 5, 'https://lh3.googleusercontent.com/YsL20W45JEpozJALq9YK-mVoHjo7awz-lAtTtzQvi3Lmwg_NS3eKV5YWiVmn-CdOmpHkPLaEt3JFDD7z_ijmwCH5W_eGOggCMUg1UtPIQWDhh928ZcfXkhUiVopkiO3ivbb7C8rz4p8=w1920-h1080-no', '2021-07-25 13:36:13', '2021-07-25 13:36:13', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(24, 5, 'https://lh3.googleusercontent.com/4pLZUJAdMY-Zo1L7pWaoBuocmQjjujeeZc1M_OCkzCddkkYqSrvOcjeaWIl6QFp56odz2r_B2i4wAergtLn1tjn6y9hcHFHjHKSXVIqPBE0A8K4ZJmuNv-ep0HHugQuBFAXJm2o2Pr0=w1920-h1080-no', '2021-07-25 13:36:13', '2021-07-25 13:36:13', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(25, 5, 'https://lh3.googleusercontent.com/Pd3hPJOhgga5OaacRXvVSNotrqxSNNYnRarXAq4ojH5zsi0JQjjL3KxwpAyhVFUDhwuH6FBX5Gd6avTB99NGtRGenLUHzeIe_mh_GNWOnqEFaHhPx9yMKErTjW36bCXbKxNbmhf5C3s=w1920-h1080-no', '2021-07-25 13:36:13', '2021-07-25 13:36:13', 'Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)'),
(54, 3, 'https://lh3.googleusercontent.com/Eov9YY6-ou9HdOLukne7M19cEFLqac3WMUaBbg2uKY4T0XHbIeVDw4fQIGneZg_UjBrB2SdrgvvDyX8oAXnuJyBI-TtXVEotK46p4ZzlrWHZbTIMiYYi3c12KKiDH1dHftpqJGOFau0=w1920-h1080-no', '2021-07-31 10:12:33', '2021-07-31 10:12:33', 'Wunschaktion geht zu Ende, Fotos: Johannes Schlindwein'),
(55, 3, 'https://lh3.googleusercontent.com/eRf40a-Ks-iBir3erubFAHUPEBcLV85CQOp1Gqd8hquBD5tpYTfuyHhIH14yOb5dlddP3XmrUogyH3jlU4d-P7Y4D8art_S1E0AoX9YOn8w-wfTvssBx7Qr67r0yHyj7jF1u4NOtmrg=w1920-h1080-no', '2021-07-31 10:12:34', '2021-07-31 10:12:34', 'Wunschaktion geht zu Ende, Fotos: Johannes Schlindwein'),
(56, 3, 'https://lh3.googleusercontent.com/TjOiRXzLdWZT7uJ-HduTs0T-A1E45xtqN-A801nBnM9jeMfMkzCS1olvuBwJ66SSeHHietNbaJYWXZpEwnrUIYtifD3yipi1i-P4O_-4laSrE-nIEuSIiHPOZoFUeW3mbTBkEiuJ1bo=w1920-h1080-no', '2021-07-31 10:12:34', '2021-07-31 10:12:34', 'Wunschaktion geht zu Ende, Fotos: Johannes Schlindwein'),
(57, 3, 'https://lh3.googleusercontent.com/n0uTDNoULCvBu2ap5LNae0-rL3Gcp_cU5IN4VIpMfXCJX3W6BLzFeeMKKzYV3ducFxaJl6GMd9_AcQRC6vkcQC0hyY6bCCo29EUVatJmVjL7cUugGE1XtLCXlRbtAlRTr9w8Cfff6-4=w1920-h1080-no', '2021-07-31 10:12:34', '2021-07-31 10:12:34', 'Wunschaktion geht zu Ende, Fotos: Johannes Schlindwein'),
(64, 8, 'https://lh3.googleusercontent.com/N3YHEAkJltdx92MMQcz_9w-77_d4K80xD5Qg7Jr8ey7C2XtSPEpVQ90dvSvlQ2c26SsE85YH9TcsCjoM5kA7MPsafc9fg2QCxcEW5vY4dOZi8hbbIxjuR4mjV5dvIOTYwGWlvU3EGKc=w1920-h1080-no', '2021-09-02 11:28:41', '2021-09-02 11:28:41', 'Erstkommunion am 04.07. um 11:30 Uhr (Fotos: Annette Göring)'),
(65, 8, 'https://lh3.googleusercontent.com/oT7iDOxF1k6XtYN4QyvKepPhooZb2vIhiUCiO8kB4xfI0YwVu1wF5Ulme8NLPYIO_nXIDpADBEIe77XSefaVCEf0vhLNFzq2lt8C0L-1cFig6XINKNGv1CS8MEBUQjf-0lQAf6sh2C4=w1920-h1080-no', '2021-09-02 11:28:41', '2021-09-02 11:28:41', 'Erstkommunion am 04.07. um 11:30 Uhr (Fotos: Annette Göring)');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `type` enum('super_admin','admin','user') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatars/default.png',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `username`, `description`, `phone`, `gender`, `status`, `type`, `password`, `email_verified_at`, `client_id`, `avatar`, `remember_token`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'super_admin@gmail.com', 'super', 'admin', 'super_admin', NULL, '11111111111', 0, 1, 'super_admin', '$2y$10$tlX1k2sKiJBb5x.JKLBjJuldeSemY8IHm2eU2H5rQKVck0SoMOwpa', NULL, NULL, 'avatars/default.png', NULL, NULL, NULL, 0),
(2, 'admin@gmail.com', 'Alexei', 'Volkov', 'admin', NULL, '230932', 0, 1, 'admin', '$2y$10$GjYaxtFSEFSn7inKl4E86uMN1HsSoHfKexFqnAtw6drCv36KNppCa', NULL, 1, 'avatars/default.png', NULL, '2021-07-16 12:29:57', '2021-07-16 12:29:57', 0),
(12, 'test@gmail.com', 'test', 'test', 'test', NULL, '293290', 0, 0, 'admin', '$2y$10$9P/E9QqC0n4dIzZbS.UNzOAhsWTHHcgqntskqvRvWNqB9g.u9qWrO', NULL, 1, 'avatars/default.png', NULL, '2021-07-20 15:14:21', '2021-07-20 15:14:21', 0),
(14, 'aeg@goering.de', 'Annette', 'Göring', 'aeg', NULL, '07251989512', 1, 1, 'admin', '$2y$10$rMGrNrKoebBe/i3BzyxO/.7Yd92ajYG7JI18HFAetmeuCyXv23RXC', NULL, 6, 'avatars/default.png', NULL, '2021-07-26 06:26:05', '2021-07-26 06:26:05', 0),
(18, 'sergeilipovsky@gmail.com', 'Sergei', 'Lipovsky', 'Sergei Lipovsky', NULL, '(507) 479-1549', 0, 1, 'user', '$2y$10$tH6A8/wL2OkOlO2lBPXzJOkioIr1GzuRS/zbewDqBaFgT9jVBtkOW', NULL, 1, 'avatars/default.png', NULL, '2021-08-21 13:22:55', '2021-08-21 13:22:55', 2),
(20, 'sh@goering.de', 'Sascha', 'Haupt', 'sh', NULL, '07251 989512', 0, 1, 'admin', '$2y$10$kT3XaSkHSQCHNpO1z1Lhvul3mhgTf8uQmae7f1x2xdQT/Ty2e6wWa', NULL, 10, 'avatars/default.png', NULL, '2021-09-01 06:20:35', '2021-09-01 06:20:35', NULL),
(21, 'aegnew@x.com', 'test aeg', 'test', 'aegnew', NULL, '++++', 0, 1, 'user', '$2y$10$hrC1puUjR8MtsUuIliFSCeyLo/gV0RQkUntFvn/5D98e8k3HF1rb2', NULL, 6, 'avatars/default.png', NULL, '2021-09-03 12:00:26', '2021-09-03 12:00:26', 14);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `flows`
--
ALTER TABLE `flows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `flows_name_unique` (`name`),
  ADD KEY `flows_user_id_foreign` (`user_id`);

--
-- Indizes für die Tabelle `flow_entries`
--
ALTER TABLE `flow_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flow_entries_flow_id_foreign` (`flow_id`),
  ADD KEY `flow_entries_user_id_foreign` (`user_id`);

--
-- Indizes für die Tabelle `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `galleries_name_unique` (`name`),
  ADD KEY `galleries_user_id_foreign` (`user_id`);

--
-- Indizes für die Tabelle `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `images_name_unique` (`name`),
  ADD KEY `images_user_id_foreign` (`user_id`);

--
-- Indizes für die Tabelle `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indizes für die Tabelle `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `schedules_old`
--
ALTER TABLE `schedules_old`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_image_id_foreign` (`image_id`),
  ADD KEY `schedules_user_id_foreign` (`user_id`);

--
-- Indizes für die Tabelle `schedule_entries`
--
ALTER TABLE `schedule_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sites_name_unique` (`name`),
  ADD KEY `sites_user_id_foreign` (`user_id`);

--
-- Indizes für die Tabelle `sync_google_images`
--
ALTER TABLE `sync_google_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sync_google_images_gallery_id_foreign` (`gallery_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_client_id_foreign` (`client_id`),
  ADD KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `device`
--
ALTER TABLE `device`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT für Tabelle `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `flows`
--
ALTER TABLE `flows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `flow_entries`
--
ALTER TABLE `flow_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT für Tabelle `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `schedules_old`
--
ALTER TABLE `schedules_old`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `schedule_entries`
--
ALTER TABLE `schedule_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `sites`
--
ALTER TABLE `sites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `sync_google_images`
--
ALTER TABLE `sync_google_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `flows`
--
ALTER TABLE `flows`
  ADD CONSTRAINT `flows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `flow_entries`
--
ALTER TABLE `flow_entries`
  ADD CONSTRAINT `flow_entries_flow_id_foreign` FOREIGN KEY (`flow_id`) REFERENCES `flows` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flow_entries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `schedules_old`
--
ALTER TABLE `schedules_old`
  ADD CONSTRAINT `schedules_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `sites`
--
ALTER TABLE `sites`
  ADD CONSTRAINT `sites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `sync_google_images`
--
ALTER TABLE `sync_google_images`
  ADD CONSTRAINT `sync_google_images_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
