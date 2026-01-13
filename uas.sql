-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 13, 2026 at 10:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int NOT NULL,
  `kode_anggota` varchar(10) NOT NULL,
  `nama_anggota` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text,
  `no_hp` varchar(15) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `kode_anggota`, `nama_anggota`, `jenis_kelamin`, `alamat`, `no_hp`, `created_at`) VALUES
(2, 'AP001', 'Aldyana', 'L', 'Cipatujah', '081214398286', '2026-01-12 11:16:16'),
(3, 'AP002', 'Agus Susanto', 'P', 'Tasikmalaya', '081245785825', '2026-01-12 11:16:54'),
(5, 'AP003', 'Parhan', 'L', 'Ciawi', '084578251425', '2026-01-13 03:51:06'),
(6, 'AP004', 'Fityan', 'L', 'Tasikmalaya', '081245783625', '2026-01-13 06:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int NOT NULL,
  `kode_buku` varchar(30) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` year NOT NULL,
  `id_kategori` varchar(10) NOT NULL,
  `stok` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `kode_buku`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `id_kategori`, `stok`) VALUES
(1, 'SJR/IS/200', 'Sejarah Dunia', 'Al-Farabi', 'Gramedia', 2003, '1', 2),
(3, 'SJR/IN/200', 'Madilog', 'Al-Farabi', 'Gramedia', 2005, '1', 1),
(4, 'SJR/IN/200', 'Sejarah Indonesia', 'Al-Farabi', 'Gramedia', 2010, '1', 1),
(5, 'PND/AG/200', 'Pendidikan Agama ', 'Al-Farabi', 'Gramedia', 2015, '3', 4),
(7, 'PND/BE/2000', 'Bahasa Inggris', 'Al-Funjabi', 'Gramedia', 2006, '3', 4),
(8, 'PMR/CB/300', 'Coding Dasar', 'Al-Fatih', 'Gramedia', 2015, '5', 5);

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id_detail` int NOT NULL,
  `id_peminjaman` int NOT NULL,
  `id_buku` int NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_peminjaman`
--

INSERT INTO `detail_peminjaman` (`id_detail`, `id_peminjaman`, `id_buku`, `jumlah`) VALUES
(1, 5, 3, 1),
(2, 5, 1, 1),
(3, 6, 7, 1),
(4, 7, 3, 1),
(5, 8, 8, 1),
(6, 8, 4, 1),
(7, 9, 4, 2),
(8, 10, 5, 1),
(9, 11, 1, 1),
(10, 12, 5, 1),
(11, 13, 1, 1),
(12, 14, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Sejarah'),
(2, 'Sikologi'),
(3, 'Pendidikan'),
(5, 'Pemerograman');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int NOT NULL,
  `no_pinjam` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_anggota` int NOT NULL,
  `id_users` int NOT NULL,
  `id_buku` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `status` enum('Dipinjam','Dikembalikan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `no_pinjam`, `id_anggota`, `id_users`, `id_buku`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(11, 'PINJ/20260113/001', 2, 1, 1, '2026-01-13', '2026-01-20', 'Dipinjam'),
(12, 'PINJ/20260113/002', 5, 1, 5, '2026-01-13', '2026-01-12', 'Dikembalikan'),
(13, 'PINJ/20260113/003', 3, 1, 1, '2026-01-13', '2026-01-20', 'Dikembalikan'),
(14, 'PINJ/20260113/004', 2, 1, 1, '2026-01-13', '2026-01-20', 'Dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int NOT NULL,
  `nama_users` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `nama_users`, `email`, `password`, `created_at`) VALUES
(1, 'Aldyana', 'aldyana029@gmail.com', '1234', '2026-01-10 07:12:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
