-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2024 at 01:19 PM
-- Server version: 10.6.20-MariaDB-cll-lve
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siperaif_db_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `departemen` varchar(255) NOT NULL,
  `PIC` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id`, `departemen`, `PIC`, `created_at`, `updated_at`) VALUES
(7, 'Prodi Ilmu Informatika', NULL, '2024-10-24 22:48:27', '2024-10-24 22:48:27'),
(8, 'Prodi Ilmu Hukum', NULL, '2024-10-24 22:48:35', '2024-10-24 22:48:35'),
(9, 'Prodi Akupuntur dan Pengobatan Herbal', NULL, '2024-10-24 22:48:51', '2024-12-03 20:21:44'),
(10, 'Prodi Manajemen', NULL, '2024-10-24 22:49:07', '2024-10-24 22:49:07'),
(12, 'Prodi Teknik Industri', NULL, '2024-10-24 22:49:31', '2024-10-24 22:49:31'),
(13, 'Prodi Arsitektur', NULL, '2024-10-24 22:50:33', '2024-10-24 22:50:33'),
(14, 'Prodi Akuntansi', NULL, '2024-10-30 05:51:42', '2024-10-09 05:51:48');

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
-- Table structure for table `lokasi_psikotes`
--

CREATE TABLE `lokasi_psikotes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lokasi_psikotes` varchar(255) DEFAULT NULL,
  `ruangan_psikotes` varchar(255) DEFAULT NULL,
  `alamat_psikotes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasi_psikotes`
--

INSERT INTO `lokasi_psikotes` (`id`, `lokasi_psikotes`, `ruangan_psikotes`, `alamat_psikotes`, `created_at`, `updated_at`) VALUES
(1, 'Universitas Widya Mandala Surabaya', 'ruang D 403', 'Jln. Dinoyo no 42-44', '2024-09-22 17:14:19', '2024-09-22 17:14:19');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_wawancara`
--

CREATE TABLE `lokasi_wawancara` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ruangan` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasi_wawancara`
--

