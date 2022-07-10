-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 10, 2022 at 11:43 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tracerstudy`
--

-- --------------------------------------------------------

--
-- Table structure for table `b_asing`
--

DROP TABLE IF EXISTS `b_asing`;
CREATE TABLE IF NOT EXISTS `b_asing` (
  `idb_asing` varchar(6) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `nm_bahasa` varchar(45) NOT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `file` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idb_asing`),
  KEY `FK_b_asing_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `b_asing`
--

INSERT INTO `b_asing` (`idb_asing`, `idusers`, `nm_bahasa`, `keterangan`, `file`) VALUES
('B00001', 'U00002', 'Bahasa Inggris', '-', 'U00002/1657033826_6cbc87e304d2329bc0ca.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `b_daerah`
--

DROP TABLE IF EXISTS `b_daerah`;
CREATE TABLE IF NOT EXISTS `b_daerah` (
  `idb_daerah` varchar(6) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `nm_bahasa` varchar(45) NOT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `file` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idb_daerah`),
  KEY `FK_b_daerah_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deskripsi_diri`
--

DROP TABLE IF EXISTS `deskripsi_diri`;
CREATE TABLE IF NOT EXISTS `deskripsi_diri` (
  `iddeskripsi` varchar(6) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `deskripsi` text NOT NULL,
  PRIMARY KEY (`iddeskripsi`),
  KEY `FK_deskripsi_diri_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deskripsi_diri`
--

INSERT INTO `deskripsi_diri` (`iddeskripsi`, `idusers`, `deskripsi`) VALUES
('D00001', 'U00002', '<p>Deskripsi singkat tentang atika rampa</p>');

-- --------------------------------------------------------

--
-- Table structure for table `identitas`
--

DROP TABLE IF EXISTS `identitas`;
CREATE TABLE IF NOT EXISTS `identitas` (
  `kode` varchar(6) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `instansi` varchar(255) CHARACTER SET latin1 NOT NULL,
  `slogan` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `tahun` float DEFAULT NULL,
  `pimpinan` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `kdpos` varchar(7) CHARACTER SET latin1 DEFAULT NULL,
  `tlp` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `fax` varchar(35) CHARACTER SET latin1 DEFAULT NULL,
  `website` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `logo` longtext CHARACTER SET latin1,
  `lat` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `lon` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `identitas`
--

INSERT INTO `identitas` (`kode`, `instansi`, `slogan`, `tahun`, `pimpinan`, `alamat`, `kdpos`, `tlp`, `fax`, `website`, `email`, `logo`, `lat`, `lon`) VALUES
('K00001', 'TRACER STUDY', 'Ghora Wira Madya Jala', 1985, 'Laksamana Muda TNI Iwan Isnurwanto, M.A.P., M.Tr.(Han).', 'Dermaga Ujung Surabaya, Jawa Timur', '60178', '08', '-', 'https://koarmada2.tnial.mil.id/', 'rampa@gmail.com', '1657029499_19b3fea6a77eae53f5fb.png', '-7.4063726', '112.5841074');

-- --------------------------------------------------------

--
-- Table structure for table `korps`
--

DROP TABLE IF EXISTS `korps`;
CREATE TABLE IF NOT EXISTS `korps` (
  `idkorps` varchar(6) NOT NULL,
  `nama_korps` varchar(45) NOT NULL,
  PRIMARY KEY (`idkorps`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korps`
--

INSERT INTO `korps` (`idkorps`, `nama_korps`) VALUES
('K00000', 'ADMINISTRATOR'),
('K00001', 'Laut (P)'),
('K00002', 'Laut (T)'),
('K00003', 'Laut (E)'),
('K00004', 'Laut (S)'),
('K00005', 'Laut (PM)'),
('K00006', 'Laut (K)'),
('K00007', 'Laut (KH)'),
('K00008', 'Marinir'),
('K00009', 'Bah'),
('K00010', 'Nav'),
('K00011', 'Kom'),
('K00012', 'Tlg'),
('K00013', 'Ekl'),
('K00014', 'Eko'),
('K00015', 'Mer'),
('K00016', 'Amo'),
('K00017', 'Rdl'),
('K00018', 'SAA'),
('K00019', 'SBA'),
('K00020', 'TRB'),
('K00021', 'Esa'),
('K00022', 'ETK'),
('K00023', 'PDK'),
('K00024', 'Jas'),
('K00025', 'Mus'),
('K00026', 'TTG'),
('K00027', 'Ttu'),
('K00028', 'Keu'),
('K00029', 'Mes'),
('K00030', 'Lis'),
('K00031', 'TKU'),
('K00032', 'MPU'),
('K00033', 'LPU'),
('K00034', 'Ang'),
('K00036', 'POM'),
('K00037', 'EDE'),
('K00038', 'Lek'),
('K00039', 'Pas'),
('K00040', 'PNS'),
('K00042', 'Tek'),
('K00043', 'Bek'),
('K00044', 'Adm');

-- --------------------------------------------------------

--
-- Table structure for table `pangkat`
--

DROP TABLE IF EXISTS `pangkat`;
CREATE TABLE IF NOT EXISTS `pangkat` (
  `idpangkat` varchar(6) NOT NULL,
  `nama_pangkat` varchar(45) NOT NULL,
  PRIMARY KEY (`idpangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pangkat`
--

INSERT INTO `pangkat` (`idpangkat`, `nama_pangkat`) VALUES
('P00001', 'ADMINISTRATOR'),
('P00005', 'Laksma TNI'),
('P00010', 'Kolonel'),
('P00011', 'Letkol'),
('P00012', 'Mayor'),
('P00013', 'Kapten'),
('P00014', 'Lettu'),
('P00016', 'Peltu'),
('P00017', 'Pelda'),
('P00018', 'Serma'),
('P00019', 'Serka'),
('P00020', 'Sertu'),
('P00031', 'Penata Tk I III/d'),
('P00033', 'Penata III/C');

-- --------------------------------------------------------

--
-- Table structure for table `pend_militer`
--

DROP TABLE IF EXISTS `pend_militer`;
CREATE TABLE IF NOT EXISTS `pend_militer` (
  `idpendidikan` varchar(6) CHARACTER SET latin1 NOT NULL,
  `idusers` varchar(20) NOT NULL,
  `nm_pendidikan` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `tahun` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `keterangan` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `file` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idpendidikan`),
  KEY `FK_pend_militer_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pend_militer`
--

INSERT INTO `pend_militer` (`idpendidikan`, `idusers`, `nm_pendidikan`, `tahun`, `keterangan`, `file`) VALUES
('M00001', 'U00002', 'SESKO', '2000', '-', 'U00002/1657031868_caafbda07358324b409c.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pend_umum`
--

DROP TABLE IF EXISTS `pend_umum`;
CREATE TABLE IF NOT EXISTS `pend_umum` (
  `idpendidikan` varchar(6) CHARACTER SET latin1 NOT NULL,
  `idusers` varchar(20) NOT NULL,
  `nm_pendidikan` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `tahun` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `keterangan` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `file` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idpendidikan`),
  KEY `FK_pendidikan_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pend_umum`
--

INSERT INTO `pend_umum` (`idpendidikan`, `idusers`, `nm_pendidikan`, `tahun`, `keterangan`, `file`) VALUES
('U00001', 'U00002', 'SD', '2000', '-', 'U00002/1657031398_2870325434fe1a1b38cc.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_jabatan`
--

DROP TABLE IF EXISTS `riwayat_jabatan`;
CREATE TABLE IF NOT EXISTS `riwayat_jabatan` (
  `idr_jab` varchar(6) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `tanggal` date NOT NULL,
  `jabatan` varchar(250) NOT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idr_jab`),
  KEY `FK_riwayat_jabatan_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pangkat`
--

DROP TABLE IF EXISTS `riwayat_pangkat`;
CREATE TABLE IF NOT EXISTS `riwayat_pangkat` (
  `idriwayat_pangkat` varchar(6) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `tanggal` date NOT NULL,
  `idpangkat` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idriwayat_pangkat`),
  KEY `FK_riwayat_pangkat_users` (`idusers`),
  KEY `FK_riwayat_pangkat_pangkat` (`idpangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `idrole` varchar(6) NOT NULL,
  `nama_role` varchar(45) NOT NULL,
  PRIMARY KEY (`idrole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`idrole`, `nama_role`) VALUES
('R00001', 'ADMINISTRATOR'),
('R00002', 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `tanda_jasa`
--

DROP TABLE IF EXISTS `tanda_jasa`;
CREATE TABLE IF NOT EXISTS `tanda_jasa` (
  `idtjasa` varchar(6) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `tanda_jasa` varchar(45) NOT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idtjasa`),
  KEY `FK_tanda_jasa_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idusers` varchar(20) NOT NULL,
  `nrp` varchar(15) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `idrole` varchar(6) NOT NULL,
  `idkorps` varchar(6) NOT NULL,
  `idpangkat` varchar(6) NOT NULL,
  `foto` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idusers`),
  KEY `FK_users_role` (`idrole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idusers`, `nrp`, `pass`, `nama`, `idrole`, `idkorps`, `idpangkat`, `foto`) VALUES
('U00001', 'ADMIN', 'aGtq', 'ADMIN', 'R00001', 'K00000', 'P00001', 'U00001/foto.jpeg'),
('U00002', '111', 'aGtq', 'Rampa atika', 'R00002', 'K00001', 'P00013', 'U00002/1657446208_779fd4eb0b7fd3898840.png');

-- --------------------------------------------------------

--
-- Table structure for table `users_detil`
--

DROP TABLE IF EXISTS `users_detil`;
CREATE TABLE IF NOT EXISTS `users_detil` (
  `idusers_detil` varchar(6) CHARACTER SET latin1 NOT NULL,
  `idusers` varchar(20) NOT NULL,
  `ms_dinas_pngkt` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `tmt_tni` date DEFAULT NULL,
  `ms_dinas_prajurit` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `tmp_lahir` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `suku` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `jabatan` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `lama_jabatan` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `alamat` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `tmt_fiktif` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `jkel` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `agama` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idusers_detil`),
  KEY `FK_users_detil_user` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_detil`
--

INSERT INTO `users_detil` (`idusers_detil`, `idusers`, `ms_dinas_pngkt`, `tmt_tni`, `ms_dinas_prajurit`, `tmp_lahir`, `tgl_lahir`, `suku`, `jabatan`, `lama_jabatan`, `alamat`, `tmt_fiktif`, `jkel`, `agama`) VALUES
('D00001', 'U00002', '-', '2022-05-20', '-', 'Surabaya', '1989-08-02', 'Jawa', '-', '-', 'Gunung Anyar', '-', 'L', 'Islam'),
('D00002', 'U00001', NULL, NULL, NULL, NULL, '1991-08-02', NULL, NULL, NULL, NULL, NULL, NULL, 'Islam'),
('D00003', 'U00002', '-', '2022-05-20', '-', 'Surabaya', '1989-08-02', 'Jawa', '-', '-', 'Gunung Anyar', '-', 'L', 'Islam');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `b_asing`
--
ALTER TABLE `b_asing`
  ADD CONSTRAINT `FK_b_asing_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `b_daerah`
--
ALTER TABLE `b_daerah`
  ADD CONSTRAINT `FK_b_daerah_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deskripsi_diri`
--
ALTER TABLE `deskripsi_diri`
  ADD CONSTRAINT `FK_deskripsi_diri_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pend_militer`
--
ALTER TABLE `pend_militer`
  ADD CONSTRAINT `FK_pend_militer_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pend_umum`
--
ALTER TABLE `pend_umum`
  ADD CONSTRAINT `FK_pendidikan_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_jabatan`
--
ALTER TABLE `riwayat_jabatan`
  ADD CONSTRAINT `FK_riwayat_jabatan_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_pangkat`
--
ALTER TABLE `riwayat_pangkat`
  ADD CONSTRAINT `FK_riwayat_pangkat_pangkat` FOREIGN KEY (`idpangkat`) REFERENCES `pangkat` (`idpangkat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_riwayat_pangkat_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tanda_jasa`
--
ALTER TABLE `tanda_jasa`
  ADD CONSTRAINT `FK_tanda_jasa_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_role` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_detil`
--
ALTER TABLE `users_detil`
  ADD CONSTRAINT `FK_users_detil_user` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
