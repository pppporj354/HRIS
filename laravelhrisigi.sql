-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2024 at 06:33 AM
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
-- Database: `laravelhrisigi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status_absensi` enum('Masuk','Izin','Sakit','Alpha') NOT NULL DEFAULT 'Alpha',
  `data_karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `tanggal`, `jam_masuk`, `keterangan`, `status_absensi`, `data_karyawan_id`, `created_at`, `updated_at`) VALUES
(1, '2024-12-24', '10:46:29', NULL, 'Masuk', 11, '2024-12-23 20:46:29', '2024-12-23 20:46:29');

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id_cuti` bigint(20) UNSIGNED NOT NULL,
  `mulai_cuti` date NOT NULL,
  `selesai_cuti` date NOT NULL,
  `jumlah_hari` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  `status_cuti` enum('Disetujui','Pending','Ditolak') NOT NULL DEFAULT 'Pending',
  `data_karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id_cuti`, `mulai_cuti`, `selesai_cuti`, `jumlah_hari`, `keterangan`, `status_cuti`, `data_karyawan_id`, `created_at`, `updated_at`) VALUES
(2, '2024-12-24', '2024-12-26', '3', 'adadada', 'Pending', 11, '2024-12-23 20:47:11', '2024-12-23 20:47:11');

-- --------------------------------------------------------

--
-- Table structure for table `data_karyawan`
--

