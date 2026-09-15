-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2026 at 03:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stunting`
--

-- --------------------------------------------------------

--
-- Table structure for table `bobot_ahp`
--

CREATE TABLE `bobot_ahp` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `kriteria` varchar(255) NOT NULL,
  `bobot` decimal(8,4) NOT NULL,
  `tipe` enum('benefit','cost') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_stunting`
--

CREATE TABLE `data_stunting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kabupaten_id` bigint(20) UNSIGNED NOT NULL,
  `puskesmas_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_balita` int(11) NOT NULL,
  `jumlah_stunting` int(11) NOT NULL,
  `jumlah_bblr` int(11) NOT NULL,
  `persentase_asi` decimal(5,2) NOT NULL,
  `persentase_pelayanan` decimal(5,2) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `bulan` tinyint(4) NOT NULL,
  `tahun` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_stunting`
--

INSERT INTO `data_stunting` (`id`, `kabupaten_id`, `puskesmas_id`, `jumlah_balita`, `jumlah_stunting`, `jumlah_bblr`, `persentase_asi`, `persentase_pelayanan`, `tanggal`, `bulan`, `tahun`, `created_at`, `updated_at`) VALUES
(2, 5, 1, 95, 10, 20, 10.00, 10.00, NULL, 8, '2026', '2026-07-31 21:20:39', '2026-08-04 20:35:27'),
(3, 2, 3, 135, 11, 10, 90.00, 80.00, NULL, 2, '2026', '2026-08-05 06:42:17', '2026-08-05 06:42:17'),
(4, 5, 11, 20, 10, 10, 50.00, 90.00, '2020-02-01', 2, '2020', '2026-08-05 07:44:34', '2026-08-30 06:42:12'),
(5, 5, 5, 150, 20, 2, 90.00, 95.00, NULL, 8, '2026', '2026-08-14 00:43:21', '2026-08-14 00:43:21'),
(6, 4, 6, 100, 10, 10, 90.00, 95.00, '2026-08-01', 8, '2026', '2026-08-22 09:03:46', '2026-08-30 06:45:06'),
(7, 3, 7, 100, 20, 3, 90.00, 100.00, NULL, 8, '2026', '2026-08-22 09:26:42', '2026-08-22 09:26:42'),
(8, 2, 8, 87, 10, 1, 95.00, 100.00, '2026-06-17', 6, '2026', '2026-08-23 22:54:04', '2026-08-30 06:27:33'),
(9, 3, 9, 127, 10, 1, 95.00, 100.00, '2026-07-27', 7, '2026', '2026-08-25 15:41:49', '2026-08-30 06:25:48'),
(10, 1, 10, 200, 5, 0, 100.00, 99.00, '2020-01-02', 1, '2020', '2026-08-30 06:40:51', '2026-08-30 06:40:51'),
(14, 2, 8, 100, 12, 3, 100.00, 99.00, '2026-09-05', 9, '2026', '2026-09-05 07:46:57', '2026-09-05 07:46:57');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_dss`
--

CREATE TABLE `hasil_dss` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_stunting_id` bigint(20) UNSIGNED NOT NULL,
  `bulan` tinyint(4) NOT NULL,
  `tahun` year(4) NOT NULL,
  `nilai_dss` decimal(8,4) NOT NULL,
  `ranking` int(11) NOT NULL,
  `prioritas` enum('Tinggi','Sedang','Rendah') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kabupaten`
--

CREATE TABLE `kabupaten` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kabupaten` varchar(255) NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kabupaten`
--

