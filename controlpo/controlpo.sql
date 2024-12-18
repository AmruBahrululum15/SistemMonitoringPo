-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2024 at 02:54 PM
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
-- Database: `controlpo`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `no_po` varchar(25) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `pengirim` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `id_barang`, `no_po`, `tanggal`, `pengirim`, `qty`) VALUES
(1, 10, '8111', '2024-09-20 15:15:02', 'Fauzy', 100),
(2, 10, '8111', '2024-09-20 15:15:43', 'Fauzy', 900),
(3, 12, '88112', '2024-09-21 07:53:22', 'Fauzy', 500),
(4, 13, '8113', '2024-09-21 09:19:28', 'Fauzy', 100),
(5, 14, '8111', '2024-09-21 14:02:41', 'Aep', 10),
(6, 10, '8111', '2024-09-21 14:10:45', 'Aep', 1),
(7, 19, '', '2024-09-23 06:47:22', 'Fauzy', 500),
(8, 10, '', '2024-09-25 01:19:41', 'Fauzy', 500),
(9, 21, '', '2024-09-25 01:23:11', 'Fauzy', 500),
(10, 22, '', '2024-09-25 01:46:04', 'aep', 200),
(11, 10, '88112', '2024-09-24 20:58:14', 'Fauzy', 200),
(12, 10, '', '2024-09-25 02:37:02', 'Fauzy', 100),
(13, 23, '', '2024-09-25 03:45:49', 'aep', 500),
(14, 27, '', '2024-09-27 07:19:50', 'aep', 500),
(15, 27, '', '2024-09-27 07:54:34', 'Aep', 100),
(16, 27, '', '2024-09-27 08:31:11', 'Fauzy', 200),
(17, 27, '', '2024-09-27 08:32:24', 'Fauzy', 0),
(18, 28, '', '2024-09-27 08:42:11', 'Fauzy', 0),
(19, 28, '', '2024-09-27 08:43:53', 'aep', 150),
(25, 31, '', '2024-09-27 09:30:24', 'Fauzy', 500),
(26, 31, '', '2024-09-27 13:56:10', 'Fauzy', 1000),
(27, 35, '', '2024-10-15 01:45:01', 'Fauzy', 1000),
(28, 35, '', '2024-10-15 01:45:41', 'aep', 500),
(29, 32, '', '2024-10-18 13:54:16', 'aep', 800),
(30, 34, '', '2024-10-31 13:39:38', 'fauzy', 500),
(31, 32, '', '2024-10-31 13:47:01', 'Fauzy', 100),
(32, 32, '', '2024-10-31 13:51:12', 'Aep', 200),
(33, 32, '', '2024-10-31 14:01:12', 'Aep', 99),
(34, 32, '', '2024-10-31 14:06:24', 'Fauzy', 100),
(35, 40, '', '2024-10-31 14:15:36', 'Aep', 1000),
(36, 40, '', '2024-10-31 14:15:57', 'Fauzy', 1000),
(37, 40, '', '2024-11-01 01:00:32', 'Fauzy', 1000),
(48, 45, '', '2024-11-01 06:52:45', 'Fauzy', 50),
(49, 50, '', '2024-11-01 07:55:06', 'Fauzy', 35);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '12345'),
(5, 'amru@gmail.com', 'amru123');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `no_po` varchar(25) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama_perusahaan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `no_po`, `id_barang`, `tanggal`, `nama_perusahaan`, `qty`) VALUES
(8, '8111', 10, '2024-09-20 14:44:52', 'PT.Nandya Karya Perkasa', 50),
(9, '8111', 10, '2024-09-20 14:46:04', 'PT.Nandya Karya Perkasa', 1),
(10, '8811', 10, '2024-09-21 07:39:18', 'PT.Nandya Karya Perkasa', 10),
(12, '8113', 13, '2024-09-21 09:18:13', 'PT.Nandya Karya Perkasa', 100),
(13, '8111', 14, '2024-09-21 13:59:12', 'PT.Nandya Karya Perkasa', 500),
(14, '8111', 10, '2024-09-21 14:29:20', 'PT.Nandya Karya Perkasa', 15),
(16, '8111', 10, '2024-09-21 14:42:58', 'PT.Nandya Karya Perkasa', 200),
(17, '', 10, '2024-09-21 14:43:16', 'PT.Nandya Karya Perkasa', 400),
(18, '88112', 19, '2024-09-23 06:46:49', 'PT.Rizky Asa Buana', 100),
(19, '8811', 22, '2024-09-25 01:45:42', 'PT.Rizky Assa Buana', 1000),
(22, '81115', 22, '2024-09-27 04:03:18', 'PT.Rizky Assa Buana', 300),
(23, '81115', 22, '2024-09-27 04:06:41', 'PT.Rizky Asa Buana', 1000),
(29, '8811', 15, '2024-09-27 04:10:33', 'PT.Nandya Karya Perkasa', 100),
(32, '270924', 31, '2024-09-27 09:29:46', 'PT.Nandya Karya Perkasa', 500),
(33, '270924', 32, '2024-09-27 09:30:06', 'PT.Nandya Karya Perkasa', 500),
(44, '202410-PO-800910', 41, '2024-11-01 01:46:48', 'PT.Rizky Asa Buana', 300),
(47, '202410-PO-800910', 46, '2024-11-01 02:11:37', 'PT.Rizky Asa Buana', 40),
(48, '202410-PO-800910', 48, '2024-11-01 02:13:03', 'PT.Rizky Asa Buana', 102),
(49, '202410-PO-800910', 42, '2024-11-01 02:14:34', 'PT.Rizky Asa Buana', 303),
(53, '202410-PO-800910', 42, '2024-11-01 02:16:24', 'PT.Rizky Asa Buana', 860),
(58, '202410-PO-800910', 44, '2024-11-01 06:32:38', 'PT.Rizky Asa Buana', 40),
(59, '202410-PO-800910', 50, '2024-11-01 06:34:46', 'PT.Rizky Asa Buana', 5),
(61, '202410-PO-800910', 45, '2024-11-01 06:41:11', 'PT.Rizky Asa Buana', 0),
(62, '202410-PO-800910', 43, '2024-11-01 06:46:24', 'PT.Rizky Asa Buana', 930),
(63, '202410-PO-800910', 43, '2024-11-01 06:46:45', 'PT.Rizky Asa Buana', 519),
(64, '202410-PO-800910', 50, '2024-11-01 07:53:59', 'PT.Rizky Asa Buana', 5);