INSERT INTO `lokasi_wawancara` (`id`, `ruangan`, `lokasi`, `created_at`, `updated_at`) VALUES
(1, 'Lantai 7', 'Ruang Biro Administrasi Umum', '2024-10-03 21:04:55', '2024-10-03 21:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `lowongan`
--

CREATE TABLE `lowongan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `img_base_64` longtext DEFAULT NULL,
  `name_lowongan` varchar(255) DEFAULT NULL,
  `link_lowongan` varchar(255) DEFAULT NULL,
  `lokasi_lowongan` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` date NOT NULL,
  `expired_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_agama`
--

CREATE TABLE `master_agama` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_agama`
--

INSERT INTO `master_agama` (`id`, `agama`, `created_at`, `updated_at`) VALUES
(1, 'Islam', '2024-10-02 04:02:24', '2024-10-02 04:02:24'),
(2, 'Kristen', '2024-10-02 04:02:24', '2024-10-02 04:02:24'),
(3, 'Katolik', '2024-10-02 04:02:24', '2024-10-02 04:02:24'),
(4, 'Hindu', '2024-10-02 04:02:24', '2024-10-02 04:02:24'),
(5, 'Buddha', '2024-10-02 04:02:24', '2024-10-02 04:02:24'),
(6, 'Konghucu', '2024-10-02 04:02:24', '2024-10-02 04:02:24');

-- --------------------------------------------------------

--
-- Table structure for table `master_kegiatan`
--

CREATE TABLE `master_kegiatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kegiatan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_kegiatan`
--

INSERT INTO `master_kegiatan` (`id`, `kegiatan`, `created_at`, `updated_at`) VALUES
(1, 'Pengisian Data Diri Pelamar', '2024-10-27 22:05:26', '2024-10-27 22:55:30'),
(2, 'Wawancara dengan Kepegawaian', '2024-10-27 22:56:55', '2024-10-27 22:56:55'),
(3, 'Tes Potensi Akademik', '2024-10-27 23:51:55', '2024-10-27 23:51:55'),
(4, 'TOEFL', '2024-10-27 23:52:04', '2024-10-27 23:52:04'),
(5, 'Istirahat', '2024-10-27 23:52:11', '2024-10-27 23:52:11'),
(6, 'Wawancara dengan Kaprodi', '2024-10-27 23:52:29', '2024-10-27 23:52:29');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_04_080045_create_role_tables', 1),
(6, '2023_12_04_080125_create_role_has_users_table', 1),
(7, '2023_12_05_122850_create_departemen_table', 1),
(8, '2023_12_20_032505_create_recruitmen_table', 1),
(9, '2024_01_31_073321_create_surat_penerimaan_table', 1),
(10, '2024_02_01_100510_create_psikotes_table', 1),
(11, '2024_08_21_210938_create_lowongan_table', 1),
(12, '2024_08_22_021152_create_posisi_lamaran_table', 1),
(13, '2024_09_19_103246_create_lokasi_psikotes_table', 1),
(20, '2024_09_20_033931_create_lokasi_psikotes_table', 2),
(22, '2024_09_20_085917_add_lowongan_id_to_recruitmen', 3),
(23, '2024_09_20_090508_remove_lokasi_hadir_from_psikotes_table', 4),
(24, '2024_09_20_092519_add_kenalan_rekrutmen_lainnya_to_recruitmen', 5),
(26, '2024_09_23_024706_remove_ttl_from_table', 6),
(27, '2024_09_23_024800_add_id_posisi_lamaran_to_table', 6),
(28, '2024_09_23_064115_remove_pemohon_to_recruitmen', 7),
(29, '2024_09_23_064247_add_id_user_to_recruitmen', 8),
(30, '2024_09_25_061023_add_img_base_64_to_lowongan', 9),
(31, '2024_09_25_075024_remove_departemen_pic_to_table', 10),
(32, '2024_09_25_080503_add_id_departemen_to_recruitmen', 11),
(35, '2024_10_01_215751_add_id_departemen_to_recruitmen', 12),
(36, '2024_10_02_100622_create_master_agama_table', 13),
(37, '2024_10_02_125223_add_agama_id_to_users_table', 14),
(38, '2024_10_02_203154_add_profil_lengkap_to_users', 15),
(39, '2024_10_02_224600_add_phone_number_to_users', 16),
(40, '2024_10_03_065654_add_phone_number_pendidikan_jurusan_to_users', 17),
(41, '2024_10_03_071507_add_alasan_penerimaan_to_recruitmen', 18),
(42, '2024_10_04_033248_create_lokasi_wawancara_table', 19),
(43, '2024_10_04_034242_add_id_lokasi_wawancara_to_recruitmen', 20),
(44, '2024_10_04_064248_add_lokasi_lowongan_to_lowongan', 21),
(45, '2024_10_27_034751_add_tgl_acceptance_to_recruitmen', 22),
(46, '2024_10_28_042322_create_master_kegiatan_table', 23),
(47, '2024_10_29_042017_delete_lama_posisi_lamaran_to_posisi_lamaran', 24),
(48, '2024_10_29_042540_add_detail_to_posisi_lamaran', 25),
(49, '2024_10_30_023442_create_unit_kerja_table', 26),
(50, '2024_10_30_030027_create_status_pegawai_table', 26),
(51, '2024_11_01_031516_add_tgl_kirim_to_recruitmen', 27),
(52, '2024_11_01_040039_add_jumlah_kirim_to_recruitmen', 28),
(53, '2024_11_03_121124_add_jumlah_kirim_to_psikotes', 29),
(54, '2024_11_05_024155_add_kirim_to_surat_penerimaan', 30),
(56, '2024_11_11_114931_create_notifications_table', 31),
(57, '2024_11_12_041307_add_barcode_to_lowongan', 32);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('04cb1d5e-6454-461a-813f-7e5e84dc33cc', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":51}', NULL, '2024-12-10 23:37:43', '2024-12-10 23:37:43'),
('09988eca-5819-41b6-bcfc-33c4cd02869b', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":43}', NULL, '2024-12-10 20:05:34', '2024-12-10 20:05:34'),
('1700f3ac-92f7-4a5d-8a8e-f14bd3eeb0da', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":58}', NULL, '2024-12-12 23:26:44', '2024-12-12 23:26:44'),
('1c0dde88-6ce9-4c5a-a96e-2e6c2893133e', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":39}', NULL, '2024-12-10 18:21:03', '2024-12-10 18:21:03'),
('321b5b6e-a782-4f8b-9481-5c09dd2e976a', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":44}', NULL, '2024-12-10 20:26:17', '2024-12-10 20:26:17'),
('48b307bc-5671-4d89-9a89-984fb6f61444', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":41}', NULL, '2024-12-10 19:55:37', '2024-12-10 19:55:37'),
('548abfb7-2630-4f28-a445-5acce0dc9f1a', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":49}', NULL, '2024-12-10 21:22:50', '2024-12-10 21:22:50'),
('60bb9b13-8f96-4ae4-86d6-d24779518f67', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":60}', NULL, '2024-12-16 01:18:54', '2024-12-16 01:18:54'),
('64b74e2c-1889-4ec9-9244-4179e43925e2', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":54}', NULL, '2024-12-10 23:43:24', '2024-12-10 23:43:24'),
('82b4e15f-7372-4bb9-a4b8-3a6155f7dac5', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":46}', NULL, '2024-12-10 20:35:59', '2024-12-10 20:35:59'),
('88b52f09-279c-4081-8e54-b86551a9b8de', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":47}', NULL, '2024-12-10 21:10:38', '2024-12-10 21:10:38'),
('8afbfb8b-f702-4ea5-97d3-144f041f0ae7', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":57}', NULL, '2024-12-11 00:02:01', '2024-12-11 00:02:01'),
('9ccbce75-3221-4d76-b244-da708d4dc3e8', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":48}', NULL, '2024-12-10 21:14:20', '2024-12-10 21:14:20'),
('9e7d923a-4b06-40b9-91f6-eb74e80c95c1', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":45}', NULL, '2024-12-10 20:28:58', '2024-12-10 20:28:58'),
('a0a64aa8-253d-4032-8752-4e6100fd268c', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":59}', NULL, '2024-12-13 01:22:32', '2024-12-13 01:22:32'),
('a15ee75e-471c-4287-8221-538c053a7b4f', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":56}', NULL, '2024-12-10 23:59:22', '2024-12-10 23:59:22'),
('ad5648c6-155f-4695-a099-6b094da828c9', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":40}', NULL, '2024-12-10 19:47:33', '2024-12-10 19:47:33'),
('c30a6690-66ba-45ea-a146-7e35c4183f3d', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":42}', NULL, '2024-12-10 20:00:02', '2024-12-10 20:00:02'),
('d24f33bf-ede3-437f-a68c-2c321e9f9c1e', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":53}', NULL, '2024-12-10 23:42:23', '2024-12-10 23:42:23'),
('d46b37a6-dba1-40f6-9413-2e4b101df07c', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":52}', NULL, '2024-12-10 23:39:47', '2024-12-10 23:39:47'),
('e7db8477-729f-49df-ba9e-d97046ef89b2', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":50}', NULL, '2024-12-10 23:25:41', '2024-12-10 23:25:41'),
('eee0914f-b8eb-487b-b5fa-616c82bf8362', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":38}', NULL, '2024-11-11 20:20:31', '2024-11-11 20:20:31'),
('f4923708-1705-4b9a-bdab-34f8e59eef46', 'App\\Notifications\\DocumentSubmissionNotification', 'App\\Models\\User', 1, '{\"message\":\"Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya\",\"recruitment_id\":55}', NULL, '2024-12-10 23:49:08', '2024-12-10 23:49:08');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `status`, `created_at`, `updated_at`) VALUES
('ronjuliostagjhs21@gmail.com', '$2y$12$mzFxVgBm6ZVKbwC09lWpl.d1PBa1xw8zgMcMN4R3tMuDkMKhvKTT6', 0, '2024-12-16 07:39:29', '2024-12-16 07:45:04');

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
-- Table structure for table `posisi_lamaran`
--

CREATE TABLE `posisi_lamaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `posisi` varchar(255) NOT NULL,
  `unit_kerja` varchar(255) DEFAULT NULL,
  `status_pegawai` varchar(255) DEFAULT NULL,
  `masa_percobaan_awal` date DEFAULT NULL,
  `masa_percobaan_akhir` date DEFAULT NULL,
  `lama_masa_percobaan` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posisi_lamaran`
--

INSERT INTO `posisi_lamaran` (`id`, `posisi`, `unit_kerja`, `status_pegawai`, `masa_percobaan_awal`, `masa_percobaan_akhir`, `lama_masa_percobaan`, `created_at`, `updated_at`) VALUES
(1, 'Karyawan', 'Prodi Ilmu Informatika', 'Tenaga Kependidikan', '2025-01-01', '2025-05-01', 4, '2024-09-19 22:09:44', '2024-11-06 04:18:19'),
(2, 'Dosen', 'Prodi Ilmu Hukum', 'Dosen', '2024-11-04', '2025-04-04', 5, '2024-09-19 22:10:22', '2024-11-04 19:05:33');

-- --------------------------------------------------------

--
-- Table structure for table `psikotes`
--

CREATE TABLE `psikotes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_doku_psikotes` varchar(255) DEFAULT NULL,
  `no_doku_rektor` varchar(255) DEFAULT NULL,
  `tgl_kirim` date DEFAULT NULL,
  `pemohon_id` bigint(20) DEFAULT NULL,
  `id_rekrutmen` bigint(20) UNSIGNED DEFAULT NULL,
  `jumlah_kirim` int(11) NOT NULL DEFAULT 0,
  `lokasi_psikotes_id` bigint(20) UNSIGNED NOT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `tgl_hadir` date DEFAULT NULL,
  `jam_hadir` time DEFAULT NULL,
  `link_psikotes` varchar(255) DEFAULT NULL,
  `status_approval` enum('pending','approved','rejected') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recruitmen`
--

CREATE TABLE `recruitmen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_doku` varchar(255) DEFAULT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `tgl_kirim` date DEFAULT NULL,
  `jumlah_kirim` int(11) NOT NULL DEFAULT 0,
  `id_users` bigint(20) UNSIGNED NOT NULL,
  `alasan_penerimaan` text DEFAULT NULL,
  `id_lokasi_wawancara` bigint(20) UNSIGNED DEFAULT NULL,
  `CV_base_64` longtext DEFAULT NULL,
  `transkrip_nilai_base_64` longtext DEFAULT NULL,
  `tgl_hadir` date DEFAULT NULL,
  `jam_hadir` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`jam_hadir`)),
  `jam_selesai` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`jam_selesai`)),
  `kegiatan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`kegiatan`)),
  `is_edited` enum('true','false') DEFAULT 'true',
  `status_approval` enum('submitted','pending','approved','rejected') DEFAULT 'submitted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kenalan` varchar(255) DEFAULT NULL,
  `kenalan_rekrutmen_lainnya` varchar(255) DEFAULT NULL,
  `lowongan_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Pelamar', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_users`
