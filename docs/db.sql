-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Apr 28, 2026 at 08:02 PM
-- Server version: 9.3.0
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--
CREATE DATABASE IF NOT EXISTS `laravel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `laravel`;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carimages`
--

CREATE TABLE `carimages` (
  `car_imageid` bigint UNSIGNED NOT NULL,
  `car_id` bigint UNSIGNED NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carimages`
--

INSERT INTO `carimages` (`car_imageid`, `car_id`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'http://backend.vm1.test/storage/cars/seed-listing-1-0.jpg', '2026-04-28 18:01:42', '2026-04-28 18:01:42'),
(2, 1, 'http://backend.vm1.test/storage/cars/seed-listing-1-1.jpg', '2026-04-28 18:01:42', '2026-04-28 18:01:42'),
(3, 1, 'http://backend.vm1.test/storage/cars/seed-listing-1-2.jpg', '2026-04-28 18:01:42', '2026-04-28 18:01:42'),
(4, 1, 'http://backend.vm1.test/storage/cars/seed-listing-1-3.jpg', '2026-04-28 18:01:42', '2026-04-28 18:01:42'),
(5, 2, 'http://backend.vm1.test/storage/cars/seed-listing-2-0.jpg', '2026-04-28 18:01:42', '2026-04-28 18:01:42'),
(6, 2, 'http://backend.vm1.test/storage/cars/seed-listing-2-1.jpg', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(7, 2, 'http://backend.vm1.test/storage/cars/seed-listing-2-2.jpg', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(8, 3, 'http://backend.vm1.test/storage/cars/seed-listing-3-0.jpg', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(9, 3, 'http://backend.vm1.test/storage/cars/seed-listing-3-1.jpg', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(10, 3, 'http://backend.vm1.test/storage/cars/seed-listing-3-2.jpg', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(11, 4, 'http://backend.vm1.test/storage/cars/seed-listing-4-0.jpg', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(12, 4, 'http://backend.vm1.test/storage/cars/seed-listing-4-1.jpg', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(13, 4, 'http://backend.vm1.test/storage/cars/seed-listing-4-2.jpg', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(14, 5, 'http://backend.vm1.test/storage/cars/seed-listing-5-0.jpg', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(15, 5, 'http://backend.vm1.test/storage/cars/seed-listing-5-1.jpg', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(16, 5, 'http://backend.vm1.test/storage/cars/seed-listing-5-2.jpg', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(17, 6, 'http://backend.vm1.test/storage/cars/seed-listing-6-0.jpg', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(18, 6, 'http://backend.vm1.test/storage/cars/seed-listing-6-1.jpg', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(19, 7, 'http://backend.vm1.test/storage/cars/seed-listing-7-0.jpg', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(20, 7, 'http://backend.vm1.test/storage/cars/seed-listing-7-1.jpg', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(21, 7, 'http://backend.vm1.test/storage/cars/seed-listing-7-2.jpg', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(22, 8, 'http://backend.vm1.test/storage/cars/seed-listing-8-0.jpg', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(23, 8, 'http://backend.vm1.test/storage/cars/seed-listing-8-1.jpg', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(24, 8, 'http://backend.vm1.test/storage/cars/seed-listing-8-2.jpg', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(25, 9, 'http://backend.vm1.test/storage/cars/seed-listing-9-0.jpg', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(26, 9, 'http://backend.vm1.test/storage/cars/seed-listing-9-1.jpg', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(27, 9, 'http://backend.vm1.test/storage/cars/seed-listing-9-2.jpg', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(28, 10, 'http://backend.vm1.test/storage/cars/seed-listing-10-0.jpg', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(29, 10, 'http://backend.vm1.test/storage/cars/seed-listing-10-1.jpg', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(30, 10, 'http://backend.vm1.test/storage/cars/seed-listing-10-2.jpg', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(31, 11, 'http://backend.vm1.test/storage/cars/seed-listing-11-0.jpg', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(32, 11, 'http://backend.vm1.test/storage/cars/seed-listing-11-1.jpg', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(33, 11, 'http://backend.vm1.test/storage/cars/seed-listing-11-2.jpg', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(34, 11, 'http://backend.vm1.test/storage/cars/seed-listing-11-3.jpg', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(35, 12, 'http://backend.vm1.test/storage/cars/seed-listing-12-0.jpg', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(36, 13, 'http://backend.vm1.test/storage/cars/seed-listing-13-0.jpg', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(37, 13, 'http://backend.vm1.test/storage/cars/seed-listing-13-1.jpg', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(38, 13, 'http://backend.vm1.test/storage/cars/seed-listing-13-2.jpg', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(39, 13, 'http://backend.vm1.test/storage/cars/seed-listing-13-3.jpg', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(40, 14, 'http://backend.vm1.test/storage/cars/seed-listing-14-0.png', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(41, 14, 'http://backend.vm1.test/storage/cars/seed-listing-14-1.png', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(42, 15, 'http://backend.vm1.test/storage/cars/seed-listing-15-0.jpg', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(43, 15, 'http://backend.vm1.test/storage/cars/seed-listing-15-1.png', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(44, 15, 'http://backend.vm1.test/storage/cars/seed-listing-15-2.jpg', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(45, 16, 'http://backend.vm1.test/storage/cars/seed-listing-16-0.jpg', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(46, 16, 'http://backend.vm1.test/storage/cars/seed-listing-16-1.jpg', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(47, 16, 'http://backend.vm1.test/storage/cars/seed-listing-16-2.jpg', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(48, 17, 'http://backend.vm1.test/storage/cars/seed-listing-17-0.jpg', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(49, 17, 'http://backend.vm1.test/storage/cars/seed-listing-17-1.jpg', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(50, 17, 'http://backend.vm1.test/storage/cars/seed-listing-17-2.jpg', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(51, 17, 'http://backend.vm1.test/storage/cars/seed-listing-17-3.jpg', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(52, 18, 'http://backend.vm1.test/storage/cars/seed-listing-18-0.jpg', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(53, 18, 'http://backend.vm1.test/storage/cars/seed-listing-18-1.jpg', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(54, 18, 'http://backend.vm1.test/storage/cars/seed-listing-18-2.jpg', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(55, 19, 'http://backend.vm1.test/storage/cars/seed-listing-19-0.jpg', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(56, 19, 'http://backend.vm1.test/storage/cars/seed-listing-19-1.png', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(57, 19, 'http://backend.vm1.test/storage/cars/seed-listing-19-2.jpg', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(58, 20, 'http://backend.vm1.test/storage/cars/seed-listing-20-0.jpg', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(59, 20, 'http://backend.vm1.test/storage/cars/seed-listing-20-1.jpg', '2026-04-28 18:01:49', '2026-04-28 18:01:49'),
(60, 20, 'http://backend.vm1.test/storage/cars/seed-listing-20-2.jpg', '2026-04-28 18:01:49', '2026-04-28 18:01:49');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` bigint UNSIGNED NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year NOT NULL,
  `mileage` int NOT NULL,
  `fuel_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transmission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `engine_size` int NOT NULL,
  `body_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `description`, `color`, `year`, `mileage`, `fuel_type`, `transmission`, `engine_size`, `body_type`, `created_at`, `updated_at`) VALUES
