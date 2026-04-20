-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 20, 2026 at 01:55 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pinjamalat`
--

-- --------------------------------------------------------

--
-- Table structure for table `alats`
--

CREATE TABLE `alats` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_alat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `status` enum('tersedia','dipinjam') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alats`
--

INSERT INTO `alats` (`id`, `kode_alat`, `nama`, `kategori_id`, `stok`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ALT-0001', 'Laptop Asus 1', 5, 0, 'dipinjam', '2026-04-14 07:57:05', '2026-04-20 02:45:56'),
(2, 'ALT-0002', 'Laptop Asus 2', 5, 0, 'dipinjam', '2026-04-14 07:57:05', '2026-04-16 13:20:59'),
(3, 'ALT-0003', 'Laptop Asus 3', 5, 0, 'dipinjam', '2026-04-14 07:57:05', '2026-04-16 13:20:20'),
(4, 'ALT-0004', 'Laptop Asus 4', 5, 1, 'tersedia', '2026-04-14 07:57:05', '2026-04-14 07:57:05'),
(5, 'ALT-0005', 'Laptop Asus 5', 5, 1, 'tersedia', '2026-04-14 07:57:05', '2026-04-14 07:57:05'),
(6, 'ALT-0006', 'Palu', 1, 1, 'tersedia', '2026-04-14 08:04:07', '2026-04-14 08:04:07'),
(7, 'ALT-0007', 'Palu 1', 1, 1, 'tersedia', '2026-04-14 08:04:43', '2026-04-14 08:04:43'),
(8, 'ALT-0008', 'Palu 2', 1, 1, 'tersedia', '2026-04-14 08:04:43', '2026-04-14 08:04:43');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@system.test|127.0.0.1', 'i:1;', 1774790976),
('laravel-cache-admin@system.test|127.0.0.1:timer', 'i:1774790976;', 1774790976),
('laravel-cache-admin@test.mail|127.0.0.1', 'i:1;', 1770117971),
('laravel-cache-admin@test.mail|127.0.0.1:timer', 'i:1770117971;', 1770117971),
('laravel-cache-dada@gmail.com|127.0.0.1', 'i:1;', 1770117752),
('laravel-cache-dada@gmail.com|127.0.0.1:timer', 'i:1770117752;', 1770117752),
('laravel-cache-petugas@gmail.com|127.0.0.1', 'i:1;', 1776151412),
('laravel-cache-petugas@gmail.com|127.0.0.1:timer', 'i:1776151412;', 1776151412),
('laravel-cache-petugas@system.com|127.0.0.1', 'i:1;', 1770683394),
('laravel-cache-petugas@system.com|127.0.0.1:timer', 'i:1770683394;', 1770683394);

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
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Peralatan Umum', '2026-02-05 20:05:22', '2026-02-08 23:58:31'),
(2, 'Media & Presentasi', '2026-02-05 20:07:41', '2026-02-08 23:58:05'),
(5, 'Elektronik', '2026-02-05 20:07:52', '2026-02-10 04:25:12');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `user_id`, `deskripsi`, `role`, `created_at`, `updated_at`) VALUES
(1, 2, 'Logout dari sistem', 'petugas', '2026-02-09 21:15:05', '2026-02-09 21:15:05'),
(2, 2, 'Login ke sistem', 'petugas', '2026-02-10 04:17:58', '2026-02-10 04:17:58'),
(3, 1, 'Mengubah alat \'Keyboardd\'', 'admin', '2026-02-10 04:23:23', '2026-02-10 04:23:23'),
(4, 1, 'Menambahkan alat \'Handphone\'', 'admin', '2026-02-10 04:23:56', '2026-02-10 04:23:56'),
(5, 1, 'Mengubah kategori \'Elektronikk\'', 'admin', '2026-02-10 04:25:01', '2026-02-10 04:25:01'),
(6, 1, 'Mengubah kategori \'Elektronik\'', 'admin', '2026-02-10 04:25:12', '2026-02-10 04:25:12'),
(7, 2, 'Memproses pengembalian peminjaman ID #9 oleh Ibnu', 'petugas', '2026-02-10 04:29:00', '2026-02-10 04:29:00'),
(8, 2, 'Menyetujui peminjaman ID #11 oleh Ibnu', 'petugas', '2026-02-10 04:34:18', '2026-02-10 04:34:18'),
(9, 2, 'Memproses pengembalian peminjaman ID #11 oleh Ibnu', 'petugas', '2026-02-10 04:34:57', '2026-02-10 04:34:57'),
(10, 8, 'Mengajukan peminjaman alat \'Laptop Asus\' sebanyak 1 unit (ID Peminjaman #13)', 'peminjam', '2026-02-10 04:40:50', '2026-02-10 04:40:50'),
(11, 2, 'Menolak peminjaman alat \'Laptop Asus\' oleh Ibnu (ID Peminjaman #13)', 'petugas', '2026-02-10 04:42:46', '2026-02-10 04:42:46'),
(12, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-10 05:21:35', '2026-02-10 05:21:35'),
(13, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-10 06:42:38', '2026-02-10 06:42:38'),
(14, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-10 06:42:45', '2026-02-10 06:42:45'),
(15, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-10 06:43:03', '2026-02-10 06:43:03'),
(16, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-10 06:43:09', '2026-02-10 06:43:09'),
(17, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-10 06:44:08', '2026-02-10 06:44:08'),
(18, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-10 06:45:35', '2026-02-10 06:45:35'),
(19, 1, 'Login ke sistem', 'admin', '2026-02-10 11:03:23', '2026-02-10 11:03:23'),
(20, 1, 'Logout dari sistem', 'admin', '2026-02-10 11:15:22', '2026-02-10 11:15:22'),
(21, 2, 'Login ke sistem', 'petugas', '2026-02-10 11:15:33', '2026-02-10 11:15:33'),
(22, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-10 11:19:48', '2026-02-10 11:19:48'),
(23, 1, 'Login ke sistem', 'admin', '2026-02-10 11:22:33', '2026-02-10 11:22:33'),
(24, 8, 'Login ke sistem', 'peminjam', '2026-02-10 11:23:29', '2026-02-10 11:23:29'),
(25, 8, 'Login ke sistem', 'peminjam', '2026-02-10 13:48:36', '2026-02-10 13:48:36'),
(26, 8, 'Login ke sistem', 'peminjam', '2026-02-10 14:36:31', '2026-02-10 14:36:31'),
(27, 8, 'Mengajukan peminjaman alat \'Laptop Asus\' sebanyak 1 unit (ID Peminjaman #14)', 'peminjam', '2026-02-10 14:36:58', '2026-02-10 14:36:58'),
(28, 8, 'Logout dari sistem', 'peminjam', '2026-02-10 14:37:06', '2026-02-10 14:37:06'),
(29, 2, 'Login ke sistem', 'petugas', '2026-02-10 14:37:22', '2026-02-10 14:37:22'),
(30, 2, 'Menyetujui peminjaman alat \'Laptop Asus\' oleh Ibnu (ID Peminjaman #14)', 'petugas', '2026-02-10 14:37:36', '2026-02-10 14:37:36'),
(31, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-10 14:37:37', '2026-02-10 14:37:37'),
(32, 2, 'Mencetak laporan peminjaman dari 2026-02-10 sampai 2026-02-10', 'petugas', '2026-02-10 14:37:47', '2026-02-10 14:37:47'),
(33, 1, 'Login ke sistem', 'admin', '2026-02-10 14:39:02', '2026-02-10 14:39:02'),
(34, 1, 'Menambahkan alat \'Obeng\'', 'admin', '2026-02-10 14:39:37', '2026-02-10 14:39:37'),
(35, 1, 'Mengubah alat \'Keyboard\'', 'admin', '2026-02-10 14:40:26', '2026-02-10 14:40:26'),
(36, 1, 'Logout dari sistem', 'admin', '2026-02-10 14:41:43', '2026-02-10 14:41:43'),
(37, 1, 'Login ke sistem', 'admin', '2026-02-10 14:48:01', '2026-02-10 14:48:01'),
(38, 8, 'Logout dari sistem', 'peminjam', '2026-02-10 15:03:49', '2026-02-10 15:03:49'),
(39, 1, 'Login ke sistem', 'admin', '2026-02-11 00:42:11', '2026-02-11 00:42:11'),
(40, 1, 'Logout dari sistem', 'admin', '2026-02-11 00:44:57', '2026-02-11 00:44:57'),
(41, 2, 'Login ke sistem', 'petugas', '2026-02-11 00:45:32', '2026-02-11 00:45:32'),
(42, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-11 00:46:23', '2026-02-11 00:46:23'),
(43, 2, 'Logout dari sistem', 'petugas', '2026-02-11 00:46:27', '2026-02-11 00:46:27'),
(44, 2, 'Login ke sistem', 'petugas', '2026-02-11 01:11:06', '2026-02-11 01:11:06'),
(45, 2, 'Logout dari sistem', 'petugas', '2026-02-11 01:11:17', '2026-02-11 01:11:17'),
(46, 1, 'Login ke sistem', 'admin', '2026-02-11 01:11:27', '2026-02-11 01:11:27'),
(47, 1, 'Logout dari sistem', 'admin', '2026-02-11 01:11:30', '2026-02-11 01:11:30'),
(48, 1, 'Login ke sistem', 'admin', '2026-02-11 02:03:14', '2026-02-11 02:03:14'),
(49, 1, 'Logout dari sistem', 'admin', '2026-02-11 02:07:31', '2026-02-11 02:07:31'),
(50, 2, 'Login ke sistem', 'petugas', '2026-02-11 02:07:52', '2026-02-11 02:07:52'),
(51, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-11 02:08:18', '2026-02-11 02:08:18'),
(52, 2, 'Logout dari sistem', 'petugas', '2026-02-11 02:08:55', '2026-02-11 02:08:55'),
(53, 8, 'Login ke sistem', 'peminjam', '2026-02-11 02:09:55', '2026-02-11 02:09:55'),
(54, 1, 'Login ke sistem', 'admin', '2026-02-11 03:38:28', '2026-02-11 03:38:28'),
(55, 1, 'Login ke sistem', 'admin', '2026-02-11 04:44:04', '2026-02-11 04:44:04'),
(56, 1, 'Login ke sistem', 'admin', '2026-02-11 14:21:00', '2026-02-11 14:21:00'),
(57, 1, 'Logout dari sistem', 'admin', '2026-02-11 14:22:29', '2026-02-11 14:22:29'),
(58, 2, 'Login ke sistem', 'petugas', '2026-02-11 14:22:37', '2026-02-11 14:22:37'),
(59, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-11 14:25:58', '2026-02-11 14:25:58'),
(60, 2, 'Logout dari sistem', 'petugas', '2026-02-11 14:28:49', '2026-02-11 14:28:49'),
(61, 8, 'Login ke sistem', 'peminjam', '2026-02-11 14:29:05', '2026-02-11 14:29:05'),
(62, 8, 'Logout dari sistem', 'peminjam', '2026-02-11 14:31:42', '2026-02-11 14:31:42'),
(63, 1, 'Login ke sistem', 'admin', '2026-02-11 14:31:52', '2026-02-11 14:31:52'),
(64, 1, 'Logout dari sistem', 'admin', '2026-02-11 14:42:24', '2026-02-11 14:42:24'),
(65, 2, 'Login ke sistem', 'petugas', '2026-02-11 14:42:33', '2026-02-11 14:42:33'),
(66, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-11 14:46:39', '2026-02-11 14:46:39'),
(67, 2, 'Logout dari sistem', 'petugas', '2026-02-11 14:47:44', '2026-02-11 14:47:44'),
(68, 8, 'Login ke sistem', 'peminjam', '2026-02-11 14:47:55', '2026-02-11 14:47:55'),
(69, 1, 'Login ke sistem', 'admin', '2026-02-12 01:13:18', '2026-02-12 01:13:18'),
(70, 2, 'Login ke sistem', 'petugas', '2026-02-12 01:13:33', '2026-02-12 01:13:33'),
(71, 8, 'Login ke sistem', 'peminjam', '2026-02-12 01:13:49', '2026-02-12 01:13:49'),
(72, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-12 02:00:28', '2026-02-12 02:00:28'),
(73, 2, 'Mencetak laporan peminjaman dari 2026-02-12 sampai 2026-02-13', 'petugas', '2026-02-12 02:00:37', '2026-02-12 02:00:37'),
(74, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-12 02:30:50', '2026-02-12 02:30:50'),
(75, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-12 02:33:05', '2026-02-12 02:33:05'),
(76, 8, 'Logout dari sistem', 'peminjam', '2026-02-12 02:33:19', '2026-02-12 02:33:19'),
(77, 8, 'Login ke sistem', 'peminjam', '2026-02-12 02:34:36', '2026-02-12 02:34:36'),
(78, 8, 'Logout dari sistem', 'peminjam', '2026-02-12 02:35:13', '2026-02-12 02:35:13'),
(79, 8, 'Login ke sistem', 'peminjam', '2026-02-12 02:35:22', '2026-02-12 02:35:22'),
(80, 1, 'Logout dari sistem', 'admin', '2026-02-12 03:13:12', '2026-02-12 03:13:12'),
(81, 1, 'Login ke sistem', 'admin', '2026-02-12 03:14:35', '2026-02-12 03:14:35'),
(82, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-12 03:16:45', '2026-02-12 03:16:45'),
(83, 1, 'Login ke sistem', 'admin', '2026-02-12 13:45:26', '2026-02-12 13:45:26'),
(84, 1, 'Logout dari sistem', 'admin', '2026-02-12 13:55:15', '2026-02-12 13:55:15'),
(85, 2, 'Login ke sistem', 'petugas', '2026-02-12 13:55:36', '2026-02-12 13:55:36'),
(86, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-12 13:56:25', '2026-02-12 13:56:25'),
(87, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-02-12 13:57:06', '2026-02-12 13:57:06'),
(88, 2, 'Logout dari sistem', 'petugas', '2026-02-12 14:00:49', '2026-02-12 14:00:49'),
(89, 8, 'Login ke sistem', 'peminjam', '2026-02-12 14:01:40', '2026-02-12 14:01:40'),
(90, 1, 'Login ke sistem', 'admin', '2026-03-25 09:25:43', '2026-03-25 09:25:43'),
(91, 1, 'Login ke sistem', 'admin', '2026-03-29 13:29:55', '2026-03-29 13:29:55'),
(92, 1, 'Logout dari sistem', 'admin', '2026-03-29 13:37:07', '2026-03-29 13:37:07'),
(93, 9, 'Login ke sistem', 'peminjam', '2026-03-29 13:37:45', '2026-03-29 13:37:45'),
(94, 9, 'Mengajukan peminjaman alat \'Laptop Asus\' sebanyak 1 unit (ID Peminjaman #15)', 'peminjam', '2026-03-29 13:38:45', '2026-03-29 13:38:45'),
(95, 9, 'Memproses pengembalian alat \'Laptop Asus\' dari Ibnu (ID Peminjaman #14)', 'peminjam', '2026-03-29 13:39:19', '2026-03-29 13:39:19'),
(96, 9, 'Menyetujui peminjaman alat \'Laptop Asus\' oleh Ibnu (ID Peminjaman #15)', 'peminjam', '2026-03-29 13:39:24', '2026-03-29 13:39:24'),
(97, 9, 'Mengajukan pengembalian alat \'Laptop Asus\' sebanyak 1 unit (ID Peminjaman #15)', 'peminjam', '2026-03-29 13:39:33', '2026-03-29 13:39:33'),
(98, 9, 'Memproses pengembalian alat \'Laptop Asus\' dari Ibnu (ID Peminjaman #15)', 'peminjam', '2026-03-29 13:39:43', '2026-03-29 13:39:43'),
(99, 1, 'Login ke sistem', 'admin', '2026-04-05 14:05:31', '2026-04-05 14:05:31'),
(100, 1, 'Logout dari sistem', 'admin', '2026-04-05 14:05:43', '2026-04-05 14:05:43'),
(101, 10, 'Login ke sistem', 'peminjam', '2026-04-07 01:03:23', '2026-04-07 01:03:23'),
(102, 10, 'Logout dari sistem', 'peminjam', '2026-04-07 01:45:52', '2026-04-07 01:45:52'),
(103, 1, 'Login ke sistem', 'admin', '2026-04-07 01:46:11', '2026-04-07 01:46:11'),
(104, 1, 'Logout dari sistem', 'admin', '2026-04-07 01:47:53', '2026-04-07 01:47:53'),
(105, 2, 'Login ke sistem', 'petugas', '2026-04-07 01:48:24', '2026-04-07 01:48:24'),
(106, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 01:48:30', '2026-04-07 01:48:30'),
(107, 1, 'Login ke sistem', 'admin', '2026-04-07 01:50:07', '2026-04-07 01:50:07'),
(108, 10, 'Login ke sistem', 'peminjam', '2026-04-07 01:50:25', '2026-04-07 01:50:25'),
(109, 1, 'Logout dari sistem', 'admin', '2026-04-07 01:54:05', '2026-04-07 01:54:05'),
(110, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 01:54:26', '2026-04-07 01:54:26'),
(111, 2, 'Mencetak laporan peminjaman dari 2026-02-01 sampai 2026-03-01', 'petugas', '2026-04-07 01:54:49', '2026-04-07 01:54:49'),
(112, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 01:55:43', '2026-04-07 01:55:43'),
(113, 10, 'Mengajukan peminjaman alat \'Laptop Asus\' sebanyak 1 unit (ID Peminjaman #16)', 'peminjam', '2026-04-07 01:58:30', '2026-04-07 01:58:30'),
(114, 2, 'Menyetujui peminjaman alat \'Laptop Asus\' oleh siswa 1 (ID Peminjaman #16)', 'petugas', '2026-04-07 01:59:18', '2026-04-07 01:59:18'),
(115, 10, 'Mengajukan peminjaman alat \'Laptop Asus\' sebanyak 1 unit (ID Peminjaman #17)', 'peminjam', '2026-04-07 02:01:21', '2026-04-07 02:01:21'),
(116, 2, 'Menyetujui peminjaman alat \'Laptop Asus\' oleh siswa 1 (ID Peminjaman #17)', 'petugas', '2026-04-07 02:01:36', '2026-04-07 02:01:36'),
(117, 10, 'Mengajukan pengembalian alat \'Laptop Asus\' sebanyak 1 unit (ID Peminjaman #17)', 'peminjam', '2026-04-07 02:02:11', '2026-04-07 02:02:11'),
(118, 2, 'Memproses pengembalian alat \'Laptop Asus\' dari siswa 1 (ID Peminjaman #17)', 'petugas', '2026-04-07 02:02:24', '2026-04-07 02:02:24'),
(119, 2, 'Login ke sistem', 'petugas', '2026-04-07 23:31:48', '2026-04-07 23:31:48'),
(120, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:31:57', '2026-04-07 23:31:57'),
(121, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:32:01', '2026-04-07 23:32:01'),
(122, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:32:08', '2026-04-07 23:32:08'),
(123, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:35:07', '2026-04-07 23:35:07'),
(124, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:35:21', '2026-04-07 23:35:21'),
(125, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:35:23', '2026-04-07 23:35:23'),
(126, 2, 'Melihat laporan dengan filter', 'petugas', '2026-04-07 23:38:06', '2026-04-07 23:38:06'),
(127, 2, 'Melihat laporan dengan filter', 'petugas', '2026-04-07 23:38:14', '2026-04-07 23:38:14'),
(128, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:40:53', '2026-04-07 23:40:53'),
(129, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:41:07', '2026-04-07 23:41:07'),
(130, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:41:24', '2026-04-07 23:41:24'),
(131, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:41:27', '2026-04-07 23:41:27'),
(132, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:42:46', '2026-04-07 23:42:46'),
(133, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:43:36', '2026-04-07 23:43:36'),
(134, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:43:47', '2026-04-07 23:43:47'),
(135, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:44:40', '2026-04-07 23:44:40'),
(136, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:44:41', '2026-04-07 23:44:41'),
(137, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:44:46', '2026-04-07 23:44:46'),
(138, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:44:57', '2026-04-07 23:44:57'),
(139, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:45:01', '2026-04-07 23:45:01'),
(140, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:45:04', '2026-04-07 23:45:04'),
(141, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:45:55', '2026-04-07 23:45:55'),
(142, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:46:13', '2026-04-07 23:46:13'),
(143, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:46:25', '2026-04-07 23:46:25'),
(144, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:47:47', '2026-04-07 23:47:47'),
(145, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:47:54', '2026-04-07 23:47:54'),
(146, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:48:00', '2026-04-07 23:48:00'),
(147, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:48:01', '2026-04-07 23:48:01'),
(148, 2, 'Melihat daftar laporan peminjaman', 'petugas', '2026-04-07 23:48:07', '2026-04-07 23:48:07'),
(149, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-07 23:51:52', '2026-04-07 23:51:52'),
(150, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:07:27', '2026-04-08 00:07:27'),
(151, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:07:34', '2026-04-08 00:07:34'),
(152, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:07:43', '2026-04-08 00:07:43'),
(153, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:07:46', '2026-04-08 00:07:46'),
(154, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:07:48', '2026-04-08 00:07:48'),
(155, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:07:51', '2026-04-08 00:07:51'),
(156, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:07:53', '2026-04-08 00:07:53'),
(157, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:09:32', '2026-04-08 00:09:32'),
(158, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:09:34', '2026-04-08 00:09:34'),
(159, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:09:38', '2026-04-08 00:09:38'),
(160, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:14:16', '2026-04-08 00:14:16'),
(161, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:14:17', '2026-04-08 00:14:17'),
(162, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:14:31', '2026-04-08 00:14:31'),
(163, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:14:51', '2026-04-08 00:14:51'),
(164, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-08 00:15:16', '2026-04-08 00:15:16'),
(165, 2, 'Cetak laporan | Dari: 2026-02-02 - 2026-04-08 | Search:  | Status: ', 'petugas', '2026-04-08 00:15:18', '2026-04-08 00:15:18'),
(166, 2, 'Login ke sistem', 'petugas', '2026-04-10 05:36:25', '2026-04-10 05:36:25'),
(167, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:43:37', '2026-04-10 05:43:37'),
(168, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:43:46', '2026-04-10 05:43:46'),
(169, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:43:55', '2026-04-10 05:43:55'),
(170, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:48:05', '2026-04-10 05:48:05'),
(171, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:48:10', '2026-04-10 05:48:10'),
(172, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:48:35', '2026-04-10 05:48:35'),
(173, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:48:36', '2026-04-10 05:48:36'),
(174, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:48:36', '2026-04-10 05:48:36'),
(175, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:49:30', '2026-04-10 05:49:30'),
(176, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:49:32', '2026-04-10 05:49:32'),
(177, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:49:56', '2026-04-10 05:49:56'),
(178, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:10', '2026-04-10 05:50:10'),
(179, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:11', '2026-04-10 05:50:11'),
(180, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:13', '2026-04-10 05:50:13'),
(181, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:14', '2026-04-10 05:50:14'),
(182, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:16', '2026-04-10 05:50:16'),
(183, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:17', '2026-04-10 05:50:17'),
(184, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:17', '2026-04-10 05:50:17'),
(185, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:26', '2026-04-10 05:50:26'),
(186, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:31', '2026-04-10 05:50:31'),
(187, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:32', '2026-04-10 05:50:32'),
(188, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-10 05:50:38', '2026-04-10 05:50:38'),
(189, 2, 'Cetak laporan | Dari: 2026-02-11 - 2026-04-10 | Search:  | Status: ', 'petugas', '2026-04-10 05:50:40', '2026-04-10 05:50:40'),
(190, 2, 'Login ke sistem', 'petugas', '2026-04-11 13:41:33', '2026-04-11 13:41:33'),
(191, 2, 'Memproses pengembalian alat \'Laptop Asus\' dari siswa 1 (ID Peminjaman #16)', 'petugas', '2026-04-11 13:41:48', '2026-04-11 13:41:48'),
(192, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:41:51', '2026-04-11 13:41:51'),
(193, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:43:49', '2026-04-11 13:43:49'),
(194, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:43:53', '2026-04-11 13:43:53'),
(195, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:43:57', '2026-04-11 13:43:57'),
(196, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:44:01', '2026-04-11 13:44:01'),
(197, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:44:19', '2026-04-11 13:44:19'),
(198, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:44:21', '2026-04-11 13:44:21'),
(199, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:44:27', '2026-04-11 13:44:27'),
(200, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:44:36', '2026-04-11 13:44:36'),
(201, 2, 'Cetak laporan | Dari: 2026-04-01 - 2026-04-11 | Search:  | Status: ', 'petugas', '2026-04-11 13:44:44', '2026-04-11 13:44:44'),
(202, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:47:13', '2026-04-11 13:47:13'),
(203, 2, 'Cetak laporan | Dari: 2026-04-01 - 2026-04-11 | Search:  | Status: ', 'petugas', '2026-04-11 13:47:16', '2026-04-11 13:47:16'),
(204, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:48:25', '2026-04-11 13:48:25'),
(205, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:48:32', '2026-04-11 13:48:32'),
(206, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:48:40', '2026-04-11 13:48:40'),
(207, 2, 'Cetak laporan | Dari: 2026-02-01 - 2026-04-11 | Search:  | Status: ', 'petugas', '2026-04-11 13:48:41', '2026-04-11 13:48:41'),
(208, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-11 13:48:55', '2026-04-11 13:48:55'),
(209, 2, 'Cetak laporan | Dari: 2026-01-01 - 2026-04-11 | Search:  | Status: ', 'petugas', '2026-04-11 13:48:56', '2026-04-11 13:48:56'),
(210, 2, 'Login ke sistem', 'petugas', '2026-04-13 07:20:58', '2026-04-13 07:20:58'),
(211, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-13 07:21:06', '2026-04-13 07:21:06'),
(212, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-13 07:21:21', '2026-04-13 07:21:21'),
(213, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-13 07:21:34', '2026-04-13 07:21:34'),
(214, 2, 'Cetak laporan | Dari: 2026-02-01 - 2026-04-13 | Search:  | Status: ', 'petugas', '2026-04-13 07:21:37', '2026-04-13 07:21:37'),
(215, 2, 'Cetak laporan | Dari: 2026-02-01 - 2026-04-13 | Search:  | Status: ', 'petugas', '2026-04-13 07:24:34', '2026-04-13 07:24:34'),
(216, 2, 'Login ke sistem', 'petugas', '2026-04-14 06:06:52', '2026-04-14 06:06:52'),
(217, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:08:20', '2026-04-14 06:08:20'),
(218, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:09:34', '2026-04-14 06:09:34'),
(219, 2, 'Login ke sistem', 'petugas', '2026-04-14 06:51:23', '2026-04-14 06:51:23'),
(220, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:52:23', '2026-04-14 06:52:23'),
(221, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:52:30', '2026-04-14 06:52:30'),
(222, 2, 'Login ke sistem', 'petugas', '2026-04-14 06:52:50', '2026-04-14 06:52:50'),
(223, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:52:55', '2026-04-14 06:52:55'),
(224, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:53:12', '2026-04-14 06:53:12'),
(225, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:53:18', '2026-04-14 06:53:18'),
(226, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:53:22', '2026-04-14 06:53:22'),
(227, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:53:26', '2026-04-14 06:53:26'),
(228, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:53:43', '2026-04-14 06:53:43'),
(229, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:53:49', '2026-04-14 06:53:49'),
(230, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:54:18', '2026-04-14 06:54:18'),
(231, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 06:54:23', '2026-04-14 06:54:23'),
(232, 1, 'Login ke sistem', 'admin', '2026-04-14 06:55:18', '2026-04-14 06:55:18'),
(233, 1, 'Menambahkan alat \'Laptop Thinkpas\'', 'admin', '2026-04-14 06:56:08', '2026-04-14 06:56:08'),
(234, 2, 'Logout dari sistem', 'petugas', '2026-04-14 06:56:45', '2026-04-14 06:56:45'),
(235, 1, 'Login ke sistem', 'admin', '2026-04-14 06:57:00', '2026-04-14 06:57:00'),
(236, 1, 'Logout dari sistem', 'admin', '2026-04-14 07:04:03', '2026-04-14 07:04:03'),
(237, 2, 'Login ke sistem', 'petugas', '2026-04-14 07:04:20', '2026-04-14 07:04:20'),
(238, 2, 'Logout dari sistem', 'petugas', '2026-04-14 07:04:42', '2026-04-14 07:04:42'),
(239, 10, 'Login ke sistem', 'peminjam', '2026-04-14 07:04:55', '2026-04-14 07:04:55'),
(240, 10, 'Mengajukan peminjaman alat \'Laptop Thinkpas\' sebanyak 1 unit (ID Peminjaman #18)', 'peminjam', '2026-04-14 07:05:11', '2026-04-14 07:05:11'),
(241, 10, 'Logout dari sistem', 'peminjam', '2026-04-14 07:05:18', '2026-04-14 07:05:18'),
(242, 1, 'Logout dari sistem', 'admin', '2026-04-14 07:05:27', '2026-04-14 07:05:27'),
(243, 2, 'Login ke sistem', 'petugas', '2026-04-14 07:06:03', '2026-04-14 07:06:03'),
(244, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 07:07:52', '2026-04-14 07:07:52'),
(245, 2, 'Login ke sistem', 'petugas', '2026-04-14 07:08:48', '2026-04-14 07:08:48'),
(246, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 07:14:17', '2026-04-14 07:14:17'),
(247, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-14 07:15:15', '2026-04-14 07:15:15'),
(248, 2, 'Login ke sistem', 'petugas', '2026-04-14 07:23:24', '2026-04-14 07:23:24'),
(249, 2, 'Menyetujui peminjaman alat \'Laptop Thinkpas\' oleh siswa 1 (ID Peminjaman #18)', 'petugas', '2026-04-14 07:36:53', '2026-04-14 07:36:53'),
(250, 2, 'Memproses pengembalian alat \'Laptop Thinkpas\' dari siswa 1 (ID Peminjaman #18)', 'petugas', '2026-04-14 07:42:42', '2026-04-14 07:42:42'),
(251, 2, 'Logout dari sistem', 'petugas', '2026-04-14 07:51:29', '2026-04-14 07:51:29'),
(252, 2, 'Logout dari sistem', 'petugas', '2026-04-14 07:51:53', '2026-04-14 07:51:53'),
(253, 1, 'Login ke sistem', 'admin', '2026-04-14 07:52:25', '2026-04-14 07:52:25'),
(254, 1, 'Menambahkan massal alat \'Laptop Asus\' sebanyak 5 unit', 'admin', '2026-04-14 07:57:05', '2026-04-14 07:57:05'),
(255, 1, 'Menambahkan massal alat \'Palu\' sebanyak 1 unit', 'admin', '2026-04-14 08:04:07', '2026-04-14 08:04:07'),
(256, 1, 'Menambahkan massal alat \'Palu\' sebanyak 2 unit', 'admin', '2026-04-14 08:04:43', '2026-04-14 08:04:43'),
(257, 2, 'Logout dari sistem', 'petugas', '2026-04-14 08:06:21', '2026-04-14 08:06:21'),
(258, 10, 'Login ke sistem', 'peminjam', '2026-04-14 08:06:55', '2026-04-14 08:06:55'),
(259, 10, 'Logout dari sistem', 'peminjam', '2026-04-14 08:10:19', '2026-04-14 08:10:19'),
(260, 1, 'Login ke sistem', 'admin', '2026-04-14 08:11:43', '2026-04-14 08:11:43'),
(261, 1, 'Logout dari sistem', 'admin', '2026-04-14 08:12:32', '2026-04-14 08:12:32'),
(262, 10, 'Login ke sistem', 'peminjam', '2026-04-14 08:12:44', '2026-04-14 08:12:44'),
(263, 10, 'Mengajukan peminjaman alat \'Laptop Asus 1\' sebanyak 1 unit (ID Peminjaman #1)', 'peminjam', '2026-04-14 08:19:48', '2026-04-14 08:19:48'),
(264, 1, 'Logout dari sistem', 'admin', '2026-04-14 08:20:09', '2026-04-14 08:20:09'),
(265, 2, 'Login ke sistem', 'petugas', '2026-04-14 08:21:25', '2026-04-14 08:21:25'),
(266, 2, 'Menyetujui peminjaman alat \'Laptop Asus 1\' oleh siswa 1 (ID Peminjaman #1)', 'petugas', '2026-04-14 08:23:32', '2026-04-14 08:23:32'),
(267, 1, 'Login ke sistem', 'admin', '2026-04-15 01:04:43', '2026-04-15 01:04:43'),
(268, 2, 'Login ke sistem', 'petugas', '2026-04-15 01:15:28', '2026-04-15 01:15:28'),
(269, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-15 01:15:47', '2026-04-15 01:15:47'),
(270, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-15 01:20:07', '2026-04-15 01:20:07'),
(271, 10, 'Login ke sistem', 'peminjam', '2026-04-15 01:35:30', '2026-04-15 01:35:30'),
(272, 10, 'Login ke sistem', 'peminjam', '2026-04-15 01:37:23', '2026-04-15 01:37:23'),
(273, 10, 'Mengajukan pengembalian alat \'Laptop Asus 1\' sebanyak 1 unit (ID Peminjaman #1)', 'peminjam', '2026-04-15 03:00:28', '2026-04-15 03:00:28'),
(274, 2, 'Memproses pengembalian alat \'Laptop Asus 1\' dari siswa 1 (ID Peminjaman #1)', 'petugas', '2026-04-15 03:01:09', '2026-04-15 03:01:09'),
(275, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-15 03:04:11', '2026-04-15 03:04:11'),
(276, 10, 'Mengajukan peminjaman alat \'Laptop Asus 3\' sebanyak 1 unit (ID Peminjaman #2)', 'peminjam', '2026-04-15 03:04:38', '2026-04-15 03:04:38'),
(277, 10, 'Membatalkan peminjaman alat \'Laptop Asus 3\' sebanyak 1 unit (ID Peminjaman #2)', 'peminjam', '2026-04-15 03:05:27', '2026-04-15 03:05:27'),
(278, 10, 'Mengajukan peminjaman alat \'Laptop Asus 2\' sebanyak 1 unit (ID Peminjaman #3)', 'peminjam', '2026-04-15 03:07:20', '2026-04-15 03:07:20'),
(279, 10, 'Membatalkan peminjaman alat \'Laptop Asus 2\' sebanyak 1 unit (ID Peminjaman #3)', 'peminjam', '2026-04-15 03:09:53', '2026-04-15 03:09:53'),
(280, 10, 'Mengajukan peminjaman alat \'Laptop Asus 2\' sebanyak 1 unit (ID Peminjaman #4)', 'peminjam', '2026-04-15 03:11:23', '2026-04-15 03:11:23'),
(281, 10, 'Membatalkan peminjaman alat \'Laptop Asus 2\' sebanyak 1 unit (ID Peminjaman #4)', 'peminjam', '2026-04-15 03:11:28', '2026-04-15 03:11:28'),
(282, 10, 'Login ke sistem', 'peminjam', '2026-04-16 00:05:02', '2026-04-16 00:05:02'),
(283, 10, 'Mengajukan peminjaman alat \'Laptop Asus 1\' sebanyak 1 unit (ID Peminjaman #5)', 'peminjam', '2026-04-16 01:08:06', '2026-04-16 01:08:06'),
(284, 2, 'Login ke sistem', 'petugas', '2026-04-16 01:15:03', '2026-04-16 01:15:03'),
(285, 2, 'Menyetujui peminjaman alat \'Laptop Asus 1\' oleh siswa 1 (ID Peminjaman #5)', 'petugas', '2026-04-16 01:15:45', '2026-04-16 01:15:45'),
(286, 10, 'Mengajukan pengembalian alat \'Laptop Asus 1\' sebanyak 1 unit (ID Peminjaman #5)', 'peminjam', '2026-04-16 01:15:57', '2026-04-16 01:15:57'),
(287, 2, 'Memproses pengembalian alat \'Laptop Asus 1\' dari siswa 1 (ID Peminjaman #5)', 'petugas', '2026-04-16 01:16:52', '2026-04-16 01:16:52'),
(288, 10, 'Mengajukan peminjaman alat \'Laptop Asus 1\' sebanyak 1 unit (ID Peminjaman #6)', 'peminjam', '2026-04-16 01:17:20', '2026-04-16 01:17:20'),
(289, 10, 'Membatalkan peminjaman alat \'Laptop Asus 1\' sebanyak 1 unit (ID Peminjaman #6)', 'peminjam', '2026-04-16 01:41:15', '2026-04-16 01:41:15'),
(290, 10, 'Login ke sistem', 'peminjam', '2026-04-16 01:51:51', '2026-04-16 01:51:51'),
(291, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-16 02:16:51', '2026-04-16 02:16:51'),
(292, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-16 02:32:55', '2026-04-16 02:32:55'),
(293, 10, 'Login ke sistem', 'peminjam', '2026-04-16 12:16:16', '2026-04-16 12:16:16'),
(294, 10, 'Login ke sistem', 'peminjam', '2026-04-16 12:27:23', '2026-04-16 12:27:23'),
(295, 1, 'Login ke sistem', 'admin', '2026-04-16 13:00:13', '2026-04-16 13:00:13'),
(296, 10, 'Mengajukan peminjaman alat \'Laptop Asus 1\' sebanyak 1 unit (ID Peminjaman #7)', 'peminjam', '2026-04-16 13:04:05', '2026-04-16 13:04:05'),
(297, 10, 'Membatalkan peminjaman alat \'Laptop Asus 1\' sebanyak 1 unit (ID Peminjaman #7)', 'peminjam', '2026-04-16 13:04:17', '2026-04-16 13:04:17'),
(298, 10, 'Logout dari sistem', 'peminjam', '2026-04-16 13:16:36', '2026-04-16 13:16:36'),
(299, 10, 'Login ke sistem', 'peminjam', '2026-04-16 13:18:22', '2026-04-16 13:18:22'),
(300, 2, 'Login ke sistem', 'petugas', '2026-04-16 13:19:26', '2026-04-16 13:19:26'),
(301, 10, 'Mengajukan peminjaman alat \'Laptop Asus 3\' sebanyak 1 unit (ID Peminjaman #8)', 'peminjam', '2026-04-16 13:20:07', '2026-04-16 13:20:07'),
(302, 2, 'Menyetujui peminjaman alat \'Laptop Asus 3\' oleh siswa 1 (ID Peminjaman #8)', 'petugas', '2026-04-16 13:20:20', '2026-04-16 13:20:20'),
(303, 10, 'Mengajukan peminjaman alat \'Laptop Asus 2\' sebanyak 1 unit (ID Peminjaman #9)', 'peminjam', '2026-04-16 13:20:51', '2026-04-16 13:20:51'),
(304, 2, 'Menyetujui peminjaman alat \'Laptop Asus 2\' oleh siswa 1 (ID Peminjaman #9)', 'petugas', '2026-04-16 13:20:59', '2026-04-16 13:20:59'),
(305, 2, 'Login ke sistem', 'petugas', '2026-04-16 13:22:08', '2026-04-16 13:22:08'),
(306, 2, 'Login ke sistem', 'petugas', '2026-04-17 02:48:35', '2026-04-17 02:48:35'),
(307, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-17 02:48:45', '2026-04-17 02:48:45'),
(308, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-17 02:48:58', '2026-04-17 02:48:58'),
(309, 2, 'Cetak laporan | Dari: 2026-04-01 - 2026-04-17 | Search:  | Status: ', 'petugas', '2026-04-17 02:49:00', '2026-04-17 02:49:00'),
(310, 2, 'Melihat laporan peminjaman dengan filter', 'petugas', '2026-04-17 02:50:46', '2026-04-17 02:50:46'),
(311, 10, 'Login ke sistem', 'peminjam', '2026-04-19 06:04:51', '2026-04-19 06:04:51'),
(312, 10, 'Logout dari sistem', 'peminjam', '2026-04-19 06:16:17', '2026-04-19 06:16:17'),
(313, 1, 'Login ke sistem', 'admin', '2026-04-19 06:16:26', '2026-04-19 06:16:26'),
(314, 10, 'Login ke sistem', 'peminjam', '2026-04-20 02:39:39', '2026-04-20 02:39:39'),
(315, 1, 'Login ke sistem', 'admin', '2026-04-20 02:44:22', '2026-04-20 02:44:22'),
(316, 10, 'Mengajukan peminjaman alat \'Laptop Asus 1\' sebanyak 1 unit (ID Peminjaman #10)', 'peminjam', '2026-04-20 02:45:08', '2026-04-20 02:45:08'),
(317, 1, 'Logout dari sistem', 'admin', '2026-04-20 02:45:21', '2026-04-20 02:45:21'),
(318, 2, 'Login ke sistem', 'petugas', '2026-04-20 02:45:30', '2026-04-20 02:45:30'),
(319, 2, 'Menyetujui peminjaman alat \'Laptop Asus 1\' oleh siswa 1 (ID Peminjaman #10)', 'petugas', '2026-04-20 02:45:56', '2026-04-20 02:45:56');

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
(5, '0001_01_01_000000_create_users_table', 1),
(6, '0001_01_01_000001_create_cache_table', 1),
(7, '0001_01_01_000002_create_jobs_table', 1),
(8, '2026_02_03_054959_add_role_to_users_table', 1),
(9, '2026_02_06_014241_create_kategoris_table', 2),
(10, '2026_02_06_014347_create_alats_table', 2),
(11, '2026_02_06_132318_create_peminjamans_table', 3),
(12, '2026_02_08_044308_add_denda_to_peminjamans_table', 4),
(13, '2026_02_08_050511_add_menunggu_pengembalian_to_peminjamans_status', 5),
(14, '2026_02_10_030745_create_log_aktivitas_table', 6),
(15, '2026_02_10_040409_add_role_to_log_aktivitas_table', 7),
(16, '2026_04_14_124729_add_kode_alat_to_alats_table', 8);

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
-- Table structure for table `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `alat_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali_target` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak','dipinjam','menunggu_pengembalian','dikembalikan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `denda` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjamans`
--

INSERT INTO `peminjamans` (`id`, `user_id`, `alat_id`, `jumlah`, `tanggal_pinjam`, `tanggal_kembali_target`, `tanggal_kembali`, `status`, `denda`, `created_at`, `updated_at`) VALUES
(1, 10, 1, 1, '2026-04-14', '2026-04-17', '2026-04-15', 'dikembalikan', 0, '2026-04-14 08:19:48', '2026-04-15 03:01:09'),
(5, 10, 1, 1, '2026-04-16', '2026-04-18', '2026-04-16', 'dikembalikan', 0, '2026-04-16 01:08:06', '2026-04-16 01:16:52'),
(8, 10, 3, 1, '2026-04-16', '2026-04-17', NULL, 'dipinjam', 0, '2026-04-16 13:20:07', '2026-04-16 13:20:20'),
(9, 10, 2, 1, '2026-04-16', '2026-04-17', NULL, 'dipinjam', 0, '2026-04-16 13:20:51', '2026-04-16 13:20:59'),
(10, 10, 1, 1, '2026-04-20', '2026-04-22', NULL, 'dipinjam', 0, '2026-04-20 02:45:08', '2026-04-20 02:45:56');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('q9uHclT4Qu5WJVXFSNROgBngVNI4E3n9BTUQqydq', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVFJaYkJ6MGo4UDhHN1NwOURLWEJoSU9Ld243ajFuYzBOSFo0WWxIViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njc6Imh0dHA6Ly9wYW50b25hbC1iZXVsYS1kaXNjcmVwYW50bHkubmdyb2stZnJlZS5kZXYvYWRtaW4vYWxhdC9jcmVhdGUiO3M6NToicm91dGUiO3M6MTc6ImFkbWluLmFsYXQuY3JlYXRlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1776579418),
('ylN0PNlpb0ZwduPyB6ebYcD1jmY9eTAKiCCiMePh', 10, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNUVyUnNaTVdGNERITEQzTm5WVTZrUUVSUDBhMnl0ZnNRa0ZJN0pmSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjY6Imh0dHA6Ly9wYW50b25hbC1iZXVsYS1kaXNjcmVwYW50bHkubmdyb2stZnJlZS5kZXYvcGVtaW5qYW0vcml3YXlhdCI7czo1OiJyb3V0ZSI7czoyMjoicGVtaW5qYW0ucml3YXlhdC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwO30=', 1776653109),
('zuQxekkGXdStsp9ZYYAUlaniuG4OptFqNJxiNxr8', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGRBalFtbTN1WGloc0pBVHRwaXpSbGZaOWtFYUlpcEJqZmpROGszbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wYW50b25hbC1iZXVsYS1kaXNjcmVwYW50bHkubmdyb2stZnJlZS5kZXYvcGV0dWdhcy9hbGF0IjtzOjU6InJvdXRlIjtzOjE4OiJwZXR1Z2FzLmFsYXQuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1776653165);

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
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','petugas','peminjam') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'peminjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Admin', 'ibnunabil94@gmail.com', NULL, '$2y$12$A2YpUfY.Te/BPGDyPddsc.tTM5MceGUt8jUHpTEi4X1n5uqsEjj6y', 'TY1osSJveF7ok5HnQ9l6dll8Ba0YZuF9HQw4BzmbzlXdh36Odg2tqG6bXxn1', '2026-02-02 23:31:29', '2026-03-25 09:24:42', 'admin'),
(2, 'Petugas', 'petugas@system.test', NULL, '$2y$12$p3wYqE2azEvbgZdj3cnC7uIY6Y3vDufgY95pz8cRnrPMdktAkp9Le', 'NeqlId8xJsTBx8JYTy4Hw3oCO9bnys9AfFVYlSGoLYEBeUGnCOQYz3E6g18S', '2026-02-02 23:31:29', '2026-02-02 23:31:29', 'petugas'),
(3, 'Test User', 'test@example.com', '2026-02-02 23:31:29', '$2y$12$EtPQ0wscB7vaPCJOD.MS6ujzSrsInoIzavo5RFAIU4qog/6qWtXFW', 'KtujDlwyT2', '2026-02-02 23:31:29', '2026-02-02 23:31:29', 'peminjam'),
(4, 'afif', 'afif@gmail.com', NULL, '$2y$12$1fgxx.fhOMrr4plCZy9G3.LuYvi/eqU00kOBg9iBekncJwY/ldOLy', NULL, '2026-02-03 16:39:18', '2026-02-03 16:39:18', 'peminjam'),
(5, 'Ahmad', 'kelas@gmail.com', NULL, '$2y$12$9rvZWB3ynj9FiPQ7/JZob.vJC2ttw3dYx2tFQSilq/f8SrY1U3t0S', NULL, '2026-02-03 16:40:59', '2026-02-03 16:40:59', 'peminjam'),
(6, 'John', 'budi@test.man', NULL, '$2y$12$42pNswxoHG1IDpl3T3fvJOJzOqR.asxjAoh1P9UIceB2MGPTcPjGe', NULL, '2026-02-05 09:07:15', '2026-02-05 09:07:15', 'peminjam'),
(8, 'Ibnu', 'bilzibnu@gmail.com', NULL, '$2y$12$zx5g2Ce/PSr946zoaGJN1.732OHmx7yo9mbqMU9yzIUkc825kAWzW', NULL, '2026-02-06 06:51:05', '2026-02-06 06:51:05', 'peminjam'),
(9, 'Ibnu', 'kelas1@gmail.com', NULL, '$2y$12$BH.3YSMHuqxev1O3f2y/t.tG.JoNsSfv/UyP4ud7kfUgSSlPKQCV.', NULL, '2026-03-29 13:37:37', '2026-03-29 13:37:37', 'peminjam'),
(10, 'siswa 1', 'siswa1@gmail.com', NULL, '$2y$12$PC.B357iyDXUS0S.KdTmxeBBEqyPWK9gVFzMMeLVmIyYyp4qtlNjm', NULL, '2026-04-07 01:02:39', '2026-04-07 01:02:39', 'peminjam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alats`
--
ALTER TABLE `alats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alats_kode_alat_unique` (`kode_alat`),
  ADD KEY `alats_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategoris_nama_unique` (`nama`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_aktivitas_user_id_foreign` (`user_id`);

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
-- Indexes for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjamans_user_id_foreign` (`user_id`),
  ADD KEY `peminjamans_alat_id_foreign` (`alat_id`);

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
-- AUTO_INCREMENT for table `alats`
--
ALTER TABLE `alats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alats`
--
ALTER TABLE `alats`
  ADD CONSTRAINT `alats_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjamans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