INSERT INTO `kabupaten` (`id`, `nama_kabupaten`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Lombok Barat', -8.6369000, 116.1167000, '2026-08-01 04:55:32', '2026-08-01 04:55:32'),
(2, 'Lombok Tengah', -8.7000000, 116.3000000, '2026-08-01 04:55:32', '2026-08-01 04:55:32'),
(3, 'Lombok Timur', -8.5333000, 116.5333000, '2026-08-01 04:55:32', '2026-08-01 04:55:32'),
(4, 'Lombok Utara', -8.3500000, 116.2500000, '2026-08-01 04:55:32', '2026-08-01 04:55:32'),
(5, 'Kota Mataram', -8.5833000, 116.1167000, '2026-08-01 04:55:32', '2026-08-01 04:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_23_031454_create_kabupaten_table', 2),
(5, '2026_07_23_031506_create_puskesmas_table', 2),
(6, '2026_07_23_031610_create_data_stunting_table', 2),
(7, '2026_07_23_031640_create_hasil_dss_table', 2),
(8, '2026_07_28_134444_create_bobot_ahp_table', 3),
(9, '2026_07_28_141305_add_bulan_to_data_stunting_table', 4),
(10, '2026_07_28_142827_add_bulan_tahun_to_hasil_dss_table', 5),
(11, '2026_08_30_000000_add_tanggal_to_data_stunting_table', 6),
(12, '2026_09_03_000000_add_status_to_users_table', 7),
(13, '2026_09_05_155812_add_coordinates_to_puskesmas_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `puskesmas`
--

CREATE TABLE `puskesmas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kabupaten_id` bigint(20) UNSIGNED NOT NULL,
  `nama_puskesmas` varchar(255) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `puskesmas`
--

INSERT INTO `puskesmas` (`id`, `kabupaten_id`, `nama_puskesmas`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 5, 'Kekalik', -8.5997000, 116.0963000, '2026-07-31 21:06:54', '2026-09-05 07:59:14'),
(2, 1, 'Keruak', -8.7663000, 116.4891000, '2026-08-04 20:22:02', '2026-09-05 07:59:14'),
(3, 2, 'Tanjung', -8.3512000, 116.1557000, '2026-08-05 06:42:17', '2026-09-05 07:59:14'),
(4, 5, 'A', -8.5772000, 116.1018000, '2026-08-05 07:44:34', '2026-09-05 07:59:14'),
(5, 5, 'Dasan Agung', -8.5772000, 116.1018000, '2026-08-14 00:43:21', '2026-09-05 07:59:14'),
(6, 4, 'Gangga', -8.3286000, 116.1956000, '2026-08-22 09:03:46', '2026-09-05 07:59:14'),
(7, 3, 'Terara', -8.6256000, 116.4253000, '2026-08-22 09:26:42', '2026-09-05 07:59:14'),
(8, 2, 'Kopang', -8.6475000, 116.3533000, '2026-08-23 22:54:04', '2026-09-05 07:59:14'),
(9, 3, 'Selong', -8.6492000, 116.5342000, '2026-08-25 15:41:49', '2026-09-05 07:59:14'),
(10, 1, 'Narmada', -8.5982000, 116.2081000, '2026-08-30 06:40:51', '2026-09-05 07:59:14'),
(11, 5, 'Gomong', -8.5835000, 116.1042000, '2026-08-30 06:42:12', '2026-09-05 07:59:14'),
(12, 1, 'Puskesmas Gerung', -8.6872000, 116.1264000, '2026-09-05 07:45:33', '2026-09-05 07:59:14'),
(13, 2, 'Puskesmas Praya', -8.7078000, 116.2731000, '2026-09-05 07:45:33', '2026-09-05 07:59:14'),
(14, 3, 'Puskesmas Selong', -8.6492000, 116.5342000, '2026-09-05 07:45:33', '2026-09-05 07:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_depan` varchar(255) NOT NULL,
  `nama_belakang` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'approved',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_depan`, `nama_belakang`, `username`, `instansi`, `email`, `role`, `status`, `password`, `created_at`, `updated_at`) VALUES
(2, 'Admin', 'SIPENTA', 'admin', 'Dinas Kesehatan', 'admin@sipenta.com', 'admin', 'approved', '$2y$12$qL.NyTwogl3qgWuDmTf4IezJWB.XzbGo6XUOQTMlAzLr2aUWaGEJS', '2026-07-30 07:12:46', '2026-07-30 07:12:46'),
(3, 'Qhaulan', 'Syaqhila', 'aqhilaaa', 'Dinas Kesehatan', 'aqhila908@gmail.com', 'kadis', 'approved', '$2y$12$CEkOuUdtwEg9x6u4z90ocuurOGQFobI/bTqZppw.VR..98eeeThB.', '2026-07-30 07:51:14', '2026-09-06 01:52:21'),
(9, 'Aqhilaaa', 'qhaulannn', 'aqhila', 'Puskesmas Narmada', 'cilaaa@gmail.com', 'admin', 'pending', '$2y$12$v.bmGmMgBJ8QKhk3DY/h7eisTud1bcNcRe4p9F0i8tMQH/zX3jj8i', '2026-09-06 00:58:40', '2026-09-06 00:58:40'),
(10, 'Aqhilaaa', 'qhaulan', 'kepala', 'Dinas Kesehatan', 'qhila@gmail.com', 'kadis', 'pending', '$2y$12$sAhRc7PrCUBvpQnGCNtMsuR1Iyc9itshuzejz3BL8LZzEku38T722', '2026-09-13 21:11:16', '2026-09-13 21:11:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bobot_ahp`
--
ALTER TABLE `bobot_ahp`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `data_stunting`
--
ALTER TABLE `data_stunting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_stunting_kabupaten_id_foreign` (`kabupaten_id`),
  ADD KEY `data_stunting_puskesmas_id_foreign` (`puskesmas_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hasil_dss`
--
ALTER TABLE `hasil_dss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasil_dss_data_stunting_id_foreign` (`data_stunting_id`);

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
-- Indexes for table `kabupaten`
--
ALTER TABLE `kabupaten`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `puskesmas`
--
ALTER TABLE `puskesmas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `puskesmas_kabupaten_id_foreign` (`kabupaten_id`);

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
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bobot_ahp`
--
ALTER TABLE `bobot_ahp`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_stunting`
--
ALTER TABLE `data_stunting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_dss`
--
ALTER TABLE `hasil_dss`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kabupaten`
--
ALTER TABLE `kabupaten`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `puskesmas`
--
ALTER TABLE `puskesmas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_stunting`
--
ALTER TABLE `data_stunting`
  ADD CONSTRAINT `data_stunting_kabupaten_id_foreign` FOREIGN KEY (`kabupaten_id`) REFERENCES `kabupaten` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `data_stunting_puskesmas_id_foreign` FOREIGN KEY (`puskesmas_id`) REFERENCES `puskesmas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hasil_dss`
--
ALTER TABLE `hasil_dss`
  ADD CONSTRAINT `hasil_dss_data_stunting_id_foreign` FOREIGN KEY (`data_stunting_id`) REFERENCES `data_stunting` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `puskesmas`
--
ALTER TABLE `puskesmas`
  ADD CONSTRAINT `puskesmas_kabupaten_id_foreign` FOREIGN KEY (`kabupaten_id`) REFERENCES `kabupaten` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
