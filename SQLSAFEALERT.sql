-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 12:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `safealertbun`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `alert_id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `severity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `authority_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`alert_id`, `user_id`, `latitude`, `longitude`, `severity`, `created_at`, `status`, `location`, `authority_id`) VALUES
(2, 'b185bcb4-7b03-44bb-bfe8-6687203ecb72', 45.75107496499752, 21.210311919207562, 4, '2025-05-21 20:05:13', 'new', 'Timișoara', NULL),
(9, 'c9a80835-88b9-4dc5-b869-9fd245c7940c', 45.7505087386019, 21.215495571091147, 3, '2025-05-21 21:19:07', 'new', 'Timișoara', 'AUT-20250520-002'),
(11, '1857b22d-bce7-42f0-9e09-b98d6f2ea030', 45.75085341189982, 21.21613658929586, 3, '2025-05-21 22:07:09', 'new', 'Timișoara', 'AUT-20250520-002'),
(12, 'd38f67b3-6056-4fef-ba5b-f648a0c82d08', 44.43295165899295, 26.103312885940106, 5, '2025-05-22 22:42:57', 'new', 'București', 'AUT-20250520-001'),
(15, '329accf2-6b27-4695-8ff9-036d7d1a474c', 45.7500185382236, 21.212988158445654, 4, '2025-05-22 23:38:54', 'new', 'Timișoara', 'AUT-20250520-002'),
(16, '24001726-4ccc-47b5-b53b-28fff67d048f', 47.16582508040545, 27.60757751002059, 5, '2025-05-22 23:39:36', 'new', 'Iași', 'AUT-20250520-003'),
(17, 'ad47229a-faf8-4b6e-98f7-dd8783d4795c', 47.16485632480385, 27.610123106926764, 5, '2025-05-22 23:41:08', 'new', 'Iași', 'AUT-20250520-003'),
(18, '0a5c9c0e-467f-4095-a768-779062829850', 47.16195383397808, 27.609216669157394, 4, '2025-05-22 23:44:04', 'new', 'Iași', 'AUT-20250520-003'),
(19, '2a8fa916-9cd3-4c5f-ba74-a5486b274ed8', 44.432264620887004, 26.102828238734755, 5, '2025-05-22 23:47:40', 'new', 'București', 'AUT-20250520-001'),
(20, '401ccb24-0403-4d13-b255-6fe3d8c43726', 45.75282461157702, 21.216988547071757, 3, '2025-05-22 23:49:55', 'new', 'Timișoara', 'AUT-20250520-002'),
(21, 'ff21797e-30d4-4f0f-8661-8ce63315b03f', 44.4330547796723, 26.10768411116995, 3, '2025-05-22 23:54:53', 'new', 'București', 'AUT-20250520-001'),
(22, 'ff21797e-30d4-4f0f-8661-8ce63315b03f', 47.16135791086028, 27.610010386795885, 5, '2025-05-22 23:54:57', 'new', 'Iași', 'AUT-20250520-003'),
(23, '4cc6105e-f8ba-49cd-98a2-95f54cbfff5e', 44.43602508378008, 26.103725006127878, 3, '2025-05-23 00:00:16', 'new', 'București', 'AUT-20250520-001'),
(24, '4cc6105e-f8ba-49cd-98a2-95f54cbfff5e', 47.16212295668884, 27.603915026728775, 4, '2025-05-23 00:00:23', 'new', 'Iași', 'AUT-20250520-003'),
(25, '15b673a2-b0f3-465f-acc6-3b8b8a687c3c', 47.16724874639411, 27.604211418888262, 3, '2025-05-23 10:05:15', 'new', 'Iași', 'AUT-20250520-003'),
(27, '5fe0ab1f-ff1d-4b8e-8046-132b36313163', 47.167075818607785, 27.602440911321075, 5, '2025-05-23 12:01:36', 'new', 'Iași', 'AUT-20250520-003'),
(28, 'a8cbbaa1-d196-454e-b9d7-b45e5ef92e03', 45.757234956370915, 21.21175694431628, 5, '2025-05-23 12:02:05', 'new', 'Timișoara', 'AUT-20250520-002'),
(29, 'b40667c4-cd75-46ee-9910-9387da259dd7', 45.75187561667093, 21.209234818386044, 5, '2025-05-23 12:02:23', 'new', 'Timișoara', 'AUT-20250520-002'),
(30, '044c72be-357a-45c6-b50f-3c43c565feca', 47.16638967567147, 27.604601433180072, 3, '2025-05-23 12:02:41', 'new', 'Iași', 'AUT-20250520-003'),
(31, '598f9162-6742-4394-a759-6c2c7e639628', 47.16567194003069, 27.603401760362527, 5, '2025-05-23 12:02:58', 'new', 'Iași', 'AUT-20250520-003'),
(32, '1cf6d45e-e491-48c3-bdc8-c1452fbceb86', 45.7516779648997, 21.213285561383397, 3, '2025-05-23 12:03:13', 'new', 'Timișoara', 'AUT-20250520-002'),
(33, '96f84580-8189-402b-905e-d720541f705f', 44.43559769648395, 26.11053597049624, 3, '2025-05-23 12:03:33', 'new', 'București', 'AUT-20250520-001'),
(34, '29b9d7af-640d-4ab0-ba1a-1da6c8f5a1ca', 47.15851629333531, 27.604186421831667, 5, '2025-05-23 12:03:55', 'new', 'Iași', 'AUT-20250520-003'),
(35, 'a1d71794-1e7f-4c2e-8918-d3694136ac6e', 47.164381492857046, 27.608756201080976, 5, '2025-05-23 12:04:11', 'new', 'Iași', 'AUT-20250520-003'),
(36, 'e8ef763b-7ba3-49fb-a2f7-8d6c75347d3e', 45.75279149092051, 21.21658614984405, 4, '2025-05-23 12:04:26', 'new', 'Timișoara', 'AUT-20250520-002'),
(37, 'd7dba953-67ca-4783-978a-ee33d5523dc6', 47.162283941938725, 27.61052164462373, 5, '2025-05-23 12:04:52', 'new', 'Iași', 'AUT-20250520-003'),
(38, 'ad47229a-faf8-4b6e-98f7-dd8783d4795c', 44.42900294768878, 26.110773242103853, 3, '2025-05-23 12:05:35', 'new', 'București', 'AUT-20250520-001');

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`user_id`, `uuid`, `name`) VALUES
(1, 'b185bcb4-7b03-44bb-bfe8-6687203ecb72', 'Daniel'),
(2, 'e181560d-6a9e-46e8-a631-a037525f496e', 'Claudiu'),
(3, 'c9a80835-88b9-4dc5-b869-9fd245c7940c', 'Craita'),
(4, '1857b22d-bce7-42f0-9e09-b98d6f2ea030', 'Alex'),
(5, 'd38f67b3-6056-4fef-ba5b-f648a0c82d08', 'Cristiana'),
(6, '5cf62ef6-64c9-4f59-9be8-c71b401c7243', 'Cristiana'),
(7, 'e9a07aab-a931-4f8e-9744-3da1b34047a0', 'Cristiana'),
(8, '329accf2-6b27-4695-8ff9-036d7d1a474c', 'Claudia'),
(9, '24001726-4ccc-47b5-b53b-28fff67d048f', 'Virginia'),
(10, 'ad47229a-faf8-4b6e-98f7-dd8783d4795c', 'Renata'),
(11, '0a5c9c0e-467f-4095-a768-779062829850', 'Valeria'),
(12, '2a8fa916-9cd3-4c5f-ba74-a5486b274ed8', 'Clementina'),
(13, '401ccb24-0403-4d13-b255-6fe3d8c43726', 'Corneliu'),
(14, 'ff21797e-30d4-4f0f-8661-8ce63315b03f', 'Cruela'),
(15, '4cc6105e-f8ba-49cd-98a2-95f54cbfff5e', 'George'),
(16, '15b673a2-b0f3-465f-acc6-3b8b8a687c3c', 'Ioana'),
(17, '5fe0ab1f-ff1d-4b8e-8046-132b36313163', 'Ruxandra'),
(18, 'a8cbbaa1-d196-454e-b9d7-b45e5ef92e03', 'Ovidiu'),
(19, 'b40667c4-cd75-46ee-9910-9387da259dd7', 'Gabriel'),
(20, '044c72be-357a-45c6-b50f-3c43c565feca', 'Elena'),
(21, '598f9162-6742-4394-a759-6c2c7e639628', 'Grigore'),
(22, '1cf6d45e-e491-48c3-bdc8-c1452fbceb86', 'Iolanda'),
(23, '96f84580-8189-402b-905e-d720541f705f', 'Narisa'),
(24, '29b9d7af-640d-4ab0-ba1a-1da6c8f5a1ca', 'Tiberiu'),
(25, 'a1d71794-1e7f-4c2e-8918-d3694136ac6e', 'Ecaterina'),
(26, 'e8ef763b-7ba3-49fb-a2f7-8d6c75347d3e', 'Ion'),
(27, 'd7dba953-67ca-4783-978a-ee33d5523dc6', 'Horatiu');

-- --------------------------------------------------------

--
-- Table structure for table `authorities`
--

CREATE TABLE `authorities` (
  `authority_id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `contact_details` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authorities`
--

INSERT INTO `authorities` (`authority_id`, `name`, `type`, `region`, `contact_details`, `contact_person`, `status`) VALUES
('AUT-20250520-001', 'Sectia 1 de politie', 'Poliție', 'București', 'sectia1@politie.ro, 021-1234567', 'Agent Ion Popescu', 'ACTIV'),
('AUT-20250520-002', 'Poliția Timișoara', 'Poliție', 'Timișoara', 'timisoara@politie.ro, 0256-765432', 'Agent Maria Ionescu', 'ACTIV'),
('AUT-20250520-003', 'Poliția Iași', 'Poliție', 'Iași', 'iasi@politie.ro, 0232-987654', 'Agent Andrei Georgescu', 'ACTIV'),
('AUT-20250520-004', 'Centrul de Asistență pentru Victime', 'ONG', 'București', 'contact@victime.ro, 021-998877', 'Doamna Elena Vasilescu', 'ACTIV'),
('AUT-20250520-005', 'Asociația Sprijin Femei', 'ONG', 'Timișoara', 'office@sprijinfemei.ro, 0256-112233', 'Domnul Mihai Popa', 'ACTIV'),
('AUT-20250520-006', 'Serviciul Social Iași', 'Serviciu Social', 'Iași', 'social@iasi.ro, 0232-445566', 'Doamna Ana Marinescu', 'ACTIV');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `form_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `severity` varchar(20) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `alert_id` int(10) UNSIGNED DEFAULT NULL,
  `authority_id` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`form_id`, `user_id`, `location`, `severity`, `details`, `created_at`, `alert_id`, `authority_id`, `status`, `code`) VALUES
