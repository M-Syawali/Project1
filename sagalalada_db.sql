-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2026 at 05:55 AM
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
-- Database: `sagalalada_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'lala', '123'),
(2, 'lala', '123');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail_pesanan` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `pedas` varchar(50) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail_pesanan`, `id_pesanan`, `id_menu`, `jumlah`, `pedas`, `catatan`, `subtotal`) VALUES
(14, 14, 19, 1, 'Original', '', 10000),
(19, 16, 19, 1, 'Original', '', 10000),
(22, 18, 19, 1, 'Original', '', 10000),
(23, 19, 19, 2, 'Original', '', 20000),
(25, 20, 19, 1, 'Original', 'jangan pake cabe', 10000),
(28, 23, 19, 1, 'Original', '', 10000),
(30, 25, 19, 1, 'Original', 'ppp', 10000),
(35, 28, 19, 1, 'Original', '', 10000),
(36, 29, 19, 1, 'Original', '', 10000),
(38, 30, 19, 1, 'Original', '', 10000),
(40, 31, 19, 1, 'Original', '', 10000),
(41, 32, 19, 1, 'Original', '', 10000),
(43, 33, 19, 1, 'Original', '', 10000),
(62, 59, 19, 1, 'Original', 'Tidak pakai durian', 10000),
(63, 59, 21, 1, 'Original', 'Jangan pakai serundeng', 12000),
(66, 60, 21, 1, 'Original', '', 12000),
(76, 70, 21, 1, 'Original', '', 12000),
(82, 76, 21, 2, 'Original', '', 24000),
(83, 77, 19, 2, 'Original', '', 20000),
(84, 78, 24, 1, 'Original', '', 12000),
(85, 78, 23, 1, 'Original', '', 10000),
(86, 79, 24, 1, 'Original', '', 12000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_menu`
--

