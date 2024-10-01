-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2024 at 03:59 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cf-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int(12) NOT NULL,
  `nama_gejala` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `nama_gejala`) VALUES
(1, 'Suhu air kurang dari 28 atau lebih dari 31.5 celcius'),
(2, 'Ph air kurang dari 7.5 atau lebih dari 8.5'),
(3, 'Kecerahan air tidak berada di angka 20-45 cm'),
(4, 'Salinitas kurang dari 10 atau lebih dari 35 g/l'),
(5, 'Udang berenang ke permukaan'),
(6, 'Udang berkumpul di pematang kolam dengan luka di antena'),
(7, 'Hepatopankreas membesar dan berwarna putih kekuningan'),
(8, 'Nafsu Makan Menurun'),
(9, 'Hepatopankreas mengecil dan berwarna keputihan'),
(10, 'Usus Kosong'),
(11, 'Udang Pucat'),
(12, 'Udang memerah di bagian ruas hingga ekor'),
(13, 'Kulit mengelupas bukan pada siklus molting');

-- --------------------------------------------------------

--
-- Table structure for table `pengetahuan`
--

CREATE TABLE `pengetahuan` (
  `id_pengetahuan` int(11) NOT NULL,
  `kode_penyakit` varchar(100) NOT NULL,
  `id_gejala` int(12) NOT NULL,
  `h` float NOT NULL,
  `e` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pengetahuan`
--

INSERT INTO `pengetahuan` (`id_pengetahuan`, `kode_penyakit`, `id_gejala`, `h`, `e`) VALUES
(1, 'P1', 1, 0.27, 0.67),
(2, 'P1', 2, 0.4, 0.67),
(3, 'P1', 3, 0.47, 0.67),
(4, 'P1', 4, 0.33, 0.4),
(5, 'P1', 5, 0.73, 0.4),
(6, 'P1', 6, 0.67, 0.27),
(7, 'P1', 7, 0.6, 0.93),
(8, 'P1', 8, 0.87, 0.4),
(9, 'P2', 1, 0.33, 0.53),
(10, 'P2', 2, 0.4, 0.73),
(11, 'P2', 3, 0.47, 0.6),
(12, 'P2', 4, 0.4, 0.53),
(13, 'P2', 8, 0.8, 0.8),
(14, 'P2', 9, 0.6, 0.73),
(15, 'P2', 10, 0.67, 0.87),
(16, 'P3', 1, 0.4, 0.6),
(17, 'P3', 2, 0.47, 0.6),
(18, 'P3', 3, 0.47, 0.6),
(19, 'P3', 4, 0.33, 0.53),
(20, 'P3', 9, 0.47, 0.67),
(21, 'P3', 11, 0.73, 0.73),
(22, 'P3', 12, 0.8, 0.93),
(23, 'P4', 1, 0.33, 0.6),
(24, 'P4', 2, 0.47, 0.6),
(25, 'P4', 3, 0.53, 0.6),
(26, 'P4', 4, 0.33, 0.6),
(27, 'P4', 8, 0.73, 0.73),
(28, 'P4', 10, 0.8, 0.67),
(29, 'P4', 13, 0.8, 0.87);

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` int(12) NOT NULL,
  `kode_penyakit` varchar(100) NOT NULL,
  `nama_penyakit` varchar(100) NOT NULL,
  `solusi` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `kode_penyakit`, `nama_penyakit`, `solusi`) VALUES
(1, 'P1', 'White Spot Disease (WSD)', 'Menambahkan vitamin c, beta-glucan, fucoidan dan imunostimulan lain pada pakan yang dapat meningkatkan ketahanan udang terhadap virus. Pengeringan kolam dengan benar sebelum tebar.'),
(2, 'P2', 'White Feces Disease (WFD)', 'Menghentikan atau mengurangi pemberian pakan untuk jangka waktu tertentu, gunakan kincir untuk aerasi yang lebih baik, dan beri probiotik 3x dosis penggunaan normal. '),
(3, 'P3', 'Infectious Myonecrosis Virus (IMNV)', 'Memberikan multivitamin hingga kondisi udang kembali normal. Beri probiotik dan kapur dengan rutin di pagi hari, kurangi jumlah pakan 30-40% dari biasanya'),
(4, 'P4', 'Acute Hepatopancreatic Necrosis Disesase (AHPND)', 'Menjaga kualitas air agar tidak terjadi perubahan secara mendadak. Mengontrol kepadatan udang. Rutin melakukan sampling.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indexes for table `pengetahuan`
--
ALTER TABLE `pengetahuan`
  ADD PRIMARY KEY (`id_pengetahuan`);

--
-- Indexes for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id_penyakit` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
