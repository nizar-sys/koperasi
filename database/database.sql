-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 18, 2021 at 12:17 PM
-- Server version: 10.3.29-MariaDB-cll-lve
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u3794268_kopkar`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('0b7eae099b90e4302f20d657b3738364', '182.2.167.52', 'Mozilla/5.0 (Android 11; Mobile; rv:90.0) Gecko/90.0 Firefox/90.0', 1626513925, 'a:4:{s:9:\"user_data\";s:0:\"\";s:5:\"login\";b:1;s:6:\"u_name\";s:5:\"admin\";s:5:\"level\";s:5:\"admin\";}'),
('23979bc7d19344912e64133822d7a92c', '114.4.215.127', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 1626546816, 'a:4:{s:9:\"user_data\";s:0:\"\";s:5:\"login\";b:1;s:6:\"u_name\";s:5:\"admin\";s:5:\"level\";s:5:\"admin\";}'),
('5cf502caec7007f5d6c17ab4368acc45', '140.213.11.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 1626576469, '');

-- --------------------------------------------------------

--
-- Table structure for table `jns_akun`
--

CREATE TABLE `jns_akun` (
  `id` bigint(20) NOT NULL,
  `kd_aktiva` varchar(5) DEFAULT NULL,
  `jns_trans` varchar(50) NOT NULL,
  `akun` enum('Aktiva','Pasiva') DEFAULT NULL,
  `laba_rugi` enum('','PENDAPATAN','BIAYA') NOT NULL DEFAULT '',
  `pemasukan` enum('Y','N') DEFAULT NULL,
  `pengeluaran` enum('Y','N') DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jns_akun`
--

