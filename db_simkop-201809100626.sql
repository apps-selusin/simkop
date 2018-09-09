-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 10, 2018 at 01:26 AM
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
(2, 'Dodo', NULL, NULL, NULL);

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
(6, 2, 'Ijasah', NULL, NULL, NULL, NULL, NULL, NULL);

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
  `Denda` decimal(5,2) NOT NULL,
  `DispensasiDenda` tinyint(4) NOT NULL,
  `LamaAngsuran` tinyint(4) NOT NULL,
  `JumlahAngsuran` float(14,2) NOT NULL,
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
  `TanggalBayar` date NOT NULL,
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
(132, '2018-09-06 20:48:31', '/simkop/t03_pinjamanadd.php', '1', '*** Batch insert begin ***', 't05_pinjamanjaminan', '', '', '', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t02_jaminan`
--
ALTER TABLE `t02_jaminan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