(2, 1, 'Timișoara', 'Nivel 4', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Raluca. Regiune detectată: Timișoara. Autoritate desemnată automat: Necunoscută.', '2025-05-21 20:05:13', 2, NULL, 'new', 'SAF-20250521-354'),
(9, 3, 'Timișoara', 'Nivel 3', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Craita. Regiune detectată: Timișoara. Autoritate desemnată automat: Poliția Timișoara.', '2025-05-21 21:19:07', 9, 'AUT-20250520-002', 'new', 'SAF-20250521-444'),
(11, 4, 'Timișoara', 'Nivel 3', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Alex. Regiune detectată: Timișoara. Autoritate desemnată automat: Poliția Timișoara.', '2025-05-21 22:07:09', 11, 'AUT-20250520-002', 'new', 'SAF-20250521-459'),
(12, 5, 'București', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Cristiana. Regiune detectată: București. Autoritate desemnată automat: Sectia 1 de politie.', '2025-05-22 22:42:57', 12, 'AUT-20250520-001', 'new', 'SAF-20250522-571'),
(15, 8, 'Timișoara', 'Nivel 4', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Claudia. Regiune detectată: Timișoara. Autoritate desemnată automat: Poliția Timișoara.', '2025-05-22 23:38:54', 15, 'AUT-20250520-002', 'new', 'SAF-20250522-600'),
(16, 9, 'Iași', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Virginia. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-22 23:39:36', 16, 'AUT-20250520-003', 'new', 'SAF-20250522-892'),
(17, 10, 'Iași', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Renata. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-22 23:41:08', 17, 'AUT-20250520-003', 'new', 'SAF-20250522-899'),
(18, 11, 'Iași', 'Nivel 4', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Valeria. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-22 23:44:04', 18, 'AUT-20250520-003', 'new', 'SAF-20250522-483'),
(19, 12, 'București', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Clementina. Regiune detectată: București. Autoritate desemnată automat: Sectia 1 de politie.', '2025-05-22 23:47:40', 19, 'AUT-20250520-001', 'new', 'SAF-20250522-455'),
(20, 13, 'Timișoara', 'Nivel 3', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Corneliu. Regiune detectată: Timișoara. Autoritate desemnată automat: Poliția Timișoara.', '2025-05-22 23:49:55', 20, 'AUT-20250520-002', 'new', 'SAF-20250522-715'),
(21, 14, 'București', 'Nivel 3', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Cruela. Regiune detectată: București. Autoritate desemnată automat: Sectia 1 de politie.', '2025-05-22 23:54:53', 21, 'AUT-20250520-001', 'new', 'SAF-20250522-138'),
(22, 14, 'Iași', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Cruela. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-22 23:54:57', 22, 'AUT-20250520-003', 'new', 'SAF-20250522-824'),
(23, 15, 'București', 'Nivel 3', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: George. Regiune detectată: București. Autoritate desemnată automat: Sectia 1 de politie.', '2025-05-23 00:00:16', 23, 'AUT-20250520-001', 'new', 'SAF-20250523-404'),
(24, 15, 'Iași', 'Nivel 4', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: George. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-23 00:00:23', 24, 'AUT-20250520-003', 'new', 'SAF-20250523-889'),
(25, 16, 'Iași', 'Nivel 3', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Ioana. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-23 10:05:15', 25, 'AUT-20250520-003', 'new', 'SAF-20250523-284'),
(27, 17, 'Iași', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Ruxandra. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-23 12:01:36', 27, 'AUT-20250520-003', 'new', 'SAF-20250523-301'),
(28, 18, 'Timișoara', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Ovidiu. Regiune detectată: Timișoara. Autoritate desemnată automat: Poliția Timișoara.', '2025-05-23 12:02:05', 28, 'AUT-20250520-002', 'new', 'SAF-20250523-708'),
(29, 19, 'Timișoara', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Gabriel. Regiune detectată: Timișoara. Autoritate desemnată automat: Poliția Timișoara.', '2025-05-23 12:02:23', 29, 'AUT-20250520-002', 'new', 'SAF-20250523-722'),
(30, 20, 'Iași', 'Nivel 3', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Elena. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-23 12:02:41', 30, 'AUT-20250520-003', 'new', 'SAF-20250523-832'),
(31, 21, 'Iași', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Grigore. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-23 12:02:58', 31, 'AUT-20250520-003', 'new', 'SAF-20250523-524'),
(32, 22, 'Timișoara', 'Nivel 3', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Iolanda. Regiune detectată: Timișoara. Autoritate desemnată automat: Poliția Timișoara.', '2025-05-23 12:03:13', 32, 'AUT-20250520-002', 'new', 'SAF-20250523-508'),
(33, 23, 'București', 'Nivel 3', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Narisa. Regiune detectată: București. Autoritate desemnată automat: Sectia 1 de politie.', '2025-05-23 12:03:33', 33, 'AUT-20250520-001', 'new', 'SAF-20250523-292'),
(34, 24, 'Iași', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Tiberiu. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-23 12:03:55', 34, 'AUT-20250520-003', 'new', 'SAF-20250523-361'),
(35, 25, 'Iași', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Ecaterina. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-23 12:04:11', 35, 'AUT-20250520-003', 'new', 'SAF-20250523-904'),
(36, 26, 'Timișoara', 'Nivel 4', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Ion. Regiune detectată: Timișoara. Autoritate desemnată automat: Poliția Timișoara.', '2025-05-23 12:04:26', 36, 'AUT-20250520-002', 'new', 'SAF-20250523-691'),
(37, 27, 'Iași', 'Nivel 5', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Horatiu. Regiune detectată: Iași. Autoritate desemnată automat: Poliția Iași.', '2025-05-23 12:04:52', 37, 'AUT-20250520-003', 'new', 'SAF-20250523-429'),
(38, 10, 'București', 'Nivel 3', 'Alertă generată automat de sistem pentru analiza cazului raportat de user ID: Renata. Regiune detectată: București. Autoritate desemnată automat: Sectia 1 de politie.', '2025-05-23 12:05:35', 38, 'AUT-20250520-001', 'new', 'SAF-20250523-664');

-- --------------------------------------------------------

--
-- Table structure for table `interventions`
--

CREATE TABLE `interventions` (
  `intervention_id` int(10) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED DEFAULT NULL,
  `intervention_type` varchar(100) DEFAULT NULL,
  `responsible_person` varchar(100) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interventions`
--

INSERT INTO `interventions` (`intervention_id`, `form_id`, `intervention_type`, `responsible_person`, `details`, `status`, `created_at`) VALUES
(2, 11, 'Juridica', 'Agent Maria Ionescu', 'S-au dispus amenzi impotriva agresorului pentru disturbarea linistii publice ', 'finalizată', '2025-05-21 22:22:58'),
(3, 2, 'Juridica', 'Ana Corina', 'S-a dispus o cerere pentru ordin de protectie pentru victima impotriva agresorului, victima se afla in centru de adapost pana la solutionarea cererii ordinului de protectie.', 'finalizată', '2025-05-23 10:36:35'),
(5, 9, 'Asistență socială', 'Doamna Ana Marinescu', 'A fost oferit sprijin material: alimente și produse de igienă.', 'finalizat', '2025-05-23 13:12:40'),
(6, 12, 'Coordonare autoritate locală', 'Agent Andrei Georgescu', 'Echipajul s-a deplasat la locație pentru evaluare și documentare a situației.', 'În desfășurare', '2025-05-23 13:13:36'),
(7, 15, 'Psihologică + medicație', 'Doamna Elena Vasilescu', 'Victima a primit recomandare pentru tratament ușor anxiolitic.', 'finalizata', '2025-05-23 13:14:08'),
(8, 16, 'Juridică', 'Agent Maria Ionescu', 'Au fost demarate proceduri pentru deschiderea unui dosar penal.', 'În desfășurare', '2025-05-23 13:14:44'),
(9, 17, 'Sprijin ONG – consiliere', 'Domnul Mihai Popa', 'Victima a primit suport informativ și juridic în cadrul ONG-ului.', 'finalizata', '2025-05-23 13:15:09'),
(10, 18, 'Evaluare psihologică inițială', 'Doamna Elena Vasilescu', 'Discuție de 45 de minute cu stabilirea gradului de risc emoțional.', 'finalizata', '2025-05-23 13:15:34'),
(11, 19, 'Sprijin pentru relocare', 'Doamna Ana Marinescu', 'Victima a fost direcționată spre serviciul social pentru reîntoarcere în siguranță.', 'În desfășurare', '2025-05-23 13:15:57'),
(12, 20, 'Coordonare echipă mobilă', 'Agent Ion Popescu', 'Patrulă mixtă a vizitat locul incidentului pentru prelevare de dovezi.', 'finalizata', '2025-05-23 13:16:22'),
(13, 21, 'Psihologică (online)', 'Doamna Elena Vasilescu', 'Ședință de consiliere online pentru victimă aflată în izolare.', 'finalizata', '2025-05-23 13:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `system_user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `authority_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`system_user_id`, `username`, `password_hash`, `role`, `authority_id`) VALUES
(1, 'admin', '$2y$10$WMZniN/byDtqZAkvJ03m2.yXyRK8iucKJXVMvxdLdQx2WKdtVyBSS', 'admin', NULL),
(2, 'politia_iasi', '$2y$10$u1fysdzqPdNvmjRm6hvv4ebH.4ibHnUYb7DyDyCMeJQBNHzbqUwYq', 'authority', 'AUT-20250520-001'),
(3, 'politia_timisoara', '$2y$10$u1fysdzqPdNvmjRm6hvv4ebH.4ibHnUYb7DyDyCMeJQBNHzbqUwYq', 'authority', 'AUT-20250520-002'),
(4, 'ong_salvare', '$2y$10$u1fysdzqPdNvmjRm6hvv4ebH.4ibHnUYb7DyDyCMeJQBNHzbqUwYq', 'ngo', 'ONG-20250520-001'),
(5, 'ong_sustinere', '$2y$10$u1fysdzqPdNvmjRm6hvv4ebH.4ibHnUYb7DyDyCMeJQBNHzbqUwYq', 'ngo', 'ONG-20250520-002');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `authority_id` (`authority_id`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `authorities`
--
ALTER TABLE `authorities`
  ADD PRIMARY KEY (`authority_id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`form_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `alert_id` (`alert_id`),
  ADD KEY `authority_id` (`authority_id`);

--
-- Indexes for table `interventions`
--
ALTER TABLE `interventions`
  ADD PRIMARY KEY (`intervention_id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`system_user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `alert_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `form_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `interventions`
--
ALTER TABLE `interventions`
  MODIFY `intervention_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `system_user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`uuid`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `alerts_ibfk_2` FOREIGN KEY (`authority_id`) REFERENCES `authorities` (`authority_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `forms_ibfk_2` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `forms_ibfk_3` FOREIGN KEY (`authority_id`) REFERENCES `authorities` (`authority_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `interventions`
--
ALTER TABLE `interventions`
  ADD CONSTRAINT `interventions_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