-- --------------------------------------------------------

--
-- Table structure for table `po`
--

CREATE TABLE `po` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `namabarang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_po` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `po`
--

INSERT INTO `po` (`id`, `nama_perusahaan`, `namabarang`, `jumlah`, `tanggal_po`) VALUES
(1, 'PT.Nandya Karya Perkasa', 'Muffler', 15000, '2024-10-01'),
(2, 'PT.Rizky assa buana', 'lower RH 599', 50000, '2024-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id_barang` int(11) NOT NULL,
  `no_po` varchar(25) NOT NULL,
  `namabarang` varchar(25) NOT NULL,
  `nama_perusahaan` varchar(25) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id_barang`, `no_po`, `namabarang`, `nama_perusahaan`, `stok`) VALUES
(42, '202410-PO-800910', 'LOWER 712 LH', 'PT.Rizky Asa Buana', 2537),
(43, '202410-PO-800910', 'LOWER 712 RH', 'PT.Rizky Asa Buana', 3251),
(45, '202410-PO-800910', 'LOWER 599 RH', 'PT.Rizky Asa Buana', 800),
(46, '202410-PO-800910', 'CONNECTOR APAR TA', 'PT.Rizky Asa Buana', 310),
(47, '202410-PO-800910', 'BRACKET,FR', 'PT.Rizky Asa Buana', 255),
(48, '202410-PO-800910', 'BRACKET,RUBBER BUMPER', 'PT.Rizky Asa Buana', 168),
(49, '202410-PO-800910', 'BRACKET,AIR TANK FR', 'PT.Rizky Asa Buana', 350),
(50, '202410-PO-800910', 'LOWER 599 LH', 'PT.Rizky Asa Buana', 900);

-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE `upload` (
  `id_file` int(11) NOT NULL,
  `namafile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upload`
--

INSERT INTO `upload` (`id_file`, `namafile`) VALUES
(1, 'WIN_20240417_22_13_01_Pro.jpg'),
(2, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(3, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(4, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(5, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(6, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(7, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(8, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(9, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(10, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(11, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(12, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(13, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(14, 'BOQ.xlsx'),
(15, 'BOQ.xlsx'),
(16, 'Penawaran Harga Outher Shell PT NTS.pdf'),
(17, 'Penawaran Harga Outher Shell PT NTS.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `po`
--
ALTER TABLE `po`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id_file`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `upload`
--
ALTER TABLE `upload`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