(1, 'Opel', 'H-Astra Twinport', 'Megkímélt, szervizelt autó, családi használatra kiváló állapotban.', 'Szürke', '2006', 242536, 'Benzin', 'Manuális', 1598, 'Kombi', '2026-04-28 18:01:42', '2026-04-28 18:01:42'),
(2, 'Volkswagen', 'Golf 7 GTE', 'A Volkswagen Golf Mk7 GTE a Volkswagen sportos plug-in hibrid modellje. A benzinmotor és villanymotor kombinációja erős gyorsulást és alacsony fogyasztást kínál, miközben megőrzi a Golf kényelmét és mindennapi használhatóságát.', 'Kék', '2015', 210000, 'Hibrid', 'Automata', 1400, 'Ferdehátú', '2026-04-28 18:01:42', '2026-04-28 18:01:42'),
(3, 'Audi', 'A3 8V', 'Az Audi A3 8V 2.0 CR TDI az Audi kompakt modellje, amely erős és takarékos dízelmotorjáról ismert. Kényelmes, jól összerakott belső térrel és stabil vezethetőséggel ideális mindennapi használatra és hosszabb utakra is.', 'Fehér', '2013', 210000, 'Dízel', 'Manuális', 2000, 'Ferdehátú', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(4, 'Volkswagen', 'Jetta', 'A Volkswagen Jetta (A6) egy kompakt autó, a Volkswagen Jetta hatodik generációja és a Jetta (A5) utódja. Fejlesztése során NCS (New Compact Sedan) néven ismert modell 2010-ben jelent meg.', 'Ezüst', '2013', 200000, 'Benzin', 'Manuális', 1200, 'Sedán', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(5, 'Opel', 'J-Astra GTC', 'Egy sportos, háromajtós kompakt autó az Opel kínálatában. Dinamikus dizájn, feszesebb futómű és turbós motorok jellemzik, így a praktikum mellé élvezetes vezetést is ad.', 'Sárga', '2012', 337000, 'Dízel', 'Manuális', 2000, 'Ferdehátú', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(6, 'Seat', 'Leon FR', 'A SEAT Leon Mk1 FR 2.0 TFSI a SEAT első generációs Leonjának sportos változata. A 2.0 TFSI turbós benzinmotor erős és jól tuningolható, miközben a feszes futómű és a sportos megjelenés élvezetes vezetést ad.', 'Fehér', '2007', 278000, 'Benzin', 'Manuális', 2000, 'Ferdehátú', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(7, 'Volkswagen', 'Golf GTI', 'A Volkswagen Golf Mk6 GTI a Volkswagen ikonikus sportos kompaktja. A 2.0 TSI turbómotor erős és élvezetes vezetést ad, miközben a GTI megőrzi a mindennapi használhatóságot és a klasszikus sportos stílust.', 'Fekete', '2009', 230000, 'Benzin', 'Automata', 2000, 'Ferdehátú', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(8, 'Volvo', 'C30 R-Line', 'A Volvo C30 T5 a Volvo Cars egyik legizgalmasabb kompakt modellje. Az 5 hengeres turbós benzinmotor erős, jellegzetes hangú és élvezetes vezetést ad, miközben a C30 különleges, sportos formája igazán egyedivé teszi.', 'Fehér', '2013', 210000, 'Dízel', 'Automata', 2400, 'Ferdehátú', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(9, 'Volkswagen', 'Golf 7 R-Line', 'A Volkswagen Golf Mk7 1.4 TSI 150 R-Line a Volkswagen egyik népszerű kompaktja. Az 1.4 TSI 150 lóerős turbómotor dinamikus, mégis takarékos, az R-Line csomag pedig sportos külsőt és hangulatot ad a mindennapi használhatóság mellé.', 'Fehér', '2014', 174000, 'Benzin', 'Manuális', 1400, 'Ferdehátú', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(10, 'Mercedes', 'A 160', 'A Mercedes-Benz A160 1.6 Turbo a Mercedes-Benz belépő szintű kompakt modellje. Az 1.6-os turbós benzinmotor kulturált és takarékos, miközben az autó prémium belsőt és kényelmes mindennapi használatot kínál.', 'Fekete', '2017', 150000, 'Benzin', 'Manuális', 1600, 'Ferdehátú', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(11, 'Audi', 'A5', 'Az Audi A5 2.0 TFSI az Audi elegáns, sportos kupéja. A 2.0 TFSI turbós benzinmotor jó teljesítményt és kulturált járást kínál, miközben az autó prémium belsővel és kényelmes utazással tűnik ki.', 'Szürke', '2009', 200000, 'Benzin', 'Manuális', 2000, 'Coupe', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(12, 'BMW', 'E36', 'A BMW 318tds E36 a BMW 90-es évekbeli 3-as sorozatának takarékos dízel változata. Klasszikus hátsókerék-hajtása miatt így is megmarad a BMW-re jellemző stabil vezethetőség.', 'Szürke', '2000', 200000, 'Dízel', 'Manuális', 1700, 'Sedán', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(13, 'Volkswagen', 'Golf 6', 'A Volkswagen Golf Mk6 1.2 TSI a Volkswagen egyik takarékos kompakt modellje. Az 1.2 TSI turbós benzinmotor kis fogyasztás mellett meglepően élénk, így ideális városi és mindennapi használatra.', 'Kék', '2012', 210000, 'Benzin', 'Manuális', 1200, 'Ferdehátú', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(14, 'Mitsubishi', 'Lancer', 'A Mitsubishi Lancer 1.8 a Mitsubishi Motors megbízható kompakt modellje. Az 1.8-as benzinmotor egyszerű, tartós és mindennapi használatra ideális, miközben a Lancer stabil futóműve kellemes vezethetőséget biztosít.', 'Piros', '2013', 210000, 'Benzin', 'Automata', 1800, 'Sedán', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(15, 'Volkswagen', 'Golf 6', 'A Volkswagen Golf Mk6 1.4 TSI 160 a Volkswagen erősebb kompakt változata. Az 1.4 TSI motor (kompresszor + turbó) 160 lóerőt ad, így kifejezetten dinamikus, miközben megmarad a Golf kényelme és mindennapi használhatósága.', 'Fekete', '2011', 180000, 'Benzin', 'Manuális', 1400, 'Ferdehátú', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(16, 'Volkswagen', 'Golf 6 GTD', 'A Volkswagen Golf Mk6 GTD a Volkswagen sportos dízel változata. A 2.0 TDI motor erős nyomatékot és alacsony fogyasztást kínál, így dinamikus, mégis gazdaságos mindennapi használatra.', 'Fehér', '2013', 180000, 'Dízel', 'Manuális', 2000, 'Ferdehátú', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(17, 'Volkswagen', 'Golf 6', 'Megkímélt, jó állapotú Volkswagen Golf 6 eladó, rendszeresen karbantartott, megbízható és kényelmes autó, amely napi használatra és hosszabb utakra is tökéletes választás.', 'Fehér', '2012', 128000, 'Benzin', 'Manuális', 1195, 'Ferdehátú', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(18, 'BMW', 'E93', 'Arany berakásos belső ezért drágább, jó állapotban van, rendszeresen karbantartott.', 'Szürke', '2012', 128000, 'Dízel', 'Manuális', 3000, 'Cabrio', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(19, 'Volkswagen', 'Golf 3', 'Alig használt serülésmentes, kölcségmentes én javítottam, gyári fényezés. Full extrás (tetőablak), nagy zene, vontató kötél, koppanás mentes futómű, női tulaj nem dohányzó. Ebben érzed a G-ket. Alku NINCS. Teszt pilóták kíméljenek!', 'Kék', '1997', 523000, 'Dízel', 'Manuális', 1900, 'Ferdehátú', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(20, 'Seat', 'Leon', '1.9 TDI a legendás motor. Napi használatban van. Turbó fix nyomáson megy, állandó SPORT MÓD.', 'Szürke', '2001', 270000, 'Dízel', 'Manuális', 1900, 'Ferdehátú', '2026-04-28 18:01:48', '2026-04-28 18:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `listing_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `listing_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `car_id` bigint UNSIGNED NOT NULL,
  `price` int NOT NULL,
  `horsepower` int UNSIGNED DEFAULT NULL,
  `status` enum('pending','active','sold','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`id`, `user_id`, `car_id`, `price`, `horsepower`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1326767, 104, 'active', '2026-04-28 18:01:42', '2026-04-28 18:01:42'),
(2, 1, 2, 6767670, 204, 'active', '2026-04-28 18:01:42', '2026-04-28 18:01:42'),
(3, 1, 3, 6700000, 150, 'active', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(4, 1, 4, 4200000, 105, 'active', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(5, 1, 5, 2670000, 185, 'active', '2026-04-28 18:01:43', '2026-04-28 18:01:43'),
(6, 1, 6, 2670067, 200, 'active', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(7, 1, 7, 5555555, 210, 'active', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(8, 1, 8, 6969690, 184, 'active', '2026-04-28 18:01:44', '2026-04-28 18:01:44'),
(9, 1, 9, 4131313, 150, 'active', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(10, 1, 10, 3131313, 105, 'active', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(11, 1, 11, 13000000, 200, 'active', '2026-04-28 18:01:45', '2026-04-28 18:01:45'),
(12, 1, 12, 2130000, 90, 'active', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(13, 1, 13, 2000000, 105, 'active', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(14, 1, 14, 3333333, 145, 'active', '2026-04-28 18:01:46', '2026-04-28 18:01:46'),
(15, 1, 15, 3000000, 160, 'active', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(16, 1, 16, 3500000, 170, 'active', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(17, 1, 17, 4200000, 105, 'active', '2026-04-28 18:01:47', '2026-04-28 18:01:47'),
(18, 1, 18, 67000000, 267, 'active', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(19, 1, 19, 670000, 67, 'active', '2026-04-28 18:01:48', '2026-04-28 18:01:48'),
(20, 1, 20, 767000, 110, 'active', '2026-04-28 18:01:48', '2026-04-28 18:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_19_092948_create_personal_access_tokens_table', 1),
(5, '2026_04_21_110343_create_cars_table', 1),
(6, '2026_04_21_111603_create_carimages_table', 1),
(7, '2026_04_21_120000_create_listings_table', 1),
(8, '2026_04_21_130000_create_favourites_table', 1),
(9, '2026_04_22_160702_create_interests_table', 1),
(10, '2026_04_26_000000_add_role_to_users_table', 1),
(11, '2026_04_26_213500_add_horsepower_to_listings_table', 1),
(12, '2026_04_27_130000_add_pending_status_to_listings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', NULL, '$2y$12$uqD9QpQqdPcHolUO1PPfAeQ2VB8thuKcgMGAFY7KpIPv9ppT/jRRa', '+36201234567', 'user', NULL, '2026-04-28 18:01:41', '2026-04-28 18:01:41'),
(2, 'Admin User', 'admin@example.com', NULL, '$2y$12$EfcoyyMipWVXlO6XaacBlOdvOXO5ft2NsM/112FE9X7T4y/BMh3Ve', '+36209999999', 'admin', NULL, '2026-04-28 18:01:42', '2026-04-28 18:01:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carimages`
--
ALTER TABLE `carimages`
  ADD PRIMARY KEY (`car_imageid`),
  ADD KEY `carimages_car_id_foreign` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favourites_user_id_listing_id_unique` (`user_id`,`listing_id`),
  ADD KEY `favourites_listing_id_foreign` (`listing_id`);

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interests_sender_id_foreign` (`sender_id`),
  ADD KEY `interests_receiver_id_foreign` (`receiver_id`),
  ADD KEY `interests_listing_id_foreign` (`listing_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listings_user_id_foreign` (`user_id`),
  ADD KEY `listings_car_id_foreign` (`car_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carimages`
--
ALTER TABLE `carimages`
  MODIFY `car_imageid` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carimages`
--
ALTER TABLE `carimages`
  ADD CONSTRAINT `carimages_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`),
  ADD CONSTRAINT `favourites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `interests`
--
ALTER TABLE `interests`
  ADD CONSTRAINT `interests_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interests_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interests_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `listings_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `listings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
