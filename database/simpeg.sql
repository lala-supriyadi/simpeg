-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2020 at 09:08 AM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simpeg`
--

-- --------------------------------------------------------

--
-- Table structure for table `anak`
--

CREATE TABLE IF NOT EXISTS `anak` (
  `id_anak` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `nik` int(50) NOT NULL,
  `nama_anak` varchar(150) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `pendidikan` varchar(150) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `hubungan` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anak`
--

INSERT INTO `anak` (`id_anak`, `id_karyawan`, `nik`, `nama_anak`, `tempat_lahir`, `tgl_lahir`, `pendidikan`, `pekerjaan`, `hubungan`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(1, 4, 2147483647, 'asdf', 'Bandung', '2020-09-27', 'SMP', 'asdf', 'Anak kandung', '2020-10-13 12:33:28', 'admin', '2020-10-13 13:09:36', 'admin', 0),
(2, 2, 54645, 'dfdg', 'Bandung', '2020-09-27', 'SMP', 'fvnb', 'Anak kandung', '2020-10-13 13:42:25', 'admin', '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE IF NOT EXISTS `cuti` (
  `id_cuti` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `jenis_cuti` varchar(100) NOT NULL,
  `no_surat_cuti` varchar(100) NOT NULL,
  `tgl_surat_cuti` date NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pinjam`
--

CREATE TABLE IF NOT EXISTS `detail_pinjam` (
  `id_detail_pinjam` int(11) NOT NULL,
  `id_pinjaman` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `cicilan_ke` int(11) NOT NULL,
  `bayar` float NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE IF NOT EXISTS `divisi` (
  `id_divisi` int(11) NOT NULL,
  `id_penempatan` int(11) NOT NULL,
  `nama_divisi` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `id_penempatan`, `nama_divisi`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(1, 3, 'HRD', '2020-08-12 13:21:22', 'admin', '0000-00-00 00:00:00', '', 0),
(2, 3, 'Marketing', '2020-08-15 07:29:35', 'admin', '0000-00-00 00:00:00', '', 0),
(3, 3, 'GA', '2020-08-15 07:29:46', 'admin', '0000-00-00 00:00:00', '', 0),
(4, 3, 'Finance', '2020-08-15 07:29:55', 'admin', '0000-00-00 00:00:00', '', 0),
(5, 3, 'Accounting', '2020-08-15 07:30:01', 'admin', '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gaji_karyawan`
--

CREATE TABLE IF NOT EXISTS `gaji_karyawan` (
  `id_gaji_karyawan` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `nama_karyawan` varchar(150) NOT NULL,
  `nip` bigint(50) NOT NULL,
  `periode` varchar(50) NOT NULL,
  `jml_hari` int(11) NOT NULL,
  `tunj_jabatan` float NOT NULL,
  `tunj_bpjstk` float NOT NULL,
  `tunj_bpjskes` float NOT NULL,
  `tunj_dapen` float NOT NULL,
  `bpjstk_stat_tun` int(11) NOT NULL,
  `bpjskes_stat_tun` int(11) NOT NULL,
  `dapen_stat_tun` int(11) NOT NULL,
  `tunj_makan` float NOT NULL,
  `tunj_lain` float NOT NULL,
  `absen` int(11) NOT NULL,
  `potongan_absensi` float NOT NULL,
  `jatah_cuti_mandiri` int(25) NOT NULL,
  `jatah_cuti_bersama` int(25) NOT NULL,
  `potongan_bpjstk` float NOT NULL,
  `potongan_bpjskes` float NOT NULL,
  `potongan_dapen` float NOT NULL,
  `potongan_simpanan_wajib` float NOT NULL,
  `potongan_sekunder` float NOT NULL,
  `potongan_darurat` float NOT NULL,
  `potongan_toko` float NOT NULL,
  `potongan_lain` float NOT NULL,
  `thp` float NOT NULL,
  `pph21_bulan` float NOT NULL,
  `pph21_tahun` float NOT NULL,
  `upah` float NOT NULL,
  `fee_bulan` float NOT NULL,
  `rafel` float NOT NULL,
  `thr` float NOT NULL,
  `pph23` float NOT NULL,
  `jml_tagihan` float NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1156 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gaji_karyawan_backup`
--

CREATE TABLE IF NOT EXISTS `gaji_karyawan_backup` (
  `id_gaji_karyawan` int(11) NOT NULL,
  `gaji_id` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `nama_karyawan` varchar(150) NOT NULL,
  `nip` int(50) NOT NULL,
  `periode` varchar(50) NOT NULL,
  `jml_hari` int(11) NOT NULL,
  `tunj_jabatan` float NOT NULL,
  `tunj_bpjstk` float NOT NULL,
  `tunj_bpjskes` float NOT NULL,
  `tunj_dapen` float NOT NULL,
  `bpjstk_stat_tun` int(11) NOT NULL,
  `bpjskes_stat_tun` int(11) NOT NULL,
  `dapen_stat_tun` int(11) NOT NULL,
  `tunj_makan` float NOT NULL,
  `tunj_lain` float NOT NULL,
  `potongan_absensi` float NOT NULL,
  `jatah_cuti_mandiri` int(25) NOT NULL,
  `jatah_cuti_bersama` int(25) NOT NULL,
  `potongan_bpjstk` float NOT NULL,
  `potongan_bpjskes` float NOT NULL,
  `potongan_dapen` float NOT NULL,
  `potongan_simpanan_wajib` float NOT NULL,
  `potongan_sekunder` float NOT NULL,
  `potongan_darurat` float NOT NULL,
  `potongan_toko` float NOT NULL,
  `potongan_lain` float NOT NULL,
  `thp` float NOT NULL,
  `pph21_bulan` float NOT NULL,
  `pph21_tahun` float NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4851 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gaji_karyawan_backup`
--

INSERT INTO `gaji_karyawan_backup` (`id_gaji_karyawan`, `gaji_id`, `id_karyawan`, `nama_karyawan`, `nip`, `periode`, `jml_hari`, `tunj_jabatan`, `tunj_bpjstk`, `tunj_bpjskes`, `tunj_dapen`, `bpjstk_stat_tun`, `bpjskes_stat_tun`, `dapen_stat_tun`, `tunj_makan`, `tunj_lain`, `potongan_absensi`, `jatah_cuti_mandiri`, `jatah_cuti_bersama`, `potongan_bpjstk`, `potongan_bpjskes`, `potongan_dapen`, `potongan_simpanan_wajib`, `potongan_sekunder`, `potongan_darurat`, `potongan_toko`, `potongan_lain`, `thp`, `pph21_bulan`, `pph21_tahun`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(4804, 20, 1, 'A Dino Nuswantoro', 13890179, '2020-10-31', 21, 100000, 2261240, 1449510, 153648, 0, 0, 0, 0, 0, 0, 0, 0, 2261240, 1449510, 153648, 0, 0, 0, 0, 0, 3623780, 0, 0, '2020-10-13 07:50:33', 'admin', '2020-10-13 18:38:12', 'admin', 0),
(4805, 2, 2, 'A Yaurland Herdiana', 18059901, '2020-10-31', 21, 0, 149613, 233397, 158590, 0, 0, 0, 0, 0, 0, 0, 0, 149613, 233397, 158590, 0, 0, 0, 0, 0, 3740330, 0, 0, '2020-10-13 07:51:25', 'admin', '0000-00-00 00:00:00', '', 0),
(4806, 3, 3, 'Abdul Rohman', 20050623, '2020-10-31', 21, 0, 225049, 351076, 238552, 0, 0, 0, 0, 0, 0, 0, 0, 225049, 351076, 238552, 0, 0, 0, 0, 0, 5569910, 56311, 675732, '2020-10-13 07:51:42', 'admin', '0000-00-00 00:00:00', '', 0),
(4807, 4, 4, 'Abdul Ro''uf', 15090062, '2020-10-31', 21, 0, 208000, 324480, 220480, 0, 0, 0, 0, 0, 0, 0, 0, 208000, 324480, 220480, 0, 0, 0, 0, 0, 5165000, 35000, 420000, '2020-10-13 07:52:05', 'admin', '0000-00-00 00:00:00', '', 0),
(4808, 5, 1149, 'RIZKI AYU ADELIA', 111, '2020-10-31', 21, 0, 240000, 374400, 254400, 0, 0, 0, 0, 0, 0, 0, 0, 240000, 374400, 254400, 0, 0, 0, 0, 0, 5925000, 75000, 900000, '2020-10-13 07:52:19', 'admin', '0000-00-00 00:00:00', '', 0),
(4842, 6, 1149, 'RIZKI AYU ADELIA', 111, '2020-11-30', 21, 0, 240000, 374400, 254400, 0, 0, 0, 0, 0, 0, 0, 0, 240000, 374400, 254400, 0, 0, 0, 0, 0, 5925000, 75000, 900000, '2020-10-13 09:33:11', 'admin', '0000-00-00 00:00:00', '', 0),
(4843, 7, 4, 'Abdul Ro''uf', 15090062, '2020-11-30', 21, 0, 208000, 324480, 220480, 0, 0, 0, 0, 0, 0, 0, 0, 208000, 324480, 220480, 0, 0, 0, 0, 0, 5165000, 35000, 420000, '2020-10-13 09:33:11', 'admin', '0000-00-00 00:00:00', '', 0),
(4844, 8, 3, 'Abdul Rohman', 20050623, '2020-11-30', 21, 0, 225049, 351076, 238552, 0, 0, 0, 0, 0, 0, 0, 0, 225049, 351076, 238552, 0, 0, 0, 0, 0, 5569910, 56311, 675732, '2020-10-13 09:33:11', 'admin', '0000-00-00 00:00:00', '', 0),
(4848, 9, 1149, 'RIZKI AYU ADELIA', 111, '2020-12-31', 22, 0, 240000, 374400, 254400, 0, 0, 0, 0, 0, 0, 0, 0, 240000, 374400, 254400, 0, 0, 0, 0, 0, 5925000, 75000, 900000, '2020-10-13 09:35:17', 'admin', '0000-00-00 00:00:00', '', 0),
(4849, 10, 4, 'Abdul Ro''uf', 15090062, '2020-12-31', 22, 0, 208000, 324480, 220480, 0, 0, 0, 0, 0, 0, 0, 0, 208000, 324480, 220480, 0, 0, 0, 0, 0, 5165000, 35000, 420000, '2020-10-13 09:35:17', 'admin', '0000-00-00 00:00:00', '', 0),
(4850, 11, 3, 'Abdul Rohman', 20050623, '2020-12-31', 22, 0, 225049, 351076, 238552, 0, 0, 0, 0, 0, 0, 0, 0, 225049, 351076, 238552, 0, 0, 0, 0, 0, 5569910, 56311, 675732, '2020-10-13 09:35:17', 'admin', '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE IF NOT EXISTS `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `id_penempatan` int(11) NOT NULL,
  `nip` bigint(50) NOT NULL,
  `kode_pagu` varchar(50) NOT NULL,
  `nik` varchar(150) DEFAULT NULL,
  `no_npwp` bigint(50) NOT NULL,
  `nama_karyawan` varchar(150) NOT NULL,
  `tempat_lahir` varchar(150) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `foto` varchar(150) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(25) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `bank` varchar(25) NOT NULL,
  `no_rekening` varchar(50) NOT NULL,
  `status_pernikahan` varchar(25) NOT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `nama_kontrak` varchar(150) NOT NULL,
  `no_kontrak` varchar(100) NOT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `tgl_berakhir` date DEFAULT NULL,
  `divisi` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `gaji_pokok` float NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL,
  `updated_status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1149 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `keluarga`
--

CREATE TABLE IF NOT EXISTS `keluarga` (
  `id_keluarga` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `nik` int(50) NOT NULL,
  `nama_keluarga` varchar(150) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `pendidikan` varchar(150) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `hubungan` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `keluarga`
--

INSERT INTO `keluarga` (`id_keluarga`, `id_karyawan`, `nik`, `nama_keluarga`, `tempat_lahir`, `tgl_lahir`, `pendidikan`, `pekerjaan`, `hubungan`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(1, 1, 435435345, 'sdfsdf', 'Bandung', '2020-09-28', 'D3', 'dfsdf', 'Istri', '2020-10-13 13:51:36', 'admin', '0000-00-00 00:00:00', '', 0),
(2, 3, 546456, 'gfhfgh', 'fdgdfgdf', '2020-09-27', 'S1', 'dgfdg', 'Istri', '2020-10-13 13:56:00', 'admin', '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kontrak`
--

CREATE TABLE IF NOT EXISTS `kontrak` (
  `id_kontrak` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `no_kontrak` varchar(50) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(11) NOT NULL,
  `men_menu_id` int(11) DEFAULT NULL,
  `menu_name` varchar(50) NOT NULL,
  `menu_link` varchar(100) NOT NULL,
  `menu_status` tinyint(1) NOT NULL,
  `menu_ismaster` tinyint(1) NOT NULL,
  `menu_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `id_user` int(15) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `men_menu_id`, `menu_name`, `menu_link`, `menu_status`, `menu_ismaster`, `menu_order`, `created_at`, `id_user`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(1, NULL, 'Setting', '#', 1, 1, 0, '2017-01-30 23:02:05', NULL, 'admin', NULL, NULL, NULL),
(2, 1, 'User', 'user', 1, 1, 0, '2017-01-30 23:02:22', NULL, 'admin', '2020-08-28 13:09:33', 'admin', NULL),
(3, 1, 'Hak Akses', 'role', 1, 1, 0, '2017-01-30 23:02:42', NULL, 'admin', '2020-08-28 13:09:39', 'admin', NULL),
(4, 1, 'Menu', 'menu', 1, 1, 0, '2017-01-30 23:04:12', NULL, 'admin', '2020-08-28 13:09:44', 'admin', NULL),
(5, NULL, 'Dashboard', 'dashboard', 1, 0, 0, '2017-01-30 23:06:03', NULL, 'admin', '2020-08-28 13:14:45', 'admin', NULL),
(17, NULL, 'Logout', 'auth/logout', 1, 1, 0, '2018-12-23 19:41:00', NULL, 'admin', '2020-08-11 14:13:01', 'admin', NULL),
(103, 104, 'Rekap Penagihan', 'penagihan/rekap_penagihan', 1, 1, 0, '2020-08-26 15:28:54', NULL, 'admin', '2020-08-28 13:13:17', 'admin', NULL),
(102, NULL, 'Penagihan', 'penagihan', 1, 1, 0, '2020-08-21 17:01:18', NULL, 'admin', '2020-08-28 13:13:01', 'admin', NULL),
(100, NULL, 'PPH 21', 'gaji_karyawan/rekap_pajak', 1, 1, 0, '2020-08-17 13:36:17', NULL, 'admin', '2020-08-28 13:11:34', 'admin', NULL),
(99, NULL, 'Mutasi', 'mutasi', 1, 1, 0, '2020-08-15 07:02:47', NULL, 'admin', '2020-08-28 13:12:39', 'admin', NULL),
(98, NULL, 'Kontrak', 'kontrak', 1, 1, 0, '2020-08-14 15:52:02', NULL, 'admin', '2020-08-28 13:12:27', 'admin', NULL),
(97, 104, 'Rekap Gaji Karyawan', 'gaji_karyawan/rekap_gaji', 1, 1, 0, '2020-08-13 15:20:33', NULL, 'admin', '2020-08-28 13:12:15', 'admin', NULL),
(96, NULL, 'Penempatan', 'penempatan', 1, 1, 0, '2020-08-13 10:03:44', NULL, 'admin', '2020-09-09 14:16:58', 'admin', NULL),
(94, NULL, 'Pinjaman', 'pinjaman', 1, 1, 0, '2020-08-12 15:42:20', NULL, 'admin', '2020-08-28 13:11:57', 'admin', NULL),
(92, 88, 'Pendidikan', 'sekolah', 1, 1, 0, '2020-08-12 11:16:23', NULL, 'admin', '2020-08-28 13:10:29', 'admin', NULL),
(91, 88, 'Suami Istri', 'keluarga', 1, 1, 0, '2020-08-12 11:16:04', NULL, 'admin', '2020-08-28 13:10:20', 'admin', NULL),
(90, 88, 'Anak', 'anak', 1, 1, 0, '2020-08-12 11:14:34', NULL, 'admin', '2020-08-28 13:10:10', 'admin', NULL),
(88, NULL, 'Data Referensi', '#', 1, 1, 0, '2020-08-12 11:13:07', NULL, 'admin', '2020-08-13 12:54:13', 'admin', NULL),
(89, 88, 'Orang Tua', 'ortu', 1, 1, 0, '2020-08-12 11:13:40', NULL, 'admin', '2020-08-28 13:10:03', 'admin', NULL),
(104, NULL, 'Rekap', '#', 1, 1, 0, '2020-08-27 08:53:39', NULL, 'admin', NULL, NULL, NULL),
(95, NULL, 'Gaji Karyawan', 'gaji_karyawan', 1, 1, 0, '2020-08-13 01:59:07', NULL, 'admin', '2020-08-28 13:12:06', 'admin', NULL),
(93, NULL, 'Divisi', 'divisi', 1, 1, 0, '2020-08-12 13:20:41', NULL, 'admin', '2020-08-28 13:10:44', 'admin', NULL),
(87, NULL, 'Data Karyawan', 'karyawan', 1, 1, 0, '2020-08-11 14:14:53', NULL, 'admin', '2020-08-28 13:09:52', 'admin', NULL),
(106, 104, 'Rekap Pinjaman', 'pinjaman/rekap_pinjaman', 1, 1, 0, '2020-10-16 07:35:08', NULL, 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_role`
--

CREATE TABLE IF NOT EXISTS `menu_role` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `CREATED_ON` datetime DEFAULT NULL,
  `id_user` int(15) DEFAULT NULL,
  `CREATED_BY` int(11) DEFAULT NULL,
  `UPDATED_ON` datetime DEFAULT NULL,
  `IS_DELETED` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_role`
--

INSERT INTO `menu_role` (`role_id`, `menu_id`, `CREATED_ON`, `id_user`, `CREATED_BY`, `UPDATED_ON`, `IS_DELETED`) VALUES
(1, 97, NULL, NULL, NULL, NULL, NULL),
(1, 103, NULL, NULL, NULL, NULL, NULL),
(1, 89, NULL, NULL, NULL, NULL, NULL),
(1, 90, NULL, NULL, NULL, NULL, NULL),
(1, 91, NULL, NULL, NULL, NULL, NULL),
(1, 92, NULL, NULL, NULL, NULL, NULL),
(1, 4, NULL, NULL, NULL, NULL, NULL),
(1, 3, NULL, NULL, NULL, NULL, NULL),
(1, 2, NULL, NULL, NULL, NULL, NULL),
(1, 87, NULL, NULL, NULL, NULL, NULL),
(1, 93, NULL, NULL, NULL, NULL, NULL),
(1, 95, NULL, NULL, NULL, NULL, NULL),
(1, 104, NULL, NULL, NULL, NULL, NULL),
(1, 88, NULL, NULL, NULL, NULL, NULL),
(1, 94, NULL, NULL, NULL, NULL, NULL),
(1, 96, NULL, NULL, NULL, NULL, NULL),
(1, 98, NULL, NULL, NULL, NULL, NULL),
(1, 99, NULL, NULL, NULL, NULL, NULL),
(1, 100, NULL, NULL, NULL, NULL, NULL),
(1, 102, NULL, NULL, NULL, NULL, NULL),
(1, 17, NULL, NULL, NULL, NULL, NULL),
(1, 5, NULL, NULL, NULL, NULL, NULL),
(1, 1, NULL, NULL, NULL, NULL, NULL),
(1, 106, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mutasi`
--

CREATE TABLE IF NOT EXISTS `mutasi` (
  `id_mutasi` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_penempatan` int(11) NOT NULL,
  `penempatan_awal` varchar(50) NOT NULL,
  `no_kontrak` varchar(50) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_berakhir` date NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ortu`
--

CREATE TABLE IF NOT EXISTS `ortu` (
  `id_ortu` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `nik` int(50) NOT NULL,
  `nama_ortu` varchar(150) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `pendidikan` varchar(150) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `hubungan` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ortu`
--

INSERT INTO `ortu` (`id_ortu`, `id_karyawan`, `nik`, `nama_ortu`, `tempat_lahir`, `tgl_lahir`, `pendidikan`, `pekerjaan`, `hubungan`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(1, 2, 345345435, 'fgfh', 'fdhdfh', '2020-09-27', 'SMA', 'gfhfgh', 'Ayah', '2020-10-13 15:20:55', 'admin', '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE IF NOT EXISTS `pekerjaan` (
  `id_pekerjaan` int(11) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `gaji_pokok` int(50) NOT NULL,
  `tunj_jabatan` int(50) NOT NULL,
  `tunj_bpjstk` int(50) NOT NULL,
  `tunj_bpjskes` int(50) NOT NULL,
  `tunj_dapen` int(50) NOT NULL,
  `tunj_lain` int(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penagihan`
--

CREATE TABLE IF NOT EXISTS `penagihan` (
  `id_penagihan` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_penempatan` int(11) NOT NULL,
  `gaji_id` int(11) NOT NULL,
  `nama_karyawan` varchar(150) NOT NULL,
  `nip` int(50) NOT NULL,
  `periode` date NOT NULL,
  `upah` int(25) NOT NULL,
  `fee_bulan` int(25) NOT NULL,
  `rafel` int(25) NOT NULL,
  `thr` int(25) NOT NULL,
  `pph23` int(25) NOT NULL,
  `jml_tagihan` int(25) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penagihan_backup`
--

CREATE TABLE IF NOT EXISTS `penagihan_backup` (
  `id_penagihan` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_penempatan` int(11) NOT NULL,
  `gaji_id` int(11) NOT NULL,
  `nama_karyawan` varchar(150) NOT NULL,
  `nip` int(50) NOT NULL,
  `periode` date NOT NULL,
  `upah` int(25) NOT NULL,
  `fee_bulan` int(25) NOT NULL,
  `rafel` int(25) NOT NULL,
  `thr` int(25) NOT NULL,
  `pph23` int(25) NOT NULL,
  `jml_tagihan` int(25) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4854 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penagihan_backup`
--

INSERT INTO `penagihan_backup` (`id_penagihan`, `id_karyawan`, `id_penempatan`, `gaji_id`, `nama_karyawan`, `nip`, `periode`, `upah`, `fee_bulan`, `rafel`, `thr`, `pph23`, `jml_tagihan`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(4804, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 07:50:33', 'admin', '2020-10-13 18:31:34', 'admin', 0),
(4805, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 07:51:25', 'admin', '2020-10-13 18:31:34', 'admin', 0),
(4806, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 07:51:42', 'admin', '2020-10-13 18:31:34', 'admin', 0),
(4807, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 07:52:05', 'admin', '2020-10-13 18:31:34', 'admin', 0),
(4808, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 07:52:19', 'admin', '2020-10-13 18:31:34', 'admin', 0),
(4842, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 09:33:11', 'admin', '2020-10-13 18:31:34', 'admin', 0),
(4843, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 09:33:11', 'admin', '2020-10-13 18:31:34', 'admin', 0),
(4844, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 09:33:11', 'admin', '2020-10-13 18:31:34', 'admin', 0),
(4851, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 09:35:17', 'admin', '2020-10-13 18:31:34', 'admin', 0),
(4852, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 09:35:17', 'admin', '2020-10-13 18:31:34', 'admin', 0),
(4853, 1, 5, 18, 'A Dino Nuswantoro', 13890179, '2020-10-31', 3623780, 733453, 0, 0, 14669, 8082653, '2020-10-13 09:35:17', 'admin', '2020-10-13 18:31:34', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `penempatan`
--

CREATE TABLE IF NOT EXISTS `penempatan` (
  `id_penempatan` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `fee` float NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penempatan`
--

INSERT INTO `penempatan` (`id_penempatan`, `nama_perusahaan`, `alamat`, `fee`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(2, 'PT Len IOTI Fintech', 'Bandung', 0.1, '2020-08-13 11:33:56', 'admin', '2020-08-28 09:53:13', 'admin', 0),
(3, 'PT Puri Makmur Lestari', 'Jl. Ters. Buah Batu Bandung', 0.1, '2020-08-21 14:57:55', 'admin', '2020-08-28 09:52:57', 'admin', 0),
(4, 'LEN INDUSTRI', 'Jl. Mohamad Toha', 0.1, '2020-08-28 09:50:42', 'admin', '0000-00-00 00:00:00', '', 0),
(5, 'Len Railways System', 'Jl. Mohamad Toha', 0.1, '2020-08-28 09:51:20', 'admin', '0000-00-00 00:00:00', '', 0),
(6, 'Len Rekaprima Semesta', 'Jl. Mohamad Toha', 0.1, '2020-08-28 09:51:44', 'admin', '0000-00-00 00:00:00', '', 0),
(7, 'Len Telekomunikasi Indonesia', 'Jl. Mohamad Toha', 0.1, '2020-08-28 09:52:06', 'admin', '0000-00-00 00:00:00', '', 0),
(8, 'Surya Energy Indonesia', 'Jl. Mohamad Toha', 0.1, '2020-08-28 09:52:38', 'admin', '0000-00-00 00:00:00', '', 0),
(9, 'PT Eltran', 'Bandung', 0.1, '2020-09-16 07:59:17', 'admin', '0000-00-00 00:00:00', '', 0),
(10, 'Koperasi Karyawan Len', 'Bandung', 0.1, '2020-09-16 07:59:33', 'admin', '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE IF NOT EXISTS `pinjaman` (
  `id_pinjaman` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `nama_karyawan` varchar(150) NOT NULL,
  `nama_pinjaman` varchar(255) NOT NULL,
  `jumlah_pinjaman` float NOT NULL,
  `tgl_pinjaman` date NOT NULL,
  `sisa` float NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `potongan`
--

CREATE TABLE IF NOT EXISTS `potongan` (
  `id_potongan` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `potongan_absensi` int(25) NOT NULL,
  `cuti_mandiri` int(25) NOT NULL,
  `cuti_bersama` int(25) NOT NULL,
  `potongan_bpjstk` int(25) NOT NULL,
  `potongan_bpjskes` int(25) NOT NULL,
  `potongan_dapen` int(25) NOT NULL,
  `potongan_lain` int(25) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_status` tinyint(1) NOT NULL,
  `role_canlogin` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `id_user` int(15) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_status`, `role_canlogin`, `created_at`, `id_user`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(1, 'Administrator', 1, 1, '0000-00-00 00:00:00', NULL, '', '2020-10-16 07:35:25', 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

CREATE TABLE IF NOT EXISTS `sekolah` (
  `id_sekolah` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL,
  `lokasi` text NOT NULL,
  `grade` varchar(50) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `tgl_ijazah` date NOT NULL,
  `no_ijazah` varchar(50) NOT NULL,
  `nama_kepsek` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `is_deleted` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sekolah`
--

INSERT INTO `sekolah` (`id_sekolah`, `id_karyawan`, `nama_sekolah`, `lokasi`, `grade`, `jurusan`, `tgl_ijazah`, `no_ijazah`, `nama_kepsek`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(1, 1, 'dsfds', 'dsfsdf', 'D3', 'dgsdgd', '2020-10-01', 'sdsdfsd', 'sdfsdf', '2020-10-13 15:24:51', 'admin', '2020-10-13 15:25:00', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(10) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `role_id`, `username`, `password`, `full_name`, `gambar`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'profil1.jpg', '0000-00-00 00:00:00', NULL, '2020-06-17 03:35:45', 'admin', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anak`
--
ALTER TABLE `anak`
  ADD PRIMARY KEY (`id_anak`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_cuti`);

--
-- Indexes for table `detail_pinjam`
--
ALTER TABLE `detail_pinjam`
  ADD PRIMARY KEY (`id_detail_pinjam`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `gaji_karyawan`
--
ALTER TABLE `gaji_karyawan`
  ADD PRIMARY KEY (`id_gaji_karyawan`);

--
-- Indexes for table `gaji_karyawan_backup`
--
ALTER TABLE `gaji_karyawan_backup`
  ADD PRIMARY KEY (`id_gaji_karyawan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD PRIMARY KEY (`id_keluarga`);

--
-- Indexes for table `kontrak`
--
ALTER TABLE `kontrak`
  ADD PRIMARY KEY (`id_kontrak`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`), ADD KEY `fk_parent_id` (`men_menu_id`);

--
-- Indexes for table `menu_role`
--
ALTER TABLE `menu_role`
  ADD PRIMARY KEY (`role_id`,`menu_id`), ADD KEY `fk_menu_role2` (`menu_id`);

--
-- Indexes for table `mutasi`
--
ALTER TABLE `mutasi`
  ADD PRIMARY KEY (`id_mutasi`);

--
-- Indexes for table `ortu`
--
ALTER TABLE `ortu`
  ADD PRIMARY KEY (`id_ortu`);

--
-- Indexes for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`);

--
-- Indexes for table `penagihan`
--
ALTER TABLE `penagihan`
  ADD PRIMARY KEY (`id_penagihan`), ADD KEY `id_penagihan` (`id_penagihan`);

--
-- Indexes for table `penagihan_backup`
--
ALTER TABLE `penagihan_backup`
  ADD PRIMARY KEY (`id_penagihan`), ADD KEY `id_penagihan` (`id_penagihan`);

--
-- Indexes for table `penempatan`
--
ALTER TABLE `penempatan`
  ADD PRIMARY KEY (`id_penempatan`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id_pinjaman`);

--
-- Indexes for table `potongan`
--
ALTER TABLE `potongan`
  ADD PRIMARY KEY (`id_potongan`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id_sekolah`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`), ADD KEY `fk_user_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anak`
--
ALTER TABLE `anak`
  MODIFY `id_anak` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id_cuti` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `detail_pinjam`
--
ALTER TABLE `detail_pinjam`
  MODIFY `id_detail_pinjam` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gaji_karyawan`
--
ALTER TABLE `gaji_karyawan`
  MODIFY `id_gaji_karyawan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1156;
--
-- AUTO_INCREMENT for table `gaji_karyawan_backup`
--
ALTER TABLE `gaji_karyawan_backup`
  MODIFY `id_gaji_karyawan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4851;
--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1149;
--
-- AUTO_INCREMENT for table `keluarga`
--
ALTER TABLE `keluarga`
  MODIFY `id_keluarga` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `kontrak`
--
ALTER TABLE `kontrak`
  MODIFY `id_kontrak` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=107;
--
-- AUTO_INCREMENT for table `mutasi`
--
ALTER TABLE `mutasi`
  MODIFY `id_mutasi` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ortu`
--
ALTER TABLE `ortu`
  MODIFY `id_ortu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id_pekerjaan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `penagihan`
--
ALTER TABLE `penagihan`
  MODIFY `id_penagihan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `penagihan_backup`
--
ALTER TABLE `penagihan_backup`
  MODIFY `id_penagihan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4854;
--
-- AUTO_INCREMENT for table `penempatan`
--
ALTER TABLE `penempatan`
  MODIFY `id_penempatan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id_pinjaman` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `potongan`
--
ALTER TABLE `potongan`
  MODIFY `id_potongan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id_sekolah` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
