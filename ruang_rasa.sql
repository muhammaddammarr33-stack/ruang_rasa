-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2025 at 11:37 AM
-- Server version: 12.1.2-MariaDB
-- PHP Version: 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ruang_rasa`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(150) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

CREATE TABLE `analytics` (
  `id` int(11) NOT NULL,
  `metric` varchar(100) DEFAULT NULL,
  `value` decimal(12,2) DEFAULT NULL,
  `recorded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `api_integrations`
--

CREATE TABLE `api_integrations` (
  `id` int(11) NOT NULL,
  `service_name` varchar(100) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `endpoint` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Ulang Tahun', 'Kado spesial untuk merayakan hari jadi. Sub-kategori: Ulang Tahun Anak, Ulang Tahun Dewasa, Ulang Tahun Pernikahan.', '2025-11-25 12:27:56'),
(2, 'Hari Raya & Idul Fitri (Lebaran)', 'Pilihan untuk menyambut hari kemenangan. Sub-kategori: Hampers Lebaran, Perlengkapan Ibadah, Kue Kering & Parsel Makanan.', '2025-11-25 12:27:56'),
(3, 'Natal & Tahun Baru', 'Kado dan dekorasi untuk memeriahkan akhir tahun. Sub-kategori: Dekorasi Natal, Kado Tukar (Secret Santa), Lilin Aroma & Paket Liburan.', '2025-11-25 12:27:56'),
(4, 'Hari Kasih Sayang (Valentine)', 'Ungkapan cinta sejati. Sub-kategori: Kado Romantis, Cokelat & Bunga, Perhiasan Pasangan.', '2025-11-25 12:27:56'),
(5, 'Hari Ibu & Hari Ayah', 'Kado penghargaan terbaik untuk orang tua tercinta.', '2025-11-25 12:27:56'),
(6, 'Wisuda & Kelulusan', 'Hadiah untuk merayakan pencapaian akademis.', '2025-11-25 12:27:56'),
(7, 'Pernikahan & Tunangan', 'Kado terbaik untuk mengawali hidup baru pasangan.', '2025-11-25 12:27:56'),
(8, 'Syukuran Bayi & Kelahiran', 'Kado untuk menyambut kedatangan anggota keluarga baru.', '2025-11-25 12:27:56'),
(9, 'Ucapan Terima Kasih (Corporate Gift/Souvenir)', 'Hadiah formal atau cenderamata untuk kolega dan relasi.', '2025-11-25 12:27:56'),
(10, 'Tahun Baru Imlek', 'Kado khas untuk merayakan Tahun Baru Cina. Sub-kategori: Angpao, Dekorasi Khas Imlek.', '2025-11-25 12:27:56'),
(11, 'Teknologi & Gadget', 'Aksesoris Ponsel, Earphone, Smartwatch, dan teknologi terbaru lainnya.', '2025-11-25 12:27:56'),
(12, 'Fashion & Aksesori', 'Dompet, Jam Tangan, Tas, Perhiasan, dan item pelengkap gaya.', '2025-11-25 12:27:56'),
(13, 'Memasak & Dapur (Kuliner)', 'Peralatan Unik, Buku Resep, Apron, dan perlengkapan untuk para chef amatir.', '2025-11-25 12:27:56'),
(14, 'Olahraga & Kebugaran', 'Botol Minum Stylish, Matras Yoga, Pakaian Olahraga, dan perlengkapan untuk menjaga kesehatan.', '2025-11-25 12:27:56'),
(15, 'Membaca & Menulis', 'Buku Terlaris, Jurnal Kulit, Alat Tulis Premium, dan kit untuk hobi literasi.', '2025-11-25 12:27:56'),
(16, 'Seni & Kerajinan (DIY)', 'Perlengkapan Lukis, Kit Rajut, Buku Mewarnai Dewasa, dan segala kebutuhan kreativitas.', '2025-11-25 12:27:56'),
(17, 'Musik & Hiburan', 'Speaker Portabel, Piringan Hitam, Tiket/Voucher, dan item untuk hiburan.', '2025-11-25 12:27:56'),
(18, 'Travel & Petualangan', 'Tas Ransel, Bantal Leher, Organizer Koper, dan perlengkapan traveling.', '2025-11-25 12:27:56'),
(19, 'Gaming', 'Merchandise Game, Aksesori Gaming, Voucher Game, dan kebutuhan para gamer.', '2025-11-25 12:27:56'),
(20, 'Kecantikan & Perawatan Diri', 'Skincare Set, Parfum, Alat Make-up, dan produk self-care.', '2025-11-25 12:27:56'),
(21, 'Untuk Wanita (Ibu, Istri, Pacar)', 'Pilihan kado terbaik yang disukai wanita dari segala usia.', '2025-11-25 12:27:56'),
(22, 'Untuk Pria (Ayah, Suami, Pacar)', 'Pilihan kado yang fungsional dan cocok untuk pria.', '2025-11-25 12:27:56'),
(23, 'Untuk Anak-anak & Balita', 'Mainan edukatif dan kado lucu untuk si kecil.', '2025-11-25 12:27:56'),
(24, 'Untuk Remaja', 'Kado trendi dan sesuai gaya hidup anak muda.', '2025-11-25 12:27:56'),
(25, 'Untuk Pasangan (Couple)', 'Kado yang bisa digunakan atau dinikmati berdua.', '2025-11-25 12:27:56'),
(26, 'Untuk Rekan Kerja & Atasan', 'Pilihan profesional dan sopan untuk hubungan kerja.', '2025-11-25 12:27:56'),
(27, 'Kado Best Seller (Terlaris)', 'Kumpulan produk yang paling banyak dibeli oleh pelanggan lain.', '2025-11-25 12:27:56'),
(28, 'Kado di Bawah Rp 100 Ribu (Affordable)', 'Kado berkualitas dengan harga yang ramah di kantong.', '2025-11-25 12:27:56'),
(29, 'Hampers & Paket Kado', 'Paket siap kirim yang praktis dan elegan.', '2025-11-25 12:27:56'),
(30, 'Kado Personal (Custom & Nama)', 'Produk yang bisa dicustom dengan nama atau pesan khusus (Fitur utama web).', '2025-11-25 12:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient` varchar(50) DEFAULT NULL,
  `status` enum('submitted','in_progress','suggested','completed') DEFAULT 'submitted',
  `last_read_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `occasion` varchar(50) DEFAULT NULL,
  `age_range` varchar(20) DEFAULT NULL,
  `interests` text DEFAULT NULL,
  `budget_range` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `user_id`, `recipient`, `status`, `last_read_at`, `created_at`, `occasion`, `age_range`, `interests`, `budget_range`) VALUES
(1, 7, 'Konsultasi Langsung', 'completed', '2025-11-25 21:51:50', '2025-11-25 14:35:35', 'Tanpa Acara', '', '[]', ''),
(2, 7, 'Pasangan', 'suggested', NULL, '2025-11-25 14:37:26', 'Ulang Tahun', '13-17', '[\"Teknologi\"]', '100-300rb'),
(3, 5, 'Konsultasi Langsung', 'completed', '2025-11-25 21:11:44', '2025-11-25 19:31:12', 'Tanpa Acara', '', '[]', ''),
(4, 4, 'Konsultasi Langsung', 'suggested', '2025-11-26 04:14:12', '2025-11-25 21:21:10', 'Tanpa Acara', '', '[]', ''),
(5, 4, 'Pasangan', 'completed', '2025-11-25 21:49:05', '2025-11-25 21:40:38', 'Ulang Tahun', '18-25', '[\"Membaca\"]', '100-300rb'),
(6, 4, 'Pasangan', 'completed', '2025-11-25 21:50:48', '2025-11-25 21:42:55', 'Ulang Tahun', '18-25', '[\"Membaca\"]', '100-300rb'),
(7, 7, 'Orang Tua', 'completed', '2025-11-26 04:13:39', '2025-11-25 22:03:26', 'Lebaran', '26-40', '[\"Membaca\",\"Memasak\"]', '100-300rb'),
(8, 6, 'Anak', 'suggested', NULL, '2025-11-26 07:02:02', 'Ulang Tahun', '<12', '[\"Seni\"]', '100-300rb'),
(9, 8, 'Pasangan', 'in_progress', '2025-11-26 16:10:17', '2025-11-26 16:08:44', 'Ulang Tahun', '13-17', '[\"Membaca\"]', '100-300rb');

-- --------------------------------------------------------

--
-- Table structure for table `consultation_feedback`
--

CREATE TABLE `consultation_feedback` (
  `id` int(11) NOT NULL,
  `consultation_id` int(11) NOT NULL,
  `satisfaction` enum('satisfied','unsatisfied') DEFAULT NULL,
  `follow_up` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation_feedback`
--

INSERT INTO `consultation_feedback` (`id`, `consultation_id`, `satisfaction`, `follow_up`, `created_at`) VALUES
(1, 6, 'unsatisfied', 1, '2025-11-25 21:43:04'),
(2, 6, 'satisfied', 0, '2025-11-25 21:43:09'),
(3, 9, 'unsatisfied', 1, '2025-11-26 16:09:34'),
(4, 9, 'unsatisfied', 1, '2025-11-26 16:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `consultation_messages`
--

CREATE TABLE `consultation_messages` (
  `id` int(11) NOT NULL,
  `consultation_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `message_type` enum('text','product') DEFAULT 'text',
  `product_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation_messages`
--

INSERT INTO `consultation_messages` (`id`, `consultation_id`, `sender_id`, `message`, `message_type`, `product_id`, `created_at`) VALUES
(1, 1, 7, 'Assalamualaikum', 'text', NULL, '2025-11-25 14:35:47'),
(2, 1, 7, 'Assalamualaikum', 'text', NULL, '2025-11-25 14:35:52'),
(3, 1, 7, 'misal kita udah nulis panjang ini tenang aja pesannya kesimpen kok', 'text', NULL, '2025-11-25 14:36:24'),
(4, 3, 5, 'belum sanggup untuk jauh darimu', 'text', NULL, '2025-11-25 21:09:53'),
(5, 3, 5, 'yang masih selalu ada dalam hatimu', 'text', NULL, '2025-11-25 21:10:04'),
(6, 3, 1, 'Bingkai Waktu Berputar (Custom Date)', 'product', 1, '2025-11-25 21:10:36'),
(7, 3, 1, 'ternyata belum siap diriku', 'text', NULL, '2025-11-25 21:11:04'),
(8, 3, 1, 'kehilangan dirimu', 'text', NULL, '2025-11-25 21:11:11'),
(9, 5, 4, 'hai admin', 'text', NULL, '2025-11-25 21:49:11'),
(10, 5, 4, 'aku yang jatuh cinta', 'text', NULL, '2025-11-25 21:49:29'),
(11, 5, 4, 'haruskah aku beri kesempatan ingin jadi kekasih yang baik berikan aku kesempatan', 'text', NULL, '2025-11-25 21:49:52'),
(12, 5, 4, 'maukan dirimu tahukah hatimu berulang ku ketuk aku mencinta mu', 'text', NULL, '2025-11-25 21:50:12'),
(13, 1, 1, 'oke ini untuk kamu cocok banget fix', 'text', NULL, '2025-11-25 21:51:20'),
(14, 1, 1, 'Buku Cerita Bergambar Interaktif', 'product', 46, '2025-11-25 21:51:26'),
(15, 7, 7, 'Assalamualaikum', 'text', NULL, '2025-11-25 22:06:33'),
(16, 7, 7, 'beri aku rekomendasi dong', 'text', NULL, '2025-11-25 22:06:49'),
(17, 7, 7, 'jadi aku punya pacar yang blablablablablalbalbalblalbalbalbla', 'text', NULL, '2025-11-25 22:07:16'),
(18, 7, 1, 'okee2', 'text', NULL, '2025-11-25 22:07:43'),
(19, 7, 1, 'aku saranin kamu beli ini karena pasti dia bakal suka dan jadi balbalblablablalb', 'text', NULL, '2025-11-25 22:08:05'),
(20, 7, 1, 'Surat Rindu Botol Kaca (Pre-Sealed)', 'product', 7, '2025-11-25 22:08:17'),
(21, 4, 1, 'ya ada yang bisa saya bantu', 'text', NULL, '2025-11-26 04:14:16'),
(22, 4, 1, 'Gantungan Kunci Pesan Rahasia', 'product', 56, '2025-11-26 04:14:20'),
(23, 9, 8, 'hai admin', 'text', NULL, '2025-11-26 16:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `consultation_suggestions`
--

CREATE TABLE `consultation_suggestions` (
  `id` int(11) NOT NULL,
  `consultation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation_suggestions`
--

INSERT INTO `consultation_suggestions` (`id`, `consultation_id`, `product_id`, `reason`, `created_at`) VALUES
(1, 2, 1, 'Produk cocok dengan budget dan preferensi Anda.', '2025-11-25 14:37:26'),
(2, 2, 8, 'Produk cocok dengan budget dan preferensi Anda.', '2025-11-25 14:37:26'),
(3, 2, 13, 'Produk cocok dengan budget dan preferensi Anda.', '2025-11-25 14:37:26'),
(4, 5, 55, 'Direkomendasikan untuk penerima dengan budget .', '2025-11-25 21:40:38'),
(6, 5, 53, 'Direkomendasikan untuk penerima dengan budget .', '2025-11-25 21:40:38'),
(7, 6, 55, 'Direkomendasikan untuk penerima dengan budget .', '2025-11-25 21:42:55'),
(9, 6, 53, 'Direkomendasikan untuk penerima dengan budget .', '2025-11-25 21:42:55'),
(10, 7, 55, 'Direkomendasikan untuk penerima dengan budget .', '2025-11-25 22:03:26'),
(12, 7, 53, 'Direkomendasikan untuk penerima dengan budget .', '2025-11-25 22:03:26'),
(13, 4, 2, 'Karena ini kado yang sangat cocok dari segi manapun\r\n', '2025-11-26 04:15:05'),
(14, 8, 55, 'Direkomendasikan untuk penerima dengan budget .', '2025-11-26 07:02:02'),
(16, 8, 53, 'Direkomendasikan untuk penerima dengan budget .', '2025-11-26 07:02:02'),
(17, 9, 55, 'Direkomendasikan untuk penerima dengan budget .', '2025-11-26 16:08:44'),
(19, 9, 53, 'Direkomendasikan untuk penerima dengan budget .', '2025-11-26 16:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `custom_orders`
--

CREATE TABLE `custom_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `custom_text` varchar(500) DEFAULT NULL,
  `font_style` varchar(50) DEFAULT 'normal',
  `text_color` varchar(20) DEFAULT '#000000',
  `packaging_type` varchar(100) DEFAULT NULL,
  `ribbon_color` varchar(20) DEFAULT NULL,
  `special_instructions` text DEFAULT NULL,
  `status` enum('draft','added_to_cart','ordered') DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_orders`
--

INSERT INTO `custom_orders` (`id`, `user_id`, `product_id`, `order_id`, `custom_text`, `font_style`, `text_color`, `packaging_type`, `ribbon_color`, `special_instructions`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 11, 56, 'Selamat wisuda sayang!', 'handwritten', '#000000', 'box', '#ffa200', 'Tulis di bagian dalam kado', 'ordered', '2025-11-25 21:19:07', '2025-11-25 21:19:58');

-- --------------------------------------------------------

--
-- Table structure for table `external_logs`
--

CREATE TABLE `external_logs` (
  `id` int(11) NOT NULL,
  `integration_id` int(11) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ldr_orders`
--

CREATE TABLE `ldr_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `secret_message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tier` enum('basic','silver','gold','platinum') DEFAULT 'basic',
  `points` int(11) DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `user_id`, `tier`, `points`, `updated_at`) VALUES
(1, 5, 'basic', 35, '2025-11-25 21:13:11'),
(2, 4, 'basic', 930, '2025-12-02 17:08:24'),
(3, 7, 'basic', 57, '2025-11-25 22:16:56'),
(4, 8, 'basic', 13, '2025-11-26 16:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `subscribed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `payment_method` enum('cod','transfer','ewallet','gateway') DEFAULT 'transfer',
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `order_status` enum('waiting','processing','shipped','completed','cancelled') DEFAULT 'waiting',
  `shipping_address` text DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `refund_amount` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `shipping_address`, `tracking_number`, `created_at`, `updated_at`, `cancel_reason`, `refund_amount`) VALUES
(1, 3, 20000.00, 'transfer', 'paid', 'completed', 'Perumahan satelit asri 9b no 5 Singaraja Bali', NULL, '2025-11-10 10:51:59', NULL, NULL, 0),
(2, 3, 100000.00, 'ewallet', 'paid', 'completed', 'Jalan jeruk gang at taubah', NULL, '2025-11-10 13:40:37', NULL, NULL, 0),
(3, 2, 100000.00, 'transfer', 'paid', 'completed', 'Jalan kedinding lor gang tanjung no 5', NULL, '2025-11-11 00:53:56', NULL, NULL, 0),
(4, 3, 40000.00, 'transfer', 'paid', 'processing', 'Jalan kenjeran', NULL, '2025-11-11 04:04:48', NULL, NULL, 0),
(5, 3, 20000.00, 'transfer', 'paid', 'processing', 'cikini', NULL, '2025-11-11 04:23:54', NULL, NULL, 0),
(6, 3, 20000.00, 'transfer', 'paid', 'processing', 'Jalan hasanudin no 20a', NULL, '2025-11-11 04:36:19', NULL, NULL, 0),
(7, 3, 20000.00, 'transfer', 'paid', 'processing', 'Jalan bogor gai', NULL, '2025-11-12 03:23:47', NULL, NULL, 0),
(8, 3, 100000.00, 'transfer', 'paid', 'processing', 'Jalan selatan maju', NULL, '2025-11-12 03:25:23', NULL, NULL, 0),
(9, 3, 20000.00, 'transfer', 'paid', 'processing', 'Jalan at taubah', NULL, '2025-11-12 03:39:24', NULL, NULL, 0),
(10, 16, 315000.00, 'transfer', 'pending', 'waiting', 'Jalan jalak putih', NULL, '2025-11-13 16:59:18', NULL, NULL, 0),
(11, 18, 250000.00, 'ewallet', 'pending', 'waiting', 'jalan kamal no 5', NULL, '2025-11-13 18:19:14', NULL, NULL, 0),
(12, 18, 250000.00, 'ewallet', 'pending', 'waiting', 'jalan kamal no 5', NULL, '2025-11-13 18:36:47', NULL, NULL, 0),
(13, 18, 315000.00, 'ewallet', 'pending', 'waiting', 'Jalan kamal no 5', NULL, '2025-11-13 18:38:06', NULL, NULL, 0),
(14, 16, 315000.00, 'cod', 'pending', 'waiting', 'Jalan gang buntu no 8', NULL, '2025-11-13 19:27:13', NULL, NULL, 0),
(15, 18, 100000.00, 'cod', 'pending', 'waiting', 'jalan kamal no 6', NULL, '2025-11-13 20:13:34', NULL, NULL, 0),
(16, 18, 315000.00, 'cod', 'pending', 'waiting', 'jalan kamal', NULL, '2025-11-13 20:23:49', NULL, NULL, 0),
(17, 18, 315000.00, 'cod', 'pending', 'waiting', 'jalan kemal 5', NULL, '2025-11-13 20:32:12', NULL, NULL, 0),
(18, 18, 299250.00, 'cod', 'pending', 'waiting', 'jalan kamal no 5', NULL, '2025-11-13 20:55:28', NULL, NULL, 0),
(19, 18, 114000.00, 'cod', 'pending', 'waiting', 'jalan kamal no 5', NULL, '2025-11-13 20:56:27', NULL, NULL, 0),
(20, 18, 90250.00, 'cod', 'pending', 'waiting', 'jalan kamal no 5', NULL, '2025-11-13 21:27:52', NULL, NULL, 0),
(21, 18, 315000.00, 'cod', 'pending', 'waiting', 'jalan kamal no 5', NULL, '2025-11-14 04:18:04', NULL, NULL, 0),
(22, 16, 315000.00, 'cod', 'pending', 'waiting', 'Jalan buntu no 8', NULL, '2025-11-14 06:58:12', NULL, NULL, 0),
(23, 16, 114000.00, 'cod', 'pending', 'waiting', 'jalan buntu np 8', NULL, '2025-11-14 07:32:20', NULL, NULL, 0),
(24, 16, 315000.00, 'cod', 'pending', 'waiting', 'Jalan buntu no 9', NULL, '2025-11-14 10:05:37', NULL, NULL, 0),
(25, 16, 630000.00, 'cod', 'pending', 'waiting', 'Jalan Mawar no 5', NULL, '2025-11-14 13:47:01', NULL, NULL, 0),
(26, 16, 945000.00, 'cod', 'pending', 'waiting', 'Jalan mawar', NULL, '2025-11-14 14:24:11', NULL, NULL, 0),
(27, 16, 315000.00, 'cod', 'pending', 'waiting', 'Jalan Mawar', NULL, '2025-11-14 15:16:57', NULL, NULL, 0),
(28, 16, 315000.00, 'transfer', 'pending', 'waiting', 'Jalan mawar', NULL, '2025-11-14 15:35:00', NULL, NULL, 0),
(29, 16, 114000.00, 'ewallet', 'pending', 'processing', 'jalan mawar no 5', NULL, '2025-11-14 17:05:08', '2025-11-14 17:15:35', NULL, 0),
(30, 16, 266000.00, 'cod', 'pending', 'shipped', 'Jalan mawar no 10', NULL, '2025-11-14 17:17:11', '2025-11-15 09:36:28', NULL, 0),
(31, 16, 237500.00, 'ewallet', 'failed', 'cancelled', 'JAlan mawar', NULL, '2025-11-14 17:28:17', '2025-11-15 13:08:45', NULL, 0),
(32, 18, 95000.00, 'ewallet', 'refunded', 'cancelled', 'Jalan Mawar no 12', NULL, '2025-11-14 18:08:42', '2025-11-15 16:05:39', 'Dikarenakan operasional', 50000),
(33, 18, 190000.00, 'transfer', 'failed', 'cancelled', 'Jalan Mawar no 12', NULL, '2025-11-15 04:27:26', '2025-11-15 13:08:04', NULL, 0),
(34, 18, 90250.00, 'ewallet', 'paid', 'processing', 'Jalan Mawar no 12', NULL, '2025-11-15 19:49:00', '2025-11-15 19:51:23', NULL, 0),
(35, 18, 315000.00, 'cod', 'pending', 'waiting', 'Jalan Mawar no 12', NULL, '2025-11-15 21:49:55', NULL, NULL, 0),
(36, 18, 90250.00, 'cod', 'pending', 'waiting', 'Jalan MAwar no 12', NULL, '2025-11-16 10:03:42', NULL, NULL, 0),
(37, 1, 315000.00, 'cod', 'pending', 'waiting', 'Jalan Mawar', NULL, '2025-11-17 07:46:26', NULL, NULL, 0),
(38, 18, 315000.00, 'cod', 'pending', 'waiting', 'Jalan Mawar no 10', NULL, '2025-11-17 11:04:27', NULL, NULL, 0),
(39, 18, 90250.00, 'cod', 'pending', 'waiting', 'jgfhghf', NULL, '2025-11-17 15:45:21', NULL, NULL, 0),
(40, 18, 400000.00, 'cod', 'pending', 'waiting', 'Jalan mawar', NULL, '2025-11-18 10:01:30', NULL, NULL, 0),
(41, 18, 90250.00, 'cod', 'pending', 'waiting', 'Jalan maawra 10', NULL, '2025-11-18 10:25:46', NULL, NULL, 0),
(42, 18, 430250.00, 'cod', 'pending', 'waiting', 'Jalan maawra 10', NULL, '2025-11-18 10:45:06', NULL, NULL, 0),
(43, 18, 455250.00, 'cod', 'paid', 'processing', 'Jalan Mawar no 10', NULL, '2025-11-18 10:45:53', '2025-11-18 10:46:46', NULL, 0),
(44, 18, 222750.00, 'ewallet', 'paid', 'processing', 'Jalan Mawar no 15', NULL, '2025-11-18 10:52:58', '2025-11-18 10:53:57', NULL, 0),
(45, 18, 165250.00, 'transfer', 'paid', 'processing', 'Jalan Mawar', NULL, '2025-11-18 10:58:24', '2025-11-18 10:58:50', NULL, 0),
(46, 18, 234000.00, 'transfer', 'paid', 'processing', 'Jalan Mawar no 10, DENDANG, TANJUNG JABUNG TIMUR, JAMBI', NULL, '2025-11-18 12:39:42', '2025-11-18 12:40:20', NULL, 0),
(47, 18, 288000.00, 'transfer', 'paid', 'processing', 'Jalan Mawar no 10, BULELENG, BULELENG, BALI', NULL, '2025-11-18 14:18:21', '2025-11-18 14:18:48', NULL, 0),
(48, 18, 181250.00, 'transfer', 'pending', 'waiting', 'Jalan Mawar, BANDUNGAN, SEMARANG, JAWA TENGAH', NULL, '2025-11-18 14:28:09', NULL, NULL, 0),
(49, 18, 223000.00, 'cod', 'paid', 'processing', 'Jalan Mawar no 10, MAOSPATI, MAGETAN, JAWA TIMUR', NULL, '2025-11-18 14:28:45', '2025-11-18 14:29:28', NULL, 0),
(50, 17, 208000.00, 'transfer', 'pending', 'waiting', 'Jalan jalak putih 5 no 7, BULELENG, BULELENG, BALI', NULL, '2025-11-20 15:16:18', '2025-11-20 15:18:09', NULL, 0),
(51, 18, 279000.00, 'ewallet', 'pending', 'waiting', 'Jalan buntu no 10, BEKASI BARAT, BEKASI, JAWA BARAT', NULL, '2025-11-20 15:22:58', '2025-11-20 15:24:23', NULL, 0),
(52, 18, 240000.00, 'ewallet', 'paid', 'processing', 'Jalan Mawar no 10, PRAYA TIMUR, LOMBOK TENGAH, NUSA TENGGARA BARAT (NTB)', NULL, '2025-11-24 12:30:52', '2025-11-24 12:31:20', NULL, 0),
(53, 18, 403000.00, 'ewallet', 'paid', 'processing', 'Jalan Mawar no 10, BULELENG, BULELENG, BALI', NULL, '2025-11-24 16:04:53', '2025-11-24 16:05:23', NULL, 0),
(54, 1, 208000.00, 'ewallet', 'paid', 'processing', 'Jalan Mawar no 12, BULELENG, BULELENG, BALI', NULL, '2025-11-25 09:00:47', '2025-11-25 09:01:30', NULL, 0),
(55, 5, 355000.00, 'ewallet', 'paid', 'processing', 'Jalan Mawar no 12 gedung lantai 5, KEMAYORAN, JAKARTA PUSAT, DKI JAKARTA', NULL, '2025-11-25 21:12:28', '2025-11-25 21:13:11', NULL, 0),
(56, 4, 195000.00, 'ewallet', 'paid', 'processing', 'Jalan Mawar Jingga no 15 blok 22, KEBON JERUK, JAKARTA BARAT, DKI JAKARTA', NULL, '2025-11-25 21:19:58', '2025-11-25 21:20:24', NULL, 0),
(57, 7, 163000.00, 'ewallet', 'paid', 'processing', 'Jalan Jalak putih gang V no 12, BULELENG, BULELENG, BALI', NULL, '2025-11-25 21:52:37', '2025-11-25 21:53:24', NULL, 0),
(58, 7, 180000.00, 'ewallet', 'paid', 'processing', 'Jalan Melati gang VI no 5, MIJEN, SEMARANG, JAWA TENGAH', NULL, '2025-11-25 22:04:23', '2025-11-25 22:04:58', NULL, 0),
(59, 7, 238000.00, 'ewallet', 'paid', 'processing', 'Jalan Jalak putih gang V no 12, BULELENG, BULELENG, BALI', NULL, '2025-11-25 22:16:24', '2025-11-25 22:16:56', NULL, 0),
(60, 8, 134000.00, 'ewallet', 'paid', 'processing', 'Jalan Mawar no 15, KENJERAN, SURABAYA, JAWA TIMUR', NULL, '2025-11-26 16:07:01', '2025-11-26 16:07:30', NULL, 0),
(61, 8, 400000.00, 'transfer', 'pending', 'waiting', 'Jalan Mawar no 12, BULELENG, Kota BULELENG, BALI', NULL, '2025-11-26 21:03:05', NULL, NULL, 0),
(62, 4, 5870000.00, 'ewallet', 'paid', 'processing', 'Jl sono an dikit ada gang, PURWOKERTO UTARA, Kota BANYUMAS, JAWA TENGAH', NULL, '2025-12-02 16:50:49', '2025-12-02 17:07:12', NULL, 0),
(63, 4, 3245000.00, 'ewallet', 'paid', 'processing', 'Jl jalan dikit, PULAU LAUT BARAT, Kota KOTABARU, KALIMANTAN SELATAN', NULL, '2025-12-02 17:08:07', '2025-12-02 17:08:24', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(1, 1, 2, 1, 20000.00, 20000.00),
(2, 2, 1, 1, 100000.00, 100000.00),
(3, 3, 1, 1, 100000.00, 100000.00),
(4, 4, 2, 1, 20000.00, 20000.00),
(5, 4, 2, 1, 20000.00, 20000.00),
(6, 5, 2, 1, 20000.00, 20000.00),
(7, 6, 2, 1, 20000.00, 20000.00),
(8, 7, 2, 1, 20000.00, 20000.00),
(9, 8, 1, 1, 100000.00, 100000.00),
(10, 9, 2, 1, 20000.00, 20000.00),
(11, 10, 5, 1, 315000.00, 315000.00),
(12, 11, 1, 1, 250000.00, 250000.00),
(13, 12, 1, 1, 250000.00, 250000.00),
(14, 13, 5, 1, 315000.00, 315000.00),
(15, 14, 5, 1, 315000.00, 315000.00),
(16, 15, 4, 1, 100000.00, 100000.00),
(17, 16, 5, 1, 315000.00, 315000.00),
(18, 17, 5, 1, 315000.00, 315000.00),
(19, 18, 5, 1, 299250.00, 299250.00),
(20, 19, 6, 1, 114000.00, 114000.00),
(21, 20, 7, 1, 90250.00, 90250.00),
(22, 21, 5, 1, 315000.00, 315000.00),
(23, 22, 5, 1, 315000.00, 315000.00),
(24, 23, 6, 1, 114000.00, 114000.00),
(25, 24, 5, 1, 315000.00, 315000.00),
(26, 25, 5, 2, 315000.00, 630000.00),
(27, 26, 5, 3, 315000.00, 945000.00),
(28, 27, 5, 1, 315000.00, 315000.00),
(29, 28, 5, 1, 315000.00, 315000.00),
(30, 29, 6, 1, 114000.00, 114000.00),
(31, 30, 8, 1, 266000.00, 266000.00),
(32, 31, 1, 1, 237500.00, 237500.00),
(33, 32, 4, 1, 95000.00, 95000.00),
(34, 33, 3, 1, 190000.00, 190000.00),
(35, 34, 7, 1, 90250.00, 90250.00),
(36, 35, 5, 1, 315000.00, 315000.00),
(37, 36, 7, 1, 90250.00, 90250.00),
(38, 37, 5, 1, 315000.00, 315000.00),
(39, 38, 5, 1, 315000.00, 315000.00),
(40, 39, 7, 1, 90250.00, 90250.00),
(41, 40, 6, 1, 120000.00, 120000.00),
(42, 40, 8, 1, 280000.00, 280000.00),
(43, 41, 7, 1, 90250.00, 90250.00),
(44, 42, 7, 1, 90250.00, 90250.00),
(45, 43, 7, 1, 90250.00, 90250.00),
(46, 44, 7, 1, 90250.00, 90250.00),
(47, 45, 7, 1, 90250.00, 90250.00),
(48, 46, 6, 1, 120000.00, 120000.00),
(49, 47, 3, 1, 200000.00, 200000.00),
(50, 48, 7, 1, 90250.00, 90250.00),
(51, 49, 6, 1, 120000.00, 120000.00),
(52, 50, 6, 1, 120000.00, 120000.00),
(53, 51, 3, 1, 200000.00, 200000.00),
(54, 52, 6, 1, 120000.00, 120000.00),
(55, 53, 5, 1, 315000.00, 315000.00),
(56, 54, 6, 1, 120000.00, 120000.00),
(57, 55, 1, 1, 280000.00, 280000.00),
(58, 56, 11, 1, 120000.00, 120000.00),
(59, 57, 46, 1, 75000.00, 75000.00),
(60, 58, 55, 1, 95000.00, 95000.00),
(61, 59, 7, 1, 150000.00, 150000.00),
(64, 62, 37, 1, 75000.00, 75000.00),
(65, 62, 6, 1, 95000.00, 95000.00),
(66, 63, 6, 1, 95000.00, 95000.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_logs`
--

CREATE TABLE `order_logs` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `changed_by` int(11) DEFAULT NULL,
  `from_status` varchar(100) DEFAULT NULL,
  `to_status` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_logs`
--

INSERT INTO `order_logs` (`id`, `order_id`, `changed_by`, `from_status`, `to_status`, `note`, `created_at`) VALUES
(1, 30, 1, 'processing', 'shipped', '', '2025-11-15 09:36:28'),
(2, 33, 1, 'processing', 'processing', '', '2025-11-15 10:34:14'),
(3, 33, 1, 'paid', 'pending', '', '2025-11-15 10:34:19'),
(4, 33, 1, 'pending', 'paid', '', '2025-11-15 10:34:22'),
(5, 33, 1, 'paid', 'failed', '', '2025-11-15 10:34:25'),
(6, 33, 1, 'failed', 'paid', '', '2025-11-15 10:34:27'),
(7, 33, 1, 'paid', 'paid', '', '2025-11-15 10:52:51'),
(8, 33, 1, 'processing', 'processing', 'dsadas', '2025-11-15 10:52:55'),
(9, 33, 1, 'processing', 'processing', NULL, '2025-11-15 10:54:05'),
(10, 33, 1, 'processing', 'completed', NULL, '2025-11-15 10:54:45'),
(11, 33, 1, 'paid', 'pending', '', '2025-11-15 10:54:50'),
(12, 33, 1, 'pending', 'paid', '', '2025-11-15 10:54:55'),
(13, 33, 1, NULL, 'cancelled', 'Cancelled by admin', '2025-11-15 12:46:06'),
(14, 33, 1, 'cancelled', 'cancelled', 'dsadas', '2025-11-15 13:08:04'),
(15, 31, 1, NULL, 'cancelled', 'Cancelled by admin', '2025-11-15 13:08:45'),
(16, 32, 1, 'paid', 'refunded', 'Refund Rp 50.000. saya kembalikan karena operasional', '2025-11-15 16:05:11'),
(17, 32, 1, 'processing', 'cancelled', 'Dikarenakan operasional', '2025-11-15 16:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `type` enum('reset','verify') DEFAULT 'reset',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_gateway` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(150) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `status` enum('success','failed','pending','settlement') DEFAULT 'pending',
  `response_data` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_gateway`, `transaction_id`, `amount`, `status`, `response_data`, `created_at`) VALUES
(1, 1, 'transfer', 'TRX17627683192246', 20000.00, 'success', '{\"gateway_response\":{\"note\":\"Simulasi pembayaran otomatis\"},\"created_by\":\"system\",\"timestamp\":\"2025-11-10 10:51:59\"}', '2025-11-10 10:51:59'),
(2, 2, 'ewallet', 'TRX17627784375938', 100000.00, 'success', '{\"gateway_response\":{\"note\":\"Simulasi pembayaran otomatis\"},\"created_by\":\"system\",\"timestamp\":\"2025-11-10 13:40:37\"}', '2025-11-10 13:40:37'),
(3, 3, 'transfer', 'TRX17628188363099', 100000.00, 'success', '{\"gateway_response\":{\"note\":\"Simulasi pembayaran otomatis\"},\"created_by\":\"system\",\"timestamp\":\"2025-11-11 00:53:56\"}', '2025-11-11 00:53:56'),
(4, 4, 'transfer', 'TRX17628302884649', 40000.00, 'success', '{\"gateway_response\":{\"note\":\"Simulasi pembayaran otomatis\"},\"created_by\":\"system\",\"timestamp\":\"2025-11-11 04:04:48\"}', '2025-11-11 04:04:48'),
(5, 5, 'transfer', 'TRX17628314349543', 20000.00, 'success', '{\"gateway_response\":{\"note\":\"Simulasi pembayaran otomatis\"},\"created_by\":\"system\",\"timestamp\":\"2025-11-11 04:23:54\"}', '2025-11-11 04:23:54'),
(6, 6, 'transfer', 'TRX17628321796197', 20000.00, 'success', '{\"gateway_response\":{\"note\":\"Simulasi pembayaran otomatis\"},\"created_by\":\"system\",\"timestamp\":\"2025-11-11 04:36:19\"}', '2025-11-11 04:36:19'),
(7, 7, 'transfer', 'TRX17629142272841', 20000.00, 'success', '{\"gateway_response\":{\"note\":\"Simulasi pembayaran otomatis\"},\"created_by\":\"system\",\"timestamp\":\"2025-11-12 03:23:47\"}', '2025-11-12 03:23:47'),
(8, 8, 'transfer', 'TRX17629143236113', 100000.00, 'success', '{\"gateway_response\":{\"note\":\"Simulasi pembayaran otomatis\"},\"created_by\":\"system\",\"timestamp\":\"2025-11-12 03:25:23\"}', '2025-11-12 03:25:23'),
(9, 9, 'transfer', 'TRX17629151643169', 20000.00, 'success', '{\"gateway_response\":{\"note\":\"Simulasi pembayaran otomatis\"},\"created_by\":\"system\",\"timestamp\":\"2025-11-12 03:39:24\"}', '2025-11-12 03:39:24'),
(10, 10, 'transfer', 'TX_6915abf647ba4', 315000.00, 'pending', NULL, '2025-11-13 16:59:18'),
(11, 11, 'ewallet', 'TX_6915beb23a90d', 250000.00, 'pending', NULL, '2025-11-13 18:19:14'),
(12, 12, 'ewallet', 'TX_6915c2cf4ad9b', 250000.00, 'pending', NULL, '2025-11-13 18:36:47'),
(13, 13, 'ewallet', 'TX_6915c31ea76e5', 315000.00, 'pending', NULL, '2025-11-13 18:38:06'),
(14, 14, 'cod', 'TX_6915cea16bf19', 315000.00, 'pending', NULL, '2025-11-13 19:27:13'),
(15, 15, 'cod', 'TX_6915d97ea17d0', 100000.00, 'pending', NULL, '2025-11-13 20:13:34'),
(16, 16, 'cod', 'TX_6915dbe598ec7', 315000.00, 'pending', NULL, '2025-11-13 20:23:49'),
(17, 17, 'cod', 'TX_6915dddc9a0f7', 315000.00, 'pending', NULL, '2025-11-13 20:32:12'),
(18, 18, 'cod', 'TX_6915e350edba8', 299250.00, 'pending', NULL, '2025-11-13 20:55:28'),
(19, 19, 'cod', 'TX_6915e38b6b3cc', 114000.00, 'pending', NULL, '2025-11-13 20:56:27'),
(20, 20, 'cod', 'TX_6915eae8b1d1e', 90250.00, 'pending', NULL, '2025-11-13 21:27:52'),
(21, 21, 'cod', 'TX_69164b0c2c47c', 315000.00, 'pending', NULL, '2025-11-14 04:18:04'),
(22, 22, 'cod', 'TX_691670942812f', 315000.00, 'pending', NULL, '2025-11-14 06:58:12'),
(23, 23, 'cod', 'TX_69167894bdf8b', 114000.00, 'pending', NULL, '2025-11-14 07:32:20'),
(24, 24, 'cod', 'TX_69169c8126a91', 315000.00, 'pending', NULL, '2025-11-14 10:05:37'),
(25, 27, 'midtrans', NULL, 315000.00, 'pending', NULL, '2025-11-14 15:16:57'),
(26, 28, 'midtrans', NULL, 315000.00, 'pending', NULL, '2025-11-14 15:35:00'),
(27, 29, 'qris', 'aa8b13cd-bb26-4184-85bf-7a75064314ae', 114000.00, '', NULL, '2025-11-14 17:05:08'),
(28, 30, 'qris', '64f4cc98-ff49-41c2-8d3f-80170cc9cc05', 266000.00, '', NULL, '2025-11-14 17:17:11'),
(29, 31, 'qris', 'bb2239ec-7a73-4152-a617-4bc19a4c6a50', 237500.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"bb2239ec-7a73-4152-a617-4bc19a4c6a50\",\"gross_amount\":\"237500.00\",\"currency\":\"IDR\",\"order_id\":\"RR31-1763116236\",\"payment_type\":\"qris\",\"signature_key\":\"0ea11f8bc8944833cabfb263be92779e78d4c6f7b32ca7b14a7605214e489b7ec90acb5635ad1e8e9b9614d34a83dd32c4103c67c4ec886d3af8a7ab0206ac70\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-14 17:30:40\",\"settlement_time\":\"2025-11-14 17:30:56\",\"expiry_time\":\"2025-11-14 17:45:40\"}', '2025-11-14 17:28:17'),
(30, 32, 'qris', '6bd09f4a-5ac1-42be-b018-62ca99fa22ee', 95000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"6bd09f4a-5ac1-42be-b018-62ca99fa22ee\",\"gross_amount\":\"95000.00\",\"currency\":\"IDR\",\"order_id\":\"RR32-1763118523\",\"payment_type\":\"qris\",\"signature_key\":\"350d752d7a2d73d48de1e8fb51c775ed6699dba10042ed8c26314f6e2b1ce026a7f5ac1ab09a6abb0470f837eb293980410d71fdee2246f067e1ae4234a23608\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-14 18:08:47\",\"settlement_time\":\"2025-11-14 18:09:49\",\"expiry_time\":\"2025-11-14 18:23:47\"}', '2025-11-14 18:08:42'),
(31, 33, 'qris', '69da1344-1a09-4eaf-8413-26bb4cb2ea4c', 190000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"69da1344-1a09-4eaf-8413-26bb4cb2ea4c\",\"gross_amount\":\"190000.00\",\"currency\":\"IDR\",\"order_id\":\"RR33-1763155650\",\"payment_type\":\"qris\",\"signature_key\":\"5e57dae5fe10184cab71b78cc5685602b60d3e9ecdc56742ea24300a5e39ef067c75ebf551762a029596954b065555947fc9d2072177b968a151e9d84acc4a0a\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-15 04:28:50\",\"settlement_time\":\"2025-11-15 04:29:56\",\"expiry_time\":\"2025-11-15 04:43:50\"}', '2025-11-15 04:27:26'),
(32, 34, 'qris', 'd731bdb4-c44d-4408-ae3a-7e252aaf31eb', 90250.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"d731bdb4-c44d-4408-ae3a-7e252aaf31eb\",\"gross_amount\":\"90250.00\",\"currency\":\"IDR\",\"order_id\":\"RR34-1763210943\",\"payment_type\":\"qris\",\"signature_key\":\"cb98738fe2782d0788916d7d29266e9263be632f44321e834e41585c3b82f357a9f41baacbbe7388d3223afee1bdfa2c44212b67ed60b62e12f17e97d73d3098\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-15 19:49:07\",\"settlement_time\":\"2025-11-15 19:51:14\",\"expiry_time\":\"2025-11-15 20:04:07\"}', '2025-11-15 19:49:00'),
(33, 35, 'midtrans', NULL, 315000.00, 'pending', NULL, '2025-11-15 21:49:55'),
(34, 36, 'midtrans', NULL, 90250.00, 'pending', NULL, '2025-11-16 10:03:42'),
(35, 37, 'midtrans', NULL, 315000.00, 'pending', NULL, '2025-11-17 07:46:26'),
(36, 38, 'midtrans', NULL, 315000.00, 'pending', NULL, '2025-11-17 11:04:27'),
(37, 39, 'midtrans', NULL, 90250.00, 'pending', NULL, '2025-11-17 15:45:21'),
(38, 40, 'midtrans', NULL, 400000.00, 'pending', NULL, '2025-11-18 10:01:30'),
(39, 41, 'midtrans', NULL, 90250.00, 'pending', NULL, '2025-11-18 10:25:46'),
(40, 42, 'midtrans', NULL, 430250.00, 'pending', NULL, '2025-11-18 10:45:06'),
(41, 43, 'qris', '05edbdd0-c980-44fd-9e5a-0da14c73e404', 455250.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"05edbdd0-c980-44fd-9e5a-0da14c73e404\",\"gross_amount\":\"90250.00\",\"currency\":\"IDR\",\"order_id\":\"RR43-1763437556\",\"payment_type\":\"qris\",\"signature_key\":\"714aa59a89b4bca8b62016a19bd396793fcede1640fe633eb0ce03ba37008bb0250c466a17033c04eadaa805f8041eca4b625d5bf3d7f43087a01b60b4d86baf\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-18 10:46:00\",\"settlement_time\":\"2025-11-18 10:46:36\",\"expiry_time\":\"2025-11-18 11:01:00\"}', '2025-11-18 10:45:53'),
(42, 44, 'qris', 'f46d196d-97d9-480e-9fe8-329edf4b75f8', 222750.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"f46d196d-97d9-480e-9fe8-329edf4b75f8\",\"gross_amount\":\"90250.00\",\"currency\":\"IDR\",\"order_id\":\"RR44-1763437981\",\"payment_type\":\"qris\",\"signature_key\":\"0daef574c12acc0d97d2b99015809653d7c6489d0e8041abef5cf0ae16f49161e3cc07947c9b91f6bf9691337b73ef0ea4ae36c9d0506e9f8f5d0e7a6419971a\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-18 10:53:23\",\"settlement_time\":\"2025-11-18 10:53:39\",\"expiry_time\":\"2025-11-18 11:08:23\"}', '2025-11-18 10:52:58'),
(43, 45, 'qris', '97e0f5d1-eecd-4a08-91c1-7de1378c83fc', 165250.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"97e0f5d1-eecd-4a08-91c1-7de1378c83fc\",\"gross_amount\":\"90250.00\",\"currency\":\"IDR\",\"order_id\":\"RR45-1763438306\",\"payment_type\":\"qris\",\"signature_key\":\"7c1c64db0b157521417baea8bd3bc91ce2aed9b5035b472cdc7488f03c4558bb95ee3aa2f120dd55a029373872deb52e9f06450b0def8524fc242f5cc6d72804\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-18 10:58:30\",\"settlement_time\":\"2025-11-18 10:58:43\",\"expiry_time\":\"2025-11-18 11:13:30\"}', '2025-11-18 10:58:24'),
(44, 46, 'qris', 'c746ab26-f82c-4ca5-bba6-6e47798b458c', 234000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"c746ab26-f82c-4ca5-bba6-6e47798b458c\",\"gross_amount\":\"120000.00\",\"currency\":\"IDR\",\"order_id\":\"RR46-1763444383\",\"payment_type\":\"qris\",\"signature_key\":\"86a8929deadc44bbb8263837800595c92194ff9247983665e3432277e345ba3e08ceab86f5b0df71b0842847966fcb219e7dd893b4f5e1abadc7ce956ecb4fe8\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-18 12:39:46\",\"settlement_time\":\"2025-11-18 12:39:54\",\"expiry_time\":\"2025-11-18 12:54:46\"}', '2025-11-18 12:39:42'),
(45, 47, 'qris', '77970836-e531-4f92-af21-b2064078a324', 288000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"77970836-e531-4f92-af21-b2064078a324\",\"gross_amount\":\"200000.00\",\"currency\":\"IDR\",\"order_id\":\"RR47-1763450303\",\"payment_type\":\"qris\",\"signature_key\":\"7d591e8857136d5352ef042e789f5122cfe29a47f74b9837b94f59ef0f130d22d832fb8e56429f82e0d4eb1624820b3e7192a1e7b2b168459a7b24eedced796d\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-18 14:18:31\",\"settlement_time\":\"2025-11-18 14:18:40\",\"expiry_time\":\"2025-11-18 14:33:31\"}', '2025-11-18 14:18:21'),
(46, 48, 'midtrans', NULL, 181250.00, 'pending', NULL, '2025-11-18 14:28:09'),
(47, 49, 'qris', 'a68bec3f-dc30-4202-8572-9edcfc5fb3a1', 223000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"a68bec3f-dc30-4202-8572-9edcfc5fb3a1\",\"gross_amount\":\"223000.00\",\"currency\":\"IDR\",\"order_id\":\"RR49-1763450926\",\"payment_type\":\"qris\",\"signature_key\":\"a561c08bd01ca29ab6e4025dafd14ef6d5b542dd6231f5dcffea211f121e72f2ab214c4a0cc437adcbb3d9cf2d02588b385e890e9d7ac00927728939cd2365bc\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-18 14:28:50\",\"settlement_time\":\"2025-11-18 14:29:03\",\"expiry_time\":\"2025-11-18 14:43:50\"}', '2025-11-18 14:28:45'),
(48, 50, 'qris', 'fd68051a-4231-478e-9558-18e7c1ae4a71', 208000.00, 'pending', '{\"status_code\":\"201\",\"transaction_id\":\"fd68051a-4231-478e-9558-18e7c1ae4a71\",\"gross_amount\":\"208000.00\",\"currency\":\"IDR\",\"order_id\":\"RR50-1763626661\",\"payment_type\":\"qris\",\"signature_key\":\"2ff1079e6b167588ed5e866e478ffe58f373ed5d8aa763350665a7bda9582722724f37ad24809020158b3471e26f3ace7dc77706a3f0fa079f38ab927bf15820\",\"transaction_status\":\"pending\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_time\":\"2025-11-20 15:17:45\",\"expiry_time\":\"2025-11-20 15:32:45\"}', '2025-11-20 15:16:18'),
(49, 51, 'qris', '67b1c6bb-0443-4c22-a1b6-005712921c9b', 279000.00, 'pending', '{\"status_code\":\"201\",\"transaction_id\":\"67b1c6bb-0443-4c22-a1b6-005712921c9b\",\"gross_amount\":\"279000.00\",\"currency\":\"IDR\",\"order_id\":\"RR51-1763626979\",\"payment_type\":\"qris\",\"signature_key\":\"42b6207e595252cfdb5e55fe5a48774f8dbaa63ad63abe1672b08c61650b7eff9d2091c2f2beb039d166d3d75af57d8a5d733a75318e56af0a425e4aef6e2648\",\"transaction_status\":\"pending\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_time\":\"2025-11-20 15:23:03\",\"expiry_time\":\"2025-11-20 15:38:03\"}', '2025-11-20 15:22:58'),
(50, 52, 'qris', 'ea379b04-a851-4ee9-b6bb-2938fb581bf3', 240000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"ea379b04-a851-4ee9-b6bb-2938fb581bf3\",\"gross_amount\":\"240000.00\",\"currency\":\"IDR\",\"order_id\":\"RR52-1763962254\",\"payment_type\":\"qris\",\"signature_key\":\"c5edaf239097daa41bd19d8965e1379a9c679a16c69802fa2c99caa3ac924b32246b574bfeb5e794ac1e45b071f0b0fa7e22b642eef2b2d98f921cbc616c7e0e\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-24 12:30:57\",\"settlement_time\":\"2025-11-24 12:31:12\",\"expiry_time\":\"2025-11-24 12:45:57\"}', '2025-11-24 12:30:52'),
(51, 53, 'qris', '1da872f5-19a5-421a-8b49-86a7052fb798', 403000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"1da872f5-19a5-421a-8b49-86a7052fb798\",\"gross_amount\":\"403000.00\",\"currency\":\"IDR\",\"order_id\":\"RR53-1763975094\",\"payment_type\":\"qris\",\"signature_key\":\"148d8f1d9b67a4540bc869172bd78b4abcab93645b820587ddc99cb4f053a085a2c91c1993429455432e7bc6812f40b0305caed92a275bc56cbcee0927e2753f\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-24 16:05:00\",\"settlement_time\":\"2025-11-24 16:05:14\",\"expiry_time\":\"2025-11-24 16:20:00\"}', '2025-11-24 16:04:53'),
(52, 54, 'qris', 'cdd66e99-40d9-4c87-8a23-3d284221b853', 208000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"cdd66e99-40d9-4c87-8a23-3d284221b853\",\"gross_amount\":\"208000.00\",\"currency\":\"IDR\",\"order_id\":\"RR54-1764036050\",\"payment_type\":\"qris\",\"signature_key\":\"e4581033122ce201548c7b45037b393eaf14609175eafb9f9d4bd05c00a88c2309cb6da50bb8601abfd1f424190374c3c632bffe365a3a2fdd45ddca377693a4\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-25 09:00:54\",\"settlement_time\":\"2025-11-25 09:01:14\",\"expiry_time\":\"2025-11-25 09:15:54\"}', '2025-11-25 09:00:47'),
(53, 55, 'qris', 'f966d171-8dea-4f4b-9c6f-50f33193c066', 355000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"f966d171-8dea-4f4b-9c6f-50f33193c066\",\"gross_amount\":\"355000.00\",\"currency\":\"IDR\",\"order_id\":\"RR55-1764079951\",\"payment_type\":\"qris\",\"signature_key\":\"97f009e80083a3732274f70f95ce4198b2dade3499a2a7984d42c153cefb51315d6e8775d2c72c1b88739b3c460da5f2a5060687b73ae3c2e5ec1950920f550b\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-25 21:12:36\",\"settlement_time\":\"2025-11-25 21:12:55\",\"expiry_time\":\"2025-11-25 21:27:36\"}', '2025-11-25 21:12:28'),
(54, 56, 'qris', '73133660-c340-4b76-9189-109bc810bfde', 195000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"73133660-c340-4b76-9189-109bc810bfde\",\"gross_amount\":\"195000.00\",\"currency\":\"IDR\",\"order_id\":\"RR56-1764080400\",\"payment_type\":\"qris\",\"signature_key\":\"21709aa6ac5cf141f1d9671d52532205e1355e3d52bc26bb01c9a1a21ef7d976458f7ebd312d435831e4568d2f6570f6399e28245daf5d12f81144d4c8fc7b0b\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-25 21:20:04\",\"settlement_time\":\"2025-11-25 21:20:17\",\"expiry_time\":\"2025-11-25 21:35:04\"}', '2025-11-25 21:19:58'),
(55, 57, 'qris', '87cf38c8-e5a7-4aa5-9f42-850a6bfe0555', 163000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"87cf38c8-e5a7-4aa5-9f42-850a6bfe0555\",\"gross_amount\":\"163000.00\",\"currency\":\"IDR\",\"order_id\":\"RR57-1764082358\",\"payment_type\":\"qris\",\"signature_key\":\"b38b11989b16ed59fe60d7cc5c65be5d634144fe101d2bc9f185b9eec9dd543e075dddef80a629101a3a8d6e44826857ec2767ee8a1e7e36712f664e7c3a76cf\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-25 21:52:43\",\"settlement_time\":\"2025-11-25 21:52:59\",\"expiry_time\":\"2025-11-25 22:07:43\"}', '2025-11-25 21:52:37'),
(56, 58, 'qris', 'de38f32f-092a-415a-a68b-09087ccdb9a0', 180000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"de38f32f-092a-415a-a68b-09087ccdb9a0\",\"gross_amount\":\"180000.00\",\"currency\":\"IDR\",\"order_id\":\"RR58-1764083064\",\"payment_type\":\"qris\",\"signature_key\":\"d7a67740b13f50965300b556bea9c1bfe115a0443e12e7876f589b1ce88fcc685c2446fa44480a04fd9f02b189c6a9d21ec10e579864bda7c7a0512eb4fe17de\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-25 22:04:32\",\"settlement_time\":\"2025-11-25 22:04:51\",\"expiry_time\":\"2025-11-25 22:19:32\"}', '2025-11-25 22:04:23'),
(57, 59, 'qris', '950cdde1-3482-465a-bd1d-f2a6cb0a2217', 238000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"950cdde1-3482-465a-bd1d-f2a6cb0a2217\",\"gross_amount\":\"238000.00\",\"currency\":\"IDR\",\"order_id\":\"RR59-1764083786\",\"payment_type\":\"qris\",\"signature_key\":\"5628c81a40a515dddbe59fcc58819802a437aa44acbc3118e6894f4d8ebe5f51e8b2f690b531a7cae6c1ea79c5bdb1a0da3f57e1348e77707aa6ecf4c4c98066\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-25 22:16:30\",\"settlement_time\":\"2025-11-25 22:16:45\",\"expiry_time\":\"2025-11-25 22:31:30\"}', '2025-11-25 22:16:24'),
(58, 60, 'qris', '1a72ff6e-7308-4e04-8c21-4ab24d0e93c1', 134000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"1a72ff6e-7308-4e04-8c21-4ab24d0e93c1\",\"gross_amount\":\"134000.00\",\"currency\":\"IDR\",\"order_id\":\"RR60-1764148024\",\"payment_type\":\"qris\",\"signature_key\":\"95a4394260429027475a697b42753bb0a01e1a76ccc9d2973c5dfaf4ea75ad7513d3197ffd4535836556dbc34ca8279bdd4abb9d876707a1cdc67cd2f3fd32cb\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-11-26 16:07:12\",\"settlement_time\":\"2025-11-26 16:07:22\",\"expiry_time\":\"2025-11-26 16:22:12\"}', '2025-11-26 16:07:01'),
(59, 61, 'midtrans', NULL, 400000.00, 'pending', NULL, '2025-11-26 21:03:05'),
(60, 62, 'qris', 'd29fa03e-92f8-4acb-b12c-20851e144de6', 5870000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"d29fa03e-92f8-4acb-b12c-20851e144de6\",\"gross_amount\":\"5870000.00\",\"currency\":\"IDR\",\"order_id\":\"RR62-1764670003\",\"payment_type\":\"qris\",\"signature_key\":\"bdfbf6b5810a0de9ad7e66f829bbfd2c08c47d5d3172fd7e10e9cb07f6026bfd4a2e59fc7dc8e9411c2f5bf6b95048cd3866937670ed289ad5c1e7f6d7bca47d\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-12-02 17:06:46\",\"settlement_time\":\"2025-12-02 17:06:55\",\"expiry_time\":\"2025-12-02 17:21:46\"}', '2025-12-02 16:50:49'),
(61, 63, 'qris', '078ff058-5f47-4072-8384-ea54b229143b', 3245000.00, 'success', '{\"status_code\":\"200\",\"transaction_id\":\"078ff058-5f47-4072-8384-ea54b229143b\",\"gross_amount\":\"3245000.00\",\"currency\":\"IDR\",\"order_id\":\"RR63-1764670088\",\"payment_type\":\"qris\",\"signature_key\":\"efc4d0a3c2db349f022afa870173a54218abbdb1c1489170cead5e48661f5b2a0bd93ae01c274a5afb7915b4c3faa356bca934a2bc2cebf3dc8016a3d8358f69\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G596375058\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2025-12-02 17:08:10\",\"settlement_time\":\"2025-12-02 17:08:19\",\"expiry_time\":\"2025-12-02 17:23:10\"}', '2025-12-02 17:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL COMMENT 'Relasi ke categories.id',
  `name` varchar(150) NOT NULL COMMENT 'Nama produk',
  `description` text DEFAULT NULL COMMENT 'Deskripsi produk',
  `price` decimal(12,2) NOT NULL COMMENT 'Harga',
  `discount` decimal(5,2) DEFAULT 0.00 COMMENT 'Diskon (%)',
  `stock` int(11) NOT NULL DEFAULT 0 COMMENT 'Jumlah stok',
  `featured` tinyint(1) DEFAULT 0 COMMENT 'Produk unggulan (0=Tidak, 1=Ya)',
  `created_at` datetime DEFAULT current_timestamp() COMMENT 'Waktu ditambahkan',
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `discount`, `stock`, `featured`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bingkai Waktu Berputar (Custom Date)', 'Bingkai foto dengan kalender yang menyoroti tanggal spesial ulang tahun, dapat diukir nama.', 280000.00, 0.00, 49, 0, '2025-11-25 12:52:32', '2025-11-25 13:11:57'),
(2, 1, 'Birthday Box: Pesta Satu Orang', 'Kotak lengkap berisi dekorasi mini, kue instan, dan kartu ucapan untuk merayakan ultah sendirian dari jauh.', 199000.00, 0.00, 65, 0, '2025-11-25 12:52:32', '2025-11-25 13:12:07'),
(3, 2, 'Paket Hampers Silaturahmi Hangat', 'Paket berisi kue kering premium, teh pilihan, dan kartu ucapan kustom untuk dikirim saat Lebaran.', 425000.00, 0.00, 80, 0, '2025-11-25 12:52:32', '2025-11-25 13:12:13'),
(4, 2, 'Set Mukena Perjalanan Hati', 'Set mukena travel yang ringan dan sajadah lipat dalam tas elegan, cocok sebagai kado Idul Fitri.', 185000.00, 0.00, 90, 0, '2025-11-25 12:52:32', '2025-11-25 13:12:23'),
(5, 3, 'Dekorasi Pohon Harapan Natal', 'Set bola natal keramik kustom dengan inisial dan tanggal, sebagai pengingat momen liburan bersama.', 150000.00, 0.00, 70, 0, '2025-11-25 12:52:32', '2025-11-25 13:12:30'),
(6, 3, 'Lilin Aroma Gingerbread & Cinnamon', 'Lilin aromaterapi edisi terbatas Natal, menciptakan suasana hangat dan manis di rumah.', 95000.00, 0.00, 118, 0, '2025-11-25 12:52:32', '2025-11-25 13:12:40'),
(7, 4, 'Surat Rindu Botol Kaca (Pre-Sealed)', 'Paket berisi 7 surat romantis yang sudah kami segel dalam botol kaca kecil, dibuka per hari.', 150000.00, 0.00, 74, 0, '2025-11-25 12:52:32', '2025-11-25 13:12:51'),
(8, 4, 'Liontin Kunci Hati (Couple Set)', 'Dua liontin yang saling melengkapi (kunci dan gembok) dengan ukiran inisial pasangan.', 380000.00, 0.00, 50, 0, '2025-11-25 12:52:32', '2025-11-25 13:13:04'),
(9, 5, 'Celemek Chef Terbaik di Dunia (Custom Name)', 'Apron masak berkualitas tinggi dengan bordir nama panggilan favorit.', 165000.00, 0.00, 40, 0, '2025-11-25 12:52:32', '2025-11-25 13:42:00'),
(10, 5, 'Pijat Leher Elektrik Malam Hari', 'Alat pijat portabel yang fokus meredakan ketegangan, kado relaksasi terbaik untuk orang tua.', 499000.00, 0.00, 35, 0, '2025-11-25 12:52:32', '2025-11-25 13:42:09'),
(11, 6, 'Boneka Beruang Toga Wisuda', 'Boneka wisuda dengan toga kustom, membawa ijazah mini yang bisa diselipkan pesan.', 120000.00, 0.00, 79, 0, '2025-11-25 12:52:32', '2025-11-25 13:42:24'),
(12, 6, 'Set Pulpen Profesional & Card Holder', 'Set alat tulis dan tempat kartu nama kulit, hadiah awal karier yang elegan.', 250000.00, 0.00, 55, 0, '2025-11-25 12:52:32', '2025-11-25 13:42:33'),
(13, 7, 'Sprei Hotel Bintang Lima (Monogram)', 'Sprei katun premium dengan bordir inisial pasangan, simbol kenyamanan rumah baru.', 850000.00, 0.00, 25, 0, '2025-11-25 12:52:32', '2025-11-25 13:42:48'),
(14, 7, 'Kotak Cincin Kayu Ukir Tanggal', 'Kotak cincin khusus untuk upacara tunangan/pernikahan, diukir dengan tanggal bersejarah.', 190000.00, 0.00, 30, 0, '2025-11-25 12:52:32', '2025-11-25 13:43:13'),
(15, 8, 'Baby Hamper: Selamat Datang Ke Dunia', 'Paket kado berisi pakaian bayi organik, mainan lembut, dan handuk bertudung.', 360000.00, 0.00, 70, 0, '2025-11-25 12:52:32', '2025-11-25 13:43:26'),
(16, 8, 'Album Foto Milestone Bayi', 'Album untuk mencatat dan menyimpan foto perkembangan bayi dari bulan ke bulan.', 145000.00, 0.00, 60, 0, '2025-11-25 12:52:32', '2025-11-25 13:43:39'),
(17, 9, 'Power Bank Bisnis Logo Custom', 'Power bank cepat pengisian daya dengan kemampuan ukir logo perusahaan.', 175000.00, 0.00, 150, 0, '2025-11-25 12:52:32', '2025-11-25 13:43:49'),
(18, 9, 'Set Tumbler Kopi Executive', 'Tumbler stainless steel anti tumpah dengan kemasan kotak premium.', 130000.00, 0.00, 180, 0, '2025-11-25 12:52:32', '2025-11-25 13:44:02'),
(19, 10, 'Angpao Amplop Sutra Merah', 'Paket amplop Angpao dari bahan sutra dengan motif emas klasik.', 65000.00, 0.00, 200, 0, '2025-11-25 12:52:32', '2025-11-25 13:44:15'),
(20, 10, 'Set Teh Naga Emas & Cangkir Porselen', 'Set teh spesial dengan porselen bertema Imlek, cocok untuk kunjungan keluarga.', 320000.00, 0.00, 40, 0, '2025-11-25 12:52:32', '2025-11-25 13:44:28'),
(21, 11, 'Earphone Sentuhan Senyap (Noise Cancelling)', 'Earphone nirkabel dengan teknologi peredam bising, sempurna untuk panggilan LDR atau saat bekerja.', 750000.00, 0.00, 30, 0, '2025-11-25 12:52:32', '2025-11-25 13:44:48'),
(22, 11, 'Lampu Meja Smart Mood Changer', 'Lampu meja yang dapat diatur warnanya melalui aplikasi, cocok untuk suasana LDR.', 240000.00, 0.00, 50, 0, '2025-11-25 12:52:32', '2025-11-25 13:44:57'),
(23, 12, 'Jam Tangan Jarak (Two Time Zones)', 'Jam tangan dengan dua tampilan waktu, memungkinkan Anda melihat waktu pasangan di zona waktu berbeda.', 450000.00, 0.00, 40, 0, '2025-11-25 12:52:32', '2025-11-25 13:45:06'),
(24, 12, 'Dompet Kulit Ukir Inisial', 'Dompet kulit asli kualitas premium dengan slot kartu yang banyak, bisa diukir inisial.', 295000.00, 0.00, 60, 0, '2025-11-25 12:52:32', '2025-11-25 13:45:16'),
(25, 13, 'Set Pembuat Kopi Drip & Filter', 'Peralatan lengkap untuk membuat kopi V60 di rumah, termasuk biji kopi pilihan.', 410000.00, 0.00, 35, 0, '2025-11-25 12:52:32', '2025-11-25 13:45:25'),
(26, 13, 'Buku Resep Warisan Keluarga (Kosong)', 'Buku resep hardcover dengan halaman kosong untuk diisi resep andalan keluarga.', 115000.00, 0.00, 50, 0, '2025-11-25 12:52:32', '2025-11-25 13:45:36'),
(27, 14, 'Matras Yoga Kedamaian Pikiran', 'Matras yoga premium dengan tekstur anti-selip dan motif yang menenangkan, mendukung resolusi kebugaran.', 320000.00, 0.00, 20, 0, '2025-11-25 12:52:32', '2025-11-25 13:45:45'),
(28, 14, 'Smart Skipping Rope Digital', 'Tali lompat digital yang menghitung kalori dan lompatan, terhubung ke aplikasi fitness.', 199000.00, 0.00, 40, 0, '2025-11-25 12:52:32', '2025-11-25 13:45:55'),
(29, 15, 'Jurnal Janji Harian (Leather Bound)', 'Jurnal kulit tebal dengan kertas antik, tempat mencatat rencana masa depan atau pengalaman LDR.', 210000.00, 0.00, 60, 0, '2025-11-25 12:52:32', '2025-11-25 13:47:37'),
(30, 15, 'Pen Set Edisi Penulis Favorit', 'Set pulpen premium dan tinta, dikemas dalam kotak bertema penulis terkenal.', 275000.00, 0.00, 45, 0, '2025-11-25 12:52:32', '2025-11-25 18:27:21'),
(31, 16, 'Kit Melukis di Kanvas (Painting by Number)', 'Kit lengkap untuk melukis tanpa perlu bakat, menghasilkan karya seni indah.', 125000.00, 0.00, 70, 0, '2025-11-25 12:52:32', '2025-11-25 18:27:46'),
(32, 16, 'Set Kerajinan Makrame Dinding', 'Set bahan dan panduan untuk membuat dekorasi dinding makrame modern.', 170000.00, 0.00, 35, 0, '2025-11-25 12:52:32', '2025-11-25 18:28:21'),
(33, 17, 'Speaker Bluetooth Retro Mini', 'Speaker portabel dengan desain vintage, suara jernih untuk menemani hari-hari.', 399000.00, 0.00, 40, 0, '2025-11-25 12:52:32', '2025-11-25 18:45:55'),
(34, 17, 'Voucher Langganan Streaming Musik 6 Bulan', 'Kartu voucher untuk layanan musik digital tanpa iklan.', 180000.00, 0.00, 100, 0, '2025-11-25 12:52:32', '2025-11-25 18:46:07'),
(35, 18, 'Bantal Leher Memory Foam Travel', 'Bantal leher super nyaman untuk penerbangan atau perjalanan darat yang panjang.', 150000.00, 0.00, 60, 0, '2025-11-25 12:52:32', '2025-11-25 18:46:18'),
(36, 18, 'Organizer Koper Serbaguna 6-in-1', 'Set tas organizer untuk memisahkan pakaian, sepatu, dan kosmetik di koper.', 99000.00, 0.00, 80, 0, '2025-11-25 12:52:32', '2025-11-25 18:46:29'),
(37, 19, 'Mousepad Gaming Peta Dunia', 'Mousepad ekstra besar dengan gambar peta dunia, cocok untuk gamer sekaligus traveler.', 75000.00, 0.00, 89, 0, '2025-11-25 12:52:32', '2025-11-25 18:46:44'),
(38, 19, 'Headset Gaming Suara Jernih RGB', 'Headset gaming dengan mikrofon jelas dan lampu RGB yang dapat disesuaikan.', 480000.00, 0.00, 30, 0, '2025-11-25 12:52:32', '2025-11-25 18:46:55'),
(39, 20, 'Set Skincare Malam Bintang', 'Paket perawatan kulit lengkap untuk rutinitas malam hari, dikemas dalam kotak mewah.', 550000.00, 0.00, 45, 0, '2025-11-25 12:52:32', '2025-11-25 18:47:10'),
(40, 20, 'Diffuser Minyak Aromaterapi (Ketenangan)', 'Diffuser elektrik dengan 3 botol minyak esensial (Lavender, Peppermint, Rose).', 220000.00, 0.00, 55, 0, '2025-11-25 12:52:32', '2025-11-25 18:47:24'),
(41, 21, 'Scarf Sutra Motif Bunga Mekar', 'Scarf sutra mewah dengan motif bunga yang elegan, cocok untuk segala acara.', 260000.00, 0.00, 50, 0, '2025-11-25 12:52:32', '2025-11-25 18:47:35'),
(42, 21, 'Tas Bahu Klasik Minimalis', 'Tas bahu kulit sintetis dengan desain yang tak lekang oleh waktu.', 420000.00, 0.00, 35, 0, '2025-11-25 12:52:32', '2025-11-25 18:47:46'),
(43, 22, 'Set Perawatan Jenggot & Brewok', 'Minyak, balm, dan sisir khusus untuk pria yang merawat penampilan brewok.', 190000.00, 0.00, 40, 0, '2025-11-25 12:52:32', '2025-11-25 18:47:57'),
(44, 22, 'Cufflink Edisi Terbatas Inisial', 'Kancing manset kemeja yang elegan, bisa diukir dengan inisial nama.', 310000.00, 0.00, 25, 0, '2025-11-25 12:52:32', '2025-11-25 18:48:09'),
(45, 23, 'Mainan Edukasi Blok Susun Kayu', 'Set blok kayu warna-warni untuk melatih motorik halus dan kreativitas anak.', 110000.00, 0.00, 90, 0, '2025-11-25 12:52:32', '2025-11-25 18:48:19'),
(46, 23, 'Buku Cerita Bergambar Interaktif', 'Buku yang dapat disentuh atau diangkat bagiannya untuk pengalaman membaca yang menyenangkan.', 75000.00, 0.00, 119, 0, '2025-11-25 12:52:32', '2025-11-25 18:48:30'),
(47, 24, 'Tas Ransel Petualang Digital', 'Tas ransel stylish dengan banyak saku tersembunyi dan fitur pengisian daya USB untuk gadget.', 180000.00, 0.00, 45, 0, '2025-11-25 12:52:32', '2025-11-25 18:48:41'),
(48, 24, 'Headphone Wireless Warna Pastel', 'Headphone nirkabel dengan desain trendi dan warna-warna cerah.', 270000.00, 0.00, 50, 0, '2025-11-25 12:52:32', '2025-11-25 18:48:50'),
(49, 25, 'Baju Kaos Couple \"Jarak Bukan Masalah\"', 'Kaos pasangan dengan desain minimalis dan tulisan yang menginspirasi LDR.', 160000.00, 0.00, 70, 0, '2025-11-25 12:52:32', '2025-11-25 18:49:00'),
(50, 25, 'Gelang Batu Alam Magnetik (Set)', 'Dua gelang yang akan saling tarik-menarik saat didekatkan, melambangkan koneksi jarak jauh.', 140000.00, 0.00, 60, 0, '2025-11-25 12:52:32', '2025-11-25 18:49:14'),
(51, 26, 'Sticky Notes Set & Pen Holder Meja', 'Set perlengkapan kantor premium untuk menjaga meja tetap rapi dan produktif.', 90000.00, 0.00, 100, 0, '2025-11-25 12:52:32', NULL),
(52, 26, 'Pouch Laptop Kulit Sintetis (Eksklusif)', 'Pouch laptop dengan desain profesional, cocok untuk pertemuan bisnis.', 230000.00, 10.00, 40, 0, '2025-11-25 12:52:32', NULL),
(53, 27, 'Kalung Peta Langit Tanggal Lahir', 'Kalung yang menampilkan konstelasi bintang pada tanggal dan lokasi lahir penerima.', 290000.00, 10.00, 75, 1, '2025-11-25 12:52:32', NULL),
(54, 27, 'Kotak Kenangan Kayu Jati (Ukiran Nama)', 'Kotak penyimpanan serbaguna yang diukir dengan nama atau pesan singkat.', 185000.00, 0.00, 50, 0, '2025-11-25 12:52:32', NULL),
(55, 28, 'Mug Titik Koordinat (Lokasi Pertemuan)', 'Mug keramik yang dicetak dengan koordinat geografis tempat Anda dan pasangan pertama kali bertemu.', 95000.00, 0.00, 99, 1, '2025-11-25 12:52:32', NULL),
(56, 28, 'Gantungan Kunci Pesan Rahasia', 'Gantungan kunci yang bisa dibuka untuk melihat gulungan kertas berisi pesan personal.', 45000.00, 0.00, 150, 0, '2025-11-25 12:52:32', NULL),
(57, 29, 'Paket Kado Relaksasi Total', 'Hampers berisi lilin, masker wajah, teh herbal, dan scrub mandi.', 340000.00, 5.00, 40, 1, '2025-11-25 12:52:32', NULL),
(58, 29, 'Hampers Jajan Nostalgia Indonesia', 'Paket kado berisi aneka camilan jadul Indonesia yang dikemas apik.', 199000.00, 0.00, 60, 0, '2025-11-25 12:52:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT 'Relasi ke products.id',
  `image_path` varchar(255) NOT NULL COMMENT 'Path file gambar',
  `is_main` tinyint(1) DEFAULT 0 COMMENT 'Gambar utama (0=Tidak, 1=Ya)',
  `created_at` datetime DEFAULT current_timestamp() COMMENT 'Waktu upload'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_main`, `created_at`) VALUES
(1, 1, '1764051117_kado1.png', 1, '2025-11-25 13:11:57'),
(2, 2, '1764051127_kado2.png', 1, '2025-11-25 13:12:07'),
(3, 3, '1764051133_kado3.png', 1, '2025-11-25 13:12:13'),
(4, 4, '1764051143_kado4.png', 1, '2025-11-25 13:12:23'),
(5, 5, '1764051150_kado5.png', 1, '2025-11-25 13:12:30'),
(6, 6, '1764051160_kado6.png', 1, '2025-11-25 13:12:40'),
(7, 7, '1764051171_kado7.png', 1, '2025-11-25 13:12:51'),
(8, 8, '1764051184_kado8.png', 1, '2025-11-25 13:13:04'),
(9, 9, '1764052920_kado9.png', 1, '2025-11-25 13:42:00'),
(10, 10, '1764052929_kado10.png', 1, '2025-11-25 13:42:09'),
(11, 11, '1764052944_kado11.png', 1, '2025-11-25 13:42:24'),
(12, 12, '1764052953_kado12.png', 1, '2025-11-25 13:42:33'),
(13, 13, '1764052968_kado13.png', 1, '2025-11-25 13:42:48'),
(14, 14, '1764052993_kado14.png', 1, '2025-11-25 13:43:13'),
(15, 15, '1764053006_kado15.png', 1, '2025-11-25 13:43:26'),
(16, 16, '1764053019_kado16.png', 1, '2025-11-25 13:43:39'),
(17, 17, '1764053029_kado17.png', 1, '2025-11-25 13:43:49'),
(18, 18, '1764053042_kado18.png', 1, '2025-11-25 13:44:02'),
(19, 19, '1764053055_kado19.png', 1, '2025-11-25 13:44:15'),
(20, 20, '1764053068_kado20.png', 1, '2025-11-25 13:44:28'),
(21, 21, '1764053088_kado21.png', 1, '2025-11-25 13:44:48'),
(22, 22, '1764053097_kado22.png', 1, '2025-11-25 13:44:57'),
(23, 23, '1764053106_kado23.png', 1, '2025-11-25 13:45:06'),
(24, 24, '1764053116_kado24.png', 1, '2025-11-25 13:45:16'),
(25, 25, '1764053125_kado25.png', 1, '2025-11-25 13:45:25'),
(26, 26, '1764053136_kado26.png', 1, '2025-11-25 13:45:36'),
(27, 27, '1764053145_kado27.png', 1, '2025-11-25 13:45:45'),
(28, 28, '1764053155_kado28.png', 1, '2025-11-25 13:45:55'),
(29, 29, '1764053257_kado29.png', 1, '2025-11-25 13:47:37'),
(30, 30, '1764070041_kado30.png', 1, '2025-11-25 18:27:21'),
(31, 31, '1764070066_kado31.png', 1, '2025-11-25 18:27:46'),
(32, 32, '1764070101_kado32.png', 1, '2025-11-25 18:28:21'),
(33, 33, '1764071155_kado33.png', 1, '2025-11-25 18:45:55'),
(34, 34, '1764071167_kado34.png', 1, '2025-11-25 18:46:07'),
(35, 35, '1764071178_kado35.png', 1, '2025-11-25 18:46:18'),
(36, 36, '1764071189_kado36.png', 1, '2025-11-25 18:46:29'),
(37, 37, '1764071204_kado37.png', 1, '2025-11-25 18:46:44'),
(38, 38, '1764071215_kado38.png', 1, '2025-11-25 18:46:55'),
(39, 39, '1764071230_kado39.png', 1, '2025-11-25 18:47:10'),
(40, 40, '1764071244_kado40.png', 1, '2025-11-25 18:47:24'),
(41, 41, '1764071255_kado41.png', 1, '2025-11-25 18:47:35'),
(42, 42, '1764071266_kado42.png', 1, '2025-11-25 18:47:46'),
(43, 43, '1764071277_kado43.png', 1, '2025-11-25 18:47:57'),
(44, 44, '1764071289_kado44.png', 1, '2025-11-25 18:48:09'),
(45, 45, '1764071299_kado45.png', 1, '2025-11-25 18:48:19'),
(46, 46, '1764071310_kado46.png', 1, '2025-11-25 18:48:30'),
(47, 47, '1764071321_kado47.png', 1, '2025-11-25 18:48:41'),
(48, 48, '1764071330_kado48.png', 1, '2025-11-25 18:48:50'),
(49, 49, '1764071340_kado49.png', 1, '2025-11-25 18:49:00'),
(50, 50, '1764071354_kado50.png', 1, '2025-11-25 18:49:14');

-- --------------------------------------------------------

--
-- Table structure for table `product_promotions`
--

CREATE TABLE `product_promotions` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT 'Relasi ke products.id',
  `promotion_id` int(11) NOT NULL COMMENT 'Relasi ke promotions.id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_promotions`
--

INSERT INTO `product_promotions` (`id`, `product_id`, `promotion_id`) VALUES
(13, 1, 1),
(14, 2, 1),
(15, 3, 1),
(16, 12, 1),
(17, 13, 1),
(18, 14, 1),
(19, 20, 1),
(20, 21, 1),
(21, 22, 1),
(22, 44, 1),
(23, 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL COMMENT 'Nama promo',
  `type` enum('seasonal','bundle','referral','flash_sale') NOT NULL COMMENT 'Jenis promo',
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'Diskon (%)',
  `start_date` date DEFAULT NULL COMMENT 'Mulai',
  `end_date` date DEFAULT NULL COMMENT 'Berakhir',
  `description` text DEFAULT NULL COMMENT 'Detail promo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `name`, `type`, `discount`, `start_date`, `end_date`, `description`) VALUES
(1, 'Hari LDR sedunia', 'seasonal', 10.00, '2025-11-26', '2025-11-27', 'Diskon spesial untuk 1 hari gas');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `confidence_score` decimal(5,2) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(11) NOT NULL,
  `referrer_id` int(11) DEFAULT NULL,
  `referred_email` varchar(150) DEFAULT NULL,
  `reward_points` int(11) DEFAULT 0,
  `status` enum('pending','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `points_required` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `name`, `points_required`, `description`, `created_at`) VALUES
(1, 'Voucher Rp 50.000', 5000, 'Voucher potongan Rp 50.000 untuk pembelian berikutnya.', '2025-11-15 21:22:37'),
(2, 'Diskon 10%', 2000, 'Diskon 10% untuk satu produk.', '2025-11-15 21:22:37'),
(3, 'Free Shipping', 1000, 'Gratis ongkir untuk satu pesanan.', '2025-11-15 21:22:37'),
(5, 'bonus pita', 6, 'pita aestechtic tambahan', '2025-11-15 21:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `reward_redemptions`
--

CREATE TABLE `reward_redemptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reward_id` int(11) NOT NULL,
  `redeemed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reward_redemptions`
--

INSERT INTO `reward_redemptions` (`id`, `user_id`, `reward_id`, `redeemed_at`) VALUES
(1, 18, 5, '2025-11-15 21:30:17'),
(2, 18, 5, '2025-11-15 21:51:27'),
(3, 18, 5, '2025-11-16 08:49:04'),
(4, 18, 5, '2025-11-24 16:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `security_logs`
--

CREATE TABLE `security_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `courier` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `shipping_cost` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','shipped','delivered') DEFAULT 'pending',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shippings`
--

INSERT INTO `shippings` (`id`, `order_id`, `courier`, `tracking_number`, `shipping_cost`, `status`, `updated_at`) VALUES
(1, 55, 'JNE - REG', NULL, 75000.00, 'pending', '2025-11-25 21:12:28'),
(2, 56, 'JNE - REG', NULL, 75000.00, 'pending', '2025-11-25 21:19:58'),
(3, 57, 'JNE - REG', NULL, 88000.00, 'pending', '2025-11-25 21:52:37'),
(4, 58, 'JNE - REG', NULL, 85000.00, 'pending', '2025-11-25 22:04:23'),
(5, 59, 'JNE - REG', NULL, 88000.00, 'pending', '2025-11-25 22:16:24'),
(6, 60, 'JNE - REG', NULL, 84000.00, 'pending', '2025-11-26 16:07:01'),
(7, 61, 'JNE - JTR<130', NULL, 350000.00, 'pending', '2025-11-26 21:03:05'),
(8, 62, 'JNE - JTR', NULL, 5700000.00, 'pending', '2025-12-02 16:50:49'),
(9, 63, 'JNE - JTR', NULL, 3150000.00, 'pending', '2025-12-02 17:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `role` enum('admin','customer','consultant') DEFAULT 'customer',
  `email_verified` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive','banned') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `profile_image`, `role`, `email_verified`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$1tPRa6g9J2Mbph.b7MYLueK00Im05Es4BC1a4eMJHFwtIEKv3nbu2', '089503451582', '', NULL, 'admin', 1, 'active', '2025-11-25 10:59:46', NULL),
(2, 'Muhammad Ammar', 'ammar@gmail.com', '$2y$10$4VGQeWAcD/I2SGXUv/Pn5.R286X2BAlNJ4kmvHQakkENiooGtB8ei', '0832234546', 'Perumahan Satelit Asri 9B no 5', NULL, 'customer', 1, 'active', '2025-11-25 11:01:13', NULL),
(3, 'Rizky Nazar', 'rizky@gmail.com', '$2y$10$KQioAq9CWdcbsVr66h5e1uxmFuaS./1X/3nOjWwOSNetSBb08Z4yS', '08123456789', '', 'uploads/profile/profile_3_1764043514.jpg', 'customer', 1, 'active', '2025-11-25 11:04:00', '2025-11-25 11:05:14'),
(4, 'Sheryl Jesslyn', 'sze@gmail.com', '$2y$10$IRFeJT1ogbkjNOeFYOkvuODWgDurb1eq0.kz04hXqQ.iQYB75R3UO', '08324234235', '', 'uploads/profile/profile_4_1764043696.jpg', 'customer', 1, 'active', '2025-11-25 11:07:20', '2025-11-25 11:08:16'),
(5, 'Tengxi Wijaya', 'tenxi@gmail.com', '$2y$10$Gy/ZC6srbWRVHVeEgpmrt.GtP/KZ47A0CsUIdIFew2qbbxCtC2lv2', '08325542354', '', 'uploads/profile/profile_5_1764055672.jpg', 'customer', 1, 'active', '2025-11-25 11:10:37', '2025-11-25 14:27:52'),
(6, 'Nayla Killa', 'naykilla@gmail.com', '$2y$10$YRz/ynHa4gRW.WGtEJ4V.Osz4Ocqkf65P/Oh7cqob/.iSFCnPkqTC', '08545436234', '', 'uploads/profile/profile_6_1764044327.jpg', 'customer', 1, 'active', '2025-11-25 11:16:33', '2025-11-25 11:18:47'),
(7, 'rama darmawan', 'rama@gmail.com', '$2y$10$DGdJ5zeuiaOwKFwYTMBFle2EALmh4TFKwAk4LsBIC7Y2qmYsI365S', '08179728488', 'Jalan Jalak putih gang V no 12', 'uploads/profile/profile_7_1764056041.jpg', 'customer', 1, 'active', '2025-11-25 14:14:46', '2025-11-25 14:34:01'),
(8, 'Alibaba', 'alibaba@gmail.com', '$2y$10$fLTvO42dT9tJDtNZyBTYGubKqcpuTJJIVgmtYgZkK84f1dyMPcMYG', '08325542354', '', NULL, 'customer', 1, 'active', '2025-11-26 16:03:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `last_activity` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_integrations`
--
ALTER TABLE `api_integrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `consultation_feedback`
--
ALTER TABLE `consultation_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultation_id` (`consultation_id`);

--
-- Indexes for table `consultation_messages`
--
ALTER TABLE `consultation_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultation_suggestions`
--
ALTER TABLE `consultation_suggestions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultation_id` (`consultation_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `custom_orders`
--
ALTER TABLE `custom_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `external_logs`
--
ALTER TABLE `external_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `integration_id` (`integration_id`);

--
-- Indexes for table `ldr_orders`
--
ALTER TABLE `ldr_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_logs`
--
ALTER TABLE `order_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_image_product` (`product_id`);

--
-- Indexes for table `product_promotions`
--
ALTER TABLE `product_promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_product_promotion` (`product_id`,`promotion_id`),
  ADD KEY `fk_promo_promotion` (`promotion_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referrer_id` (`referrer_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `reward_id` (`reward_id`);

--
-- Indexes for table `security_logs`
--
ALTER TABLE `security_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `analytics`
--
ALTER TABLE `analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `api_integrations`
--
ALTER TABLE `api_integrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `consultation_feedback`
--
ALTER TABLE `consultation_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `consultation_messages`
--
ALTER TABLE `consultation_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `consultation_suggestions`
--
ALTER TABLE `consultation_suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `custom_orders`
--
ALTER TABLE `custom_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `external_logs`
--
ALTER TABLE `external_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ldr_orders`
--
ALTER TABLE `ldr_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `order_logs`
--
ALTER TABLE `order_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `product_promotions`
--
ALTER TABLE `product_promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `security_logs`
--
ALTER TABLE `security_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `consultation_feedback`
--
ALTER TABLE `consultation_feedback`
  ADD CONSTRAINT `consultation_feedback_ibfk_1` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`);

--
-- Constraints for table `consultation_suggestions`
--
ALTER TABLE `consultation_suggestions`
  ADD CONSTRAINT `consultation_suggestions_ibfk_1` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`),
  ADD CONSTRAINT `consultation_suggestions_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_orders`
--
ALTER TABLE `custom_orders`
  ADD CONSTRAINT `custom_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_orders_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `external_logs`
--
ALTER TABLE `external_logs`
  ADD CONSTRAINT `external_logs_ibfk_1` FOREIGN KEY (`integration_id`) REFERENCES `api_integrations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ldr_orders`
--
ALTER TABLE `ldr_orders`
  ADD CONSTRAINT `ldr_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ldr_orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `memberships`
--
ALTER TABLE `memberships`
  ADD CONSTRAINT `memberships_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `fk_image_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_promotions`
--
ALTER TABLE `product_promotions`
  ADD CONSTRAINT `fk_promo_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_promo_promotion` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD CONSTRAINT `recommendations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `recommendations_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `referrals`
--
ALTER TABLE `referrals`
  ADD CONSTRAINT `referrals_ibfk_1` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  ADD CONSTRAINT `reward_redemptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reward_redemptions_ibfk_2` FOREIGN KEY (`reward_id`) REFERENCES `rewards` (`id`);

--
-- Constraints for table `security_logs`
--
ALTER TABLE `security_logs`
  ADD CONSTRAINT `security_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `shippings`
--
ALTER TABLE `shippings`
  ADD CONSTRAINT `shippings_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
