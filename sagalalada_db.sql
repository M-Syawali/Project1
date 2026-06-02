-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jun 2026 pada 12.31
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

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
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'lala', '123'),
(2, 'lala', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
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
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail_pesanan`, `id_pesanan`, `id_menu`, `jumlah`, `pedas`, `catatan`, `subtotal`) VALUES
(12, 14, 18, 1, 'Original', '', 15000),
(13, 14, 17, 1, 'Original', '', 12000),
(14, 14, 19, 1, 'Original', '', 10000),
(15, 15, 18, 3, 'Original', '', 45000),
(16, 15, 17, 4, 'Original', '', 48000),
(17, 16, 18, 1, 'Original', '', 15000),
(18, 16, 17, 1, 'Original', '', 12000),
(19, 16, 19, 1, 'Original', '', 10000),
(20, 17, 18, 1, 'Original', '', 15000),
(21, 17, 17, 1, 'Original', '', 12000),
(22, 18, 19, 1, 'Original', '', 10000),
(23, 19, 19, 2, 'Original', '', 20000),
(24, 19, 18, 1, 'Original', '', 15000),
(25, 20, 19, 1, 'Original', 'jangan pake cabe', 10000),
(26, 21, 17, 1, 'Original', '', 12000),
(27, 22, 17, 1, 'Original', '', 12000),
(28, 23, 19, 1, 'Original', '', 10000),
(29, 24, 18, 1, 'Original', 'masak yang sodap', 15000),
(30, 25, 19, 1, 'Original', 'ppp', 10000),
(31, 25, 18, 1, 'Original', '', 15000),
(32, 26, 18, 1, 'Level 2', '', 15000),
(33, 27, 18, 3, 'Original', '', 45000),
(34, 28, 18, 1, 'Original', 'skekweow', 15000),
(35, 28, 19, 1, 'Original', '', 10000),
(36, 29, 19, 1, 'Original', '', 10000),
(37, 29, 18, 1, 'Original', '', 15000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_menu`
--

CREATE TABLE `kategori_menu` (
  `id_kategori_menu` int(11) NOT NULL,
  `nama_kategori_menu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_menu`
--

INSERT INTO `kategori_menu` (`id_kategori_menu`, `nama_kategori_menu`) VALUES
(18, 'Makanan'),
(19, 'Minuman'),
(21, 'Paket');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
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
-- Struktur dari tabel `meja`
--

CREATE TABLE `meja` (
  `id_meja` int(11) NOT NULL,
  `nomor_meja` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `id_kategori_menu` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `deskripsi_menu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `stok`, `gambar`, `id_kategori_menu`, `id_admin`, `deskripsi_menu`) VALUES
(17, 'ayam goreng', 12000, NULL, '1780228743_img556-1749970206.jpg', 18, 1, 'ddsdddss'),
(18, 'mie', 15000, NULL, '1780243741_mie-pedas-udang-geprek.jpg', 21, 1, 'wddwdw'),
(19, 'es teler', 10000, NULL, '1780243761_es.jpg', 19, 1, 'ddd');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
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
(26, 'yokasa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
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
-- Struktur dari tabel `pesanan`
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
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `tanggal`, `id_meja`, `id_admin`, `total_harga`, `status_pesanan`, `id_pelanggan`, `nomor_pesanan`) VALUES
(14, '2026-05-31 23:09:56', NULL, NULL, 37000, 'dibayar', 2, NULL),
(15, '2026-05-31 23:30:00', NULL, NULL, 93000, 'dibayar', 12, NULL),
(16, '2026-06-01 09:34:14', NULL, NULL, 37000, 'dibatalkan', 13, NULL),
(17, '2026-06-01 20:31:53', NULL, NULL, 27000, 'dibatalkan', 14, NULL),
(18, '2026-06-01 21:24:42', NULL, NULL, 10000, 'dibatalkan', 15, 'SGL-20260601-383'),
(19, '2026-06-01 21:32:00', NULL, NULL, 35000, 'dibayar', 16, 'SGL-20260601-220'),
(20, '2026-06-01 21:36:52', NULL, NULL, 10000, 'dibayar', 17, 'SGL-20260601-632'),
(21, '2026-06-01 21:39:38', NULL, NULL, 12000, 'dibayar', 18, 'SGL-20260601-618'),
(22, '2026-06-02 06:13:35', NULL, NULL, 12000, 'dibayar', 19, 'SGL-20260602-703'),
(23, '2026-06-02 06:45:30', NULL, NULL, 10000, 'dibayar', 20, 'SGL-20260602-359'),
(24, '2026-06-02 07:22:52', NULL, NULL, 15000, 'dibayar', 21, 'SGL-20260602-420'),
(25, '2026-06-02 08:07:45', NULL, NULL, 25000, 'dibayar', 22, 'SGL-20260602-888'),
(26, '2026-06-02 08:55:16', NULL, NULL, 15000, 'dibatalkan', 23, 'SGL-20260602-472'),
(27, '2026-06-02 10:15:01', NULL, NULL, 45000, 'dibayar', 24, 'SGL-20260602-387'),
(28, '2026-06-02 16:34:03', NULL, NULL, 25000, 'selesai', 25, 'SGL-20260602-118'),
(29, '2026-06-02 16:35:55', NULL, NULL, 25000, 'dibatalkan', 26, 'SGL-20260602-270');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail_pesanan`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `kategori_menu`
--
ALTER TABLE `kategori_menu`
  ADD PRIMARY KEY (`id_kategori_menu`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_pembayaran` (`id_pembayaran`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indeks untuk tabel `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id_meja`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_kategori` (`id_kategori_menu`),
  ADD KEY `fk_admin_menu_baru` (`id_admin`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `id_pesanan_2` (`id_pesanan`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_meja` (`id_meja`),
  ADD KEY `id_user` (`id_admin`),
  ADD KEY `fk_pelanggan_pesanan` (`id_pelanggan`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `kategori_menu`
--
ALTER TABLE `kategori_menu`
  MODIFY `id_kategori_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `meja`
--
ALTER TABLE `meja`
  MODIFY `id_meja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran` (`id_pembayaran`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_admin_menu` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_admin_menu_baru` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_kategori_menu`) REFERENCES `kategori_menu` (`id_kategori_menu`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pelanggan_pesanan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_meja`) REFERENCES `meja` (`id_meja`),
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
