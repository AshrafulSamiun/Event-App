-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 18, 2025 at 01:08 PM
-- Server version: 8.3.0
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar_events`
--

DROP TABLE IF EXISTS `calendar_events`;
CREATE TABLE IF NOT EXISTS `calendar_events` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `system_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_prefix` int NOT NULL DEFAULT '0',
  `current_year` int DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `priority_level` tinyint NOT NULL DEFAULT '0',
  `subject` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recurring_cycle` tinyint DEFAULT NULL,
  `repeat_every` tinyint DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `repeat_no_date_id` tinyint DEFAULT NULL,
  `required_action` text COLLATE utf8mb4_unicode_ci,
  `message` text COLLATE utf8mb4_unicode_ci,
  `comments` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `never_end` tinyint(1) DEFAULT NULL,
  `repeat_end_after` tinyint(1) DEFAULT NULL,
  `occerance_number` tinyint(1) DEFAULT NULL,
  `end_on` tinyint DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `inserted_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status_active` tinyint NOT NULL DEFAULT '1',
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `calendar_events`
--

INSERT INTO `calendar_events` (`id`, `system_no`, `system_prefix`, `current_year`, `event_date`, `start_time`, `end_time`, `priority_level`, `subject`, `recurring_cycle`, `repeat_every`, `start_date`, `repeat_no_date_id`, `required_action`, `message`, `comments`, `never_end`, `repeat_end_after`, `occerance_number`, `end_on`, `end_date`, `inserted_by`, `updated_by`, `status_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, 'EVNT-2025-0001', 1, 2025, '2025-02-18', '23:02:00', '23:43:00', 1, 'Monthly Meeting', 2, NULL, '2025-02-28', 2, 'fsdf sf sd sd', 'this is a big message lorum ipsum this is a big message lorum\nthis is a big message lorum ipsum this is a big message lorum\nthis is a big message lorum ipsum this is a big message lorum', 'sdf sdf sdf sdf', NULL, NULL, NULL, NULL, '2025-04-04', 100, 100, 1, 0, '2025-02-17 06:01:57', '2025-02-17 12:50:56'),
(3, 'EVNT-2025-0002', 2, 2025, '2025-02-27', '12:10:00', '16:03:00', 0, 'Project Delivery Time', NULL, NULL, NULL, NULL, 'Need to give git link', 'I Have to delivery the project', 'f dsf sdf', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-17 12:57:26', '2025-02-17 13:00:11'),
(4, 'EVNT-2025-0003', 3, 2025, '2025-02-20', '12:30:00', '13:10:00', 1, 'This is test csv', NULL, NULL, NULL, NULL, NULL, 'imort csv succfully', 'g hj j g', NULL, NULL, NULL, NULL, NULL, 101, 0, 1, 0, '2025-02-18 03:39:26', '2025-02-18 03:39:26'),
(5, 'EVNT-2025-0004', 4, 2025, '2025-05-20', '12:30:00', '13:10:00', 1, 'This isasd  test csv', NULL, NULL, NULL, NULL, NULL, 'imort csa sasd v succfully', 'g  as dhj j g', NULL, NULL, NULL, NULL, NULL, 101, 0, 1, 0, '2025-02-18 03:42:55', '2025-02-18 03:42:55'),
(6, 'EVNT-2025-0005', 5, 2025, '2025-02-18', '12:45:00', '15:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sdf sdf', 'scdscsdsd s', 'sd fsdf sdf sfd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 04:44:40', '2025-02-18 04:44:40'),
(7, 'EVNT-2025-0006', 6, 2025, '2025-02-20', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:02:40', '2025-02-18 05:02:40'),
(8, 'EVNT-2025-0007', 7, 2025, '2025-02-18', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:02:41', '2025-02-18 05:02:41'),
(9, 'EVNT-2025-0008', 8, 2025, '2025-02-04', '10:45:00', '04:52:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd fdf df', 'sd sdf sf sdf', 'sdf sdf sfd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:02:41', '2025-02-18 05:02:41'),
(10, 'EVNT-2025-0009', 9, 2025, '2025-02-18', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:02:41', '2025-02-18 05:02:41'),
(11, 'EVNT-2025-0010', 10, 2025, '2025-02-18', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:02:42', '2025-02-18 05:02:42'),
(12, 'EVNT-2025-0011', 11, 2025, '2025-02-18', '10:45:00', '04:52:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd fdf df', 'sd sdf sf sdf', 'sdf sdf sfd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:02:42', '2025-02-18 05:02:42'),
(13, 'EVNT-2025-0012', 12, 2025, '2025-02-25', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:02:58', '2025-02-18 05:02:58'),
(14, 'EVNT-2025-0013', 13, 2025, '2025-02-18', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:02:59', '2025-02-18 05:02:59'),
(15, 'EVNT-2025-0014', 14, 2025, '2025-02-24', '10:45:00', '04:52:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd fdf df', 'sd sdf sf sdf', 'sdf sdf sfd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:02:59', '2025-02-18 05:02:59'),
(16, 'EVNT-2025-0015', 15, 2025, '2025-02-18', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:03:42', '2025-02-18 05:03:42'),
(17, 'EVNT-2025-0016', 16, 2025, '2025-03-10', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:03:42', '2025-02-18 05:03:42'),
(18, 'EVNT-2025-0017', 17, 2025, '2025-02-18', '10:45:00', '04:52:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd fdf df', 'sd sdf sf sdf', 'sdf sdf sfd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:03:42', '2025-02-18 05:03:42'),
(19, 'EVNT-2025-0018', 18, 2025, '2025-04-22', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:08:44', '2025-02-18 05:08:44'),
(27, 'EVNT-2025-0026', 26, 2025, '2025-02-18', '10:45:00', '04:52:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd fdf df', 'sd sdf sf sdf', 'sdf sdf sfd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:09:12', '2025-02-18 05:09:12'),
(28, 'EVNT-2025-0027', 27, 2025, '2025-02-18', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:09:12', '2025-02-18 05:09:12'),
(29, 'EVNT-2025-0028', 28, 2025, '2025-02-18', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:09:13', '2025-02-18 05:09:13'),
(30, 'EVNT-2025-0029', 29, 2025, '2025-02-18', '10:45:00', '04:52:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd fdf df', 'sd sdf sf sdf', 'sdf sdf sfd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:09:13', '2025-02-18 05:09:13'),
(31, 'EVNT-2025-0030', 30, 2025, '2025-02-18', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:11:03', '2025-02-18 05:11:03'),
(32, 'EVNT-2025-0031', 31, 2025, '2025-02-18', '12:45:00', '17:42:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd sdf sd f', 'sd dsd fsdf sd', 'sdf sdf sdf sd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:11:03', '2025-02-18 05:11:03'),
(33, 'EVNT-2025-0032', 32, 2025, '2025-02-18', '10:45:00', '04:52:00', 0, 'Worker holyday allowence', NULL, NULL, NULL, NULL, 'sd fdf df', 'sd sdf sf sdf', 'sdf sdf sfd', NULL, NULL, NULL, NULL, NULL, 100, 0, 1, 0, '2025-02-18 05:11:03', '2025-02-18 05:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_remindars`
--

DROP TABLE IF EXISTS `calendar_remindars`;
CREATE TABLE IF NOT EXISTS `calendar_remindars` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `reminder_no` tinyint DEFAULT NULL,
  `reminder_period` tinyint DEFAULT NULL,
  `mst_id` int NOT NULL DEFAULT '0',
  `time` time NOT NULL,
  `reminder_date` date DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_sent` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inserted_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status_active` tinyint NOT NULL DEFAULT '1',
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `calendar_remindars`
--

INSERT INTO `calendar_remindars` (`id`, `reminder_no`, `reminder_period`, `mst_id`, `time`, `reminder_date`, `email`, `mail_sent`, `description`, `inserted_by`, `updated_by`, `status_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '06:30:00', '2025-02-17', 'iashraful46@yahoo.com', 0, 'fsdf sdf sdf', 100, 100, 1, 0, NULL, '2025-02-17 19:25:12'),
(2, 2, 3, 2, '06:30:00', '2025-02-15', 'iashraful46@yahoo.com', 0, 'sdf df sf sdf', 100, 100, 1, 0, NULL, '2025-02-17 19:25:12'),
(3, 1, 1, 3, '04:30:00', '2025-02-26', 'iashraful46@yahoo.com', 0, 'Project need to deliver', 100, 100, 1, 0, NULL, '2025-02-17 19:26:02'),
(4, 1, 1, 6, '10:24:00', '2025-02-17', 'iashraful46@yahoo.com', 0, 'dsfsd fsdf sd', 100, 0, 1, 0, NULL, NULL),
(5, 1, 1, 7, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(6, 1, 1, 8, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(7, 1, 1, 10, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(8, 1, 1, 11, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(9, 1, 1, 13, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(10, 1, 1, 14, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(11, 1, 1, 16, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(12, 1, 1, 17, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 100, 1, 0, NULL, '2025-02-18 06:29:55'),
(13, 1, 1, 19, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 100, 1, 0, NULL, '2025-02-18 06:29:35'),
(14, 1, 1, 20, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(15, 1, 1, 21, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(16, 1, 1, 22, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(17, 1, 1, 25, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(18, 1, 1, 26, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(19, 1, 1, 28, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(20, 1, 1, 29, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(21, 1, 1, 31, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(22, 1, 1, 32, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(23, 1, 1, 34, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(24, 1, 1, 35, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(25, 1, 1, 37, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(26, 1, 1, 38, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(27, 1, 1, 40, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL),
(28, 1, 1, 41, '12:45:00', '2025-02-17', 'a.i.bhouiyan@gmail.com', 0, 'dsf sd fsdf', 100, 0, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_09_16_070934_create_calendar_events_table', 1),
(5, '2024_09_24_030334_create_calendar_remindars_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_type` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` int NOT NULL,
  `company_id` int DEFAULT NULL,
  `account_holder_id` int NOT NULL,
  `project_type` tinyint NOT NULL,
  `authenticated_by_admin` tinyint NOT NULL,
  `pin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_active` tinyint NOT NULL DEFAULT '1',
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_status_active_index` (`status_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