CREATE TABLE `kategori_menu` (
  `id_kategori_menu` int(11) NOT NULL,
  `nama_kategori_menu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_menu`
--

INSERT INTO `kategori_menu` (`id_kategori_menu`, `nama_kategori_menu`) VALUES
(18, 'Makanan'),
(19, 'Minuman'),
(22, 'paket');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `id_pembayaran` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `tanggal_laporan` datetime DEFAULT current_timestamp(),
  `total_pendapatan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `id_meja` int(11) NOT NULL,
  `nomor_meja` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`id_meja`, `nomor_meja`) VALUES
(1, '01');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `id_kategori_menu` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `deskripsi_menu` text NOT NULL,
  `status` enum('tersedia','habis') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `stok`, `gambar`, `id_kategori_menu`, `id_admin`, `deskripsi_menu`, `status`) VALUES
(19, 'es teler', 10000, 0, '1780243761_es.jpg', 19, 1, 'ddd', 'habis'),
(21, 'ayam ', 12000, 0, '1780624861_ayam-goreng-lengkuas.jpg', 18, 1, 'enakk', 'habis'),
(23, 'Ayam', 10000, 0, '1780651446_Coto-Makassar.jpg', 18, 1, 'aym', 'habis'),
(24, 'jepang', 12000, 4, '1780885008_images.jpg', 22, 1, 'djdijwidjiw', 'habis');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`) VALUES
(1, 'ghisya'),
(2, 'nanag'),
(3, 'pot'),
(4, 'nopall'),
(5, 'lala'),
(6, 'pok'),
(7, 'anton'),
(8, 'asepp'),
(9, 'roger'),
(10, 'tatang'),
(11, 'lula'),
(12, 'ani'),
(13, 'D'),
(14, 'Diaz Husein Alfian'),
(15, 'yyyy'),
(16, 'Doyok'),
(17, 'Wleee'),
(18, 'Hansen'),
(19, 'shiball'),
(20, 'Yowaimo'),
(21, 'Kepo'),
(22, 'Skebung'),
(23, 'Yor'),
(24, 'yeyy'),
(25, 'weilah'),
(26, 'yokasa'),
(27, 'weee'),
(28, 'desi'),
(29, 'nabil'),
(30, 'sultan'),
(31, 'mandala'),
(32, 'lulu'),
(33, 'nunu'),
(34, 'nanang'),
(35, 'lola'),
(36, 'ddd'),
(37, 'nunung'),
(38, 'nice'),
(39, 'diaz'),
(40, 'Aep'),
(41, 'lalala'),
(42, 'kakang'),
(43, 'yyat'),
(44, 'wawa'),
(45, 'syawal'),
(46, 'cucu'),
(47, 'awa'),
(48, 'lois'),
(49, 'es'),
(50, '111eewd'),
(51, 'gg');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `metode_bayar` enum('cash','qris','debit') DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `tanggal_bayar` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `id_meja` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `status_pesanan` enum('pending','diproses','selesai','dibayar','dibatalkan') DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `nomor_pesanan` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `tanggal`, `id_meja`, `id_admin`, `total_harga`, `status_pesanan`, `id_pelanggan`, `nomor_pesanan`) VALUES
(14, '2026-05-31 23:09:56', NULL, NULL, 37000, 'dibatalkan', 2, NULL),
(15, '2026-05-31 23:30:00', NULL, NULL, 93000, 'dibatalkan', 12, NULL),
(16, '2026-06-01 09:34:14', NULL, NULL, 37000, 'dibatalkan', 13, NULL),
(17, '2026-06-01 20:31:53', NULL, NULL, 27000, 'dibatalkan', 14, NULL),
(18, '2026-06-01 21:24:42', NULL, NULL, 10000, 'dibatalkan', 15, 'SGL-20260601-383'),
(19, '2026-06-01 21:32:00', NULL, NULL, 35000, 'dibatalkan', 16, 'SGL-20260601-220'),
(20, '2026-06-01 21:36:52', NULL, NULL, 10000, 'dibatalkan', 17, 'SGL-20260601-632'),
(21, '2026-06-01 21:39:38', NULL, NULL, 12000, 'dibatalkan', 18, 'SGL-20260601-618'),
(22, '2026-06-02 06:13:35', NULL, NULL, 12000, 'dibatalkan', 19, 'SGL-20260602-703'),
(23, '2026-06-02 06:45:30', NULL, NULL, 10000, 'dibatalkan', 20, 'SGL-20260602-359'),
(24, '2026-06-02 07:22:52', NULL, NULL, 15000, 'dibatalkan', 21, 'SGL-20260602-420'),
(25, '2026-06-02 08:07:45', NULL, NULL, 25000, 'dibatalkan', 22, 'SGL-20260602-888'),
(26, '2026-06-02 08:55:16', NULL, NULL, 15000, 'dibatalkan', 23, 'SGL-20260602-472'),
(27, '2026-06-02 10:15:01', NULL, NULL, 45000, 'dibatalkan', 24, 'SGL-20260602-387'),
(28, '2026-06-02 16:34:03', NULL, NULL, 25000, 'dibatalkan', 25, 'SGL-20260602-118'),
(29, '2026-06-02 16:35:55', NULL, NULL, 25000, 'dibatalkan', 26, 'SGL-20260602-270'),
(30, '2026-06-04 08:38:09', NULL, NULL, 10000, 'dibatalkan', 27, 'SGL-20260604-935'),
(31, '2026-06-04 14:19:29', NULL, NULL, 25000, 'dibatalkan', 28, 'SGL-20260604-243'),
(32, '2026-06-04 14:20:33', NULL, NULL, 10000, 'dibatalkan', 29, 'SGL-20260604-363'),
(33, '2026-06-04 14:35:00', NULL, NULL, 25000, 'dibatalkan', 30, 'SGL-20260604-313'),
(34, '2026-06-04 14:35:34', NULL, NULL, 15000, 'dibatalkan', 31, 'SGL-20260604-323'),
(35, '2026-06-04 16:27:21', NULL, NULL, 15000, 'dibatalkan', 31, 'SGL-20260604-340'),
(36, '2026-06-04 16:28:16', NULL, NULL, 15000, 'dibatalkan', 30, 'SGL-20260604-588'),
(37, '2026-06-04 23:33:39', 1, NULL, 30000, 'dibatalkan', 32, 'SGL-20260604-124'),
(41, '2026-06-04 23:59:58', NULL, NULL, 45000, 'dibatalkan', 5, 'SGL-20260604-426'),
(43, '2026-06-05 00:01:27', NULL, NULL, 45000, 'dibatalkan', 5, 'SGL-20260604-651'),
(45, '2026-06-05 00:02:24', NULL, NULL, 45000, 'dibatalkan', 5, 'SGL-20260604-877'),
(46, '2026-06-05 00:03:56', NULL, NULL, 45000, 'dibatalkan', 5, 'SGL-20260604-488'),
(47, '2026-06-05 00:05:59', NULL, NULL, 30000, 'dibatalkan', 34, 'SGL-20260604-459'),
(48, '2026-06-05 00:08:22', NULL, NULL, 15000, 'dibatalkan', 11, 'SGL-20260604-762'),
(49, '2026-06-05 00:16:04', NULL, NULL, 15000, 'dibatalkan', 35, 'SGL-20260604-403'),
(50, '2026-06-05 00:19:42', NULL, NULL, 30000, 'dibatalkan', 36, 'SGL-20260604-571'),
(51, '2026-06-05 00:30:15', 1, NULL, 60000, 'dibatalkan', 5, 'SGL-20260604-145'),
(52, '2026-06-05 00:33:35', 1, NULL, 15000, 'dibatalkan', 10, 'SGL-20260604-348'),
(53, '2026-06-05 00:39:15', 1, NULL, 15000, 'dibatalkan', 5, 'SGL-20260604-730'),
(54, '2026-06-05 00:46:34', 1, NULL, 30000, 'dibatalkan', 37, 'SGL-20260604-935'),
(55, '2026-06-05 00:50:55', 1, NULL, 15000, 'dibatalkan', 34, 'SGL-20260604-912'),
(56, '2026-06-05 00:52:03', NULL, NULL, 15000, 'dibatalkan', 38, 'SGL-20260604-257'),
(57, '2026-06-05 08:53:12', NULL, NULL, 15000, 'dibatalkan', 2, 'SGL-20260605-499'),
(58, '2026-06-05 08:54:22', 1, NULL, 15000, 'dibatalkan', 39, 'SGL-20260605-730'),
(59, '2026-06-05 09:47:04', 1, NULL, 37000, 'dibatalkan', 40, 'SGL-20260605-106'),
(60, '2026-06-05 09:59:37', 1, NULL, 42000, 'selesai', 39, 'SGL-20260605-288'),
(61, '2026-06-05 10:02:38', 1, NULL, 15000, 'selesai', 41, 'SGL-20260605-716'),
(62, '2026-06-05 10:08:46', 1, NULL, 15000, 'selesai', 41, 'SGL-20260605-671'),
(63, '2026-06-05 10:12:19', 1, NULL, 15000, 'dibatalkan', 5, 'SGL-20260605-458'),
(64, '2026-06-05 10:35:00', 1, NULL, 15000, 'dibatalkan', 34, 'SGL-20260605-935'),
(65, '2026-06-05 10:37:03', 1, NULL, 15000, 'dibatalkan', 42, 'SGL-20260605-885'),
(66, '2026-06-05 14:39:59', NULL, NULL, 30000, 'selesai', 43, 'SGL-20260605-515'),
(67, '2026-06-05 14:49:47', NULL, NULL, 15000, 'selesai', 44, 'SGL-20260605-376'),
(68, '2026-06-05 15:06:29', NULL, NULL, 15000, 'dibatalkan', 39, 'SGL-20260605-322'),
(69, '2026-06-05 15:14:28', NULL, NULL, 15000, 'selesai', 40, 'SGL-20260605-208'),
(70, '2026-06-05 15:16:33', NULL, NULL, 12000, 'dibatalkan', 45, 'SGL-20260605-120'),
(71, '2026-06-05 15:22:39', NULL, NULL, 15000, 'selesai', 46, 'SGL-20260605-684'),
(72, '2026-06-05 15:29:33', NULL, NULL, 15000, 'selesai', 45, 'SGL-20260605-706'),
(73, '2026-06-05 15:50:54', NULL, NULL, 15000, 'selesai', 47, 'SGL-20260605-185'),
(74, '2026-06-05 16:17:35', NULL, NULL, 15000, 'selesai', 45, 'SGL-20260605-160'),
(75, '2026-06-05 16:28:23', 1, NULL, 30000, 'selesai', 48, 'SGL-20260605-145'),
(76, '2026-06-08 09:22:37', NULL, NULL, 24000, 'selesai', 11, 'SGL-20260608-220'),
(77, '2026-06-08 09:26:51', NULL, NULL, 20000, 'dibatalkan', 49, 'SGL-20260608-289'),
(78, '2026-06-08 09:35:19', NULL, NULL, 22000, 'dibatalkan', 50, 'SGL-20260608-462'),
(79, '2026-06-08 09:36:24', NULL, NULL, 12000, 'selesai', 51, 'SGL-20260608-506');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail_pesanan`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `kategori_menu`
--
ALTER TABLE `kategori_menu`
  ADD PRIMARY KEY (`id_kategori_menu`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_pembayaran` (`id_pembayaran`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id_meja`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_kategori` (`id_kategori_menu`),
  ADD KEY `fk_admin_menu_baru` (`id_admin`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `id_pesanan_2` (`id_pesanan`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_meja` (`id_meja`),
  ADD KEY `id_user` (`id_admin`),
  ADD KEY `fk_pelanggan_pesanan` (`id_pelanggan`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `kategori_menu`
--
ALTER TABLE `kategori_menu`
  MODIFY `id_kategori_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meja`
--
ALTER TABLE `meja`
  MODIFY `id_meja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE;

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran` (`id_pembayaran`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_admin_menu` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_admin_menu_baru` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_kategori_menu`) REFERENCES `kategori_menu` (`id_kategori_menu`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pelanggan_pesanan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_meja`) REFERENCES `meja` (`id_meja`),
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
