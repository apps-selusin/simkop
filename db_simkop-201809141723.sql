-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 14, 2018 at 12:22 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simkop`
--

-- --------------------------------------------------------

--
-- Table structure for table `t01_nasabah`
--

CREATE TABLE `t01_nasabah` (
  `id` int(11) NOT NULL,
  `Customer` varchar(25) NOT NULL,
  `Pekerjaan` varchar(25) DEFAULT NULL,
  `Alamat` text,
  `NoTelpHp` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t01_nasabah`
--

INSERT INTO `t01_nasabah` (`id`, `Customer`, `Pekerjaan`, `Alamat`, `NoTelpHp`) VALUES
(1, 'Andoko', NULL, NULL, NULL),
(2, 'Dodo', NULL, NULL, NULL),
(3, 'Hendra', NULL, NULL, NULL),
(4, 'Vico', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t02_jaminan`
--

CREATE TABLE `t02_jaminan` (
  `id` int(11) NOT NULL,
  `nasabah_id` int(11) NOT NULL,
  `MerkType` varchar(25) NOT NULL,
  `NoRangka` varchar(50) DEFAULT NULL,
  `NoMesin` varchar(50) DEFAULT NULL,
  `Warna` varchar(15) DEFAULT NULL,
  `NoPol` varchar(15) DEFAULT NULL,
  `Keterangan` text,
  `AtasNama` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t02_jaminan`
--

INSERT INTO `t02_jaminan` (`id`, `nasabah_id`, `MerkType`, `NoRangka`, `NoMesin`, `Warna`, `NoPol`, `Keterangan`, `AtasNama`) VALUES
(1, 1, 'ATM', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'BPKB', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 'Sertifikat', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 2, 'BPKB', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, 'Surat Nikah', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2, 'Ijasah', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 4, 'Sertifikat', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 3, 'Sertifikat', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t03_pinjaman`
--

CREATE TABLE `t03_pinjaman` (
  `id` int(11) NOT NULL,
  `NoKontrak` varchar(25) NOT NULL,
  `TglKontrak` date NOT NULL,
  `nasabah_id` int(11) NOT NULL,
  `Pinjaman` float(14,2) NOT NULL,
  `LamaAngsuran` tinyint(4) NOT NULL,
  `Bunga` decimal(5,2) NOT NULL DEFAULT '2.25',
  `Denda` decimal(5,2) NOT NULL DEFAULT '0.40',
  `DispensasiDenda` tinyint(4) NOT NULL DEFAULT '3',
  `AngsuranPokok` float(14,2) NOT NULL,
  `AngsuranBunga` float(14,2) NOT NULL,
  `AngsuranTotal` float(14,2) NOT NULL,
  `NoKontrakRefTo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t04_angsuran`
--

CREATE TABLE `t04_angsuran` (
  `id` int(11) NOT NULL,
  `pinjaman_id` int(11) NOT NULL,
  `AngsuranKe` tinyint(4) NOT NULL,
  `AngsuranTanggal` date NOT NULL,
  `AngsuranPokok` float(14,2) NOT NULL,
  `AngsuranBunga` float(14,2) NOT NULL,
  `AngsuranTotal` float(14,2) NOT NULL,
  `SisaHutang` float(14,2) NOT NULL,
  `TanggalBayar` date DEFAULT NULL,
  `TotalDenda` float(14,2) DEFAULT NULL,
  `Terlambat` smallint(6) DEFAULT NULL,
  `Keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t05_pinjamanjaminan`
--

CREATE TABLE `t05_pinjamanjaminan` (
  `id` int(11) NOT NULL,
  `pinjaman_id` int(11) NOT NULL,
  `jaminan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t96_employees`
--

CREATE TABLE `t96_employees` (
  `EmployeeID` int(11) NOT NULL,
  `LastName` varchar(20) DEFAULT NULL,
  `FirstName` varchar(10) DEFAULT NULL,
  `Title` varchar(30) DEFAULT NULL,
  `TitleOfCourtesy` varchar(25) DEFAULT NULL,
  `BirthDate` datetime DEFAULT NULL,
  `HireDate` datetime DEFAULT NULL,
  `Address` varchar(60) DEFAULT NULL,
  `City` varchar(15) DEFAULT NULL,
  `Region` varchar(15) DEFAULT NULL,
  `PostalCode` varchar(10) DEFAULT NULL,
  `Country` varchar(15) DEFAULT NULL,
  `HomePhone` varchar(24) DEFAULT NULL,
  `Extension` varchar(4) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Notes` longtext,
  `ReportsTo` int(11) DEFAULT NULL,
  `Password` varchar(50) NOT NULL DEFAULT '',
  `UserLevel` int(11) DEFAULT NULL,
  `Username` varchar(20) NOT NULL DEFAULT '',
  `Activated` enum('Y','N') NOT NULL DEFAULT 'N',
  `Profile` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t96_employees`
--

INSERT INTO `t96_employees` (`EmployeeID`, `LastName`, `FirstName`, `Title`, `TitleOfCourtesy`, `BirthDate`, `HireDate`, `Address`, `City`, `Region`, `PostalCode`, `Country`, `HomePhone`, `Extension`, `Email`, `Photo`, `Notes`, `ReportsTo`, `Password`, `UserLevel`, `Username`, `Activated`, `Profile`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', -1, 'admin', 'N', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t97_userlevels`
--

CREATE TABLE `t97_userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t97_userlevels`
--

INSERT INTO `t97_userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `t98_userlevelpermissions`
--

CREATE TABLE `t98_userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t98_userlevelpermissions`
--

INSERT INTO `t98_userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}cf01_home.php', 111),
(-2, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t01_nasabah', 0),
(-2, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t96_employees', 0),
(-2, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t97_userlevels', 0),
(-2, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t98_userlevelpermissions', 0),
(-2, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t99_audittrail', 0),
(-2, '{D3A66325-B686-405A-A7D0-90D6B7E2446A}t96_employees', 0),
(-2, '{D3A66325-B686-405A-A7D0-90D6B7E2446A}t97_userlevels', 0),
(-2, '{D3A66325-B686-405A-A7D0-90D6B7E2446A}t98_userlevelpermissions', 0),
(-2, '{D3A66325-B686-405A-A7D0-90D6B7E2446A}t99_audittrail', 0),
(0, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}cf01_home.php', 111),
(0, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t01_nasabah', 0),
(0, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t96_employees', 0),
(0, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t97_userlevels', 0),
(0, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t98_userlevelpermissions', 0),
(0, '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t99_audittrail', 0),
(0, '{D3A66325-B686-405A-A7D0-90D6B7E2446A}t96_employees', 0),
(0, '{D3A66325-B686-405A-A7D0-90D6B7E2446A}t97_userlevels', 0),
(0, '{D3A66325-B686-405A-A7D0-90D6B7E2446A}t98_userlevelpermissions', 0),
(0, '{D3A66325-B686-405A-A7D0-90D6B7E2446A}t99_audittrail', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t99_audittrail`
--

CREATE TABLE `t99_audittrail` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t99_audittrail`
--

INSERT INTO `t99_audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2018-09-05 04:40:30', '/simkop/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(4, '2018-09-05 04:40:33', '/simkop/login.php', 'admin', 'login', '::1', '', '', '', ''),
(5, '2018-09-05 04:56:38', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'Customer', '2', '', 'Dodo'),
(6, '2018-09-05 04:56:38', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'Pekerjaan', '2', '', NULL),
(7, '2018-09-05 04:56:38', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'Alamat', '2', '', NULL),
(8, '2018-09-05 04:56:38', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'NoTelpHp', '2', '', NULL),
(9, '2018-09-05 04:56:38', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'id', '2', '', '2'),
(10, '2018-09-05 04:57:00', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'MerkType', '2', '', 'BPKB'),
(11, '2018-09-05 04:57:00', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'NoRangka', '2', '', NULL),
(12, '2018-09-05 04:57:00', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'NoMesin', '2', '', NULL),
(13, '2018-09-05 04:57:00', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'Warna', '2', '', NULL),
(14, '2018-09-05 04:57:00', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'NoPol', '2', '', NULL),
(15, '2018-09-05 04:57:00', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'Keterangan', '2', '', NULL),
(16, '2018-09-05 04:57:00', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'AtasNama', '2', '', NULL),
(17, '2018-09-05 04:57:00', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'id', '2', '', '2'),
(18, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '3', '', '10'),
(19, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '3', '', '2018-09-05'),
(20, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '3', '', '2'),
(21, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'jaminan_id', '3', '', '2'),
(22, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '3', '', '10500000'),
(23, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '3', '', '.4'),
(24, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '3', '', '3'),
(25, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '3', '', '12'),
(26, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'JumlahAngsuran', '3', '', '1000000'),
(27, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '3', '', NULL),
(28, '2018-09-05 04:57:25', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '3', '', '3'),
(29, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '4', '', '11'),
(30, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '4', '', '2018-09-30'),
(31, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '4', '', '2'),
(32, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'jaminan_id', '4', '', '2'),
(33, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '4', '', '11000000'),
(34, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '4', '', '.4'),
(35, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '4', '', '3'),
(36, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '4', '', '12'),
(37, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'JumlahAngsuran', '4', '', '2000000'),
(38, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '4', '', NULL),
(39, '2018-09-05 05:00:02', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '4', '', '4'),
(40, '2018-09-06 20:24:27', '/simkop/t01_nasabahedit.php', '1', '*** Batch update begin ***', 't02_jaminan', '', '', '', ''),
(41, '2018-09-06 20:24:27', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'nasabah_id', '1', '', '1'),
(42, '2018-09-06 20:24:27', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'MerkType', '1', '', 'ATM'),
(43, '2018-09-06 20:24:27', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'NoRangka', '1', '', NULL),
(44, '2018-09-06 20:24:27', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'NoMesin', '1', '', NULL),
(45, '2018-09-06 20:24:27', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'Warna', '1', '', NULL),
(46, '2018-09-06 20:24:27', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'NoPol', '1', '', NULL),
(47, '2018-09-06 20:24:27', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'Keterangan', '1', '', NULL),
(48, '2018-09-06 20:24:27', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'AtasNama', '1', '', NULL),
(49, '2018-09-06 20:24:27', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'id', '1', '', '1'),
(50, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'nasabah_id', '2', '', '1'),
(51, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'MerkType', '2', '', 'BPKB'),
(52, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'NoRangka', '2', '', NULL),
(53, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'NoMesin', '2', '', NULL),
(54, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'Warna', '2', '', NULL),
(55, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'NoPol', '2', '', NULL),
(56, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'Keterangan', '2', '', NULL),
(57, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'AtasNama', '2', '', NULL),
(58, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'id', '2', '', '2'),
(59, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'nasabah_id', '3', '', '1'),
(60, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'MerkType', '3', '', 'Sertifikat'),
(61, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'NoRangka', '3', '', NULL),
(62, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'NoMesin', '3', '', NULL),
(63, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'Warna', '3', '', NULL),
(64, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'NoPol', '3', '', NULL),
(65, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'Keterangan', '3', '', NULL),
(66, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'AtasNama', '3', '', NULL),
(67, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', 'A', 't02_jaminan', 'id', '3', '', '3'),
(68, '2018-09-06 20:24:28', '/simkop/t01_nasabahedit.php', '1', '*** Batch update successful ***', 't02_jaminan', '', '', '', ''),
(69, '2018-09-06 20:24:45', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'nasabah_id', '4', '', '2'),
(70, '2018-09-06 20:24:45', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'MerkType', '4', '', 'BPKB'),
(71, '2018-09-06 20:24:45', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'NoRangka', '4', '', NULL),
(72, '2018-09-06 20:24:45', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'NoMesin', '4', '', NULL),
(73, '2018-09-06 20:24:45', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'Warna', '4', '', NULL),
(74, '2018-09-06 20:24:45', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'NoPol', '4', '', NULL),
(75, '2018-09-06 20:24:45', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'Keterangan', '4', '', NULL),
(76, '2018-09-06 20:24:45', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'AtasNama', '4', '', NULL),
(77, '2018-09-06 20:24:45', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'id', '4', '', '4'),
(78, '2018-09-06 20:24:56', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'nasabah_id', '5', '', '2'),
(79, '2018-09-06 20:24:56', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'MerkType', '5', '', 'Surat Nikah'),
(80, '2018-09-06 20:24:56', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'NoRangka', '5', '', NULL),
(81, '2018-09-06 20:24:56', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'NoMesin', '5', '', NULL),
(82, '2018-09-06 20:24:56', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'Warna', '5', '', NULL),
(83, '2018-09-06 20:24:56', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'NoPol', '5', '', NULL),
(84, '2018-09-06 20:24:56', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'Keterangan', '5', '', NULL),
(85, '2018-09-06 20:24:56', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'AtasNama', '5', '', NULL),
(86, '2018-09-06 20:24:56', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'id', '5', '', '5'),
(87, '2018-09-06 20:25:07', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'nasabah_id', '6', '', '2'),
(88, '2018-09-06 20:25:07', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'MerkType', '6', '', 'Ijasah'),
(89, '2018-09-06 20:25:07', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'NoRangka', '6', '', NULL),
(90, '2018-09-06 20:25:07', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'NoMesin', '6', '', NULL),
(91, '2018-09-06 20:25:07', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'Warna', '6', '', NULL),
(92, '2018-09-06 20:25:07', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'NoPol', '6', '', NULL),
(93, '2018-09-06 20:25:07', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'Keterangan', '6', '', NULL),
(94, '2018-09-06 20:25:07', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'AtasNama', '6', '', NULL),
(95, '2018-09-06 20:25:07', '/simkop/t02_jaminanadd.php', '1', 'A', 't02_jaminan', 'id', '6', '', '6'),
(96, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(97, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-06'),
(98, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(99, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(100, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '.4'),
(101, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(102, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(103, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'JumlahAngsuran', '1', '', '1100000'),
(104, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(105, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(106, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(107, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '1', '', '1'),
(108, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '1', '', '1'),
(109, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '1', '', '1'),
(110, '2018-09-06 20:26:23', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(111, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '2', '', '2'),
(112, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '2', '', '2018-09-06'),
(113, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '2', '', '2'),
(114, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '2', '', '10500000'),
(115, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '2', '', '.4'),
(116, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '2', '', '3'),
(117, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '2', '', '12'),
(118, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'JumlahAngsuran', '2', '', '1100000'),
(119, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '2', '', NULL),
(120, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '2', '', '2'),
(121, '2018-09-06 20:41:08', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(122, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '3', '', '3'),
(123, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '3', '', '2018-09-06'),
(124, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '3', '', '1'),
(125, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '3', '', '10600000'),
(126, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '3', '', '.4'),
(127, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '3', '', '3'),
(128, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '3', '', '12'),
(129, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'JumlahAngsuran', '3', '', '1100000'),
(130, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '3', '', NULL),
(131, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '3', '', '3'),
(132, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(133, '2018-09-10 06:30:56', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(134, '2018-09-10 06:30:56', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-10'),
(135, '2018-09-10 06:30:56', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(136, '2018-09-10 06:30:56', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(137, '2018-09-10 06:30:56', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '.4'),
(138, '2018-09-10 06:30:56', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(139, '2018-09-10 06:30:56', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(140, '2018-09-10 06:30:56', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'JumlahAngsuran', '1', '', '1100000'),
(141, '2018-09-10 06:30:56', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(142, '2018-09-10 06:30:56', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(143, '2018-09-10 06:30:57', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(144, '2018-09-10 06:30:57', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '1', '', '1'),
(145, '2018-09-10 06:30:57', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '1', '', '1'),
(146, '2018-09-10 06:30:57', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '1', '', '1'),
(147, '2018-09-10 06:30:57', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(148, '2018-09-10 06:38:58', '/simkop/login.php', 'admin', 'login', '::1', '', '', '', ''),
(149, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(150, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-11'),
(151, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(152, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(153, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '0.225'),
(154, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(155, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(156, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(157, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'JumlahAngsuran', '1', '', '1100000'),
(158, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(159, '2018-09-11 09:49:52', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(160, '2018-09-11 09:49:53', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(161, '2018-09-11 09:51:18', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'JumlahAngsuran', '1', '1100000.00', '1000000.00'),
(162, '2018-09-11 09:51:18', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(163, '2018-09-11 09:51:18', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(164, '2018-09-11 09:51:18', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(165, '2018-09-11 09:51:18', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(166, '2018-09-11 09:53:35', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'JumlahAngsuran', '1', '1000000.00', '1100000'),
(167, '2018-09-11 09:53:35', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(168, '2018-09-11 09:53:35', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(169, '2018-09-11 09:53:35', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(170, '2018-09-11 09:53:35', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(171, '2018-09-11 09:55:25', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'DispensasiDenda', '1', '3', '4'),
(172, '2018-09-11 09:55:25', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(173, '2018-09-11 09:55:25', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(174, '2018-09-11 09:55:25', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(175, '2018-09-11 09:55:25', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(176, '2018-09-11 09:59:07', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'DispensasiDenda', '1', '4', '5'),
(177, '2018-09-11 09:59:07', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(178, '2018-09-11 09:59:08', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(179, '2018-09-11 09:59:08', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(180, '2018-09-11 09:59:08', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(181, '2018-09-11 10:01:52', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'DispensasiDenda', '1', '5', '6'),
(182, '2018-09-11 10:01:52', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(183, '2018-09-11 10:01:53', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(184, '2018-09-11 10:01:53', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(185, '2018-09-11 10:01:53', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(186, '2018-09-11 10:05:58', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'DispensasiDenda', '1', '6', '7'),
(187, '2018-09-11 10:05:58', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(188, '2018-09-11 10:05:58', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(189, '2018-09-11 10:05:58', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(190, '2018-09-11 10:05:58', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(191, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(192, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-11'),
(193, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(194, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(195, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(196, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.25'),
(197, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(198, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(199, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '867000'),
(200, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '233000'),
(201, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100000'),
(202, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(203, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(204, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(205, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '1', '', '1'),
(206, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '1', '', '1'),
(207, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '1', '', '1'),
(208, '2018-09-11 22:44:50', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(209, '2018-09-11 23:05:44', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '1', '867000.00', '867500'),
(210, '2018-09-11 23:05:44', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '1', '1100000.00', '1100666.6666666665'),
(211, '2018-09-11 23:05:44', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(212, '2018-09-11 23:05:44', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(213, '2018-09-11 23:05:44', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(214, '2018-09-11 23:05:44', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(215, '2018-09-11 23:23:42', '/simkop/login.php', 'admin', 'login', '::1', '', '', '', ''),
(216, '2018-09-11 23:37:59', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'Bunga', '1', '2.25', '2.2403846153846154'),
(217, '2018-09-11 23:37:59', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '1', '867500.00', '867000'),
(218, '2018-09-11 23:37:59', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '1', '1100666.62', '1100000'),
(219, '2018-09-11 23:37:59', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(220, '2018-09-11 23:37:59', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(221, '2018-09-11 23:37:59', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(222, '2018-09-11 23:37:59', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(223, '2018-09-11 23:42:34', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'Bunga', '1', '2.24', '2.25'),
(224, '2018-09-11 23:42:34', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '1', '867000.00', '866000'),
(225, '2018-09-11 23:42:34', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranBunga', '1', '233000.00', '234000'),
(226, '2018-09-11 23:42:34', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(227, '2018-09-11 23:42:34', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(228, '2018-09-11 23:42:34', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(229, '2018-09-11 23:42:34', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(230, '2018-09-11 23:48:35', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'Bunga', '1', '2.25', '2.2403846153846154'),
(231, '2018-09-11 23:48:35', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '1', '866000.00', '867000'),
(232, '2018-09-11 23:48:35', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranBunga', '1', '234000.00', '233000'),
(233, '2018-09-11 23:48:35', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(234, '2018-09-11 23:48:35', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(235, '2018-09-11 23:48:35', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(236, '2018-09-11 23:48:35', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(237, '2018-09-12 00:20:55', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(238, '2018-09-12 00:20:55', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(239, '2018-09-12 00:20:55', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(240, '2018-09-12 00:20:55', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(246, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(247, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-12'),
(248, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(249, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(250, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(251, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.23'),
(252, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(253, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(254, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '868000'),
(255, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '232000'),
(256, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100000'),
(257, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(258, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(259, '2018-09-12 00:41:39', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(260, '2018-09-12 00:42:39', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'Bunga', '1', '2.23', '2.24'),
(261, '2018-09-12 00:42:39', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '1', '868000.00', '867000'),
(262, '2018-09-12 00:42:39', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranBunga', '1', '232000.00', '233000'),
(263, '2018-09-12 00:42:39', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(264, '2018-09-12 00:42:39', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(265, '2018-09-12 00:42:39', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(266, '2018-09-12 00:42:39', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(267, '2018-09-12 00:49:09', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(268, '2018-09-12 00:49:09', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(269, '2018-09-12 00:49:09', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(270, '2018-09-12 00:49:09', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(271, '2018-09-12 00:51:26', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '1', '867000.00', '868000'),
(272, '2018-09-12 00:51:26', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '1', '1100000.00', '1101000'),
(273, '2018-09-12 00:51:26', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(274, '2018-09-12 00:51:26', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(275, '2018-09-12 00:51:26', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(276, '2018-09-12 00:51:26', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(277, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(278, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-12'),
(279, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(280, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(281, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(282, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.25'),
(283, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(284, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(285, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '866666.6666666666'),
(286, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '234000'),
(287, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100666.6666666665'),
(288, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(289, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(290, '2018-09-12 00:52:51', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(291, '2018-09-12 00:54:02', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '1', '866666.69', '867000'),
(292, '2018-09-12 00:54:02', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '1', '1100666.62', '1101000'),
(293, '2018-09-12 00:55:18', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'Bunga', '1', '2.25', '2.24'),
(294, '2018-09-12 00:55:18', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranBunga', '1', '234000.00', '233000'),
(295, '2018-09-12 00:55:18', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '1', '1101000.00', '1100000'),
(296, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(297, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-12'),
(298, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(299, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(300, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(301, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.25'),
(302, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(303, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(304, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '866666.6666666666'),
(305, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '234000'),
(306, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100666.6666666665'),
(307, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(308, '2018-09-12 00:59:01', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(309, '2018-09-12 00:59:02', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(310, '2018-09-12 00:59:29', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '1', '866666.69', '867000'),
(311, '2018-09-12 00:59:29', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '1', '1100666.62', '1101000'),
(312, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(313, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-12'),
(314, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(315, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(316, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(317, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.25'),
(318, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(319, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(320, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '866666.6666666666'),
(321, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '234000'),
(322, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100666.6666666665'),
(323, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(324, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(325, '2018-09-12 01:02:20', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(326, '2018-09-12 01:03:13', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '1', '866666.69', '867000'),
(327, '2018-09-12 01:03:13', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '1', '1100666.62', '1101000'),
(328, '2018-09-12 01:03:48', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'Bunga', '1', '2.25', '2.24'),
(329, '2018-09-12 01:03:48', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranBunga', '1', '234000.00', '233000'),
(330, '2018-09-12 01:03:48', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '1', '1101000.00', '1100000'),
(331, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '2', '', '2'),
(332, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '2', '', '2018-09-12'),
(333, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '2', '', '2'),
(334, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '2', '', '10500000'),
(335, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '2', '', '12'),
(336, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '2', '', '2.25'),
(337, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '2', '', '0.4'),
(338, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '2', '', '3'),
(339, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '2', '', '875000'),
(340, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '2', '', '236250'),
(341, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '2', '', '1111250'),
(342, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '2', '', NULL),
(343, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '2', '', '2'),
(344, '2018-09-12 01:09:38', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(345, '2018-09-12 01:17:08', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'Customer', '3', '', 'Hendra'),
(346, '2018-09-12 01:17:08', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'Pekerjaan', '3', '', NULL),
(347, '2018-09-12 01:17:08', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'Alamat', '3', '', NULL),
(348, '2018-09-12 01:17:08', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'NoTelpHp', '3', '', NULL),
(349, '2018-09-12 01:17:08', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'id', '3', '', '3'),
(350, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '3', '', '3'),
(351, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '3', '', '2018-09-12'),
(352, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '3', '', '3'),
(353, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '3', '', '10600000'),
(354, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '3', '', '12'),
(355, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '3', '', '2.25'),
(356, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '3', '', '0.4'),
(357, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '3', '', '3'),
(358, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '3', '', '883333.3333333334'),
(359, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '3', '', '238500'),
(360, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '3', '', '1121833.3333333335'),
(361, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '3', '', NULL),
(362, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '3', '', '3'),
(363, '2018-09-12 01:17:19', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(364, '2018-09-12 01:18:32', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'Customer', '4', '', 'Vico'),
(365, '2018-09-12 01:18:32', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'Pekerjaan', '4', '', NULL),
(366, '2018-09-12 01:18:32', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'Alamat', '4', '', NULL),
(367, '2018-09-12 01:18:32', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'NoTelpHp', '4', '', NULL),
(368, '2018-09-12 01:18:32', '/simkop/t01_nasabahaddopt.php', '1', 'A', 't01_nasabah', 'id', '4', '', '4'),
(369, '2018-09-12 01:19:04', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'nasabah_id', '7', '', '4'),
(370, '2018-09-12 01:19:04', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'MerkType', '7', '', 'Sertifikat'),
(371, '2018-09-12 01:19:04', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'NoRangka', '7', '', NULL),
(372, '2018-09-12 01:19:04', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'NoMesin', '7', '', NULL),
(373, '2018-09-12 01:19:04', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'Warna', '7', '', NULL),
(374, '2018-09-12 01:19:04', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'NoPol', '7', '', NULL),
(375, '2018-09-12 01:19:04', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'Keterangan', '7', '', NULL),
(376, '2018-09-12 01:19:04', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'AtasNama', '7', '', NULL),
(377, '2018-09-12 01:19:04', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'id', '7', '', '7'),
(378, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '4', '', '4'),
(379, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '4', '', '2018-09-12'),
(380, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '4', '', '4'),
(381, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '4', '', '11000000'),
(382, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '4', '', '12'),
(383, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '4', '', '2.25'),
(384, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '4', '', '0.4'),
(385, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '4', '', '3'),
(386, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '4', '', '916666.6666666666'),
(387, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '4', '', '247500'),
(388, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '4', '', '1164166.6666666665'),
(389, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '4', '', NULL),
(390, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '4', '', '4'),
(391, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(392, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '1', '', '4'),
(393, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '1', '', '7'),
(394, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '1', '', '1'),
(395, '2018-09-12 01:19:09', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(396, '2018-09-12 01:21:24', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '4', '916666.69', '917000'),
(397, '2018-09-12 01:21:24', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranBunga', '4', '247500.00', '248000'),
(398, '2018-09-12 01:21:24', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '4', '1164166.62', '1165000'),
(399, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(400, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-12'),
(401, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(402, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(403, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(404, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.25'),
(405, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(406, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(407, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '866666.6666666666'),
(408, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '234000'),
(409, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100666.6666666665'),
(410, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(411, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(412, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(413, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '1', '', '1'),
(414, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '1', '', '1'),
(415, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '1', '', '1'),
(416, '2018-09-12 01:27:51', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(417, '2018-09-12 01:28:31', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '1', '866666.69', '867000'),
(418, '2018-09-12 01:28:31', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '1', '1100666.62', '1101000'),
(419, '2018-09-12 01:28:59', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'Bunga', '1', '2.25', '2.24'),
(420, '2018-09-12 01:28:59', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranBunga', '1', '234000.00', '233000'),
(421, '2018-09-12 01:28:59', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '1', '1101000.00', '1100000'),
(422, '2018-09-12 01:28:59', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(423, '2018-09-12 01:28:59', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', '');
INSERT INTO `t99_audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(424, '2018-09-12 01:28:59', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(425, '2018-09-12 01:28:59', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(426, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '2', '', '2'),
(427, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '2', '', '2018-09-12'),
(428, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '2', '', '2'),
(429, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '2', '', '10500000'),
(430, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '2', '', '12'),
(431, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '2', '', '2.25'),
(432, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '2', '', '0.4'),
(433, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '2', '', '3'),
(434, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '2', '', '875000'),
(435, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '2', '', '236250'),
(436, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '2', '', '1111250'),
(437, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '2', '', NULL),
(438, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '2', '', '2'),
(439, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't04_angsuran', '', '', '', ''),
(440, '2018-09-12 01:32:10', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(441, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '3', '', '3'),
(442, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '3', '', '2018-09-12'),
(443, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '3', '', '3'),
(444, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '3', '', '10600000'),
(445, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '3', '', '12'),
(446, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '3', '', '2.25'),
(447, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '3', '', '0.4'),
(448, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '3', '', '3'),
(449, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '3', '', '883333.3333333334'),
(450, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '3', '', '238500'),
(451, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '3', '', '1121833.3333333335'),
(452, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '3', '', NULL),
(453, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '3', '', '3'),
(454, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't04_angsuran', '', '', '', ''),
(455, '2018-09-12 01:33:29', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(456, '2018-09-12 01:35:17', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '3', '883333.31', '884000'),
(457, '2018-09-12 01:35:17', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '3', '1121833.38', '1122500'),
(458, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(459, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-12'),
(460, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(461, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(462, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(463, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.25'),
(464, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(465, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(466, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '866666.6666666666'),
(467, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '234000'),
(468, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100666.6666666665'),
(469, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(470, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(471, '2018-09-12 01:42:10', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(472, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '2', '', '2'),
(473, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '2', '', '2018-09-12'),
(474, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '2', '', '2'),
(475, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '2', '', '10500000'),
(476, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '2', '', '12'),
(477, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '2', '', '2.25'),
(478, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '2', '', '0.4'),
(479, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '2', '', '3'),
(480, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '2', '', '875000'),
(481, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '2', '', '236250'),
(482, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '2', '', '1111250'),
(483, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '2', '', NULL),
(484, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '2', '', '2'),
(485, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't04_angsuran', '', '', '', ''),
(486, '2018-09-12 01:45:35', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(487, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(488, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-12'),
(489, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(490, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(491, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(492, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.25'),
(493, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(494, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(495, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '866666.6666666666'),
(496, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '234000'),
(497, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100666.6666666665'),
(498, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(499, '2018-09-12 16:55:45', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(500, '2018-09-12 16:55:46', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't04_angsuran', '', '', '', ''),
(501, '2018-09-12 16:55:46', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(502, '2018-09-14 10:47:52', '/simkop/login.php', 'admin', 'login', '::1', '', '', '', ''),
(503, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(504, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-14'),
(505, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(506, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(507, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(508, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.25'),
(509, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(510, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(511, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '866666.6666666666'),
(512, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '234000'),
(513, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100666.6666666665'),
(514, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(515, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(516, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(517, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '1', '', '1'),
(518, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '1', '', '1'),
(519, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '1', '', '1'),
(520, '2018-09-14 10:48:39', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(521, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '2', '', '2'),
(522, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '2', '', '2018-09-14'),
(523, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '2', '', '2'),
(524, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '2', '', '10500000'),
(525, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '2', '', '12'),
(526, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '2', '', '2.25'),
(527, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '2', '', '0.4'),
(528, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '2', '', '3'),
(529, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '2', '', '875000'),
(530, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '2', '', '236250'),
(531, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '2', '', '1111250'),
(532, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '2', '', NULL),
(533, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '2', '', '2'),
(534, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(535, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '2', '', '2'),
(536, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '2', '', '4'),
(537, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '2', '', '2'),
(538, '2018-09-14 10:56:53', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(539, '2018-09-14 11:00:09', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'nasabah_id', '8', '', '3'),
(540, '2018-09-14 11:00:09', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'MerkType', '8', '', 'Sertifikat'),
(541, '2018-09-14 11:00:09', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'NoRangka', '8', '', NULL),
(542, '2018-09-14 11:00:09', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'NoMesin', '8', '', NULL),
(543, '2018-09-14 11:00:09', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'Warna', '8', '', NULL),
(544, '2018-09-14 11:00:09', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'NoPol', '8', '', NULL),
(545, '2018-09-14 11:00:09', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'Keterangan', '8', '', NULL),
(546, '2018-09-14 11:00:09', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'AtasNama', '8', '', NULL),
(547, '2018-09-14 11:00:09', '/simkop/t02_jaminanaddopt.php', '1', 'A', 't02_jaminan', 'id', '8', '', '8'),
(548, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '3', '', '3'),
(549, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '3', '', '2018-09-14'),
(550, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '3', '', '3'),
(551, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '3', '', '10600000'),
(552, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '3', '', '12'),
(553, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '3', '', '2.25'),
(554, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '3', '', '0.4'),
(555, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '3', '', '3'),
(556, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '3', '', '883333.3333333334'),
(557, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '3', '', '238500'),
(558, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '3', '', '1121833.3333333335'),
(559, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '3', '', NULL),
(560, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '3', '', '3'),
(561, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(562, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '3', '', '3'),
(563, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '3', '', '8'),
(564, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '3', '', '3'),
(565, '2018-09-14 11:00:12', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(566, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '4', '', '4'),
(567, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '4', '', '2018-09-14'),
(568, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '4', '', '4'),
(569, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '4', '', '11000000'),
(570, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '4', '', '12'),
(571, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '4', '', '2.25'),
(572, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '4', '', '0.4'),
(573, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '4', '', '3'),
(574, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '4', '', '916666.6666666666'),
(575, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '4', '', '247500'),
(576, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '4', '', '1164166.6666666665'),
(577, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '4', '', NULL),
(578, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '4', '', '4'),
(579, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(580, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '4', '', '7'),
(581, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '4', '', '4'),
(582, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '4', '', '4'),
(583, '2018-09-14 11:04:53', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(584, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(585, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-14'),
(586, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(587, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(588, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(589, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.25'),
(590, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(591, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(592, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '866666.6666666666'),
(593, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '234000'),
(594, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100666.6666666665'),
(595, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(596, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(597, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(598, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '1', '', '1'),
(599, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '1', '', '1'),
(600, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '1', '', '1'),
(601, '2018-09-14 11:10:15', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(602, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '2', '', '2'),
(603, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '2', '', '2018-09-14'),
(604, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '2', '', '2'),
(605, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '2', '', '10500000'),
(606, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '2', '', '12'),
(607, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '2', '', '2.25'),
(608, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '2', '', '0.4'),
(609, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '2', '', '3'),
(610, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '2', '', '875000'),
(611, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '2', '', '236250'),
(612, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '2', '', '1111250'),
(613, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '2', '', NULL),
(614, '2018-09-14 11:18:37', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '2', '', '2'),
(615, '2018-09-14 11:18:38', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(616, '2018-09-14 11:18:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '2', '', '6'),
(617, '2018-09-14 11:18:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '2', '', '2'),
(618, '2018-09-14 11:18:38', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '2', '', '2'),
(619, '2018-09-14 11:18:38', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(620, '2018-09-14 11:19:09', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '2', '875000.00', '880000'),
(621, '2018-09-14 11:19:09', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '2', '1111250.00', '1116250'),
(622, '2018-09-14 11:19:09', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(623, '2018-09-14 11:19:09', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(624, '2018-09-14 11:19:09', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(625, '2018-09-14 11:19:09', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(626, '2018-09-14 11:20:32', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '2', '880000.00', '885000'),
(627, '2018-09-14 11:20:32', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '2', '1116250.00', '1121250'),
(628, '2018-09-14 11:20:32', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(629, '2018-09-14 11:20:32', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(630, '2018-09-14 11:20:32', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(631, '2018-09-14 11:20:32', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(632, '2018-09-14 11:21:35', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '2', '885000.00', '880000'),
(633, '2018-09-14 11:21:35', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '2', '1121250.00', '1116250'),
(634, '2018-09-14 11:21:36', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(635, '2018-09-14 11:21:36', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(636, '2018-09-14 11:21:36', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(637, '2018-09-14 11:21:36', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(638, '2018-09-14 11:22:50', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranPokok', '2', '880000.00', '881000'),
(639, '2018-09-14 11:22:50', '/simkop/t03_pinjamanedit.php', '1', 'U', 't03_pinjaman', 'AngsuranTotal', '2', '1116250.00', '1117250'),
(640, '2018-09-14 11:22:50', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't04_angsuran', '', '', '', ''),
(641, '2018-09-14 11:22:50', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't04_angsuran', '', '', '', ''),
(642, '2018-09-14 11:22:50', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(643, '2018-09-14 11:22:50', '/simkop/t03_pinjamanedit.php', '1', '*** Batch update successful ***', 't05_pinjamanjaminan', '', '', '', ''),
(644, '2018-09-14 17:17:21', '/simkop/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(645, '2018-09-14 17:17:27', '/simkop/login.php', 'admin', 'login', '::1', '', '', '', ''),
(646, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrak', '1', '', '1'),
(647, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'TglKontrak', '1', '', '2018-09-14'),
(648, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'nasabah_id', '1', '', '1'),
(649, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Pinjaman', '1', '', '10400000'),
(650, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'LamaAngsuran', '1', '', '12'),
(651, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Bunga', '1', '', '2.25'),
(652, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'Denda', '1', '', '0.4'),
(653, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'DispensasiDenda', '1', '', '3'),
(654, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranPokok', '1', '', '866666.6666666666'),
(655, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranBunga', '1', '', '234000'),
(656, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'AngsuranTotal', '1', '', '1100666.6666666665'),
(657, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'NoKontrakRefTo', '1', '', NULL),
(658, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't03_pinjaman', 'id', '1', '', '1'),
(659, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', ''),
(660, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'jaminan_id', '1', '', '1'),
(661, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'pinjaman_id', '1', '', '1'),
(662, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', 'A', 't05_pinjamanjaminan', 'id', '1', '', '1'),
(663, '2018-09-14 17:18:05', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert successful ***', 't05_pinjamanjaminan', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t01_nasabah`
--
ALTER TABLE `t01_nasabah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t02_jaminan`
--
ALTER TABLE `t02_jaminan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t03_pinjaman`
--
ALTER TABLE `t03_pinjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t04_angsuran`
--
ALTER TABLE `t04_angsuran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t05_pinjamanjaminan`
--
ALTER TABLE `t05_pinjamanjaminan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t96_employees`
--
ALTER TABLE `t96_employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `t97_userlevels`
--
ALTER TABLE `t97_userlevels`
  ADD PRIMARY KEY (`userlevelid`);

--
-- Indexes for table `t98_userlevelpermissions`
--
ALTER TABLE `t98_userlevelpermissions`
  ADD PRIMARY KEY (`userlevelid`,`tablename`);

--
-- Indexes for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t01_nasabah`
--
ALTER TABLE `t01_nasabah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t02_jaminan`
--
ALTER TABLE `t02_jaminan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `t03_pinjaman`
--
ALTER TABLE `t03_pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t04_angsuran`
--
ALTER TABLE `t04_angsuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t05_pinjamanjaminan`
--
ALTER TABLE `t05_pinjamanjaminan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t96_employees`
--
ALTER TABLE `t96_employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=664;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