INSERT INTO `jns_akun` (`id`, `kd_aktiva`, `jns_trans`, `akun`, `laba_rugi`, `pemasukan`, `pengeluaran`, `aktif`) VALUES
(5, 'A5', 'Piutang USP', 'Aktiva', '', 'Y', 'Y', 'Y'),
(6, 'A6', 'Piutang USP (Brg. Sekunder)', 'Aktiva', '', 'Y', 'Y', 'Y'),
(7, 'A7', 'Piutang USP (Sembako)', 'Aktiva', '', 'Y', 'Y', 'Y'),
(8, 'A8', 'Persediaan Barang dan Cetakan', 'Aktiva', '', 'Y', 'Y', 'Y'),
(9, 'A9', 'Persediaan Barang Waserda', 'Aktiva', '', 'Y', 'Y', 'Y'),
(10, 'B', 'Investasi Jangka Panjang', 'Aktiva', '', NULL, NULL, 'Y'),
(11, 'B1', 'Modal Puskowan Jabar', 'Aktiva', '', 'Y', 'Y', 'Y'),
(12, 'B2', 'Modal Puskowan DKI', 'Aktiva', '', 'Y', 'Y', 'Y'),
(13, 'B3', 'Modal Coopay', 'Aktiva', '', 'Y', 'Y', 'Y'),
(14, 'B4', 'Modal Beeholiday', 'Aktiva', '', 'Y', 'Y', 'Y'),
(15, 'B5', 'Modal Travel(Umroh)', 'Aktiva', '', 'Y', 'Y', 'Y'),
(16, 'B6', 'Modal KUHINDO', 'Aktiva', '', 'Y', 'Y', 'Y'),
(17, 'B7', 'Modal Konsinyasi dan YPKI', 'Aktiva', '', 'Y', 'Y', 'Y'),
(18, 'C', 'Aktiva Tetap', 'Aktiva', '', NULL, NULL, 'Y'),
(19, 'C1', 'Tanah (di 3 Lokasi)', 'Aktiva', '', 'Y', 'Y', 'Y'),
(20, 'C2', 'Bangunan (di 3 Lokasi)', 'Aktiva', '', 'Y', 'Y', 'Y'),
(21, 'C3', 'Perlatan Kantor', 'Aktiva', '', 'Y', 'Y', 'Y'),
(22, 'C4', 'Instalasi Listrik', 'Aktiva', '', 'Y', 'Y', 'Y'),
(23, 'C5', 'Akumulasi Penyusutan', 'Aktiva', '', 'Y', 'Y', 'Y'),
(24, 'D', 'Hutang Lancar', 'Pasiva', '', 'Y', 'Y', 'Y'),
(25, 'D2', 'Simpanan Berjangka', 'Pasiva', '', 'Y', 'Y', 'Y'),
(26, 'D3', 'Simpanan Lebaran', 'Pasiva', '', 'Y', 'Y', 'Y'),
(27, 'D4', 'Tabungan Ananda', 'Pasiva', '', 'Y', 'Y', 'N'),
(28, 'D5', 'Tabungan Umroh', 'Pasiva', '', 'Y', 'Y', 'Y'),
(29, 'D6', 'DANA BERGULIR PEMKOT BEKASI', 'Pasiva', '', 'Y', 'Y', 'Y'),
(30, 'D7', 'Cadangan Pajak & Tab. Ananda', 'Pasiva', '', 'Y', 'Y', 'Y'),
(31, 'D8', 'Dana Pendidikan', 'Pasiva', '', 'Y', 'Y', 'Y'),
(32, 'D1', 'Simpanan Sukarela', 'Pasiva', '', 'Y', 'Y', 'Y'),
(33, 'D9', 'Dana Sosial', 'Pasiva', '', 'Y', 'Y', 'Y'),
(34, 'D10', 'Dana Lain-Lain', 'Pasiva', '', 'Y', 'Y', 'Y'),
(35, 'E', 'Hutang Jangka Panjang', 'Pasiva', '', NULL, NULL, 'Y'),
(36, 'E1', 'DANA BERGULIR PERKASA', 'Pasiva', '', 'Y', 'Y', 'Y'),
(37, 'E2', 'LPDB-KUMKM', 'Pasiva', '', 'Y', 'Y', 'Y'),
(38, 'F', 'Modal Sendiri', 'Pasiva', '', NULL, NULL, 'Y'),
(39, 'F3', 'Dana Cadangan Resiko', 'Pasiva', '', 'Y', 'Y', 'Y'),
(40, 'F1', 'Simpanan Pokok/Khusus', 'Pasiva', '', 'Y', 'Y', 'Y'),
(41, 'F2', 'Simpanan Wajib', 'Pasiva', '', 'Y', 'Y', 'Y'),
(42, 'F4', 'Dana Cadangan Koperasi', 'Pasiva', '', 'Y', 'Y', 'Y'),
(43, 'F5', 'Hibah', 'Pasiva', '', 'Y', 'Y', 'N'),
(44, 'F6', 'SHU Tahun Berjalan', 'Pasiva', '', 'Y', 'Y', 'Y'),
(45, 'J', 'Pendapatan Usaha', 'Pasiva', '', NULL, NULL, 'Y'),
(46, 'J1', 'Pendapatan Jasa Pinjaman (USP)', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(47, 'J2', 'Pendapatan Administrasi Pinjaman', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(48, 'J3', 'Jasa Pinjaman Brg. Sekunder', 'Pasiva', 'PENDAPATAN', 'Y', 'N', 'Y'),
(49, 'J4', 'Jasa Pinjaman Sembako', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(50, 'K', 'Pendapatan Dari Sumber Lain', 'Pasiva', '', NULL, NULL, 'Y'),
(51, 'K1', 'Pendapatan Bunga Bank', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(52, 'K2', 'Pendapatan Denda Keterlambatan', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(53, 'K3', 'Keuntungan Paket Lebaran', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(54, 'K4', 'Penjualan Materai', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'N'),
(55, 'K5', 'Penjualan Buku (TA dan PJ)', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(56, 'K6', 'Keuntungan Konsinyasi', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(57, 'K7', 'Keuntungan Beeholiday', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(58, 'K8', 'Keuntungan Cooppay', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(59, 'K9', 'Uang Sewa Rumah', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(60, 'K10', 'Keuntungan Asuransi', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(61, 'K11', 'Keuntungan Daging & Kue Lebaran', 'Pasiva', 'PENDAPATAN', 'Y', 'Y', 'Y'),
(62, 'L', 'Biaya', 'Aktiva', '', NULL, NULL, 'Y'),
(63, 'L1', 'Beban Biaya Usaha (Operasional)', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(64, 'L2', 'Beban Hasil Simpanan Berjangka', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(65, 'L3', 'Biaya Penyusutan', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(66, 'L4', 'Biaya Bunga Pinjaman Bank', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(67, 'L5', 'Sumbangan dan Iuran', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(68, 'L6', 'Biaya RAT', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(69, 'L7', 'Biaya Dana Hibah, Perijinan, dll', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(70, 'L8', 'Biaya Pameran (Promosi)', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(71, 'L9', 'THR Pengurus dan Anggota', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(72, 'L10', 'Biaya Percetakan', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(73, 'L11', 'Biaya Rapat-Rapat Luar Kota', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(74, 'L12', 'Pembelian Materai', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(75, 'L13', 'Bagi Hasil Tabungan Ananda', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y'),
(76, 'L14', 'Cadangan Pajak/Pajak dan PBB', 'Aktiva', 'BIAYA', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `jns_angsuran`
--

CREATE TABLE `jns_angsuran` (
  `id` bigint(20) NOT NULL,
  `ket` int(11) NOT NULL,
  `masa_kerja` int(11) NOT NULL,
  `masa_kerja_max` int(11) NOT NULL,
  `aktif` enum('Y','T','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jns_angsuran`
--

INSERT INTO `jns_angsuran` (`id`, `ket`, `masa_kerja`, `masa_kerja_max`, `aktif`) VALUES
(1, 1, 0, 2, 'Y'),
(2, 24, 3, 8, 'Y'),
(3, 30, 9, 11, 'Y'),
(4, 36, 12, 14, 'Y'),
(5, 42, 15, 17, 'Y'),
(6, 48, 18, 20, 'Y'),
(7, 54, 21, 23, 'Y'),
(8, 60, 24, 0, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `jns_pinjam`
--

CREATE TABLE `jns_pinjam` (
  `id` int(5) NOT NULL,
  `kode_jenis_pinjam` varchar(10) NOT NULL,
  `jns_pinjam` varchar(30) NOT NULL,
  `tampil` enum('Y','T') NOT NULL,
  `vcCOACode` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jns_pinjam`
--

INSERT INTO `jns_pinjam` (`id`, `kode_jenis_pinjam`, `jns_pinjam`, `tampil`, `vcCOACode`) VALUES
(3, 'USP', 'USP', 'Y', '00.10.20.120'),
(4, 'RTL', 'RETAIL', 'Y', '00.10.10.120');

-- --------------------------------------------------------

--
-- Table structure for table `jns_simpan`
--

CREATE TABLE `jns_simpan` (
  `id` int(5) NOT NULL,
  `jns_simpan` varchar(30) NOT NULL,
  `vcCOACode` varchar(12) NOT NULL,
  `jumlah` double NOT NULL,
  `tampil` enum('Y','T') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jns_simpan`
--

INSERT INTO `jns_simpan` (`id`, `jns_simpan`, `vcCOACode`, `jumlah`, `tampil`) VALUES
(1, 'Simpanan Berjangka', '00.10.10.120', 0, 'Y'),
(2, 'Simpanan Pokok', '00.10.10.120', 100000, 'Y'),
(43, 'Simpanan Wajib', '00.10.10.100', 50000, 'Y'),
(44, 'Tabungan Koperasi', '00.10.10.000', 0, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `nama_kas_tbl`
--

CREATE TABLE `nama_kas_tbl` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `vcCOACode` varchar(12) NOT NULL,
  `aktif` enum('Y','T') NOT NULL,
  `tmpl_simpan` enum('Y','T') NOT NULL,
  `tmpl_penarikan` enum('Y','T') NOT NULL,
  `tmpl_pinjaman` enum('Y','T') NOT NULL,
  `tmpl_bayar` enum('Y','T') NOT NULL,
  `tmpl_pemasukan` enum('Y','T') NOT NULL,
  `tmpl_pengeluaran` enum('Y','T') NOT NULL,
  `tmpl_transfer` enum('Y','T') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nama_kas_tbl`
--

INSERT INTO `nama_kas_tbl` (`id`, `nama`, `vcCOACode`, `aktif`, `tmpl_simpan`, `tmpl_penarikan`, `tmpl_pinjaman`, `tmpl_bayar`, `tmpl_pemasukan`, `tmpl_pengeluaran`, `tmpl_transfer`) VALUES
(1, 'Kas Tunai', '00.10.10.110', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(2, 'Bank Mandiri', '00.10.10.120', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(3, 'BPRS PATRIOT Kota Bekasi', '00.10.10.130', 'Y', 'T', 'T', 'T', 'T', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id_kerja` varchar(5) NOT NULL,
  `jenis_kerja` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` (`id_kerja`, `jenis_kerja`) VALUES
('1', 'TNI'),
('2', 'PNS'),
('3', 'Karyawan Swasta'),
('4', 'Guru'),
('5', 'Buruh'),
('6', 'Tani'),
('7', 'Pedagang'),
('8', 'Wiraswasta'),
('9', 'Mengurus Rumah Tangga'),
('99', 'Lainnya'),
('98', 'Pensiunan'),
('97', 'Penjahit');

-- --------------------------------------------------------

--
-- Table structure for table `suku_bunga`
--

CREATE TABLE `suku_bunga` (
  `id` int(10) NOT NULL,
  `opsi_key` varchar(20) NOT NULL,
  `opsi_val` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suku_bunga`
--

INSERT INTO `suku_bunga` (`id`, `opsi_key`, `opsi_val`) VALUES
(1, 'bg_tab', '0'),
(2, 'bg_pinjam', '2'),
(3, 'biaya_adm', '10000'),
(4, 'denda', '1'),
(5, 'denda_hari', '15'),
(6, 'dana_cadangan', '40'),
(7, 'jasa_anggota', '40'),
(8, 'dana_pengurus', '5'),
(9, 'dana_karyawan', '5'),
(10, 'dana_pend', '5'),
(11, 'dana_sosial', '5'),
(12, 'jasa_usaha', '70'),
(13, 'jasa_modal', '30'),
(14, 'pjk_pph', '5'),
(15, 'pinjaman_bunga_tipe', 'A'),
(16, 'cadangan_resiko', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anggota`
--

CREATE TABLE `tbl_anggota` (
  `id` bigint(20) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `identitas` varchar(255) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tmp_lahir` varchar(225) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `masuk_kerja` date NOT NULL,
  `status` varchar(30) NOT NULL,
  `agama` varchar(30) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(255) NOT NULL,
  `notelp` varchar(12) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `jabatan_id` int(10) NOT NULL,
  `jenis_anggota` enum('Biasa','Luar Biasa') NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `pass_word` varchar(225) NOT NULL,
  `file_pic` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id`, `nik`, `nama`, `identitas`, `jk`, `tmp_lahir`, `tgl_lahir`, `masuk_kerja`, `status`, `agama`, `departement`, `pekerjaan`, `alamat`, `kota`, `notelp`, `tgl_daftar`, `jabatan_id`, `jenis_anggota`, `aktif`, `pass_word`, `file_pic`) VALUES
(1, '0', 'Yatti  Surtiyati Arief', 'A-001', 'P', 'BANDUNG', '1970-02-13', '2016-03-14', 'Menikah', 'Islam', 'Purchasing', 'Pedagang', '-', 'Bekasi', '-', '2015-02-01', 2, 'Biasa', 'Y', 'c915d22bdd8fb8efe65269537d27e77b7df1b407', 'ba714-rachaeltay_800x600.jpg'),
(2, '0', 'Wiwik Indriani ', 'A-002', 'P', 'Surabaya', '1974-06-26', '2013-02-28', 'Menikah', 'Islam', 'Purchasing', 'Pedagang', '-', 'Bekasi', '-', '2015-02-02', 2, 'Biasa', 'Y', '1e157dd5081c6699192c94068932336f5c00ebf5', 'e81dd-44591811912_ecaef7458e_b.jpg'),
(5, '123456789', 'Jenderal Dekok', 'A123', 'L', 'Yogyakarta', '1981-03-02', '2020-01-01', 'Menikah', '', '', '', 'Jl Gawang Selatan', '', '085777788889', '2021-05-01', 0, 'Biasa', 'Y', '1e157dd5081c6699192c94068932336f5c00ebf5', '251a0-pengertian-koperasi-dan-tujuannya.png'),
(7, '1234567890', 'Damar Satria', '1234567890', 'L', 'Jakarta', '1982-06-17', '2011-06-15', 'Menikah', '', 'Engineering', '', 'Jakarta', '', '123456789', '2011-06-08', 0, 'Biasa', 'Y', '', ''),
(8, '111', 'dhika setya ulfa', '304111111111111111', 'P', 'jakarta', '2021-06-01', '2021-06-01', 'Menikah', '', 'Engineering', '', 'dusun jakarta', '', '081333333333', '2021-06-01', 0, 'Biasa', 'Y', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_apheader`
--

CREATE TABLE `tbl_apheader` (
  `IDHeaderAP` int(11) NOT NULL,
  `vcApHeaderCode` varchar(15) NOT NULL,
  `dtApDate` datetime NOT NULL,
  `vcCurrCode` varchar(3) NOT NULL,
  `cuAPRateValue` double NOT NULL,
  `vcApHeaderDesc` varchar(30) NOT NULL,
  `vcCOACode` varchar(12) NOT NULL,
  `cuCOAValue` double NOT NULL,
  `cuItemApTotal` double NOT NULL,
  `itStatusApHeader` enum('0','1') NOT NULL DEFAULT '0',
  `itPostApHeader` enum('0','1') NOT NULL DEFAULT '0',
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_apheader`
--

INSERT INTO `tbl_apheader` (`IDHeaderAP`, `vcApHeaderCode`, `dtApDate`, `vcCurrCode`, `cuAPRateValue`, `vcApHeaderDesc`, `vcCOACode`, `cuCOAValue`, `cuItemApTotal`, `itStatusApHeader`, `itPostApHeader`, `vcUserID`) VALUES
(7, 'AP-2019-05-1', '2019-05-01 15:09:58', 'IDR', 1, 'Biaya', '00.10.10.100', 0, 100000, '0', '1', 'admin'),
(8, 'AP-2019-05-2', '2019-05-15 15:10:55', 'IDR', 1, 'biaya', '00.10.10.100', 0, 350000, '0', '1', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_apitem`
--

CREATE TABLE `tbl_apitem` (
  `IDItemAP` int(11) NOT NULL,
  `vcApHeaderCode` varchar(15) NOT NULL,
  `vcCOAApItemCode` varchar(12) NOT NULL,
  `cuApItemValue` double NOT NULL,
  `itStatusApItem` enum('0','1') NOT NULL DEFAULT '0',
  `itPostApItem` enum('0','1') NOT NULL DEFAULT '0',
  `vcApItemDesc` varchar(35) NOT NULL,
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_apitem`
--

INSERT INTO `tbl_apitem` (`IDItemAP`, `vcApHeaderCode`, `vcCOAApItemCode`, `cuApItemValue`, `itStatusApItem`, `itPostApItem`, `vcApItemDesc`, `vcUserID`) VALUES
(9, 'AP-2019-05-1', '44.10.00.001', 100000, '0', '0', 'beli makan untuk tamu', 'admin'),
(10, 'AP-2019-05-2', '44.10.00.001', 350000, '0', '0', 'biaya perjalanan dinas', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_arheader`
--

CREATE TABLE `tbl_arheader` (
  `IDHeader` int(11) NOT NULL,
  `vcARHeaderCode` varchar(15) NOT NULL,
  `dtARDate` datetime NOT NULL,
  `vcCurrCode` varchar(3) NOT NULL,
  `cuARRateValue` double NOT NULL,
  `vcARHeaderDesc` varchar(30) NOT NULL,
  `vcCOACode` varchar(12) NOT NULL,
  `cuCOAValue` double NOT NULL,
  `cuItemARTotal` double NOT NULL,
  `itStatusARHeader` enum('0','1') NOT NULL DEFAULT '0',
  `itPostARHeader` enum('0','1') NOT NULL DEFAULT '0',
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_arheader`
--

INSERT INTO `tbl_arheader` (`IDHeader`, `vcARHeaderCode`, `dtARDate`, `vcCurrCode`, `cuARRateValue`, `vcARHeaderDesc`, `vcCOACode`, `cuCOAValue`, `cuItemARTotal`, `itStatusARHeader`, `itPostARHeader`, `vcUserID`) VALUES
(1, 'AR-2019-06-1', '2019-06-01 10:03:03', 'USD', 0, '-', '00.10.10.110', 0, 900000, '0', '0', 'admin'),
(2, 'AR-2021-06-1', '2021-06-08 11:33:46', 'IDR', 0, 'Simpanan Tunai', '00.10.10.100', 0, 100000, '0', '0', 'admin'),
(3, 'AR-2021-07-2', '2021-07-01 05:46:41', 'IDR', 0, 'test', '00.10.10.100', 0, 120000, '0', '1', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_aritem`
--

CREATE TABLE `tbl_aritem` (
  `IDItem` int(11) NOT NULL,
  `vcARHeaderCode` varchar(15) NOT NULL,
  `vcCOAARItemCode` varchar(12) NOT NULL,
  `cuARItemValue` double NOT NULL,
  `itStatusARItem` enum('0','1') NOT NULL DEFAULT '0',
  `itPostARItem` enum('0','1') NOT NULL DEFAULT '0',
  `vcARItemDesc` varchar(35) NOT NULL,
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_aritem`
--

INSERT INTO `tbl_aritem` (`IDItem`, `vcARHeaderCode`, `vcCOAARItemCode`, `cuARItemValue`, `itStatusARItem`, `itPostARItem`, `vcARItemDesc`, `vcUserID`) VALUES
(1, 'AR-2019-06-1', '00.10.10.120', 900000, '0', '0', '-', 'admin'),
(2, 'AR-2021-06-1', '00.10.10.110', 100000, '0', '0', 'Simpanan Wajib', 'admin'),
(3, 'AR-2021-07-2', '33.10.10.000', 120000, '0', '0', 'test', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id` bigint(20) NOT NULL,
  `nm_barang` varchar(255) NOT NULL,
  `kode` varchar(5) NOT NULL,
  `type` varchar(50) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `harga` double NOT NULL,
  `jml_brg` int(11) NOT NULL,
  `ket` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`id`, `nm_barang`, `kode`, `type`, `merk`, `harga`, `jml_brg`, `ket`, `created_at`) VALUES
(1, 'Konsinyasi', 'KYS', '-', '-', 0, 0, '', '2019-01-28 13:26:14'),
(2, 'Pinjaman Sembako', 'SBK', '-', '-', 0, 0, '', '2019-01-27 12:32:23'),
(3, 'Barang Sekunder ', 'BS', '-', '-', 0, 0, '', '2019-01-29 14:21:22'),
(4, 'USP', 'USP', '-', '-', 0, 0, '', '2019-01-29 13:35:31'),
(5, 'Cooppay', 'COOP', '-', '-', 0, 0, '', '2019-01-29 15:41:36'),
(6, 'Motor', 'SC001', ' Honda', ' Scoopy', 15000000, 1, 'Baru', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coa`
--

CREATE TABLE `tbl_coa` (
  `CoaId` bigint(20) NOT NULL,
  `vcCOACode` varchar(12) NOT NULL,
  `vcCOAName` varchar(50) NOT NULL,
  `vcGroupCode` varchar(2) NOT NULL,
  `itCOAType` enum('0','1') NOT NULL,
  `itCOALevel` enum('0','1','2','3','4','5') NOT NULL,
  `itCOACashBank` enum('0','1') NOT NULL,
  `itCOAFixedAsset` enum('0','1') NOT NULL,
  `vcCOABalanceType` enum('D','K') NOT NULL,
  `cuCOABalanceValue` double NOT NULL,
  `itCOAReportType` enum('0','1') NOT NULL,
  `vcCOADesc` varchar(200) NOT NULL,
  `itActive` enum('0','1') NOT NULL,
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_coa`
--

INSERT INTO `tbl_coa` (`CoaId`, `vcCOACode`, `vcCOAName`, `vcGroupCode`, `itCOAType`, `itCOALevel`, `itCOACashBank`, `itCOAFixedAsset`, `vcCOABalanceType`, `cuCOABalanceValue`, `itCOAReportType`, `vcCOADesc`, `itActive`, `vcUserID`) VALUES
(1, '00.00.00.000', 'Aktiva', '00', '0', '0', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(2, '00.10.00.000', 'Aktiva Lancar', '00', '0', '1', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(3, '00.10.10.000', 'Kas dan Bank', '00', '0', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(4, '00.10.10.100', 'Kas ', '00', '1', '3', '1', '0', 'D', 0, '0', '', '0', 'admin'),
(5, '00.10.10.110', 'Kas Kecil', '00', '1', '3', '1', '0', 'D', 0, '0', '', '0', 'admin'),
(6, '00.10.10.120', 'Bank Mandiri', '00', '1', '3', '1', '0', 'D', 0, '0', '', '0', 'admin'),
(7, '00.10.10.130', 'Bank Patriot', '00', '1', '3', '1', '0', 'D', 0, '0', '', '0', 'admin'),
(8, '00.10.20.000', 'Piutang ', '00', '0', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(9, '00.10.20.100', 'Piutang USP', '00', '1', '3', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(10, '00.10.20.110', 'Piutang USP (Barang Sekunder)', '00', '1', '3', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(11, '00.10.20.120', 'Piutang USP (Sembako)', '00', '1', '3', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(12, '00.10.30.000', 'Persediaan Barang', '00', '0', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(13, '00.10.30.100', 'Persediaan ATK', '00', '1', '3', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(14, '00.10.30.110', 'Persediaan Barang Dagangan', '00', '1', '3', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(15, '00.20.00.000', 'Investasi Jangka Panjang', '00', '0', '1', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(16, '00.20.10.100', 'Modal Puskowan Jabar', '00', '1', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(17, '00.20.10.110', 'Modal Puskowan DKI', '00', '1', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(18, '00.20.10.120', 'Modal Coopay', '00', '1', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(19, '00.20.10.130', 'Modal Beeholiday', '00', '1', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(20, '00.20.10.140', 'Modal Travel (Umroh)', '00', '1', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(21, '00.20.10.150', 'Modal KUHINDO', '00', '1', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(22, '00.20.10.160', 'Modal Konsinyasi dan YPKI', '00', '1', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(23, '00.30.00.000', 'Aktiva Tetap', '00', '0', '1', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(24, '00.30.10.000', 'Nilai Perolehan', '00', '0', '2', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(25, '00.30.10.100', 'NP. Tanah', '00', '1', '3', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(26, '00.30.10.110', 'NP. Bangunan', '00', '1', '3', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(27, '00.30.10.120', 'NP. Peralatan Kantor', '00', '1', '3', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(28, '00.30.10.130', 'NP. Instalasi Listrik', '00', '1', '3', '0', '0', 'D', 0, '0', '', '0', 'admin'),
(29, '00.30.20.000', 'Akumulasi Penyusutan', '00', '0', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(30, '00.30.20.100', 'AP. Tanah', '00', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(31, '00.30.20.110', 'AP. Bangunan', '00', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(32, '00.30.20.120', 'AP. Peralatan Kantor', '00', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(33, '00.30.20.130', 'AP. Instalasi Listrik', '00', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(34, '11.00.00.000', 'Passiva', '11', '0', '0', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(35, '11.10.00.000', 'Hutang Lancar', '11', '0', '1', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(36, '11.10.10.000', 'Simpanan', '11', '0', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(37, '11.10.10.100', 'Simpanan Sukarela', '11', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(38, '11.10.10.110', 'Simpanan Berjangka', '11', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(39, '11.10.10.120', 'Simpanan Lebaran', '11', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(40, '11.10.20.000', 'Tabungan', '11', '0', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(41, '11.10.20.100', 'Tabungan Ananda', '11', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(42, '11.10.20.110', 'Tabungan Umroh', '11', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(43, '11.10.20.120', 'Dana Bergulir Pemkot Bekasi', '11', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(44, '11.10.20.130', 'Cadangan Pajak & Tab. Ananda', '11', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(45, '11.10.30.000', 'Dana-Dana Koperasi', '11', '0', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(46, '11.10.30.100', 'Dana Pendidikan', '11', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(47, '11.10.30.110', 'Dana Sosial', '11', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(48, '11.10.30.120', 'Dana Lain-Lain', '11', '1', '3', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(49, '11.20.00.000', 'Hutang Jangka Panjang', '11', '0', '1', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(50, '11.20.10.000', 'Dana Bergulir Perkasa', '11', '1', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(51, '11.20.20.000', 'LPDB-KUKM', '11', '1', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(52, '22.00.00.000', 'MODAL SENDIRI', '22', '0', '0', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(53, '22.10.00.000', 'simpanan', '22', '0', '1', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(54, '22.10.10.000', 'simpanan Pokok/Khusus', '22', '1', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(55, '22.10.20.000', 'simpanan Wajib', '22', '1', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(56, '22.20.00.000', 'Dana-Dana', '22', '0', '1', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(57, '22.20.10.000', 'Dana Cadangan Resiko', '22', '1', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(58, '22.20.20.000', 'Dana Cadangan Koperasi', '22', '1', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(59, '22.20.30.000', 'Dana Hibah', '22', '1', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(60, '22.20.40.000', 'SHU Tahun Berjalan', '22', '1', '2', '0', '0', 'K', 0, '0', '', '0', 'admin'),
(61, '33.00.00.000', 'Pendapatan', '33', '0', '0', '0', '0', 'K', 0, '1', '-', '0', 'admin'),
(62, '33.10.00.000', 'Pendapatan Usaha', '33', '0', '1', '0', '0', 'K', 0, '1', '-', '0', 'admin'),
(63, '33.10.10.000', 'Pendapatan Jasa Pinjaman', '33', '1', '2', '0', '0', 'K', 0, '1', '-', '0', 'admin'),
(64, '33.10.11.000', 'Pendapatan Administrasi Pinjaman', '33', '1', '2', '0', '0', 'K', 0, '1', '-', '0', 'admin'),
(65, '33.20.00.000', 'Pendapatan Sumber Lain', '33', '0', '1', '0', '0', 'K', 0, '1', '-', '0', 'admin'),
(66, '44.00.00.000', 'Biaya', '44', '0', '0', '0', '0', 'D', 0, '1', '--', '0', 'admin'),
(67, '44.10.00.000', 'Biaya Operasional', '44', '0', '1', '0', '0', 'D', 0, '1', '-', '0', 'admin'),
(68, '44.10.00.001', 'Beban Biaya Usaha (Operasional)', '44', '1', '2', '0', '0', 'D', 0, '1', '-', '0', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currency`
--

CREATE TABLE `tbl_currency` (
  `itTransID` int(11) NOT NULL,
  `vcCurrCode` varchar(3) NOT NULL,
  `vcCurrName` varchar(25) NOT NULL,
  `cuRateValue` double NOT NULL,
  `itDefault` enum('1','0') DEFAULT '0',
  `itActive` enum('0','1') NOT NULL,
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_currency`
--

INSERT INTO `tbl_currency` (`itTransID`, `vcCurrCode`, `vcCurrName`, `cuRateValue`, `itDefault`, `itActive`, `vcUserID`) VALUES
(1, 'IDR', 'Rupiah Indonesia', 1, '1', '0', 'admin'),
(2, 'USD', 'Dollar USA', 14000, '0', '0', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faheader`
--

CREATE TABLE `tbl_faheader` (
  `itTransID` int(11) NOT NULL,
  `vcFaHeaderCode` varchar(15) NOT NULL,
  `vcCurrCode` varchar(3) NOT NULL,
  `vcFACOACode` varchar(12) NOT NULL,
  `dtFADate` datetime NOT NULL,
  `itDepreciation` int(11) NOT NULL,
  `cuFAHeaderValue` double NOT NULL,
  `vcFACOACodeDR` varchar(12) NOT NULL,
  `vcFACOACodeCR` varchar(12) NOT NULL,
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faitem`
--

CREATE TABLE `tbl_faitem` (
  `itTransID` int(11) NOT NULL,
  `vcFAHeaderCode` varchar(15) NOT NULL,
  `dtPeriodFA` datetime NOT NULL,
  `cuAccumulateFA` double NOT NULL,
  `cuFAItemValue` double NOT NULL,
  `itPercent` int(11) NOT NULL,
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_groupcoa`
--

CREATE TABLE `tbl_groupcoa` (
  `GroupId` int(11) NOT NULL,
  `vcGroupCode` varchar(2) NOT NULL,
  `vcGroupName` varchar(50) NOT NULL,
  `itStatus` enum('0','1') NOT NULL,
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_groupcoa`
--

INSERT INTO `tbl_groupcoa` (`GroupId`, `vcGroupCode`, `vcGroupName`, `itStatus`, `vcUserID`) VALUES
(3, '00', 'Aktiva', '0', 'admin'),
(4, '11', 'Passiva', '0', 'admin'),
(5, '22', 'Modal', '0', 'admin'),
(6, '33', 'Pendapatan', '0', 'admin'),
(7, '44', 'Biaya', '0', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_journal`
--

CREATE TABLE `tbl_journal` (
  `itTransID` int(11) NOT NULL,
  `vcIDJournal` varchar(15) NOT NULL,
  `dtJournal` datetime NOT NULL,
  `vcCOAJournal` varchar(12) NOT NULL,
  `cuJournalDebet` double NOT NULL,
  `cuJournalCredit` double NOT NULL,
  `vcJournalDesc` varchar(35) NOT NULL,
  `itPostJournal` enum('0','1') NOT NULL,
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_journal`
--

INSERT INTO `tbl_journal` (`itTransID`, `vcIDJournal`, `dtJournal`, `vcCOAJournal`, `cuJournalDebet`, `cuJournalCredit`, `vcJournalDesc`, `itPostJournal`, `vcUserID`) VALUES
(67, 'GL-2019-05-1', '2019-05-01 15:12:35', '00.10.20.100', 280000, 0, 'pinjaman', '1', 'admin'),
(68, 'GL-2019-05-1', '2019-05-01 15:12:35', '33.10.11.000', 0, 50000, 'biaya admin', '1', 'admin'),
(69, 'GL-2019-05-1', '2019-05-01 15:12:35', '33.10.10.000', 0, 230000, 'jasa pinjaman', '1', 'admin'),
(70, 'AP-2019-05-2', '2019-05-15 15:10:55', '00.10.10.100', 0, 350000, 'biaya', '1', 'admin'),
(71, 'AP-2019-05-2', '2019-05-15 15:10:55', '44.10.00.001', 350000, 0, 'biaya perjalanan dinas', '1', 'admin'),
(72, 'AP-2019-05-1', '2019-05-01 15:09:58', '00.10.10.100', 0, 100000, 'Biaya', '1', 'admin'),
(73, 'AP-2019-05-1', '2019-05-01 15:09:58', '44.10.00.001', 100000, 0, 'beli makan untuk tamu', '1', 'admin'),
(74, 'AR-2021-07-2', '2021-07-01 05:46:41', '00.10.10.100', 120000, 0, 'test', '1', 'admin'),
(75, 'AR-2021-07-2', '2021-07-01 05:46:41', '33.10.10.000', 0, 120000, 'test', '1', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_memoheader`
--

CREATE TABLE `tbl_memoheader` (
  `IDHeaderMemo` int(11) NOT NULL,
  `vcMemoHeaderCode` varchar(15) NOT NULL,
  `dtMemoDate` datetime NOT NULL,
  `vcCurrCode` varchar(3) NOT NULL,
  `cuMemoRateValue` double NOT NULL,
  `vcMemoHeaderDesc` varchar(35) NOT NULL,
  `cuMemoHeaderDebet` double NOT NULL,
  `cuMemoHeaderCredit` double NOT NULL,
  `itStatusMemoHeader` enum('0','1') NOT NULL DEFAULT '0',
  `itPostMemoHeader` enum('0','1') NOT NULL DEFAULT '0',
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_memoheader`
--

INSERT INTO `tbl_memoheader` (`IDHeaderMemo`, `vcMemoHeaderCode`, `dtMemoDate`, `vcCurrCode`, `cuMemoRateValue`, `vcMemoHeaderDesc`, `cuMemoHeaderDebet`, `cuMemoHeaderCredit`, `itStatusMemoHeader`, `itPostMemoHeader`, `vcUserID`) VALUES
(9, 'GL-2019-05-1', '2019-05-01 15:12:35', 'IDR', 1, 'Pinjaman Anggota', 280000, 280000, '0', '1', 'admin'),
(10, 'GL-2021-06-1', '2021-06-08 11:35:09', 'IDR', 1, 'test', 120000, 0, '0', '0', 'admin'),
(11, 'GL-2021-06-2', '2021-06-19 18:41:56', 'IDR', 1, 'td', 0, 0, '0', '0', 'admin'),
(12, 'GL-2021-07-3', '2021-07-01 15:20:40', 'IDR', 1, 'test', 0, 0, '0', '0', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_memoitem`
--

CREATE TABLE `tbl_memoitem` (
  `IDItemMemo` int(11) NOT NULL,
  `vcMemoHeaderCode` varchar(15) NOT NULL,
  `vcCOAMemoItemCode` varchar(12) NOT NULL,
  `debet_or_kredit` enum('D','K') DEFAULT NULL,
  `cuMemoItemValue` double NOT NULL,
  `itStatusMemoItem` enum('0','1') NOT NULL DEFAULT '0',
  `itPostMemoItem` enum('0','1') NOT NULL DEFAULT '0',
  `vcMemoItemDesc` varchar(35) NOT NULL,
  `vcUserID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_memoitem`
--

INSERT INTO `tbl_memoitem` (`IDItemMemo`, `vcMemoHeaderCode`, `vcCOAMemoItemCode`, `debet_or_kredit`, `cuMemoItemValue`, `itStatusMemoItem`, `itPostMemoItem`, `vcMemoItemDesc`, `vcUserID`) VALUES
(17, 'GL-2019-05-1', '33.10.10.000', 'K', 230000, '0', '0', 'jasa pinjaman', 'admin'),
(18, 'GL-2019-05-1', '33.10.11.000', 'K', 50000, '0', '0', 'biaya admin', 'admin'),
(19, 'GL-2019-05-1', '00.10.20.100', 'D', 280000, '0', '0', 'pinjaman', 'admin'),
(20, 'GL-2021-06-1', '00.10.10.110', 'D', 120000, '0', '0', 'SImpanan Wajib', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengajuan`
--

CREATE TABLE `tbl_pengajuan` (
  `id` bigint(20) NOT NULL,
  `no_ajuan` int(11) NOT NULL,
  `ajuan_id` varchar(255) NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `lama_ags` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `tgl_cair` date NOT NULL,
  `tgl_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pengajuan`
--

INSERT INTO `tbl_pengajuan` (`id`, `no_ajuan`, `ajuan_id`, `anggota_id`, `tgl_input`, `jenis`, `nominal`, `lama_ags`, `keterangan`, `status`, `alasan`, `tgl_cair`, `tgl_update`) VALUES
(3, 1, 'B.21.06.001', 5, '2021-05-30 09:11:10', 'Biasa', 1000000, 1, 'Mendesak', 3, 'masih cukup gajinya', '2021-05-29', '2021-05-30 09:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pinjaman_d`
--

CREATE TABLE `tbl_pinjaman_d` (
  `id` bigint(20) NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `pinjam_id` bigint(20) NOT NULL,
  `angsuran_ke` bigint(20) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `bayar_jasa_pinjaman` int(11) NOT NULL,
  `denda_rp` int(11) NOT NULL,
  `terlambat` int(11) NOT NULL,
  `ket_bayar` enum('Angsuran','Pelunasan','Bayar Denda') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `jns_trans` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pinjaman_d`
--

INSERT INTO `tbl_pinjaman_d` (`id`, `tgl_bayar`, `pinjam_id`, `angsuran_ke`, `jumlah_bayar`, `bayar_jasa_pinjaman`, `denda_rp`, `terlambat`, `ket_bayar`, `dk`, `kas_id`, `jns_trans`, `update_data`, `user_name`, `keterangan`) VALUES
(1, '2021-05-30 06:42:00', 1, 1, 285000, 60000, 31350, 0, 'Angsuran', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', ''),
(2, '2021-06-01 21:08:00', 1, 2, 285000, 60000, 28500, 0, 'Angsuran', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', ''),
(3, '2021-06-01 21:09:00', 1, 3, 2909850, 0, 0, 0, 'Pelunasan', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', ''),
(4, '2021-06-01 21:23:00', 3, 1, 1030000, 0, 0, 0, 'Pelunasan', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', ''),
(5, '2021-06-01 21:25:00', 2, 1, 2010200, 0, 0, 0, 'Pelunasan', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', ''),
(6, '2021-06-22 23:57:00', 7, 1, 1700000, 300000, 0, 0, 'Angsuran', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', ''),
(7, '2021-06-23 00:06:00', 9, 1, 15900000, 0, 0, 0, 'Pelunasan', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', ''),
(8, '2021-07-17 16:26:00', 8, 1, 868800, 450000, 199824, 0, 'Angsuran', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pinjaman_h`
--

CREATE TABLE `tbl_pinjaman_h` (
  `id` bigint(20) NOT NULL,
  `jns_pinjam` int(5) NOT NULL,
  `no_pinjaman` varchar(16) NOT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `barang_id` bigint(20) NOT NULL,
  `lama_angsuran` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `bunga` float(10,2) NOT NULL,
  `biaya_adm` int(11) NOT NULL,
  `lunas` enum('Belum','Lunas') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `jns_trans` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `contoh` int(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pinjaman_h`
--

INSERT INTO `tbl_pinjaman_h` (`id`, `jns_pinjam`, `no_pinjaman`, `tgl_pinjam`, `anggota_id`, `barang_id`, `lama_angsuran`, `jumlah`, `bunga`, `biaya_adm`, `lunas`, `dk`, `kas_id`, `jns_trans`, `update_data`, `user_name`, `keterangan`, `contoh`) VALUES
(1, 3, 'USP-2019-05-1', '2019-05-09 11:37:00', 1, 4, 12, 3000000, 2.00, 30000, 'Lunas', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', 'tesss', 0),
(2, 4, 'RTL-2021-05-1', '2021-05-30 06:40:00', 1, 3, 2, 10000, 2.00, 1000000, 'Lunas', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', '', 0),
(3, 3, 'USP-2021-05-2', '2021-05-30 09:19:00', 5, 5, 1, 1000000, 2.00, 10000, 'Lunas', 'K', 1, 7, '0000-00-00 00:00:00', 'operator', '', 0),
(4, 4, 'RTL-2021-05-3', '2021-05-30 12:25:00', 5, 1, 0, 1000000, 2.00, 100000000, 'Belum', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', '', 0),
(5, 4, 'RTL-2021-06-4', '2021-06-01 21:53:00', 2, 2, 9, 7000000, 2.00, 700000000, 'Belum', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', '5645', 0),
(6, 4, 'RTL-2021-06-5', '2021-06-08 11:30:00', 7, 6, 24, 15000000, 2.00, 0, 'Belum', 'K', 1, 7, '0000-00-00 00:00:00', 'operator', 'Ok', 0),
(7, 4, 'RTL-2021-06-6', '2021-06-10 18:43:00', 1, 6, 9, 15000000, 2.00, 0, 'Belum', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', '', 0),
(8, 3, 'USP-2021-06-7', '2021-06-23 00:01:00', 1, 6, 24, 15000000, 3.00, 225000, 'Belum', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', 'Pinjaman motor', 0),
(9, 3, 'USP-2021-06-8', '2021-06-23 00:04:00', 8, 6, 1, 15000000, 3.00, 450000, 'Lunas', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id` bigint(20) NOT NULL,
  `opsi_key` varchar(255) NOT NULL,
  `opsi_val` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `opsi_key`, `opsi_val`) VALUES
(1, 'nama_lembaga', 'KOPERASI KARYAWAN'),
(2, 'nama_ketua', '-'),
(3, 'hp_ketua', '087123235468'),
(4, 'alamat', '-'),
(5, 'telepon', '-'),
(6, 'kota', 'Jakarta '),
(7, 'email', 'kopkar@gmail.com'),
(8, 'web', 'www.kopkar.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trans_kas`
--

CREATE TABLE `tbl_trans_kas` (
  `id` bigint(20) NOT NULL,
  `tgl_catat` datetime NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `akun` enum('Pemasukan','Pengeluaran','Transfer') NOT NULL,
  `dari_kas_id` bigint(20) DEFAULT NULL,
  `untuk_kas_id` bigint(20) DEFAULT NULL,
  `jns_trans` bigint(20) DEFAULT NULL,
  `dk` enum('D','K') DEFAULT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trans_sp`
--

CREATE TABLE `tbl_trans_sp` (
  `id` bigint(20) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `jenis_id` int(5) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `akun` enum('Setoran','Penarikan') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `nama_penyetor` varchar(255) NOT NULL,
  `no_identitas` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_trans_sp`
--

INSERT INTO `tbl_trans_sp` (`id`, `tgl_transaksi`, `anggota_id`, `jenis_id`, `jumlah`, `keterangan`, `akun`, `dk`, `kas_id`, `update_data`, `user_name`, `nama_penyetor`, `no_identitas`, `alamat`) VALUES
(1, '2019-05-16 13:32:00', 1, 2, 100000, '-', 'Setoran', 'D', 1, '0000-00-00 00:00:00', 'admin', '0', '0', '0'),
(2, '2019-05-16 13:32:00', 1, 43, 50000, '-', 'Setoran', 'D', 1, '0000-00-00 00:00:00', 'admin', '0', '0', '0'),
(3, '2019-05-16 13:32:00', 1, 1, 10000000, '-', 'Setoran', 'D', 1, '0000-00-00 00:00:00', 'admin', '0', '0', '0'),
(4, '2021-05-24 08:55:00', 5, 2, 100000, '', 'Setoran', 'D', 1, '0000-00-00 00:00:00', 'admin', '0', '0', '0'),
(5, '2021-05-30 09:00:00', 5, 43, 50000, 'Bulan Mei', 'Setoran', 'D', 1, '0000-00-00 00:00:00', 'admin', '0', '0', '0'),
(6, '2021-06-04 16:51:00', 1, 2, 100000, '', 'Setoran', 'D', 1, '0000-00-00 00:00:00', 'admin', '0', '0', '0'),
(7, '2021-06-15 06:44:00', 1, 2, 10000, 'J', 'Setoran', 'D', 1, '0000-00-00 00:00:00', 'admin', '0', '0', '0'),
(8, '2021-07-09 05:44:00', 7, 44, 200000, 'test', 'Setoran', 'D', 1, '0000-00-00 00:00:00', 'admin', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` bigint(20) NOT NULL,
  `u_name` varchar(30) NOT NULL,
  `pass_word` varchar(255) NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `level` enum('admin','operator','pinjaman') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `u_name`, `pass_word`, `aktif`, `level`) VALUES
(1, 'admin', '224bec3dd08832bc6a69873f15a50df406045f40', 'Y', 'admin'),
(4, 'operator', 'ff546a1143afce9c58af2a5bf001811fe3b7699a', 'Y', 'operator'),
(5, 'pinjaman', 'efd2770f6782f7218be595baf2fc16bc7cf45143', 'Y', 'pinjaman');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `jns_akun`
--
ALTER TABLE `jns_akun`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kd_aktiva` (`kd_aktiva`);

--
-- Indexes for table `jns_angsuran`
--
ALTER TABLE `jns_angsuran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jns_pinjam`
--
ALTER TABLE `jns_pinjam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vcCOACode` (`vcCOACode`);

--
-- Indexes for table `jns_simpan`
--
ALTER TABLE `jns_simpan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vcCOACode` (`vcCOACode`);

--
-- Indexes for table `nama_kas_tbl`
--
ALTER TABLE `nama_kas_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vcCOACode` (`vcCOACode`);

--
-- Indexes for table `suku_bunga`
--
ALTER TABLE `suku_bunga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identitas` (`identitas`);

--
-- Indexes for table `tbl_apheader`
--
ALTER TABLE `tbl_apheader`
  ADD PRIMARY KEY (`IDHeaderAP`),
  ADD UNIQUE KEY `vcApHeaderCode` (`vcApHeaderCode`),
  ADD KEY `vcCurrCode` (`vcCurrCode`),
  ADD KEY `vcCOACode` (`vcCOACode`),
  ADD KEY `vcUserID` (`vcUserID`);

--
-- Indexes for table `tbl_apitem`
--
ALTER TABLE `tbl_apitem`
  ADD PRIMARY KEY (`IDItemAP`),
  ADD KEY `vcApHeaderCode` (`vcApHeaderCode`),
  ADD KEY `vcUserID` (`vcUserID`),
  ADD KEY `vcCOAApItemCode` (`vcCOAApItemCode`);

--
-- Indexes for table `tbl_arheader`
--
ALTER TABLE `tbl_arheader`
  ADD PRIMARY KEY (`IDHeader`),
  ADD KEY `vcARHeaderCode` (`vcARHeaderCode`),
  ADD KEY `vcCurrCode` (`vcCurrCode`),
  ADD KEY `vcCOACode` (`vcCOACode`),
  ADD KEY `vcUserID` (`vcUserID`);

--
-- Indexes for table `tbl_aritem`
--
ALTER TABLE `tbl_aritem`
  ADD PRIMARY KEY (`IDItem`),
  ADD KEY `vcARHeaderCode` (`vcARHeaderCode`),
  ADD KEY `vcCOAARItemCode` (`vcCOAARItemCode`),
  ADD KEY `vcUserID` (`vcUserID`);

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coa`
--
ALTER TABLE `tbl_coa`
  ADD PRIMARY KEY (`CoaId`),
  ADD UNIQUE KEY `vcCOACode` (`vcCOACode`),
  ADD KEY `vcUserID` (`vcUserID`),
  ADD KEY `vcGroupCode` (`vcGroupCode`);

--
-- Indexes for table `tbl_currency`
--
ALTER TABLE `tbl_currency`
  ADD PRIMARY KEY (`itTransID`),
  ADD KEY `vcCurrCode` (`vcCurrCode`),
  ADD KEY `vcUserID` (`vcUserID`);

--
-- Indexes for table `tbl_faheader`
--
ALTER TABLE `tbl_faheader`
  ADD PRIMARY KEY (`itTransID`),
  ADD UNIQUE KEY `vcFaHeaderCode` (`vcFaHeaderCode`),
  ADD KEY `vcCurrCode` (`vcCurrCode`),
  ADD KEY `vcFACOACode` (`vcFACOACode`),
  ADD KEY `vcUserID` (`vcUserID`),
  ADD KEY `vcFACOACodeDR` (`vcFACOACodeDR`),
  ADD KEY `vcFACOACodeCR` (`vcFACOACodeCR`);

--
-- Indexes for table `tbl_faitem`
--
ALTER TABLE `tbl_faitem`
  ADD PRIMARY KEY (`itTransID`),
  ADD KEY `vcUserID` (`vcUserID`),
  ADD KEY `vcFAHeaderCode` (`vcFAHeaderCode`);

--
-- Indexes for table `tbl_groupcoa`
--
ALTER TABLE `tbl_groupcoa`
  ADD PRIMARY KEY (`GroupId`),
  ADD UNIQUE KEY `vcGroupCode` (`vcGroupCode`),
  ADD KEY `vcUserID` (`vcUserID`);

--
-- Indexes for table `tbl_journal`
--
ALTER TABLE `tbl_journal`
  ADD PRIMARY KEY (`itTransID`);

--
-- Indexes for table `tbl_memoheader`
--
ALTER TABLE `tbl_memoheader`
  ADD PRIMARY KEY (`IDHeaderMemo`),
  ADD UNIQUE KEY `vcMemoHeaderCode` (`vcMemoHeaderCode`),
  ADD KEY `vcUserID` (`vcUserID`);

--
-- Indexes for table `tbl_memoitem`
--
ALTER TABLE `tbl_memoitem`
  ADD PRIMARY KEY (`IDItemMemo`),
  ADD KEY `vcMemoHeaderCode` (`vcMemoHeaderCode`),
  ADD KEY `vcCOAMemoItemCode` (`vcCOAMemoItemCode`),
  ADD KEY `vcUserID` (`vcUserID`);

--
-- Indexes for table `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`anggota_id`);

--
-- Indexes for table `tbl_pinjaman_d`
--
ALTER TABLE `tbl_pinjaman_d`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kas_id` (`kas_id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `pinjam_id` (`pinjam_id`),
  ADD KEY `jns_trans` (`jns_trans`);

--
-- Indexes for table `tbl_pinjaman_h`
--
ALTER TABLE `tbl_pinjaman_h`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_id` (`anggota_id`),
  ADD KEY `kas_id` (`kas_id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `jns_trans` (`jns_trans`),
  ADD KEY `barang_id` (`barang_id`),
  ADD KEY `jns_pinjam` (`jns_pinjam`);

--
-- Indexes for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_trans_kas`
--
ALTER TABLE `tbl_trans_kas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `dari_kas_id` (`dari_kas_id`,`untuk_kas_id`),
  ADD KEY `untuk_kas_id` (`untuk_kas_id`),
  ADD KEY `jns_trans` (`jns_trans`);

--
-- Indexes for table `tbl_trans_sp`
--
ALTER TABLE `tbl_trans_sp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_id` (`anggota_id`),
  ADD KEY `jenis_id` (`jenis_id`),
  ADD KEY `kas_id` (`kas_id`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_name` (`u_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jns_akun`
--
ALTER TABLE `jns_akun`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `jns_angsuran`
--
ALTER TABLE `jns_angsuran`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jns_pinjam`
--
ALTER TABLE `jns_pinjam`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jns_simpan`
--
ALTER TABLE `jns_simpan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `nama_kas_tbl`
--
ALTER TABLE `nama_kas_tbl`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suku_bunga`
--
ALTER TABLE `suku_bunga`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_apheader`
--
ALTER TABLE `tbl_apheader`
  MODIFY `IDHeaderAP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_apitem`
--
ALTER TABLE `tbl_apitem`
  MODIFY `IDItemAP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_arheader`
--
ALTER TABLE `tbl_arheader`
  MODIFY `IDHeader` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_aritem`
--
ALTER TABLE `tbl_aritem`
  MODIFY `IDItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_coa`
--
ALTER TABLE `tbl_coa`
  MODIFY `CoaId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tbl_currency`
--
ALTER TABLE `tbl_currency`
  MODIFY `itTransID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_faheader`
--
ALTER TABLE `tbl_faheader`
  MODIFY `itTransID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_faitem`
--
ALTER TABLE `tbl_faitem`
  MODIFY `itTransID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_groupcoa`
--
ALTER TABLE `tbl_groupcoa`
  MODIFY `GroupId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_journal`
--
ALTER TABLE `tbl_journal`
  MODIFY `itTransID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbl_memoheader`
--
ALTER TABLE `tbl_memoheader`
  MODIFY `IDHeaderMemo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_memoitem`
--
ALTER TABLE `tbl_memoitem`
  MODIFY `IDItemMemo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_pinjaman_d`
--
ALTER TABLE `tbl_pinjaman_d`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_pinjaman_h`
--
ALTER TABLE `tbl_pinjaman_h`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_trans_kas`
--
ALTER TABLE `tbl_trans_kas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_trans_sp`
--
ALTER TABLE `tbl_trans_sp`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jns_pinjam`
--
ALTER TABLE `jns_pinjam`
  ADD CONSTRAINT `jns_pinjam_ibfk_1` FOREIGN KEY (`vcCOACode`) REFERENCES `tbl_coa` (`vcCOACode`);

--
-- Constraints for table `jns_simpan`
--
ALTER TABLE `jns_simpan`
  ADD CONSTRAINT `jns_simpan_ibfk_1` FOREIGN KEY (`vcCOACode`) REFERENCES `tbl_coa` (`vcCOACode`);

--
-- Constraints for table `tbl_apheader`
--
ALTER TABLE `tbl_apheader`
  ADD CONSTRAINT `tbl_apheader_ibfk_1` FOREIGN KEY (`vcCOACode`) REFERENCES `tbl_coa` (`vcCOACode`),
  ADD CONSTRAINT `tbl_apheader_ibfk_2` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`),
  ADD CONSTRAINT `tbl_apheader_ibfk_3` FOREIGN KEY (`vcCurrCode`) REFERENCES `tbl_currency` (`vcCurrCode`);

--
-- Constraints for table `tbl_apitem`
--
ALTER TABLE `tbl_apitem`
  ADD CONSTRAINT `tbl_apitem_ibfk_1` FOREIGN KEY (`vcApHeaderCode`) REFERENCES `tbl_apheader` (`vcApHeaderCode`),
  ADD CONSTRAINT `tbl_apitem_ibfk_2` FOREIGN KEY (`vcCOAApItemCode`) REFERENCES `tbl_coa` (`vcCOACode`),
  ADD CONSTRAINT `tbl_apitem_ibfk_3` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`);

--
-- Constraints for table `tbl_arheader`
--
ALTER TABLE `tbl_arheader`
  ADD CONSTRAINT `tbl_arheader_ibfk_1` FOREIGN KEY (`vcCurrCode`) REFERENCES `tbl_currency` (`vcCurrCode`),
  ADD CONSTRAINT `tbl_arheader_ibfk_2` FOREIGN KEY (`vcCOACode`) REFERENCES `tbl_coa` (`vcCOACode`),
  ADD CONSTRAINT `tbl_arheader_ibfk_3` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`);

--
-- Constraints for table `tbl_aritem`
--
ALTER TABLE `tbl_aritem`
  ADD CONSTRAINT `tbl_aritem_ibfk_1` FOREIGN KEY (`vcARHeaderCode`) REFERENCES `tbl_arheader` (`vcARHeaderCode`),
  ADD CONSTRAINT `tbl_aritem_ibfk_2` FOREIGN KEY (`vcCOAARItemCode`) REFERENCES `tbl_coa` (`vcCOACode`),
  ADD CONSTRAINT `tbl_aritem_ibfk_3` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`);

--
-- Constraints for table `tbl_coa`
--
ALTER TABLE `tbl_coa`
  ADD CONSTRAINT `tbl_coa_ibfk_1` FOREIGN KEY (`vcGroupCode`) REFERENCES `tbl_groupcoa` (`vcGroupCode`),
  ADD CONSTRAINT `tbl_coa_ibfk_2` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`);

--
-- Constraints for table `tbl_currency`
--
ALTER TABLE `tbl_currency`
  ADD CONSTRAINT `tbl_currency_ibfk_1` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`);

--
-- Constraints for table `tbl_faheader`
--
ALTER TABLE `tbl_faheader`
  ADD CONSTRAINT `tbl_faheader_ibfk_1` FOREIGN KEY (`vcCurrCode`) REFERENCES `tbl_currency` (`vcCurrCode`),
  ADD CONSTRAINT `tbl_faheader_ibfk_2` FOREIGN KEY (`vcFACOACode`) REFERENCES `tbl_coa` (`vcCOACode`),
  ADD CONSTRAINT `tbl_faheader_ibfk_3` FOREIGN KEY (`vcFACOACodeDR`) REFERENCES `tbl_coa` (`vcCOACode`),
  ADD CONSTRAINT `tbl_faheader_ibfk_4` FOREIGN KEY (`vcFACOACodeCR`) REFERENCES `tbl_coa` (`vcCOACode`),
  ADD CONSTRAINT `tbl_faheader_ibfk_5` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`);

--
-- Constraints for table `tbl_faitem`
--
ALTER TABLE `tbl_faitem`
  ADD CONSTRAINT `tbl_faitem_ibfk_1` FOREIGN KEY (`vcFAHeaderCode`) REFERENCES `tbl_faheader` (`vcFaHeaderCode`),
  ADD CONSTRAINT `tbl_faitem_ibfk_2` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`);

--
-- Constraints for table `tbl_groupcoa`
--
ALTER TABLE `tbl_groupcoa`
  ADD CONSTRAINT `tbl_groupcoa_ibfk_1` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`);

--
-- Constraints for table `tbl_memoheader`
--
ALTER TABLE `tbl_memoheader`
  ADD CONSTRAINT `tbl_memoheader_ibfk_1` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`);

--
-- Constraints for table `tbl_memoitem`
--
ALTER TABLE `tbl_memoitem`
  ADD CONSTRAINT `tbl_memoitem_ibfk_1` FOREIGN KEY (`vcMemoHeaderCode`) REFERENCES `tbl_memoheader` (`vcMemoHeaderCode`),
  ADD CONSTRAINT `tbl_memoitem_ibfk_2` FOREIGN KEY (`vcCOAMemoItemCode`) REFERENCES `tbl_coa` (`vcCOACode`),
  ADD CONSTRAINT `tbl_memoitem_ibfk_3` FOREIGN KEY (`vcUserID`) REFERENCES `tbl_user` (`u_name`);

--
-- Constraints for table `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  ADD CONSTRAINT `tbl_pengajuan_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `tbl_anggota` (`id`);

--
-- Constraints for table `tbl_pinjaman_d`
--
ALTER TABLE `tbl_pinjaman_d`
  ADD CONSTRAINT `tbl_pinjaman_d_ibfk_1` FOREIGN KEY (`pinjam_id`) REFERENCES `tbl_pinjaman_h` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_d_ibfk_2` FOREIGN KEY (`kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_d_ibfk_3` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`),
  ADD CONSTRAINT `tbl_pinjaman_d_ibfk_4` FOREIGN KEY (`jns_trans`) REFERENCES `jns_akun` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pinjaman_h`
--
ALTER TABLE `tbl_pinjaman_h`
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `tbl_anggota` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_2` FOREIGN KEY (`kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_3` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`),
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_4` FOREIGN KEY (`jns_trans`) REFERENCES `jns_akun` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_5` FOREIGN KEY (`barang_id`) REFERENCES `tbl_barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_6` FOREIGN KEY (`jns_pinjam`) REFERENCES `jns_pinjam` (`id`);

--
-- Constraints for table `tbl_trans_kas`
--
ALTER TABLE `tbl_trans_kas`
  ADD CONSTRAINT `tbl_trans_kas_ibfk_2` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`),
  ADD CONSTRAINT `tbl_trans_kas_ibfk_3` FOREIGN KEY (`dari_kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_trans_kas_ibfk_4` FOREIGN KEY (`untuk_kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_trans_kas_ibfk_5` FOREIGN KEY (`jns_trans`) REFERENCES `jns_akun` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_trans_sp`
--
ALTER TABLE `tbl_trans_sp`
  ADD CONSTRAINT `tbl_trans_sp_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `tbl_anggota` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_trans_sp_ibfk_2` FOREIGN KEY (`kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_trans_sp_ibfk_3` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`),
  ADD CONSTRAINT `tbl_trans_sp_ibfk_4` FOREIGN KEY (`jenis_id`) REFERENCES `jns_simpan` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