--

CREATE TABLE `role_has_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fk_role` bigint(20) UNSIGNED NOT NULL,
  `fk_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_users`
--

INSERT INTO `role_has_users` (`id`, `fk_role`, `fk_user`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-09-27 04:21:08', '2024-09-27 04:21:03');

-- --------------------------------------------------------

--
-- Table structure for table `status_pegawai`
--

CREATE TABLE `status_pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_pegawai`
--

INSERT INTO `status_pegawai` (`id`, `nama_status`, `created_at`, `updated_at`) VALUES
(1, 'Dosen', '2024-10-31 05:09:19', '2024-10-31 05:45:13'),
(2, 'Tenaga Kependidikan', '2024-11-04 04:42:52', '2024-11-04 04:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `surat_penerimaan`
--

CREATE TABLE `surat_penerimaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_doku` varchar(255) DEFAULT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `tgl_kirim` date DEFAULT NULL,
  `jumlah_kirim` int(11) NOT NULL DEFAULT 0,
  `rekrutmen_id` bigint(20) UNSIGNED NOT NULL,
  `id_posisi_lamaran` bigint(20) UNSIGNED NOT NULL,
  `tgl_kerja` date DEFAULT NULL,
  `status_penerimaan` enum('true','false') DEFAULT 'false',
  `status_approval` enum('pending','approved','rejected') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_kerja`
--

CREATE TABLE `unit_kerja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_unit_kerja` varchar(255) DEFAULT NULL,
  `kode_unit` varchar(255) DEFAULT NULL,
  `id_departemen` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_kerja`
--

INSERT INTO `unit_kerja` (`id`, `nama_unit_kerja`, `kode_unit`, `id_departemen`, `created_at`, `updated_at`) VALUES
(2, 'Prodi Ilmu Informatika', 'Prodi Informatika', 7, '2024-11-06 04:18:03', '2024-11-06 04:18:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `NIP` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('P','W') DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `profil_lengkap` tinyint(1) NOT NULL DEFAULT 0,
  `phone_number` varchar(255) DEFAULT NULL,
  `universitas` varchar(255) DEFAULT NULL,
  `pendidikan` varchar(255) DEFAULT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `id_agama` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `NIP`, `tempat_lahir`, `tgl_lahir`, `email`, `email_verified_at`, `password`, `gender`, `alamat`, `profil_lengkap`, `phone_number`, `universitas`, `pendidikan`, `jurusan`, `id_agama`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Kepala BAU', '0020536', NULL, NULL, 'bau@ukdc.ac.id', NULL, '$2y$12$ouDG/8xAsd2OFhJBVilVfuh32LWtKNvdKSS4VaH/YlEOfzJQ9Gihi', 'W', NULL, 1, NULL, NULL, NULL, NULL, 2, 0, NULL, '2024-02-03 11:21:51', '2024-11-11 19:40:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `lokasi_psikotes`
--
ALTER TABLE `lokasi_psikotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi_wawancara`
--
ALTER TABLE `lokasi_wawancara`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_agama`
--
ALTER TABLE `master_agama`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `master_agama_agama_unique` (`agama`);

--
-- Indexes for table `master_kegiatan`
--
ALTER TABLE `master_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

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
-- Indexes for table `posisi_lamaran`
--
ALTER TABLE `posisi_lamaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `psikotes`
--
ALTER TABLE `psikotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psikotes_lokasi_psikotes_id_unique` (`lokasi_psikotes_id`) USING BTREE,
  ADD KEY `psikotes_id_rekrutmen_foreign` (`id_rekrutmen`);

--
-- Indexes for table `recruitmen`
--
ALTER TABLE `recruitmen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recruitmen_id_users_unique` (`id_users`),
  ADD KEY `recruitmen_lowongan_id_unique` (`lowongan_id`) USING BTREE,
  ADD KEY `recruitmen_id_lokasi_wawancara_foreign` (`id_lokasi_wawancara`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_users`
--
ALTER TABLE `role_has_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_has_users_fk_user_unique` (`fk_user`),
  ADD KEY `role_has_users_fk_role_unique` (`fk_role`) USING BTREE;

--
-- Indexes for table `status_pegawai`
--
ALTER TABLE `status_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_penerimaan`
--
ALTER TABLE `surat_penerimaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_penerimaan_rekrutmen_id_foreign` (`rekrutmen_id`),
  ADD KEY `surat_penerimaan_id_lokasi_psikotes_unique` (`id_posisi_lamaran`) USING BTREE;

--
-- Indexes for table `unit_kerja`
--
ALTER TABLE `unit_kerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_kerja_id_departemen_foreign` (`id_departemen`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_agama_foreign` (`id_agama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lokasi_psikotes`
--
ALTER TABLE `lokasi_psikotes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lokasi_wawancara`
--
ALTER TABLE `lokasi_wawancara`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `master_agama`
--
ALTER TABLE `master_agama`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_kegiatan`
--
ALTER TABLE `master_kegiatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posisi_lamaran`
--
ALTER TABLE `posisi_lamaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `psikotes`
--
ALTER TABLE `psikotes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `recruitmen`
--
ALTER TABLE `recruitmen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_has_users`
--
ALTER TABLE `role_has_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `status_pegawai`
--
ALTER TABLE `status_pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `surat_penerimaan`
--
ALTER TABLE `surat_penerimaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `unit_kerja`
--
ALTER TABLE `unit_kerja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `psikotes`
--
ALTER TABLE `psikotes`
  ADD CONSTRAINT `psikotes_id_rekrutmen_foreign` FOREIGN KEY (`id_rekrutmen`) REFERENCES `recruitmen` (`id`),
  ADD CONSTRAINT `psikotes_lokasi_psikotes_id_foreign` FOREIGN KEY (`lokasi_psikotes_id`) REFERENCES `lokasi_psikotes` (`id`);

--
-- Constraints for table `recruitmen`
--
ALTER TABLE `recruitmen`
  ADD CONSTRAINT `recruitmen_id_lokasi_wawancara_foreign` FOREIGN KEY (`id_lokasi_wawancara`) REFERENCES `lokasi_wawancara` (`id`),
  ADD CONSTRAINT `recruitmen_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `recruitmen_lowongan_id_foreign` FOREIGN KEY (`lowongan_id`) REFERENCES `lowongan` (`id`);

--
-- Constraints for table `role_has_users`
--
ALTER TABLE `role_has_users`
  ADD CONSTRAINT `role_has_users_fk_role_foreign` FOREIGN KEY (`fk_role`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `role_has_users_fk_user_foreign` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `surat_penerimaan`
--
ALTER TABLE `surat_penerimaan`
  ADD CONSTRAINT `surat_penerimaan_id_lokasi_psikotes_foreign` FOREIGN KEY (`id_posisi_lamaran`) REFERENCES `posisi_lamaran` (`id`),
  ADD CONSTRAINT `surat_penerimaan_rekrutmen_id_foreign` FOREIGN KEY (`rekrutmen_id`) REFERENCES `recruitmen` (`id`);

--
-- Constraints for table `unit_kerja`
--
ALTER TABLE `unit_kerja`
  ADD CONSTRAINT `unit_kerja_id_departemen_foreign` FOREIGN KEY (`id_departemen`) REFERENCES `departemen` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_agama_foreign` FOREIGN KEY (`id_agama`) REFERENCES `master_agama` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