CREATE TABLE `data_karyawan` (
  `id_data_karyawan` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `status_karyawan` enum('Karyawan Tetap','Karyawan Kontrak') NOT NULL,
  `keahlian` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `rekrutmen_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_karyawan`
--

INSERT INTO `data_karyawan` (`id_data_karyawan`, `nama`, `alamat`, `nomor_telepon`, `status_karyawan`, `keahlian`, `jabatan`, `rekrutmen_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Eduardo Ernser Sr.', '544 Karelle Cape\nGleichnerstad, TX 28671-5938', '425-426-9203', 'Karyawan Tetap', 'orchestrate back-end users', 'Technical Writer', NULL, 1, '2024-07-08 06:46:18', '2024-07-08 06:46:18'),
(2, 'Mrs. Cordia Kuhn', '79321 Schamberger Course\nBeatriceview, ID 56936', '+1.325.990.3620', 'Karyawan Tetap', 'deploy magnetic networks', 'Financial Specialist', NULL, 2, '2024-07-08 06:46:19', '2024-07-08 06:46:19'),
(3, 'Mrs. Modesta Koelpin', '111 Bashirian Skyway\nHartmannshire, NC 53914-2702', '+1-231-649-6548', 'Karyawan Kontrak', 'extend intuitive niches', 'Well and Core Drill Operator', NULL, 3, '2024-07-08 06:46:19', '2024-07-08 06:46:19'),
(4, 'Emile Crist V', '75501 Smith Union\nLabadieport, WY 75052-4685', '1-240-762-1855', 'Karyawan Tetap', 'deliver interactive interfaces', 'Agricultural Equipment Operator', NULL, 4, '2024-07-08 06:46:20', '2024-07-08 06:46:20'),
(5, 'Keenan Trantow', '17267 Langosh Courts Suite 440\nNorth Jeraldbury, CA 07047', '1-361-496-5031', 'Karyawan Tetap', 'incubate proactive e-business', 'Bartender', NULL, 5, '2024-07-08 06:46:21', '2024-07-08 06:46:21'),
(6, 'Ivah Heaney', '84946 Schiller Lake Suite 620\nAltenwerthstad, TX 63998', '+1.463.973.9976', 'Karyawan Kontrak', 'cultivate bricks-and-clicks communities', 'Order Clerk', NULL, 6, '2024-07-08 06:46:21', '2024-07-08 06:46:21'),
(7, 'Dr. Marianna Glover', '4866 Linda Lock\nEast Sylvesterhaven, GA 33779-9938', '985.762.9707', 'Karyawan Tetap', 'reinvent real-time applications', 'Precision Aircraft Systems Assemblers', NULL, 7, '2024-07-08 06:46:22', '2024-07-08 06:46:22'),
(8, 'Rhianna Zieme', '108 Coralie Mall\nBrownhaven, OH 41694-4698', '623.371.2721', 'Karyawan Tetap', 'envisioneer efficient e-markets', 'Poet OR Lyricist', NULL, 8, '2024-07-08 06:46:23', '2024-07-08 06:46:23'),
(9, 'Trenton Ryan V', '296 Koss Mall\nAnkundingshire, OR 12158-3790', '1-763-846-9007', 'Karyawan Tetap', 'unleash bricks-and-clicks convergence', 'Job Printer', NULL, 9, '2024-07-08 06:46:23', '2024-07-08 06:46:23'),
(10, 'Rene Swift', '230 Pouros Courts\nImmanuelfurt, WV 61397', '641-454-1850', 'Karyawan Kontrak', 'revolutionize bricks-and-clicks action-items', 'Rail Transportation Worker', NULL, 10, '2024-07-08 06:46:24', '2024-07-08 06:46:24'),
(11, 'administrator_master', 'Jl. Ketintang no.156', '081345642135', 'Karyawan Tetap', 'Human Resource', 'Human Resource', NULL, 11, '2024-07-08 06:46:29', '2024-07-08 06:46:29'),
(12, 'employee_example', 'Jl. Ketintang no.156', '081323553176', 'Karyawan Tetap', 'Web Programming, Desktop Programming, Mobile Programming', 'Software Developer', NULL, 12, '2024-07-08 06:46:29', '2024-07-08 06:46:29');

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
-- Table structure for table `gaji`
--

CREATE TABLE `gaji` (
  `id_gaji` bigint(20) UNSIGNED NOT NULL,
  `gaji_pokok` int(11) NOT NULL,
  `potongan_ketidakhadiran` int(11) NOT NULL,
  `potongan_lain` int(11) NOT NULL,
  `total_potongan` int(11) NOT NULL,
  `total_tunjangan` int(11) NOT NULL,
  `total_gaji` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tahun_bulan` varchar(7) NOT NULL,
  `status_gaji` enum('Terbayar','Kredit') NOT NULL DEFAULT 'Kredit',
  `data_karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gaji`
--

INSERT INTO `gaji` (`id_gaji`, `gaji_pokok`, `potongan_ketidakhadiran`, `potongan_lain`, `total_potongan`, `total_tunjangan`, `total_gaji`, `keterangan`, `tahun_bulan`, `status_gaji`, `data_karyawan_id`, `created_at`, `updated_at`) VALUES
(1, 5000000, 0, 0, 0, 0, 5000000, 'Sesuai', '2024-12', 'Terbayar', 1, '2024-12-23 20:34:11', '2024-12-23 20:34:22'),
(2, 5000000, 0, 0, 0, 0, 5000000, '0000', '2024-11', 'Terbayar', 11, '2024-12-23 20:43:35', '2024-12-23 20:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `komponen_gaji`
--

CREATE TABLE `komponen_gaji` (
  `id_komponen_gaji` bigint(20) UNSIGNED NOT NULL,
  `gaji_pokok` int(11) NOT NULL,
  `data_karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komponen_gaji`
--

INSERT INTO `komponen_gaji` (`id_komponen_gaji`, `gaji_pokok`, `data_karyawan_id`, `created_at`, `updated_at`) VALUES
(1, 5000000, 1, '2024-12-24 03:33:01', '2024-12-24 03:33:01'),
(2, 5000000, 2, '2024-12-24 03:35:01', '2024-12-24 03:35:01'),
(3, 5000000, 3, '2024-12-24 03:35:01', '2024-12-24 03:35:01'),
(4, 5000000, 4, '2024-12-24 03:35:47', '2024-12-24 03:35:47'),
(5, 5000000, 5, '2024-12-24 03:35:47', '2024-12-24 03:35:47'),
(6, 5000000, 6, '2024-12-24 03:36:57', '2024-12-24 03:36:57'),
(7, 5000000, 7, '2024-12-24 03:37:25', '2024-12-24 03:37:32'),
(8, 5000000, 8, '2024-12-24 03:37:36', '2024-12-24 03:37:36'),
(9, 5000000, 9, '2024-12-24 03:37:36', '2024-12-24 03:37:36'),
(10, 5000000, 10, '2024-12-24 03:38:08', '2024-12-24 03:38:08'),
(11, 5000000, 11, '2024-12-24 03:38:08', '2024-12-24 03:38:08'),
(12, 5000000, 12, '2024-12-24 03:38:32', '2024-12-24 03:38:32');

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
(1, '01_create_users_table', 1),
(2, '02_create_rekrutmen_table', 1),
(3, '03_create_data_karyawan_table', 1),
(4, '04_create_absensi_table', 1),
(5, '05_create_cuti_table', 1),
(6, '06_create_gaji_table', 1),
(7, '07_create_komponen_gaji_table', 1),
(8, '08_create_notifikasi_table', 1),
(9, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(10, '2014_10_12_100000_create_password_resets_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` bigint(20) UNSIGNED NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `status_notifikasi` enum('Dibaca','Belum Dibaca') NOT NULL DEFAULT 'Belum Dibaca',
  `jam` time DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `pesan`, `status_notifikasi`, `jam`, `tanggal`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'administrator_master mengajukan cuti untuk tanggal 24 Desember 2024 sampai tanggal 26 Desember 2024 selengkapnya bisa dicek pada halaman persetujuan cuti.', 'Dibaca', '03:25:26', '2024-12-24', 11, '2024-12-23 20:25:26', '2024-12-23 20:28:58'),
(2, 'Gaji anda pada bulan Desember 2024 telah dibayarkan. Selengkapnya bisa dicek pada halaman riwayat gaji.', 'Belum Dibaca', '03:34:22', '2024-12-24', 1, '2024-12-23 20:34:22', '2024-12-23 20:34:22'),
(3, 'Gaji anda pada bulan Desember 2024 telah dibayarkan. Selengkapnya bisa dicek pada halaman riwayat gaji.', 'Belum Dibaca', '03:39:12', '2024-12-24', 1, '2024-12-23 20:39:12', '2024-12-23 20:39:12'),
(4, 'Gaji anda pada bulan November 2024 telah dibayarkan. Selengkapnya bisa dicek pada halaman riwayat gaji.', 'Dibaca', '03:43:38', '2024-12-24', 11, '2024-12-23 20:43:38', '2024-12-23 20:44:41'),
(5, 'administrator_master mengajukan cuti untuk tanggal 24 Desember 2024 sampai tanggal 26 Desember 2024 selengkapnya bisa dicek pada halaman persetujuan cuti.', 'Belum Dibaca', '03:47:11', '2024-12-24', 11, '2024-12-23 20:47:11', '2024-12-23 20:47:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekrutmen`
--

CREATE TABLE `rekrutmen` (
  `id_rekrutmen` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `keahlian` varchar(255) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status_rekrutmen` enum('Proses','Diterima','Ditolak') NOT NULL DEFAULT 'Proses',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rekrutmen`
--

INSERT INTO `rekrutmen` (`id_rekrutmen`, `nama`, `email`, `nomor_telepon`, `alamat`, `keahlian`, `catatan`, `status_rekrutmen`, `created_at`, `updated_at`) VALUES
(1, 'Miss Destiny Tremblay DDS', 'hcrist@hotmail.com', '(470) 219-9522', '28340 Violet Bypass\nEast Damienview, KY 25345', 'leverage killer niches', 'Velit aliquid assumenda velit eum.', 'Proses', '2024-07-08 06:46:26', '2024-07-08 06:46:26'),
(2, 'Ms. Bryana Armstrong MD', 'dstamm@yahoo.com', '+1-657-977-3924', '84293 Koch Ville Suite 983\nGaylordside, NH 18945-9003', 'aggregate distributed functionalities', 'Magnam iusto sit minima ad repellendus.', 'Proses', '2024-07-08 06:46:26', '2024-07-08 06:46:26'),
(3, 'Godfrey Ritchie', 'domenico68@hotmail.com', '+1 (641) 626-1794', '5709 Kutch Run Suite 475\nWest Robbborough, NM 94902', 'facilitate collaborative vortals', 'Id quos natus non.', 'Proses', '2024-07-08 06:46:26', '2024-07-08 06:46:26'),
(4, 'Mabelle Oberbrunner', 'jose.baumbach@gmail.com', '323.526.8669', '62669 O\'Keefe Stream\nKeyonfurt, MN 58346-7419', 'optimize rich mindshare', 'Ducimus ut porro ea doloribus est velit a.', 'Proses', '2024-07-08 06:46:26', '2024-07-08 06:46:26'),
(5, 'Callie Rippin', 'wilber.kling@hotmail.com', '248.278.8243', '98436 Conroy Park\nNew Rico, NM 62406-3784', 'embrace robust deliverables', 'Nam esse omnis quia.', 'Proses', '2024-07-08 06:46:26', '2024-07-08 06:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrator','Employee') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Felton', 'erdman.douglas@gmail.com', '2024-07-08 06:46:17', '$2y$12$mhPCZqR.QvBLllhhLXXvduZ81bFqfKZFXz27bZA.2Q4eNHwCYLR5G', 'Employee', '11hfuRQ1gB', '2024-07-08 06:46:18', '2024-07-08 06:46:18'),
(2, 'Roberta', 'aurelia98@gmail.com', '2024-07-08 06:46:18', '$2y$12$7D59qUZmzPGA8sExG8KTNecRA0etNdMqUsdC6BMtUXaacHyXF47jG', 'Employee', 'kGLng6jnPt', '2024-07-08 06:46:19', '2024-07-08 06:46:19'),
(3, 'Elijah', 'kwhite@gmail.com', '2024-07-08 06:46:19', '$2y$12$/jDNYGPPzZrGOZgUO6cr.eKpwm60dY3jAupq7AYqNzHA93pgy/2Yi', 'Employee', 'ZWMrnkx1zP', '2024-07-08 06:46:19', '2024-07-08 06:46:19'),
(4, 'Iliana', 'lois.ward@hotmail.com', '2024-07-08 06:46:19', '$2y$12$YTaXHdaiP0KDB1gsyzjBoOACeMH3NZgPU3tj/KJYSJj2nSd6wwm.W', 'Employee', 'e6bTzepznU', '2024-07-08 06:46:20', '2024-07-08 06:46:20'),
(5, 'Adela', 'abelardo.smitham@gmail.com', '2024-07-08 06:46:20', '$2y$12$F4ghCr5dkql.sQ8MPLqAnuTPlpka5fwGF1lvvNmE6cOpczodyGKBK', 'Employee', '6yKbCrWXnb', '2024-07-08 06:46:21', '2024-07-08 06:46:21'),
(6, 'Darrel', 'florence.anderson@hotmail.com', '2024-07-08 06:46:21', '$2y$12$.jMSh/wQCs/Pde3DjMfhuewzze4e3jgErr0sDFx3d8DJtfjhWRQ/O', 'Employee', 'r24hJOkEME', '2024-07-08 06:46:21', '2024-07-08 06:46:21'),
(7, 'Mariela', 'giovanna67@yahoo.com', '2024-07-08 06:46:21', '$2y$12$UBaILKpvhK3tXkxdkC2UxOYPqNyOUMROGA7BLEh7esndEN9cdOIK.', 'Employee', 'OoO6ewm5Ph', '2024-07-08 06:46:22', '2024-07-08 06:46:22'),
(8, 'Jerrold', 'triston97@yahoo.com', '2024-07-08 06:46:22', '$2y$12$vLpuTxJevB5D6K5HWYWUW.2yIBNV5PibowTTyTRDbL5kxxivNille', 'Employee', 'C5GsQrSZXL', '2024-07-08 06:46:23', '2024-07-08 06:46:23'),
(9, 'Erna', 'marlee.torp@hotmail.com', '2024-07-08 06:46:23', '$2y$12$BBiS4kffiv47WVetwq0kuOXco3RR.OFm/rwOXVs4EuYdjejNwSBSm', 'Employee', 'i5yjsYuY5e', '2024-07-08 06:46:23', '2024-07-08 06:46:23'),
(10, 'Aditya', 'jarred25@yahoo.com', '2024-07-08 06:46:23', '$2y$12$d6qlgIPtCA0dQJORf0xpsOvyfz8esbi/mYwMAaQKRW5jLm8qMkqRa', 'Employee', 'vlIGqCRTRH', '2024-07-08 06:46:24', '2024-07-08 06:46:24'),
(11, 'administrator_master', 'admin@indoglobalimpex.com', '2024-07-08 06:46:28', '$2y$12$4v1751mN4SDWqnOKtBdfUu3/1CXUKVoA6eO4nMBCWktTr47anOzsO', 'Administrator', 'USQSIqiDSUTO5XOPLHTHSOZ8MXPWsfGuJxFt5nONWGGFF6eJ6N2LjtCQ9byk', '2024-07-08 06:46:28', '2024-07-08 06:46:28'),
(12, 'employee_example', 'employee@indoglobalimpex.com', '2024-07-08 06:46:28', '$2y$12$qESPue1UePUXF.20kEp2geRKpW6tA4NHxq9788NcxtjXfl1iN.lDq', 'Employee', 'pr8hvXgpEY0af45StfaPZOTLlZXY0nhZ2HCNIvYw06entsuxOHnwHmA224Dh', '2024-07-08 06:46:29', '2024-07-08 06:46:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `absensi_data_karyawan_id_foreign` (`data_karyawan_id`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_cuti`),
  ADD KEY `cuti_data_karyawan_id_foreign` (`data_karyawan_id`);

--
-- Indexes for table `data_karyawan`
--
ALTER TABLE `data_karyawan`
  ADD PRIMARY KEY (`id_data_karyawan`),
  ADD KEY `data_karyawan_rekrutmen_id_foreign` (`rekrutmen_id`),
  ADD KEY `data_karyawan_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gaji`
--
ALTER TABLE `gaji`
  ADD PRIMARY KEY (`id_gaji`),
  ADD KEY `gaji_data_karyawan_id_foreign` (`data_karyawan_id`);

--
-- Indexes for table `komponen_gaji`
--
ALTER TABLE `komponen_gaji`
  ADD PRIMARY KEY (`id_komponen_gaji`),
  ADD KEY `komponen_gaji_data_karyawan_id_foreign` (`data_karyawan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rekrutmen`
--
ALTER TABLE `rekrutmen`
  ADD PRIMARY KEY (`id_rekrutmen`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id_cuti` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_karyawan`
--
ALTER TABLE `data_karyawan`
  MODIFY `id_data_karyawan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gaji`
--
ALTER TABLE `gaji`
  MODIFY `id_gaji` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `komponen_gaji`
--
ALTER TABLE `komponen_gaji`
  MODIFY `id_komponen_gaji` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekrutmen`
--
ALTER TABLE `rekrutmen`
  MODIFY `id_rekrutmen` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_data_karyawan_id_foreign` FOREIGN KEY (`data_karyawan_id`) REFERENCES `data_karyawan` (`id_data_karyawan`) ON DELETE CASCADE;

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_data_karyawan_id_foreign` FOREIGN KEY (`data_karyawan_id`) REFERENCES `data_karyawan` (`id_data_karyawan`) ON DELETE CASCADE;

--
-- Constraints for table `data_karyawan`
--
ALTER TABLE `data_karyawan`
  ADD CONSTRAINT `data_karyawan_rekrutmen_id_foreign` FOREIGN KEY (`rekrutmen_id`) REFERENCES `rekrutmen` (`id_rekrutmen`),
  ADD CONSTRAINT `data_karyawan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `gaji`
--
ALTER TABLE `gaji`
  ADD CONSTRAINT `gaji_data_karyawan_id_foreign` FOREIGN KEY (`data_karyawan_id`) REFERENCES `data_karyawan` (`id_data_karyawan`) ON DELETE CASCADE;

--
-- Constraints for table `komponen_gaji`
--
ALTER TABLE `komponen_gaji`
  ADD CONSTRAINT `komponen_gaji_data_karyawan_id_foreign` FOREIGN KEY (`data_karyawan_id`) REFERENCES `data_karyawan` (`id_data_karyawan`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
