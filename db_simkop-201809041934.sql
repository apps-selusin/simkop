-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 04, 2018 at 02:34 PM
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
(1, 'Andoko', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t02_jaminan`
--

CREATE TABLE `t02_jaminan` (
  `id` int(11) NOT NULL,
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

INSERT INTO `t02_jaminan` (`id`, `MerkType`, `NoRangka`, `NoMesin`, `Warna`, `NoPol`, `Keterangan`, `AtasNama`) VALUES
(1, 'ATM', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t03_pinjaman`
--

CREATE TABLE `t03_pinjaman` (
  `id` int(11) NOT NULL,
  `NoKontrak` varchar(25) NOT NULL,
  `TglKontrak` date NOT NULL,
  `nasabah_id` int(11) NOT NULL,
  `jaminan_id` int(11) NOT NULL,
  `Pinjaman` float(14,2) NOT NULL,
  `Denda` decimal(5,2) NOT NULL,
  `DispensasiDenda` tinyint(4) NOT NULL,
  `LamaAngsuran` tinyint(4) NOT NULL,
  `JumlahAngsuran` float(14,2) NOT NULL,
  `NoKontrakRefTo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t03_pinjaman`
--

INSERT INTO `t03_pinjaman` (`id`, `NoKontrak`, `TglKontrak`, `nasabah_id`, `jaminan_id`, `Pinjaman`, `Denda`, `DispensasiDenda`, `LamaAngsuran`, `JumlahAngsuran`, `NoKontrakRefTo`) VALUES
(1, '99001', '2015-01-01', 1, 1, 10400000.00, '0.40', 3, 12, 1100000.00, NULL),
(2, '9', '2018-09-30', 1, 1, 10400000.00, '0.40', 3, 12, 1100000.00, NULL);

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

--
-- Dumping data for table `t04_angsuran`
--

INSERT INTO `t04_angsuran` (`id`, `pinjaman_id`, `AngsuranKe`, `AngsuranTanggal`, `AngsuranPokok`, `AngsuranBunga`, `AngsuranTotal`, `SisaHutang`, `TanggalBayar`, `TotalDenda`, `Terlambat`, `Keterangan`) VALUES
(1, 2, 1, '2018-10-30', 867000.00, 233000.00, 1100000.00, 9533000.00, '0000-00-00', NULL, NULL, NULL),
(2, 2, 2, '2018-11-30', 867000.00, 233000.00, 1100000.00, 8666000.00, '0000-00-00', NULL, NULL, NULL),
(3, 2, 3, '2018-12-30', 867000.00, 233000.00, 1100000.00, 7799000.00, '0000-00-00', NULL, NULL, NULL),
(4, 2, 4, '2019-01-30', 867000.00, 233000.00, 1100000.00, 6932000.00, '0000-00-00', NULL, NULL, NULL),
(5, 2, 5, '2019-02-28', 867000.00, 233000.00, 1100000.00, 6065000.00, '0000-00-00', NULL, NULL, NULL),
(6, 2, 6, '2019-03-30', 867000.00, 233000.00, 1100000.00, 5198000.00, '0000-00-00', NULL, NULL, NULL),
(7, 2, 7, '2019-04-30', 867000.00, 233000.00, 1100000.00, 4331000.00, '0000-00-00', NULL, NULL, NULL),
(8, 2, 8, '2019-05-30', 867000.00, 233000.00, 1100000.00, 3464000.00, '0000-00-00', NULL, NULL, NULL),
(9, 2, 9, '2019-06-30', 867000.00, 233000.00, 1100000.00, 2597000.00, '0000-00-00', NULL, NULL, NULL),
(10, 2, 10, '2019-07-30', 867000.00, 233000.00, 1100000.00, 1730000.00, '0000-00-00', NULL, NULL, NULL),
(11, 2, 11, '2019-08-30', 867000.00, 233000.00, 1100000.00, 863000.00, '0000-00-00', NULL, NULL, NULL),
(12, 2, 12, '2019-09-30', 863000.00, 237000.00, 1100000.00, 0.00, '0000-00-00', NULL, NULL, NULL);

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
(3, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t02_jaminan`
--
ALTER TABLE `t02_jaminan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t03_pinjaman`
--
ALTER TABLE `t03_pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t04_angsuran`
--
ALTER TABLE `t04_angsuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `t96_employees`
--
ALTER TABLE `t96_employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
